<?php

namespace App\Http\Controllers;

use App\Models\Event;

class HomeController extends Controller
{
    public function index()
    {
        $randomEvents = Event::inRandomOrder()->take(7)->get();
        return view('home', compact('randomEvents'));
    }

    }

