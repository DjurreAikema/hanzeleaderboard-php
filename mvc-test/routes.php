<?php
// TODO Figure a better way to do routes
Route::set('index.php', function () {
    $controller = new HomeController();
    $controller->Test();
});

// Auth routes
Route::set('login', function () {
    $auth = new AuthController();
    $auth->login();
});

Route::set('logout', function () {
    $auth = new AuthController();
    $auth->logout();
});

Route::set('register', function () {
    $auth = new AuthController();
    $auth->register();
});

// User routes
Route::get('profile', function () {
    UserController::View('user/profile');
    echo 'hello';
});

Route::set('update', function () {

});
