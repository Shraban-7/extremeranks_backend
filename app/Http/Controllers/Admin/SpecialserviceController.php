<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Specialservice;
use Toastr;
use Image;
use File;
use DB;

class SpecialserviceController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:specialservice-list|specialservice-create|specialservice-edit|specialservice-delete', ['only' => ['index','store']]);
         $this->middleware('permission:specialservice-create', ['only' => ['create','store']]);
         $this->middleware('permission:specialservice-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:specialservice-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $show_data = Specialservice::orderBy('id','DESC')->get();
        return view('backEnd.specialservice.index',compact('show_data'));
    }
    public function create()
    {
        return view('backEnd.specialservice.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'link' => 'required',
            'description' => 'required',
            'image' => 'required',
            'status' => 'required',
        ]);

        // image with intervention 
        $image = $request->file('image');
        $name =  time().'-'.$image->getClientOriginalName();
        $name = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$name);
        $name = strtolower(preg_replace('/\s+/', '-', $name));
        $uploadpath = 'public/uploads/specialservice/';
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
        Specialservice::create($input);
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('specialservices.index');
    }
    
    public function edit($id)
    {
        $edit_data = Specialservice::find($id);
        return view('backEnd.specialservice.edit',compact('edit_data'));
    }
    
    public function update(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'link' => 'required',
            'description' => 'required',
        ]);
        $update_data = Specialservice::find($request->hidden_id);
       
        $input = $request->except('hidden_id');

        // new white logo
        $image = $request->file('image');

        if($image){
            // image with intervention 
            $image = $request->file('image');
            $name =  time().'-'.$image->getClientOriginalName();
            $name = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$name);
            $name = strtolower(preg_replace('/\s+/', '-', $name));
            $uploadpath = 'public/uploads/specialservice/';
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
        return redirect()->route('specialservices.index');
    }
 
    public function inactive(Request $request)
    {
        $inactive = Specialservice::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Specialservice::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = Specialservice::find($request->hidden_id);
        File::delete($delete_data->image);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }
}
