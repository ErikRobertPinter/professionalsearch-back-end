<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfessionalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\PageViewController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ProfessionController;
use App\Http\Controllers\SkillController;


use App\Http\Middleware\Right;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/send-email', [MailController::class, 'sendEmail']);

Route::post("addProfessional", [ProfessionalController::class, 'add']);
Route::post("addUser", [UserController::class, 'add']);
Route::get("getUsers/{id?}", [UserController::class, 'list']);
Route::get("user/{id}", [UserController::class, 'getUserById']);
Route::delete("deleteUser/{id}", [UserController::class, 'delete']);
//auth
Route::put("register", [AuthController::class, 'register'])->middleware('api');
Route::post("login", [AuthController::class, 'login']);
Route::get("logout", [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get("user_main", [UserController::class, 'index'])->middleware('auth:sanctum', Right::class.":user");


Route::get('skills', [SkillController::class, 'getSkills']);


//jobs apis
Route::post("addJob", [JobController::class, 'add']);
Route::get("listJobs", [JobController::class, 'list']);
Route::get("jobs/{userId}", [JobController::class, 'myJobs']);

//profession apis
Route::get("professions/{userId}", [ProfessionalController::class, 'myProfessions']);

//page view
Route::post("addpageview", [PageViewController::class, 'addPageView']);

//profession apis
Route::post("addProfession", [ProfessionController::class, 'addProfession']);