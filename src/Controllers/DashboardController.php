<?php

namespace Administr\Controllers;

use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('administr::dashboard.index');
    }
}