@extends('backEnd.layouts.master')
@section('title','Coupon Code Manage')

@section('css')
<link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="container-fluid">
    
   
   <div class="row">
    <div class="col-12">
        <div class="card cust_card">
           <div class="card_head">
            <div class="card_top">
                <div class="card_head_widget">
                    <p>Coupon Code</p>
                </div>
                <div class="card_head_widget text_right">
                    <a href="#create" class="b_btn">Create</a>
                </div>
            </div>
           </div>

            <div class="card-body form_card_body table-responsive-sm">
                <table id="datatable-buttons" class="table dt-responsive nowrap w-100">
                    <thead class="cust_thead">
                        <tr>
                            <th>SL</th>
                            <th>Code</th>
                            <th>Expairdate</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Buy Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                
                
                    <tbody>
                        @foreach($show_data as $key=>$value)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$value->couponcode}}</td>
                            <td>{{$value->expairdate}}</td>
                            <td> {{$value->offertype==1?'Persantance':'Amount'}}</td>
                            <td>{{$value->amount}}</td>
                            <td>{{$value->buyammount}}</td>
                            <td>@if($value->status==1)<span class="badge bg-soft-success text-success">Active</span> @else <span class="badge bg-soft-danger text-danger">Inactive</span> @endif</td>
                            <td>
                                <div class="button-list">
                                    @if($value->status == 1)
                                    <form method="post" action="{{route('couponcode.inactive')}}" class="d-inline"> 
                                    @csrf
                                    <input type="hidden" value="{{$value->id}}" name="hidden_id">       
                                    <button type="button" class="btn btn-xs  btn-secondary waves-effect waves-light change-confirm"><i class="fe-thumbs-down"></i></button></form>
                                    @else
                                    <form method="post" action="{{route('couponcode.active')}}" class="d-inline">
                                        @csrf
                                    <input type="hidden" value="{{$value->id}}" name="hidden_id">        
                                    <button type="button" class="btn btn-xs  btn-success waves-effect waves-light change-confirm"><i class="fe-thumbs-up"></i></button></form>
                                    @endif

                                    <a href="{{route('couponcode.edit',$value->id)}}" class="btn btn-xs btn-primary waves-effect waves-light"><i class="fe-edit-1"></i></a>

                                    <form method="post" action="{{route('couponcode.destroy')}}" class="d-inline">        
                                        @csrf
                                    <input type="hidden" value="{{$value->id}}" name="hidden_id">
                                    <button type="submit" class="btn btn-xs btn-danger waves-effect waves-light delete-confirm"><i class="mdi mdi-close"></i></button></form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    
                </table>
 
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->

    <div class="col-12">
        <div class="card cust_card create_card"  id="create">
           <div class="card_head">
            <div class="card_top">
                <div class="card_head_widget">
                    <p>Create New Couponcode</p>
                </div>
                <div class="card_head_widget text_right">
                   
                </div>
            </div>
           </div>

            <div class="card-body form_card_body">
                <form action="{{route('couponcode.store')}}" method="POST" class=row data-parsley-validate=""  enctype="multipart/form-data">
                    @csrf
                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <label for="couponcode" class="form-label">Coupon Code *</label>
                            <input type="text" class="form-control @error('couponcode') is-invalid @enderror" name="couponcode" value="{{ old('couponcode') }}" id="couponcode" required="">
                            @error('couponcode')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col-end -->
                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <label for="expairdate" class="form-label">Expair Date *</label>
                            <input type="date" class="form-control @error('expairdate') is-invalid @enderror mydate" name="expairdate" value="{{ old('expairdate') }}" id="expairdate" required="">
                            @error('expairdate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col-end -->
                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <label for="offertype">Offer Type</label>
                            <select type="text" name="offertype" class="select2  form-control{{ $errors->has('offertype') ? ' is-invalid' : '' }}" value="{{ old('offertype') }}"/>
                                <option value="">=== Select Option ===</option>
                                <option value="1">Percentage</option>
                                <option value="2">Amount</option>
                            </select>

                            @error('offertype')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                      <!-- /.form-group -->
                    <!-- col-end -->
                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <label for="amount" class="form-label">Amount *</label>
                            <input type="text" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') }}" id="amount" required="">
                            @error('amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col-end -->
                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <label for="buyammount" class="form-label">Minimum Buy *</label>
                            <input type="text" class="form-control @error('buyammount') is-invalid @enderror" name="buyammount" value="{{ old('buyammount') }}" id="buyammount" required="">
                            @error('buyammount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col-end -->
                    <!-- col-end -->
                    <div class="col-sm-12 mb-3">
                        <div class="form-group">
                            <label for="status" class="d-block">Status</label>
                            <label class="switch">
                              <input type="checkbox" value="1" name="status" checked>
                              <span class="slider round"></span>
                            </label>
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col end -->
                    <div>
                        <input type="submit" class="btn btn-success" value="Submit">
                    </div>

                </form>
 
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
   </div>
</div>
@endsection


@section('script')
<!-- third party js -->
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="{{asset('/public/backEnd/')}}/assets/js/pages/datatables.init.js"></script>
<!-- third party js ends -->
<script src="{{asset('public/backEnd/')}}/assets/libs/parsleyjs/parsley.min.js"></script>
@endsection