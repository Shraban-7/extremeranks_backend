<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Toastr;
use Image;
use File;
use DB;
class ContactController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:contact-list|contact-create|contact-edit|contact-delete', ['only' => ['index','store']]);
         $this->middleware('permission:contact-create', ['only' => ['create','store']]);
         $this->middleware('permission:contact-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:contact-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $show_data = Contact::orderBy('id','DESC')->get();
        return view('backEnd.contact.index',compact('show_data'));
    }
    public function create()
    {
        return view('backEnd.contact.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required',
            'status' => 'required',
        ]);
        $input = $request->all();
        
         $image4 = $request->file('meta_image');
        if($image4){
        $name4 =  time().'-'.$image4->getClientOriginalName();
        $name4 = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$name4);
        $name4 = strtolower(preg_replace('/\s+/', '-', $name4));
        $uploadpath4 = 'public/uploads/contactus/';
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
        
        Contact::create($input);
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('contact.index');
    }
    
    public function edit($id)
    {
        $edit_data = Contact::find($id);
        return view('backEnd.contact.edit',compact('edit_data'));
    }
    
    public function update(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required',
        ]);
        $update_data = Contact::find($request->hidden_id);
        
        $input = $request->except('hidden_id');
        
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
        
        $image4 = $request->file('meta_image');
        if($image4){
        $name4 =  time().'-'.$image4->getClientOriginalName();
        $name4 = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$name4);
        $name4 = strtolower(preg_replace('/\s+/', '-', $name4));
        $uploadpath4 = 'public/uploads/contactus/';
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
        
        $update_data->update($input);

        Toastr::success('Success','Data update successfully');
        return redirect()->route('contact.index');
    }
 
    public function inactive(Request $request)
    {
        $inactive = Contact::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Contact::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = Contact::find($request->hidden_id);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }
}
