<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;
use Session;
use Toastr;
use Auth;
class DashboardController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth')->except(['locked','unlocked']);
    }
    public function dashboard(){
        $total_income = Order::whereIn('order_status',[3,4])->sum('total');
        $monthly_income = Order::whereIn('order_status',[3,4])->whereMonth('created_at', Carbon::now()->month)->sum('total');
        $today_income = Order::whereIn('order_status',[3,4])->whereDate('created_at', Carbon::today())->sum('total');
        $cancel_payment = Order::where(['order_status'=>5])->whereDate('created_at', Carbon::today())->sum('total');
        $complete_order = Order::whereIn('order_status',[3,4])->count();
        $active_order = Order::count();
        $unpaid_order = Order::where(['order_status'=>2])->count();
        $cancel_order = Order::where(['order_status'=>5])->count();

        $arrow_up = asset('public/backend/assets/images/north.png');
        $arrow_down = asset('public/backend/assets/images/north-down.png');

        // income reports
        $prev_monincome = Order::whereMonth('created_at', now()->subMonth()->month)->sum('total');
        $current_monincome = Order::whereIn('order_status',[3,4])->whereMonth('created_at', now()->month)->sum('total');
        if ($prev_monincome == 0) {
             $income_report = '<span class="green_c"><img src="' .$arrow_up.'" >100% </span> Since last month';
        } else {
            $precent = (($current_monincome - $prev_monincome) / $prev_monincome) * 100;
            if ($precent > 0) {
               $income_report = '<span class="green_c"><img src="' . $arrow_up . '" >100% </span> Since last month';
            }else{
                $income_report = '<span class="red_c"><img src="' . $arrow_down . '" >100% </span> Since last month';
            }
        }
        // earning reports
        $prev_moninearn = Order::whereIn('order_status',[3,4])->whereMonth('created_at', now()->subMonth()->month)->sum('total');
        $current_moniearn = Order::whereIn('order_status',[3,4])->whereMonth('created_at', now()->month)->sum('total');
        if ($prev_moninearn == 0) {
             $earn_report = '<span class="green_c"><img src="' .$arrow_up.'" >100% </span> Since last month';
        } else {
            $precent = (($current_moniearn - $prev_moninearn) / $prev_moninearn) * 100;
            if ($precent > 0) {
               $earn_report = '<span class="green_c"><img src="' . $arrow_up . '" >100% </span> Since last month';
            }else{
                $earn_report = '<span class="red_c"><img src="' . $arrow_down . '" >100% </span> Since last month';
            }
        }

        // today earning
        $prev_dayearning = Order::whereIn('order_status',[3,4])->whereDate('created_at', now()->subDay())->sum('total');
        $today_earning = Order::whereIn('order_status',[3,4])->whereDate('created_at', Carbon::today())->sum('total');
        if ($prev_dayearning == 0) {
             $todayearn_report = '<span class="green_c"><img src="' .$arrow_up.'" >100% </span> Since last day';
        } else {
            $precent = (($today_earning - $prev_dayearning) / $prev_dayearning) * 100;
            if ($precent > 0) {
               $todayearn_report = '<span class="green_c"><img src="' . $arrow_up . '" >100% </span> Since last day';
            }else{
                $todayearn_report = '<span class="red_c"><img src="' . $arrow_down . '" >100% </span> Since last day';
            }
        }  
        // today earning
        $prev_daycancel = Order::where(['order_status'=>5])->whereDate('created_at', now()->subDay())->sum('total');
        $today_cancel = Order::where(['order_status'=>5])->whereDate('created_at', Carbon::today())->sum('total');
        if ($prev_daycancel == 0) {
             $todaycancel_report = '<span class="green_c"><img src="' .$arrow_up.'" >100% </span> Since last day';
        } else {
            $precent = (($today_cancel - $prev_daycancel) / $prev_daycancel) * 100;
            if ($precent > 0) {
               $todaycancel_report = '<span class="green_c"><img src="' . $arrow_up . '" >100% </span> Since last day';
            }else{
                $todaycancel_report = '<span class="red_c"><img src="' . $arrow_down . '" >100% </span> Since last day';
            }
        }
        // complete order reports
        $prev_moncomorder = Order::whereMonth('created_at', now()->subMonth()->month)->count();
        $current_moncomorder = Order::whereIn('order_status',[3,4])->whereMonth('created_at', now()->month)->count();
        if ($prev_moncomorder == 0) {
             $complete_report = '<span class="green_c"><img src="' .$arrow_up.'" >100% </span> Since last month';
        } else {
            $precent = (($current_moncomorder - $prev_moncomorder) / $prev_moncomorder) * 100;
            if ($precent > 0) {
               $complete_report = '<span class="green_c"><img src="' . $arrow_up . '" >100% </span> Since last month';
            }else{
                $complete_report = '<span class="red_c"><img src="' . $arrow_down . '" >100% </span> Since last month';
            }
        }
        // active order reports
        $prev_monacorder = Order::whereMonth('created_at', now()->subMonth()->month)->count();
        $current_monacorder = Order::whereMonth('created_at', now()->month)->count();
        if ($prev_monacorder == 0) {
             $active_report = '<span class="green_c"><img src="' .$arrow_up.'" >100% </span> Since last month';
        } else {
            $precent = (($current_monacorder - $prev_monacorder) / $prev_monacorder) * 100;
            if ($precent > 0) {
               $active_report = '<span class="green_c"><img src="' . $arrow_up . '" >100% </span> Since last month';
            }else{
                $active_report = '<span class="red_c"><img src="' . $arrow_down . '" >100% </span> Since last month';
            }
        }

        // unpaid order reports
        $prev_dayupcancel = Order::where(['order_status'=>5])->whereDate('created_at', now()->subDay())->count();
        $today_upcancel = Order::where(['order_status'=>5])->whereDate('created_at', Carbon::today())->count();
        if ($prev_dayupcancel == 0) {
             $todayupcancel_report = '<span class="green_c"><img src="' .$arrow_up.'" >100% </span> Since last day';
        } else {
            $precent = (($today_upcancel - $prev_dayupcancel) / $prev_dayupcancel) * 100;
            if ($precent > 0) {
               $todayupcancel_report = '<span class="green_c"><img src="' . $arrow_up . '" >100% </span> Since last day';
            }else{
                $todayupcancel_report = '<span class="red_c"><img src="' . $arrow_down . '" >100% </span> Since last day';
            }
        }
        // cancel order reports
        $prev_dayorcancel = Order::where(['order_status'=>5])->whereDate('created_at', now()->subDay())->count();
        $today_orcancel = Order::where(['order_status'=>5])->whereDate('created_at', Carbon::today())->count();
        if ($prev_dayorcancel == 0) {
             $todayorcancel_report = '<span class="green_c"><img src="' .$arrow_up.'" >100% </span> Since last day';
        } else {
            $precent = (($today_orcancel - $prev_dayorcancel) / $prev_dayorcancel) * 100;
            if ($precent > 0) {
               $todayorcancel_report = '<span class="green_c"><img src="' . $arrow_up . '" >100% </span> Since last day';
            }else{
                $todayorcancel_report = '<span class="red_c"><img src="' . $arrow_down . '" >100% </span> Since last day';
            }
        }

        return view('backEnd.admin.dashboard',compact('total_income','monthly_income','today_income','cancel_payment',
            'complete_order','active_order','unpaid_order','cancel_order','income_report','earn_report','todayearn_report','todaycancel_report','complete_report','active_report','todayorcancel_report','todayupcancel_report'));
    }
    public function changepassword(){
        return view('backEnd.admin.changepassword');
    }
     public function newpassword(Request $request)
    {
        $this->validate($request, [
            'old_password'=>'required',
            'new_password'=>'required',
            'confirm_password' => 'required_with:new_password|same:new_password|'
        ]);

        $user = User::find(Auth::id());
        $hashPass = $user->password;

        if (Hash::check($request->old_password, $hashPass)) {

            $user->fill([
                'password' => Hash::make($request->new_password)
            ])->save();

            Toastr::success('Success', 'Password changed successfully!');
            return redirect()->route('dashboard');
        }else{
            Toastr::error('Failed', 'Old password not match!');
            return back();
        }
    }
    public function locked(){
        // only if user is logged in
        
            Session::put('locked', true);
            return view('backEnd.auth.locked');
        

        return redirect()->route('login');
    }

    public function unlocked(Request $request)
    {
        if(!Auth::check())
            return redirect()->route('login');
        $password = $request->password;
        if(Hash::check($password,Auth::user()->password)){
            Session::forget('locked');
            Toastr::success('Success', 'You are logged in successfully!');
            return redirect()->route('dashboard');
        }
        Toastr::error('Failed', 'Your password not match!');
        return back();
    }
}
