<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProjectController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
   
//     Route::post('project',[ProjectController::class,'project']);
//     Route::post('employee',[EmployeeController::class,'employee']);

// });

Route::group([
    'prefix'=>'snapnet',
],
function()
    {
        // LOGIN AND REGISTRATION
        Route::post('login', [EmployeeController::class,'loginEmployee']);
        Route::post('register', [EmployeeController::class,'registerEmployee']);
        Route::post('logout', [EmployeeController::class,'logoutEmployeer']);
    }
);


Route::group(['prefix'=>'snapnet',], function() {

    Route::post('create-project',[ProjectController::class,'createProject']);
    Route::post('show-project',[ProjectController::class,'showProject']);
    Route::post('update-project',[ProjectController::class,'UpdateProject']);
    Route::post('destroy-project',[ProjectController::class,'destroyProject']);
    Route::post('search',[ProjectController::class,'search']);
    Route::post('dashboard',[ProjectController::class,'dashboard']);
    Route::post('update-employee',[EmployeeController::class,'updateEmployee']);
    Route::post('destroy-employee',[EmployeeController::class,'destroyEmployee']);
    Route::get('dashboard', [ProjectController::class, 'dashboard']);


});
