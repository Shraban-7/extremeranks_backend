<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Deliveryfile;
use Toastr;
use Image;
use File;
use DB;
use Auth;

class DeliveryfileController extends Controller
{
   
   
   public function deliveryfile_save(Request $request){
      
    	$this->validate($request,[
            'projectfile'=>'required',
        ]);

        // image upload
       $file = $request->file('projectfile');
		
        $name =  time().'-'.$file->getClientOriginalName();
        $uploadpath = 'public/uploads/deliveryfile/';
        $file->move($uploadpath, $name);
        $fileUrl = $uploadpath.$name;
		

        $store_data = new Deliveryfile();
        $store_data->admin_id           = Auth::user()->id;
        $store_data->order_id           = $request->id;
        $store_data->customer_id        = $request->customer_id;
        $store_data->note               = $request->note;
        $store_data->projectfile        = $fileUrl;
        // return $store_data;
        $store_data->save();
        Toastr::success('message', 'Project file  add successfully!');
    	return redirect()->back();
   
   }
   
}
