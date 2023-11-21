<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Needleitem;
use Toastr;
use Image;
use File;
use DB;


class NeedleitemController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:needleitem-list|needleitem-create|needleitem-edit|needleitem-delete', ['only' => ['index','store']]);
         $this->middleware('permission:needleitem-create', ['only' => ['create','store']]);
         $this->middleware('permission:needleitem-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:needleitem-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $show_data = Needleitem::orderBy('id','DESC')->get();
        return view('backEnd.needleitem.index',compact('show_data'));
    }
    public function create()
    {
        return view('backEnd.needleitem.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'type' => 'required',
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        $input = $request->all();
        Needleitem::create($input);
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('needleitem.index');
    }
    
    public function edit($id)
    {
        $edit_data = Needleitem::find($id);
        return view('backEnd.needleitem.edit',compact('edit_data'));
    }
    
    public function update(Request $request)
    {
        $this->validate($request, [
            'type' => 'required',
            'title' => 'required',
        ]);
        $update_data = Needleitem::find($request->hidden_id);
        $input = $request->except('hidden_id');

        
        $input['status'] = $request->status?1:0;
        $update_data->update($input);

        Toastr::success('Success','Data update successfully');
        return redirect()->route('needleitem.index');
    }
 
    public function inactive(Request $request)
    {
        $inactive = Needleitem::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Needleitem::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = Needleitem::find($request->hidden_id);
        File::delete($delete_data->image);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }
}
