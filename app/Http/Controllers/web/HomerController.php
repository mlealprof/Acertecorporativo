<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomerController extends Controller
{
    public function home(){
        return view ('web.home');
    }
}
