<?php
/**
 * Sunny 2020/12/23 下午2:46
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

use App\Toolkit\StrTools;
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

if (!empty($_SERVER['HTTP_ACCEPT']) && $_SERVER['HTTP_ACCEPT'] === config('app.apiAccept', '')) {
    if (strrpos($_SERVER['REQUEST_URI'], '?')) {
        $baseUrl = explode('/', substr($_SERVER['REQUEST_URI'], 5, strrpos($_SERVER['REQUEST_URI'], '?') - 5));
    } else {
        $baseUrl = explode('/', substr($_SERVER['REQUEST_URI'], 5));
    }

    $i = 0;
    foreach ($baseUrl as &$params) {
        if (preg_match('/^\d+$/', $params)) {
            $params = '{params'.++$i.'}';
        } elseif (preg_match('/(params:*+)/', $params)) {
            $params = 'params:{params'.++$i.'}';
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
    Route::group(['middleware' => 'api'], function () use ($isSearch, $baseUrl, $url) {
        $baseUrl = implode('/', $baseUrl);
        $url = StrTools::convertUnderline(implode('\\', $url));

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                if ($isSearch) {
                    Route::match(['GET'], '/'.$baseUrl, $url.'Controller@get');
                } else {
                    Route::match(['GET'], '/'.$baseUrl, $url.'Controller@search');
                }
                break;
            case 'POST':
                Route::match(['POST'], '/'.$baseUrl, $url.'Controller@create');
                break;
            case 'PUT':
                Route::match(['PUT'], '/'.$baseUrl, $url.'Controller@update');
                break;
            case 'PATCH':
                Route::match(['PATCH'], '/'.$baseUrl, $url.'Controller@modify');
                break;
            case 'DELETE':
                Route::match(['DELETE'], '/'.$baseUrl, $url.'Controller@delete');
                break;
        }
    });
}
