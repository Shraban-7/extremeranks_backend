@extends('backEnd.layouts.master')
@section('title','Order Invoice')
@section('content')
<div class="container-fluid">
   <div class="row cust_col_p">
    <div class="col-sm-12">
        <div class="card cust_card">
            <div class="card_head card_p">
            <div class="card_top">
                <div class="card_head_widget">
                    <p class="head_t">Order Invoice</p>
                </div>
                <div class="card_head_widget text_right">
                    <a href="{{url('client/invoice/'.$orderInfo->rand_id)}}" id="copyLink">Copy Link</a>

                </div>
            </div>
           </div>
            <div class="card-body">
               <div class="invoice_inner" style="padding:30px;;overflow: hidden">
                   <div class="billing_form" style="width:65%;float: left;">
                       <h4>Billing From</h4>
                       <img src="{{asset($generalsetting->white_logo)}}" style="margin:10px 0;width:150px" alt="">
                       <div class="billing_info">
                           <p style="margin:5px 0;">{{$generalsetting->email}}</p>
                           <p style="margin:5px 0;">{{$generalsetting->address}}</p>
                           <p style="margin:5px 0;">{{ date('d M,y h:i A', strtotime($orderInfo->order_create))}}</p>
                       </div>
                   </div>
                   <div class="billing_to"  style="width:35%;float: left;">
                        <h4>Invoice No :  #{{$orderInfo->order_id}}</h4>
                        <h4>Billing From</h4>
                       <div class="billing_info">
                           <p style="margin:5px 0;">{{$shippingInfo->fname}} {{$shippingInfo->lname}}</p>
                           <p style="margin:5px 0;">{{$shippingInfo->email}} </p>
                           <p style="margin:5px 0;">{{$shippingInfo->housenumber}} {{$shippingInfo?$shippingInfo->apartment:''}} {{$shippingInfo->state?$shippingInfo->state->statename:''}}  {{$shippingInfo->city?$shippingInfo->city:''}} {{$shippingInfo?$shippingInfo->zipcode:''}} {{$shippingInfo->country?$shippingInfo->country->nicename:''}}</p>
                           <p style="margin:5px 0;">{{ date('d M,y h:i A', strtotime($orderInfo->created_at))}}</p>
                       </div>
                   </div>
               </div>
               <!-- invoice_inner end -->
               <div class="service-info" style="padding:30px;overflow: hidden;">
                   @if($orderInfo->order_type == 1)
                   <table style="width: 100%;border:1px solid #ddd">
                       <thead>
                           <tr style="width:100%">
                               <td style="width:30%;float:left;padding:10px;background: #F3F5FA;">Name Of Service</td>
                               <td style="width:20%;float:left;padding:10px;background: #F3F5FA;">Product ID</td>
                               <td style="width:30%;float:left;padding:10px;background: #F3F5FA;">Client Name</td>
                               <td style="width:20%;float:left;padding:10px;background: #F3F5FA;">Amount</td>
                           </tr>
                       </thead>
                       <tbody>
                        @foreach($orderDetails as $key=>$value)
                           <tr style="width:100%">
                               <td style="width:30%;float:left;padding:10px">{{$value->package_name}}</td>
                               <td style="width:20%;float:left;padding:10px">#{{$value->product_id?$value->product_id:$value->package_id}}</td>
                               <td style="width:30%;float:left;padding:10px">{{$value->client_name}}</td>
                               <td style="width:20%;float:left;padding:10px">${{$value->price}}</td>
                           </tr>
                        @endforeach
                       </tbody>
                   </table>
                   @else
                   <table style="width: 100%;border:1px solid #ddd">
                       <thead>
                           <tr style="width:100%">
                               <td style="width:25%;float:left;padding:10px;background: #F3F5FA;">Service Name</td>
                               <td style="width:20%;float:left;padding:10px;background: #F3F5FA;">Produt ID</td>
                               <!--<td style="width:20%;float:left;padding:10px;background: #F3F5FA;">Client Name</td>-->
                               <td style="width:20%;float:left;padding:10px;background: #F3F5FA;">Service Attribute</td>
                               <td style="width:20%;float:left;padding:10px;background: #F3F5FA;">Attribute Num</td>
                               <td style="width:15%;float:left;padding:10px;background: #F3F5FA;">Amount</td>
                           </tr>
                       </thead>
                       <tbody>
                        @foreach($orderDetails as $key=>$value)
                           <tr style="width:100%">
                               <td style="width:25%;float:left;padding:10px">{{$value->package_name}}</td>
                               <td style="width:20%;float:left;padding:10px">#{{$value->product_id?$value->product_id:$value->package_id}}</td>
                               <!--<td style="width:20%;float:left;padding:10px">#{{$value->client_name}}</td>-->
                               <td style="width:20%;float:left;padding:10px">#{{$value->service_attribute}}</td>
                               <td style="width:20%;float:left;padding:10px">#{{$value->attribute_number}}</td>
                               <td style="width:15%;float:left;padding:10px">${{$value->price}}</td>
                           </tr>
                        @endforeach
                       </tbody>
                   </table>
                   @endif
               </div>
               <div class="invoice_summary"  style="padding:30px;overflow: hidden;">    
                <div class="invoice_text" style="width:45%;margin-right:5%;float:left">
                        <p> {{($shippingInfo->note)}}</p>
                    </div>
                    <div class="invoice_overview" style="width:50%;float:left">
                        <table style="width: 100%;"> 
                            <tbody> 
                                <tr style="width:100%">
                                    <td style="width:50%;float:left;background:#F3F5FA;padding:10px">Subtotal</td>
                                    <td style="width:50%;float:left;text-align: right;background:#F3F5FA;padding:10px;color:#FF4444">${{($orderInfo->total+$orderInfo->discount)-$orderInfo->tax}}</td>
                                </tr>
                                <tr>
                                    <td style="width:30%;float:left;padding:8px;background:#F9FAFD">Discount</td>
                                    <td style="width:20%;float:left;text-align: right;padding:8px;background:#F9FAFD">:</td>
                                    <td style="width:50%;float:left;text-align: right;padding:8px;background:#F9FAFD;color:#1DBF73">${{$orderInfo->discount}}</td>
                                </tr>
                                <tr>
                                    <td style="width:30%;float:left;padding:8px;background:#F9FAFD">Tax</td>
                                    <td style="width:20%;float:left;text-align: right;padding:8px;background:#F9FAFD">:</td>
                                    <td style="width:50%;float:left;text-align: right;padding:8px;background:#F9FAFD">${{$orderInfo->tax}}</td>
                                </tr>
                                <tr>
                                    <td style="width:30%;float:left;padding:8px;background:#F9FAFD">Payable</td>
                                    <td style="width:20%;float:left;text-align: right;padding:8px;background:#F9FAFD">:</td>
                                    <td style="width:50%;float:left;text-align: right;padding:8px;background:#F9FAFD;color:#FF4444">${{$orderInfo->total}}</td>
                                </tr>
                            </tbody>    
                        </table>    
                    </div>
               </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
   </div>
</div>
@endsection
@section('script')
<script>
$(document).ready(function() {
  $('#copyLink').click(function(e) {
    e.preventDefault();
    var link = $(this).attr('href');
    copyToClipboard(link);
    swal({
        title: `Link copied successfully!`,
        icon: "success",
        buttons: true,
        dangerMode: false,
    })
  });

  function copyToClipboard(text) {
    var tempInput = $('<input>');
    $('body').append(tempInput);
    tempInput.val(text).select();
    document.execCommand('copy');
    tempInput.remove();
  }
});
</script>
@endsection