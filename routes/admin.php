<?php


use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Medicine\MedicineController;
use App\Http\Controllers\Tenant\TenantContoller;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "admin", "middleware" => [ "auth", "admin" ] ], function () {
	
	Route::get("/dashboard", [DashboardController::class, "index"])->name("admin.dashboard");
	
	// business routes
	Route::resource("tenants", TenantContoller::class);
	Route::post("tenants/update/{tenant}", [TenantContoller::class, "update"])->name("tenants.update");
	
	Route::get("medicines", [MedicineController::class, "index"])->name("admin.medicines.index");
	Route::get("medicines/create", [MedicineController::class, "create"])->name("admin.medicines.create");
	Route::post("medicines/store", [MedicineController::class, "store"])->name("admin.medicines.store");
});
