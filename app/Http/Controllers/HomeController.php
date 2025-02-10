<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameModel;

class HomeController extends Controller
{
    public function home()
    {
        // Fetch all games with their related rates, results, and timings
    $games = GameModel::with(['rates', 'results', 'timings'])->get();

        return view('index',compact('games'));
    }
}
