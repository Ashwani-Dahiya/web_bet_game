<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BetModel;
use Illuminate\Support\Facades\Auth;
use App\Models\GameModel;

class HistoryController extends Controller
{
    public function play_history()
    {
        $games = GameModel::all();
        $bets = BetModel::with(['game'])
            ->where("user_id", Auth::id())
            ->latest()
            ->get();
        return view("bet_history", compact("bets", "games"));
    }
    public function filter_bet_history(Request $request)
    {
        $query = BetModel::with('game')
            ->where("user_id", Auth::id());

        if ($request->date) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->game_id) {
            $query->where("game_id", $request->game_id);
        }

        $bets = $query->latest()->get()->map(function ($bet) {
            return [
                'id' => $bet->id,
                'date' => optional($bet->created_at)->format('d-m-Y'),
                'game_name' => optional($bet->game)->name ?? 'N/A',
                'bet_type' => $bet->bet_type,
                'number' => $bet->number,
                'amount' => $bet->amount,
                'status' => $bet->status,
            ];
        });

        return response()->json(['bets' => $bets]);
    }
}
