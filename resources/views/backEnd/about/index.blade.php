@extends('backEnd.layouts.master')
@section('title','About Manage')

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
                    <p>About</p>
                </div>
                <div class="card_head_widget text_right">
                    <a href="#create" class="b_btn">Create</a>
                </div>
            </div>
           </div>

            <div class="card-body table-responsive-sm">
                <table class="table dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Title</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                
                
                    <tbody>
                        @foreach($show_data as $key=>$value)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{!!Str::limit($value->title,40)!!}</td>
                            <td><img src="{{asset($value->image)}}" class="backend-image" alt=""></td>
                            <td>@if($value->status==1)<span class="badge bg-soft-success text-success">Active</span> @else <span class="badge bg-soft-danger text-danger">Inactive</span> @endif</td>
                            <td>
                                <div class="button-list">
                                    @if($value->status == 1)
                                    <form method="post" action="{{route('about.inactive')}}" class="d-inline"> 
                                    @csrf
                                    <input type="hidden" value="{{$value->id}}" name="hidden_id">       
                                    <button type="button" class="btn btn-xs  btn-secondary waves-effect waves-light change-confirm"><i class="fe-thumbs-down"></i></button></form>
                                    @else
                                    <form method="post" action="{{route('about.active')}}" class="d-inline">
                                        @csrf
                                    <input type="hidden" value="{{$value->id}}" name="hidden_id">        
                                    <button type="button" class="btn btn-xs  btn-success waves-effect waves-light change-confirm"><i class="fe-thumbs-up"></i></button></form>
                                    @endif

                                    <a href="{{route('about.edit',$value->id)}}" class="btn btn-xs btn-primary waves-effect waves-light"><i class="fe-edit-1"></i></a>

                                    <form method="post" action="{{route('about.destroy')}}" class="d-inline">        
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
                    <p>Create New About</p>
                </div>
                <div class="card_head_widget text_right">
                
                </div>
            </div>
           </div>

            <div class="card-body form_card_body">
               <form action="{{route('about.store')}}" method="POST" class=row data-parsley-validate=""  enctype="multipart/form-data">
                    @csrf
                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" id="title" required="">
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
                            <textarea name="description" id="description" class="summernote form-control @error('description') is-invalid @enderror" value="{{old('description')}}" required=""></textarea>
                            
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
                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}"  id="image" required="">
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
                            <input type="file" class="form-control @error('imageone') is-invalid @enderror" name="imageone" value="{{ old('imageone') }}"  id="imageone" required="">
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
                            <input type="file" class="form-control @error('imagetwo') is-invalid @enderror" name="imagetwo" value="{{ old('imagetwo') }}"  id="imagetwo" required="">
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
                            <input type="file" class="form-control @error('imagethree') is-invalid @enderror" name="imagethree" value="{{ old('imagethree') }}"  id="imagethree" required="">
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
                            <input type="text" class="form-control @error('experience') is-invalid @enderror" name="experience" value="{{ old('experience') }}" id="experience" required="">
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
                        <input type="text" class="form-control @error('meta_title') is-invalid @enderror" name="meta_title" value="{{ old('meta_title') }}" id="meta_title">
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
                        <input type="submit" class="cust_sub_btn b_btn" value="Submit">
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

<script src="{{asset('public/backEnd/')}}/assets/libs/parsleyjs/parsley.min.js"></script>
<!-- third party js ends -->
@endsection