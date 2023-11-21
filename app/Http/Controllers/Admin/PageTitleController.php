<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageTitle;
use Toastr;
class PageTitleController extends Controller
{
    function __construct()
    {
         // $this->middleware('permission:pagetitle-list|pagetitle-create|pagetitle-edit|pagetitle-delete', ['only' => ['index','store']]);
         // $this->middleware('permission:pagetitle-create', ['only' => ['create','store']]);
         // $this->middleware('permission:pagetitle-edit', ['only' => ['edit','update']]);
         // $this->middleware('permission:pagetitle-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $show_data = PageTitle::orderBy('id','DESC')->get();
        return view('backEnd.pagetitle.index',compact('show_data'));
    }
    public function create()
    {
        return view('backEnd.pagetitle.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'subtitle' => 'required',
            'status' => 'required',
        ]);

        $input = $request->all();
        PageTitle::create($input);
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('pagetitle.index');
    }
    
    public function edit($id)
    {
        $edit_data = PageTitle::find($id);
        return view('backEnd.pagetitle.edit',compact('edit_data'));
    }
    
    public function update(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'subtitle' => 'required',
            'status' => 'required',
        ]);
        $update_data = PageTitle::find($request->hidden_id);
       
        $input = $request->except('hidden_id');
        $input['status'] = $request->status?1:0;
        $update_data->update($input);

        Toastr::success('Success','Data update successfully');
        return redirect()->route('pagetitle.index');
    }
 
    public function inactive(Request $request)
    {
        $inactive = PageTitle::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = PageTitle::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = PageTitle::find($request->hidden_id);
        File::delete($delete_data->image);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }
}
