<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\EntryController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome_pending');
})->name('landing');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


/**
 * 
 * Pages
 * 
 */
Route::get('/page/{url}', [PageController::class, 'show'])->name('page.show');
Route::post('/page/contact-us', [PageController::class, 'contact'])->name('page.contact');
Route::post('/subscribe', [PageController::class, 'subscribe'])->name('subscribe');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::prefix('entry')->as('entry.')->group(function () {
    Route::get('/create', [EntryController::class, 'create'])->name('create');
    Route::post('/create', [EntryController::class, 'store'])->name('store');
    Route::get('/video', [EntryController::class, 'video'])->name('video');
    Route::get('/verify/{entry?}', [EntryController::class, 'verify'])->name('verify');
    Route::post('/verify/{entry?}/store', [EntryController::class, 'verifyEntry'])->name('verify.store');
    Route::get('/success/{entry?}', [EntryController::class, 'success'])->name('success');
    Route::get('/pdf/{entry?}', [EntryController::class, 'entryToPDF'])->name('pdf');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
