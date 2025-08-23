<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrintJobController;

Route::get('/print-jobs', [PrintJobController::class, 'index']);
Route::post('/print-jobs/{printJob}/done', [PrintJobController::class, 'done']);
