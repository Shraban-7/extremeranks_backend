<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Toastr;
use Image;
use File;

class ServiceController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:category-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:category-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $show_data = Service::orderBy('id', 'DESC')->get();
        return view('backEnd.service.index', compact('show_data'));
    }
    public function create()
    {
        return view('backEnd.service.create');
    }
    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'service_name' => 'required',
            'status' => 'required',
        ]);


        $input = $request->all();

        $image4 = $request->file('image');
        if($image4){
        $name4 =  time().'-'.$image4->getClientOriginalName();
        $name4 = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$name4);
        $name4 = strtolower(preg_replace('/\s+/', '-', $name4));
        $uploadpath4 = 'public/uploads/service/';
        if (!file_exists($uploadpath4)) {
            mkdir($uploadpath4, 0755, true);
        }
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
        $input['image'] = $image4Url;
        }
        else{
           $input['image'] = NULL;
        }

        $input['slug'] = strtolower(preg_replace('/[^a-zA-Z0-9\-]/', '', preg_replace('/\s+/', '-', $request->service_name)));
        Service::create($input);
        Toastr::success('Success', 'Data insert successfully');
        return redirect()->route('services.index');
    }

    public function edit($id)
    {
        $edit_data = Service::find($id);
        return view('backEnd.service.edit', compact('edit_data'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'service_name' => 'required',
            'status' => 'required',
        ]);
        $update_data = Service::find($request->id);

        $input = $request->all();


         $image4 = $request->file('image');
        if($image4){
            $image4 = $request->file('image');
            $name4 =  time().'-'.$image4->getClientOriginalName();
            $name4 = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$name4);
            $name4 = strtolower(preg_replace('/\s+/', '-', $name4));
            $uploadpath4 = 'public/uploads/service/';
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
            $input['image'] = $image4Url;
            File::delete($update_data->image);
        }else{
            $input['image'] = $update_data->image;
        }

        //$input['slug'] = strtolower(preg_replace('/[^a-zA-Z0-9\-]/', '', preg_replace('/\s+/', '-', $request->category_name)));

        $input['status'] = $request->status?1:0;
        $update_data->update($input);

        Toastr::success('Success', 'Data update successfully');
        return redirect()->route('services.index');
    }

    public function inactive(Request $request)
    {
        $inactive = Service::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success', 'Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Service::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success', 'Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = Service::find($request->hidden_id);
        File::delete($delete_data->image);
        $delete_data->delete();
        Toastr::success('Success', 'Data delete successfully');
        return redirect()->back();
    }
}
