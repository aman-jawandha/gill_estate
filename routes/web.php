<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\SellerController;

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

// --------------------website routes-------------------

Route::controller(WebsiteController::class)->group(function () {
    Route::get('/','home')->name('home');
    Route::get('/about-us','about_us')->name('about-us');
    Route::get('/properties','properties')->name('properties');
    Route::get('/search-properties', 'search_properties')->name('search-properties');
    Route::get('/property-detail/{id}','property_detail')->name('property-detail');
    Route::get('/contact-us','contact_us')->name('contact-us');
    Route::post('/store-contact-us','store_contact_us')->name('store-contact-us');
    Route::get('/api/cities/{regionCode}','get_cities')->name('get-cities');
});

// --------------------common routes-------------------

Route::controller(AuthController::class)->group(function () {
    Route::get('login','login_form')->name('login');
    Route::post('post-login','login')->name('post_login');
    Route::get('check-email','check_email')->name('check-email');
    Route::get('/registration','register_form')->name('register');
    Route::post('post-register','register')->name('post-register');
    Route::get('/forgot-password','forgot_pswd')->name('forgot-password');
    Route::post('/send-reset-pswd-mail','send_reset_pswd_mail')->name('send-reset-pswd-mail');
    Route::get('/reset-password/{token}','reset_pswd_form')->name('reset-pswd-form');
    Route::post('/reset-password','reset_pswd')->name('reset-pswd');
});

Route::middleware(['auth'])->group(function (){
Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard','dashboard')->name('dashboard');
    Route::get('logout','logout')->name('logout');
    Route::get('profile','profile')->name('profile');
    Route::post('profile-update','profile_update')->name('profile-update');
    Route::post('/password-update','password_update')->name('password-update');
});
});

// --------------------admin routes-------------------

Route::middleware(['auth'])->group(function (){

    Route::controller(DashboardController::class)->group(function () {
        Route::get('contact-us-messages','contact_us_msgs')->name('contact-us-messages')->middleware('permission:contact-us-list');
        Route::get('queries','queries')->name('queries')->middleware('permission:queries-list');
        Route::delete('delete-feedback/{id}','delete_feedback')->name('delete-feedback');
    });

    Route::controller(RoleController::class)->group(function () {
        Route::get('roles','index')->name('roles')->middleware('permission:roles-list');
        Route::get('create-role','create')->name('create-role')->middleware('permission:create-role');
        Route::post('store-role','store')->name('store-role')->middleware('permission:create-role');
        Route::get('edit-role/{id}','edit')->name('edit-role')->middleware('permission:edit-role');
        Route::post('update-role','update')->name('update-role')->middleware('permission:edit-role');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('staff','staff')->name('staff')->middleware('permission:staff-list');
        Route::get('create-staff','create')->name('create-staff')->middleware('permission:create-staff');
        Route::post('store-staff','store')->name('store-staff')->middleware('permission:create-staff');
        Route::get('edit-staff/{id}','edit')->name('edit-staff')->middleware('permission:edit-staff');
        Route::post('update-staff','update')->name('update-staff')->middleware('permission:edit-staff');
        Route::delete('delete-staff/{id}','delete')->name('delete-staff')->middleware('permission:delete-staff');
        Route::get('sellers','sellers')->name('sellers')->middleware('permission:sellers-list');
        Route::post('delete-seller/{id}','delete_seller')->name('delete-seller')->middleware('permission:delete-seller');
        Route::get('buyers','buyers')->name('buyers')->middleware('permission:buyers-list');
        Route::post('delete-buyer/{id}','delete_buyer')->name('delete-buyer')->middleware('permission:delete-buyer');
    });

    Route::controller(FaqController::class)->group(function () {
        Route::get('faqs','index')->name('faqs')->middleware('permission:faqs-list');
        Route::get('create-faq','create')->name('create-faq')->middleware('permission:create-faq');
        Route::post('store-faq','store')->name('store-faq')->middleware('permission:create-faq');
        Route::get('edit-faq/{id}','edit')->name('edit-faq')->middleware('permission:edit-faq');
        Route::post('update-faq','update')->name('update-faq')->middleware('permission:edit-faq');
        Route::delete('delete-faq/{id}','delete')->name('delete-faq')->middleware('permission:delete-faq');
    });

    Route::controller(PropertyController::class)->group(function () {
        Route::get('properties-list','index')->name('properties-list')->middleware('permission:properties-list');
        Route::get('search-properties-list','search')->name('search-properties-list')->middleware('permission:properties-list');
        Route::get('create-property','create')->name('create-property')->middleware('permission:create-property');
        Route::post('store-property','store')->name('store-property')->middleware('permission:create-property');
        Route::get('edit-property/{id}','edit')->name('edit-property')->middleware('permission:edit-property');
        Route::get('edit-seller-property/{id}','edit')->name('edit-seller-property')->middleware('permission:edit-property');
        Route::post('update-property','update')->name('update-property')->middleware('permission:edit-property');
        Route::delete('delete-property/{id}','delete')->name('delete-property')->middleware('permission:delete-property');
        Route::get('view-property/{id}','view')->name('view-property')->middleware('permission:view-property');
        Route::get('view-seller-property/{id}','view')->name('view-seller-property')->middleware('permission:view-property');
        Route::post('store-property-images','store_property_images')->name('store-property-images')->middleware('permission:add-property-media');
        Route::post('store-property-video','store_property_video')->name('store-property-video')->middleware('permission:add-property-media');
        Route::delete('delete-property-media/{id}','delete_property_media')->name('delete-property-media')->middleware('permission:delete-property-media');
        Route::get('buyers-requirements','buyers_requirements')->name('buyers-requirements')->middleware('permission:buyers-requirements-list');
        Route::delete('delete-requirement/{id}','delete_requirement')->name('delete-requirement')->middleware('permission:delete-requirement');
        Route::get('sellers-properties','sellers_properties')->name('sellers-properties')->middleware('permission:sellers-properties');
        Route::post('reject-property','reject_property')->name('reject-property')->middleware('permission:reject-property');
    });
});

// --------------------seller routes-------------------

Route::middleware(['auth', 'role:seller'])->group(function (){
    Route::controller(SellerController::class)->group(function () {
        Route::get('sell-property','sell_property')->name('sell-property');
        Route::get('my-properties','my_properties')->name('my-properties');
        Route::get('edit-my-property/{id}','edit_property')->name('edit-my-property');
        Route::get('view-my-property/{id}','view_property')->name('view-my-property');
    });

    Route::controller(PropertyController::class)->group(function () {
        Route::post('store-my-property','store')->name('store-my-property');
        Route::post('update-my-property','update')->name('update-my-property');
        Route::delete('delete-my-property/{id}','delete')->name('delete-my-property');
        Route::post('store-my-property-images','store_property_images')->name('store-my-property-images');
        Route::post('store-my-property-video','store_property_video')->name('store-my-property-video');
        Route::delete('delete-my-property-media/{id}','delete_property_media')->name('delete-my-property-media');
    });
});

// --------------------buyer routes-------------------

Route::middleware(['auth', 'role:buyer'])->group(function (){
    Route::controller(BuyerController::class)->group(function () {
        Route::get('favourite-property','fav_property')->name('favourite-property');
        Route::get('shortlisted-properties','fav_properties')->name('shortlisted-properties');
        Route::get('find-property','find_property')->name('find-property');
        Route::post('store-property-requirements','store_property_requirements')->name('store-property-requirements');
        Route::delete('delete-property-requirement/{id}','delete_property_requirement')->name('delete-property-requirement');
    });
});
