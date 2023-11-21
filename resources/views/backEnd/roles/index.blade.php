@extends('backEnd.layouts.master')
@section('title','Roles Manage')

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
                        <p>Roles</p>
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
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                
                
                    <tbody>
                        @foreach($show_data as $key=>$value)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$value->name}}</td>
                            <td>
                                <div class="button-list">

                                    <a href="{{route('roles.show',$value->id)}}" class="btn btn-xs btn-info waves-effect waves-light"><i class="fe-eye"></i></a>
                                    <a href="{{route('roles.edit',$value->id)}}" class="btn btn-xs btn-primary waves-effect waves-light"><i class="fe-edit-1"></i></a>

                                    <form method="post" action="{{route('roles.destroy')}}" class="d-inline">        
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
        <div class="card cust_card create_card" id="create">
            <div class="card_head ">
                <div class="card_top">
                    <div class="card_head_widget">
                        <p>CREATE NEW ROLE</p>
                    </div>
                    <div class="card_head_widget text_right">
                       
                    </div>
                </div>
            </div>

            <div class="card-body form_card_body">
                <form action="{{route('roles.store')}}" method="POST" class=row data-parsley-validate=""  enctype="multipart/form-data">
                    @csrf
                    <div class="col-sm-12">
                        <div class="form-group mb-3">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" id="name" placeholder="Name" required="">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col-end -->
                    <div class="col-sm-12">
                        <div class="form-check checkall text-primary">
                            <input type="checkbox" class="form-check-input" id="checkall">
                            <label class="form-check-label" for="checkall">All</label>
                           </div>
                    </div>
                        @foreach($permission as $value)
                    <div class="col-sm-4 my-1">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" value="{{$value->id}}" id="customCheck{{$value->id}}" name="permission[]">
                            <label class="form-check-label" for="customCheck{{$value->id}}">{{$value->name}}</label>
                        </div>
                    </div>
                        @endforeach
                    <div class="mt-3">
                        <input type="submit" class="cust_sub_btn b_btn" value="Create Role">
                    </div>

                </form>

            </div> <!-- end card-body-->

            
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

<script>
        jQuery("#checkall").click(function() {


           var isChecked = this.checked;
                jQuery('.form-check-input').each(function() {
                    jQuery(this).prop('checked', isChecked);
                });

        });
</script>


@endsection