<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;

class Controller extends BaseController
{
    static function checkPass($password) {
        //check password against the hash in .env and return a boolian
        return (Hash::check($password, config('app.PASS'))) ? true : false;
    }
}
