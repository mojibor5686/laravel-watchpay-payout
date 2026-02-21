<?php

namespace App\Http\Controllers;

use App\Models\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class SystemController extends Controller {

    public function systemLogs() {
        $logPath = storage_path( 'logs/laravel.log' );
        $logs = [];

        if ( file_exists( $logPath ) ) {
            $fileContent = file_get_contents( $logPath );
            preg_match_all( '/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\].*/', $fileContent, $matches );
            $logs = array_reverse( $matches[ 0 ] );
        }

        return view( 'system.logs', compact( 'logs' ) );
    }

    public function health() {
        return view( 'system.health' );
    }

    public function loginHistory() {

        $logs = SystemLog::latest()->paginate( 20 );

        return view( 'system.login', compact( 'logs' ) );
    }

    public function clearCache() {
        Artisan::call( 'cache:clear' );
        Artisan::call( 'config:clear' );
        Artisan::call( 'view:clear' );
        return back()->with( 'success', 'সিস্টেম ক্যাশ সফলভাবে পরিষ্কার করা হয়েছে!' );
    }

    public function clearRoute() {
        Artisan::call( 'route:clear' );
        return back()->with( 'success', 'রুট ক্যাশ রিফ্রেশ করা হয়েছে!' );
    }

    public function clearLogs() {
        $logFile = storage_path( 'logs/laravel.log' );
        if ( File::exists( $logFile ) ) {
            File::put( $logFile, '' );
            return back()->with( 'success', 'সিস্টেম লগ ফাইল ক্লিন করা হয়েছে!' );
        }
        return back()->with( 'error', 'কোনো লগ ফাইল পাওয়া যায়নি।' );
    }

    public function storageLink() {
        try {
            Artisan::call( 'storage:link' );
            return back()->with( 'success', 'স্টোরেজ লিঙ্ক সফলভাবে তৈরি করা হয়েছে!' );
        } catch ( \Exception $e ) {
            return back()->with( 'error', 'লিঙ্ক তৈরিতে সমস্যা হয়েছে। হয়তো এটি আগেই তৈরি করা।' );
        }
    }
}
