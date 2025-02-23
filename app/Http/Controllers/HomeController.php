<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Models\Product;
use App\Http\Controllers\StripeController;
use DateTime;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /* Dashboard Page */
    public function index(){
        return view('dashboard.index');
    }

    /* Stipe & Paypal Chackout Page */
    public function checkout(){
        /* Get Saved Cards */
        $customerID = "cus_LPNPAm6xztB7bo"; // Demo Customer Id (Create Customer At Login Time)
        $getsavedCards = (new StripeController)->getSavedCards($customerID);
        $savedCards = $getsavedCards->data;
        
        foreach($savedCards as $cardData){
            if(isset($cardData->card->exp_month)){
                $expMonth = DateTime::createFromFormat('n', $cardData->card->exp_month);
                $cardData->card->exp_month = $expMonth->format('m');
            }
            if(isset($cardData->card->exp_year)){
                $expYear = DateTime::createFromFormat('Y', $cardData->card->exp_year);
                $cardData->card->exp_year = $expYear->format('y');
            }
        }

        /* Get All Products */
        $products = Product::getAllProducts();
        $total = 0;
        foreach($products as $product){
            if(isset($product->amount) && $product->amount != ''){
                $total = $total + $product->amount;
            }
        }

        return view('checkout',compact('products','total','savedCards'));
    }

    /* Stripe Checkout Using Cashier Page */
    public function cashierCheckout(){

        $customer = Auth::loginUsingId(1);
        $customerData = auth()->user(); 
        $intent = auth()->user()->createSetupIntent();

        /* Get Saved Cards */
        $savedCards = $customer->paymentMethods();
        foreach($savedCards as $cardData){
            if(isset($cardData->card->exp_month)){
                $expMonth = DateTime::createFromFormat('n', $cardData->card->exp_month);
                $cardData->card->exp_month = $expMonth->format('m');
            }
            if(isset($cardData->card->exp_year)){
                $expYear = DateTime::createFromFormat('Y', $cardData->card->exp_year);
                $cardData->card->exp_year = $expYear->format('y');
            }
        }

        /* Get All Products */
        $products = Product::getAllProducts();
        $total = 0;
        foreach($products as $product){
            if(isset($product->amount) && $product->amount != ''){
                $total = $total + $product->amount;
            }
        }

        return view('cashiercheckout',compact('intent','products','total','savedCards'));
    }

}
