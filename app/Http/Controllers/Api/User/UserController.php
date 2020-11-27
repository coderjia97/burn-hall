<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function get($id): string
    {
        return 'get';
    }

    public function search(): string
    {
        return 'search';
    }

    public function create()
    {
        return 'create';
    }

    public function update()
    {
        return 'update';
    }

    public function modify()
    {
        return 'modify';
    }

    public function delete()
    {
        return 'delete';
    }
}
