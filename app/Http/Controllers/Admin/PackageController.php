<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\Package;
use App\Models\Pricing;
use App\Models\Product;
use App\Models\Service;
use Toastr;
use Image;
use File;
use DB;

class PackageController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:package-list|package-create|package-edit|package-delete', ['only' => ['index','store']]);
         $this->middleware('permission:package-create', ['only' => ['create','store']]);
         $this->middleware('permission:package-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:package-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {

        $show_data = DB::table('packages')
        ->join('products','packages.product_id','=','products.id')
        ->select('packages.*','products.product_name')
        ->orderBy('packages.id','DESC')
        ->get();

        $services= Product::all();


        // return $show_data;

        return view('backEnd.package.index',compact('show_data','services'));
    }
    public function create()
    {
        return view('backEnd.package.create');
    }
    public function store(Request $request)
    {

        // return $request->all();
        $this->validate($request, [
            'product_id' => 'required',
            'name' => 'required',
            'price' => 'required',
            'status' => 'required',
        ]);

        $input['type'] = 1;
        $input = $request->all();
        Package::create($input);
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('packages.index');
    }

    public function edit($id)
    {
        $edit_data = Package::find($id);
        $products= Product::all();
        return view('backEnd.package.edit',compact('edit_data','products'));
    }


    public function update(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'product_id' => 'required',
            'name' => 'required',
            'price' => 'required',
            'status' => 'required',
        ]);

        $update_data = Package::find($request->hidden_id);
        $input = $request->except('hidden_id');
        $input['status'] = $request->status?1:0;
        $update_data->update($input);

        Toastr::success('Success','Data update successfully');
        return redirect()->route('packages.index');
    }

    public function inactive(Request $request)
    {
        $inactive = Package::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Package::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = Package::find($request->hidden_id);
        File::delete($delete_data->image);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }

    public function price($id)
    {
        $package = Package::find($id);
        $category = Category::find($package->category_id);
        $attributes = Attribute::where('category_id',$package->category_id)->where('status',1)->get();
        return view('backEnd.package.price',compact('package','category','attributes'));
    }
    public function price_store(Request $request)
    {

        $ids         = array_filter($request->attribute_id);
        $value       = $request->attribute_value;
        $package_id  = $request->package_id;
        $category_id = $request->category_id;
        if($ids){
            foreach($ids as $key=>$id)
            {
                $exists = Pricing::where(['attribute_id'=>$id,'package_id'=>$request->package_id])->first();
                if(!$exists){
                    $saveprice                   = new Pricing();
                    $saveprice->category_id      = $category_id;
                    $saveprice->package_id       = $package_id;
                    $saveprice->attribute_id     = $id;
                    $saveprice->attribute_value  = $value[$key];
                    $saveprice->save();
                }else{
                    $editprice                   = Pricing::find($exists->id);
                    $editprice->category_id      = $category_id;
                    $editprice->package_id       = $package_id;
                    $editprice->attribute_id     = $id;
                    $editprice->attribute_value  = $value[$key];
                    $editprice->save();
                }
            }
        }
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('packages.index');
    }
}
