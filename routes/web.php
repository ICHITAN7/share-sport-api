<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/d1-test', function () {
    $result = DB::connection('d1')->select("SELECT 'Hello from D1' AS message");
    return $result;
});
Route::get('/phpinfo',function(){
    return phpinfo();
});

