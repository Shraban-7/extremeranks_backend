<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Createpage;
use Toastr;
use Image;
use File;
use DB;

class CreatepageController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:createpage-list|createpage-create|createpage-edit|createpage-delete', ['only' => ['index','store']]);
         $this->middleware('permission:createpage-create', ['only' => ['create','store']]);
         $this->middleware('permission:createpage-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:createpage-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $show_data = Createpage::orderBy('id','DESC')->get();
        return view('backEnd.createpage.index',compact('show_data'));
    }
    public function create()
    {
        return view('backEnd.createpage.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'pagename' => 'required',
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        $input = $request->all();
        
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
        
        $input['slug'] = strtolower(preg_replace('/[^a-zA-Z0-9\-]/', '', preg_replace('/\s+/', '-', $request->pagename)));

        Createpage::create($input);
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('createpage.index');
    }
    
    public function edit($id)
    {
        $edit_data = Createpage::find($id);
        return view('backEnd.createpage.edit',compact('edit_data'));
    }
    
    public function update(Request $request)
    {
        $this->validate($request, [
            'pagename' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);
        $update_data = Createpage::find($request->hidden_id);
       
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
        
        $input['slug'] = strtolower(preg_replace('/[^a-zA-Z0-9\-]/', '', preg_replace('/\s+/', '-', $request->pagename)));
        
        $input['status'] = $request->status?1:0;
        $update_data->update($input);

        Toastr::success('Success','Data update successfully');
        return redirect()->route('createpage.index');
    }
 
    public function inactive(Request $request)
    {
        $inactive = Createpage::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Createpage::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = Createpage::find($request->hidden_id);
        File::delete($delete_data->image);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }
}
