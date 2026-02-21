<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use App\Models\Transaction;
use App\Models\Gateway;
use Illuminate\Http\Request;

class HomeController extends Controller {
    public function index() {
        $stats = [
            'total_withdrawn'   => Withdrawal::where( 'status', 'success' )->sum( 'amount' ),
            'pending_withdraw'  => Withdrawal::where( 'status', 'pending' )->sum( 'amount' ),
            'total_transactions'=> Transaction::count(),
            'gateway'           => Gateway::first(),
            'recent_withdrawals'=> Withdrawal::latest()->take( 5 )->get(),
            'recent_trx'        => Transaction::latest()->take( 5 )->get(),
        ];

        return view( 'dashboard', compact( 'stats' ) );
    }
}