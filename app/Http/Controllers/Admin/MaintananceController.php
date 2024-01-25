<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
class MaintananceController extends Controller
{
    public function backup () {
        return view('admin.maintanance.error');
    }
    
    public function error () {

        $logFilePath = storage_path('logs/laravel.log');

        $lines = file($logFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        // Get the last 500 lines
        $last500Lines = array_slice($lines, -500);

        // Remove HTML tags from each line
        $errors = array_map('strip_tags', $last500Lines);
    
        
        return view('admin.maintanance.error', array('errors'=>$errors));
    }
}
