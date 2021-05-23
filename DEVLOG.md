# MMS Backend Headless Dev Log

## Initial Setup
composer create-project laravel/laravel mms-backend.test

mysql
	create database mms_backend;
	exit
nano .env
	(setup mysql settings)
php artisan migrate

## Require login for all pages

### First, create admin in seeder
php artisan make:seeder UsersTableSeeder

- Add the new seeder to DatabaseSeeder.php
	- $this->call(UsersTableSeeder::class);

php artisan db:seed
- Check the table
	mysql
	use mms_backend;
	select * from users;
- You should see the new user

### Add login routes & secure routes/contorllers
- Add these to routes/web.php
	Auth::routes();
	Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

- Add a view for your login (temporary)
	- Copy the /resources/views/auth from mblaravel or other Laravel 5.5 project
	- Copy the /resources/views/layouts for now while you're at it

- Edit the Auth controllers to change the post-login url from "home"

- Disable registration
	Remove resources/views/auth/register.blade.php
	In the registration controller
		Comment out interior commands in create & verify functions
		Add the following to override default functions:
			public function showRegistrationForm()
			{
				// Disabling Registration
				return redirect('/login');
			}

			public function register()
			{
				// Disabling Registration
			}

- Require login for all pages
	php artisan make:controller DashboardController
	Add middleware calls

- Remove default welcome route & add protected home route for dashboard
	Route::get('/', '\App\Http\Controllers\DashboardController@show_dashboard');

## Setup IDE / Gulp
- Add gulpfile from mblaravel and associated directories for base SCSS workflow
    cd mms-backend.test
    npm install
    nmp install gulp
    gulp watch


## Set up model for pages & content blocks
    php artisan make:model Page -mcr
    php artisan make:model Block -mcr
    php artisan make:model Post -mcr
    php artisan make:model Image -mcr

## For SFTP Connectivity, install league/flysystem-sftp ~1.0
    Add this to composer.json
            "league/flysystem-sftp": "^1.0",
    and run
    compose update
    
    
