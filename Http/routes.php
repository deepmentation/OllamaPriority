<?php

/*
|--------------------------------------------------------------------------
| Module Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for the module.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['prefix' => 'ollamapriority', 'middleware' => ['web', 'auth', 'roles.manage']], function() {
    Route::get('/config', ['uses' => 'OllamaPriorityController@showConfig', 'as' => 'ollamapriority.config']);
    Route::post('/config', ['uses' => 'OllamaPriorityController@saveConfig', 'as' => 'ollamapriority.config.save']);
});

?>
