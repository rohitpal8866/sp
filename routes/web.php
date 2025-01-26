<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\FlatController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SiteConfigurationController;
use App\Http\Controllers\TenantController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.dashboard.index');
})->name('home');


// Route::post('login' , [LoginController::class,'login'])->name('login');

// Route::get('git-pull', function () {
//     try {
//         // Execute the git pull command and capture both output and status
//         $output = [];
//         $status = null;
//         exec('git pull 2>&1', $output, $status);

//         // If the command was successful, return the output
//         if ($status === 0) {
//             return response()->json([
//                 'message' => 'Git pull successful!',
//                 'output' => implode("\n", $output)
//             ]);
//         } else {
//             // Check if the error is related to dubious ownership
//             $errorMessage = implode("\n", $output);
//             if (strpos($errorMessage, 'detected dubious ownership in repository') !== false) {
//                 // Attempt to fix the issue by marking the directory as safe
//                 $fixCommand = 'git config --global --add safe.directory D:/sp';
//                 exec($fixCommand, $fixOutput, $fixStatus);

//                 if ($fixStatus === 0) {
//                     // Retry the git pull after fixing the ownership issue
//                     exec('git pull 2>&1', $output, $status);
//                     if ($status === 0) {
//                         return response()->json([
//                             'message' => 'Git pull successful after fixing the safe directory!',
//                             'output' => implode("\n", $output)
//                         ]);
//                     }
//                 }
//             }

//             // If the git pull failed, return the error message
//             return response()->json([
//                 'message' => 'Git pull failed!',
//                 'error' => $errorMessage
//             ], 500);
//         }
//     } catch (\Exception $e) {
//         // Catch any other exceptions that might occur
//         return response()->json([
//             'message' => 'An error occurred while executing git pull!',
//             'error' => $e->getMessage()
//         ], 500);
//     }
// })->name('git-pull');

Route::get('git-pull', [GeneralController::class, 'gitPull'])->name('git-pull');

Route::group([ 'as' => 'admin.'], function () {

    Route::group(['prefix'=> 'dashboard' , 'as' => 'dashboard.' ], function () {
        Route::get('/', function () {
            return view('admin.dashboard.index');
        })->name('index');
    });


    Route::group(['prefix'=> 'building' ], function () {
        // Building
        Route::get('/', [BuildingController::class,'index'])->name('building.index');
        Route::get('/create', [BuildingController::class,'create'])->name('building.create');
        Route::post('/store', [BuildingController::class,'store'])->name('building.store');
        Route::get('/show/{id}', [BuildingController::class,'show'])->name('building.show');
        Route::post('/update/{id}', [BuildingController::class,'update'])->name('building.update');
        Route::delete('/delete/{id}', [BuildingController::class,'delete'])->name('building.delete');

        // Flat
        Route::group(['prefix'=> 'flat'], function () {
            Route::get('/{id}', [FlatController::class,'index'])->name('flat');
            Route::post('/store', [FlatController::class,'store'])->name('flat.store');
            Route::get('/show/{id}', [FlatController::class,'show'])->name('flat.show');
            Route::post('/update/{id}', [FlatController::class,'update'])->name('flat.update');
            Route::delete('/delete/{id}', [FlatController::class,'delete'])->name('flat.delete');
        });
    });

    // Tenant
    Route::group(['prefix'=> 'tenant' , 'as' => 'tenant.'], function () {
        Route::get('/', [TenantController::class,'index'])->name('index');
        Route::get('/create', [TenantController::class,'create'])->name('create');
        Route::post('/store', [TenantController::class,'store'])->name('store');
        Route::get('/show/{id}', [TenantController::class,'show'])->name('show');
        Route::post('/update/{id}', [TenantController::class,'update'])->name('update');
        Route::get('/get-flats', [TenantController::class, 'getFlats'])->name('getFlats');
        Route::delete('/delete/{id}', [TenantController::class,'delete'])->name('delete');
        Route::get('/remove-document/{id}', [TenantController::class,'removeDocument'])->name('removeDocument');

    });

    // Bills
    Route::group(['prefix'=> 'bill' , 'as' => 'bill.'], function () {
        Route::get('/', [BillController::class,'index'])->name('index');
        Route::post('/update', [BillController::class,'update'])->name('update');
        Route::post('/pdf-print', [BillController::class,'billPrint'])->name('pdf-print');
        Route::get('/generate-bill/{id}', [BillController::class,'generateBill'])->name('generate-bill');
    });

    // Payment
    Route::group(['prefix'=> 'payment','as'=> 'payment.'], function () {
        Route::get('/', [BillController::class,'store'])->name('store');
    });
    // WebSite Configuration
    Route::group(['prefix'=> 'account-configuration' , 'as' => 'siteconfig.'], function () {
        Route::get('/', [SiteConfigurationController::class,'index'])->name('index');
        Route::post('/store', [SiteConfigurationController::class,'store'])->name('store');
        Route::put('/update', [SiteConfigurationController::class,'update'])->name('update');
        Route::delete('/delete/{id}', [SiteConfigurationController::class,'delete'])->name('delete');
    });
    
});
