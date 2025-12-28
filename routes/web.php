<?php

use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandlordController;
use App\Http\Controllers\RoommateController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'ShowLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/register', [AuthController::class, 'ShowRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['role:landlord'], 'prefix' => 'landlord'], function () {

    // Profile
    Route::get('/profile', [LandlordController::class, 'profile'])->name('profile');
    Route::post('/profile', [LandlordController::class, 'updateProfile'])->name('updateProfile');

    // Apartment Posts (Create new apartment listing)
    Route::get('/post', [LandlordController::class, 'createPost'])->name('posts.create');
    Route::post('/post', [LandlordController::class, 'storePost'])->name('store.post');


    Route::get('/applications', [LandlordController::class, 'applications'])->name('applications');
    Route::put('/landlord/applications/{id}', [LandlordController::class, 'updateApplication'])
        ->name('landlord.applications.update');

    Route::get('/dashboard', [LandlordController::class, 'dashboard'])->name('dashboard');

    // Apartments (CRUD)
    Route::get('/apartments/{apartment}', [ApartmentController::class, 'show'])->name('apartments.show'); // View
    Route::get('/apartments/{apartment}/edit', [ApartmentController::class, 'edit'])->name('apartments.edit'); // Edit
    Route::put('/apartments/{apartment}', [ApartmentController::class, 'update'])->name('apartments.update'); // Update
    Route::delete('/apartments/{apartment}', [ApartmentController::class, 'destroy'])->name('apartments.destroy'); // Delete

    // Verification
    Route::get('/verify', [LandlordController::class, 'verificationForm'])->name('landlord.verification.form');
    Route::post('/verify', [LandlordController::class, 'submitVerification'])->name('landlord.verification.submit');
});

Route::group(['middleware' => ['role:student'], 'prefix' => 'student'], function () {
    Route::get('/profile', [StudentController::class, 'profile'])->name('student.profile');
    Route::post('/profile', [StudentController::class, 'updateProfile'])->name('student.updateProfile');

    Route::get('/apartments', [StudentController::class, 'apartments'])->name('student.apartments');
    Route::post('/apartments/{apartment}/apply', [StudentController::class, 'applyApartment'])->name('student.apartments.apply');

    Route::get('/applications', [StudentController::class, 'applications'])->name('student.applications');
    Route::get('/landlord/{id}', [StudentController::class, 'viewLandlord'])
        ->name('student.landlord.profile');
    Route::get('/student/{id}', [StudentController::class, 'viewStudent'])
        ->name('student.view');

    // ROOMMATE POSTS
    Route::get('/roommates', [RoommateController::class, 'index'])->name('student.roommates.index');
    Route::get('/roommates/create', [RoommateController::class, 'create'])->name('student.roommates.create');
    Route::post('/roommates/store', [RoommateController::class, 'store'])->name('student.roommates.store');
    Route::post('/favorites/toggle', [App\Http\Controllers\FavoriteController::class, 'toggle'])->name('student.favorites.toggle');
    Route::get('/saved-items', [App\Http\Controllers\FavoriteController::class, 'index'])->name('student.favorites.index');
    Route::get('/roommates/my-posts', [RoommateController::class, 'myPosts'])->name('student.roommates.myPosts');

    // PAYMENT ROUTES
    Route::get('/payment/initiate/{application}', [App\Http\Controllers\PaymentController::class, 'initiate'])->name('student.payment.initiate');
    Route::post('/payment/execute/{application}', [App\Http\Controllers\PaymentController::class, 'execute'])->name('student.payment.execute');
    Route::get('/payment/success/{application}', [App\Http\Controllers\PaymentController::class, 'success'])->name('student.payment.success');
    Route::post('/payment/cancel/{application}', [App\Http\Controllers\PaymentController::class, 'cancel'])->name('student.payment.cancel');

    // REVIEW ROUTES
    Route::post('/apartments/{apartment}/review', [App\Http\Controllers\ReviewController::class, 'store'])->name('student.reviews.store');
    Route::get('/apartments/{apartment}/reviews', [App\Http\Controllers\ReviewController::class, 'index'])->name('student.reviews.index');
    // APPLY TO BE ROOMMATE
    Route::post('/roommates/{post}/apply', [RoommateController::class, 'apply'])->name('student.roommates.apply');

    // MANAGE APPLICATIONS FOR THE CREATOR
    Route::get('/roommates/manage', [RoommateController::class, 'manage'])->name('student.roommates.manage');
    Route::post('/roommates/{roommate}/update', [RoommateController::class, 'updateStatus'])->name('student.roommates.update');
    Route::put('/roommates/post/{post}/update', [RoommateController::class, 'updatePost'])->name('student.roommates.updatePost');
    Route::get('/roommates/my-applications', [RoommateController::class, 'myApplications'])->name('student.roommates.applications');
});

// CHAT ROUTES
Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{conversation}', [App\Http\Controllers\ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{conversation}/send', [App\Http\Controllers\ChatController::class, 'store'])->name('chat.send');
    Route::get('/chat/start/{user}', [App\Http\Controllers\ChatController::class, 'start'])->name('chat.start');
    Route::get('/chat/message-partial/{message}', [App\Http\Controllers\ChatController::class, 'getMessagePartial'])->name('chat.message.partial');
    Route::get('/chat/{conversation}/poll', [App\Http\Controllers\ChatController::class, 'getNewMessages'])->name('chat.poll');
});
