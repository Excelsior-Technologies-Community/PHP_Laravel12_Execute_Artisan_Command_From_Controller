<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan; // Importing the Artisan facade
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Run the Artisan command from the controller.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Running the Artisan migrate command
        Artisan::call('migrate'); // Executes the 'php artisan migrate' command

        // Returning a response after command execution
        return response()->json([
            "message" => "Artisan migrate command executed successfully!", // Success message
            "output"  => Artisan::output() // The output of the Artisan command (e.g., migration success message)
        ]);
    }
}
