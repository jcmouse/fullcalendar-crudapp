<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FullCalendarController;

Route::get('/', function () {
    return view('welcome');
});


Route::controller(FullCalendarController::class)->group(function(){
    Route::get('fullcalendar', 'index');    
    Route::get('events', 'events')->name('fullcalendar.events');
    Route::post('events/add', 'add')->name('fullcalendar.events.add');
    Route::put('events/update', 'update')->name('fullcalendar.events.update');
    Route::delete('events/destroy', 'destroy')->name('fullcalendar.events.destroy');    
});