@extends('backEnd.layouts.master')
@section('title','Category Edit')
@section('content')
<div class="container-fluid">

    <!-- end page title -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card cust_card">
                <div class="card_head">
                    <div class="card_top">
                        <div class="card_head_widget">
                            <p>Services</p>
                        </div>
                        <div class="card_head_widget text_right">
                            <a href="{{route('services.index')}}" class="b_btn">Manage Service</a>
                        </div>
                    </div>
                 </div>

                <div class="card-body form_card_body">
                    <form action="{{route('services.update')}}" method="POST" class="row" data-parsley-validate="" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{$edit_data->id}}" name="id" />
                        <div class="col-sm-12 ">
                            <div class="form-group mb-3">
                                <label for="page_title" class="form-label">Service Name </label>
                                <input type="text" class="form-control @error('service_name') is-invalid @enderror" name="service_name" value="{{ $edit_data->service_name }}" id="service_name" placeholder="Service Name" />
                                @error('category_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->

                        <div class="col-sm-12">
                            <div class="form-group mb-3">
                                <label for="page_title" class="form-label">Page Title </label>
                                <input type="text" class="form-control @error('page_title') is-invalid @enderror" required name="page_title" value="{{ $edit_data->page_title }}" id="page_title">
                                @error('page_title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label for="meta_image" class="form-label">Image</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}"  id="image" >
                                <img src="{{asset($edit_data->image)}}" class="edit-image" alt="">
                                @error('meta_image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    <!--col-end-->
                        <div class="col-sm-12">
                            <div class="form-group mb-3">
                                <label for="page_subtitle" class="form-label">Page Subtitle </label>
                                <input type="text" class="form-control @error('page_subtitle') is-invalid @enderror" required name="page_subtitle" value="{{ $edit_data->page_subtitle }}" id="page_subtitle">
                                @error('page_subtitle')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    <!--col-end-->
                        <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <label for="meta_title" class="form-label">Meta Title (Optional)</label>
                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror" name="meta_title" value="{{ $edit_data->meta_title }}" id="meta_title">
                            @error('meta_title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <label for="meta_description" class="form-label">Meta Description (Optional)</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror" name="meta_description" value="{{ old('meta_description') }}" id="meta_description">{{$edit_data->meta_description}}</textarea>
                            @error('meta_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <label for="meta_tag" class="form-label">Meta Tag (Optional)</label>
                            <input type="text" class="form-control @error('meta_tag') is-invalid @enderror" name="meta_tag" value="{{ $edit_data->meta_tag }}" id="meta_tag">
                            @error('meta_tag')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 mb-3">
                        <div class="form-group">
                            <label for="meta_image" class="form-label">Meta Image (Optional)</label>
                            <input type="file" class="form-control @error('meta_image') is-invalid @enderror" name="meta_image" value="{{ old('meta_image') }}"  id="meta_image" >
                            <img src="{{asset($edit_data->meta_image)}}" class="edit-image" alt="">
                            @error('meta_image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
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
                            <input type="submit" class="cust_sub_btn b_btn" value="Category Update" />
                        </div>
                    </form>
                </div>
                <!-- end card-body-->
            </div>
            <!-- end card-->
        </div>
        <!-- end col-->
    </div>
</div>
@endsection
@section('script')
<script src="{{asset('public/backEnd/')}}/assets/libs/parsleyjs/parsley.min.js"></script>
<script src="{{asset('public/backEnd/')}}/assets/js/pages/form-validation.init.js"></script>
<script src="{{asset('public/backEnd/')}}/assets/libs/select2/js/select2.min.js"></script>
<script src="{{asset('public/backEnd/')}}/assets/js/pages/form-advanced.init.js"></script>
@endsection
