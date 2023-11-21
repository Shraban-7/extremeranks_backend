@extends('backEnd.layouts.master')
@section('title','Package Manage')

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
        <div class="card cust_card create_card">
            <div class="card_head">
            <div class="card_top">
                <div class="card_head_widget">
                    <p>Create {{$package->name}} Pricing</p>
                </div>
            </div>
           </div>

            <div class="card-body form_card_body">
               <form action="{{route('packages.price_store')}}" method="POST" class=row data-parsley-validate=""  enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{$package->id}}" name="package_id">
                    <input type="hidden" value="{{$category->id}}" name="category_id">
                    @foreach($attributes as $key=>$value)
                    <input type="hidden" name="attribute_id[]" value="{{$value->id}}">
                    @php
                        $edit_data = App\Models\Pricing::where(['package_id'=>$package->id,'attribute_id'=>$value->id])->first();
                    @endphp
                    @if($value->type==1)
                    <div class="col-sm-6">
                        <div class="form-group mb-3">
                            <label for="attribute_value" class="form-label">{{$value->title}} *</label>
                            <input type="text" class="form-control @error('attribute_value') is-invalid @enderror" name="attribute_value[]" value="{{$edit_data?$edit_data->attribute_value: old('attribute_value') }}" id="attribute_value" required="">
                            @error('attribute_value')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col-end -->
                    @else
                     <div class="col-sm-6 my-1">
                        <div class="form-group">
                            <label for="attribute_value" class="form-label">{{$value->title}} *</label>
                            <select type="text" class="form-control @error('attribute_value') is-invalid @enderror" name="attribute_value[]" value="{{$value->id}}" id="attribute_value" required="">
                                <option value="">Select..</option>
                                <option value="1" @if($edit_data) {{$edit_data->attribute_value == 1? 'selected' :''}} @endif>Yes</option>
                                <option value="0" @if($edit_data) {{$edit_data->attribute_value == 0? 'selected' :''}}  @endif>No</option>
                            </select>
                            @error('attribute_value')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    @endif
                    @endforeach
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