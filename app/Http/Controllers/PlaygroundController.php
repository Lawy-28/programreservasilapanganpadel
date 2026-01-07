<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlaygroundController extends Controller
{
    /**
     * Menampilkan halaman playground untuk keperluan testing UI atau komponen.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('playground');
    }
}
