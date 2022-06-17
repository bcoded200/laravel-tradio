<?php

use Chris\Calculator\Controllers\CalcController;
use Illuminate\Support\Facades\Route;

Route::group(['namespace'=> 'Chris\Calculator'], function() {

Route::get('/calculate',[CalcController::class,'index'])->name('calculate');


});
