<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Couponcode;
use Toastr;

class CouponcodeController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:couponcode-list|couponcode-create|couponcode-edit|couponcode-delete', ['only' => ['index','store']]);
         $this->middleware('permission:couponcode-create', ['only' => ['create','store']]);
         $this->middleware('permission:couponcode-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:couponcode-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $show_data = Couponcode::orderBy('id','DESC')->get();
        return view('backEnd.couponcode.index',compact('show_data'));
    }
    public function create()
    {
        return view('backEnd.couponcode.create');
    }
    public function store(Request $request){
        $this->validate($request,[
            'couponcode'=>'required',
            'expairdate'=>'required',
            'offertype'=>'required',
            'amount'=>'required',
            'buyammount'=>'required',
            'status'=>'required',
        ]);

        $input = $request->all();
        Couponcode::create($input);
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('couponcode.index');

    }
    public function edit($id)
    {
        $edit_data = Couponcode::find($id);
        return view('backEnd.couponcode.edit',compact('edit_data'));
    } 
    public function update(Request $request){    
        $update_data = Couponcode::find($request->id);
        $input = $request->all();
        $input['status'] = $request->status?1:0;
        $update_data->update($input);

        Toastr::success('Success','Data update successfully');
        return redirect()->route('couponcode.index');
    }
    public function inactive(Request $request)
    {
        $inactive = Couponcode::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Couponcode::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = Couponcode::find($request->hidden_id);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }
    
}
