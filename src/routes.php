<?php

Route::any('blogadmin/posts/qq', 'AdminpostsController@qq');
Route::get('blogadmin/posts/namecheck/{name}', 'AdminpostsController@namecheck');
Route::resource('blogadmin/posts', 'AdminpostsController');
Route::get('blog/feed', 'BlogController@getFeed');
Route::get('blog/search', 'BlogController@getSearch');
Route::get('blog/category/{name}', 'BlogController@getCategory');
Route::get('blog/{year}/{month}', 'BlogController@getArchive');
Route::get('blog/{name}', 'BlogController@getShow');
Route::get('blog', 'BlogController@getIndex');
