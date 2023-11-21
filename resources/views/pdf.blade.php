<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body {
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
       <div class="row">
        <div class="col-sm-12">
            <div class="card cust_card;" style="padding: 20px ">
                <table class="table" width="100%">
                    <tbody>
                        <tr style="width:100%;padding:20px;;overflow: hidden">
                            <td style="width:60%;float: left;">
                                <h3 class="">Billing From</h3>
                                <img src="{{asset($generalsetting->white_logo)}}" style="margin:10px 0;width:150px" alt="">
                               <div class="billing_info">
                                   <p style="margin:5px 0;color:#444">{{$generalsetting->email}}</p>
                                   <p style="margin:5px 0;color:#444">{{$generalsetting->address}}</p>
                                   <p style="margin:5px 0;color:#444">{{ date('d M,y h:i A', strtotime($orderInfo->order_create))}}</p>
                               </div>
                            </td>
                            <td  style="width:40%;float: left;">
                                <h3 class="">Invoice No :  #{{$orderInfo->order_id}}</h3>
                                <h3>Billing From</h3>
                               <div class="billing_info">
                                   <p style="margin:5px 0;color:#444">{{$shippingInfo->fname}} {{$shippingInfo->lname}}</p>
                                   <p style="margin:5px 0;color:#444">{{$shippingInfo->email}} </p>
                                   <p style="margin:5px 0;color:#444">{{$shippingInfo->housenumber}} {{$shippingInfo?$shippingInfo->apartment:''}} {{$shippingInfo->state?$shippingInfo->state->statename:''}}  {{$shippingInfo->city?$shippingInfo->city:''}} {{$shippingInfo?$shippingInfo->zipcode:''}} {{$shippingInfo->country?$shippingInfo->country->nicename:''}}</p>
                                   <p style="margin:5px 0;color:#444">{{ date('d M,y h:i A', strtotime($orderInfo->created_at))}}</p>
                               </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                 @if($orderInfo->order_type == 1)
                   <table style="width: 100%;border:1px solid #ddd">
                       <thead>
                           <tr style="width:100%">
                               <td style="width:30%;float:left;padding:10px;background: #F3F5FA;"><b>Name Of Service</b></td>
                               <td style="width:20%;float:left;padding:10px;background: #F3F5FA;"><b>Product ID</b></td>
                               <td style="width:30%;float:left;padding:10px;background: #F3F5FA;"><b>Package Name</b></td>
                               <td style="width:20%;float:left;padding:10px;background: #F3F5FA;"><b>Amount</b></td>
                           </tr>
                       </thead>
                       <tbody>
                        @foreach($orderDetails as $key=>$value)
                           <tr style="width:100%">
                               <td style="width:30%;float:left;padding:10px">{{$value->category->category_name}}</td>
                               <td style="width:20%;float:left;padding:10px">#{{$value->product_id?$value->product_id:$value->package_id}}</td>
                               <td style="width:30%;float:left;padding:10px">{{$value->package_name}}</td>
                               <td style="width:20%;float:left;padding:10px">${{$value->price}}</td>
                           </tr>
                        @endforeach
                       </tbody>
                   </table>
                   <table style="width: 100%;border:1px solid #ddd;margin-top:20px;">
                       <thead>
                           <tr style="width:100%">
                               <td style="width:47%;float:left;padding:10px 10px;background: #F3F5FA;"><b>Packege Details</b></td>
                               <td style="width:47%;float:left;padding:10px 10px;background: #F3F5FA;"><b>Value</b></td>
                           </tr>
                       </thead>
                       <tbody>
                        @foreach($orderattribute as $key=>$value)
                           <tr style="width:100%">
                               <td style="width:47%;float:left;padding:10px 10px">{{$value->title}}</td>
                               <td style="width:47%;float:left;padding:10px 10px">{{$value->value}}</td>
                           </tr>
                        @endforeach
                       </tbody>
                   </table>
                   @else
                   <table style="width: 100%;border:1px solid #ddd">
                       <thead>
                           <tr style="width:100%">
                               <td style="width:25%;float:left;padding:10px;background: #F3F5FA;"><b>Service Name</b></td>
                               <td style="width:20%;float:left;padding:10px;background: #F3F5FA;"><b>Produt ID</b></td>
                               <td style="width:20%;float:left;padding:10px;background: #F3F5FA;"><b>Service Attribute</b></td>
                               <td style="width:20%;float:left;padding:10px;background: #F3F5FA;"><b>Attribute Num</b></td>
                               <td style="width:15%;float:left;padding:10px;background: #F3F5FA;"><b>Amount</b></td>
                           </tr>
                       </thead>
                       <tbody>
                        @foreach($orderDetails as $key=>$value)
                           <tr style="width:100%">
                               <td style="width:25%;float:left;padding:10px">{{$value->package_name}}</td>
                               <td style="width:20%;float:left;padding:10px">#{{$value->product_id?$value->product_id:$value->package_id}}</td>
                               <td style="width:20%;float:left;padding:10px">#{{$value->service_attribute}}</td>
                               <td style="width:20%;float:left;padding:10px">#{{$value->attribute_number}}</td>
                               <td style="width:15%;float:left;padding:10px">${{$value->price}}</td>
                           </tr>
                        @endforeach
                       </tbody>
                   </table>
                   @endif
                <table style="width: 50%;float: right;"> 
                    <tbody> 
                        <tr>
                            <td style="width:30%;float:left;padding:8px;background:#F9FAFD">Subtotal</td>
                            <td style="width:20%;float:left;text-align: center;padding:8px;background:#F9FAFD">:</td>
                            <td style="width:50%;float:left;text-align: right;padding:8px;background:#F9FAFD;color:#1DBF73"><b>${{($orderInfo->total+$orderInfo->discount)-$orderInfo->tax}}</b></td>
                        </tr>
                        <tr>
                            <td style="width:30%;float:left;padding:8px;background:#F9FAFD">Discount</td>
                            <td style="width:20%;float:left;text-align: center;padding:8px;background:#F9FAFD">:</td>
                            <td style="width:50%;float:left;text-align: right;padding:8px;background:#F9FAFD;color:#1DBF73">${{$orderInfo->discount}}</td>
                        </tr>
                        <tr>
                            <td style="width:30%;float:left;padding:8px;background:#F9FAFD">Tax</td>
                            <td style="width:20%;float:left;text-align: center;padding:8px;background:#F9FAFD">:</td>
                            <td style="width:50%;float:left;text-align: right;padding:8px;background:#F9FAFD">${{$orderInfo->tax}}</td>
                        </tr>
                        <tr>
                            <td style="width:30%;float:left;padding:8px;background:#F9FAFD">Payable</td>
                            <td style="width:20%;float:left;text-align: center;padding:8px;background:#F9FAFD">:</td>
                            <td style="width:50%;float:left;text-align: right;padding:8px;background:#F9FAFD;color:#FF4444"><b>${{$orderInfo->total}}</b></td>
                        </tr>
                    </tbody>    
                </table>
            </div>
        </div><!-- end col-->
       </div>
    </div>
</body>
</html>