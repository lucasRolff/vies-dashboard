<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Validation;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Validation::orderBy('id', 'desc')
        ->get();

        return view('dashboard')->with(['data' => $data]);
    }
}
