<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PicController extends Controller
{
    public function index()
    {
        return view('pic.dashboard');
    }

    public function viewReports()
    {
        return view('pic.reports');
    }
}
