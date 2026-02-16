<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DetailProuctController extends Controller
{
    public function index()
    {
        return view('detail_product');
    }
}
