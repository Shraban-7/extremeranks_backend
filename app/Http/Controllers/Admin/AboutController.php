<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\About;
use Toastr;
use Image;
use File;
use DB;

class AboutController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:about-list|about-create|about-edit|about-delete', ['only' => ['index','store']]);
         $this->middleware('permission:about-create', ['only' => ['create','store']]);
         $this->middleware('permission:about-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:about-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $show_data = About::orderBy('id','DESC')->get();
        return view('backEnd.about.index',compact('show_data'));
    }
    public function create()
    {
        return view('backEnd.about.create');
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
        $uploadpath = 'public/uploads/about/';
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
        $imageone = $request->file('imageone');
        $nameone =  time().'-'.$imageone->getClientOriginalName();
        $nameone = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$nameone);
        $nameone = strtolower(preg_replace('/\s+/', '-', $nameone));
        $uploadpathone = 'public/uploads/about/';
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
        
        // image with intervention 
        $imagetwo = $request->file('imagetwo');
        $nametwo =  time().'-'.$imagetwo->getClientOriginalName();
        $nametwo = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$nametwo);
        $nametwo = strtolower(preg_replace('/\s+/', '-', $nametwo));
        $uploadpathtwo = 'public/uploads/about/';
        $imageUrltwo = $uploadpathtwo.$nametwo; 
        $imgtwo=Image::make($imagetwo->getRealPath());
        $imgtwo->encode('webp', 90);
        $width = "";
        $height = "";
        $imgtwo->height() > $imgtwo->width() ? $width=null : $height=null;
        $imgtwo->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $imgtwo->save($imageUrltwo);
        
        $input = $request->all();
        // image with intervention 
        $imagethree = $request->file('imagethree');
        $namethree =  time().'-'.$imagethree->getClientOriginalName();
        $namethree = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$namethree);
        $namethree = strtolower(preg_replace('/\s+/', '-', $namethree));
        $uploadpaththree = 'public/uploads/about/';
        $imageUrlthree = $uploadpaththree.$namethree; 
        $imgthree=Image::make($imagethree->getRealPath());
        $imgthree->encode('webp', 90);
        $width = "";
        $height = "";
        $imgthree->height() > $imgthree->width() ? $width=null : $height=null;
        $imgthree->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $imgthree->save($imageUrlthree);
        
        // image with intervention 
        
        $image4 = $request->file('meta_image');
        if($image4){
        $name4 =  time().'-'.$image4->getClientOriginalName();
        $name4 = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$name4);
        $name4 = strtolower(preg_replace('/\s+/', '-', $name4));
        $uploadpath4 = 'public/uploads/about/';
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
        

        
        $input['image'] = $imageUrl;
        $input['imageone'] = $imageUrlone;
        $input['imagetwo'] = $imageUrltwo;
        $input['imagethree'] = $imageUrlthree;
        
        About::create($input);
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('about.index');
    }
    
    public function edit($id)
    {
        $edit_data = About::find($id);
        return view('backEnd.about.edit',compact('edit_data'));
    }
    
    public function update(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);
        $update_data = About::find($request->hidden_id);
       
        $input = $request->except('hidden_id');

        // new white logo
        $image = $request->file('image');

        if($image){
            // image with intervention 
            $image = $request->file('image');
            $name =  time().'-'.$image->getClientOriginalName();
            $name = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$name);
            $name = strtolower(preg_replace('/\s+/', '-', $name));
            $uploadpath = 'public/uploads/about/';
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
        
        $imageone = $request->file('imageone');
        if($imageone){
            // image with intervention 
            $imageone = $request->file('imageone');
            $nameone =  time().'-'.$imageone->getClientOriginalName();
            $nameone = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$nameone);
            $nameone = strtolower(preg_replace('/\s+/', '-', $nameone));
            $uploadpathone = 'public/uploads/about/';
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
            $input['imageone'] = $imageUrlone;
            File::delete($update_data->imageone);
        }else{
            $input['imageone'] = $update_data->imageone;

        }
        $imagetwo = $request->file('imagetwo');
        
        if($imagetwo){
            // image with intervention 
            $imagetwo = $request->file('imagetwo');
            $nametwo =  time().'-'.$imagetwo->getClientOriginalName();
            $nametwo = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$nametwo);
            $nametwo = strtolower(preg_replace('/\s+/', '-', $nametwo));
            $uploadpathtwo = 'public/uploads/about/';
            $imageUrltwo = $uploadpathtwo.$nametwo; 
            $imgtwo=Image::make($imagetwo->getRealPath());
            $imgtwo->encode('webp', 90);
            $width = "";
            $height = "";
            $imgtwo->height() > $imgtwo->width() ? $width=null : $height=null;
            $imgtwo->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
            $imgtwo->save($imageUrltwo);
            $input['imagetwo'] = $imageUrltwo;
            File::delete($update_data->imagetwo);
        }else{
            $input['imagetwo'] = $update_data->imagetwo;

        }
        $imagethree = $request->file('imagethree');
        
        if($imagethree){
            // image with intervention 
            $imagethree = $request->file('imagethree');
            $namethree =  time().'-'.$imagethree->getClientOriginalName();
            $namethree = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$namethree);
            $namethree = strtolower(preg_replace('/\s+/', '-', $namethree));
            $uploadpaththree = 'public/uploads/about/';
            $imageUrlthree = $uploadpaththree.$namethree; 
            $imgthree=Image::make($imagethree->getRealPath());
            $imgthree->encode('webp', 90);
            $width = "";
            $height = "";
            $imgthree->height() > $imgthree->width() ? $width=null : $height=null;
            $imgthree->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
            $imgthree->save($imageUrlthree);
            $input['imagethree'] = $imageUrlthree;
            File::delete($update_data->imagethree);
        }else{
            $input['imagethree'] = $update_data->imagethree;

        }
      
        $image4 = $request->file('meta_image');
        if($image4){
            $image4 = $request->file('meta_image');
            $name4 =  time().'-'.$image4->getClientOriginalName();
            $name4 = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$name4);
            $name4 = strtolower(preg_replace('/\s+/', '-', $name4));
            $uploadpath4 = 'public/uploads/about/';
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
      
        
        
        $input['status'] = $request->status?1:0;
        $update_data->update($input);

        Toastr::success('Success','Data update successfully');
        return redirect()->route('about.index');
    }
 
    public function inactive(Request $request)
    {
        $inactive = About::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = About::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = About::find($request->hidden_id);
        File::delete($delete_data->image);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }
}
