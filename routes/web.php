<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShoppingListController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/shopping-list', [ShoppingListController::class, 'index'])->name('shopping-list.index');
Route::post('/shopping-list', [ShoppingListController::class, 'store'])->name('shopping-list.store');
Route::patch('/shopping-list/{item}', [ShoppingListController::class, 'update'])->name('shopping-list.update');
Route::delete('/shopping-list/{item}', [ShoppingListController::class, 'destroy'])->name('shopping-list.destroy');
