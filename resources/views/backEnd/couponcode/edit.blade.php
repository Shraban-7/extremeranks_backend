@extends('backEnd.layouts.master')
@section('title','Coupon Code Edit')
@section('css')
<link href="{{asset('public/backEnd')}}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="container-fluid">
    

   <div class="row">
    <div class="col-lg-12">
        <div class="card cust_card create_card">
          <div class="card_head">
            <div class="card_top">
                <div class="card_head_widget">
                    <p>Coupon Code</p>
                </div>
                <div class="card_head_widget text_right">
                    <a href="{{route('couponcode.index')}}" class="b_btn">Manage</a>
                </div>
            </div>
           </div>

            <div class="card-body form_card_body">
                <form action="{{route('couponcode.update')}}" method="POST" class=row data-parsley-validate=""  enctype="multipart/form-data" name="editForm">
                    @csrf
                    <input type="hidden" value="{{$edit_data->id}}" name="id">
                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <label for="couponcode" class="form-label">Coupon Code *</label>
                            <input type="text" class="form-control @error('couponcode') is-invalid @enderror" name="couponcode" value="{{ $edit_data->couponcode }}" id="couponcode" required="">
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
                            <input type="date" class="form-control @error('expairdate') is-invalid @enderror mydate" name="expairdate" value="{{ $edit_data->expairdate }}" id="expairdate" required="">
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
                            <input type="text" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ $edit_data->amount }}" id="amount" required="">
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
                            <input type="text" class="form-control @error('buyammount') is-invalid @enderror" name="buyammount" value="{{ $edit_data->buyammount }}" id="buyammount" required="">
                            @error('buyammount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col-end -->
                    <div class="col-sm-12 mb-3">
                        <div class="form-group">
                            <label for="status" class="d-block">Status</label>
                            <label class="switch">
                              <input type="checkbox" value="1" name="status" @if($edit_data->status==1)checked @endif>
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

            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col-->
   </div>
</div>
@endsection


@section('script')
<script src="{{asset('public/backEnd/')}}/assets/libs/parsleyjs/parsley.min.js"></script>
<script src="{{asset('public/backEnd/')}}/assets/js/pages/form-validation.init.js"></script>
<script src="{{asset('public/backEnd/')}}/assets/libs/select2/js/select2.min.js"></script>
<script src="{{asset('public/backEnd/')}}/assets/js/pages/form-advanced.init.js"></script>

<script src="{{asset('/public/backEnd/')}}/assets/libs/flatpickr/flatpickr.min.js"></script>

<script type="text/javascript">
    document.forms['editForm'].elements['status'].value="{{$edit_data->status}}";
    document.forms['editForm'].elements['offertype'].value="{{$edit_data->offertype}}";
    
  
</script>






@endsection