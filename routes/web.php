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

Route::get("/","PageController@index")->name("index");
Route::get("/about-us","PageController@about")->name("about");

Route::get("/articles","PageController@article")->name("article");
Route::get("/detail/{id}","PageController@detail")->name("detail");
Route::post("/search/","PageController@search")->name("search");

Route::get("/services","PageController@service")->name("service");
Route::get("/contact-us","PageController@contact")->name("contact");

Auth::routes();


Route::prefix("portal")->middleware("auth")->group(function (){

    Route::get('/', 'HomeController@index')->name('home');
    Route::resource("/category","CategoryController");
    Route::resource("/post","PostController");

});

