<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('test', [\App\Http\Controllers\Test\TestController::class,'test']);

//Route::get('get-tree', [\App\Http\Controllers\Questions\GroupController::class,'getTree']);

Route::get('groups/get-tree', [\App\Http\Controllers\Questions\GroupController::class,'getTree']);
Route::get('groups/get-questions', [\App\Http\Controllers\Questions\GroupController::class,'getGroupQuestions']);

Route::apiResources([
    'groups' => \App\Http\Controllers\Questions\GroupController::class,
    'questions' => \App\Http\Controllers\Questions\QuestionController::class,
    'chains' => \App\Http\Controllers\Questions\ChainsController::class,
    'chain-elements' => \App\Http\Controllers\Questions\ChainElementsController::class,
]);

