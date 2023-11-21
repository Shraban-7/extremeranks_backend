@extends('backEnd.layouts.master')
@section('title','Category Create')
@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{route('services.index')}}" class="btn btn-primary waves-effect waves-light btn-sm rounded-pill">Manage</a>
                </div>
                <h4 class="page-title">Service Create</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('services.store') }}" method="POST" class="row" data-parsley-validate="" enctype="multipart/form-data">
                        @csrf
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="category_name" class="form-label">Service Name</label>
                                <input type="text" class="form-control @error('service_name') is-invalid @enderror" name="service_name" value="{{ old('category_name') }}" id="category_name" />
                                @error('service_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->
                        <div class="col-sm-6 mb-3">
                            <div class="form-group">
                                <label for="image" class="form-label">Image *</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}" id="image" required="" />
                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col end -->
                        <div class="col-sm-12">
                            <div class="form-group mb-3">
                                <label for="page_title" class="form-label">Page Title </label>
                                <input type="text" class="form-control @error('page_title') is-invalid @enderror" required name="page_title" value="{{ old('page_title') }}" id="page_title">
                                @error('page_title')
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
                                <input type="text" class="form-control @error('page_subtitle') is-invalid @enderror" required name="page_subtitle" value="{{ old('page_subtitle') }}" id="page_subtitle">
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
                                <input type="text" class="form-control @error('meta_title') is-invalid @enderror" name="meta_title" value="{{ old('meta_title') }}" id="meta_title">
                                @error('meta_title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    <!--col-end-->
                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <label for="meta_description" class="form-label">Meta Description (Optional)</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror" name="meta_description" value="{{ old('meta_description') }}" id="meta_description"></textarea>
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
                            <input type="text" class="form-control @error('meta_tag') is-invalid @enderror" name="meta_tag" value="{{ old('meta_tag') }}" id="meta_tag">
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
                            <input type="file" class="form-control @error('meta_image') is-invalid @enderror" name="meta_image" value="{{ old('meta_image') }}"  id="meta_image">
                            @error('meta_image')
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
                                    <input type="checkbox" value="1" name="status" checked />
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
                            <input type="submit" class="btn btn-success" value="Submit" />
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
