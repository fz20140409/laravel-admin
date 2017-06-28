<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/**
 * 后台抽象控制器
 * Class BaseController
 * @package App\Http\Controllers\Admin
 */
class BaseController extends Controller
{

    function __construct()
    {

        $this->middleware('admin_login_auth');
        $this->middleware('admin_permission_auth');

    }
}
