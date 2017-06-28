<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;


class LogsController
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('admin_login_auth');
        $this->middleware('admin_permission_auth');
    }
}
