<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminNotification;
use Illuminate\Support\Str;
use App\Models\CustomerNotification;
use App\Models\Order;
use App\Models\Ordertype;
use App\Models\orderDetails;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Shipping;
use App\Models\Package;
use App\Models\Country;
use App\Models\State;
use App\Models\Attribute;
use App\Models\Pricing;
use App\Models\Message;
use App\Models\User;
use App\Models\Setting;
use App\Models\GeneralSetting;
use App\Models\Review;
use App\Models\OrderAttribute;
use Carbon\Carbon;
use Mail;
use Session;
use Toastr;
use Cart;
use Auth;
use PDF;
use DB;

class OrderController extends Controller
{

function __construct()
    {
         $this->middleware('permission:order-manage', ['only' => ['ordermanage']]);
         $this->middleware('permission:order-details', ['only' => ['details']]);
         $this->middleware('permission:order-invoice', ['only' => ['invoice']]);
         $this->middleware('permission:order-create', ['only' => ['createinvoice']]);
         $this->middleware('permission:order-delete', ['only' => ['order_delete']]);
    }
    public function ordermanage(){
        if(auth()->user()->hasRole('Superadmin')){
            $show_data = Order::orderBy('id','DESC')->with('customer','payment')->paginate(10);
            // return $show_data;
        }else{
            $show_data = Order::where(['user_id'=>auth()->user()->id])->orderBy('id','DESC')->with('customer','payment')->paginate(10);
        }
        return view('backEnd.order.index',compact('show_data'));
    }
    public function lastestinvoice(){
        
        if(auth()->user()->hasRole('Superadmin')){
            $show_data = Order::orderBy('id','DESC')->with('customer','payment')->paginate(10);
        }else{
            $show_data = Order::where(['user_id'=>auth()->user()->id])->orderBy('id','DESC')->with('customer','payment')->get();
        }
        return view('backEnd.order.lastestinvoice',compact('show_data'));
    }

    public function details($order_id){
        if(auth()->user()->hasRole('Superadmin')){
             $orderInfo     = Order::where('id', $order_id)->first();
        }else{
             $orderInfo     = Order::where(['id'=>$order_id,'user_id'=>auth()->user()->id])->first();
             if($orderInfo == null){
                 Toastr::warning('Failed','You have no access for this action');
                 return redirect()->route('dashboard');
             }
        }
       
        
        $paymentmethod = Payment::where('order_id', $order_id)->first();
        $shippingInfo  = Shipping::where('id', $orderInfo->shipping_id)->first();
        $orderDetails  = Orderdetails::where('order_id', $order_id)->get();
        $customerInfo   = Customer::where('id', $orderInfo->customer_id)->first();
        $user = Auth::user();
        if(auth()->user()->hasRole('Superadmin')){
            $allnotifications = AdminNotification::whereNull('user_id')->where(['status'=>'unread','notify_id'=>$order_id])->update(['status'=>'read']);
        }else{
            $allnotifications = AdminNotification::where(['status'=>'unread','notify_id'=>$order_id])->update(['status'=>'read']);
        }
        $messages = Message::where('order_id',$orderInfo->id)->with('user')->get();
        // message read
        $readmessage = Message::where(['order_id'=>$orderInfo->id,'sender'=>'customer'])->with('user')->update(['status'=>'read']);
        $lastSeen = Message::where(['sender'=>'customer'])->with('user','customer')->latest()->first();
        $last_seen = Carbon::parse($lastSeen?$lastSeen->created_at:'')->diffForHumans();
        $asign_users = User::where('status',1)->skip(1)->limit(100)->get();
        return view('backEnd.order.view', compact('orderInfo', 'shippingInfo', 'paymentmethod', 'orderDetails', 'customerInfo','user','messages','last_seen','asign_users'));
    }
    public function invoice($order_id){
        $orderInfo     = Order::where('id', $order_id)->first();
        $paymentmethod = Payment::where('order_id', $order_id)->first();
        $shippingInfo  = Shipping::where('id', $orderInfo->shipping_id)->first();
        $orderDetails  = Orderdetails::where('order_id', $order_id)->get();
        $billingInfo   = Customer::where('id', $orderInfo->customer_id)->first();
        return view('backEnd.order.invoice', compact('orderInfo', 'shippingInfo', 'paymentmethod', 'orderDetails', 'billingInfo'));
    }
    public function attribute($order_id){
        $orderInfo     = Order::where('id', $order_id)->first();
        $paymentmethod = Payment::where('order_id', $order_id)->first();
        $shippingInfo  = Shipping::where('id', $orderInfo->shipping_id)->first();
        $orderattribute  = OrderAttribute::where('order_id', $order_id)->get();
        $billingInfo   = Customer::where('id', $orderInfo->customer_id)->first();
        return view('backEnd.order.attribute', compact('orderInfo', 'shippingInfo', 'paymentmethod', 'orderattribute', 'billingInfo'));
    }
    public function status_change(Request $request){
        
        $orderInfo     = Order::where('id', $request->order_id)->first();
        $orderInfo->order_status = $request->status;
        $orderInfo->save();
        
        // if($request->status == 3 ||$request->status == 4 ){
        //     $payment = Payment::where('order_id',$request->order_id)->first();
        //     $payment->payment_status = 'completed';
        //     $payment->save();
        // }

        if($request->status == 4){
            $link = '/customer/order-delivery#'.$orderInfo->order_id;
        }else{
            $link = '/customer/user-order';
        }
        $notification               = new CustomerNotification();
        $notification->title        = 'Your order ('. $orderInfo->order_id.') has been '.$orderInfo->ordertype->name;
        $notification->customer_id  = $orderInfo->customer_id;
        $notification->link         = $link;
        $notification->save();
        
        $customerInfo = Customer::where('id',$orderInfo->customer_id)->first();
        $data = array(
             'email'          => $customerInfo->email,
             'order_id'       => $orderInfo->order_id,
             'name'          => $customerInfo->name,
             'rand_id'       => $orderInfo->rand_id,
             'order_status'  => $orderInfo->ordertype->name,
            );
        $send = Mail::send('frontEnd.emails.order_common', $data, function($textmsg) use ($data){
          $textmsg->to($data['email']);
          $textmsg->subject('Your order ('. $data['order_id'].') has been '.$data['order_status']);
        });

        Toastr::success('Success','Order status change successfully');
        return back();
    }
    
    public function payment_status(Request $request){
        
        
        $payment = Payment::find($request->id);
        $payment->payment_status = 'paid';
        $payment->save();
        
        $orderInfo     = Order::where('id', $payment->order_id)->first();
        
        $notification               = new CustomerNotification();
        $notification->title        = 'Your order payment ('. $orderInfo->order_id.') has been paid';
        $notification->customer_id  = $orderInfo->customer_id;
        $notification->link         = '/customer/user-order';
        $notification->save();
        
        Toastr::success('Success','Order status change successfully');
        return back();

    }
    public function order_delete(Request $request){
        $orderinfo = Order::find($request->order_id);
        $orderdetails     = orderDetails::where('order_id', $request->order_id)->delete();
        $shippinginfo     = Shipping::where('id', $orderinfo->shipping_id)->delete();
        $payment          = Payment::where('order_id',$request->order_id)->delete();
        $anotification    = AdminNotification::where('notify_id',$request->order_id)->delete();
        $cnotification    = CustomerNotification::where('notify_id',$request->order_id)->delete();
        $message          = Message::where('order_id',$request->order_id)->delete();
        $orderinfo->delete();
        Toastr::success('Success','Order delete successfully');
        return back();
    }
    public function payment_reminder(Request $request){
        $orderinfo = Order::find($request->order_id);
        $customerInfo = Customer::where('id',$orderinfo->customer_id)->first();
        $data = array(
             'email'       => $customerInfo->email,
             'order_id'       => $orderinfo->order_id,
             'name'       => $customerInfo->name,
             'rand_id'       => $orderinfo->rand_id,
            );
        $send = Mail::send('frontEnd.emails.payment', $data, function($textmsg) use ($data){
          $textmsg->to($data['email']);
          $textmsg->subject('Payment Reminder From Extreme Ranks');
        });
        Toastr::success('Success','Payment Reminder Send Successfully');
        return back();
    }
    public function cancel_reminder(Request $request){
        $orderinfo = Order::find($request->order_id);
        $customerInfo = Customer::where('id',$orderinfo->customer_id)->first();
        $data = array(
             'email'       => $customerInfo->email,
             'order_id'       => $orderinfo->order_id,
             'name'       => $customerInfo->name,
             'rand_id'       => $orderinfo->rand_id,
            );
        $send = Mail::send('frontEnd.emails.cancel_reminder', $data, function($textmsg) use ($data){
          $textmsg->to($data['email']);
          $textmsg->subject('Order Cancel Reminder From Extreme Ranks');
        });
        Toastr::success('Success','Order Cancel Reminder Send Successfully');
        return back();
    }
    public function createinvoice(Request $request){
        Session::forget('subtotal');
        Session::forget('tax');
        Session::forget('discount');
        Session::forget('discountinput');
        Session::forget('taxinput');
        $invoicesetting = GeneralSetting::select('email','address')->first();
        $customerInfo = Customer::where(['id'=>$request->customer_id])->first();
        return view('backEnd.order.create',compact('invoicesetting','customerInfo'));
    }

    public function cart_store(Request $request){
        Session::forget('subtotal');
        $subtotal = $request->amount;
        Session::put('subtotal',$request->amount);
        $subtotal = Session::get('subtotal');

        $tax = ($subtotal*Session::get('taxinput'))/100;
        Session::put('tax',$tax);

        $discount = ($subtotal*Session::get('discountinput'))/100;
        Session::put('discount',$discount);

       return response()->json($subtotal);
         
    }
    public function cart_info() {
        $data = Cart::instance('shopping')->content();
        return view('backEnd.order.cart_info',compact('data'));
    } 
 
    public function cart_tax(Request $request) {
        Session::put('taxinput',$request->tax);

        $subtotal = Session::get('subtotal');
        $tax = ($subtotal*$request->tax)/100;
        Session::put('tax',$tax);
        return response()->json(['tax'=>$tax]);
    } 
    public function cart_discount(Request $request) {
        Session::put('discountinput',$request->discount);
        $subtotal = Session::get('subtotal');
        $discount = ($subtotal*$request->discount)/100;
        Session::put('discount',$discount);
        return response()->json(['discount'=>$discount]);
    } 
    public function invoice_preview(Request $request){
        $data = $request->all();
        Session::put('invoice_id',rand(111111, 999999));
        return view('backEnd.order.invoicepreview', compact('data'));
    }
     public function invoice_save(Request $request){

        $this->validate($request, [
            'companyname' => 'required',
            'address' => 'required',
            'delivery' => 'required',
            'email' => 'required',
           
        ]);
        $customer_info = Customer::where('email',$request->email)->first();
        if($customer_info){
            $customer_id = $customer_info->id;
        }else{
            $store_data              = new Customer();
            $store_data->fullName    = $request->companyname;
            $store_data->phoneNumber = $request->email;
            $store_data->email       = $request->email;
            $store_data->verifyToken = 1;
            $store_data->status      = 1;
            $store_data->password    = bcrypt($request->phone);
            $store_data->save();
            $customer_info = $store_data;
            $customer_id = $store_data->id;
        }        
        $subtotal = Session::get('subtotal')?Session::get('subtotal'):0;
        $tax = Session::get('tax')?Session::get('tax'):0;
        $discount = Session::get('discount')?Session::get('discount'):0;

        if (count(array_filter($request->service_name)) > 0) {

            $shipping                 = new Shipping();
            $shipping->fname          = $request->companyname;
            $shipping->companyname    = $request->companyname;
            $shipping->phone          = $request->email;
            $shipping->email          = $request->email;
            $shipping->housenumber    = $request->address;
            $shipping->invoice_email  = $request->invoice_email;
            $shipping->invoice_address= $request->invoice_address;
            $shipping->note           = $request->note;
            $shipping->customer_id    = $customer_id;
            $shipping->save();
           
            //which transection id
            $order_package = array_filter($request->service_name);
            $order_package = $order_package[0];

            $invoice_id = Session::get('invoice_id')?Session::get('invoice_id'):rand(111111, 999999);

            $order                = new Order();
            $order->package_name  = $order_package;
            $order->customer_id   = $customer_id;
            $order->shipping_id   = $shipping->id;
            $order->total         = ($subtotal+$tax) - $discount;
            $order->discount      = $discount;
            $order->delivery_date = Carbon::now()->addDays($request->delivery);
            $order->order_create  = $request->invoice_date;
            $order->order_status  = $request->status;
            $order->order_type    = 2;
            $order->tax           = $tax;
            $order->rand_id       = Str::lower(Str::random(12));
            $order->order_id      = 'EX-'.$invoice_id;
            $order->save();
            
            $payment                 = new Payment();
            $payment->order_id       = $order->id;
            $payment->payment_type   = 'online';
            $payment->trx_id         =  null;
            $payment->payment_status = $request->status==1?'in draft':'due';
            $payment->save();

            
            $service_names = array_filter($request->service_name);
            $product_id    = array_filter($request->product_id);
            // $client_name   = array_filter($request->client_name);
            $service_attribute   = array_filter($request->service_attribute);
            $attribute_number   = array_filter($request->attribute_number);
            $amount        = array_filter($request->amount);
            foreach ($service_names as $key=>$service_name) {
                $order_details                   = new Orderdetails();
                $order_details->order_id         = $order->id;
                $order_details->package_name     = $service_name;
                $order_details->product_id       = $product_id[$key];
                // $order_details->client_name      = $client_name[$key];
                $order_details->service_attribute = $service_attribute[$key];
                $order_details->attribute_number = $attribute_number[$key];
                $order_details->price            = $amount[$key];
                $order_details->quantity         = 1;
                $order_details->total            = $amount[$key];
                $order_details->save();
            }

            Session::forget('subtotal');
            Session::forget('tax');
            Session::forget('discount');
            Session::forget('discountinput');
            Session::forget('taxinput');
            Session::forget('invoice_id');
            Toastr::success('Success','Invoice create successfully');
            return redirect('admin/order/invoice/'.$order->id);
        } else {
            Toastr::error('Failed','Invoice create failed');
            return back();
        }
    }
    public function delivery_extende(Request $request){
        $order = Order::find($request->order_id);
        $order->delivery_date = $request->delivery;
        $order->save();
        Toastr::success('Success','Data insert successfully');
        return back();
    }
    public function order_asign(Request $request){
        
        $order = Order::find($request->id);
        $order->user_id = $request->admin_id;
        $order->save();
        
        $notification               = new AdminNotification();
        $notification->title        = 'You have asign a support ('. $request->order_id .')';
        $notification->user_id      = $request->admin_id;
        $notification->notify_id    = $request->id;
        $notification->link         = 'admin/order/details/'.$request->id;
        $notification->save();
        
        Toastr::success('Success','Order asign successfully');
        return back();
    }
    public function admin_search(Request $request){
        if($request->keyword){
            $orders = Order::select('id','order_id','total')->where('order_id','LIKE','%'.$request->keyword."%")->get();
        }else{
            $orders = Order::select('id','order_id','total')->limit(0)->get();
        }
        return view('backEnd.order.search',compact('orders'));
        
    }
    
    public function review(){
        $review = Review::orderBy('id','DESC')->with('customer','order')->get();
        // return $review;
        return view('backEnd.review.index',compact('review'));
    }
    
     public function review_destroy(Request $request)
    {
        $delete_data = Review::find($request->hidden_id);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }
    

}
