<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\LogoController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\RoiseoController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CounterController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\PricingController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SuccessController;
use App\Http\Controllers\Admin\AboutfaqController;
use App\Http\Controllers\Admin\AnalysisController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageTitleController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\WhychooseController;
use App\Http\Controllers\FrontEnd\PayPalController;
use App\Http\Controllers\Admin\CouponcodeController;
use App\Http\Controllers\Admin\CreatepageController;
use App\Http\Controllers\Admin\NeedleitemController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\SocialMediaController;
use App\Http\Controllers\Admin\SupportitemController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\TransparentController;
use App\Http\Controllers\FrontEnd\FrontEndController;
use App\Http\Controllers\Admin\AboutcounterController;
use App\Http\Controllers\Admin\BlogcategoryController;
use App\Http\Controllers\Admin\BusinessgrowController;
use App\Http\Controllers\Admin\DeliveryfileController;
use App\Http\Controllers\Admin\ResearchworkController;
use App\Http\Controllers\Admin\SectiontitleController;
use App\Http\Controllers\Admin\StartworkingController;
use App\Http\Controllers\Admin\WhychooseitemController;
use App\Http\Controllers\Admin\GeneralSettingController;
use App\Http\Controllers\Admin\SpecialserviceController;


Route::get('/cc', function() {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Clear Config</h1>';
});
Route::get('/migrate', function() {
    Artisan::call('migrate');
    return "Model Created!";
});
// frontend routes
Route::group(['namespace'=>'FrontEnd'], function(){
    Route::get('/', [FrontEndController::class, 'home'])->name('home');
    Route::get('client/invoice/{invoice}', [FrontEndController::class, 'open_invoice'])->name('open_invoice');

});
Route::get('paypal/payment',  [PayPalController::class,'paypal_payment'])->name('payment');
Route::get('paypal/cancel',  [PayPalController::class,'paypal_cancel'])->name('payment.cancel');
Route::get('paypal/success',  [PayPalController::class,'paypal_success'])->name('payment.success');
Auth::routes();

// ajax route
Route::get('/ajax-package', 'App\Http\Controllers\Admin\PricingController@getPackage');
Route::get('/ajax-attribute', 'App\Http\Controllers\Admin\PricingController@getAttribute');


// unathenticate route
Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {

    Route::get('locked', [DashboardController::class, 'locked'])->name('locked');
    Route::post('unlocked', [DashboardController::class, 'unlocked'])->name('unlocked');
});
// auth route
Route::group(['namespace' => 'Admin', 'middleware' => ['auth', 'lock'], 'prefix' => 'admin'], function () {


    Route::post('deliveryfile/save', [DeliveryfileController::class, 'deliveryfile_save'])->name('deliveryfile_save');

    Route::get('order/manage/', [OrderController::class, 'ordermanage'])->name('ordermanage');
    Route::get('order/details/{order_id}', [OrderController::class, 'details'])->name('details');
    Route::get('order/invoice/{order_id}', [OrderController::class, 'invoice'])->name('invoice');
    Route::get('order/attribute/{order_id}', [OrderController::class, 'attribute'])->name('attribute');
    Route::post('order/status-change', [OrderController::class, 'status_change'])->name('order.status_change');
    Route::post('payment-status', [OrderController::class, 'payment_status'])->name('order.payment_status');

    Route::get('latest/invoice', [OrderController::class, 'lastestinvoice'])->name('lastestinvoice');
    Route::get('create/invoice', [OrderController::class, 'createinvoice'])->name('createinvoice');
    Route::get('invoice/preview', [OrderController::class, 'invoice_preview']);
    Route::post('invoice/save', [OrderController::class, 'invoice_save'])->name('invoice_save');
    Route::get('custom-package', [OrderController::class, 'custom_package']);
    Route::post('custom-package/add', [OrderController::class, 'custom_packadd'])->name('custom_packadd');
    Route::get('cart/store', [OrderController::class, 'cart_store'])->name('admin.cart_store');
    Route::get('cart/add', [OrderController::class, 'add_cart'])->name('admin.add_cart');
    Route::get('cart/details', [OrderController::class, 'cart_details'])->name('admin.cart_details');
    Route::get('cart/info', [OrderController::class, 'cart_info'])->name('admin.cart_info');
    Route::get('cart/remove', [OrderController::class, 'cart_remove'])->name('admin.cart_remove');
    Route::get('cart/tax', [OrderController::class, 'cart_tax'])->name('admin.cart_tax');
    Route::get('cart/discount', [OrderController::class, 'cart_discount'])->name('admin.cart_discount');
    Route::get('country-state', [OrderController::class, 'country_state'])->name('admin.country');
    Route::post('order/delete', [OrderController::class, 'order_delete'])->name('order.delete');
    Route::post('order/payment-reminder', [OrderController::class, 'payment_reminder'])->name('order.payment_reminder');
    Route::post('order/cancel-reminder', [OrderController::class, 'cancel_reminder'])->name('order.cancel_reminder');
    Route::post('order/delivery-extende', [OrderController::class, 'delivery_extende'])->name('order.delivery_extende');
    Route::post('order/asign', [OrderController::class, 'order_asign'])->name('order_asign');
    Route::get('admin-search', [OrderController::class, 'admin_search'])->name('admin.search');
    Route::get('review', [OrderController::class, 'review'])->name('review');
    Route::post('review/destroy', [OrderController::class, 'review_destroy'])->name('review.destroy');



    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('change-password', [DashboardController::class, 'changepassword'])->name('change_password');
    Route::post('new-password', [DashboardController::class, 'newpassword'])->name('new_password');

    // users route
    Route::get('users/manage', [UserController::class, 'index'])->name('users.index');

    Route::post('users/save', [UserController::class, 'store'])->name('users.store');
    Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::post('users/update', [UserController::class, 'update'])->name('users.update');
    Route::post('users/inactive', [UserController::class, 'inactive'])->name('users.inactive');
    Route::post('users/active', [UserController::class, 'active'])->name('users.active');
    Route::post('users/destroy', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('customer/list', [UserController::class, 'customer_list'])->name('users.customer_list');

    // roles
    Route::get('roles/manage', [RoleController::class, 'index'])->name('roles.index');
    Route::get('roles/{id}/show', [RoleController::class, 'show'])->name('roles.show');
    Route::post('roles/save', [RoleController::class, 'store'])->name('roles.store');
    Route::get('roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::post('roles/update', [RoleController::class, 'update'])->name('roles.update');
    Route::post('roles/destroy', [RoleController::class, 'destroy'])->name('roles.destroy');

    // permissions
    Route::get('permission/manage', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('permissions/{id}/show', [PermissionController::class, 'show'])->name('permissions.show');
    Route::get('permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('permissions/save', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('permissions/{id}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::post('permissions/update', [PermissionController::class, 'update'])->name('permissions.update');
    Route::post('permissions/destroy', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    // settings route
    Route::get('settings/manage', [GeneralSettingController::class, 'index'])->name('settings.index');
    Route::get('settings/create', [GeneralSettingController::class, 'create'])->name('settings.create');
    Route::post('settings/save', [GeneralSettingController::class, 'store'])->name('settings.store');
    Route::get('settings/{id}/edit', [GeneralSettingController::class, 'edit'])->name('settings.edit');
    Route::post('settings/update', [GeneralSettingController::class, 'update'])->name('settings.update');
    Route::post('settings/inactive', [GeneralSettingController::class, 'inactive'])->name('settings.inactive');
    Route::post('settings/active', [GeneralSettingController::class, 'active'])->name('settings.active');
    Route::post('settings/destroy', [GeneralSettingController::class, 'destroy'])->name('settings.destroy');

    // social media route
    Route::get('social-media/manage', [SocialMediaController::class, 'index'])->name('socialmedias.index');
    Route::get('social-media/create', [SocialMediaController::class, 'create'])->name('socialmedias.create');
    Route::post('social-media/save', [SocialMediaController::class, 'store'])->name('socialmedias.store');
    Route::get('social-media/{id}/edit', [SocialMediaController::class, 'edit'])->name('socialmedias.edit');
    Route::post('social-media/update', [SocialMediaController::class, 'update'])->name('socialmedias.update');
    Route::post('social-media/inactive', [SocialMediaController::class, 'inactive'])->name('socialmedias.inactive');
    Route::post('social-media/active', [SocialMediaController::class, 'active'])->name('socialmedias.active');
    Route::post('social-media/destroy', [SocialMediaController::class, 'destroy'])->name('socialmedias.destroy');

    // contact route
    Route::get('contact/manage', [ContactController::class, 'index'])->name('contact.index');
    Route::get('contact/create', [ContactController::class, 'create'])->name('contact.create');
    Route::post('contact/save', [ContactController::class, 'store'])->name('contact.store');
    Route::get('contact/{id}/edit', [ContactController::class, 'edit'])->name('contact.edit');
    Route::post('contact/update', [ContactController::class, 'update'])->name('contact.update');
    Route::post('contact/inactive', [ContactController::class, 'inactive'])->name('contact.inactive');
    Route::post('contact/active', [ContactController::class, 'active'])->name('contact.active');
    Route::post('contact/destroy', [ContactController::class, 'destroy'])->name('contact.destroy');

    // category routes
    Route::get('service/manage', [ServiceController::class, 'index'])->name('services.index');
    Route::get('service/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('service/save', [ServiceController::class, 'store'])->name('services.store');
    Route::get('service/{id}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::post('service/update', [ServiceController::class, 'update'])->name('services.update');
    Route::post('service/inactive', [ServiceController::class, 'inactive'])->name('services.inactive');
    Route::post('service/active', [ServiceController::class, 'active'])->name('services.active');
    Route::post('service/destroy', [ServiceController::class, 'destroy'])->name('services.destroy');


    // Slider routes
    Route::get('slider/manage', [SliderController::class, 'index'])->name('sliders.index');
    Route::get('slider/create', [SliderController::class, 'create'])->name('sliders.create');
    Route::post('slider/save', [SliderController::class, 'store'])->name('sliders.store');
    Route::get('slider/{id}/edit', [SliderController::class, 'edit'])->name('sliders.edit');
    Route::post('slider/update', [SliderController::class, 'update'])->name('sliders.update');
    Route::post('slider/inactive', [SliderController::class, 'inactive'])->name('sliders.inactive');
    Route::post('slider/active', [SliderController::class, 'active'])->name('sliders.active');
    Route::post('slider/destroy', [SliderController::class, 'destroy'])->name('sliders.destroy');


    // Start Work routes
    Route::get('startworking/manage', [StartworkingController::class, 'index'])->name('startworkings.index');
    Route::get('startworking/create', [StartworkingController::class, 'create'])->name('startworkings.create');
    Route::post('startworking/save', [StartworkingController::class, 'store'])->name('startworkings.store');
    Route::get('startworking/{id}/edit', [StartworkingController::class, 'edit'])->name('startworkings.edit');
    Route::post('startworking/update', [StartworkingController::class, 'update'])->name('startworkings.update');
    Route::post('startworking/inactive', [StartworkingController::class, 'inactive'])->name('startworkings.inactive');
    Route::post('startworking/active', [StartworkingController::class, 'active'])->name('startworkings.active');
    Route::post('startworking/destroy', [StartworkingController::class, 'destroy'])->name('startworkings.destroy');

    // Roiseo routes
    Route::get('roiseo/manage', [RoiseoController::class, 'index'])->name('roiseo.index');
    Route::get('roiseo/create', [RoiseoController::class, 'create'])->name('roiseo.create');
    Route::post('roiseo/save', [RoiseoController::class, 'store'])->name('roiseo.store');
    Route::get('roiseo/{id}/edit', [RoiseoController::class, 'edit'])->name('roiseo.edit');
    Route::post('roiseo/update', [RoiseoController::class, 'update'])->name('roiseo.update');
    Route::post('roiseo/inactive', [RoiseoController::class, 'inactive'])->name('roiseo.inactive');
    Route::post('roiseo/active', [RoiseoController::class, 'active'])->name('roiseo.active');
    Route::post('roiseo/destroy', [RoiseoController::class, 'destroy'])->name('roiseo.destroy');

    // Special Service routes
    Route::get('specialservice/manage', [SpecialserviceController::class, 'index'])->name('specialservices.index');
    Route::get('specialservice/create', [SpecialserviceController::class, 'create'])->name('specialservices.create');
    Route::post('specialservice/save', [SpecialserviceController::class, 'store'])->name('specialservices.store');
    Route::get('specialservice/{id}/edit', [SpecialserviceController::class, 'edit'])->name('specialservices.edit');
    Route::post('specialservice/update', [SpecialserviceController::class, 'update'])->name('specialservices.update');
    Route::post('specialservice/inactive', [SpecialserviceController::class, 'inactive'])->name('specialservices.inactive');
    Route::post('specialservice/active', [SpecialserviceController::class, 'active'])->name('specialservices.active');
    Route::post('specialservice/destroy', [SpecialserviceController::class, 'destroy'])->name('specialservices.destroy');

    // Whychoose routes
    Route::get('whychoose/manage', [WhychooseController::class, 'index'])->name('whychooses.index');
    Route::get('whychoose/create', [WhychooseController::class, 'create'])->name('whychooses.create');
    Route::post('whychoose/save', [WhychooseController::class, 'store'])->name('whychooses.store');
    Route::get('whychoose/{id}/edit', [WhychooseController::class, 'edit'])->name('whychooses.edit');
    Route::post('whychoose/update', [WhychooseController::class, 'update'])->name('whychooses.update');
    Route::post('whychoose/inactive', [WhychooseController::class, 'inactive'])->name('whychooses.inactive');
    Route::post('whychoose/active', [WhychooseController::class, 'active'])->name('whychooses.active');
    Route::post('whychoose/destroy', [WhychooseController::class, 'destroy'])->name('whychooses.destroy');

    // Whychoose Item routes
    Route::get('whychooseitem/manage', [WhychooseitemController::class, 'index'])->name('whychooseitems.index');
    Route::get('whychooseitem/create', [WhychooseitemController::class, 'create'])->name('whychooseitems.create');
    Route::post('whychooseitem/save', [WhychooseitemController::class, 'store'])->name('whychooseitems.store');
    Route::get('whychooseitem/{id}/edit', [WhychooseitemController::class, 'edit'])->name('whychooseitems.edit');
    Route::post('whychooseitem/update', [WhychooseitemController::class, 'update'])->name('whychooseitems.update');
    Route::post('whychooseitem/inactive', [WhychooseitemController::class, 'inactive'])->name('whychooseitems.inactive');
    Route::post('whychooseitem/active', [WhychooseitemController::class, 'active'])->name('whychooseitems.active');
    Route::post('whychooseitem/destroy', [WhychooseitemController::class, 'destroy'])->name('whychooseitems.destroy');

    // Businessgrow Item routes
    Route::get('businessgrow/manage', [BusinessgrowController::class, 'index'])->name('businessgrow.index');
    Route::get('businessgrow/create', [BusinessgrowController::class, 'create'])->name('businessgrow.create');
    Route::post('businessgrow/save', [BusinessgrowController::class, 'store'])->name('businessgrow.store');
    Route::get('businessgrow/{id}/edit', [BusinessgrowController::class, 'edit'])->name('businessgrow.edit');
    Route::post('businessgrow/update', [BusinessgrowController::class, 'update'])->name('businessgrow.update');
    Route::post('businessgrow/inactive', [BusinessgrowController::class, 'inactive'])->name('businessgrow.inactive');
    Route::post('businessgrow/active', [BusinessgrowController::class, 'active'])->name('businessgrow.active');
    Route::post('businessgrow/destroy', [BusinessgrowController::class, 'destroy'])->name('businessgrow.destroy');

    // Success Item routes
    Route::get('success/manage', [SuccessController::class, 'index'])->name('success.index');
    Route::get('success/create', [SuccessController::class, 'create'])->name('success.create');
    Route::post('success/save', [SuccessController::class, 'store'])->name('success.store');
    Route::get('success/{id}/edit', [SuccessController::class, 'edit'])->name('success.edit');
    Route::post('success/update', [SuccessController::class, 'update'])->name('success.update');
    Route::post('success/inactive', [SuccessController::class, 'inactive'])->name('success.inactive');
    Route::post('success/active', [SuccessController::class, 'active'])->name('success.active');
    Route::post('success/destroy', [SuccessController::class, 'destroy'])->name('success.destroy');

    // Testimonial Item routes
    Route::get('testimonial/manage', [TestimonialController::class, 'index'])->name('testimonials.index');
    Route::get('testimonial/create', [TestimonialController::class, 'create'])->name('testimonials.create');
    Route::post('testimonial/save', [TestimonialController::class, 'store'])->name('testimonials.store');
    Route::get('testimonial/{id}/edit', [TestimonialController::class, 'edit'])->name('testimonials.edit');
    Route::post('testimonial/update', [TestimonialController::class, 'update'])->name('testimonials.update');
    Route::post('testimonial/inactive', [TestimonialController::class, 'inactive'])->name('testimonials.inactive');
    Route::post('testimonial/active', [TestimonialController::class, 'active'])->name('testimonials.active');
    Route::post('testimonial/destroy', [TestimonialController::class, 'destroy'])->name('testimonials.destroy');

    // Client Item routes
    Route::get('client/manage', [ClientController::class, 'index'])->name('clients.index');
    Route::get('client/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('client/save', [ClientController::class, 'store'])->name('clients.store');
    Route::get('client/{id}/edit', [ClientController::class, 'edit'])->name('clients.edit');
    Route::post('client/update', [ClientController::class, 'update'])->name('clients.update');
    Route::post('client/inactive', [ClientController::class, 'inactive'])->name('clients.inactive');
    Route::post('client/active', [ClientController::class, 'active'])->name('clients.active');
    Route::post('client/destroy', [ClientController::class, 'destroy'])->name('clients.destroy');

    // Blog Item routes
    Route::get('blog/manage', [BlogController::class, 'index'])->name('blogs.index');
    Route::get('blog/create', [BlogController::class, 'create'])->name('blogs.create');
    Route::post('blog/save', [BlogController::class, 'store'])->name('blogs.store');
    Route::get('blog/{id}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
    Route::post('blog/update', [BlogController::class, 'update'])->name('blogs.update');
    Route::post('blog/inactive', [BlogController::class, 'inactive'])->name('blogs.inactive');
    Route::post('blog/active', [BlogController::class, 'active'])->name('blogs.active');
    Route::post('blog/destroy', [BlogController::class, 'destroy'])->name('blogs.destroy');

    Route::get('blog/comment', [BlogController::class, 'blogcomment'])->name('blogs.comment');
    Route::post('blog/comment/unpublish', [BlogController::class, 'blogcommentunpublish'])->name('blogs.comment.unpublish');
    Route::post('blog/comment/publish', [BlogController::class, 'blogcommentpublish'])->name('blogs.comment.publish');
    Route::post('blog/comment/destroy', [BlogController::class, 'blogcommentdestroy'])->name('blogs.comment.destroy');

    // Blogcategory Item routes

    Route::get('blogcategory/manage', [BlogcategoryController::class, 'index'])->name('blogcategories.index');
    Route::get('blogcategory/create', [BlogcategoryController::class, 'create'])->name('blogcategories.create');
    Route::post('blogcategory/save', [BlogcategoryController::class, 'store'])->name('blogcategories.store');
    Route::get('blogcategory/{id}/edit', [BlogcategoryController::class, 'edit'])->name('blogcategories.edit');
    Route::post('blogcategory/update', [BlogcategoryController::class, 'update'])->name('blogcategories.update');
    Route::post('blogcategory/inactive', [BlogcategoryController::class, 'inactive'])->name('blogcategories.inactive');
    Route::post('blogcategory/active', [BlogcategoryController::class, 'active'])->name('blogcategories.active');
    Route::post('blogcategory/destroy', [BlogcategoryController::class, 'destroy'])->name('blogcategories.destroy');

    // Analysis Item routes
    Route::get('analysis/manage', [AnalysisController::class, 'index'])->name('analysis.index');
    Route::get('analysis/create', [AnalysisController::class, 'create'])->name('analysis.create');
    Route::post('analysis/save', [AnalysisController::class, 'store'])->name('analysis.store');
    Route::get('analysis/{id}/edit', [AnalysisController::class, 'edit'])->name('analysis.edit');
    Route::post('analysis/update', [AnalysisController::class, 'update'])->name('analysis.update');
    Route::post('analysis/inactive', [AnalysisController::class, 'inactive'])->name('analysis.inactive');
    Route::post('analysis/active', [AnalysisController::class, 'active'])->name('analysis.active');
    Route::post('analysis/destroy', [AnalysisController::class, 'destroy'])->name('analysis.destroy');

    // About Item routes
    Route::get('about/manage', [AboutController::class, 'index'])->name('about.index');
    Route::get('about/create', [AboutController::class, 'create'])->name('about.create');
    Route::post('about/save', [AboutController::class, 'store'])->name('about.store');
    Route::get('about/{id}/edit', [AboutController::class, 'edit'])->name('about.edit');
    Route::post('about/update', [AboutController::class, 'update'])->name('about.update');
    Route::post('about/inactive', [AboutController::class, 'inactive'])->name('about.inactive');
    Route::post('about/active', [AboutController::class, 'active'])->name('about.active');
    Route::post('about/destroy', [AboutController::class, 'destroy'])->name('about.destroy');

    // Video Item routes
    Route::get('video/manage', [VideoController::class, 'index'])->name('videos.index');
    Route::get('video/create', [VideoController::class, 'create'])->name('videos.create');
    Route::post('video/save', [VideoController::class, 'store'])->name('videos.store');
    Route::get('video/{id}/edit', [VideoController::class, 'edit'])->name('videos.edit');
    Route::post('video/update', [VideoController::class, 'update'])->name('videos.update');
    Route::post('video/inactive', [VideoController::class, 'inactive'])->name('videos.inactive');
    Route::post('video/active', [VideoController::class, 'active'])->name('videos.active');
    Route::post('video/destroy', [VideoController::class, 'destroy'])->name('videos.destroy');

    // Aboutcounter Item routes
    Route::get('aboutcounter/manage', [AboutcounterController::class, 'index'])->name('aboutcounter.index');
    Route::get('aboutcounter/create', [AboutcounterController::class, 'create'])->name('aboutcounter.create');
    Route::post('aboutcounter/save', [AboutcounterController::class, 'store'])->name('aboutcounter.store');
    Route::get('aboutcounter/{id}/edit', [AboutcounterController::class, 'edit'])->name('aboutcounter.edit');
    Route::post('aboutcounter/update', [AboutcounterController::class, 'update'])->name('aboutcounter.update');
    Route::post('aboutcounter/inactive', [AboutcounterController::class, 'inactive'])->name('aboutcounter.inactive');
    Route::post('aboutcounter/active', [AboutcounterController::class, 'active'])->name('aboutcounter.active');
    Route::post('aboutcounter/destroy', [AboutcounterController::class, 'destroy'])->name('aboutcounter.destroy');

    // Aboutfaq Item routes
    Route::get('aboutfaq/manage', [AboutfaqController::class, 'index'])->name('aboutfaq.index');
    Route::get('aboutfaq/create', [AboutfaqController::class, 'create'])->name('aboutfaq.create');
    Route::post('aboutfaq/save', [AboutfaqController::class, 'store'])->name('aboutfaq.store');
    Route::get('aboutfaq/{id}/edit', [AboutfaqController::class, 'edit'])->name('aboutfaq.edit');
    Route::post('aboutfaq/update', [AboutfaqController::class, 'update'])->name('aboutfaq.update');
    Route::post('aboutfaq/inactive', [AboutfaqController::class, 'inactive'])->name('aboutfaq.inactive');
    Route::post('aboutfaq/active', [AboutfaqController::class, 'active'])->name('aboutfaq.active');
    Route::post('aboutfaq/destroy', [AboutfaqController::class, 'destroy'])->name('aboutfaq.destroy');

    // Product Item routes
    Route::get('product/manage', [ProductController::class, 'index'])->name('products.index');
    Route::get('product/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('product/save', [ProductController::class, 'store'])->name('products.store');
    Route::get('product/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::post('product/update', [ProductController::class, 'update'])->name('products.update');
    Route::post('product/inactive', [ProductController::class, 'inactive'])->name('products.inactive');
    Route::post('product/active', [ProductController::class, 'active'])->name('products.active');
    Route::post('product/destroy', [ProductController::class, 'destroy'])->name('products.destroy');

    // Protfolios
    Route::get('portfolio/manage', [PortfolioController::class, 'index'])->name('portfolios.index');
    Route::get('portfolio/create', [PortfolioController::class, 'create'])->name('portfolios.create');
    Route::post('portfolio/save', [PortfolioController::class, 'store'])->name('portfolios.store');
    Route::get('portfolio/{id}/edit', [PortfolioController::class, 'edit'])->name('portfolios.edit');
    Route::post('portfolio/update', [PortfolioController::class, 'update'])->name('portfolios.update');
    Route::post('portfolio/inactive', [PortfolioController::class, 'inactive'])->name('portfolios.inactive');
    Route::post('portfolio/active', [PortfolioController::class, 'active'])->name('portfolios.active');
    Route::post('portfolio/destroy', [PortfolioController::class, 'destroy'])->name('portfolios.destroy');

    // Counter Item routes
    Route::get('counter/manage', [CounterController::class, 'index'])->name('counters.index');
    Route::get('counter/create', [CounterController::class, 'create'])->name('counters.create');
    Route::post('counter/save', [CounterController::class, 'store'])->name('counters.store');
    Route::get('counter/{id}/edit', [CounterController::class, 'edit'])->name('counters.edit');
    Route::post('counter/update', [CounterController::class, 'update'])->name('counters.update');
    Route::post('counter/inactive', [CounterController::class, 'inactive'])->name('counters.inactive');
    Route::post('counter/active', [CounterController::class, 'active'])->name('counters.active');
    Route::post('counter/destroy', [CounterController::class, 'destroy'])->name('counters.destroy');

    // Researchwork Item routes
    Route::get('researchwork/manage', [ResearchworkController::class, 'index'])->name('researchworks.index');
    Route::get('researchwork/create', [ResearchworkController::class, 'create'])->name('researchworks.create');
    Route::post('researchwork/save', [ResearchworkController::class, 'store'])->name('researchworks.store');
    Route::get('researchwork/{id}/edit', [ResearchworkController::class, 'edit'])->name('researchworks.edit');
    Route::post('researchwork/update', [ResearchworkController::class, 'update'])->name('researchworks.update');
    Route::post('researchwork/inactive', [ResearchworkController::class, 'inactive'])->name('researchworks.inactive');
    Route::post('researchwork/active', [ResearchworkController::class, 'active'])->name('researchworks.active');
    Route::post('researchwork/destroy', [ResearchworkController::class, 'destroy'])->name('researchworks.destroy');

    // Package Item routes
    Route::get('package/manage', [PackageController::class, 'index'])->name('packages.index');
    Route::get('package/create', [PackageController::class, 'create'])->name('packages.create');
    Route::post('package/save', [PackageController::class, 'store'])->name('packages.store');
    Route::get('package/{id}/edit', [PackageController::class, 'edit'])->name('packages.edit');
    Route::post('package/update', [PackageController::class, 'update'])->name('packages.update');
    Route::post('package/inactive', [PackageController::class, 'inactive'])->name('packages.inactive');
    Route::post('package/active', [PackageController::class, 'active'])->name('packages.active');
    Route::post('package/destroy', [PackageController::class, 'destroy'])->name('packages.destroy');
    Route::get('package/price/{id}', [PackageController::class, 'price'])->name('packages.price');
    Route::post('package/price_store', [PackageController::class, 'price_store'])->name('packages.price_store');

    // Attribute Item routes
    Route::get('attribute/manage', [AttributeController::class, 'index'])->name('attributes.index');
    Route::get('attribute/create', [AttributeController::class, 'create'])->name('attributes.create');
    Route::post('attribute/save', [AttributeController::class, 'store'])->name('attributes.store');
    Route::get('attribute/{id}/edit', [AttributeController::class, 'edit'])->name('attributes.edit');
    Route::post('attribute/update', [AttributeController::class, 'update'])->name('attributes.update');
    Route::post('attribute/inactive', [AttributeController::class, 'inactive'])->name('attributes.inactive');
    Route::post('attribute/active', [AttributeController::class, 'active'])->name('attributes.active');
    Route::post('attribute/destroy', [AttributeController::class, 'destroy'])->name('attributes.destroy');

    // Pricing Item routes
    Route::get('pricing/manage', [PricingController::class, 'index'])->name('pricings.index');
    Route::get('pricing/create', [PricingController::class, 'create'])->name('pricings.create');
    Route::post('pricing/save', [PricingController::class, 'store'])->name('pricings.store');
    Route::get('pricing/{id}/edit', [PricingController::class, 'edit'])->name('pricings.edit');
    Route::post('pricing/update', [PricingController::class, 'update'])->name('pricings.update');
    Route::post('pricing/inactive', [PricingController::class, 'inactive'])->name('pricings.inactive');
    Route::post('pricing/active', [PricingController::class, 'active'])->name('pricings.active');
    Route::post('pricing/destroy', [PricingController::class, 'destroy'])->name('pricings.destroy');

    // Faq Item routes
    Route::get('faq/manage', [FaqController::class, 'index'])->name('faq.index');
    Route::get('faq/create', [FaqController::class, 'create'])->name('faq.create');
    Route::post('faq/save', [FaqController::class, 'store'])->name('faq.store');
    Route::get('faq/{id}/edit', [FaqController::class, 'edit'])->name('faq.edit');
    Route::post('faq/update', [FaqController::class, 'update'])->name('faq.update');
    Route::post('faq/inactive', [FaqController::class, 'inactive'])->name('faq.inactive');
    Route::post('faq/active', [FaqController::class, 'active'])->name('faq.active');
    Route::post('faq/destroy', [FaqController::class, 'destroy'])->name('faq.destroy');

    // Createpage routes
    Route::get('createpage/manage', [CreatepageController::class, 'index'])->name('createpage.index');
    Route::get('createpage/create', [CreatepageController::class, 'create'])->name('createpage.create');
    Route::post('createpage/save', [CreatepageController::class, 'store'])->name('createpage.store');
    Route::get('createpage/{id}/edit', [CreatepageController::class, 'edit'])->name('createpage.edit');
    Route::post('createpage/update', [CreatepageController::class, 'update'])->name('createpage.update');
    Route::post('createpage/inactive', [CreatepageController::class, 'inactive'])->name('createpage.inactive');
    Route::post('createpage/active', [CreatepageController::class, 'active'])->name('createpage.active');
    Route::post('createpage/destroy', [CreatepageController::class, 'destroy'])->name('createpage.destroy');

    // Pagetitle routes
    Route::get('pagetitle/manage', [PageTitleController::class, 'index'])->name('pagetitle.index');
    Route::get('pagetitle/create', [PageTitleController::class, 'create'])->name('pagetitle.create');
    Route::post('pagetitle/save', [PageTitleController::class, 'store'])->name('pagetitle.store');
    Route::get('pagetitle/{id}/edit', [PageTitleController::class, 'edit'])->name('pagetitle.edit');
    Route::post('pagetitle/update', [PageTitleController::class, 'update'])->name('pagetitle.update');
    Route::post('pagetitle/inactive', [PageTitleController::class, 'inactive'])->name('pagetitle.inactive');
    Route::post('pagetitle/active', [PageTitleController::class, 'active'])->name('pagetitle.active');
    Route::post('pagetitle/destroy', [PageTitleController::class, 'destroy'])->name('pagetitle.destroy');

    Route::get('sectiontitle/manage', [SectiontitleController::class, 'index'])->name('sectiontitle.index');
    Route::get('sectiontitle/create', [SectiontitleController::class, 'create'])->name('sectiontitle.create');
    Route::post('sectiontitle/save', [SectiontitleController::class, 'store'])->name('sectiontitle.store');
    Route::get('sectiontitle/{id}/edit', [SectiontitleController::class, 'edit'])->name('sectiontitle.edit');
    Route::post('sectiontitle/update', [SectiontitleController::class, 'update'])->name('sectiontitle.update');
    Route::post('sectiontitle/inactive', [SectiontitleController::class, 'inactive'])->name('sectiontitle.inactive');
    Route::post('sectiontitle/active', [SectiontitleController::class, 'active'])->name('sectiontitle.active');
    Route::post('sectiontitle/destroy', [SectiontitleController::class, 'destroy'])->name('sectiontitle.destroy');

    // State routes
    Route::get('state/manage', [StateController::class, 'index'])->name('state.index');
    Route::get('state/create', [StateController::class, 'create'])->name('state.create');
    Route::post('state/save', [StateController::class, 'store'])->name('state.store');
    Route::get('state/{id}/edit', [StateController::class, 'edit'])->name('state.edit');
    Route::post('state/update', [StateController::class, 'update'])->name('state.update');
    Route::post('state/inactive', [StateController::class, 'inactive'])->name('state.inactive');
    Route::post('state/active', [StateController::class, 'active'])->name('state.active');
    Route::post('state/destroy', [StateController::class, 'destroy'])->name('state.destroy');

    // chat
    Route::get('chat/{id}', [MessageController::class, 'vchat'])->name('chat');
    Route::get('messages', [MessageController::class, 'messages'])->name('messages');
    Route::post('message/send', [MessageController::class, 'message_send'])->name('message_send');
    Route::get('support/list', [MessageController::class, 'support_list'])->name('support_list');
    Route::get('support/chat', [MessageController::class, 'support_chat'])->name('support_chat');
    Route::get('unread-support', [MessageController::class, 'unread_support'])->name('unread_support');
    Route::get('unread-message', [MessageController::class, 'unread_message'])->name('unread_message');
    Route::get('sidebar-message', [MessageController::class, 'sidebar_message'])->name('sidebar_message');
    Route::get('unread-supportmsg', [MessageController::class, 'unread_supportmsg'])->name('unread_supportmsg');


    // couponcode route
    Route::get('couponcode/manage', [CouponcodeController::class, 'index'])->name('couponcode.index');
    Route::get('couponcode/create', [CouponcodeController::class, 'create'])->name('couponcode.create');
    Route::post('couponcode/save', [CouponcodeController::class, 'store'])->name('couponcode.store');
    Route::get('/couponcode/{id}/edit', [CouponcodeController::class, 'edit'])->name('couponcode.edit');
    Route::post('/couponcode/update', [CouponcodeController::class, 'update'])->name('couponcode.update');
    Route::post('/couponcode/inactive/', [CouponcodeController::class, 'inactive'])->name('couponcode.inactive');
    Route::post('/couponcode/active', [CouponcodeController::class, 'active'])->name('couponcode.active');
    Route::post('/couponcode/destroy', [CouponcodeController::class, 'destroy'])->name('couponcode.destroy');

    // Support Item routes
    Route::get('supportitem/manage', [SupportitemController::class, 'index'])->name('supportitem.index');
    Route::get('supportitem/create', [SupportitemController::class, 'create'])->name('supportitem.create');
    Route::post('supportitem/save', [SupportitemController::class, 'store'])->name('supportitem.store');
    Route::get('supportitem/{id}/edit', [SupportitemController::class, 'edit'])->name('supportitem.edit');
    Route::post('supportitem/update', [SupportitemController::class, 'update'])->name('supportitem.update');
    Route::post('supportitem/inactive', [SupportitemController::class, 'inactive'])->name('supportitem.inactive');
    Route::post('supportitem/active', [SupportitemController::class, 'active'])->name('supportitem.active');
    Route::post('supportitem/destroy', [SupportitemController::class, 'destroy'])->name('supportitem.destroy');

    // Transparent Item routes
    Route::get('transparent/manage', [TransparentController::class, 'index'])->name('transparent.index');
    Route::get('transparent/create', [TransparentController::class, 'create'])->name('transparent.create');
    Route::post('transparent/save', [TransparentController::class, 'store'])->name('transparent.store');
    Route::get('transparent/{id}/edit', [TransparentController::class, 'edit'])->name('transparent.edit');
    Route::post('transparent/update', [TransparentController::class, 'update'])->name('transparent.update');
    Route::post('transparent/inactive', [TransparentController::class, 'inactive'])->name('transparent.inactive');
    Route::post('transparent/active', [TransparentController::class, 'active'])->name('transparent.active');
    Route::post('transparent/destroy', [TransparentController::class, 'destroy'])->name('transparent.destroy');

     // Needleitem Item routes
    Route::get('needleitem/manage', [NeedleitemController::class, 'index'])->name('needleitem.index');
    Route::get('needleitem/create', [NeedleitemController::class, 'create'])->name('needleitem.create');
    Route::post('needleitem/save', [NeedleitemController::class, 'store'])->name('needleitem.store');
    Route::get('needleitem/{id}/edit', [NeedleitemController::class, 'edit'])->name('needleitem.edit');
    Route::post('needleitem/update', [NeedleitemController::class, 'update'])->name('needleitem.update');
    Route::post('needleitem/inactive', [NeedleitemController::class, 'inactive'])->name('needleitem.inactive');
    Route::post('needleitem/active', [NeedleitemController::class, 'active'])->name('needleitem.active');
    Route::post('needleitem/destroy', [NeedleitemController::class, 'destroy'])->name('needleitem.destroy');

//Partner  routes
Route::get('partner/index', [PartnerController::class, 'index'])->name('partner.index');
Route::post('partner/store', [PartnerController::class, 'store'])->name('partner.store');
Route::get('partner/{id}/edit', [PartnerController::class, 'edit'])->name('partner.edit');
Route::post('partner/update/{id}', [PartnerController::class, 'update'])->name('partner.update');
Route::post('partner/inactive', [PartnerController::class, 'inactive'])->name('partner.inactive');
Route::post('partner/active', [PartnerController::class, 'active'])->name('partner.active');
Route::post('partner/destroy', [PartnerController::class, 'destroy'])->name('partner.destroy');


// Team Item routes
Route::get('team/index', [TeamController::class, 'index'])->name('team.index');
Route::post('team/store', [TeamController::class, 'store'])->name('team.store');
Route::get('team/{id}/edit', [TeamController::class, 'edit'])->name('team.edit');
Route::post('team/update/{id}', [TeamController::class, 'update'])->name('team.update');
Route::post('team/inactive', [TeamController::class, 'inactive'])->name('team.inactive');
Route::post('team/active', [TeamController::class, 'active'])->name('team.active');
Route::post('team/destroy', [TeamController::class, 'destroy'])->name('team.destroy');



});
