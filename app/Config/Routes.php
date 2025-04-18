<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->post('login', 'AuthController::login');
$routes->post('register', 'AuthController::register');


$routes->group('products', ['filter' => 'jwt'], function($routes){
    $routes->get('', 'Products::index'); 
    $routes->get('(:num)', 'Products::show/$1'); 
    $routes->post('', 'Products::create'); 
    $routes->put('(:num)', 'Products::update/$1'); 
    $routes->delete('(:num)', 'Products::delete/$1'); 
});
