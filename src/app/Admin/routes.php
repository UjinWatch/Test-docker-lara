<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('recipes', RecipeController::class);
    $router->resource('manager/users', UserController::class);
    $router->resource('test-coins', TestCoinController::class);
    $router->resource('user-cards', UserCardController::class);
});
