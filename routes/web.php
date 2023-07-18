<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Master\CategoryController;
use App\Http\Controllers\Master\DivisionController;
use App\Http\Controllers\Master\UnitController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
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

// Localization
Route::get('/js/lang.js', function () {
    $strings = Cache::rememberForever('lang.js', function () {
        $lang = config('app.locale');

        $files = glob(resource_path('lang/'.$lang.'/*.php'));
        $strings = [];

        foreach ($files as $file) {
            $name = basename($file, '.php');
            $strings[$name] = require $file;
        }

        return $strings;
    });

    header('Content-Type: text/javascript');
    echo 'window.i18n = '.json_encode($strings).';';
    exit();
})->name('assets.lang');


Route::middleware(['lang'])->group(function () {
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');

    Route::get('/register', 'Auth\RegisterController@index')->name('register');

    Route::middleware(['auth'])->group(function () {
        Route::get('/user', function() {
            $pageTitle = "Template User";
            return view('user', compact('pageTitle'));
        })->name('template.user');
        Route::get('/template/profile', function() {
            $pageTitle = "Template Profile";
            return view('profile', compact('pageTitle'));
        })->name('template.profile');

        Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
        Route::get('dashboard', 'DashboardController@index')->name('dashboard');

        Route::get('change-language/{lang}/{route}', function ($lang, $route) {
            return redirect()->route($route);
        })->name('change-language');

        // BEGIN::MASTER
        Route::prefix('master')->group(function () {
            // BEGIN:: UNIT
            Route::get('units/ajax', [UnitController::class, 'ajax'])->name('units.ajax');
            Route::resource('units', UnitController::class);
            // END:: UNIT

            // BEGIN:: CATEGORY
            Route::get('categories/ajax', [CategoryController::class, 'ajax'])->name('categories.ajax');
            Route::resource('categories', CategoryController::class);
            // END:: CATEGORY

            // BEGIN:: DIVISION
            Route::get('division/ajax', [DivisionController::class, 'ajax'])->name('division.ajax');
            Route::resource('division', DivisionController::class);
            // END:: DIVISION
        });
        // END:: MASTER

    });
});
