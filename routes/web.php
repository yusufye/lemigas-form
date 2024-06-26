<?php

use App\Models\Code;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\CodeController;
use App\Http\Controllers\PublicFormController;

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
    return redirect()->route('filament.admin.auth.login');
});

Route::get('/public/{encryptedId}', [CodeController::class, 'show'])->name('public-form');
Route::post('/public/submit/{code_id}', [PublicFormController::class, 'store'])->name('submit-public-form');
Route::get('pdf/{code}', PdfController::class)->name('pdf'); 