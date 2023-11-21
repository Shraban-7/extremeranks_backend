<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blogcategory;
use Toastr;
use Image;
use File;

class BlogcategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:blogcategory-list|blogcategory-create|blogcategory-edit|blogcategory-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:blogcategory-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:blogcategory-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:blogcategory-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {

        $show_data = Blogcategory::orderBy('id', 'DESC')->get();
        return view('backEnd.blogcategory.index', compact('show_data'));
    }
    public function create()
    {
        return view('backEnd.blogcategory.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required',
        ]);
        

        $input = $request->all();
        
        $image4 = $request->file('meta_image');
        if($image4){
        $name4 =  time().'-'.$image4->getClientOriginalName();
        $name4 = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$name4);
        $name4 = strtolower(preg_replace('/\s+/', '-', $name4));
        $uploadpath4 = 'public/uploads/blogcategory/';
        $image4Url = $uploadpath4.$name4; 
        $img4=Image::make($image4->getRealPath());
        $img4->encode('webp', 90);
        $width4 = "";
        $height4 = "";
        $img4->height() > $img4->width() ? $width4=null : $height4=null;
        $img4->resize($width4, $height4, function ($constraint4) {
            $constraint4->aspectRatio();
        });
        $img4->save($image4Url);
        $input['meta_image'] = $image4Url;
        }
        else{
           $input['image'] = NULL;
        }
        
        $input['slug'] = strtolower(preg_replace('/[^a-zA-Z0-9\-]/', '', preg_replace('/\s+/', '-', $request->name)));
        Blogcategory::create($input);
        Toastr::success('Success', 'Data insert successfully');
        return redirect()->route('blogcategories.index');
    }

    public function edit($id)
    {
        $edit_data = Blogcategory::find($id);
        return view('backEnd.blogcategory.edit', compact('edit_data'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required',
        ]);
        $update_data = Blogcategory::find($request->hidden_id);
        $input = $request->except('hidden_id');
        
        $image4 = $request->file('meta_image');
        if($image4){
            $image4 = $request->file('meta_image');
            $name4 =  time().'-'.$image4->getClientOriginalName();
            $name4 = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$name4);
            $name4 = strtolower(preg_replace('/\s+/', '-', $name4));
            $uploadpath4 = 'public/uploads/blogcategory/';
            $image4Url = $uploadpath4.$name4; 
            $img4=Image::make($image4->getRealPath());
            $img4->encode('webp', 90);
            $width4 = "";
            $height4 = "";
            $img4->height() > $img4->width() ? $width4=null : $height4=null;
            $img4->resize($width4, $height4, function ($constraint4) {
                $constraint4->aspectRatio();
            });
            $img4->save($image4Url);
            $input['meta_image'] = $image4Url;
            File::delete($update_data->meta_image);
        }else{
            $input['meta_image'] = $update_data->meta_image;
        }
        
        $input['slug'] = strtolower(preg_replace('/[^a-zA-Z0-9\-]/', '', preg_replace('/\s+/', '-', $request->name)));

        $input['status'] = $request->status?1:0;
        $update_data->update($input);

        Toastr::success('Success', 'Data update successfully');
        return redirect()->route('blogcategories.index');
    }

    public function inactive(Request $request)
    {
        $inactive = Blogcategory::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success', 'Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Blogcategory::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success', 'Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = Blogcategory::find($request->hidden_id);
        $delete_data->delete();
        Toastr::success('Success', 'Data delete successfully');
        return redirect()->back();
    }
}
