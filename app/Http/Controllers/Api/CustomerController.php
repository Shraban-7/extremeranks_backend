<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\GeneralSetting;
use App\Models\AdminNotification;
use App\Models\CustomerNotification;
use App\Models\Comment;
use Illuminate\Support\Str;
use App\Models\Customer;
use App\Models\Shipping;
use App\Models\Order;
use App\Models\Payment;
use App\Models\orderDetails;
use App\Models\Package;
use App\Models\Review;
use App\Models\Cart;
use App\Models\Message;
use App\Models\User;
use App\Events\SendMessage;
use App\Models\Couponcode;
use App\Models\Attribute;
use App\Models\OrderAttribute;
use Carbon\Carbon;
use Mail;
use DB;
use PDF;
use Stripe\Stripe;
use Stripe\Exception\ApiErrorException;

class CustomerController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth:customer', ['except' => ['login', 'register', 'verify', 'resendverify', 'forgetpassword', 'fpassreset','logout','striped_payment','couponapply','contact']]);
    }
    
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullName' => 'required',
            'email' => 'required|email|unique:customers',
            'phoneNumber' => 'required|numeric|unique:customers',
            'password' => 'required|same:confirmed',
            'confirmed' => 'required',
           
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>'validationfail',
                'errors'=>'validation_error',
                'message'=>$validator->errors()
            ]);
        }
        

        if ($validator->fails()) {
            return response()->json(
                [
                    "error" => 'validation_error',
                    "message" => $validator->errors(),
                ],
                200
            );
        }

        $verifyToken = rand(1111, 9999);
        $store_data = new Customer();
        $store_data->fullName = $request->fullName;
        $store_data->phoneNumber = $request->phoneNumber;
        $store_data->email = $request->email;
        $store_data->verifyToken = $verifyToken;
        $store_data->status = 1;
        $store_data->password = bcrypt(request('password'));
        $store_data->save();

         $customerId= $request->header('verifyphone');
           if($request->email !=NULL){
               $data = array(
                     'email'       => $request->email,
                     'verifyToken' => $verifyToken,
                    );
                $send = Mail::send('frontEnd.emails.register', $data, function($textmsg) use ($data){
                  $textmsg->to($data['email']);
                  $textmsg->subject('Your Verify Code Send Successfully');
                });
            }

        return response()->json(['status' => 'success', 'verifyemail' => $request->email, 'initpass' => $request->password]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
           
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>'validationfail',
                'errors'=>'validation_error',
                'message'=>$validator->errors()
            ]);
        }
        $credentials = request(['email', 'password']);
        if ($token = Auth::guard('customer')->attempt($credentials)) {
            return response()->json(['status' => 'success', 'token' => $token]);
        }
        return response()->json(['status' => 'Error']);
    }

    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'verifyPin' => 'required',
           
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status'=>'validationfail',
                'errors'=>'validation_error',
                'message'=>$validator->errors()
            ]);
        }
        

        if ($validator->fails()) {
            return response()->json(
                [
                    "error" => 'validation_error',
                    "message" => $validator->errors(),
                ],
                200
            );
        }

        $customeremail = $request->header('verifyemail');
        $password = $request->header('initpass');
        $verified = Customer::where('email', $customeremail)->first();
        $verifydbtoken = $verified->verifyToken;
        $verifyformtoken = $request->verifyPin;
        if ($verifydbtoken == $verifyformtoken) {
            $verified->verifyToken = 1;
            $verified->status = 1;
            $verified->save();
            $credentials = ['email' => $customeremail, 'password' => $password];
            try {
                if (!($token = Auth::guard('customer')->attempt($credentials))) {
                    return response()->json(
                        [
                            'error' => 'Invalid Credentials',
                        ],
                        401
                    );
                }
            } catch (JWTException $e) {
                return response()->json(
                    [
                        'error' => 'Could not create token',
                    ],
                    500
                );
            }
            return response()->json(
                [
                    'status' => 'success',
                    'token' => $token,
                ],
                200
            );
        }
    }

    public function resendverify(Request $request)
    {
        $customeremail = $request->header('verifyemail');
        $findcustomer = Customer::where('phoneNumber', $customeremail)->orWhere('email', $customeremail)->first();
        $verifyToken = rand(1111, 9999);
        $findcustomer->verifyToken = $verifyToken;
        $findcustomer->save();
        
        if($findcustomer->email !=NULL){
               $data = array(
                     'email'       => $request->email,
                     'verifyToken' => $verifyToken,
                    );
                $send = Mail::send('frontEnd.emails.register', $data, function($textmsg) use ($data){
                  $textmsg->to($data['email']);
                  $textmsg->subject('Your Verify Code Send Successfully');
                });
            }

        return response()->json(['status' => 'success']);
    }


    public function forgetpassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
        ]);
        $checkCustomer = Customer::where('email', $request->email)->first();
        if ($checkCustomer) {
            $passResetToken = rand(1111, 9999);
            $checkCustomer->passResetToken = $passResetToken;
            $checkCustomer->save();
            $data = array(
                 'email'       => $checkCustomer->email,
                 'passResetToken' => $passResetToken,
                );
            $send = Mail::send('frontEnd.emails.forgotpassword', $data, function($textmsg) use ($data){
              $textmsg->to($data['email']);
              $textmsg->subject('Your Verify Code Send Successfully');
            });
            $customeremail = $request->email;
            return response()->json(['status' => 'success','customeremail'=>$customeremail]);
        }


    }

    public function fpassreset(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'password' => 'required',
        ]);
        $customeremail = $request->header('customeremail');
        $customerInfo = Customer::where('email', $customeremail)->first();
        if ($customerInfo->passResetToken == $request->token) {
            $customerInfo->password = bcrypt(request('password'));
            $customerInfo->passResetToken = null;
            $customerInfo->save();

            $credentials = ['email' => $customeremail, 'password' => $request->password];
            try {
                if (!($token = Auth::guard('customer')->attempt($credentials))) {
                    return response()->json(
                        [
                            'error' => 'Invalid Credentials',
                        ],
                        401
                    );
                }
            } catch (JWTException $e) {
                return response()->json(
                    [
                        'error' => 'Could not create token',
                    ],
                    500
                );
            }
            return response()->json(
                [
                    'status' => 'success',
                    'token' => $token,
                ],
                200
            );
            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error']);
        }
    }

    public function orderSave(Request $request){

        $validator = Validator::make($request->all(), [
            'fname' => 'required',
            'lname' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'companyname' => 'required',
            'country_id' => 'required',
            'housenumber' => 'required',
            'city' => 'required',
            'state_id' => 'required',
            'zipcode' => 'required',
            'paymentType' => 'required',
           
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    "error" => 'validation_error',
                    "message" => $validator->errors(),
                ],
                200
            );
        }  
        $customer_id = $request->header('customerid');
        $productcarts = Cart::with('package')
        ->where('customer_id', $customer_id)
        ->get();

        $package = Cart::with('package')
        ->where('customer_id', $customer_id)
        ->first();

        $subtotal = Cart::where('customer_id', $customer_id)
            ->get()
            ->sum(function ($total) {
                return $total->price * $total->quantity;
        });
        $discount = $request->header('discount')?$request->header('discount'):0;
        if ($productcarts != null) {

            $generalsetting = GeneralSetting::where('status',1)->select('id','email','address')->first();
            $shipping                   = new Shipping();
            $shipping->fname            = $request->fname;
            $shipping->lname            = $request->lname;
            $shipping->companyname      = $request->companyname;
            $shipping->country_id       = $request->country_id;
            $shipping->housenumber      = $request->housenumber;
            $shipping->apartment        = $request->apartment;
            $shipping->city             = $request->city;
            $shipping->state_id         = $request->state_id;
            $shipping->zipcode          = $request->zipcode;
            $shipping->phone            = $request->phone;
            $shipping->email            = $request->email;
            $shipping->invoice_email    = $generalsetting->email;
            $shipping->invoice_address  = $generalsetting->address;
            $shipping->note             = $request->note;
            $shipping->customer_id      = Auth::guard('customer')->user()->id;
            $shipping->save();
           
            //which transection id
            $order                = new Order();
            $order->package_name  = $package->package->name;;
            $order->customer_id   = Auth::guard('customer')->user()->id;
            $order->shipping_id   = $shipping->id;
            $order->total         = ($subtotal) - $discount;
            $order->delivery_date = Carbon::now()->addDays($package->package->days);
            $order->order_create  = Carbon::now();
            $order->discount      = $discount;
            $order->tax           = 0;
            $order->order_id      = 'EX-'.rand(111111, 999999);
            $order->rand_id       = Str::lower(Str::random(12));
            $order->order_status  = 2;
            $order->order_type    = 1;
            $order->created_at    = Carbon::now();
            // return $order;
            $order->save();
            

            $payment                 = new Payment();
            $payment->order_id       = $order->id;
            $payment->payment_type   = $request->paymentType;
            $payment->trx_id         = $request->transectionId;
            $payment->payment_status = 'due';
            $payment->save();
            
            foreach ($productcarts as $cartitem) {
                foreach($cartitem->package->pricing as $price){
                    if($price->attribute_value != 0){
                        $attribute = Attribute::select('id','title')->find($price->attribute_id);
                        $order_attribute = new OrderAttribute();
                        $order_attribute->pricing_id = $price->id;
                        $order_attribute->order_id = $order->id;
                        $order_attribute->title = $attribute->title;
                        $order_attribute->value = $price->attribute_value==1?'yes':$price->attribute_value;
                        $order_attribute->save(); 
                    }
                }
                $order_details                   = new orderDetails();
                $order_details->order_id         = $order->id;
                $order_details->package_name     = $cartitem->package->name;
                $order_details->package_id       = $cartitem->package->id;
                $order_details->category_id      = $cartitem->package->category_id;
                $order_details->price            = $cartitem->package->price;
                $order_details->quantity         = $cartitem->quantity;
                $order_details->client_name      = Auth::guard('customer')->user()->fullName;
                $order_details->total            = $cartitem->package->price * $cartitem->quantity;
                $order_details->save();
                Cart::where(['customer_id' => $customer_id, 'product_id' => $cartitem->product_id])->delete();
            }

            $notification            = new AdminNotification();
            $notification->title     = 'New ('. $order->order_id.') order placed';
            $notification->link      = 'admin/order/details/'.$order->id;
            $notification->notify_id = $order->id;
            $notification->save();
            
            $customerInfo = Customer::where('id',$order->customer_id)->first();
            
            $data['customername']=$request->fname.' '.$request->lname;
            $data['invoiceid']=$order->rand_id;
            $data['formemail']=$request->email;
            $data['customeremail']=$customerInfo->email;
            $send = Mail::send('frontEnd.emails.ordermail', $data, function($textmsg) use ($data){
              $textmsg->to('info@extremeranks.com');
              $textmsg->cc("$data[customeremail]");
              $textmsg->cc("$data[formemail]");
              $textmsg->subject("$data[customername] Order From Extremeranks.com");
            });
            
            return response()->json(['status' => 'success','order'=>$order,'payment'=>$request->paymentType, 'paymentId'=>$payment->id]);
            
        } else {
            return response()->json(['status' => 'error']);
        }
    }
    public function striped_payment(Request $request){

        
        $paymentMethodId = $request->input('paymentMethodId');
        $amount = $request->input('amount');
        $name = $request->input('fname');
        $email = $request->input('email');
        $address = $request->input('address');

        // Initialize Stripe with your secret key
        Stripe::setApiKey('sk_test_51NGb48H3mm8HTXyy1FNcaAHOwm8fVk3kLne1Ici2O7nzvNlA5MTH0gsonZVwWDAhBZPO8M1G7JYPKC4jwphYDqTw00Q1eX4KNA');
        $charge = \Stripe\PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'usd',
            'confirm' => true,
            'receipt_email' => $email,
            'payment_method' => $paymentMethodId,
            'description' => 'Order placed by'.$name,
        ]);

        if ($charge->status === 'succeeded') {
            
             $payment = Payment::find($request->paymentId);
             $payment->payment_status = 'paid';
             $payment->save();
             
             $order = Order::find($payment->order_id);
             $order->order_status = 3;
             $order->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully.',
            ]);
        } else {
           
             
             $payment = Payment::find($request->paymentId);
             $payment->payment_status = 'due';
             $payment->save();
             
             $order = Order::find($payment->order_id);
             $order->order_status = 2;
             $order->save();
             
            return response()->json([
                'success' => false,
                'message' => 'Payment failed. Please try again.',
            ]);
        }
    }
    public function account(Request $request){
        $customer = Auth::guard('customer')->user();
        return response()->json(['status' => 'success', 'customer' => $customer]);
    }
    public function chatopen(){
        $chatopen = Order::where(['customer_id'=>Auth::guard('customer')->user()->id])->latest()->first();
        $ordercount = Order::where(['customer_id'=>Auth::guard('customer')->user()->id])->count();
        return response()->json(['status' => 'success', 'chatopen' => $chatopen, 'ordercount' => $ordercount]);
    }
    public function myorder(){
        $notification = CustomerNotification::where(['status'=>'unread'])->update(['status'=>'read']);
        $orders = Order::latest()->with('orderdetails','ordertype','payment','attributes')->withCount('unreadmessages')->where(['customer_id' => Auth::guard('customer')->user()->id])->whereNot('order_status',1)->paginate(5);
        return response()->json(['status' => 'success', 'orders' => $orders, 'notification' => $notification]);
    }
    public function delivery_order(){
        $notification = CustomerNotification::where(['status'=>'unread'])->update(['status'=>'read']);
        $orders = Order::latest()->with('review','orderdetails','attributes','deliveryfile')->where(['customer_id' => Auth::guard('customer')->user()->id,'order_status'=>4])->get(); 
        return response()->json(['status' => 'success', 'orders' => $orders,'notification' => $notification]);
    }
    public function packages(){
        $packages = Package::with('category','pricing','pricing.attribute')->where(['status' => 1,'type'=>1])->paginate(10);
        return response()->json(['status' => 'success', 'packages' => $packages]);
    }
    public function download_invoice($order_id){
        $orderInfo     = Order::where('id', $order_id)->first();
        $paymentmethod = Payment::where('order_id', $order_id)->first();
        $shippingInfo  = Shipping::where('id', $orderInfo->shipping_id)->first();
        $orderDetails  = Orderdetails::with(['category'])->where('order_id', $order_id)->get();
        $orderattribute  = OrderAttribute::where('order_id', $orderInfo->id)->get();
        $billingInfo   = Customer::where('id', $orderInfo->customer_id)->first();
        $pdf = PDF::loadView('pdf', ['orderInfo' => $orderInfo,'paymentmethod'=>$paymentmethod,'shippingInfo'=>$shippingInfo,'orderDetails'=>$orderDetails,'orderattribute'=>$orderattribute,'billingInfo'=>$billingInfo]);
        return $pdf->download();
        return response()->compact('orderInfo', 'shippingInfo', 'paymentmethod', 'orderDetails','orderattribute', 'billingInfo');
    }
    public function order_complete(Request $request){
        $order = Order::where(['id' => $request->id])->first();
        $order->order_status = 4;
        $order->save();
        return response()->json(['status' => 'success', 'order' => $order]);
    }

    public function order_review(Request $request){
         $this->validate($request, [
            'review' => 'required',
        ]);
        $ifExits = Review::where('order_id',$request->id)->first();
        if($ifExits !=null){
          $ifExits->review = $request->review;
          $ifExits->save();
        }
        
        $review                 = new Review();
        $review->customer_id    = Auth::guard('customer')->user()->id;
        $review->order_id       = $request->id;
        $review->review         = $request->review;
        $review->status         = 1;
        $review->save();
        return response()->json(['status' => 'success', 'review' => $review]);
    }
    public function profileUpdate(Request $request){

        $this->validate($request, [
            'firstName' => 'required',
            'lastName' => 'required',
            'displayName' => 'required',
            'phoneNumber' => 'required',
            'address' => 'required',
            'email' => 'required',
        ]);

        $update = Customer::find(Auth::guard('customer')->user()->id);

        $update_image = $request->file('image');
        if ($update_image) {
            $file = $request->file('image');
            $name = time() . '-' . $file->getClientOriginalName();
            $uploadPath = 'public/uploads/customer/';
            $file->move($uploadPath, $name);
            $fileUrl = $uploadPath . $name;
        } else {
            $fileUrl = $update->image;
        }
        $update->firstName      = $request->firstName;
        $update->lastName       = $request->lastName;
        $update->fullName       = $request->firstName.' '.$request->lastName;
        $update->displayName    = $request->displayName;
        $update->phoneNumber    = $request->phoneNumber;
        $update->email          = $request->email;
        $update->address        = $request->address;
        $update->image          = $fileUrl;
        $update->save();
        return response()->json(['status' => 'success', 'update' => $update]);
    }
    public function passwordchange(Request $request){
        $this->validate($request, [
            'current_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password|min:6'
        ]);

        $user = Customer::find(Auth::guard('customer')->user()->id);
        $hashPass = $user->password;
        if(Hash::check($request->current_password, $hashPass)){
            $user
                ->fill([
                    'password' => Hash::make($request->new_password),
                ])
                ->save();

            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error']);
        }
    }
     public function logout()
    {
        Auth::guard('customer')->logout();
        return response()->json(['status' => 'success']);
    }

     public function messages(Request $request){
        if($request->order_id != 'undefined' && $request->order_id != 0){
            $order = Order::where('order_id',$request->order_id)->first();
            $messages = Message::where(['customer_id'=>Auth::guard('customer')->user()->id,'order_id'=>$order->id])->with('user','customer')->get();
            $readmessage = Message::where(['customer_id'=>Auth::guard('customer')->user()->id,'order_id'=>$order->id,'sender'=>'admin'])->with('order')->update(['status'=>'read']);
        }else{
            $order = null;
            $messages = Message::where(['customer_id'=>Auth::guard('customer')->user()->id])->whereNull('order_id')->with('user','customer')->get();
            if($request->order_id == 0){
             $readmessage = Message::where(['customer_id'=>Auth::guard('customer')->user()->id,'sender'=>'admin'])->whereNull('order_id')->with('order')->update(['status'=>'read']);
            }
        }
        $lastSeen = Message::where(['sender'=>'admin'])->with('user','customer')->latest()->first();
        $last_seen = Carbon::parse($lastSeen?$lastSeen->created_at:'')->diffForHumans();
        return response()->json(['messages'=>$messages,'last_seen'=>$last_seen,'order'=>$order]);
    }
    
    public function message_send(Request $request){
        
        if($request->order_id !=0){
            $order = Order::where('order_id',$request->order_id)->select('order_id','user_id','id')->first();
            $order_id = $order->id;
            $user_id = $order->user_id;
        }else{
            $order_id = null;
            $user_id = null;
        }
        
        $file = $request->file('file');
        if($file){
            $file_name = $file->getClientOriginalName();
        	$name = $file->getClientOriginalName();
        	$uploadPath = 'public/uploads/message/';
        	$file->move($uploadPath,$name);
        	$fileUrl =$uploadPath.$name;
        }else{
          $file_name = null;  
          $fileUrl = null;  
        }
        
        $messages           = new Message;
        $messages->message  = $request->message;
        $messages->order_id = $order_id;
        $messages->customer_id = Auth::guard('customer')->user()->id;
        $messages->file     = $fileUrl;
        $messages->admin_id  = $user_id;
        $messages->file_name = $file_name;
        $messages->sender   = 'customer';
        $messages->status   = 'unread';
        $messages->save();

       $messages = Message::where(['customer_id'=>Auth::guard('customer')->user()->id,'order_id'=>$order_id])->with('customer')->get();
       $user = Customer::find(Auth::guard('customer')->user()->id);
       $data = array(
                 'customername'       => $user->firstName.' '.$user->lastName,
                 'customer_id'       => $user->id,
                 'email'       => $user->email,
                 'maildetails' => $request->message,
                 'fileUrl' => $fileUrl,
                 'order_id' => $order_id,
                );
        $send = Mail::send('frontEnd.emails.commonmail', $data, function($textmsg) use ($data){
              $textmsg->to('info@extremeranks.com');
              $textmsg->subject("New message on chatbox from  $data[customername]");
            });
            
       return response()->json($messages);
    }
    
    public function notification(){
        $notification = CustomerNotification::where(['customer_id'=>Auth::guard('customer')->user()->id])->latest()->get();
        $unreadnotify = CustomerNotification::where(['status'=>'unread','customer_id'=>Auth::guard('customer')->user()->id])->get();
        return response()->json(['status' => 'success','notification'=>$notification,'unreadnotify'=>$unreadnotify]);
    }
    public function unreadmessage(){
        $unreadmessage = Message::where(['customer_id'=>Auth::guard('customer')->user()->id,'sender'=>'admin','status'=>'unread'])->whereNotNull('order_id')->with('user','order')->latest()->limit(10)->get();
        return response()->json(['status' => 'success','unreadmessage'=>$unreadmessage]);
    }
    public function unreasms_count(){
        $unreadmessage = Message::where(['customer_id'=>Auth::guard('customer')->user()->id,'sender'=>'admin','status'=>'unread'])->whereNotNull('order_id')->count();
        return response()->json(['status' => 'success','unreadmessage'=>$unreadmessage]);
    }
    public function unreadsupport(){
        $unreadsupport = Message::where(['customer_id'=>Auth::guard('customer')->user()->id,'sender'=>'admin','status'=>'unread'])->whereNull('order_id')->count();
        return response()->json(['status' => 'success','unreadsupport'=>$unreadsupport]);
    }
     public function customercomment(Request $request){

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'comment' => 'required',
        ]);
   
        $comment                = new Comment();
        $comment->name          = $request->name;
        $comment->email         = $request->email;
        $comment->website       = $request->website;
        $comment->blog_id       = $request->blog_id;
        $comment->customer_id   = Auth::guard('customer')->user()->id;
        $comment->comment       = $request->comment;
        $comment->status        = 0;
        $comment->save();

       $comments = Comment::where('blog_id',$request->blog_id)->with('customer')->get();
       return response()->json(['status'=>'success','comments'=>$comments]);
    }
    
    public function couponapply(Request $request)
    {
        $findcoupon = Couponcode::where('couponcode', $request->couponcode)->first();
        if ($findcoupon == null) {
            return response()->json(['status' => 'invalid', 'message' => 'Opps! Your enter coupon code not valid']);
        } else {
            $cartamount = $request->cartamount;
            $currentdata = date('Y-m-d');
            $expairdate = $findcoupon->expairdate;
            if ($currentdata <= $expairdate) {
                $cartamount = getallheaders()['cartamount'];
                if ($cartamount >= $findcoupon->buyammount) {
                    if ($cartamount >= $findcoupon->buyammount) {
                        if ($findcoupon->offertype == 1) {
                            $discountammount = ($cartamount * $findcoupon->amount) / 100;
                            return response()->json(['status' => 'success', 'message' => 'Success! Your coupon code accepted', 'amount' => $discountammount, 'couponcode' => $findcoupon->couponcode]);
                        } else {
                            $discountammount = $findcoupon->amount;
                            return response()->json(['status' => 'success', 'message' => 'Success! Your coupon code accepted', 'amount' => $discountammount, 'couponcode' => $findcoupon->couponcode]);
                        }
                    }
                } else {
                    return response()->json(['status' => 'lowamount', 'message' => 'Opps!  Your total shopping amount not available for offer']);
                }
            } else {
                return response()->json(['status' => 'expaire', 'message' => 'Opps! Sorry your promo code date expaire']);
            }
        }
    }
    
    public function ordeview($order_id){
        $orderinfo = Order::where(['id'=>$order_id,'customer_id'=>Auth::guard('customer')->user()->id])->select('id','customer_id','order_id','package_name','order_status','total','delivery_date')->with('ordertype')->with('customer')->first();
        $setting = Generalsetting::select('id','name','dark_logo')->first();
        return response()->json(['status' => 'success', 'setting' => $setting,'orderinfo'=>$orderinfo]);
    }
    
    public function contact(Request $request)
    {
  
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'company' => 'required',
            'deadline' => 'required',
            'package' => 'required',
            'budget' => 'required',
            'summary' => 'required',
           
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>'validationfail',
                'errors'=>'validation_error',
                'message'=>$validator->errors()
            ]);
        }
        

        if ($validator->fails()) {
            return response()->json(
                [
                    "error" => 'validation_error',
                    "message" => $validator->errors(),
                ],
                200
            );
        }


         
                $data = $request->all();
                $send = Mail::send('frontEnd.emails.contact', $data, function($textmsg) use ($data){
                  $textmsg->to('info@extremeranks.com');
                  $textmsg->subject('Customer project estimate email');
                });
            

        return response()->json(['status' => 'success', 'message' => 'Message send successfully']);
    }
    
    
    

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' =>
                $this->guard()
                    ->factory()
                    ->getTTL() *60 * 24 *365,
        ]);
    }
    public function guard()
    {
        return Auth::guard('customer');
    }
    
    



}
