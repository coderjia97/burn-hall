<?php

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
// GET getFunction /api/user/user/{id}
// GET searchFunction /api/user/user
// POST createFunction /api/user/user
// PUT updateFunction /api/user/user
// PATCH modifyFunction /api/user/user
// DELETE deleteFunction /api/user/user/1
// DELETE deleteFunction /api/user/user?id=1

if ($_SERVER['HTTP_ACCEPT'] === 'application/whell.api+json') {
    if (strrpos($_SERVER['REQUEST_URI'], '?')) {
        $baseUrl = explode('/', substr($_SERVER['REQUEST_URI'], 5, strrpos($_SERVER['REQUEST_URI'], '?') - 5));
    } else {
        $baseUrl = explode('/', substr($_SERVER['REQUEST_URI'], 5));
    }

    $i = 0;
    foreach ($baseUrl as &$params) {
        if (preg_match('/^\d+$/', $params) || preg_match('/(params:*+)/', $params)) {
            $params = '{params' . ++$i . '}';
        }
    }
    unset($params);

    $isSearch = preg_match('/\{params\d+\}/', $baseUrl[count($baseUrl) - 1]);

    $url = array_filter($baseUrl, static function ($url) {
        return !preg_match('/\{params\d+\}/', $url);
    });
    array_walk($url, static function (&$url) {
        $url = ucfirst($url);
    });

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if ($isSearch) {
                Route::match(['GET'], '/' . implode('/', $baseUrl), implode('\\', $url) . 'Controller@get');
            } else {
                Route::match(['GET'], '/' . implode('/', $baseUrl), implode('\\', $url) . 'Controller@search');
            }
            break;
        case 'POST':
            Route::match(['POST'], '/' . implode('/', $baseUrl), implode('\\', $url) . 'Controller@create');
            break;
        case 'PUT':
            Route::match(['PUT'], '/' . implode('/', $baseUrl), implode('\\', $url) . 'Controller@update');
            break;
        case 'PATCH':
            Route::match(['PATCH'], '/' . implode('/', $baseUrl), implode('\\', $url) . 'Controller@modify');
            break;
        case 'DELETE':
            Route::match(['DELETE'], '/' . implode('/', $baseUrl), implode('\\', $url) . 'Controller@delete');
            break;
    }
}
