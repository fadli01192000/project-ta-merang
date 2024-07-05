<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index() {
        $title = 'Pengaturan';

        return view('pengaturan', compact('title'));
    }
}
