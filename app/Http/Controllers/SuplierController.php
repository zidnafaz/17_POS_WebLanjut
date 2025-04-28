<?php

namespace App\Http\Controllers;

use App\Models\SuplierModel;
use Illuminate\Http\Request;

class SuplierController extends Controller
{
    public function index()
    {
        $supliers = SuplierModel::all(); // Ambil semua data suplier
        return view('suplier.index', compact('supliers'));
    }
}
