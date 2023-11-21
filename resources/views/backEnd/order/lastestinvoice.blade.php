@extends('backEnd.layouts.master')
@section('title','Order Manage')
@section('content')
<div class="container-fluid">
   <div class="row">
    <div class="col-12">
        <div class="card cust_card">
            <div class="card_head">
                <div class="card_top">
                    <div class="card_head_widget">
                        <p>Latest Invoice</p>
                    </div>
                    <div class="card_head_widget text_right">
                        
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive-sm">
                <table class="table dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <td>Invoice Name</td>
                            <td>Invoice ID</td>
                            <td>Date</td>
                            <td>Client</td>
                            <td>Amount</td>
                            <td style="width:130px">Status</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                
                
                    <tbody>
                        @foreach($show_data as $key=>$value)
                        <tr>
                            <td>{{$value->package_name}}</td>
                            <td>{{$value->order_id}}</td>
                            <td>{{ date('d-m-y', strtotime($value->delivery_date))}}</td>
                            <td>{{$value->customer?$value->customer->fullName:''}}</td>
                            <td> ${{$value->total}}</td>

                            <td><p class="pay_status {{$value->payment?$value->payment->payment_status:''}}" ><span></span>{{$value->payment?$value->payment->payment_status:''}} </p></td>
                            <td>
                                <div class="dot_dropdown_area">
                                <a class="anchor"  data-bs-toggle="collapse" href="#collapseExample{{$key}}">
                                    <i class="fa fa-ellipsis-v dot_dropdown"></i>
                                </a>
                                <ul class="order_drop collapse order_collapse" id="collapseExample{{$key}}">
                                    @if($value->order_status < 4)
                                   <li>
                                       <form method="POST" action="{{route('order.payment_reminder')}}">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{$value->id}}">
                                        <button type="submit" class="payment_reminder">Payment Reminder</button>
                                    </form>
                                   </li>
                                   @endif
                                   
                                   <li><a href="{{url('admin/order/details/'.$value->id)}}">Chat With Client</a>
                                   </li>
                                   <li>
                                    <form method="POST" action="{{route('order.delete')}}">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{$value->id}}">
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

