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

        $bets = BetModel::where("user_id", Auth::id())
            ->latest()
            ->get()
            ->groupBy('join_bets') // Group by join_bets column
            ->map(function ($group) {
                return [
                    'total_amount' => $group->sum('amount'), // Sum of amount for the same join_bets
                    'bets' => $group->toArray(), // All bets in this group
                ];
            });

        // dd($bets); // Debugging the result

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

        $bets = $query->latest()->get()->groupBy('join_bets')->map(function ($group) {
            return [
                'total_amount' => $group->sum('amount'), // `join_bets` के आधार पर कुल राशि
                'bets' => $group->map(function ($bet) {
                    return [
                        'id' => $bet->id,
                        'date' => optional($bet->created_at)->format('d-m-Y'),
                        'game_name' => optional($bet->game)->name ?? 'N/A',
                        'bet_type' => $bet->bet_type,
                        'number' => $bet->number,
                        'amount' => $bet->amount,
                        'status' => $bet->status,
                    ];
                })->values(), // `groupBy` के कारण keys reset करने के लिए values() use किया
            ];
        });

        return response()->json(['bets' => $bets]);
    }

}
