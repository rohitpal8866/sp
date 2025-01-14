<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
})->name('login');


Route::post('login' , [LoginController::class,'login'])->name('login');

Route::get('git-pull', function () {
  try{
    
  } catch (\Exception $e) {
    return response()->json([
        'message' => 'Git pull failed!',
        'error' => $e->getMessage()
    ], 500);
}
})->name('git-pull');

Route::group(['middleware' => ['auth'] , 'as' => 'admin.'], function () {

    Route::group(['prefix'=> 'dashboard' , 'as' => 'dashboard.' ], function () {
        Route::get('/', function () {
            return view('admin.dashboard.index');
        })->name('index');
    });


    Route::group(['prefix'=> 'building' , 'as' => 'building.' ], function () {
        Route::get('/', function () {
            return view('admin.building.index');
        })->name('index');
    });
    
});
