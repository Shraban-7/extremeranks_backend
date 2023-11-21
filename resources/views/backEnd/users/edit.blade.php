@extends('backEnd.layouts.master')
@section('title','Users Edit')
@section('css')
<link href="{{asset('public/backEnd')}}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="container-fluid">
    
   <div class="row">
    <div class="col-lg-12">
        <div class="card cust_card">
            <div class="card_head">
                <div class="card_top">
                    <div class="card_head_widget">
                        <p>Edit User</p>
                    </div>
                    <div class="card_head_widget text_right">
                        <a href="{{route('users.index')}}" class="b_btn">Add New User</a>
                    </div>
                </div>
            </div>

            <div class="card-body form_card_body">
                <form action="{{route('users.update')}}" method="POST" class=row data-parsley-validate=""  enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{$edit_data->id}}" name="hidden_id">
                    
                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $edit_data->username}}" id="username" placeholder="User Name" required="">
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col-end -->
                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $edit_data->email}}"  id="email" placeholder="Email Address" required="">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col-end -->
                    
                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $edit_data->name}}" id="name" placeholder="Full Name" required="">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col-end -->
                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                             <select class="form-control select2-multiple" name="roles[]" data-toggle="select2"  multiple="multiple" data-placeholder="Choose ..." required>
                                <optgroup label="Select Role">
                                    @foreach($roles as $role)
                                    <option value="{{$role->name}}" @foreach($edit_data->roles as $srole) {{$srole->id==$role->id?'selected':''}} @endforeach>{{$role->name}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                            @error('roles')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col end -->
                    <div class="col-sm-12 mb-3">
                        <div class="form-group">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ $edit_data->image }}"  id="image" >
                            <img src="{{asset($edit_data->image)}}" alt="">
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
                            <label for="dashboard" class="d-block">Dashboard Visible</label>
                            <label class="switch">
                              <input type="checkbox" value="1" name="dashboard" @if($edit_data->dashboard==1)checked @endif>
                              <span class="slider round"></span>
                            </label>
                            @error('dashboard')
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
@endsection