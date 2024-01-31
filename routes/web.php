<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('admin', function () {
	return redirect('admin/login');
});

use App\Http\Controllers\Account\ApplicationController as AccountApplicationController;
use App\Http\Controllers\Account\PaymentController as AccountPaymentController;
use App\Http\Controllers\Account\TicketController as AccountTicketController;
use App\Http\Controllers\ApplicationRegisterController;
use App\Http\Controllers\Account\DashboardController;
use App\Http\Controllers\DocumentUploadController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Account\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPassword;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ChangePassword;            
use App\Http\Controllers\OtpController;

Route::get('register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
Route::get('otp_verify', [RegisterController::class, 'otpVerify'])->middleware('guest')->name('otp.verify');
Route::post('validate_otp', [RegisterController::class, 'validateOtp'])->middleware('guest')->name('otp.validate');
Route::post('otpVerifyPerform', [RegisterController::class, 'otpVerifyPerform'])->middleware('guest')->name('otp.verify.perform');

Route::get('login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');

Route::get('reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
Route::post('reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
Route::get('change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
Route::post('change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('working_video', [HomeController::class, 'workingVideo']);
Route::get('page/{slug}', [HomeController::class, 'page']);
Route::get('payment_url_callback', [PaymentController::class, 'paymentUrlcallBack']);

Route::post('contact/store', [ContactController::class, 'store'])->name('contact.store');

Route::prefix('trademark')->group(function(){
	Route::get('index', [ApplicationRegisterController::class, 'index']);
	Route::get('payment', [ApplicationRegisterController::class, 'payment']);
	Route::get('get_order_id', [PaymentController::class, 'getOrderId']);

	Route::post('payment/callback', [PaymentController::class, 'callBack']);
	Route::post('store_user', [ApplicationRegisterController::class, 'storeUser']);
});

Route::prefix('otp')->group(function(){
	Route::post('send', [OtpController::class, 'send']);
	Route::post('verify', [OtpController::class, 'verify']);
});

Route::group(['middleware' => 'auth'], function () {
	Route::post('logout', [LoginController::class, 'logout'])->name('logout');
	Route::prefix('account')->group(function(){
		Route::get('profile', [UserController::class, 'profile'])->name('account.profile');

		Route::post('profile_update', [UserController::class, 'profileUpdate'])->name('account.profile.update');
		Route::post('profile_image_upload', [UserController::class, 'profileImageUpdate'])->name('account.profile.image.upload');
		Route::post('profile_image_delete', [UserController::class, 'profileImageDelete'])->name('account.profile.image.delete');
		Route::post('document_upload', [DocumentUploadController::class, 'storeUserDocuments'])->name('account.document.upload');
		Route::post('delete_document', [DocumentUploadController::class, 'deleteDocument'])->name('account.document.delete');

		Route::prefix('dashboard')->group(function(){
			Route::get('index', [DashboardController::class, 'index'])->name('account.dashboard.index');
		});

		Route::prefix('application')->group(function() {
			Route::get('index', [AccountApplicationController::class, 'index'])->name('account.application.index');
			Route::get('detail/{id}', [AccountApplicationController::class, 'detail'])->name('account.application.detail');
			Route::get('apply', [AccountApplicationController::class, 'apply'])->name('account.application.apply');
			Route::get('upload_document', [AccountApplicationController::class, 'uploadDocument'])->name('account.application.upload_document');
			Route::get('show_document', [AccountApplicationController::class, 'showDocument'])->name('account.application.show_document');

			Route::post('get_order_id', [AccountPaymentController::class, 'getOrderId']);
			Route::post('payment/callback', [AccountPaymentController::class, 'callback']);
		});

		Route::prefix('ticket')->group(function() {
			Route::get('index', [AccountTicketController::class, 'index'])->name('account.ticket.index');
			Route::get('create', [AccountTicketController::class, 'create'])->name('account.ticket.create');
			Route::get('detail/{id}', [AccountTicketController::class, 'detail'])->name('account.ticket.detail');
			Route::post('store', [AccountTicketController::class, 'store'])->name('account.ticket.store');
			Route::post('send_message', [AccountTicketController::class, 'sendMessage'])->name('account.ticket.send_message');
		});
	});
});