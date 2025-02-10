<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameModel;
class PlayController extends Controller
{
    public function play_page()
{
    // Fetch all games with their related rates, results, and timings
    $games = GameModel::with(['rates', 'results', 'timings'])->get();

    // Pass the data to the view
    return view('play', compact('games'));
}

    public function play_game($gameName)
    {
        $active_nav='jodi';
        $game = GameModel::where('name', $gameName)->with(['rates', 'results', 'timings'])->first();
        if (!$game) {
            abort(404);
        }
        return view("games.play-jodi", compact('game','active_nav'));
    }
    public function play_manual($gameName)
    {
        $active_nav= 'manual';
        $game = GameModel::where('name', $gameName)->with(['rates', 'results', 'timings'])->first();
        if (!$game) {
            abort(404);
        }
        return view("games.play-manual", compact('game','active_nav'));
    }
    public function play_harraf($gameName)
    {
        $active_nav= 'harraf';
        $game = GameModel::where('name', $gameName)->with(['rates', 'results', 'timings'])->first();
        if (!$game) {
            abort(404);
        }
        return view("games.play-harraf", compact('game','active_nav'));
    }
    public function play_crossing($gameName)
    {
        $active_nav= 'crossing';
        $game = GameModel::where('name', $gameName)->with(['rates', 'results', 'timings'])->first();
        if (!$game) {
            abort(404);
        }
        return view("games.play-crossing", compact('game','active_nav'));
    }
    public function play_copy_paste($gameName)
    {
        $active_nav= 'copy-paste';
        $game = GameModel::where('name', $gameName)->with(['rates', 'results', 'timings'])->first();
        if (!$game) {
            abort(404);
        }
        return view("games.play-copy-paste", compact('game','active_nav'));
    }
    public function play_num_to_num($gameName)
    {
        $active_nav= 'num-to-num';
        $game = GameModel::where('name', $gameName)->with(['rates', 'results', 'timings'])->first();
        if (!$game) {
            abort(404);
        }
        return view("games.play-num-to-num", compact('game','active_nav'));
    }
}
