<?php

namespace App\Http\Controllers\Admin;

use DB;
use File;
use Image;
use Toastr;
use App\Models\Faq;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FaqController extends Controller
{
     function __construct()
    {
         $this->middleware('permission:faq-list|faq-create|faq-edit|faq-delete', ['only' => ['index','store']]);
         $this->middleware('permission:faq-create', ['only' => ['create','store']]);
         $this->middleware('permission:faq-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:faq-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {

        $show_data = DB::table('faqs')
        ->join('products','faqs.product_id','=','products.id')
        ->select('faqs.*','products.product_name')
        ->orderBy('faqs.id','DESC')
        ->get();

        $products = Product::all();

        return view('backEnd.faq.index',compact('show_data','products'));
    }
    public function create()
    {
        return view('backEnd.faq.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        $input = $request->all();
        Faq::create($input);
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('faq.index');
    }

    public function edit($id)
    {
        $edit_data = Faq::find($id);
        $products=Product::all();
        return view('backEnd.faq.edit',compact('edit_data','products'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        $update_data = Faq::find($request->hidden_id);
        $input = $request->except('hidden_id');

        $input['status'] = $request->status?1:0;
        $update_data->update($input);

        Toastr::success('Success','Data update successfully');
        return redirect()->route('faq.index');
    }

    public function inactive(Request $request)
    {
        $inactive = Faq::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Faq::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = Faq::find($request->hidden_id);
        File::delete($delete_data->image);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }
}
