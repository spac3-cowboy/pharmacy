<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Manufacturer\ManufacturerController;
use App\Http\Controllers\Medicine\MedicineController;
use App\Http\Controllers\Medicine\StockController;
use App\Http\Controllers\Purchase\PurchaseController;
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


Route::get("/login", [AuthController::class, "loginPage"])->name("auth.login");
Route::get("/login", [AuthController::class, "loginPage"])->name("login");
Route::post("/login", [AuthController::class, "login"])->name("auth.login.post");
Route::post("/logout", [AuthController::class, "logout"])->name("auth.logout");

Route::get("/", [DashboardController::class, "index"])
    ->name("dashboard")
    ->middleware("auth");


Route::group(["prefix" => "dashbaord"], function (){
    Route::get("/", [DashboardController::class, "index"])->name("dashboard");

    Route::resource('customers', CustomerController::class);
    Route::resource('manufacturers', ManufacturerController::class);
    Route::resource('medicines', MedicineController::class);
    Route::resource('categories', CategoryController::class);

    // Medicine
    Route::get('/medicine-stock', [StockController::class, "index"])->name("medicine-stock.index");
    Route::get('/medicine-stock/create', [StockController::class, "create"])->name("medicine-stock.create");
    Route::post('/medicine-stock/store', [StockController::class, "store"])->name("medicine-stock.store");
    Route::get('/medicine-stock/edit', [StockController::class, "edit"])->name("medicine-stock.edit");
    Route::post('/medicine-stock/update', [StockController::class, "update"])->name("medicine-stock.update");
    Route::get('/medicine-stock/delete', [StockController::class, "delete"])->name("medicine-stock.delete");
    Route::post('/medicine-stock/destroy', [StockController::class, "destroy"])->name("medicine-stock.destroy");

    // Stock
    Route::get('stock/in-stock', [StockController::class, "inStock"])->name("stocks.instock");
    Route::get('stock/out-of-stock', [StockController::class, "outOfStock"])->name("stocks.outofstock");
    Route::get('stock/emergency-stock', [StockController::class, "emergencyStock"])->name("stocks.emergencystock");
    Route::get('stock/expired-stock', [StockController::class, "expiredStock"])->name("stocks.expiredstock");
    Route::get('stock/to-be-expired', [StockController::class, "toBeExpired"])->name("stocks.tobeexpired");

    // purchase
    Route::get('purchase', [PurchaseController::class, "index"])->name("purchases.index");
    Route::get('purchase/create', [PurchaseController::class, "create"])->name("purchases.create");
    Route::post('purchase/store', [PurchaseController::class, "store"])->name("purchases.store");

});
