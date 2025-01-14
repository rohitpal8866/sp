<?php

use App\Http\Controllers\BuildingController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.dashboard.index');
})->name('home');


// Route::post('login' , [LoginController::class,'login'])->name('login');

Route::get('git-pull', function () {
    try {
        // Execute the git pull command and capture both output and status
        $output = [];
        $status = null;
        exec('git pull 2>&1', $output, $status);

        // If the command was successful, return the output
        if ($status === 0) {
            return response()->json([
                'message' => 'Git pull successful!',
                'output' => implode("\n", $output)
            ]);
        } else {
            // Check if the error is related to dubious ownership
            $errorMessage = implode("\n", $output);
            if (strpos($errorMessage, 'detected dubious ownership in repository') !== false) {
                // Attempt to fix the issue by marking the directory as safe
                $fixCommand = 'git config --global --add safe.directory D:/sp';
                exec($fixCommand, $fixOutput, $fixStatus);

                if ($fixStatus === 0) {
                    // Retry the git pull after fixing the ownership issue
                    exec('git pull 2>&1', $output, $status);
                    if ($status === 0) {
                        return response()->json([
                            'message' => 'Git pull successful after fixing the safe directory!',
                            'output' => implode("\n", $output)
                        ]);
                    }
                }
            }

            // If the git pull failed, return the error message
            return response()->json([
                'message' => 'Git pull failed!',
                'error' => $errorMessage
            ], 500);
        }
    } catch (\Exception $e) {
        // Catch any other exceptions that might occur
        return response()->json([
            'message' => 'An error occurred while executing git pull!',
            'error' => $e->getMessage()
        ], 500);
    }
})->name('git-pull');



Route::group([ 'as' => 'admin.'], function () {

    Route::group(['prefix'=> 'dashboard' , 'as' => 'dashboard.' ], function () {
        Route::get('/', function () {
            return view('admin.dashboard.index');
        })->name('index');
    });


    Route::group(['prefix'=> 'building' , 'as' => 'building.' ], function () {
        Route::get('/', [BuildingController::class,'index'])->name('index');
        Route::get('/create', [BuildingController::class,'create'])->name('create');
        Route::post('/store', [BuildingController::class,'store'])->name('store');
        Route::get('/show/{id}', [BuildingController::class,'show'])->name('show');
        Route::get('/update/{id}', [BuildingController::class,'update'])->name('update');
        Route::delete('/delete/{id}', [BuildingController::class,'delete'])->name('delete');
    });
    
});
