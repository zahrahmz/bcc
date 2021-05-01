<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class ZahraController extends BaseController
{
    public function index()
    {
        $this->setPageTitle('فروشگاه اینترنتی بی سی سی');
        return view('site.ZAHRA.success');
    }
}
