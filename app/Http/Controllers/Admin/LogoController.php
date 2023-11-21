<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logo;
use Toastr;
use Image;
use File;

class LogoController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:logo-list|logo-create|logo-edit|logo-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:logo-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:logo-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:logo-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $show_data = Logo::orderBy('id', 'DESC')->get();
        return view('backEnd.logo.index', compact('show_data'));
    }
    public function create()
    {
        return view('backEnd.logo.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required',
            'status' => 'required',
        ]);
        // image with intervention
        $image = $request->file('image');
        $name = time() . '-' . $image->getClientOriginalName();
        $name = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp', $name);
        $name = strtolower(preg_replace('/\s+/', '-', $name));
        $uploadpath = 'public/uploads/logo/';
        $imageUrl = $uploadpath . $name;
        $img = Image::make($image->getRealPath());
        $img->encode('webp', 90);
        $width = 128;
        $height = 128;
        $img->height() > $img->width() ? ($width = null) : ($height = null);
        $img->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($imageUrl);

        $input = $request->all();
        $input['image'] = $imageUrl;
        // dd($input);
        Logo::create($input);
        Toastr::success('Success', 'Data insert successfully');
        return redirect()->route('logo.index');
    }

    public function edit($id)
    {
        $edit_data = Logo::find($id);
        return view('backEnd.logo.edit', compact('edit_data'));
    }

    public function update(Request $request)
    {
        return "ok";
        $this->validate($request, [
            'image' => 'required',
            'status' => 'required',
        ]);
        $update_data = Logo::find($request->hidden_id);
        $input = $request->all();
        return $input;
        $image = $request->file('image');
        if($image){
            // image with intervention 
            $name =  time().'-'.$image->getClientOriginalName();
            $name = preg_reLogoplace('"\.(jpg|jpeg|png|webp)$"', '.webp',$name);
            $name = strtolower(preg_replace('/\s+/', '-', $name));
            $uploadpath = 'public/uploads/logo/';
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

        Toastr::success('Success', 'Data update successfully');
        return redirect()->route('logo.index');
    }

    public function inactive(Request $request)
    {
        $inactive = Logo::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success', 'Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Logo::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success', 'Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = Logo::find($request->hidden_id);
        $delete_data->delete();
        Toastr::success('Success', 'Data delete successfully');
        return redirect()->back();
    }
}
