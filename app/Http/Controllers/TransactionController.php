<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use App\Models\Product;
use App\Models\ProductTransaction;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Customer;
use Srmklive\PayPal\Services\ExpressCheckout;

class TransactionController extends Controller
{
    /* Stripe Transactions Start */
    public function stripeTransaction()
    {
        return view('transactions.stripe');
    }

    public static function postStripeTransactionList(Request $request)
    { 
        try{           
           return ProductTransaction::postStripeTransactionList($request);
        }catch(\Exception $e){
            session()->flash('error',$e->getMessage());
            return redirect()->route('products.create');
        } 
    }    

    public static function postStripeCashierTransactionList(Request $request)
    { 
        try{           
           return ProductTransaction::postStripeCashierTransactionList($request);
        }catch(\Exception $e){
            session()->flash('error',$e->getMessage());
            return redirect()->route('products.create');
        } 
    }   
    /* Stripe Transactions End */

    /* Stripe Refund Start */
    public function getStripeRefund($id)
    {
        $data = ProductTransaction::getProductTransactionDetails($id);
        return view('transactions.refundstripe',compact('data'));
    }

    public function postStripeRefund(Request $request)
    {
        /* For initialize Stripe package */
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $stripe = new \Stripe\StripeClient(
            env('STRIPE_SECRET')
        );

        $transactionData = ProductTransaction::find($request->id);
        
        $refundData = $stripe->refunds->create([
            'payment_intent' => $transactionData->transaction_id, 'amount' => $request->refund_amount * 100
        ]);

        if(isset($refundData->status) && $refundData->status == 'succeeded'){
            $transactionData->status = config('const.paymentRefunded');
            $transactionData->save();
        }
        session()->flash('success', 'Payment Refunded Successfully.');
        return redirect()->route('stripe-transaction');
    }

    public function getStripeCashierRefund($id)
    {
        $data = ProductTransaction::getProductTransactionDetails($id);
        return view('transactions.refundstripecashier',compact('data'));
    }

    public function postStripeCashierRefund(Request $request)
    {
        try{
            $transactionData = ProductTransaction::find($request->id);
            $user = $request->user();
            $refundData = $user->refund($transactionData->transaction_id, [
                'amount' => $request->refund_amount * 100,
            ]);
            if(isset($refundData->status) && $refundData->status == 'succeeded'){
                $transactionData->status = config('const.paymentRefunded');
                $transactionData->save();
            }
            session()->flash('success', 'Payment Refunded Successfully.');
            return redirect()->route('stripe-transaction');
        } catch(\Exception $e){ 
            // session()->flash('error', $e->getMessage());
            session()->flash('error', "Oops, There is some thing went wrong. Please try after some time.");
            return redirect()->route('stripe-transaction');
        }
    }
    /* Stripe Refund End */

    /* Paypal Transactions Start */
    public function paypalTransaction()
    {
        return view('transactions.paypal');
    }

    public static function postPaypalTransactionList(Request $request)
    { 
        try{           
           return ProductTransaction::postPaypalTransactionList($request);
        }catch(\Exception $e){
            session()->flash('error',$e->getMessage());
            return redirect()->route('products.create');
        } 
    }  
    /* Paypal Transactions End */

    /* Paypal Refund Start */
    public function getPaypalRefund($id)
    {
        $data = ProductTransaction::getProductTransactionDetails($id);
        return view('transactions.refundpaypal',compact('data'));
    }

    public function postStripePaypalRefund(Request $request)
    {
        $transactionData = ProductTransaction::find($request->id);
        $provider = new ExpressCheckout;
        $response = $provider->refundTransaction($transactionData->transaction_id, $request->refund_amount);
        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            $transactionData->status = config('const.paymentRefunded');
            $transactionData->save();
            session()->flash('success', 'Payment Refunded Successfully.');
            return redirect()->route('paypal-transaction');
        }else{
            session()->flash('error', "Oops, There is some thing went wrong. Please try after some time.");
            return redirect()->route('paypal-transaction');
        }
    }
    /* Paypal Refund End */

}
