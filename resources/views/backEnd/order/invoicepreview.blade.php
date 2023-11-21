<style>
    .bodyoverflow{
        overflow-y: hidden;
    }
    .pbutton-group {
        position: absolute;
        top: 25px;
        right: -160px;
    }
    .back_invoice {
        background: #D9D9D9;
        border-radius: 5px;
        color: #222;
        padding: 10px 0px;
        margin-top: 5px;
        cursor: pointer;
        display: block;
        text-align: center;
    }
</style>
<div class="row cust_col_p">
    <div class="col-sm-12">
        <div class="card cust_card">
            <div class="card_head card_p">
            <div class="card_top">
                <div class="card_head_widget">
                    <p class="head_t" style="text-align:left">Order Invoice</p>
                </div>
            </div>
           </div>
            <div class="card-body">
               <div class="invoice_inner" style="padding:20px 20px;overflow: hidden">
                   <div class="billing_form" style="width:50%;float: left;text-align: left;">
                       <h4>Billing From</h4>
                       <img src="{{asset($generalsetting->white_logo)}}" style="margin:10px 0;width:150px" alt="">
                       <div class="billing_info">
                           <p style="margin:5px 0;">{{$data['bemail']}}</p>
                           <p style="margin:5px 0;">{{$data['baddress']}}</p>
                           <p style="margin:5px 0;">{{$data['bdelivery']}}</p>
                       </div>
                   </div>
                   <div class="billing_to"  style="width:50%;float: left;text-align: left;">
                        <h4>Invoice No :  #{{Session::get('invoice_id')}}</h4>
                        <h4>Billing To</h4>
                       <div class="billing_info">
                           <p style="margin:5px 0;">{{$data['company']}}</p>
                           <p style="margin:5px 0;">{{$data['email']}}</p>
                           <p style="margin:5px 0;">{{$data['address']}}</p>
                           <p style="margin:5px 0;">{{$data['delivery']}}</p>
                       </div>
                   </div>
               </div>
               <!-- invoice_inner end -->
               <div class="service-info" style="padding:20px;padding-top:0;overflow: hidden;">
                   <table style="width: 100%;border:1px solid #ddd">
                       <thead>
                           <tr style="width:100%">
                               <td style="width:20%;float:left;padding:10px;background: #F3F5FA;">Service Name</td>
                               <td style="width:15%;float:left;padding:10px;background: #F3F5FA;">Produt ID</td>
                               <td style="width:25%;float:left;padding:10px;background: #F3F5FA;">Services</td>
                               <td style="width:25%;float:left;padding:10px;background: #F3F5FA;">Attribute</td>
                               <td style="width:15%;float:left;padding:10px;background: #F3F5FA;">Amount</td>
                           </tr>
                       </thead>
                       <tbody>
                        @foreach($data['service_name'] as $key=>$value)
                           <tr>
                               <td  style="width:20%;float:left;padding:10px">{{$value}}</td>
                               <td  style="width:15%;float:left;padding:10px">#{{$data['product_id'][$key]}}</td>
                               <td  style="width:25%;float:left;padding:10px">{{$data['service'][$key]}}</td>
                               <td  style="width:25%;float:left;padding:10px">{{$data['attribute'][$key]}}</td>
                               <td  style="width:15%;float:left;padding:10px">${{$data['amount'][$key]}}</td>
                           </tr>
                           @endforeach
                       </tbody>
                   </table>
               </div>
               <div class="invoice_summary"  style="padding:20px;padding-top:0;overflow: hidden;">    
                    <div class="invoice_text" style="width:45%;margin-right:5%;float:left">
                        <p>{{$data['note']}}</p>
                    </div>
                    @php
                        $subtotal = Session::get('subtotal');
                        $tax = Session::get('tax')?Session::get('tax'):0;
                        $discount = Session::get('discount')?Session::get('discount'):0;
                    @endphp
                    <div class="invoice_overview" style="width:50%;float:left">
                        <table style="width: 100%;"> 
                            <tbody> 
                                <tr style="width:100%">
                                    <td style="width:50%;float:left;background:#F3F5FA;padding:10px;text-align: left;">Subtotal</td>
                                    <td style="width:50%;float:left;text-align: right;background:#F3F5FA;padding:10px;color:#FF4444">${{$subtotal}}</td>
                                </tr>
                                <tr>
                                    <td style="width:30%;float:left;padding:8px;background:#F9FAFD;text-align: left">Discount</td>
                                    <td style="width:20%;float:left;text-align: right;padding:8px;background:#F9FAFD;">:</td>
                                    <td style="width:50%;float:left;text-align: right;padding:8px;background:#F9FAFD;color:#1DBF73">${{$discount}}</td>
                                </tr>
                                <tr>
                                    <td style="width:30%;float:left;padding:8px;background:#F9FAFD;text-align: left">Tax</td>
                                    <td style="width:20%;float:left;text-align: right;padding:8px;background:#F9FAFD">:</td>
                                    <td style="width:50%;float:left;text-align: right;padding:8px;background:#F9FAFD">${{Session::get('tax')}}</td>
                                </tr>
                                <tr>
                                    <td style="width:30%;float:left;padding:8px;background:#F9FAFD;text-align: left">Payable</td>
                                    <td style="width:20%;float:left;text-align: right;padding:8px;background:#F9FAFD">:</td>
                                    <td style="width:50%;float:left;text-align: right;padding:8px;background:#F9FAFD;color:#FF4444">${{($subtotal+Session::get('tax')) - Session::get('discount')}}</td>
                                </tr>
                            </tbody>    
                        </table>    
                    </div>
               </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
         <div class="pbutton-group">
            <button class="send_now" style=" background: linear-gradient(138.15deg, #00C0F4 0%, #256EFE 91.11%);border: 0;color: #fff;padding: 10px 20px;border-radius: 5px;display: block;margin-bottom: 5px;margin-top: 8px;" name="status" value="2">Send Now</button>
            <button class="draft_save" style=" background: linear-gradient(133.68deg, #FFA301 5.17%, #FF4444 94.13%);border: 0;color: #fff;padding: 10px 20px;border-radius: 5px;" name="status" value="1">Save as a Draft</button>
            <a class="back_invoice">Back To Invoice</a>
      
    </div>
    </div><!-- end col-->
   
   </div>

   <script src="{{asset('public/backEnd/')}}/assets/js/head.js"></script>
   <script>
     $(".back_invoice").click(function () {
          $('.invoice_preview').hide();
          $('body').removeClass('bodyoverflow');
        });
   </script>