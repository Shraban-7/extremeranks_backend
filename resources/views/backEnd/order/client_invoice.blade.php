<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />

        <title>@yield('title') - {{$generalsetting->name}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset($generalsetting->favicon)}}" />
        <!-- Bootstrap css -->
        <link href="{{asset('public/backEnd/')}}/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{asset('public/backEnd/')}}/assets/css/toastr.min.css" />   <style>
            .invoice_body {
                position: relative;
                font-family:'Poppins', sans-serif;
            }
            .pay_now,.pay_now:hover {
                background: #6658DD;
                color: #fff;
                position: relative;
                /* top: -20px;
                right: -120px;*/
                padding: 25px 100px;
                font-weight: 600;
                border-radius: 4px;
                text-decoration: none;
                font-size:28px;
            }
        </style>
    </head>

    <!-- body start -->
    <body style="background:#fff">
            <div style="width:760px;margin:0 auto;" class="invoice_body">
               <div class="row cust_col_p">
                    <div class="col-sm-12">
                        <div class="card cust_card" style="border: 1px solid #E8E8E8; margin-top: 30px; margin-bottom: 30px;padding-bottom: 0;padding: 0;">
                            <div class="card_head card_p" style="background: #F3F5FA;">
                                <div class="card_top">
                                    <div class="card_head_widget">
                                        <p class="head_t" style=" font-size: 18px; text-transform: uppercase; color: #606060; font-weight: 500; line-height: 16px; margin-bottom: 0;padding: 15px 10px;margin-top:0 !important">Order Invoice</p>
                                    </div>
                                    <div class="card_head_widget text_right"></div>
                                </div>
                            </div>
                            <div class="card-body">
                               <div class="invoice_inner" style="padding:30px;;overflow: hidden">
                                   <div class="billing_form" style="width:55%;float: left;">
                                       <h4>Billing From</h4>
                                       <img src="{{asset($generalsetting->white_logo)}}" style="margin:10px 0;width:150px" alt="">
                                       <div class="billing_info">
                                           <p style="margin:5px 0;">{{$generalsetting->email}}</p>
                                           <p style="margin:5px 0;">{{$generalsetting->address}}</p>
                                           <p style="margin:5px 0;">{{ date('d M,y h:i A', strtotime($orderInfo->order_create))}}</p>
                                       </div>
                                   </div>
                                   <div class="billing_to"  style="width:45%;float: left;">
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
                                               <td style="width:29%;float:left;padding:10px;background: #F3F5FA;"><b>Name Of Service</b></b></td>
                                               <td style="width:15%;float:left;padding:10px;background: #F3F5FA;"><b>Product ID</b></td>
                                               <td style="width:29%;float:left;padding:10px;background: #F3F5FA;"><b>Package Name</b></td-->
                                               <td style="width:15%;float:left;padding:10px;background: #F3F5FA;"><b>Amount</b></td>
                                           </tr>
                                       </thead>
                                       <tbody>
                                        @foreach($orderDetails as $key=>$value)
                                           <tr style="width:100%">
                                               <td style="width:29%;float:left;padding:10px">{{$value->category->category_name}}</td>
                                               <td style="width:15%;float:left;padding:10px">#{{$value->product_id?$value->product_id:$value->package_id}}</td>
                                               <td style="width:29%;float:left;padding:10px">{{$value->package_name}}</td>
                                               <td style="width:15%;float:left;padding:10px">${{$value->price}}</td>
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
                                               <td style="width:15%;float:left;padding:10px;background: #F3F5FA;"><b>Produt ID</b></td>
                                               <td style="width:20%;float:left;padding:10px;background: #F3F5FA;"><b>Service Attribute</b></td>
                                               <td style="width:15%;float:left;padding:10px;background: #F3F5FA;"><b>Value</b></td>
                                               <td style="width:10%;float:left;padding:10px;background: #F3F5FA;"><b>Amount</b></td>
                                           </tr>
                                       </thead>
                                       <tbody>
                                        @foreach($orderDetails as $key=>$value)
                                           <tr style="width:100%">
                                               <td style="width:25%;float:left;padding:10px">{{$value->package_name}}</td>
                                               <td style="width:15%;float:left;padding:10px">#{{$value->product_id?$value->product_id:$value->package_id}}</td>
                                               <td style="width:20%;float:left;padding:10px">#{{$value->service_attribute}}</td>
                                               <td style="width:15%;float:left;padding:10px">#{{$value->attribute_number}}</td>
                                               <td style="width:10%;float:left;padding:10px">${{$value->price}}</td>
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
                                                    <td style="width:45%;float:left;background:#F3F5FA;padding:10px">Subtotal</td>
                                                    <td style="width:43%;float:left;text-align: right;background:#F3F5FA;padding:10px;color:#FF4444"><b>${{($orderInfo->total+$orderInfo->discount)-$orderInfo->tax}}</b></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:25%;float:left;padding:8px;background:#F9FAFD">Discount</td>
                                                    <td style="width:20%;float:left;text-align: right;padding:8px;background:#F9FAFD">:</td>
                                                    <td style="width:41%;float:left;text-align: right;padding:8px;background:#F9FAFD;color:#1DBF73">${{$orderInfo->discount}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="width:25%;float:left;padding:8px;background:#F9FAFD">Tax</td>
                                                    <td style="width:20%;float:left;text-align: right;padding:8px;background:#F9FAFD">:</td>
                                                    <td style="width:41%;float:left;text-align: right;padding:8px;background:#F9FAFD">${{$orderInfo->tax}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="width:25%;float:left;padding:8px;background:#F9FAFD">Payable</td>
                                                    <td style="width:20%;float:left;text-align: right;padding:8px;background:#F9FAFD">:</td>
                                                    <td style="width:41%;float:left;text-align: right;padding:8px;background:#F9FAFD;color:#FF4444"><b>${{$orderInfo->total}}</b></td>
                                                </tr>
                                            </tbody>    
                                        </table>
                                        
                                    </div>
                               </div>
                                <div style="margin-top:10px;text-align:center;height:70px;"><a href="" class="pay_now">Pay Now</a></div>
                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div><!-- end col-->
                </div>
            </div>
                <!-- Right bar overlay-->
        <!-- Vendor js -->
        <script src="{{asset('public/backEnd/')}}/assets/js/vendor.min.js"></script>
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <!-- App js -->
        <script src="{{asset('public/backEnd/')}}/assets/js/app.min.js"></script>
    </body>
</html>