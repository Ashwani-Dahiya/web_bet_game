<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameModel;

class GameZoneController extends Controller
{
    public function play_zone_page($gameName){
        $active_nav='jodi';
        $game = GameModel::where('name', $gameName)->with(['rates', 'results', 'timings'])->first();
        if (!$game) {
            abort(404);
        }
        return view("games.layout.play_game_type", compact('game','active_nav'));
    }
}
