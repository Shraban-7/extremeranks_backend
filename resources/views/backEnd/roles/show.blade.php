@extends('backEnd.layouts.master')
@section('title','Roles Show')
@section('content')
<div class="container-fluid">
    
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('roles.index')}}">Roles</a></li>
                        <li class="breadcrumb-item active">Show</li>
                    </ol>
                </div>
                <h4 class="page-title">Roles Show</h4>
            </div>
        </div>
    </div>       
    <!-- end page title --> 
   <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <button type="button" class="btn btn-success waves-effect waves-light mb-2">
                            <span class="btn-label">Name</span><span class="font-16">{{ $role->name }}</span>
                        </button>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <button type="button" class="btn btn-info waves-effect waves-light mb-2">
                            <span class="btn-label"><i class="mdi mdi-alert-circle-outline"></i></span>Permissions
                        </button>
                        <div class="button-list form-group">
                            @if(!empty($rolePermissions))
                                @foreach($rolePermissions as $v)
                                    <button class="btn btn-blue btn-xs rounded-pill">{{ $v->name }}</button>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col-->
   </div>
</div>
@endsection
