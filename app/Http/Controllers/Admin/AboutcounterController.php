<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aboutcounter;
use Toastr;
use Image;
use File;
use DB;

class AboutcounterController extends Controller
{
     function __construct()
    {
         $this->middleware('permission:aboutcounter-list|aboutcounter-create|aboutcounter-edit|aboutcounter-delete', ['only' => ['index','store']]);
         $this->middleware('permission:aboutcounter-create', ['only' => ['create','store']]);
         $this->middleware('permission:aboutcounter-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:aboutcounter-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $show_data = Aboutcounter::orderBy('id','DESC')->get();
        return view('backEnd.aboutcounter.index',compact('show_data'));
    }
    public function create()
    {
        return view('backEnd.aboutcounter.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'count' => 'required',
            'status' => 'required',
        ]);

        
        $input = $request->all();
        Aboutcounter::create($input);
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('aboutcounter.index');
    }
    
    public function edit($id)
    {
        $edit_data = Aboutcounter::find($id);
        return view('backEnd.aboutcounter.edit',compact('edit_data'));
    }
    
    public function update(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'count' => 'required',
        ]);
        $update_data = Aboutcounter::find($request->hidden_id);
       
        $input = $request->except('hidden_id');

       
        
        $input['status'] = $request->status?1:0;
        $update_data->update($input);

        Toastr::success('Success','Data update successfully');
        return redirect()->route('aboutcounter.index');
    }
 
    public function inactive(Request $request)
    {
        $inactive = Aboutcounter::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Aboutcounter::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = Aboutcounter::find($request->hidden_id);
        File::delete($delete_data->image);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }
}
