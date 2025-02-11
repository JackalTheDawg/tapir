<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AcceptanceOfApplication;
use App\Http\Controllers\FilterVehicle;

Route::post('/new-bid', [AcceptanceOfApplication::class, 'acceptance']);

Route::get('/stock', [FilterVehicle::class, 'filter']);

Route::get('/import', function() {
    $artisan = Artisan::call("app:export-data");
    if($artisan != 0){
        return response(["message" => "something goes wrong, try again later"], 500);
    } else {
        return response(["message" => "import complite"]);
    }
});