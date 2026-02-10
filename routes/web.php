<?php

use App\Http\Controllers\PenomoranSuratController;
use App\Livewire\SuperDuper\BlogList;
use App\Livewire\SuperDuper\BlogDetails;
use App\Livewire\SuperDuper\Pages\ContactUs;
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

// Route::get('/', function () {
//     return view('components.superduper.pages.home');
// })->name('home');

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('post/list', [\App\Http\Controllers\PostController::class, 'list'])->name('post.list');
Route::get('post/{slug}', [\App\Http\Controllers\PostController::class, 'show'])->name('post.show');
Route::get('/services', [\App\Http\Controllers\HomeController::class, 'services'])->name('home.services');

Route::get('/blog', BlogList::class)->name('blog');

Route::get('/blog/{slug}', BlogDetails::class)->name('blog.show');

Route::get('/contact-us', ContactUs::class)->name('contact-us');

Route::get('/privacy-policy', function () {
    return view('components.superduper.pages.coming-soon', ['page_type' => 'privacy']);
})->name('privacy-policy');

Route::get('/terms-conditions', function () {
    return view('components.superduper.pages.coming-soon', ['page_type' => 'privacy']);
})->name('terms-conditions');

Route::get('/coming-soon', function () {
    return view('components.superduper.pages.coming-soon', ['page_type' => 'generic']);
})->name('coming-soon');

Route::post('/contact', [App\Http\Controllers\ContactController::class, 'submit'])
    ->name('contact.submit');

Route::prefix('nasabah')->name('nasabah.')->group(function () {
    Route::get('/login', [\App\Http\Controllers\NasabahAuthController::class, 'showLogin'])
        ->middleware('guest:nasabah')
        ->name('login');
    Route::post('/login', [\App\Http\Controllers\NasabahAuthController::class, 'login'])
        ->middleware('guest:nasabah')
        ->name('login.submit');
    
    Route::get('/register', [\App\Http\Controllers\NasabahAuthController::class, 'showRegister'])
        ->middleware('guest:nasabah')
        ->name('register');
    Route::post('/register', [\App\Http\Controllers\NasabahAuthController::class, 'register'])
        ->middleware('guest:nasabah')
        ->name('register.submit');
    
    Route::post('/logout', [\App\Http\Controllers\NasabahAuthController::class, 'logout'])
        ->middleware('auth:nasabah')
        ->name('logout');

    Route::get('/', [\App\Http\Controllers\NasabahDashboardController::class, 'index'])
        ->middleware(['nasabah'])
        ->name('dashboard');

    // Product page for nasabah
    Route::get('/products', [\App\Http\Controllers\Nasabah\ProductController::class, 'index'])
        ->middleware(['nasabah'])
        ->name('products');

    // Profile page for nasabah
    Route::get('/profile', [\App\Http\Controllers\Nasabah\ProfileController::class, 'show'])
        ->middleware(['nasabah'])
        ->name('profile');
    Route::post('/profile', [\App\Http\Controllers\Nasabah\ProfileController::class, 'update'])
        ->middleware(['nasabah'])
        ->name('profile.update');

    // Policy routes
    Route::get('/policies', [\App\Http\Controllers\Nasabah\PolicyController::class, 'overview'])
        ->middleware(['nasabah'])
        ->name('policies');

    Route::get('/policies/active', [\App\Http\Controllers\Nasabah\PolicyController::class, 'index'])
        ->middleware(['nasabah'])
        ->name('policies.index');

    Route::get('/policies/pending', [\App\Http\Controllers\Nasabah\PolicyController::class, 'pending'])
        ->middleware(['nasabah'])
        ->name('policies.pending');

    Route::get('/policies/apply', [\App\Http\Controllers\Nasabah\PolicyController::class, 'create'])
        ->middleware(['nasabah', 'nasabah.profile'])
        ->name('policies.create');

    Route::post('/policies', [\App\Http\Controllers\Nasabah\PolicyController::class, 'store'])
        ->middleware(['nasabah', 'nasabah.profile'])
        ->name('policies.store');

    // Claim routes
    Route::get('/claims', [\App\Http\Controllers\Nasabah\ClaimController::class, 'index'])
        ->middleware(['nasabah'])
        ->name('claims');
    Route::get('/claims/create', [\App\Http\Controllers\Nasabah\ClaimController::class, 'create'])
        ->middleware(['nasabah', 'nasabah.profile'])
        ->name('claims.create');
    Route::post('/claims', [\App\Http\Controllers\Nasabah\ClaimController::class, 'store'])
        ->middleware(['nasabah', 'nasabah.profile'])
        ->name('claims.store');
});


// TODO: Create actual blog preview component
Route::post('/blog-preview', function () {
    // Implementation pending
})->name('blog.preview');
