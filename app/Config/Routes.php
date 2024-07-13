<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');




// Register and Login
$routes->get('register', 'Auth::register');
$routes->post('auth/store', 'Auth::store');
$routes->get('login', 'Auth::login');
$routes->post('auth/authenticate', 'Auth::authenticate');
$routes->get('auth/logout', 'Auth::logout');

// // Dashboard and Profile
// $routes->get('dashboard', 'Dashboard::index');
$routes->get('profile', 'Dashboard::profile');
$routes->post('dashboard/updateProfile', 'Dashboard::updateProfile');

// $routes->get('dashboard/updateProfile', function() {
//     $message = "Hello from the test route!";
//     echo $message;
// });




// // Friends
// $routes->get('friends', 'Dashboard::friends');
// $routes->post('dashboard/addFriend/(:num)', 'Dashboard::addFriend/$1');

// $routes->get('/dashboard/sendFriendRequest/(:num)', 'Dashboard::sendFriendRequest/$1');
// $routes->get('/dashboard/acceptFriendRequest/(:num)', 'Dashboard::acceptFriendRequest/$1');



$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/dashboard/sendRequest/(:num)', 'Dashboard::sendRequest/$1');
$routes->get('/dashboard/acceptRequest/(:num)', 'Dashboard::acceptRequest/$1');
// $routes->get('/dashboard/profile', 'Dashboard::profile');
// $routes->post('/dashboard/profile', 'Dashboard::profile');




