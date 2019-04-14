<?php

Route::set('index.php', function () {
    HomeController::view('index');
});

Route::set('about', function () {
    HomeController::View('about');
    HomeController::test();
});

Route::set('contact', function () {
    echo 'contact us';
});