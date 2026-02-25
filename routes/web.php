<?php

use App\Http\Controllers\IdeaController;
use App\Http\Controllers\IdeaImageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\StepController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/ideas');

Route::get('/ideas', [IdeaController::class, 'index'])->middleware('auth')->name('idea.index');
Route::post('/ideas', [IdeaController::class, 'store'])->middleware('auth')->name('idea.store');
Route::get('/ideas/{idea}', [IdeaController::class, 'show'])->middleware('auth')->name('idea.show');
Route::patch('/ideas/{idea}', [IdeaController::class, 'update'])->middleware('auth')->name('idea.update');

Route::delete('/ideas/{idea}', [IdeaController::class, 'destroy'])->middleware('auth')->name('idea.destroy');
Route::delete('/ideas/{idea}/image', [IdeaImageController::class, 'destroy'])->middleware('auth')->name('idea.image.destroy');

Route::patch('/steps/{step}', [StepController::class, 'update'])->middleware('auth')->name('step.update');
// Auth
Route::get('/register', [RegisteredUserController::class, 'create'])->middleware('guest');
Route::post('/register', [RegisteredUserController::class, 'store'])->middleware('guest');

Route::get('/login', [SessionsController::class, 'create'])->middleware('guest')->name('login');
Route::post('/login', [SessionsController::class, 'store'])->middleware('guest');

Route::post('/logout', [SessionsController::class, 'destroy'])->middleware('auth');

Route::get('/profile', [ProfileController::class, 'edit'])->middleware('auth')->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->middleware('auth')->name('profile.update');
