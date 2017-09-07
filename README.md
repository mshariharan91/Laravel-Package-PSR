Small custom E-commerce application



-- Assignment modules are created in the packages folder with namespace 'Harii'

-- install Lumen with JWT

-- copy .env.example .env 

-- Database setup required in .env file

-- Run `compser install`

-- Run `php artisan vendor:publish` to publish the reqired migrations file from package

-- Run `php artisan migrate` to create the database tables structure

-- Register package service provider

$app->register(Harii\Auth\AuthServiceProvider::class);
$app->register(Harii\User\UserServiceProvider::class);
$app->register(Harii\Admin\AdminServiceProvider::class);

-- Tymon/jwt-auth package used to authenticate users by token based

-- Postman API Reference  https://documenter.getpostman.com/view/1984603/ecommerce-assignment/6tZ4k3U 