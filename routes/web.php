<?php

use App\Http\Controllers\admin\AdminOrderController;
use App\Models\Order;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\user\OrderController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\user\KatalogController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\PaymentController;

//Route Register
Route::get('/register', [AuthController::class, 'showRegistration'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

//Route Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

//Route Admin
Route::get('admin-dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

//Route Admin Produk
Route::get('admin-produk', [ProdukController::class, 'index'])->name('admin.produk');
Route::post('admin-produk', [ProdukController::class, 'store'])->name('admin.create.produk');
Route::put('/update-produk/{id}', [ProdukController::class, 'update'])->name('admin.update.produk');
Route::delete('/delete-produk/{id}', [ProdukController::class, 'destroy'])->name('admin.delete.produk');

//Route Admin Member
Route::get('admin-member', [UserController::class, 'index'])->name('admin.member');
Route::post('admin-member', [UserController::class, 'store'])->name('admin.create.member');
Route::put('/update-member/{id}', [UserController::class, 'update'])->name('admin.update.member');
Route::delete('/delete-member/{id}', [UserController::class, 'destroy'])->name('admin.delete.member');

//Route Admin Order
Route::get('admin-order', [OrderController::class, 'index2'])->name('admin.order');
Route::put('/update-order/{id}', [OrderController::class, 'store2'])->name('admin.update.order');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//Route User
Route::get('/', function () {
    $admin = User::where('role', 'admin')->get();
    return view('user/home', compact('admin',));
})->name('home');
Route::get('user-katalog', [KatalogController::class, 'index'])->name('user.katalog');
Route::get('user-order', [OrderController::class, 'index'])->name('user.order');
Route::post('user-checkout', [OrderController::class, 'checkout'])->name('user.order.checkout');
Route::get('invoice/{midtrans_order_id}', [OrderController::class, 'invoice'])->name('user.invoice');
Route::delete('/delete-order/{id}', [OrderController::class, 'destroy'])->name('user.delete.order');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::post('/checkout', [OrderController::class, 'store'])->name('checkout');

Route::get('/get-flower-variants/{id}', function ($id) {
    $variants = \App\Models\FlowerVariant::where('flower_id', $id)
        ->with('color')
        ->get()
        ->map(function ($variant) {
            return [
                'color_id' => $variant->color->id,
                'color_name' => ucfirst($variant->color->name),
            ];
        });

    return response()->json($variants);
});


