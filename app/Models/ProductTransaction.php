<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;
use Yajra\DataTables\DataTables;
use URL;

class ProductTransaction extends Model
{
    public $table = 'product_transaction';

    /* Get Product Transaction Details */
    public static function getProductTransactionDetails($id)
    {
        $data = ProductTransaction::find($id);
        return $data;
    }

    /* Stripe Transactions List */
    public static function postStripeTransactionList($request)
    {
        $query = ProductTransaction::where(['payment_type' => config('const.stripePayment')]);
        
        if ($request->order == null) {
            $query->orderBy('product_transaction.id', 'desc');
        }

        return Datatables::of($query)
            ->addColumn('status', function ($data) {
                return Helper::PaymentStatus($data->status);
            })
            ->addColumn('action', function ($data) {
                $refundLink = URL::to('/') . '/stripe-refund/' . $data->id; 
                if($data->status == config('const.paymentCompleted')){         
                    return '<a href="' . $refundLink . '" class="btn-sm btn-danger waves-effect waves-float waves-light">Refund</a>';
                }else{
                    return '<button type="button" class="btn red btn-xs pointerhide cursornone">---</button>';
                }
            })
            ->rawColumns(['status','action'])
            ->make(true);
    }

    /* Stripe Cashier Transactions List */
    public static function postStripeCashierTransactionList($request)
    {
        $query = ProductTransaction::where(['payment_type' => config('const.stripeCashierPayment')]);
        
        if ($request->order == null) {
            $query->orderBy('product_transaction.id', 'desc');
        }

        return Datatables::of($query)
            ->addColumn('status', function ($data) {
                return Helper::PaymentStatus($data->status);
            })
            ->addColumn('action', function ($data) {
                $refundLink = URL::to('/') . '/stripe-cashier-refund/' . $data->id; 
                if($data->status == config('const.paymentCompleted')){         
                    return '<a href="' . $refundLink . '" class="btn-sm btn-danger waves-effect waves-float waves-light">Refund</a>';
                }else{
                    return '<button type="button" class="btn red btn-xs pointerhide cursornone">---</button>';
                }
            })
            ->rawColumns(['status','action'])
            ->make(true);
    }

    /* Paypal Transactions List */
    public static function postPaypalTransactionList($request)
    {
        $query = ProductTransaction::where(['payment_type' => config('const.paypalPayment')]);
        
        if ($request->order == null) {
            $query->orderBy('product_transaction.id', 'desc');
        }

        return Datatables::of($query)
            ->addColumn('status', function ($data) {
                return Helper::PaymentStatus($data->status);
            })
            ->addColumn('action', function ($data) {
                $refundLink = URL::to('/') . '/paypal-refund/' . $data->id; 
                if($data->status == config('const.paymentCompleted')){         
                    return '<a href="' . $refundLink . '" class="btn-sm btn-danger waves-effect waves-float waves-light">Refund</a>';
                }else{
                    return '<button type="button" class="btn red btn-xs pointerhide cursornone">---</button>';
                }
            })
            ->rawColumns(['status','action'])
            ->make(true);
    }

}
