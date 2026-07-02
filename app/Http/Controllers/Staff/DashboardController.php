<?php

namespace App\Http\Controllers\Staff;

//use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller;


class DashboardController extends Controller
{
    public function index()
    {
        return view('staff.dashboard');
    }
}