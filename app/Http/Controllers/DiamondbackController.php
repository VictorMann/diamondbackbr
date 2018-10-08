<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DiamondbackController extends Controller
{
    public function index ()
    {
        return view('diamondback');
    }
}
