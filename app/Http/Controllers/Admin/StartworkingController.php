<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\Startworking;
use Toastr;
use Image;
use File;
use DB;

class StartworkingController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:startworking-list|startworking-create|startworking-edit|startworking-delete', ['only' => ['index','store']]);
         $this->middleware('permission:startworking-create', ['only' => ['create','store']]);
         $this->middleware('permission:startworking-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:startworking-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $show_data = Startworking::orderBy('id','DESC')->get();
        return view('backEnd.startworking.index',compact('show_data'));
    }
    public function create()
    {
        return view('backEnd.startworking.create');
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
        $uploadpath = 'public/uploads/startworking/';
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

        // image with intervention 
        $imageone = $request->file('iconimage');
        if($imageone !=NULL){
        $nameone =  time().'-'.$imageone->getClientOriginalName();
        $nameone = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$nameone);
        $nameone = strtolower(preg_replace('/\s+/', '-', $nameone));
        $uploadpathone = 'public/uploads/startworking/';
        $imageUrlone = $uploadpathone.$nameone; 
        $imgone=Image::make($imageone->getRealPath());
        $imgone->encode('webp', 90);
        $width = "";
        $height = "";
        $imgone->height() > $imgone->width() ? $width=null : $height=null;
        $imgone->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $imgone->save($imageUrlone);
        }else{
           $input['iconimage'] = NULL; 
        }


        $input = $request->all();
        $input['image'] = $imageUrl;
        Startworking::create($input);
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('startworkings.index');
    }
    
    public function edit($id)
    {
        $edit_data = Startworking::find($id);
        return view('backEnd.startworking.edit',compact('edit_data'));
    }
    
    public function update(Request $request)
    {
        $this->validate($request, [
            'title' => 'required'
        ]);
        $update_data = Startworking::find($request->hidden_id);
       
        $input = $request->except('hidden_id');

        // new white logo
        $image = $request->file('image');

        if($image){
            // image with intervention 
            $image = $request->file('image');
            $name =  time().'-'.$image->getClientOriginalName();
            $name = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$name);
            $name = strtolower(preg_replace('/\s+/', '-', $name));
            $uploadpath = 'public/uploads/settings/';
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
        $imageone = $request->file('iconimage');

        if($imageone){
            // image with intervention 
            $imageone = $request->file('iconimage');
            $nameone =  time().'-'.$imageone->getClientOriginalName();
            $nameone = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$nameone);
            $nameone = strtolower(preg_replace('/\s+/', '-', $nameone));
            $uploadpathone = 'public/uploads/startworking/';
            $imageUrlone = $uploadpathone.$nameone; 
            $imgone=Image::make($imageone->getRealPath());
            $imgone->encode('webp', 90);
            $width = "";
            $height = "";
            $imgone->height() > $imgone->width() ? $width=null : $height=null;
            $imgone->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
            $imgone->save($imageUrlone);
            $input['iconimage'] = $imageUrlone;
            File::delete($update_data->iconimage);
        }else{
            $input['iconimage'] = $update_data->iconimage;

        }
        
        $input['status'] = $request->status?1:0;
        $update_data->update($input);

        Toastr::success('Success','Data update successfully');
        return redirect()->route('startworkings.index');
    }
 
    public function inactive(Request $request)
    {
        $inactive = Startworking::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Startworking::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = Startworking::find($request->hidden_id);
        File::delete($delete_data->image);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }
}
