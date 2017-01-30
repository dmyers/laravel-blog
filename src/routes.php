<?php

Route::any('blogadmin/posts/qq', 'AdminpostsController@qq');
Route::get('blogadmin/posts/namecheck/{name}', 'AdminpostsController@namecheck');
Route::resource('blogadmin/posts', 'AdminpostsController');
