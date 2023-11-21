<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sectiontitlecategory;
use App\Models\Sectiontitle;
use Toastr;
use Image;
use File;
use DB;

class SectiontitleController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:sectiontitle-list|sectiontitle-create|sectiontitle-edit|sectiontitle-delete', ['only' => ['index','store']]);
         $this->middleware('permission:sectiontitle-create', ['only' => ['create','store']]);
         $this->middleware('permission:sectiontitle-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:sectiontitle-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {

        $show_data = DB::table('sectiontitles')
        ->join('sectiontitlecategories','sectiontitles.sectiontitlecat_id','=','sectiontitlecategories.id')
        ->select('sectiontitles.*','sectiontitlecategories.name')
        ->orderBy('sectiontitles.id','DESC')
        ->get();
        
        $sectiontitlecategories = Sectiontitlecategory::get();

        return view('backEnd.sectiontitle.index',compact('show_data','sectiontitlecategories'));
    }
    
    public function create()
    {
        return view('backEnd.sectiontitle.create');
    }
    public function store(Request $request)
    {
        
        $this->validate($request, [
            'sectiontitlecat_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        $input = $request->all();
        Sectiontitle::create($input);
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('sectiontitle.index');
    }
    
    public function edit($id)
    {
        $edit_data = Sectiontitle::find($id);
        $sectiontitlecategories = Sectiontitlecategory::get();
        return view('backEnd.sectiontitle.edit',compact('edit_data','sectiontitlecategories'));
    }
    
    public function update(Request $request)
    {
        $this->validate($request, [
            'sectiontitlecat_id' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);
        $update_data = Sectiontitle::find($request->hidden_id);
       
        $input = $request->except('hidden_id');
        
        $input['status'] = $request->status?1:0;
        $update_data->update($input);

        Toastr::success('Success','Data update successfully');
        return redirect()->route('sectiontitle.index');
    }
 
    public function inactive(Request $request)
    {
        $inactive = Sectiontitle::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Sectiontitle::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = Sectiontitle::find($request->hidden_id);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }

}
