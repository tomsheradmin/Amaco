<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AizUploadController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\Bannercontroller;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BusinessSettingsController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\FaqCategoryController;
use App\Http\Controllers\Admin\HomeSliderController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PartnersController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\WebsiteController;
use App\Http\Controllers\Admin\JobApplicationController;
use App\Http\Controllers\Admin\JobVacancyController;
use App\Http\Controllers\Admin\SubsidiaryController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/notifications', function () {
    $admin = auth()->user();
    return $admin->unreadNotifications;
})->middleware('auth');

Route::post('/admin/notifications/mark-as-read', function () {
    $admin = auth()->user();
    $admin->unreadNotifications->markAsRead();
    return response()->json(['success' => true]);
})->middleware('auth');

Route::group(['middleware' => ['guest']], function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AuthController::class, 'login']);
});

Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/', [AdminController::class, 'admin_dashboard'])->name('admin.dashboard');
    Route::get('/cache-cache', [AdminController::class, 'clearCache'])->name('cache.clear');

    Route::resource('roles', RoleController::class);
    Route::get('/roles/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
    Route::get('/roles/destroy/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');

    Route::resource('staffs', StaffController::class);
    Route::get('/staffs/destroy/{id}', [StaffController::class, 'destroy'])->name('staffs.destroy');

    Route::post('/banners/get_form', [Bannercontroller::class, 'get_form'])->name('banners.get_form');
    Route::get('/banners/destroy/{banner}', [Bannercontroller::class, 'destroy'])->name('banners.destroy');
    Route::resource('banners', Bannercontroller::class)->except(['show', 'destroy']);
    Route::get('/banners/edit/{id}', [Bannercontroller::class, 'edit'])->name('banners.edit');

    Route::get('/enquiries-contact', [PageController::class, 'enquiries'])->name('enquiries.contact');
    // website setting
    Route::group(['prefix' => 'website'], function () {
        Route::get('/footer', [WebsiteController::class, 'footer'])->name('website.footer');

        Route::get('/menu', [WebsiteController::class, 'menu'])->name('website.menu');
        Route::post('/menu', [WebsiteController::class, 'menuUpdate']);

        Route::get('/header', [WebsiteController::class, 'header'])->name('website.header');
        Route::get('/appearance', [WebsiteController::class, 'appearance'])->name('website.appearance');

        Route::post('/home-slider/update-status', [HomeSliderController::class, 'updateStatus'])->name('home-slider.update-status');
        Route::get('/home-slider/delete/{id}', [HomeSliderController::class, 'destroy'])->name('home-slider.delete');
        Route::resource('home-slider', HomeSliderController::class);


        Route::resource('custom-pages', PageController::class);
        Route::get('/pages', [PageController::class, 'index'])->name('website.pages');
        Route::get('/custom-pages/edit/{id}', [PageController::class, 'edit'])->name('custom-pages.edit');
        Route::get('/custom-pages/destroy/{id}', [PageController::class, 'destroy'])->name('custom-pages.destroy');
        Route::post('/page/delete_image', [PageController::class, 'delete_image'])->name('page.delete_image');

        Route::get('/subscribers', [PageController::class, 'subscribers'])->name('subscribers.index');
        Route::get('/subscribers/destroy/{id}', [PageController::class, 'subscribersDestroy'])->name('subscriber.destroy');

        // Partners
        Route::resource('partners', PartnersController::class)->except('show');
    });

    // Manage testimonials
    Route::resource('testimonials', TestimonialController::class)->except('show');
    Route::get('/testimonials/delete/{id}', [TestimonialController::class, 'destroy'])->name('testimonials.delete');
    Route::post('/testimonials/update-status', [TestimonialController::class, 'updateStatus'])->name('testimonials.update-status');

    // uploaded files
    Route::any('/uploaded-files/file-info', [AizUploadController::class, 'file_info'])->name('uploaded-files.info');
    Route::resource('/uploaded-files', AizUploadController::class);
    Route::get('/uploaded-files/destroy/{id}', [AizUploadController::class, 'destroy'])->name('uploaded-files.destroy');
    Route::post('/aiz-uploader', [AizUploadController::class, 'show_uploader']);
    Route::post('/aiz-uploader/upload', [AizUploadController::class, 'upload']);
    Route::get('/aiz-uploader/get_uploaded_files', [AizUploadController::class, 'get_uploaded_files']);
    Route::post('/aiz-uploader/get_file_by_ids', [AizUploadController::class, 'get_preview_files']);
    Route::get('/aiz-uploader/download/{id}', [AizUploadController::class, 'attachment_download'])->name('download_attachment');

    //Notifications
    Route::get('/all-notification', [NotificationController::class, 'index'])->name('admin.all-notification');

    //Reviews
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/published', [ReviewController::class, 'updatePublished'])->name('reviews.published');

    Route::get('invoice/{order_id}', [InvoiceController::class, 'invoice_download'])->name('invoice.download');

    Route::resource('customers', CustomerController::class);
    Route::get('customers_ban/{customer}', [CustomerController::class, 'ban'])->name('customers.ban');
    Route::get('/customers/login/{id}', [CustomerController::class, 'login'])->name('customers.login');
    Route::get('/customers/destroy/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    Route::post('/bulk-customer-delete', [CustomerController::class, 'bulk_customer_delete'])->name('bulk-customer-delete');

    Route::post('/business-settings/update', [BusinessSettingsController::class, 'update'])->name('business_settings.update');

    Route::post('/business-settings/update-settings', [BusinessSettingsController::class, 'updateSettings'])->name('business_settings.update_settings');

    //Manage faq categories
    Route::get('/faq_categories/all', [FaqCategoryController::class, 'index'])->name('faq_categories.index');
    Route::get('/faq_categories/create', [FaqCategoryController::class, 'create'])->name('faq_categories.create');
    Route::post('/faq_categories/store/', [FaqCategoryController::class, 'store'])->name('faq_categories.store');
    Route::get('/faq_categories/edit/{id}', [FaqCategoryController::class, 'edit'])->name('faq_categories.edit');
    Route::post('/faq_categories/update/{id}', [FaqCategoryController::class, 'update'])->name('faq_categories.update');
    Route::post('/faq_categories/status', [FaqCategoryController::class, 'updateStatus'])->name('faq_categories.status');
    Route::get('/faq_categories/delete/{id}', [FaqCategoryController::class, 'destroy'])->name('faq_categories.delete');

    Route::get('/faqs/edit/{id}', [FaqCategoryController::class, 'getAllCategoryFaqs'])->name('faqs.edit');
    Route::post('/faqs/update', [FaqCategoryController::class, 'updateFaq'])->name('faqs.update');

    // Manage Blogs
    Route::get('/blogs/all', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/create', [BlogController::class, 'create'])->name('blog.create');
    Route::post('/blog/store/', [BlogController::class, 'store'])->name('blog.store');
    Route::get('/blog/edit/{id}', [BlogController::class, 'edit'])->name('blog.edit');
    Route::post('/blog/update/{id}', [BlogController::class, 'update'])->name('blog.update');
    Route::post('/blog/status', [BlogController::class, 'updateStatus'])->name('blog.status');
    Route::get('/blog/delete/{id}', [BlogController::class, 'destroy'])->name('blog.delete');

    Route::get('/configuration', [BusinessSettingsController::class, 'shipping_configuration'])->name('shipping_configuration.index');
    Route::post('/shipping_configuration/free_shipping', [BusinessSettingsController::class, 'freeshipping_settings'])->name('shipping_configuration.free_shipping');
    Route::post('/configuration/return', [BusinessSettingsController::class, 'return_settings'])->name('configuration.return_settings');
    Route::post('/configuration/vat', [BusinessSettingsController::class, 'vat_settings'])->name('configuration.vat_settings');
    Route::post('/configuration/pickup', [BusinessSettingsController::class, 'pickup_settings'])->name('configuration.pickup_settings');
    Route::post('/configuration/delivery', [BusinessSettingsController::class, 'delivery_settings'])->name('configuration.delivery_settings');
    Route::post('/configuration/invoice', [BusinessSettingsController::class, 'invoice_settings'])->name('configuration.invoice_settings');
    Route::post('/configuration/seo-og', [BusinessSettingsController::class, 'seo_og_image_settings'])->name('configuration.seo_og_image_settings');
    Route::post('/configuration/cod-charge', [BusinessSettingsController::class, 'cod_charge_settings'])->name('configuration.cod_charge_settings');
    Route::post('/configuration/payment-methods', [BusinessSettingsController::class, 'payment_methods_settings'])->name('configuration.payment_methods_settings');

    //Reports
    Route::get('/stock_report', [ReportController::class, 'stock_report'])->name('stock_report.index');
    Route::get('/export-stock-report', [ReportController::class, 'exportStockReport'])->name('export.stock_report');

    Route::get('/in_house_sa le_report', [ReportController::class, 'in_house_sale_report'])->name('in_house_sale_report.index');

    Route::get('/wish_report', [ReportController::class, 'wish_report'])->name('wish_report.index');
    Route::get('/export-wish-report', [ReportController::class, 'exportWishReport'])->name('export.wish_report');

    Route::get('/user_search_report', [ReportController::class, 'user_search_report'])->name('user_search_report.index');
    Route::get('/export-search-report', [ReportController::class, 'exportSearchReport'])->name('export.search_report');

    Route::get('/sales_report', [ReportController::class, 'sales_report'])->name('sales_report.index');
    Route::get('/sales_orders/{id}/show', [ReportController::class, 'sales_orders_show'])->name('sales_orders.show');
    Route::get('/export-sales-report', [ReportController::class, 'exportSalesReport'])->name('export.sales_report');

    // Menus
    Route::prefix('menus')->name('menus.')->group(function () {
        Route::get('/', [MenuController::class, 'index'])->name('index');
        Route::post('/', [MenuController::class, 'store'])->name('store');
        Route::get('{type}/{id}/edit', [MenuController::class, 'edit']);
        Route::put('{type}/{id}', [MenuController::class, 'update']);
        Route::delete('{type}/{id}', [MenuController::class, 'destroy']);
    });
    Route::get('/menus/get-items/{type}', [MenuController::class, 'getItems'])->name('menus.getItems');
    Route::post('menus/update-order', [MenuController::class, 'updateOrder'])->name('menus.updateOrder');

    // Manage services
    Route::get('/service/all', [ServiceController::class, 'index'])->name('service.index');
    Route::get('/service/create', [ServiceController::class, 'create'])->name('service.create');
    Route::post('/service/store/', [ServiceController::class, 'store'])->name('service.store');
    Route::get('/service/edit/{id}', [ServiceController::class, 'edit'])->name('service.edit');
    Route::post('/service/update/{id}', [ServiceController::class, 'update'])->name('service.update');
    Route::post('/service/status', [ServiceController::class, 'updateStatus'])->name('service.status');
    Route::get('/service/delete/{id}', [ServiceController::class, 'destroy'])->name('service.delete');

    // Blogs (News and Updates)
    Route::resource('job-vacancies', JobVacancyController::class)
        ->names('job-vacancies')
        ->except(['show']);

    // Jobs
    Route::get(
        'job-applications',
        [JobApplicationController::class, 'index']
    )->name('job-applications.index');

    Route::get(
        'job-applications/{jobApplication}',
        [JobApplicationController::class, 'show']
    )->name('job-applications.show');

    Route::patch(
        'job-applications/{jobApplication}',
        [JobApplicationController::class, 'update']
    )->name('job-applications.update');

    Route::get(
        'job-applications/{jobApplication}/cv',
        [JobApplicationController::class, 'downloadCv']
    )->name('job-applications.cv');

    // Subsidiary
    Route::resource('subsidiaries', SubsidiaryController::class)
        ->except(['show']);
});

Route::get('/env-check', function () {
    return [
        'php_version' => PHP_VERSION,
        'gd_loaded'   => extension_loaded('gd'),
        'php_ini'     => php_ini_loaded_file(),
        'php_binary' => PHP_BINARY,
    ];
});
