<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RapotController extends Controller
{
    public function index()
    {
        return view('pages.dashboard.rapot.index');
    }
}
