<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Researchwork;
use Toastr;
use Image;
use File;
use DB;

class ResearchworkController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:researchwork-list|researchwork-create|researchwork-edit|researchwork-delete', ['only' => ['index','store']]);
         $this->middleware('permission:researchwork-create', ['only' => ['create','store']]);
         $this->middleware('permission:researchwork-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:researchwork-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {

        $show_data = DB::table('researchworks')
        ->join('products','researchworks.product_id','=','products.id')
        ->select('researchworks.*','products.product_name')
        ->orderBy('researchworks.id','DESC')
        ->get();

        $products = Product::all();

        return view('backEnd.researchwork.index',compact('show_data','products'));
    }
    public function create()
    {
        return view('backEnd.researchwork.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'image' => 'required',
            'status' => 'required',
        ]);

        // image with intervention
        $image = $request->file('image');
        $name =  time().'-'.$image->getClientOriginalName();
        $name = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$name);
        $name = strtolower(preg_replace('/\s+/', '-', $name));
        $uploadpath = 'public/uploads/researchwork/';
        $imageUrl = $uploadpath.$name;
        $img=Image::make($image->getRealPath());
        $img->encode('webp', 90);
        $width = "";
        $height = "";
        $img->height() > $img->width() ? $width=null : $height=null;
        $img->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($imageUrl);

        $input = $request->all();
        $input['image'] = $imageUrl;
        Researchwork::create($input);
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('researchworks.index');
    }

    public function edit($id)
    {
        $edit_data = Researchwork::find($id);
        return view('backEnd.researchwork.edit',compact('edit_data'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);
        $update_data = Researchwork::find($request->hidden_id);

        $input = $request->except('hidden_id');

        // new white logo
        $image = $request->file('image');

        if($image){
            // image with intervention
            $image = $request->file('image');
            $name =  time().'-'.$image->getClientOriginalName();
            $name = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$name);
            $name = strtolower(preg_replace('/\s+/', '-', $name));
            $uploadpath = 'public/uploads/researchwork/';
            $imageUrl = $uploadpath.$name;
            $img=Image::make($image->getRealPath());
            $img->encode('webp', 90);
            $width = "";
            $height = "";
            $img->height() > $img->width() ? $width=null : $height=null;
            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($imageUrl);
            $input['image'] = $imageUrl;
            File::delete($update_data->image);
        }else{
            $input['image'] = $update_data->image;

        }


        $input['status'] = $request->status?1:0;
        $update_data->update($input);

        Toastr::success('Success','Data update successfully');
        return redirect()->route('researchworks.index');
    }

    public function inactive(Request $request)
    {
        $inactive = Researchwork::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Researchwork::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = Researchwork::find($request->hidden_id);
        File::delete($delete_data->image);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }
}
