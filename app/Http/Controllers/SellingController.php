<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellingController extends Controller
{
    public function index()
    {
        return view('selling');
    }
}
