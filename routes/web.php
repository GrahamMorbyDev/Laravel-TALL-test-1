<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShoppingListController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/shopping', [ShoppingListController::class, 'index'])->name('shopping.index');
Route::post('/shopping', [ShoppingListController::class, 'store'])->name('shopping.store');
Route::delete('/shopping/{shopping_list_item}', [ShoppingListController::class, 'destroy'])->name('shopping.destroy');
