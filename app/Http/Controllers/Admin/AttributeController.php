<?php

namespace App\Http\Controllers\Admin;

use DB;
use File;
use Image;
use Toastr;
use App\Models\Product;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttributeController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:attribute-list|attribute-create|attribute-edit|attribute-delete', ['only' => ['index','store']]);
         $this->middleware('permission:attribute-create', ['only' => ['create','store']]);
         $this->middleware('permission:attribute-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:attribute-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {

        $show_data = DB::table('attributes')
        ->join('products','attributes.product_id','=','products.id')
        ->select('attributes.*','products.product_name')
        ->orderBy('attributes.id','DESC')
        ->get();

        $products= Product::all();

        return view('backEnd.attribute.index',compact('show_data','products'));
    }
    public function create()
    {
        return view('backEnd.attribute.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required',
            'title' => 'required',
            'type' => 'required',
            'status' => 'required',
        ]);


        $input = $request->all();
        Attribute::create($input);
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('attributes.index');
    }

    public function edit($id)
    {
        $edit_data = Attribute::find($id);
        $products= Product::all();
        return view('backEnd.attribute.edit',compact('edit_data','products'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required',
            'title' => 'required',
            'type' => 'required',
            'status' => 'required',
        ]);

        $update_data = Attribute::find($request->hidden_id);

        $input = $request->except('hidden_id');
        $input['status'] = $request->status?1:0;
        $update_data->update($input);

        Toastr::success('Success','Data update successfully');
        return redirect()->route('attributes.index');
    }

    public function inactive(Request $request)
    {
        $inactive = Attribute::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Attribute::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = Attribute::find($request->hidden_id);
        File::delete($delete_data->image);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }
}
