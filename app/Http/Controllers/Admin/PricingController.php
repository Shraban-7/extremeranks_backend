<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pricing;
use App\Models\Package;
use App\Models\Attribute;
use Toastr;
use Image;
use File;
use DB;

class PricingController extends Controller
{


// ajax code

    public function getPackage(Request $request){
        $category = DB::table("packages")
            ->where("category_id", $request->category_id)
            ->pluck('name', 'id');
        return response()->json($category);
    }
    
    public function getAttribute(Request $request)
    {
        $category = DB::table("attributes")
            ->where("category_id", $request->category_id)
            ->pluck('title', 'id');
        return response()->json($category);
    }


    function __construct()
    {
         $this->middleware('permission:pricing-list|pricing-create|pricing-edit|pricing-delete', ['only' => ['index','store']]);
         $this->middleware('permission:pricing-create', ['only' => ['create','store']]);
         $this->middleware('permission:pricing-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:pricing-delete', ['only' => ['destroy']]);
    }




    public function index(Request $request)
    {

        $show_data = DB::table('pricings')
        ->join('categories','pricings.category_id','=','categories.id')
        ->select('pricings.*','categories.category_name')
        ->orderBy('pricings.id','DESC')
        ->get();

        $packages = Package::where('status',1)->orderBy('id','DESC')->get();
        $attributes = Attribute::where('status',1)->orderBy('id','DESC')->get();

        return view('backEnd.pricing.index',compact('show_data','packages','attributes'));
    }
    public function create()
    {
        $packages = Package::where('status',1)->orderBy('id','DESC')->get();
        $attributes = Attribute::where('status',1)->orderBy('id','DESC')->get();
        return view('backEnd.pricing.create',compact('packages','attributes'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'package_id' => 'required',
            'attribute_id' => 'required',
            'slug' => 'required',
            'status' => 'required',
        ]);

        
        $input = $request->all();
        $input['slug'] = strtolower(preg_replace('/[^a-zA-Z0-9\-]/', '', preg_replace('/\s+/', '-', $request->slug)));
        Pricing::create($input);
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('pricings.index');
    }
    
    public function edit($id)
    {
        $edit_data = Pricing::find($id);
        $packages = Package::where('status',1)->orderBy('id','DESC')->get();
        $attributes = Attribute::where('status',1)->orderBy('id','DESC')->get();
        return view('backEnd.pricing.edit',compact('edit_data','packages','attributes'));
    }
    
    public function update(Request $request)
    {
         $this->validate($request, [
            'package_id' => 'required',
            'attribute_id' => 'required',
            'slug' => 'required',
            'status' => 'required',
        ]);
        $update_data = Pricing::find($request->hidden_id);
       
        $input = $request->except('hidden_id');
        $input['slug'] = strtolower(preg_replace('/[^a-zA-Z0-9\-]/', '', preg_replace('/\s+/', '-', $request->slug)));
        $input['status'] = $request->status?1:0;
        $update_data->update($input);

        Toastr::success('Success','Data update successfully');
        return redirect()->route('pricings.index');
    }
 
    public function inactive(Request $request)
    {
        $inactive = Pricing::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Pricing::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = Pricing::find($request->hidden_id);
        File::delete($delete_data->image);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }
}
