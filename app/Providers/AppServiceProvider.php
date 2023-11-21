<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\GeneralSetting;
use App\Models\Category;
use App\Models\Ordertype;
use App\Models\AdminNotification;
use App\Models\Createpage;
use App\Models\Message;
use App\Models\Service;
use Illuminate\Support\Facades\View;
use Auth;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $generalsetting = GeneralSetting::where('status',1)->limit(1)->first();
        view()->share('generalsetting',$generalsetting);
        // category
        $categories = Service::where('status',1)->get();
        view()->share('categories',$categories);

        // ordertypes
        $ordertypes = Ordertype::get();
        view()->share('ordertypes',$ordertypes);

        $backpages = Createpage::select('id','pagename','slug')->get();
        view()->share('backpages',$backpages);

        $allnotifications = AdminNotification::latest()->get();
        view()->share('allnotifications',$allnotifications);
        $unreadnotifications = AdminNotification::where(['status'=>'unread'])->latest()->get();
        view()->share('unreadnotifications',$unreadnotifications);
        $ureadmessage = Message::where(['sender'=>'customer','status'=>'unread'])->whereNotNull('order_id')->with('customer')->latest()->limit(10)->get();
        view()->share('ureadmessage',$ureadmessage);
        $unreadsupport = Message::where(['sender'=>'customer','status'=>'unread'])->whereNull('order_id')->with('customer')->count();
        view()->share('unreadsupport',$unreadsupport);

        View::composer('backEnd.layouts.master', function ($view) {
        if (auth()->check()) {
                $asignallnotifications = AdminNotification::where('user_id', auth()->user()->id)->latest()->get();
                view()->share('asignallnotifications',$asignallnotifications);
                $asignunreadnotifications = AdminNotification::where('user_id', auth()->user()->id)->latest()->where(['status'=>'unread'])->get();
                view()->share('asignunreadnotifications',$asignunreadnotifications);
                $asignureadmessage = Message::where(['sender'=>'customer','status'=>'unread','admin_id'=>auth()->user()->id])->with('customer')->latest()->limit(10)->get();
                view()->share('asignureadmessage',$asignureadmessage);
            }
        });
    }
}
