<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Cart;
use DB;
use Response;

class ShoppingCartController extends Controller
{

    public function cartshow(Request $request)
    {
       $customer_id = $request->header('customerid');
       return Cart::with('package')
            ->where('customer_id',$customer_id) 
            ->orderBy('created_at', 'desc')
            ->get();  
    }

    public function cartstore(Request $request)
    {
        
        $customer_id = $request->header('customerid');
        Cart::where(['customer_id'=>$customer_id])->delete();

        $item = Cart::where(['product_id'=>$request->productid,
            'customer_id'=>$customer_id]);

        if ($item->count()) {
            return response()->json([
                'status' => 'exist'
            ]);
        }else {
            $package = Package::select('id','price','name')->find($request->productid);
            $item = Cart::forceCreate([
                'product_id'    => $request->productid,
                'customer_id'   => $customer_id,
                'price'         => $package->price,
                'quantity'      => $request->quantity?$request->quantity:1,
            ]);
        }
        return response()->json([
            'status' => 'success',
            'quantity' => $item->quantity,
            'package' => $item->package,
        ]);
    }

    public function cartdestroy(Request $request, $product_id)
    {
        $customer_id = $request->header('customerid');
        $item = Cart::where(['id'=>$product_id,'customer_id'=>$customer_id])->delete();
        return response(['status'=>'success','message'=>'cart item delete']);
    }

    public function show_cart(Request $request)
    {
       $customer_id = $request->header('customerid');
       $carts =  Cart::with('package','package.category')
        ->where('customer_id',$customer_id) 
        ->orderBy('created_at', 'desc')
        ->get();

        $subtotal =  Cart::where('customer_id',$customer_id) 
        ->sum('price');  
        return response()->json(['status'=>'success','carts'=>$carts,'subtotal'=>$subtotal]);
    }
    

}
