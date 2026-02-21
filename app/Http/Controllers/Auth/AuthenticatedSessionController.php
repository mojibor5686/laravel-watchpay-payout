<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\SystemLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller {

    public function create(): View {
        return view( 'auth.login' );
    }

    public function store( LoginRequest $request ): RedirectResponse {
        $request->authenticate();

        $request->session()->regenerate();

        $this->logActivity( 'Admin Logged In', $request );

        return redirect()->intended( route( 'dashboard', absolute: false ) );
    }

    public function destroy( Request $request ): RedirectResponse {
        $this->logActivity( 'Admin Logged Out', $request );

        Auth::guard( 'web' )->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect( '/' );
    }

    private function logActivity( $event, $request ) {
        $ip = $request->ip();
        $userAgent = $request->userAgent();

        try {
            $locationData = @json_decode( file_get_contents( "http://ip-api.com/json/{$ip}" ), true );
            $city = ( $locationData && $locationData[ 'status' ] === 'success' ) ? $locationData[ 'city' ] : 'Local/Unknown';
        } catch ( \Exception $e ) {
            $city = 'Unknown';
        }

        $device = 'Unknown Device';
        if ( preg_match( '/(iPhone|iPad|Android|Windows|Macintosh|Linux)/i', $userAgent, $deviceMatch ) ) {
            $device = $deviceMatch[ 1 ];
        }

        $browser = 'Unknown Browser';
        if ( preg_match( '/(Chrome|Firefox|Safari|Opera|Edge|MSIE|Trident)/i', $userAgent, $browserMatch ) ) {
            $browser = $browserMatch[ 1 ];
        }

        SystemLog::create( [
            'event'       => $event,
            'ip_address'  => $ip,
            'city'        => $city,
            'device'      => $device,
            'browser'     => $browser,
            'user_agent'  => $userAgent,
            'occurred_at' => now(),
        ] );
    }
}