<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Modul;
use App\Models\Jurusan;

class InstrukturController extends Controller
{
    public function index()
    {
        return view('instruktur.dashboard');
    }
}
