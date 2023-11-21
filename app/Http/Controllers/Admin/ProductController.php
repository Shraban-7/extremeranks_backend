<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Service;
use DB;
// use App\Models\Product;
use File;
use Illuminate\Http\Request;
use Image;
use Toastr;

class ProductController extends Controller
{
    // function __construct()
    // {
    //      $this->middleware('permission:service-list|service-create|service-edit|service-delete', ['only' => ['index','store']]);
    //      $this->middleware('permission:service-create', ['only' => ['create','store']]);
    //      $this->middleware('permission:service-edit', ['only' => ['edit','update']]);
    //      $this->middleware('permission:service-delete', ['only' => ['destroy']]);
    // }

    public function index(Request $request)
    {

        $show_data = DB::table('products')
            ->join('services', 'products.service_id', '=', 'services.id')
            ->select('products.*', 'services.service_name')
            ->orderBy('products.id', 'DESC')
            ->get();

        $services = Service::all();

        return view('backEnd.product.index', compact('show_data', 'services'));
    }
    public function create()
    {
        return view('backEnd.product.create');
    }
    public function store(Request $request)
    {

        // return $request->all();
        $this->validate($request, [
            'product_name' => 'required',
            'description' => 'required',
            'image' => 'required',
            'status' => 'required',
        ]);

        // image with intervention
        $image = $request->file('image');
        $name = time() . '-' . $image->getClientOriginalName();
        $name = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp', $name);
        $name = strtolower(preg_replace('/\s+/', '-', $name));
        $uploadpath = 'public/uploads/product/';
        if (!file_exists($uploadpath)) {
            mkdir($uploadpath, 0755, true);
        }
        $imageUrl = $uploadpath . $name;
        $img = Image::make($image->getRealPath());
        $img->encode('webp', 90);
        $width = "";
        $height = "";
        $img->height() > $img->width() ? $width = null : $height = null;
        $img->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($imageUrl);

        $input = $request->all();
        $input['image'] = $imageUrl;

        return $request->all();
        Product::create($input);
        Toastr::success('Success', 'Data insert successfully');
        return redirect()->route('products.index');
    }

    public function edit($id)
    {
        $edit_data = Product::find($id);
        $services = Service::all();
        return view('backEnd.product.edit', compact('edit_data', 'services'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'product_name' => 'required',
            'description' => 'required',
        ]);

        $update_data = Product::find($request->hidden_id);

        $input = $request->except('hidden_id');

        // Check if a new image is uploaded
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '-' . $image->getClientOriginalName();
            $name = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp', $name);
            $name = strtolower(preg_replace('/\s+/', '-', $name));
            $uploadpath = 'public/uploads/product/';
            $imageUrl = $uploadpath . $name;

            $img = Image::make($image->getRealPath());
            $img->encode('webp', 90);
            $width = "";
            $height = "";
            $img->height() > $img->width() ? $width = null : $height = null;
            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($imageUrl);

            // Delete the previous image
            File::delete($update_data->image);

            // Update the image field
            $input['image'] = $imageUrl;
        }

        // Update other fields
        $input['status'] = $request->status ? 1 : 0;
        $update_data->update($input);

        Toastr::success('Success', 'Data update successfully');
        return redirect()->route('products.index');
    }

    public function inactive(Request $request)
    {
        $inactive = Product::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success', 'Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Product::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success', 'Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = Product::find($request->hidden_id);
        File::delete($delete_data->image);
        $delete_data->delete();
        Toastr::success('Success', 'Data delete successfully');
        return redirect()->back();
    }
}
