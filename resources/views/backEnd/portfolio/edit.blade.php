@extends('backEnd.layouts.master')
@section('title','Portfolio Update')
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
                    <p>Edit Product</p>
                </div>
                <div class="card_head_widget text_right">
                    <a href="{{route('portfolios.index')}}" class="b_btn">Manage</a>
                </div>
            </div>
           </div>

            <div class="card-body form_card_body">
                <form action="{{route('portfolios.update')}}" method="POST" class=row data-parsley-validate=""  enctype="multipart/form-data" name="editForm">
                    @csrf
                    <input type="hidden" name="hidden_id" value="{{$edit_data->id}}">

                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <label for="service_id" class="form-label">Product *</label>
                            <select name="product_id" id="product_id" class="form-control @error('product_id') is-invalid @enderror" required>
                                <option value="">Select...</option>
                                @foreach($products as $key => $value)
                                    <option value="{{ $value->id }}" {{ $value->id == $edit_data->product_id ? 'selected' : '' }}>
                                        {{ $value->product_name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('product_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col-end -->

                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Portfolio Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $edit_data->title}}" id="title" required="">
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col-end -->

                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <label for="link" class="form-label">Portfolio Link *</label>
                            <input type="text" class="form-control @error('link') is-invalid @enderror" name="link" value="{{ $edit_data->link}}" id="link" required="">
                            @error('link')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col-end -->


                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Description *</label>
                            <textarea name="description" id="description" class="summernote form-control @error('description') is-invalid @enderror" required="">{{$edit_data->description}}</textarea>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col-end -->
                    <div class="col-sm-12 mb-3">
                        <div class="form-group">
                            <label for="image" class="form-label">Image *</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}"  id="image" >
                            <img src="{{asset($edit_data->image)}}" class="edit-image" alt="">
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col end -->
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
     document.forms['editForm'].elements['product_id'].value="{{$edit_data->product_id}}"


  </script>

@endsection
