<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Models\Category;

use Illuminate\Support\Facades\View;


View::composer('components.navbar', function ($view) {
    $view->with('categories', Category::all());
});


Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// HOME
Route::get('/', [HomeController::class, 'index'])->name('home');

// EVENTOS----------------------------------------------------


// ADMIN
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/eventos', [EventController::class, 'index'])->name('events.index');
    Route::get('/admin/eventos/crear', [EventController::class, 'create'])->name('events.create');
    Route::post('/admin/eventos', [EventController::class, 'store'])->name('events.store');
    Route::get('/admin/eventos/{event}/editar', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/admin/eventos/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/admin/eventos/{event}', [EventController::class, 'destroy'])->name('events.destroy');
});

//Usuario
Route::get('/eventos', [EventController::class, 'public'])->name('events.public');
Route::get('/eventos/{event}', [EventController::class, 'show'])->name('events.show');


//CATEGORIAS------------------------------------------------

use App\Http\Controllers\CategoryController;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/categorias', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/admin/categorias/crear', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/admin/categorias', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/admin/categorias/{categoria}/editar', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/admin/categorias/{categoria}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/admin/categorias/{categoria}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

//USERS administrador----------------------------------------------

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/usuarios', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/usuarios/{user}/update-role', [AdminUserController::class, 'updateRole'])->name('admin.users.update-role');
    Route::delete('/admin/usuarios/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
});



#EVENTO VISTA------------------------
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{eventId}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{eventId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::get('/eventos/{event}', [EventController::class, 'show'])->name('events.show');

});

// TICKETS--------------------
Route::resource('tickets', TicketController::class);
Route::middleware(['auth'])->group(function () {
    Route::get('/mis-boletos', [TicketController::class, 'index'])->name('tickets.index');
});

//PERFIL-----------

Route::middleware(['auth'])->group(function () {
    Route::get('/perfil', [UserController::class, 'index'])->name('profile');
    Route::post('/perfil/update', [UserController::class, 'update'])->name('profile.update');
});


Route::post('/logout', function () {
    Auth::logout();
    return redirect('/')->with('success', 'Sesión cerrada correctamente.');
})->name('logout');


//UBICACIONES---------------------------------
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('/places', PlaceController::class)->except(['show']);
});



#PAGOS--------------------------
Route::middleware(['auth'])->group(function () {
    Route::post('/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::get('/checkout/success', [PaymentController::class, 'success'])->name('payment.success');
});
