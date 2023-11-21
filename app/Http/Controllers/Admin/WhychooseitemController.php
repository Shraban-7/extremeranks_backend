<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Whychooseitem;
use Toastr;
use Image;
use File;
use DB;

class WhychooseitemController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:whychooseitem-list|whychooseitem-create|whychooseitem-edit|whychooseitem-delete', ['only' => ['index','store']]);
         $this->middleware('permission:whychooseitem-create', ['only' => ['create','store']]);
         $this->middleware('permission:whychooseitem-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:whychooseitem-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $show_data = Whychooseitem::orderBy('id','DESC')->get();
        return view('backEnd.whychooseitem.index',compact('show_data'));
    }
    public function create()
    {
        return view('backEnd.whychooseitem.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        
        $input = $request->all();
        Whychooseitem::create($input);
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('whychooseitems.index');
    }
    
    public function edit($id)
    {
        $edit_data = Whychooseitem::find($id);
        return view('backEnd.whychooseitem.edit',compact('edit_data'));
    }
    
    public function update(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);
        $update_data = Whychooseitem::find($request->hidden_id);
       
        $input = $request->except('hidden_id');
        
        $input['status'] = $request->status?1:0;
        $update_data->update($input);

        Toastr::success('Success','Data update successfully');
        return redirect()->route('whychooseitems.index');
    }
 
    public function inactive(Request $request)
    {
        $inactive = Whychooseitem::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Whychooseitem::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = Whychooseitem::find($request->hidden_id);
        File::delete($delete_data->image);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }
}
