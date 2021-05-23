<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/', '\App\Http\Controllers\DashboardController@index');

Route::get('/images', '\App\Http\Controllers\MMSImageController@index');
Route::post('/image-upload', '\App\Http\Controllers\MMSImageController@upload');
Route::post('/image-delete/{id}', '\App\Http\Controllers\MMSImageController@destroy');
Route::get('/list-images', '\App\Http\Controllers\MMSImageController@list_images');

Route::get('/pages', '\App\Http\Controllers\PageController@index');
Route::get('/page-new', '\App\Http\Controllers\PageController@create');
Route::post('/page-create', '\App\Http\Controllers\PageController@store');
Route::get('/page-edit/{page}', '\App\Http\Controllers\PageController@edit');
Route::post('/page-update/{page}', '\App\Http\Controllers\PageController@update');
Route::post('/page-delete/{page}', '\App\Http\Controllers\PageController@destroy');

Route::get('/posts', '\App\Http\Controllers\PostController@index');
Route::get('/post-new', '\App\Http\Controllers\PostController@create');
Route::post('/post-create', '\App\Http\Controllers\PostController@store');
Route::get('/post-edit/{post}', '\App\Http\Controllers\PostController@edit');
Route::post('/post-update/{post}', '\App\Http\Controllers\PostController@update');
Route::post('/post-delete/{post}', '\App\Http\Controllers\PostController@destroy');
Route::get('/posts-import', '\App\Http\Controllers\PostController@import');

Route::get('/projects', '\App\Http\Controllers\MMSProjectController@index');
Route::get('/project-new', '\App\Http\Controllers\MMSProjectController@create');
Route::post('/project-create', '\App\Http\Controllers\MMSProjectController@store');
Route::get('/project-edit/{project}', '\App\Http\Controllers\MMSProjectController@edit');
Route::post('/project-update/{project}', '\App\Http\Controllers\MMSProjectController@update');
Route::post('/project-delete/{project}', '\App\Http\Controllers\MMSProjectController@destroy');
Route::get('/projects-import', '\App\Http\Controllers\MMSProjectController@import');



/* PUBLISHING */
Route::get('/push-pages-staging', '\App\Http\Controllers\PublishController@push_pages_staging');
Route::get('/push-pages-production', '\App\Http\Controllers\PublishController@push_pages_production');
Route::get('/push-posts-staging', '\App\Http\Controllers\PublishController@push_posts_staging');
Route::get('/push-posts-production', '\App\Http\Controllers\PublishController@push_posts_production');
Route::get('/push-projects-staging', '\App\Http\Controllers\PublishController@push_projects_staging');
Route::get('/push-projects-production', '\App\Http\Controllers\PublishController@push_projects_production');

Route::get('/publish', '\App\Http\Controllers\PublishController@index');
Route::get('/create_sitemap', 'SitemapController@create_sitemap');
