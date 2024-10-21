<?php

namespace App\Http\Controllers\Halo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HaloController extends Controller
{
    public function index()
    {
        $nama = 'rey';
        $data = ['nama'=> $nama];
        return view('coba.hallo', $data);       
    }
}