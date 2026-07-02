<?php

namespace App\Http\Controllers\Manager;

//use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('manager.dashboard');
    }
}