<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FrontEndController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\ShoppingCartController;



Route::group(['namespace' => 'Api', 'middleware' => ['api'], 'prefix' => 'v1'], function () {

    
    
     Route::get('/easyway', [FrontEndController::class, 'easyway'])->name('easyway');
     Route::get('/specialized', [FrontEndController::class, 'specialized'])->name('specialized');
     Route::get('/testimonialtitle', [FrontEndController::class, 'testimonialtitle'])->name('testimonialtitle');
     Route::get('/trustedpeople', [FrontEndController::class, 'trustedpeople'])->name('trustedpeople');
     Route::get('/blogtitle', [FrontEndController::class, 'blogtitle'])->name('blogtitle');
     Route::get('/faqtitle', [FrontEndController::class, 'faqtitle'])->name('faqtitle');
     Route::get('/keyresearchtitle', [FrontEndController::class, 'keyresearchtitle'])->name('keyresearchtitle');
     Route::get('/pricingtitle', [FrontEndController::class, 'pricingtitle'])->name('pricingtitle');
     Route::get('/freespace', [FrontEndController::class, 'freespace'])->name('freespace');
     Route::get('/letsget', [FrontEndController::class, 'letsget'])->name('letsget');
     Route::get('/niddletitle', [FrontEndController::class, 'niddletitle'])->name('niddletitle');
     Route::get('/linkbuildingworktitle', [FrontEndController::class, 'linkbuildingworktitle'])->name('linkbuildingworktitle');
     Route::get('/linkinsertationworktitle', [FrontEndController::class, 'linkinsertationworktitle'])->name('linkinsertationworktitle');
     Route::get('/onpageseoranks', [FrontEndController::class, 'onpageseoranks'])->name('onpageseoranks');
     Route::get('/managedseoranks', [FrontEndController::class, 'managedseoranks'])->name('managedseoranks');
     Route::get('/guestpostingtitle', [FrontEndController::class, 'guestpostingtitle'])->name('guestpostingtitle');
     Route::get('/articlewritingtitle', [FrontEndController::class, 'articlewritingtitle'])->name('articlewritingtitle');
     
     Route::get('/servicefaqtitle', [FrontEndController::class, 'servicefaqtitle'])->name('servicefaqtitle');
     Route::get('/transparenttitle', [FrontEndController::class, 'transparenttitle'])->name('transparenttitle');
     
     Route::get('/supportitem', [FrontEndController::class, 'supportitem'])->name('supportitem');
     Route::get('/transparent', [FrontEndController::class, 'transparent'])->name('transparent');
     Route::get('/needletop', [FrontEndController::class, 'needletop'])->name('needletop');
     Route::get('/needlebottom', [FrontEndController::class, 'needlebottom'])->name('needlebottom');
    
    
    
    // FrontEnd 
    Route::post('/subscribe', [FrontEndController::class, 'subscribe'])->name('subscribe');
    
    Route::post('/seo-checker', [FrontEndController::class, 'seo_checker'])->name('seo_checker');
    Route::get('/generalsetting', [FrontEndController::class, 'generalsetting'])->name('generalsetting');
    Route::get('/contactinfo', [FrontEndController::class, 'contactinfo'])->name('contactinfo');
    Route::get('/categories', [FrontEndController::class, 'categories'])->name('categories');
    
    Route::get('/keyword-research', [FrontEndController::class, 'keywordresearch'])->name('keywordresearch');
    Route::get('/link-building', [FrontEndController::class, 'linkbuilding'])->name('linkbuilding');
    Route::get('/link-insertion', [FrontEndController::class, 'linkinsertation'])->name('linkinsertation');
    Route::get('/on-page-seo', [FrontEndController::class, 'onpageseo'])->name('onpageseo');
    Route::get('/managed-seo', [FrontEndController::class, 'managedseo'])->name('managedseo');
    Route::get('/guest-posting', [FrontEndController::class, 'guestposting'])->name('guestposting');
    Route::get('/article-writing', [FrontEndController::class, 'articlewriting'])->name('articlewriting');
    
    Route::get('/footer/categories', [FrontEndController::class, 'footercategories'])->name('footercategories');
    Route::get('/footer/categories/one', [FrontEndController::class, 'footercategoriesone'])->name('footercategoriesone');
    
    Route::get('/slider', [FrontEndController::class, 'slider'])->name('sliders');
    Route::get('/start/working', [FrontEndController::class, 'startworking'])->name('startworkings');
    Route::get('/roi/seo', [FrontEndController::class, 'roiseo'])->name('roiseo');
    Route::get('/special/services', [FrontEndController::class, 'specialservice'])->name('specialservices');
    Route::get('/special/services', [FrontEndController::class, 'specialservice'])->name('specialservices');
    Route::get('/why/choose', [FrontEndController::class, 'whychoose'])->name('whychoose');
    Route::get('/why/chooseitem', [FrontEndController::class, 'whychooseitem'])->name('whychooseitem');
    Route::get('/businessgrow', [FrontEndController::class, 'businessgrow'])->name('businessgrow');
    Route::get('/success', [FrontEndController::class, 'success'])->name('success');
    Route::get('/testimonial', [FrontEndController::class, 'testimonial'])->name('testimonials');
    Route::get('/clints', [FrontEndController::class, 'clints'])->name('clints');
    Route::get('/homeblogs', [FrontEndController::class, 'homeblogs'])->name('homeblogs');
    Route::get('/blogs', [FrontEndController::class, 'blogs'])->name('blogs');
    Route::get('/blog-details/{slug}', [FrontEndController::class, 'blogdetails'])->name('blogdetails');
    Route::get('/blog-category/{slug}', [FrontEndController::class, 'blogcategory'])->name('blogcategory');
    Route::get('/analysis', [FrontEndController::class, 'analysis'])->name('analysis');

    // Home Page End 

    Route::get('/about', [FrontEndController::class, 'about'])->name('about');
    Route::get('/video', [FrontEndController::class, 'video'])->name('video');
    Route::get('/aboutcounter', [FrontEndController::class, 'aboutcounter'])->name('aboutcounter');
    Route::get('/aboutfaq', [FrontEndController::class, 'aboutfaq'])->name('aboutfaq');

    // About Page End 
    Route::get('/keywservicetop', [FrontEndController::class, 'keywservicetop'])->name('keywservicetop');
    Route::get('/keywservicebottom', [FrontEndController::class, 'keywservicebottom'])->name('keywservicebottom');
    Route::get('/keywservicecounter', [FrontEndController::class, 'keywservicecounter'])->name('keywservicecounter');
    Route::get('/keywservicework', [FrontEndController::class, 'keywservicework'])->name('keywservicework');
    Route::get('/keywservicefaq', [FrontEndController::class, 'keywservicefaq'])->name('keywservicefaq');

    // Link Building
    Route::get('/linkbuildingtop', [FrontEndController::class, 'linkbuildingtop'])->name('linkbuildingtop');
    Route::get('/linkbuildingbottom', [FrontEndController::class, 'linkbuildingbottom'])->name('linkbuildingbottom');
    Route::get('/linkbuildingcounter', [FrontEndController::class, 'linkbuildingcounter'])->name('linkbuildingcounter');
    Route::get('/linkbuildingwork', [FrontEndController::class, 'linkbuildingwork'])->name('linkbuildingwork');
    Route::get('/linkbuildingfaq', [FrontEndController::class, 'linkbuildingfaq'])->name('linkbuildingfaq');

    // Link Insertation
    Route::get('/linkinsertationtop', [FrontEndController::class, 'linkinsertationtop'])->name('linkinsertationtop');
    Route::get('/linkinsertationbottom', [FrontEndController::class, 'linkinsertationbottom'])->name('linkinsertationbottom');
    Route::get('/linkinsertationcounter', [FrontEndController::class, 'linkinsertationcounter'])->name('linkinsertationcounter');
    Route::get('/linkinsertationwork', [FrontEndController::class, 'linkinsertationwork'])->name('linkinsertationwork');
    Route::get('/linkinsertationfaq', [FrontEndController::class, 'linkinsertationfaq'])->name('linkinsertationfaq');
    
    
    // On Page Seo
    Route::get('/onpageseotop', [FrontEndController::class, 'onpageseotop'])->name('onpageseotop');
    Route::get('/onpageseobottom', [FrontEndController::class, 'onpageseobottom'])->name('onpageseobottom');
    Route::get('/onpageseocounter', [FrontEndController::class, 'onpageseocounter'])->name('onpageseocounter');
    Route::get('/onpageseowork', [FrontEndController::class, 'onpageseowork'])->name('onpageseowork');
    Route::get('/onpageseofaq', [FrontEndController::class, 'onpageseofaq'])->name('onpageseofaq');

    // Managed Seo
    Route::get('/managedseotop', [FrontEndController::class, 'managedseotop'])->name('managedseotop');
    Route::get('/managedseobottom', [FrontEndController::class, 'managedseobottom'])->name('managedseobottom');
    Route::get('/managedseocounter', [FrontEndController::class, 'managedseocounter'])->name('managedseocounter');
    Route::get('/managedseowork', [FrontEndController::class, 'managedseowork'])->name('managedseowork');
    Route::get('/managedseofaq', [FrontEndController::class, 'managedseofaq'])->name('managedseofaq');
    Route::get('pricing/{slug}', [FrontEndController::class, 'pricing'])->name('pricing');

    // Guest Posting
    Route::get('/guestpostingtop', [FrontEndController::class, 'guestpostingtop'])->name('guestpostingtop');
    Route::get('/guestpostingbottom', [FrontEndController::class, 'guestpostingbottom'])->name('guestpostingbottom');
    Route::get('/guestpostingcounter', [FrontEndController::class, 'guestpostingcounter'])->name('guestpostingcounter');
    Route::get('/guestpostingwork', [FrontEndController::class, 'guestpostingwork'])->name('guestpostingwork');
    Route::get('/guestpostingfaq', [FrontEndController::class, 'guestpostingfaq'])->name('guestpostingfaq');

    // Article Writing
    Route::get('/articlewritingtop', [FrontEndController::class, 'articlewritingtop'])->name('articlewritingtop');
    Route::get('/articlewritingbottom', [FrontEndController::class, 'articlewritingbottom'])->name('articlewritingbottom');
    Route::get('/articlewritingcounter', [FrontEndController::class, 'articlewritingcounter'])->name('articlewritingcounter');
    Route::get('/articlewritingwork', [FrontEndController::class, 'articlewritingwork'])->name('articlewritingwork');
    Route::get('/articlewritingfaq', [FrontEndController::class, 'articlewritingfaq'])->name('articlewritingfaq');
    Route::get('/pagename', [FrontEndController::class, 'pagename'])->name('pagename');
    Route::get('/page/{slug}', [FrontEndController::class, 'morepage'])->name('morepage');

    Route::get('/socialmedia', [FrontEndController::class, 'socialmedia'])->name('socialmedia');
    Route::get('/countries', [FrontEndController::class, 'countries'])->name('countries');
    Route::get('/states/{id}', [FrontEndController::class, 'states'])->name('states');

    // Customer route
    Route::post('/customer/payment/striped', [CustomerController::class,'striped_payment'])->name('striped_payment');
    Route::post('/customer/login', [CustomerController::class,'login'])->name('login');
    Route::post('/customer/register', [CustomerController::class,'register'])->name('register');
    Route::post('/customer/verified', [CustomerController::class,'verify'])->name('verify');
    Route::put('/customer/resend/verify', [CustomerController::class,'resendverify'])->name('resendverify');
    Route::post('/customer/forget-password', [CustomerController::class,'forgetpassword'])->name('forgetpassword');
    Route::post('/customer/forget-password/reset', [CustomerController::class,'fpassreset'])->name('fpassreset');
    Route::post('/customer/logout', [CustomerController::class,'logout'])->name('logout');
    
    Route::post('customer/coupon-apply', [CustomerController::class, 'couponapply']);
    Route::post('customer/contact', [CustomerController::class, 'contact']);

     // cart manage
     Route::post('add-to-cart', [ShoppingCartController::class,'detailscart'])->name('detailscart');
     Route::post('/cart', [ShoppingCartController::class,'cartstore'])->name('cartstore');
     Route::get('/cart', [ShoppingCartController::class,'cartshow'])->name('cartshow');
     Route::get('/show-cart', [ShoppingCartController::class,'show_cart'])->name('show_cart');
     Route::post('/cart/delete/{product_id}', [ShoppingCartController::class,'cartdestroy'])->name('cartdestroy');

});

// customer panel api routes
Route::group(['namespace' => 'Api', 'prefix' => 'v1', 'middleware' => 'auth:customer'], function () {

    Route::get('/customer/account', [CustomerController::class, 'account'])->name('account');
    Route::get('/customer/profile/edit', [CustomerController::class, 'editprofile'])->name('editprofile');
    Route::post('/customer/profile/update', [CustomerController::class, 'profileUpdate'])->name('profileUpdate');
    Route::post('/customer/password/change', [CustomerController::class, 'passwordchange'])->name('passwordchange');
    Route::post('/customer/order/save', [CustomerController::class, 'orderSave'])->name('orderSave');
    Route::get('/customer/order-chat', [CustomerController::class, 'chatopen'])->name('chatopen');
    Route::get('/customer/orders', [CustomerController::class, 'myorder'])->name('myorder');
    Route::get('/customer/download-invoice/{order_id}', [CustomerController::class, 'download_invoice'])->name('download_invoice');
    Route::post('/customer/password/change', [CustomerController::class, 'passwordchange'])->name('passwordchange');
    Route::get('/customer/packages', [CustomerController::class, 'packages'])->name('packages');
    Route::get('/customer/delivery-orders', [CustomerController::class, 'delivery_order'])->name('delivery_order');
    Route::post('customer/order/complete', [CustomerController::class, 'order_complete'])->name('order_complete');
    Route::post('customer/order/review', [CustomerController::class, 'order_review'])->name('order_review');
    Route::get('messages', [CustomerController::class, 'messages'])->name('messages');
    Route::post('customer/message/send', [CustomerController::class, 'message_send'])->name('message_send');
    Route::get('customer/unread-message', [CustomerController::class, 'unreadmessage'])->name('unreadmessage');
    Route::get('customer/unread-message-count', [CustomerController::class, 'unreasms_count'])->name('unreasms_count');
    Route::get('customer/unread-support', [CustomerController::class, 'unreadsupport'])->name('unreadsupport');
    Route::get('customer/notification', [CustomerController::class, 'notification'])->name('notification');
    Route::any('customer/comment-add', [CustomerController::class, 'customercomment'])->name('customercomment');
    Route::get('customer/order-view/{order_id}', [CustomerController::class, 'ordeview'])->name('orderview');




});
