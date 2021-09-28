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

/*Auth::routes();
Route::get('/', 'HomeController@index')->name('dashboard');
Auth::routes();*/

Route::get('/', 'HomeController@index')->name('dashboard');


Auth::routes();
Route::get('/board/{id}', 'GeneralController@main');
Route::get('/home', 'GeneralController@home');

Route::get('/profile', 'UserController@profile');
Route::post('/users', 'UserController@updateAvatar');

Route::group(['prefix' => 'boards'], function () {
    Route::get('/', 'BoardController@index');
    Route::post('/', 'BoardController@saveBoard');

    Route::get('/{id}', 'BoardController@findOne');
    Route::put('/{id}', 'BoardController@updateBoard');
    Route::delete('/{id}', 'BoardController@deleteBoard');

    Route::group(['prefix' => '/{boardId}/lists'], function () {
        Route::get('/', 'ListsController@index');
        Route::post('/', 'ListsController@saveList');

        Route::get('/{listId}', 'ListsController@findOne');
        Route::put('/{listId}', 'ListsController@updateList');
        Route::delete('/{listId}', 'ListsController@deleteList');

        Route::group(['prefix' => '/{listId}/cards'], function () {
            Route::get('/', 'TaskController@index');
            Route::post('/', 'TaskController@saveCard');

            Route::get('/{taskId}', 'TaskController@findOne');
            Route::put('/{taskId}', 'TaskController@updateCard');
            Route::delete('/{taskId}', 'TaskController@deleteCard');

            Route::group(['prefix' => '/{taskId}/attachments'], function () {
                Route::get('/', 'AttachmentController@index');
                Route::post('/', 'AttachmentController@saveAttachment');

                Route::get('/{attachmentId}', 'AttachmentController@findOne');
                Route::put('/{attachmentId}', 'AttachmentController@updateAttachment');
                Route::delete('/{attachmentId}', 'AttachmentController@deleteAttachment');
            });

            Route::group(['prefix' => '/{taskId}/checklists'], function () {
                Route::get('/', 'CheckListController@index');
                Route::post('/', 'CheckListController@saveCheckList');

                Route::get('/{checklistId}', 'CheckListController@findOne');
                Route::put('/{checklistId}', 'CheckListController@updateCheckList');
                Route::delete('/{checklistId}', 'CheckListController@deleteCheckList');
            });

            Route::group(['prefix' => '/{taskId}/comments'], function () {
                Route::get('/', 'CommentController@index');
                Route::post('/', 'CommentController@saveComment');

                Route::get('/{commentId}', 'CommentController@findOne');
                Route::put('/{commentId}', 'CommentController@updateComment');
                Route::delete('/{commentId}', 'CommentController@deleteComment');
            });

        });

    });

});

Auth::routes();