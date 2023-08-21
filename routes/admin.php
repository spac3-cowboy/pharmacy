<?php


use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Medicine\MedicineController;
use App\Http\Controllers\Admin\Notice\NoticeController;
use App\Http\Controllers\Admin\Setting\SettingController;
use App\Http\Controllers\Tenant\TenantContoller;
use Illuminate\Support\Facades\Route;

Route::group([
		"prefix" => "admin",
		"middleware" => [ "auth", "admin" ],
		"as" => "admin."
	], function () {

		Route::get("/dashboard", [DashboardController::class, "index"])->name("dashboard");

		// business routes
		Route::resource("tenants", TenantContoller::class);
		Route::post("tenants/update/{tenant}", [TenantContoller::class, "update"])->name("tenants.update");

		Route::get("medicines", [MedicineController::class, "index"])->name("medicines.index");
		Route::get("medicines/create", [MedicineController::class, "create"])->name("medicines.create");
		Route::post("medicines/store", [MedicineController::class, "store"])->name("medicines.store");


		// Settings Routes
		Route::get("notices", [NoticeController::class, "index"])->name("notices.index");
		Route::get("notices/create", [NoticeController::class, "create"])->name("notices.create");

		// Settings Routes
		Route::get("settings", 	[SettingController::class, "index"])->name("settings.index");

});
