<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuruDashboardController extends Controller
{
    public function index()
    {
        return view('guru.dashboard');
    }
}