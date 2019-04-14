<?php

Route::set('index.php', function () {
    $controller = new HomeController();
    $controller->Test();
});

Route::set('about', function () {
    $controller = new HomeController();
    $controller->Test();
});

Route::set('contact', function () {
    HomeController::view('index');
});