<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class GeneralController extends Controller
{
    public function gitPull()
    {
        try {
            // Execute the git pull command and capture both output and status
            $output = [];
            $status = null;
            exec('git pull 2>&1', $output, $status);

            // If the command was successful, return the output
            if ($status === 0) {

                // Artisan::call('migrate:fresh --seed');
                Artisan::call('migrate:fresh');

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

                Artisan::call('migrate:fresh --seed');

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
    }
}
