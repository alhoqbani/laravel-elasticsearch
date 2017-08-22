<?php

Route::get('elastic', 'ElasticSearch\\ElasticController@index');

Route::resource('posts', 'Posts\PostsController');

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
