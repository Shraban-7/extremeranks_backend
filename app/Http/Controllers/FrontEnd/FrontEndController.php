<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shipping;
use App\Models\Order;
use App\Models\Payment;
use App\Models\orderDetails;
use App\Models\OrderAttribute;
use App\Models\Customer;
class FrontEndController extends Controller
{
    public function home() {
        return view('backEnd.auth.login');
    }
     public function open_invoice($invoice){
        $orderInfo     = Order::where('rand_id', $invoice)->firstOrfail();
        $paymentmethod = Payment::where('order_id', $orderInfo->id)->first();
        $shippingInfo  = Shipping::where('id', $orderInfo->shipping_id)->first();
        $orderDetails  = orderDetails::with(['category'])->where('order_id', $orderInfo->id)->get();
        $orderattribute  = OrderAttribute::where('order_id', $orderInfo->id)->get();
        $billingInfo   = Customer::where('id', $orderInfo->customer_id)->first();
        return view('backEnd.order.client_invoice', compact('orderInfo', 'shippingInfo', 'paymentmethod', 'orderDetails', 'orderattribute', 'billingInfo'));
    }

   
}
