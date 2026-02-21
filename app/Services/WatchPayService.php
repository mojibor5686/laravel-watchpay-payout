<?php

namespace App\Services;

use App\Models\Gateway;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class WatchPayService {
    private $merchantKey;
    private $mchId;
    private $backUrl;
    private $withdrawUrl;
    private $queryTransferUrl;
    private $isActive;

    public function __construct() {
        $gateway = Gateway::first();

        if ( !$gateway ) {
            Log::error( 'Gateway settings not found in database!' );
            $this->isActive = false;
            return;
        }

        $this->merchantKey = $gateway->merchant_key;
        $this->mchId       = $gateway->merchant_id;
        $this->backUrl     = $gateway->back_url;
        $this->isActive    = ( $gateway->status === 'active' );

        $this->withdrawUrl      = config( 'watchpay.api_withdraw_url' );
        $this->queryTransferUrl = config( 'watchpay.api_transfer_url' );
    }

    public function withdraw( array $data ) {
        if ( !$this->isActive ) {
            return json_encode( [
                'success' => false,
                'message' => 'পেমেন্ট গেটওয়ে বর্তমানে বন্ধ আছে। অনুগ্রহ করে অ্যাডমিনের সাথে যোগাযোগ করুন।'
            ] );
        }

        try {
            $postData = array_filter( [
                'mch_id' => $this->mchId,
                'mch_transferId' => $data[ 'mch_transferId' ],
                'transfer_amount' => $data[ 'transfer_amount' ],
                'apply_date' => $data[ 'apply_date' ],
                'bank_code' => $data[ 'bank_code' ],
                'receive_name' => $data[ 'receive_name' ],
                'receive_account' => $data[ 'receive_account' ],
                'remark' => $data[ 'remark' ] ?? null,
                'back_url' => $this->backUrl,
                'receiver_telephone' => $data[ 'receiver_telephone' ] ?? null,
            ] );

            ksort( $postData );

            $signStr = '';
            foreach ( $postData as $key => $value ) {
                $signStr .= $key.'='.$value.'&';
            }

            $postData[ 'sign' ] = md5( rtrim( $signStr, '&' ).'&key='.$this->merchantKey );
            $postData[ 'sign_type' ] = 'MD5';

            $response = Http::asForm()->timeout( 60 )->post( $this->withdrawUrl, $postData );

            if ( $response->successful() ) {
                return $response->body();
            }

            throw new Exception( 'API Response Error: '.$response->status() );
        } catch ( Exception $e ) {
            Log::error( 'WatchPay Withdrawal Failed: '.$e->getMessage() );
            return json_encode( [ 'success' => false, 'message' => 'উইথড্রয়াল প্রসেস করতে সমস্যা হয়েছে।' ] );
        }
    }

    public function validateWithdrawSign( array $data ) {
        try {
            $retsign = $data[ 'sign' ] ?? '';
            unset( $data[ 'sign' ], $data[ 'signType' ] );

            $signData = array_filter( [
                'applyDate' => $data[ 'applyDate' ] ?? null,
                'errorMsg' => $data[ 'errorMsg' ] ?? null,
                'mchId' => $data[ 'mchId' ] ?? null,
                'merTransferId' => $data[ 'merTransferId' ] ?? null,
                'respCode' => $data[ 'respCode' ] ?? null,
                'tradeNo' => $data[ 'tradeNo' ] ?? null,
                'tradeResult' => $data[ 'tradeResult' ] ?? null,
                'transferAmount' => $data[ 'transferAmount' ] ?? null,
            ] );

            ksort( $signData );

            $signStr = '';
            foreach ( $signData as $key => $value ) {
                if ( $value !== null ) {
                    $signStr .= $key.'='.$value.'&';
                }
            }

            $calculatedSign = md5( rtrim( $signStr, '&' ).'&key='.$this->merchantKey );

            return $calculatedSign === $retsign;

        } catch ( Exception $e ) {
            Log::error( 'Withdraw Sign Validation Error: '.$e->getMessage() );

            return false;
        }
    }

    public function queryWithdraw( string $mchTransferId ) {
        try {
            $signStr = 'mch_id='.$this->mchId.'&mch_transferId='.$mchTransferId;
            $sign = md5( $signStr.'&key='.$this->merchantKey );

            $postData = [
                'mch_id' => $this->mchId,
                'mch_transferId' => $mchTransferId,
                'sign_type' => 'MD5',
                'sign' => $sign,
            ];

            $response = Http::asForm()->post( $this->queryTransferUrl, $postData );

            return $response->body();

        } catch ( Exception $e ) {
            Log::error( 'WatchPay Query Failed: '.$e->getMessage() );

            return json_encode( [ 'success' => false, 'message' => 'উইথড্রয়াল স্ট্যাটাস চেক করা যায়নি।' ] );
        }
    }
}
