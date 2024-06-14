<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('register');
});

Route::get("/users", function (Request $request) {
    $page = $request->query('page', 1);
    $count = $request->query('count', 6);

    $request = Request::create('/api/v1/users/', 'GET', ['page' => $page, 'count' => $count]);
    $data = json_decode(Route::dispatch($request)->getContent());

    return view('users', ["data" => $data]);
});
