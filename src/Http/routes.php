<?php

use Jarl\ActivityLog\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('auth/activity-logs', Controllers\LogController::class.'@index')->name('jarl.activity-log.index');
Route::delete('auth/activity-logs/{id}', Controllers\LogController::class.'@destroy')->name('jarl.activity-log.destroy');
