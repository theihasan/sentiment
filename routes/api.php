<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\SentimentController;

Route::middleware('auth:sanctum')->post('/analysis', [SentimentController::class, 'analyze']);

require __DIR__.'/auth.php';
