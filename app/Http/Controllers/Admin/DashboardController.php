<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        $this->setPageTitle('داشبورد');
        $this->setSideBar('dashboard');
        return view('admin.dashboard.dashboard');
    }
}
