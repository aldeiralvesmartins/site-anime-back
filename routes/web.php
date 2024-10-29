<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('local/temp/{dojo}/{path}', fn(string $dojo, string $path) => Storage::disk('local')
    ->download("reports/$dojo/$path"))
    ->name('local.temp')
    ->middleware('signed');
