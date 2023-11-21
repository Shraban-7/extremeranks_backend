<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Country;
use Toastr;
use Image;
use File;
use DB;

class StateController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:state-list|state-create|state-edit|state-delete', ['only' => ['index','store']]);
         $this->middleware('permission:state-create', ['only' => ['create','store']]);
         $this->middleware('permission:state-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:state-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $show_data = DB::table('states')
        ->join('countries','states.country_id','=','countries.id')
        ->select('states.*','countries.name')
        ->orderBy('states.id','DESC')
        ->get();
        $countries = Country::all();
        return view('backEnd.state.index',compact('show_data','countries'));
    }
    public function create()
    {
        $countries = Country::all();
        return view('backEnd.state.create',compact('countries'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'country_id' => 'required',
            'statename' => 'required',
            'status' => 'required',
        ]);

        $input = $request->all();
        State::create($input);
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('state.index');
    }
    
    public function edit($id)
    {
        $edit_data = State::find($id);
        $countries = Country::all();
        return view('backEnd.state.edit',compact('edit_data','countries'));
    }
    
    public function update(Request $request)
    {
        $this->validate($request, [
            'country_id' => 'required',
            'statename' => 'required',
            'status' => 'required',
        ]);

        $update_data = State::find($request->hidden_id);
        $input = $request->except('hidden_id');
        
        $input['status'] = $request->status?1:0;
        $update_data->update($input);

        Toastr::success('Success','Data update successfully');
        return redirect()->route('state.index');
    }
 
    public function inactive(Request $request)
    {
        $inactive = State::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = State::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = State::find($request->hidden_id);
        File::delete($delete_data->image);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }
}
