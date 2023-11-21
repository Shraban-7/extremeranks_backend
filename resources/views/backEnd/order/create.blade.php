@extends('backEnd.layouts.master')
@section('title','Create Invoice')
@section('css')
    
    <link href="{{asset('public/backEnd')}}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <style>
        .service-info thead {
            background: #F3F5FA;
        }
        .service-info .table {
            border: 1px solid #F3F5FA;
        }
        .invoice_summary {
            margin-top: 15px;
        }

        .invoice_summary tr td {
            border: none;
        }
        div#cart_package label {
            font-weight: 400;
        }
        .no_hover:hover {
            background: transparent !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection
@section('content')
    @php
        $subtotal = Session::get('subtotal')?Session::get('subtotal'):0;
        $tax = Session::get('tax')?Session::get('tax'):0;
        $discount = Session::get('discount')?Session::get('discount'):0;
    @endphp
    <form action="{{route('invoice_save')}}" class="row cust_col_p" method="POST" enctype="multipart/form-data">
    <div class="container-fluid">
    <div class="row invoice_show">
    <div class="col-sm-3">
        <div class="card cust_card">
            <div class="card_head card_p">
                <div class="card_head_widget">
                    <p class="head_t">Vat & Discount</p>
                </div>
           </div>
            <div class="card-body p-2">
               <div class="form-group mb-1">
                    <label for="tax" class=" mb-1">Tax</label>
                    <input type="text" class="form-control @error('tax') is-invalid @enderror" value="" placeholder="Add Tax(%)" name="tax" value="{{ old('tax') }}" id="tax" required="">
                    @error('tax')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
               <div class="form-group">
                    <label for="discount" class="mb-1">Discount</label>
                    <input type="text" class="form-control @error('discount') is-invalid @enderror"  placeholder="Discount(%)" name="discount" value="{{ old('discount') }}" id="discount" required="">
                    @error('discount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
    <div class="col-sm-9">
        @csrf
        <div class="card cust_card">
            <div class="card_head card_p">
                <div class="card_top">
                    <div class="card_head_widget">
                        <p class="head_t">Create Invoice</p>
                    </div>
                </div>
           </div>
            <div class="card-body p-2">
               <div class="row">
                <div class="col-sm-6">
                    <div class="billing_form">
                       <h4>Billing From</h4>
                       <img src="{{asset($generalsetting->white_logo)}}" style="margin:10px 0;width:150px" alt="">
                       <div class="billing_info">
                           <div class="form-group mb-1">
                                <input type="text" class="pre_bemail form-control @error('invoice_email') is-invalid @enderror" placeholder="Email" name="invoice_email" value="{{$invoicesetting->email}}" id="invoice_email" required="">
                                @error('invoice_email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-1">
                                <input type="text" class="pre_baddress form-control @error('address') is-invalid @enderror" placeholder="Short Address" name="invoice_address" value="{{$invoicesetting->address}}" id="invoice_address" required="">
                                @error('invoice_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="date" placeholder="Invoice Date" value="{{date('Y-m-d')}}" class="custom_date form-control pre_bdelivery" required name="invoice_date">
                                @error('delivery')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                       </div>
                   </div>
                </div>
                <div class="col-sm-6">
                    <div class="billing_form">
                       <h4>Billing To</h4>
                        <div class="form-group mb-1">
                            <input type="text" class="pre_company form-control @error('companyname') is-invalid @enderror" placeholder="Company Name" name="companyname" value="{{ $customerInfo?$customerInfo->fullName:'' }}" id="companyname">
                            @error('companyname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-1">
                            <input type="text" class="pre_email form-control @error('email') is-invalid @enderror" placeholder="Email address" name="email" value="{{ $customerInfo?$customerInfo->email:'' }}" id="email" required="">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-1">
                            <input type="text" class="pre_address form-control @error('address') is-invalid @enderror" placeholder="Short Address" name="address" value="{{ $customerInfo?$customerInfo->address:'' }}" id="address" required="">
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="date" placeholder="Delivery Date" class="custom_date form-control pre_delivery" name="delivery">
                            @error('delivery')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                   </div>
                </div>
               </div>
            </div> <!-- end card body-->
           <div class="service-info invoice-form px-2">
               <table class="table">
                   <thead>
                       <tr>
                           <td>Service</td>
                           <td>Produt ID</td>
                           <td>Services</td>
                           <td>Attribute</td>
                           <td>Amount</td>
                           <td>Action</td>
                       </tr>
                   </thead>
                   <tbody class="data">
                       <tr class="increment">
                           <td><input type="text" name="service_name[]" placeholder="Service Name" class="form-control service_name"></td>
                           <td><input type="text" name="product_id[]" placeholder="Product ID" class="form-control product_id"></td>
                           <!--<td><input type="text" name="client_name[]" placeholder="Client Name" class="form-control client_name"></td>-->
                           <td><input type="text" name="service_attribute[]" placeholder="Service Attribute" class="form-control service_attribute"></td>
                           <td><input type="text" name="attribute_number[]" placeholder="Attribute Number" class="form-control attribute_number"></td>
                           <td><input type="text" name="amount[]" placeholder="Amount" class="form-control total_amount cart_store"></td>
                           <td><a class="cart_remove"><img src="{{asset('public/backend/assets/images/delete.png')}}" alt=""></a></td>
                       </tr>
                       <tbody  class="clone" style="display: none;">
                           <tr class="increment_control">
                               <td><input type="text" placeholder="Service Name" name="service_name[]" value="" class="form-control"></td>
                               <td><input type="text" placeholder="Product ID" name="product_id[]" value="" class="form-control"></td>
                               <!--<td><input type="text" placeholder="Client Name" name="client_name[]" value="" class="form-control"></td>-->
                               <td><input type="text" placeholder="Service Attribute" name="service_attribute[]" value="" class="form-control service_attribute"></td>
                               <td><input type="text" placeholder="Service Number" name="attribute_number[]" value="" class="form-control attribute_number"></td>
                               <td><input type="text" placeholder="Amount" name="amount[]" value="" class="form-control cart_store"></td>
                               <td><a class="cart_remove" ><img src="{{asset('public/backend/assets/images/delete.png')}}" alt=""></a></td>
                            </tr>
                        </tbody>
                   </tbody>
                   <tbody id="cart_details"></tbody>
                   <tr class="no_hover" >
                       <td colspan="5"><a class="cart_add" >Add Another Service</a></td>
                   </tr>
               </table>
           </div>
           <!-- service end -->
           <div class="invoice_summary p-2"> 
              <div class="row">
                  <div class="col-sm-6">
                      <textarea name="note" placeholder="Additional Note" class="pre_note form-control" rows="8"></textarea>
                  </div>
                  <div class="col-sm-6">
                      <table class="table" id="cart_info">
                        
                        <thead>
                            <tr>
                                <td>Subtotal</td>
                                <td></td>
                                <td class="text-end">${{$subtotal}}</td>
                            </tr>
                        </thead>
                          <tbody>
                            <tr>
                                <td>Discount</td>
                                <td class="text-center">:</td>
                                <td class="text-end">${{$discount}}</td>
                            </tr>
                            <tr>
                                <td>Tax</td>
                                <td class="text-center">:</td>
                                <td class="text-end">${{$tax}}</td>
                            </tr>
                            <tr>
                                <td>Payable</td>
                                <td class="text-center">:</td>
                                <td class="text-end">${{($subtotal+$tax)- $discount}}</td>
                            </tr>
                          </tbody>
                      </table>
                  </div>
              </div>
              <div class="row mt-4">
                  <div class="col-sm-8">
                      <a class="invoice_pbtn">Preview Invoice</a>
                      <button class="send_now"  name="status" value="2">Send Now</button>
                  </div>
                  <div class="col-sm-4 text-end">
                     <button class="draft_save" name="status" value="1">Save as a Draft</button>
                  </div>
              </div>
            </div>
        </div> <!-- end card -->
        
    </div><!-- end col-->
    <div class="invoice_preview"></div>
   </div>
</div>
</form>

@endsection

@section('script')
    <!-- cart js start -->
    <script src="{{asset('public/backEnd/')}}/assets/libs/parsleyjs/parsley.min.js"></script>
    <script src="{{asset('public/backEnd/')}}/assets/js/pages/form-validation.init.js"></script>
    <script src="{{asset('public/backEnd/')}}/assets/libs/select2/js/select2.min.js"></script>
    <script src="{{asset('public/backEnd/')}}/assets/js/pages/form-advanced.init.js"></script>
    <!-- Plugins js -->

    <script>
        var timer;
        $("body").on("keyup", ".cart_store", function() {
            var amount = 0;
            $(".cart_store").each(function(){
                amount += +$(this).val();
            });
            clearTimeout(timer);
            var discount = $(this).val(); 
            timer = setTimeout(function() {
            if(amount){
            $.ajax({
               type:"GET",
               data:{'amount':amount},
               url:"{{route('admin.cart_store')}}",
               success:function(res){               
                if(res){
                    return cart_info();
                }
               }
            });
            }
          },500);  
        });
        $(".cart_add").click(function() {
            var html = $(".clone").html();
            $(".data tr:last").after(html);
        });
        $("body").on("click", ".cart_remove", function() {
            $(this).closest("tr.increment_control").remove();
            var amount = 0;
            $(".cart_store").each(function(){
                amount += +$(this).val();
            });
            clearTimeout(timer);
            var discount = $(this).val(); 
            timer = setTimeout(function() {
            if(amount){
            $.ajax({
               type:"GET",
               data:{'amount':amount},
               url:"{{route('admin.cart_store')}}",
               success:function(res){               
                if(res){
                    return cart_info();
                }
               }
            });
          }
          },500);  
        });
        function cart_info(){
            $.ajax({
               type:"GET",
               url:"{{route('admin.cart_info')}}",
               success:function(data){               
                if(data){
                    $("#cart_info").html(data);
                }else{
                   $("#cart_info").empty();
                }
               }
            }); 
       };
        $('#tax').on('keypress keyup keydown',function(){
        var tax = $(this).val(); 
        clearTimeout(timer);
        var discount = $(this).val(); 
        timer = setTimeout(function() {
       
            $.ajax({
               type:"GET",
               data:{'tax':tax},
               url:"{{route('admin.cart_tax')}}",
               success:function(data){               
                if(data){
                    return cart_info();
                }
               }
            });
         
         },500);  
       });
        $('#discount').on('keypress keyup keydown',function(){
        clearTimeout(timer);
        var discount = $(this).val(); 
        timer = setTimeout(function() {
        
            $.ajax({
               type:"GET",
               data:{'discount':discount},
               url:"{{route('admin.cart_discount')}}",
               success:function(data){               
                if(data){
                    return cart_info();
                }
               }
            });
          
         },500); 
       });
       $(".invoice_pbtn").click(function () {
          var bemail = $('.pre_bemail').val(); 
          var baddress = $('.pre_baddress').val(); 
          var bdelivery = $('.pre_bdelivery').val(); 
          var company = $('.pre_company').val(); 
          var email   = $('.pre_email').val(); 
          var address   = $('.pre_address').val(); 
          var delivery   = $('.pre_delivery').val(); 
          var note   = $('.pre_note').val(); 

            var service_name = [];
            $('input[name="service_name[]"]').each(function() {
                var value = $(this).val();
                if (value !== "") {
                  service_name.push(value);
                }
            });
            var product_id = [];
            $('input[name="product_id[]"]').each(function() {
                var value = $(this).val();
                if (value !== "") {
                  product_id.push(value);
                }
            });
            var client_name = [];
            $('input[name="client_name[]"]').each(function() {
                var value = $(this).val();
                if (value !== "") {
                  client_name.push(value);
                }
            });
            var amount = [];
            $('input[name="amount[]"]').each(function() {
                var value = $(this).val();
                if (value !== "") {
                  amount.push(value);
                }
            });

            var service = [];
            $('input[name="service_attribute[]"]').each(function() {
                var value = $(this).val();
                if (value !== "") {
                  service.push(value);
                }
            });
            var attribute = [];
            $('input[name="attribute_number[]"]').each(function() {
                var value = $(this).val();
                if (value !== "") {
                  attribute.push(value);
                }
            });

            var data = {
              bemail: bemail,
              baddress: baddress,
              bdelivery: bdelivery,
              company: company,
              email: email,
              address: address,
              delivery: delivery,
              service_name: service_name,
              product_id: product_id,
              client_name: client_name,
              service: service,
              attribute: attribute,
              amount: amount,
              note: note,
            };
          if(data){
              $.ajax({
                type: "GET",
                data: data,
                url: "{{url('admin/invoice/preview')}}",
                success: function (res) {
                    $('.invoice_preview').show();
                    $('body').addClass('bodyoverflow');
                    console.log(res);
                  if(res) {
                     $(".invoice_preview").html(res);
                  }
                },
              });
            }
        });
    </script>
    <!-- cart js end -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr(".custom_date", {});
</script>
@endsection
