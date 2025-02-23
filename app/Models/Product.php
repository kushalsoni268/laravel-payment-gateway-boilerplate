<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;
use Yajra\DataTables\DataTables;
use URL;

class Product extends Model
{
    public $table = 'products';

    /* Get All Products */
    public static function getAllProducts(){
        $data = Product::all();
        return $data;
    }

    /* Get Product Details */
    public static function getProductDetails($id)
    {
        $data = Product::find($id);
        return $data;
    }

    /* Products List */
    public static function postProductList($request)
    {
        $query = Product::select('products.*');
        
        if ($request->order == null) {
            $query->orderBy('products.id', 'desc');
        }

        return Datatables::of($query)
            ->addColumn('action', function ($data) {
                $editLink = URL::to('/') . '/products/' . $data->id . '/edit';
                $viewLink = URL::to('/') . '/products/' . $data->id;
                $deleteLink = $data->id;
                return Helper::Action($editLink, $deleteLink, $viewLink);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /* Product Create & Update */
    public static function addEditProduct($request, $id = '')
    {
        if ($id != '') {
            $data = Product::find($id);
        } else {
            $data = new Product();
        }
                
        $data->name = isset($request->name) ? $request->name : null;
        $data->amount = isset($request->amount) ? $request->amount : null;
        $data->save();
        return $data;
    }
}
