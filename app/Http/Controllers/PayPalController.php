<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Models\Product;
use Srmklive\PayPal\Services\ExpressCheckout;
use App\Models\ProductTransaction;

class PayPalController extends Controller
{

    /**
     * @var ExpressCheckout
     */
    protected $provider;

    public function __construct()
    {
        $this->provider = new ExpressCheckout();
    }

    public function payment(Request $request){
    
        $products = json_decode($request->products,true);
        $data = [];
        $items = [];

        foreach($products as $product){
            $items[] = [
                        'name' => $product['name'],
                        'price' => $product['amount'],
                        'desc'  => 'Description for'.$product['name'],
                        'qty' => 1
                    ];
        }

        $data['items'] = $items;
        $data['invoice_id'] = "Invoice-".time();
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['return_url'] = route('paypal.payment.success');
        $data['cancel_url'] = route('paypal.payment.cancel');
        $data['total'] = $request->total;
  
        $provider = new ExpressCheckout;
  
        $response = $provider->setExpressCheckout($data);
  
        $response = $provider->setExpressCheckout($data, true);
  
        if(isset($response['paypal_link']) && $response['paypal_link'] != ''){
            return redirect($response['paypal_link']);
        }
        session()->flash('error', "Oops, There is some thing went wrong. Please try after some time.");
        return redirect()->route('checkout');
    }

    public function cancel(){
        session()->flash('error', 'Payment Cancelled');
        return redirect()->route('checkout');
    }
    
    public function success(Request $request){
        $provider = new ExpressCheckout;
        $response = $this->provider->getExpressCheckoutDetails($request->token);
        $token = $response['TOKEN'];
        $payerID = $response['PAYERID'];

        $itemData = Product::getAllProducts();
        $items = [];
        foreach($itemData as $product){
            $items[] = [
                        'name' => $product->name,
                        'price' => $product->amount,
                        'desc'  => 'Description for'.$product->name,
                        'qty' => 1
                    ];
        }

        $data = [];
        $data['items'] = $items;
        $data['invoice_id'] = $response['INVNUM'];
        $data['invoice_description'] = $response['PAYMENTREQUEST_0_DESC'];
        $data['total'] = $response['AMT'];
        
        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            $payment_status = $this->provider->doExpressCheckoutPayment($data, $token, $payerID);
            if(isset($payment_status['PAYMENTINFO_0_PAYMENTSTATUS']) && $payment_status['PAYMENTINFO_0_PAYMENTSTATUS'] == 'Completed'){
                /* Store Transaction Details */
                $productTransaction = new ProductTransaction();
                $productTransaction->transaction_id = $payment_status['PAYMENTINFO_0_TRANSACTIONID'];  // round($bookingAmount, 2);
                $productTransaction->amount = round($payment_status['PAYMENTINFO_0_AMT'], 2);
                $productTransaction->payment_type =config('const.paypalPayment');
                $productTransaction->status = config('const.paymentCompleted');
                $productTransaction->save();
            }
            session()->flash('success', 'Payment Successful');
            return redirect()->route('checkout');
        }
        session()->flash('error', 'Something Went Wrong');
        return redirect()->route('checkout');
    }
    
}
