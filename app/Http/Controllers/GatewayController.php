<?php

namespace App\Http\Controllers;

use App\Models\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class GatewayController extends Controller {

    public function index() {
        try {
            $gateways = Gateway::all();
            return view( 'gateways.index', compact( 'gateways' ) );
        } catch ( Exception $e ) {
            Log::error( 'Gateway Index Error: ' . $e->getMessage() );
            return redirect()->back()->with( 'error', 'গেটওয়ে সেটিংস লোড করতে সমস্যা হয়েছে।' );
        }
    }

    public function store( Request $request ) {
        $request->validate( [
            'merchant_key' => 'required',
            'merchant_id'  => 'required',
            'back_url'     => 'required|url',
            'status'       => 'required|in:active,inactive'
        ], [
            'merchant_key.required' => 'মার্চেন্ট কি (Merchant Key) দেওয়া আবশ্যক।',
            'merchant_id.required'  => 'মার্চেন্ট আইডি (Merchant ID) দেওয়া আবশ্যক।',
            'back_url.required'     => 'নোটিফিকেশন ইউআরএল (Back URL) দেওয়া আবশ্যক।',
            'back_url.url'          => 'অনুগ্রহ করে একটি সঠিক ইউআরএল (যেমন: https://example.com) প্রদান করুন।',
            'status.required'       => 'গেটওয়ে স্ট্যাটাস নির্বাচন করুন।',
        ] );

        try {
            Gateway::updateOrCreate(
                [ 'id' => 1 ],
                $request->only( [ 'merchant_key', 'merchant_id', 'back_url', 'status' ] )
            );

            return redirect()->back()->with( 'success', 'গেটওয়ে সেটিংস সফলভাবে আপডেট করা হয়েছে!' );
        } catch ( Exception $e ) {
            Log::error( 'Gateway Update Failed: ' . $e->getMessage(), [
                'inputs' => $request->except( [ 'merchant_key' ] )
            ] );

            return redirect()->back()->with( 'error', 'দুঃখিত, সেটিংস সেভ করার সময় একটি ত্রুটি ঘটেছে।' );
        }
    }
}