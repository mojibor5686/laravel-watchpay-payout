<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Services\WatchPayService;
use Exception;
use Illuminate\Support\Str;

class WithdrawalController extends Controller {

    private $watchPay;

    public function __construct( WatchPayService $watchPay ) {
        $this->watchPay = $watchPay;
    }

    public function index() {
        try {
            $withdrawals = Withdrawal::latest()->paginate( 15 );
            $totalWithdrawn = Withdrawal::where( 'status', 'success' )->sum( 'amount' );
            return view( 'withdrawals.index', compact( 'withdrawals', 'totalWithdrawn' ) );
        } catch ( Exception $e ) {
            Log::error( 'Withdrawal Index Error: ' . $e->getMessage() );
            return redirect()->back()->with( 'error', 'উইথড্রয়াল তালিকা লোড করতে সমস্যা হয়েছে।' );
        }
    }

    public function pending() {
        try {
            $withdrawals = Withdrawal::where( 'status', 'pending' )->latest()->paginate( 15 );
            return view( 'withdrawals.pending', compact( 'withdrawals' ) );
        } catch ( Exception $e ) {
            Log::error( 'Pending Withdrawal Error: ' . $e->getMessage() );
            return redirect()->back()->with( 'error', 'পেন্ডিং তালিকা লোড করা যায়নি।' );
        }
    }

    public function approved() {
        try {
            $withdrawals = Withdrawal::where( 'status', 'approved' )->latest()->paginate( 15 );
            return view( 'withdrawals.approved', compact( 'withdrawals' ) );
        } catch ( Exception $e ) {
            Log::error( 'Approved Withdrawal Error: ' . $e->getMessage() );
            return redirect()->back()->with( 'error', 'অ্যাপ্রুভড তালিকা লোড করা যায়নি।' );
        }
    }

    public function rejected() {
        try {
            $withdrawals = Withdrawal::where( 'status', 'rejected' )->latest()->paginate( 15 );
            return view( 'withdrawals.rejected', compact( 'withdrawals' ) );
        } catch ( Exception $e ) {
            Log::error( 'Rejected Withdrawal Error: ' . $e->getMessage() );
            return redirect()->back()->with( 'error', 'অ্যাপ্রুভড তালিকা লোড করা যায়নি।' );
        }
    }

    public function create() {
        return view( 'withdrawals.create' );
    }

    public function store( Request $request ) {
        $request->validate( [
            'method'    => 'required|string',
            'number'    => 'required|string',
            'amount'    => 'required|numeric|min:10',
            'user_name' => 'required|string'
        ], [
            'method.required'    => 'পেমেন্ট মেথড নির্বাচন করুন।',
            'number.required'    => 'হিসাব নম্বর প্রদান করুন।',
            'amount.min'         => 'সর্বনিম্ন ১০ টাকা উইথড্র করা যাবে।',
            'user_name.required' => 'ব্যবহারকারীর নাম আবশ্যক।'
        ] );

        $trx_id = 'WD-' . strtoupper( Str::random( 10 ) );

        DB::beginTransaction();
        try {
            $withdrawal = Withdrawal::create( [
                'method'    => $request->method,
                'number'    => $request->number,
                'amount'    => $request->amount,
                'user_name' => $request->user_name,
                'trx'       => $trx_id,
                'status'    => 'pending'
            ] );

            Transaction::create( [
                'withdrawal_id' => $withdrawal->id,
                'user_name'     => $withdrawal->user_name,
                'amount'        => $withdrawal->amount,
                'method_name'   => $withdrawal->method,
                'status'        => 'pending'
            ] );

            DB::commit();

            return $this->initiateWithdraw( $withdrawal->id );

        } catch ( Exception $e ) {
            DB::rollBack();
            Log::error( 'Withdrawal Store Failed: ' . $e->getMessage() );
            return redirect()->back()->with( 'error', 'রিকোয়েস্ট জমা দিতে সমস্যা হয়েছে। পুনরায় চেষ্টা করুন।' );
        }
    }

    public function updateStatus( Request $request, $id ) {
        $request->validate( [ 'status' => 'required|in:success,rejected,pending' ] );

        DB::beginTransaction();
        try {
            $withdrawal = Withdrawal::findOrFail( $id );
            $withdrawal->update( [ 'status' => $request->status ] );

            $transaction = Transaction::where( 'withdrawal_id', $withdrawal->id )->first();
            if ( $transaction ) {
                $transaction->update( [ 'status' => $request->status ] );
            }

            DB::commit();
            $msg = $request->status == 'success' ? 'অনুমোদন সফল হয়েছে।' : 'অনুরোধটি ' . ( $request->status == 'rejected' ? 'বাতিল' : 'পেন্ডিং' ) . ' করা হয়েছে।';
            return redirect()->back()->with( 'success', $msg );
        } catch ( Exception $e ) {
            DB::rollBack();
            Log::error( 'Status Update Failed: ' . $e->getMessage(), [ 'id' => $id ] );
            return redirect()->back()->with( 'error', 'স্ট্যাটাস আপডেট করতে সমস্যা হয়েছে।' );
        }
    }

    public function destroy( $id ) {
        DB::beginTransaction();
        try {
            $withdrawal = Withdrawal::findOrFail( $id );

            if ( $withdrawal->status == 'pending' ) {
                Transaction::where( 'withdrawal_id', $withdrawal->id )->delete();
                $withdrawal->delete();
                DB::commit();
                return redirect()->back()->with( 'success', 'রিকোয়েস্ট এবং ট্রানজ্যাকশন মুছে ফেলা হয়েছে।' );
            }

            return redirect()->back()->with( 'error', 'শুধুমাত্র পেন্ডিং রিকোয়েস্ট ডিলিট করা সম্ভব।' );
        } catch ( Exception $e ) {
            DB::rollBack();
            Log::error( 'Withdrawal Delete Failed: ' . $e->getMessage(), [ 'id' => $id ] );
            return redirect()->back()->with( 'error', 'মুছে ফেলতে ব্যর্থ হয়েছে।' );
        }
    }

    public function initiateWithdraw( $id ) {
        try {
            $withdraw = Withdrawal::findOrFail( $id );

            if ( $withdraw->status !== 'pending' ) {
                return back()->with( 'error', 'শুধুমাত্র পেন্ডিং রিকোয়েস্ট পাঠানো সম্ভব।' );
            }

            $bank_codes = [
                'bkash' => 'BDT25000f012',
                'nagad' => 'BDT25000f999'
            ];

            $bank_code = $bank_codes[ Str::lower( $withdraw->method ) ] ?? 'BDT25000f012';

            $transfer_id = 'WD-' . strtoupper( Str::random( 12 ) );
            $withdraw->update( [ 'trx_id' => $transfer_id ] );

            $data = [
                'mch_transferId'  => $transfer_id,
                'transfer_amount' => $withdraw->amount,
                'apply_date'      => now()->format( 'Y-m-d H:i:s' ),
                'bank_code'       => $bank_code,
                'receive_name'    => $withdraw->user_name,
                'receive_account' => $withdraw->number,
                'remark'          => 'WithdrawID'.$withdraw->id,
                'receiver_telephone' => $withdraw->number,
            ];

            $response = $this->watchPay->withdraw( $data );

            $json = json_decode( $response, true );

            if ( isset( $json[ 'respCode' ] ) && $json[ 'respCode' ] === 'SUCCESS' ) {
                return redirect()->back()->with( 'success', 'উইথড্রয়াল প্রসেস শুরু হয়েছে। ট্রেড নম্বর: ' . ( $json[ 'tradeNo' ] ?? 'N/A' ) );
            }

            Log::error( 'WatchPay API Error:', ( array )$json );
            return back()->with( 'error', $json[ 'errorMsg' ] ?? 'এপিআই থেকে কোনো রেসপন্স পাওয়া যায়নি।' );

        } catch ( Exception $e ) {
            Log::error( 'Initiate Withdraw Error: ' . $e->getMessage() );
            return back()->with( 'error', 'উইথড্রয়াল শুরু করতে ব্যর্থ হয়েছে।' );
        }
    }

    public function withdraw_notify( Request $request ) {
        Log::info( 'WatchPay Webhook Received:', $request->all() );

        if ( !$this->watchPay->validateWithdrawSign( $request->all() ) ) {
            Log::error( 'Withdraw Webhook Signature Invalid!' );
            return response( 'Invalid Signature', 400 );
        }

        $orderNo = $request->merTransferId;
        $tradeResult = $request->tradeResult;

        $withdraw = Withdrawal::where( 'trx_id', $orderNo )->first();

        if ( !$withdraw ) {
            return response( 'Order Not Found', 404 );
        }

        DB::beginTransaction();

        try {
            $status = ( $tradeResult == '1' ) ? 'approved' : 'rejected';

            $withdraw->update( [ 'status' => $status ] );

            Transaction::where( 'withdrawal_id', $withdraw->id )->update( [ 'status' => $status ] );

            DB::commit();

            return response( 'success' );

        } catch ( Exception $e ) {
            DB::rollback();
            Log::error( 'Webhook DB Update Failed: ' . $e->getMessage() );
            return response( 'Internal Error', 500 );
        }
    }
}