@extends('backEnd.layouts.master')
@section('title','Pricing Update')
@section('css')
<link href="{{asset('public/backEnd')}}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="container-fluid">
    
    <!-- end page title --> 
   <div class="row">
    <div class="col-lg-12">
        <div class="card cust_card">
            <div class="card_head">
            <div class="card_top">
                <div class="card_head_widget">
                    <p>Edit Pricing</p>
                </div>
                <div class="card_head_widget text_right">
                    <a href="{{route('pricings.index')}}" class="b_btn">Manage</a>
                </div>
            </div>
           </div>

            <div class="card-body form_card_body">
                <form action="{{route('pricings.update')}}" method="POST" class=row data-parsley-validate=""  enctype="multipart/form-data" name="editForm">
                    @csrf
                    <input type="hidden" name="hidden_id" value="{{$edit_data->id}}">

                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <label for="category_id" class="form-label">Category *</label>
                            <select name="category_id" id="category_id" class="category form-control @error('category_id') is-invalid @enderror" required>
                                <option value="">Select...</option>
                                @foreach($categories as $key=>$value)
                                <option value="{{$value->id}}">{{$value->category_name}}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col-end -->

                    <div class="col-sm-6">
                        <div class="form-group mb-3">
                            <label for="package_id" class="form-label">Package *</label>
                            <select name="package_id" id="package_id" class="form-control @error('package_id') is-invalid @enderror" required>
                                <option value="">Select...</option>
                                @foreach($packages as $key=>$value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                            @error('package_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col-end -->

                    <div class="col-sm-6">
                        <div class="form-group mb-3">
                            <label for="attribute_id" class="form-label">Attribute *</label>
                            <select name="attribute_id" id="attribute_id" class="form-control @error('attribute_id') is-invalid @enderror" required>
                                <option value="">Select...</option>
                                @foreach($attributes as $key=>$value)
                                <option value="{{$value->id}}">{{$value->title}}</option>
                                @endforeach
                            </select>
                            @error('attribute_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col-end -->

                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <label for="slug" class="form-label">Slug *</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" value="{{ $edit_data->slug}}" id="slug" required="">
                            @error('slug')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col-end -->

                    
                    <div class="col-sm-6 mb-3">
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
                        <input type="submit" class="cust_sub_btn b_btn" value="Update">
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

<script type="text/javascript">
     document.forms['editForm'].elements['category_id'].value="{{$edit_data->category_id}}"
     document.forms['editForm'].elements['package_id'].value="{{$edit_data->package_id}}"
     document.forms['editForm'].elements['attribute_id'].value="{{$edit_data->attribute_id}}"


  </script>

@endsection