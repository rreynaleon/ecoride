<?php

return [
    "/" => [
        "controller" => 'App\\Controller\\PageController',
        "action" => "home"
    ],
    "/home" => [
        "controller" => 'App\\Controller\\PageController',
        "action" => "home"
    ],
    "/about" => [
        "controller" => 'App\\Controller\\PageController',
        "action" => "about"
    ],
    "/contact" => [
        "controller" => 'App\\Controller\\PageController',
        "action" => "contact"
    ],
    "/register" => [
        "controller" => 'App\\Controller\\AuthController',
        "action" => "register"
    ],
    "/login" => [
        "controller" => 'App\\Controller\\AuthController',
        "action" => "login"
    ],
    "/logout" => [
        "controller" => 'App\\Controller\\AuthController',
        "action" => "logout"
    ],
    "/rides" => [
        "controller" => 'App\\Controller\\RideController',
        "action" => "list"
    ],
    "/ride/show" => [
        "controller" => 'App\\Controller\\RideController',
        "action" => "show"
    ],
    "/ride/create" => [
        "controller" => 'App\\Controller\\RideController',
        "action" => "create"
    ],
    "/ride/my" => [
        "controller" => 'App\\Controller\\RideController',
        "action" => "myRides"
    ],
    "/user/dashboard" => [
        "controller" => 'App\\Controller\\UserController',
        "action" => "dashboard"
    ],
    "/user/profile" => [
        "controller" => 'App\\Controller\\UserController',
        "action" => "profile"
    ],
    "/user/edit" => [
        "controller" => 'App\\Controller\\UserController',
        "action" => "edit"
    ],
    "/booking/my" => [
        "controller" => 'App\\Controller\\BookingController',
        "action" => "myBookings"
    ],
    "/review/my" => [
        "controller" => 'App\\Controller\\ReviewController',
        "action" => "myReviews"
    ],
    // Admin routes
    "/admin/dashboard" => [
        "controller" => 'App\\Controller\\AdminController',
        "action" => "dashboard"
    ],
    "/admin/users" => [
        "controller" => 'App\\Controller\\AdminController',
        "action" => "users"
    ],
    "/admin/rides" => [
        "controller" => 'App\\Controller\\AdminController',
        "action" => "rides"
    ],
    "/admin/bookings" => [
        "controller" => 'App\\Controller\\AdminController',
        "action" => "bookings"
    ],
    "/admin/reviews" => [
        "controller" => 'App\\Controller\\AdminController',
        "action" => "reviews"
    ],
    "/admin/roles" => [
        "controller" => 'App\\Controller\\AdminController',
        "action" => "roles"
    ],
];