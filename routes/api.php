<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function () {
   Route::get('/user', function (Request $request) {
       return $request->user();
   });

});

Route::resource('categories', 'Category\CategoryController')->except(['create', 'edit']);
Route::resource('categories.articles', 'Category\CategoryArticleController')->except(['create', 'edit', 'show']);

Route::resource('articles', 'Article\ArticleController')->only(['index', 'show']);

Route::get('reports/generate-pdf', 'Article\GeneratePDF@pdf')->name('articles.generatePDF');



