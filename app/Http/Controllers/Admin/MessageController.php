<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Models\AdminNotification;
use App\Models\Customer;
use App\Events\SendMessage;
use Carbon\Carbon;
use Toastr;
use Auth;
class MessageController extends Controller
{

    public function chat($id){
        $customer_id = $id;
        return view('chat',compact('customer_id'));
    }
    public function support_list(Request $request){ 
        $customers = Customer::select('customers.*')
        ->leftJoin('messages', 'customers.id', '=', 'messages.customer_id')
        ->selectRaw('MAX(messages.created_at) as last_message_sent')
        ->groupBy('customers.id')
        ->orderByDesc('last_message_sent')
        ->withCount('unreadmessages')
        ->get();
        return view('backEnd.message.support_list',compact('customers'));
    }
    public function support_chat(Request $request){ 
        $customers = Customer::select('customers.*')
        ->leftJoin('messages', 'customers.id', '=', 'messages.customer_id')
        ->selectRaw('MAX(messages.created_at) as last_message_sent')
        ->groupBy('customers.id')
        ->orderByDesc('last_message_sent')
        ->withCount('unreadmessages')
        ->get();
        $customerInfo = Customer::find($request->customer_id);
        $messages = Message::where(['customer_id'=>$request->customer_id])->whereNull('order_id')->with('user')->get();
        Message::where(['customer_id'=>$request->customer_id,'status'=>'unread','sender'=>'customer'])->whereNull('order_id')->with('user')->update(['status'=>'read']);
        $lastSeen = Message::where(['customer_id'=>$customerInfo->id])->latest()->first();
        $last_seen = Carbon::parse($lastSeen?$lastSeen->created_at:'')->diffForHumans();
        return view('backEnd.message.support_chat',compact('customerInfo','messages','customers','last_seen'));
    }
    public function messages(Request $request){ 
        if($request->order_id !=0){
            $messages = Message::where('order_id',$request->order_id)->with('user')->get();
            Message::where(['order_id'=>$request->order_id,'sender'=>'customer','status'=>'unread','customer_id'=>$request->customer_id])->with('user')->update(['status'=>'read']);
        }else{
           $messages = Message::where(['customer_id'=>$request->customer_id])->whereNull('order_id')->with('user')->get();
           Message::where(['customer_id'=>$request->customer_id,'sender'=>'customer','status'=>'unread'])->whereNull('order_id')->with('user')->update(['status'=>'read']); 
        }
        return view('backEnd.message.chat',compact('messages'));
    }
    public function message_send(Request $request){
        
        $user = Auth::user();
        
        $file = $request->file('file');
        if($file){
            $file_name = $file->getClientOriginalName();
        	$name = time().'-'.$file->getClientOriginalName();
        	$uploadPath = 'public/uploads/message/';
        	$file->move($uploadPath,$name);
        	$fileUrl =$uploadPath.$name;
        }else{
          $file_name = null;  
          $fileUrl = null;  
        }
    	
        $messages = new Message;
        $messages->admin_id = $user->id;
        $messages->message = $request->message;
        $messages->order_id = $request->order_id;
        $messages->customer_id = $request->customer_id;
        $messages->file   = $fileUrl;
        $messages->file_name   = $file_name;
        $messages->sender = 'admin';
        $messages->status = 'unread';
        $messages->save();

        // broadcast(new SendMessage($user, $messages))->toOthers();

        $messages = Message::where(['order_id'=>$request->order_id,'customer_id'=> $request->customer_id])->with('user')->get();
        return response()->json($messages);
    }
    
    public function unread_support(Request $request){ 
        $unreadsupport = Message::where(['sender'=>'customer','status'=>'unread'])->whereNull('order_id')->with('customer')->count();
        return response()->json(['unreadsupport'=>$unreadsupport]);
    }
    public function unread_message(){ 
           $asignallnotifications = AdminNotification::where('user_id', auth()->user()->id)->latest()->get();
           $asignunreadnotifications = AdminNotification::where('user_id', auth()->user()->id)->where(['status'=>'unread'])->latest()->get();
           $asignureadmessage = Message::where(['sender'=>'customer','status'=>'unread','admin_id'=>auth()->user()->id])->with('customer')->latest()->limit(10)->get();
           $allnotifications = AdminNotification::latest()->get();
           $unreadnotifications = AdminNotification::where(['status'=>'unread'])->latest()->get(); 
           $ureadmessage = Message::where(['sender'=>'customer','status'=>'unread'])->whereNotNull('order_id')->with('customer')->latest()->limit(10)->get();
           $data = 'success';
        //   $ureadmessage = Message::whereIn('id', function ($query) {
        //                 $query->select(DB::raw('MAX(id)'))
        //                     ->from('messages')
        //                     ->where('sender', 'customer')
        //                     ->where('status', 'unread')
        //                     ->whereNotNull('order_id')
        //                     ->groupBy('customer_id');
        //             })->with('customer')->latest()->limit(10)->get();
           return view('backEnd.message.unread_message',compact('data','allnotifications','unreadnotifications','ureadmessage','asignallnotifications','asignunreadnotifications','asignureadmessage'));
    }
    public function sidebar_message(){ 
           $asignallnotifications = AdminNotification::where('user_id', auth()->user()->id)->latest()->get();
           $allnotifications = AdminNotification::latest()->get();
           $data = 'success';
           return view('backEnd.message.sidebar_message',compact('data','allnotifications','asignallnotifications'));
    }
    public function unread_supportmsg(){ 
           $customers = Customer::select('customers.*')
            ->leftJoin('messages', 'customers.id', '=', 'messages.customer_id')
            ->selectRaw('MAX(messages.created_at) as last_message_sent')
            ->groupBy('customers.id')
            ->orderByDesc('last_message_sent')
            ->withCount('unreadmessages')
            ->get();
           $data = 'success';
           return view('backEnd.message.unread_supportmsg',compact('data','customers'));
    }
    
}
