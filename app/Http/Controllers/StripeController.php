<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Models\Product;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Customer;
use App\Helpers\Helper;
use App\Models\ProductTransaction;

class StripeController extends Controller
{
    /* Stripe Payment */
    public function payment(Request $request){
        try{
            /* For initialize Stripe package */
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $stripe = new \Stripe\StripeClient(
                env('STRIPE_SECRET')
            );

            /* Create Customer */
            // $customer = $stripe->customers->create([
            //     'description' => 'Payment Gateway Demo Customer',
            // ]);

            $customerID = "cus_LPNPAm6xztB7bo"; // Demo Customer Id (Create Customer At Login Time)

            if(isset($request->save_card) && $request->save_card == 1){
                $intentData = $stripe->paymentIntents->create([
                    'payment_method' => $request->stripeToken,
                    'amount' => round($request->amount, 2)*100,
                    'currency' => 'INR',
                    'confirm' => true,
                    'customer' => $customerID,
                    'payment_method_types' => ['card'],
                    'setup_future_usage' => 'off_session',
                ]);
            }else{
                $intentData = $stripe->paymentIntents->create([
                    'payment_method' => $request->stripeToken,
                    'amount' => round($request->amount, 2)*100,
                    'currency' => 'INR',
                    'confirm' => true,
                    'customer' => $customerID,
                    'payment_method_types' => ['card'],
                ]);
            }

            if(isset($intentData->id) && $intentData->id != ''){
                /* Store Transaction Details */
                $productTransaction = new ProductTransaction();
                $productTransaction->transaction_id = $intentData->id;  // round($bookingAmount, 2);
                $productTransaction->amount = round($request->amount, 2);
                $productTransaction->payment_type =config('const.stripePayment');
                $productTransaction->status = isset($intentData->status) && $intentData->status == 'succeeded' ? config('const.paymentCompleted') : config('const.paymentPending');
                $productTransaction->save();
            }

            /* Remove Duplicate Card */
            $cards = $stripe->paymentMethods->all(['customer' => $customerID, 'type' => 'card']);
            $fingerprints = [];
            foreach ($cards as $card) {
                $fingerprint = $card['card']['fingerprint'];
                    if (in_array($fingerprint, $fingerprints, true)) {
                    $stripe->paymentMethods->detach($card['id']);
                } else {
                    $fingerprints[] = $fingerprint;
                }
            }

            return Helper::success($intentData);
        }catch(\Exception $e){                  
            return  Helper::fail([], $e->getMessage());
        }
    }

    /* Stripe Cashier Payment */
    public function cashierPayment(Request $request){
        try{
            $user = $request->user();
            $user->createOrGetStripeCustomer();
            if(isset($request->save_card) && $request->save_card == 1){
                $user->updateDefaultPaymentMethod($request->stripeToken);
            }
            $intentData = $user->charge($request->amount * 100, $request->stripeToken, [
                'currency' => "INR"
            ]);    

            /* Store Transaction Details */
            $productTransaction = new ProductTransaction();
            $productTransaction->transaction_id = $intentData->id;  // round($bookingAmount, 2);
            $productTransaction->amount = round($request->amount, 2);
            $productTransaction->payment_type =config('const.stripeCashierPayment');
            $productTransaction->status = config('const.paymentCompleted');
            $productTransaction->save();

            /* Remove Duplicate Card */
            $cards = $user->paymentMethods();
            $fingerprints = [];
            foreach ($cards as $cardData) {
                $fingerprint = $cardData->card->fingerprint;
                if (in_array($fingerprint, $fingerprints, true)) {
                    $user->deletePaymentMethod($cardData->id);
                } else {
                    $fingerprints[] = $fingerprint;
                }
            }

            return Helper::success($intentData);
        } catch(\Stripe\Exception\CardException $e) {
            return  Helper::fail([], $e->getMessage());
        } catch(\Exception $e){ 
            if ($e->payment->status && $e->payment->status == 'requires_action') {
                /* Store Transaction Details */
                $productTransaction = new ProductTransaction();
                $productTransaction->transaction_id = $e->payment->id;  // round($bookingAmount, 2);
                $productTransaction->amount = round($request->amount, 2);
                $productTransaction->payment_type =config('const.stripeCashierPayment');
                $productTransaction->status = config('const.paymentPending');
                $productTransaction->save();

                /* Remove Duplicate Card */
                $cards = $user->paymentMethods();
                $fingerprints = [];
                foreach ($cards as $cardData) {
                    $fingerprint = $cardData->card->fingerprint;
                    if (in_array($fingerprint, $fingerprints, true)) {
                        $user->deletePaymentMethod($cardData->id);
                    } else {
                        $fingerprints[] = $fingerprint;
                    }
                }

                return Helper::success($e->payment);
            } else {
                return  Helper::fail([], $e->getMessage());
            }
        }
    }

    /* Get All Card */
    public function getSavedCards($customerID){
        try{
            /* For initialize Stripe package */
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $stripe = new \Stripe\StripeClient(
                env('STRIPE_SECRET')
              );
            
            $data = $stripe->customers->allPaymentMethods(
                $customerID,
                ['type' => 'card']
            );
            
            return $data;
        }catch(\Exception $e){                  
            return  Helper::fail([], $e->getMessage());
        }
    }   

    /* Update Payment Status */
    public function changePaymentStatus(Request $request){
        $updateData = ProductTransaction::where('transaction_id', $request->id)->update(['status' => $request->status]);
        return Helper::success($updateData);
    }
    
}
