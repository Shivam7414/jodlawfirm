<?php

use App\Http\Controllers\Admin\ApplicationSettingController;
use App\Http\Controllers\Admin\EmailTempleteController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\SocialLinkController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\DocumentUploadController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\PageController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('login', [LoginController::class, 'adminLogin']);
Route::post('logout', [LoginController::class, 'logout']);

Route::middleware(['auth:admin'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('document_upload', [DocumentUploadController::class, 'storeAdminDocuments'])->name('document_upload');
    Route::post('document_delete', [DocumentUploadController::class, 'deleteDocument'])->name('document_delete');
    
    Route::prefix('profile')->group(function () {
        Route::get('index', [App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('profile.index');
        Route::post('store', [App\Http\Controllers\Admin\ProfileController::class, 'store'])->name('profile.store');
    });

    Route::prefix('site_settings')->group(function(){
        Route::get('index', [SiteSettingController::class, 'index'])->name('site_settings.index');

        Route::post('store', [SiteSettingController::class, 'store'])->name('site_settings.store');
        Route::post('file_upload', [SiteSettingController::class, 'fileUpload'])->name('site_settings.file_upload');
    });

    Route::prefix('trademark_settings')->group(function(){
        Route::get('index', [ApplicationSettingController::class, 'index'])->name('registration.index');
        Route::get('price1_setting', [ApplicationSettingController::class, 'price1Setting']);
        Route::get('price2_setting', [ApplicationSettingController::class, 'price2Setting']);
        Route::get('required_documents', [ApplicationSettingController::class, 'requiredDocuments']);
        Route::get('add_youtube_video', [ApplicationSettingController::class, 'addYoutubeVideo']);
        
        Route::post('price1_setting_store', [ApplicationSettingController::class, 'price1SettingStore']);
        Route::post('price2_setting_store', [ApplicationSettingController::class, 'price2SettingStore']);
        Route::post('required_documents_store', [ApplicationSettingController::class, 'requiredDocumentsStore']);
        Route::post('store_content', [ApplicationSettingController::class, 'storeContent']);
        Route::post('store_youtube_video', [ApplicationSettingController::class, 'storeYoutubeVideo']);
    });

    Route::prefix('application')->group(function () {
        Route::get('index', [App\Http\Controllers\Admin\ApplicationController::class, 'index'])->name('application.index');
        Route::get('add', [App\Http\Controllers\Admin\ApplicationController::class, 'add'])->name('application.add');
        Route::get('detail/{id}', [App\Http\Controllers\Admin\ApplicationController::class, 'detail'])->name('application.detail');
        Route::get('search_users', [App\Http\Controllers\Admin\ApplicationController::class, 'searchUsers'])->name('application.search_users');
        Route::get('show_user_documents', [App\Http\Controllers\Admin\ApplicationController::class, 'showUserDocuments'])->name('application.show_user_documents');
        Route::get('show_admin_documents', [App\Http\Controllers\Admin\ApplicationController::class, 'showAdminDocuments'])->name('application.show_admin_documents');
        Route::get('upload_user_documents', [App\Http\Controllers\Admin\ApplicationController::class, 'uploadUserDocuments'])->name('application.upload_user_documents');

        Route::post('change_status/{id}', [App\Http\Controllers\Admin\ApplicationController::class, 'changeStatus'])->name('application.change_status');
        Route::post('generate_payment_link', [App\Http\Controllers\Admin\ApplicationController::class, 'generatePaymentLink'])->name('application.generate_payment_link');
    });

    Route::prefix('user')->group(function () {
        Route::get('index', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('user.index');
        Route::get('detail/{id}', [App\Http\Controllers\Admin\UserController::class, 'detail'])->name('user.detail');
        Route::get('add', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('user.add');
        Route::get('edit/{id}', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('user.edit');

        Route::post('store', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('user.store');
    });

    Route::prefix('api_credential')->group(function () {
        Route::get('index', [App\Http\Controllers\Admin\ApiCredentialController::class, 'index'])->name('api_credential.index');
        Route::post('store', [App\Http\Controllers\Admin\ApiCredentialController::class, 'store'])->name('api_credential.store');

        Route::post('update_payment_mode_status', [App\Http\Controllers\Admin\ApiCredentialController::class, 'updatePaymentModeStatus'])->name('api_credential.update_payment_mode_status');
    });

    Route::prefix('page')->group(function () {
        Route::get('index', [PageController::class, 'index'])->name('page.index');
        Route::get('add', [PageController::class, 'edit'])->name('page.add');
        Route::get('edit/{id}', [PageController::class, 'edit'])->name('page.edit');
        Route::get('add_category', [PageController::class, 'editCategory'])->name('page.add_category');
        Route::get('edit_category/{id}', [PageController::class, 'editCategory'])->name('page.edit_category');

        Route::post('store', [PageController::class, 'store'])->name('page.store');
        Route::post('delete', [PageController::class, 'delete'])->name('page.delete');
        Route::post('store_category', [PageController::class, 'storeCategory'])->name('page.store_category');
        Route::post('delete_category', [PageController::class, 'deleteCategory'])->name('page.delete_category');
    });

    Route::prefix('social_link')->group(function () {
        Route::get('index', [SocialLinkController::class, 'index'])->name('social_link.index');
        Route::post('store', [SocialLinkController::class, 'store'])->name('social_link.store');
    });

    Route::prefix('ticket')->group(function() {
        Route::get('index', [TicketController::class, 'index'])->name('ticket.index');
        Route::get('create', [TicketController::class, 'create'])->name('ticket.create');
        Route::get('detail/{id}', [TicketController::class, 'detail'])->name('ticket.detail');
        Route::post('store', [TicketController::class, 'store'])->name('ticket.store');
        Route::post('send_message', [TicketController::class, 'sendMessage'])->name('ticket.send_message');
        Route::post('change_status/{id}', [TicketController::class, 'changeStatus'])->name('ticket.change_status');
    });

    Route::prefix('contact_us')->group(function() {
        Route::get('index', [ContactController::class, 'index'])->name('contact_us.index');
        Route::post('change_status/{id}', [ContactController::class, 'changeStatus'])->name('contact_us.change_status');
    });

    Route::prefix('email_templete')->group(function() {
        Route::get('index', [EmailTempleteController::class, 'index'])->name('email_templete.index');
        Route::get('add', [EmailTempleteController::class, 'edit'])->name('email_templete.add');
        Route::get('edit/{id}', [EmailTempleteController::class, 'edit'])->name('email_templete.edit');

        Route::post('store', [EmailTempleteController::class, 'store'])->name('email_templete.store');
        Route::post('delete', [EmailTempleteController::class, 'delete'])->name('email_templete.delete');
    });
});