<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Counter;
use Toastr;
use Image;
use File;
use DB;

class CounterController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:counter-list|counter-create|counter-edit|counter-delete', ['only' => ['index','store']]);
         $this->middleware('permission:counter-create', ['only' => ['create','store']]);
         $this->middleware('permission:counter-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:counter-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {

        $show_data = DB::table('counters')
        ->join('categories','counters.category_id','=','categories.id')
        ->select('counters.*','categories.category_name')
        ->orderBy('counters.id','DESC')
        ->get();

        return view('backEnd.counter.index',compact('show_data'));
    }
    public function create()
    {
        return view('backEnd.counter.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'category_id' => 'required',
            'count' => 'required',
            'status' => 'required',
        ]);

        $input = $request->all();
        Counter::create($input);
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('counters.index');
    }
    
    public function edit($id)
    {
        $edit_data = Counter::find($id);
        return view('backEnd.counter.edit',compact('edit_data'));
    }
    
    public function update(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'category_id' => 'required',
            'count' => 'required',
        ]);
        $update_data = Counter::find($request->hidden_id);
       
        $input = $request->except('hidden_id');

       
        
        $input['status'] = $request->status?1:0;
        $update_data->update($input);

        Toastr::success('Success','Data update successfully');
        return redirect()->route('counters.index');
    }
 
    public function inactive(Request $request)
    {
        $inactive = Counter::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Counter::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = Counter::find($request->hidden_id);
        File::delete($delete_data->image);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }
}
