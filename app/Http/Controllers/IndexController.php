<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if (!$user){
            return redirect()->route('welcome');
        }
        return view('dashboard', compact('user'));
    }
}
