<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Manufacturer\ManufacturerController;
use App\Http\Controllers\Medicine\MedicineController;
use App\Http\Controllers\Medicine\StockController;
use App\Http\Controllers\Medicine\UnitController;
use App\Http\Controllers\POS\POSController;
use App\Http\Controllers\Purchase\PurchaseController;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\Sale\SaleController;
use App\Http\Controllers\Setting\SettingController;
use App\Http\Controllers\Tenant\TenantContoller;
use App\Http\Controllers\Vendor\VendorController;
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


Route::group(["prefix" => "dashboard", "middleware" => ["auth"]], function (){
    Route::get("/", [DashboardController::class, "index"])->name("dashboard");

    Route::resource('customers', CustomerController::class);
    Route::resource('manufacturers', ManufacturerController::class);
    Route::resource('vendors', VendorController::class);
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
    Route::get('purchase/show/{id}', [PurchaseController::class, "show"])->name("purchases.show");
    Route::get('purchase/create', [PurchaseController::class, "create"])->name("purchases.create");
    Route::get('purchase/edit', [PurchaseController::class, "edit"])->name("purchases.edit");
    Route::post('purchase/store', [PurchaseController::class, "store"])->name("purchases.store");
    Route::post('purchase/destroy', [PurchaseController::class, "destroy"])->name("purchases.destroy");
    Route::get('purchase/get-page-data', [PurchaseController::class, "getPageData"])->name("purchases.store");

    Route::resource("sales", SaleController::class);
    Route::get("sales/{sale}/invoice", [SaleController::class, "invoice"])->name("sales.invoice");

    // business routes
    Route::resource("tenants", TenantContoller::class);

    // units
    Route::resource("units", UnitController::class);

    Route::get("/settings", [SettingController::class, "index"])->name("settings.index");
    Route::post("/settings/update", [SettingController::class, "update"])->name("settings.update");

    Route::get("/reports/", [ReportController::class, "index"])->name("reports.index");
    Route::get("/reports/sales", [ReportController::class, "salesReport"])->name("reports.sales");
    Route::get("/reports/purchase", [ReportController::class, "purchaseReport"])->name("reports.purchase");
    Route::get("/reports/top-sold-medicines", [ReportController::class, "topSoldMedicines"])->name("reports.topsoldmedicines");
    Route::get("/reports/profit", [ReportController::class, "profit"])->name("reports.profit");


    // pos
    Route::get('pos', [POSController::class, "index"])->name("pos");
    Route::get('pos/get-page-data', [POSController::class, "getPageData"]);
    Route::post('pos/add-to-cart', [POSController::class, "addToCart"]);
    Route::post('pos/remove-from-cart', [POSController::class, "removeFromCart"]);
    Route::post('pos/increase-quantity', [POSController::class, "increaseQuantity"]);
    Route::post('pos/decrease-quantity', [POSController::class, "decreaseQuantity"]);
    Route::post('pos/set-discount', [POSController::class, "setDiscount"]);
    Route::post('pos/reset-cart', [POSController::class, "resetCart"]);
    Route::post('pos/select-batch', [POSController::class, "selectBatch"]);
    Route::get('pos/search', [POSController::class, "searchStocks"]);
    Route::post('pos/pay', [POSController::class, "pay"]);

});
