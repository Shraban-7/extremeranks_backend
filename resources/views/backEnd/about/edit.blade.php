@extends('backEnd.layouts.master')
@section('title','About Update')
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
                    <p>Edit About</p>
                </div>
                <div class="card_head_widget text_right">
                    <a href="{{route('about.index')}}" class="b_btn">Manage</a>
                </div>
            </div>
           </div>

            <div class="card-body form_card_body">
                <form action="{{route('about.update')}}" method="POST" class=row data-parsley-validate=""  enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="hidden_id" value="{{$edit_data->id}}">
                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Title *</label>
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
                            <div class="img_note">
                                <h6>Image Size: With: 280px; Height: 249px;</h6>
                            </div>
                            <label for="image" class="form-label">Image One *</label>
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
                    <div class="col-sm-12 mb-3">
                        <div class="form-group">
                            <div class="img_note">
                                <h6>Image Size: With: 280px; Height: 249px;</h6>
                            </div>
                            <label for="imageone" class="form-label">Image Two *</label>
                            <input type="file" class="form-control @error('imageone') is-invalid @enderror" name="imageone" value="{{ old('imageone') }}"  id="imageone" >
                            <img src="{{asset($edit_data->imageone)}}" class="edit-image" alt="">
                            @error('imageone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col end -->
                    <div class="col-sm-12 mb-3">
                        <div class="form-group">
                            <div class="img_note">
                                <h6>Image Size: With: 280px; Height: 249px;</h6>
                            </div>
                            <label for="imagetwo" class="form-label">Image Three *</label>
                            <input type="file" class="form-control @error('imagetwo') is-invalid @enderror" name="imagetwo" value="{{ old('imagetwo') }}"  id="imagetwo" >
                            <img src="{{asset($edit_data->imagetwo)}}" class="edit-image" alt="">
                            @error('imagetwo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col end -->
                    <div class="col-sm-12 mb-3">
                        <div class="form-group">
                            <div class="img_note">
                                <h6>Image Size: With: 280px; Height: 249px;</h6>
                            </div>
                            <label for="imagethree" class="form-label">Image Four *</label>
                            <input type="file" class="form-control @error('imagethree') is-invalid @enderror" name="imagethree" value="{{ old('imagethree') }}"  id="imagethree" >
                            <img src="{{asset($edit_data->imagethree)}}" class="edit-image" alt="">
                            @error('imagethree')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col end -->
                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <label for="experience" class="form-label">Experience *</label>
                            <input type="text" class="form-control @error('experience') is-invalid @enderror" name="experience" value="{{ $edit_data->experience }}" id="experience" required="">
                            @error('experience')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    
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
@endsection