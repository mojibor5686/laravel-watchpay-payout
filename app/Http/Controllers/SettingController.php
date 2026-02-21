<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Exception;

class SettingController extends Controller {

    public function index() {
        try {
            $user = User::first();
            return view( 'setting.index', compact( 'user' ) );
        } catch ( Exception $e ) {
            Log::error( 'Settings Index Error: ' . $e->getMessage() );
            return redirect()->back()->with( 'error', 'সেটিংস লোড করতে সমস্যা হচ্ছে। আবার চেষ্টা করুন।' );
        }
    }

    public function store( Request $request ) {
        $user = User::find( 1 );

        $request->validate( [
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email,' . ( $user->id ?? 0 ),
            'old_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:4|confirmed',
        ], [
            'name.required'         => 'নাম দেওয়া আবশ্যক।',
            'email.required'        => 'ইমেইল দেওয়া আবশ্যক।',
            'email.unique'          => 'এই ইমেইলটি ইতিপূর্বে ব্যবহার করা হয়েছে।',
            'old_password.required_with' => 'পাসওয়ার্ড পরিবর্তন করতে বর্তমান পাসওয়ার্ডটি দিন।',
            'new_password.min'      => 'নতুন পাসওয়ার্ড কমপক্ষে ৪ অক্ষরের হতে হবে।',
            'new_password.confirmed' => 'নিশ্চিতকরণ পাসওয়ার্ডটি মিলেনি।',
        ] );

        try {
            $data = [
                'name'  => $request->name,
                'email' => $request->email,
            ];

            if ( $request->filled( 'new_password' ) ) {
                if ( !Hash::check( $request->old_password, $user->password ) ) {
                    return redirect()->back()->with( 'error', 'বর্তমান পাসওয়ার্ডটি সঠিক নয়!' );
                }
                $data[ 'password' ] = Hash::make( $request->new_password );
            }

            User::updateOrCreate( [ 'id' => 1 ], $data );

            return redirect()->back()->with( 'success', 'প্রোফাইল এবং সিকিউরিটি আপডেট সফল হয়েছে!' );

        } catch ( Exception $e ) {
            Log::error( 'Settings Update Failed: ' . $e->getMessage(), [
                'user_id' => 1,
                'email'   => $request->email,
                'trace'   => $e->getTraceAsString()
            ] );

            return redirect()->back()->with( 'error', 'দুঃখিত, কোনো একটি সমস্যা হয়েছে। ত্রুটিটি সিস্টেমে জমা করা হয়েছে।' );
        }
    }
}