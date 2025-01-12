<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
})->name('login');


Route::post('login' , [LoginController::class,'login'])->name('login');


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
