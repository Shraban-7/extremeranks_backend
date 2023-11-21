@extends('backEnd.layouts.master')
@section('title','Order Manage')
@section('css')
<style>
    .order-table td {
        padding: 10px;
    }
    ul#collapseExample0 button {
    width: 100%;
}
</style>
@endsection
@section('content')
<div class="container-fluid">
   <div class="row">
    <div class="col-12">
        <div class="card cust_card">
            <div class="card_head">
                <div class="card_top">
                    <div class="card_head_widget">
                        <p>Active Orders</p>
                    </div>
                    <div class="card_head_widget text_right">
                        <a href="{{route('createinvoice')}}" class="b_btn">Create</a>
                    </div>
                </div>
            </div>
            <div class="card-body order-table table-responsive-sm">
                <table class="table dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <td>SERVICE/PACKAGE</td>
                            <td>Client</td>
                            <td>Order ID</td>
                            <td>Price</td>
                            <td>Delivery Time</td>
                            <td>Pay Status</td>
                            <td>Status</td>
                            <td></td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($show_data as $key=>$value)
                        <tr>
                            <td>@if($value->orderdetail) <p class="order_client">{{$value->orderdetail->category?$value->orderdetail->category->category_name:'Custom'}}</p> @endif {{$value->package_name}}</td>
                            
                            <td class="cust_info">
                                <img src="{{asset($value->customer?$value->customer->image:'')}}" class="backend-image sm_img" alt="">
                                <p>{{$value->customer?Str::limit($value->customer->fullName,8):''}}</p>
                            </td>
                            <td>
                                <p class="trackId">{{$value->order_id}}</p>
                            </td>
                            </td>
                            <td>
                                <p class="order_price">${{$value->total}}</p>
                            </td>
                            <td>
                                <p class=""><i data-feather="clock" style="width:16px;"></i> {{ \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($value->delivery_date));}} Days Left</p>
                            </td>
                            <td>
                                
                            @if($value->payment->payment_status == 'due')
                            <span class="wsit_customer_order_status" style="background:#FF4444;" >{{$value->payment->payment_status}}</span>
                            @else
                            <span class="wsit_customer_order_status" style="background:#256EFE;" >{{$value->payment->payment_status}}</span>
                            @endif
                            
                            </td>
                            
                            <td><span class="status_badge" style="width:93px; text-align:center; background:{{$value->ordertype?$value->ordertype->color:''}}">{{$value->ordertype?$value->ordertype->name:''}} </span></td>
                            <td>
                                <a href="{{url('admin/order/details/'.$value->id)}}" class="view_more">View</a>
                            </td>
                            <td>
                                <div class="dot_dropdown_area">
                                <a class="anchor"  data-bs-toggle="collapse" href="#collapseExample{{$key}}">
                                    <i class="fa fa-ellipsis-v dot_dropdown"></i>
                                   
                                </a>
                                <ul class="order_drop collapse order_collapse" id="collapseExample{{$key}}">
                                    
                                  @if($value->payment->payment_status != 'paid')
                                   <li>
                                    <form method="POST" action="{{route('order.payment_reminder')}}">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{$value->id}}">
                                        <button type="submit" class="payment_reminder  change-confirm">Payment Reminder</button>
                                    </form>
                                   </li>
                                   @endif
                                   <li>
                                    <form method="POST" action="{{route('order.cancel_reminder')}}">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{$value->id}}">
                                        <button type="submit" class="payment_reminder  change-confirm">Cancel Reminder</button>
                                    </form>
                                   </li>
                                    @if($value->payment->payment_status != 'paid')
                                   <li>
                                       <form action="{{route('order.payment_status')}}" method="POST">
                       
                                           @csrf
                                           <input type="hidden" value="{{$value->payment->id}}" name="id">
                                           <button type="submit" class="change_btn bg-primary">Paid</button>
                                       </form>
                                   </li>
                                   @endif
                                   
                                   @foreach($ordertypes as $ordertype)
                                   
                                   
                                   @if($ordertype->id > $value->order_status)
                                   <li class="">
                                        <form method="POST" action="{{route('order.status_change')}}">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{$value->id}}">
                                            <input type="hidden" name="status" value="{{$ordertype->id}}">
                                            <button type="submit" class="change_btn change-confirm" style="background:{{$ordertype->color}};">{{$ordertype->name}}</button>
                                        </form>
                                   </li>
                                   @endif
                                   @endforeach
                                   
                                   <li>
                                    <a href="{{url('admin/order/invoice/'.$value->id)}}">Invoice View</a>
                                   </li>
                                   @if($value->order_type == 1)
                                   <li>
                                    <a href="{{url('admin/order/attribute/'.$value->id)}}">Order Attribute</a>
                                   </li>
                                   @endif
                                   <li>
                                    <form method="POST" action="{{route('order.delete')}}">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{$value->id}}">
                                        <input type="hidden" name="status" value="{{$ordertype->id}}">
                                        <button type="submit" class="delete_info  delete-confirm">Delete Information</button>
                                    </form>
                                   </li>
                                </ul>
                                </div>
                            </td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
 
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
    
   </div>
   <div class="row">
       <div class="col-sm-12">
           <div class="custom-paginate">
               {{ $show_data->links('pagination::bootstrap-4') }}
           </div>
       </div>
   </div>
</div>
@endsection
