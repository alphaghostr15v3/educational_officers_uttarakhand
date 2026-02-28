<?php

namespace App\Http\Controllers\StateAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StateAdminDashboardController extends Controller
{
    public function index()
    {
        return view('state-admin.dashboard');
    }
}
