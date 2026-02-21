<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class TransactionController extends Controller {

    public function index() {
        try {
            $transactions = Transaction::latest()->paginate( 15 );
            return view( 'transactions.index', compact( 'transactions' ) );
        } catch ( Exception $e ) {
            Log::error( 'Transaction Index Error: ' . $e->getMessage() );
            return redirect()->back()->with( 'error', 'লেনদেনের তালিকা লোড করতে সমস্যা হয়েছে।' );
        }
    }

    public function destroy( $id ) {
        try {
            $transaction = Transaction::findOrFail( $id );
            $transaction->delete();

            return redirect()->back()->with( 'success', 'লেনদেনের রেকর্ডটি সফলভাবে মুছে ফেলা হয়েছে!' );
        } catch ( Exception $e ) {
            Log::error( 'Transaction Delete Error: ' . $e->getMessage(), [ 'trx_id' => $id ] );
            return redirect()->back()->with( 'error', 'রেকর্ডটি মুছতে গিয়ে একটি ত্রুটি ঘটেছে।' );
        }
    }
}