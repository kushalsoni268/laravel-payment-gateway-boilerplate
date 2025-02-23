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

class ProductController extends Controller
{
    public function index()
    {
        $data = Product::getAllProducts();
        return view('products.index',compact('data'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        try{                 
            $rules = array(
                'name' => 'required',
                'amount' => 'required',
                );

            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()) {
                return back()->withInput()->withErrors($validator->errors());
            }

            $return_response = Product::addEditProduct($request);
            if($return_response){
                session()->flash('success', 'Product Created Successfully.');
                return redirect()->route('products.index');
            }else{
                session()->flash('error', 'Oops, something went wrong..');
                return redirect()->route('products.create');
            }
        }catch(\Exception $e){                  
            session()->flash('error',$e->getMessage());
            return back()->withInput();
        }
    }

    public function show($id)
    {
        $data = Product::getProductDetails($id);
        return view('products.show',compact('data'));
    }

    public function edit($id)
    {
        $data = Product::find($id);
        return view('products.edit',compact('data'));
    }

    public function update(Request $request, $id)
    {
        try{     
            $rules = array(
                'name' => 'required',
                'amount' => 'required'            
                );

            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()) {
                return back()->withInput()->withErrors($validator->errors());
            }
                       
            $updateProduct = Product::addEditProduct($request,$id);
            if($updateProduct){
                session()->flash('success', 'Product Updated Successfully.');
                return redirect()->route('products.index');
            }else{
                session()->flash('error', 'Oops, something went wrong..');
                return redirect()->route('products.create');
            }
        }catch(\Exception $e){                  
            session()->flash('error',$e->getMessage());
            return back()->withInput();
        }
    }

    public function destroy($id)
    {
        try{
            $data_del = Product::where('id',$id)->delete();
            return Response::json($data_del);
        }catch(\Exception $e){
            return Response::json($e);
        }  
    }

    public static function postProductList(Request $request)
    { 
        try{           
           return Product::postProductList($request);
        }catch(\Exception $e){
            session()->flash('error',$e->getMessage());
            return redirect()->route('products.create');
        } 
    }    

}
