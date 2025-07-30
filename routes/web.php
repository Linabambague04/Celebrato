<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrmController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('ormconsultas',[OrmController::class,'queries']);
