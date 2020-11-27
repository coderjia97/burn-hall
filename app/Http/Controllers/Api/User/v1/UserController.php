<?php

namespace App\Http\Controllers\Api\User\v1;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function search($id): string
    {
        echo '<pre>';
        print_r($id);
        echo '</pre>';
        echo '<pre>';
        print_r('search base v1');
        echo '</pre>';
        return 'search base';
    }
}
