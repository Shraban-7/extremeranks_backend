<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\Team;
use Illuminate\Http\Request;

use Toastr;
use Image;
use File;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $show_data = Partner::paginate(12);
        return view('backEnd.partner.index', compact('show_data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $data = $request->validate([
            'name' => 'required|string',
            'url' => 'required|string',
            'status' => 'nullable|string',
            'image' => 'required|file|mimes:jpeg,png,gif',
        ]);

        $data['slug'] = strtolower(preg_replace('/[^a-zA-Z0-9\-]/', '', preg_replace('/\s+/', '-', $request->name)));

        $image = $request->file('image');
        if ($image) {
            $name4 =  time() . '-' . $image->getClientOriginalName();
            $name4 = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp', $name4);
            $name4 = strtolower(preg_replace('/\s+/', '-', $name4));
            $uploadpath = 'public/uploads/partner/';
            if (!file_exists($uploadpath)) {
                mkdir($uploadpath, 0755, true);
            }
            $imageUrl = $uploadpath . $name4;
            $img4 = Image::make($image->getRealPath());
            $img4->encode('webp', 90);
            $width4 = "";
            $height4 = "";
            $img4->height() > $img4->width() ? $width4 = null : $height4 = null;
            $img4->resize($width4, $height4, function ($constraint4) {
                $constraint4->aspectRatio();
            });
            $img4->save($imageUrl);
            $data['image'] = $imageUrl;
        }
        Partner::create($data);
        Toastr::success('Success', 'Data insert successfully');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $team = Partner::find($id);
        return view('backEnd.partner.edit', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $team = Partner::find($id);
        $data = $request->validate([
            'name' => 'required|string',
            'url' => 'nullable|string',
            'status' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpeg,png,gif',
        ]);

        $data['slug'] = strtolower(preg_replace('/[^a-zA-Z0-9\-]/', '', preg_replace('/\s+/', '-', $request->name)));

        $image = $request->file('image');
        if ($image) {
            File::delete($team->image);
            $name4 =  time() . '-' . $image->getClientOriginalName();
            $name4 = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp', $name4);
            $name4 = strtolower(preg_replace('/\s+/', '-', $name4));
            $uploadpath = 'public/uploads/partner/';
            if (!file_exists($uploadpath)) {
                mkdir($uploadpath, 0755, true);
            }
            $imageUrl = $uploadpath . $name4;
            $img4 = Image::make($image->getRealPath());
            $img4->encode('webp', 90);
            $width4 = "";
            $height4 = "";
            $img4->height() > $img4->width() ? $width4 = null : $height4 = null;
            $img4->resize($width4, $height4, function ($constraint4) {
                $constraint4->aspectRatio();
            });
            $img4->save($imageUrl);
            $data['image'] = $imageUrl;
        }
        $team->update($data);
        Toastr::success('Success', 'Data UPDATE successfully');
        return redirect()->route('partner.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $delete_data = Partner::find($request->hidden_id);
        File::delete($delete_data->image);
        $delete_data->delete();
        Toastr::success('Success', 'Data delete successfully');
        return redirect()->back();
    }
}
