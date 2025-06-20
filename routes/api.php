<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfessionalController;
use App\Http\Controllers\ProfessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\PageViewController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\RatingController;


use App\Http\Middleware\Right;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/send-email', [MailController::class, 'sendEmail']);



//auth
Route::post("register", [AuthController::class, 'register'])->middleware('api');
Route::post("login", [AuthController::class, 'login']);
Route::get("logout", [AuthController::class, 'logout'])->middleware('auth:sanctum');

//users
Route::post("addProfessional", [ProfessionalController::class, 'add']);
Route::post("addUser", [UserController::class, 'add']);
Route::get("getUsers/{id?}", [UserController::class, 'listallusers']);
Route::get("user/{id}", [UserController::class, 'getUserById']);
Route::delete("deleteuser/{id}", [UserController::class, 'delete']);

Route::get("user_main", [UserController::class, 'index'])->middleware('auth:sanctum', Right::class.":user");


Route::get('skills', [SkillController::class, 'getSkills']);


//jobs apis
Route::post("addJob", [JobController::class, 'add']);
Route::get("listJobs", [JobController::class, 'list']);
Route::get("jobs/{userId}", [JobController::class, 'myJobs']);

//job statistics apis
Route::get("jobstatistics/{userId}/{year}", [JobController::class, 'monthlyStatistics']);
Route::get("monthlyProfits/{userId}/{year}", [JobController::class, 'monthlyProfits']);
Route::get("usertypes", [UserController::class, 'userTypes']);

//profession apis
Route::get("professions/{userId}", [ProfessionalController::class, 'myProfessions']);
Route::post("addProfession", [ProfessionController::class, 'addProfession']);

//professional apis
Route::get("professions/{userId}", [ProfessionalController::class, 'myProfessions']);

//page view
Route::post("addpageview", [PageViewController::class, 'addPageView']);


//ratings
Route::post("addrating",  [RatingController::class, 'addRating']);
Route::get("getratings/{idxx}",  [RatingController::class, 'getRatings']);