<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BetModel;
use App\Models\GameModel;
use Illuminate\Support\Facades\Auth;
class PlaceBetController extends Controller
{
    public function place_bet_jodi(Request $request)
    {
        // Validate the request
        $request->validate([
            "jodi" => "required|array",
            "game_id" => "required|integer",
        ]);

        // Get the jodi array and remove null values
        $jodi = $request->input('jodi');
        $filteredJodi = array_filter($jodi, function ($value) {
            return !is_null($value); // Remove null values
        });

        // Calculate the total amount
        $totalAmount = array_sum($filteredJodi);

        // Get user_id and user data
        $user = Auth::user();

        // Check if user has sufficient balance
        if ($user->wallet_balance < $totalAmount) {
            return redirect()->route('play.page')->with('error', 'Insufficient wallet balance!');
        }

        // Deduct the total amount from the user's wallet balance
        $user->wallet_balance -= $totalAmount;
        $user->save();

        // Fetch the game name
        $game = GameModel::find($request->input('game_id'));
        $gameName = $game ? $game->name : "Unknown Game";

        // Save each bet in the database
        $game_id = $request->input('game_id');
        foreach ($filteredJodi as $number => $amount) {
            BetModel::create([
                'user_id' => $user->id,
                'bet_type' => "jodi",
                'game_id' => $game_id,
                'number' => $number,
                'amount' => $amount,
                'status' => "pending",
            ]);
        }

        // Redirect to the play page with a success message, including total amount and game name
        return redirect()->route('play.page')->with(
            'success-bet',
            "Your bets for '{$gameName}' have been placed successfully! Total Points: {$totalAmount}"
        );
    }

    public function place_bet_maual_jodi(Request $request)
    {
        $request->validate([
            "game_id" => "required|integer",
        ]);


        // Filter out null values from the request data
        $filteredData = array_filter($request->all(), function ($value) {
            return !is_null($value);
        });

        // Initialize an array to store the final bet amounts
        $bets = [];

        // Loop through the filtered data to process the jodi and point pairs
        foreach ($filteredData as $key => $value) {
            // Check if the key is for a jodi (e.g., manual-jodi-0-0, manual-jodi-1-1, etc.)
            if (strpos($key, 'manual-jodi-') !== false) {
                // Extract the index from the key (e.g., 0, 1, 2, etc.)
                preg_match('/manual-jodi-(\d+)-(\d+)/', $key, $matches);
                $rowIndex = $matches[1];
                $columnIndex = $matches[2];

                // Check if there is a corresponding point for this row (manual-point-0, manual-point-1, etc.)
                $pointKey = "manual-point-" . $rowIndex;
                if (isset($filteredData[$pointKey])) {
                    $pointValue = $filteredData[$pointKey];

                    // Store the bet in the bets array (number and amount)
                    if ($value) {
                        $bets[] = [
                            'number' => $value,
                            'amount' => $pointValue,
                        ];
                    }
                }
            }
        }

        // Calculate the total amount
        $totalAmount = 0;
        foreach ($bets as $bet) {
            $totalAmount += $bet['amount'];
        }

        // Get the user
        $user = Auth::user();

        // Check if the user has enough balance
        if ($user->wallet_balance < $totalAmount) {
            return redirect()->route('play.page')->with('error', 'Insufficient wallet balance!');
        }

        // Deduct the total amount from the user's balance
        $user->wallet_balance -= $totalAmount;
        $user->save();

        // Save each bet in the database
        foreach ($bets as $bet) {
            BetModel::create([
                'user_id' => $user->id,
                'bet_type' => 'jodi-manual',
                'game_id' => $request->input('game_id'),
                'number' => $bet['number'],
                'amount' => $bet['amount'],
                'status' => 'pending',
            ]);
        }

        // Redirect to the play page with a success message
        return redirect()->route('play.page')->with(
            'success-bet',
            "Your bets have been placed successfully! Total Points: {$totalAmount}"
        );
    }


    public function place_bet_harraf(Request $request)
    {
        // Filter out null values from the request data
        $filteredData = array_filter($request->all(), function ($value) {
            return !is_null($value) && $value !== ''; // Remove null or empty values
        });

        // Initialize arrays to store "Andar" and "Bahar" bets
        $andarBets = [];
        $baharBets = [];

        // Loop through the filtered data to identify "Andar" and "Bahar" bets
        foreach ($filteredData as $key => $value) {
            // Check if the key belongs to "Andar"
            if (strpos($key, 'ander-') !== false) {
                preg_match('/ander-(\d+)/', $key, $matches);
                if (!empty($matches)) {
                    $andarBets[] = [
                        'number' => $matches[1], // Extract the number from the key
                        'amount' => (int) $value, // Store the amount
                    ];
                }
            }

            // Check if the key belongs to "Bahar"
            if (strpos($key, 'bahar-') !== false) {
                preg_match('/bahar-(\d+)/', $key, $matches);
                if (!empty($matches)) {
                    $baharBets[] = [
                        'number' => $matches[1], // Extract the number from the key
                        'amount' => (int) $value, // Store the amount
                    ];
                }
            }
        }

        // Combine both bets
        $totalBets = [
            'andar' => $andarBets,
            'bahar' => $baharBets,
        ];

        // Calculate the total amount of bets
        $totalAmount = 0;
        foreach ($andarBets as $bet) {
            $totalAmount += $bet['amount'];
        }
        foreach ($baharBets as $bet) {
            $totalAmount += $bet['amount'];
        }

        // Get the user
        $user = Auth::user();

        // Check if the user has enough balance
        if ($user->wallet_balance < $totalAmount) {
            return redirect()->route('play.page')->with('error', 'Insufficient wallet balance!');
        }

        // Deduct the total amount from the user's balance
        $user->wallet_balance -= $totalAmount;
        $user->save();

        // Save each bet in the database
        foreach ($andarBets as $bet) {
            BetModel::create([
                'user_id' => $user->id,
                'bet_type' => 'andar', // Bet type
                'game_id' => $request->input('game_id'),
                'number' => $bet['number'],
                'amount' => $bet['amount'],
                'status' => 'pending',
            ]);
        }

        foreach ($baharBets as $bet) {
            BetModel::create([
                'user_id' => $user->id,
                'bet_type' => 'bahar', // Bet type
                'game_id' => $request->input('game_id'),
                'number' => $bet['number'],
                'amount' => $bet['amount'],
                'status' => 'pending',
            ]);
        }

        // Redirect to the play page with a success message
        return redirect()->route('play.page')->with(
            'success-bet',
            "Your bets have been placed successfully! Total Points: {$totalAmount}"
        );
    }
    public function place_bet_crossing(Request $request)
    {
        // Validate the request
        $request->validate([
            "crossed_numbers" => "required|string", // Expecting a comma-separated string
            "game_id" => "required|integer",
            "points" => "required|integer",
        ]);

        // Extract crossed numbers as an array
        $crossedNumbers = explode(',', $request->input('crossed_numbers'));

        // Calculate the total amount (points per number)
        $pointsPerNumber = $request->input('points');
        $totalAmount = count($crossedNumbers) * $pointsPerNumber;

        // Get user_id and user data
        $user = Auth::user();

        // Check if user has sufficient balance
        if ($user->wallet_balance < $totalAmount) {
            return redirect()->route('play.page')->with('error', 'Insufficient wallet balance!');
        }

        // Deduct the total amount from the user's wallet balance
        $user->wallet_balance -= $totalAmount;
        $user->save();

        // Fetch the game name
        $game = GameModel::find($request->input('game_id'));
        $gameName = $game ? $game->name : "Unknown Game";

        // Save each bet in the database
        $game_id = $request->input('game_id');
        foreach ($crossedNumbers as $number) {
            BetModel::create([
                'user_id' => $user->id,
                'bet_type' => "crossing",
                'game_id' => $game_id,
                'number' => $number,
                'amount' => $pointsPerNumber,
                'status' => "pending",
            ]);
        }

        // Redirect to the play page with a success message, including total amount and game name
        return redirect()->route('play.page')->with(
            'success-bet',
            "Your crossing bets for '{$gameName}' have been placed successfully! Total Points: {$totalAmount}"
        );
    }


    public function place_bet_copy_paste(Request $request)
    {
        // ✅ Validate the request
        $request->validate([
            "jodi_numbers" => "required|array",  // Jodi numbers must be an array
            "game_id" => "required|integer",
            "point" => "required|integer",
        ]);
        // dd($request->all()) ;

        // ✅ Extract jodi numbers from request (Fixing the issue)
        $jodiNumbersJson = $request->input('jodi_numbers')[0] ?? null;

        // ✅ Decode JSON String to Array
        $jodiNumbers = json_decode($jodiNumbersJson, true);

        // ✅ Ensure extracted data is an array
        if (!is_array($jodiNumbers) || empty($jodiNumbers)) {
            return redirect()->route('play.page')->with('error', 'Invalid Jodi numbers data!');
        }

        // ✅ Calculate total amount
        $pointsPerNumber = $request->input('point'); // "point" सही नाम से एक्सेस करें
        $totalAmount = count($jodiNumbers) * $pointsPerNumber;

        // ✅ Get user details
        $user = Auth::user();

        // ✅ Check if user has enough balance
        if ($user->wallet_balance < $totalAmount) {
            return redirect()->route('play.page')->with('error', 'Insufficient wallet balance!');
        }

        // ✅ Deduct points from user's wallet
        $user->wallet_balance -= $totalAmount;
        $user->save();

        // ✅ Fetch game name
        $game = GameModel::find($request->input('game_id'));
        $gameName = $game ? $game->name : "Unknown Game";

        // ✅ Save bets in the database
        $game_id = $request->input('game_id');
        foreach ($jodiNumbers as $number) {
            BetModel::create([
                'user_id' => $user->id,
                'bet_type' => "copy_paste",
                'game_id' => $game_id,
                'number' => $number,
                'amount' => $pointsPerNumber,
                'status' => "pending",
            ]);
        }

        // ✅ Redirect with success message
        return redirect()->route('play.page')->with(
            'success-bet',
            "Your Jodi bets for '{$gameName}' have been placed successfully! Total Points: {$totalAmount}"
        );
    }

    public function place_bet_num_to_num(Request $request)
    {
        // Validate the request
        $request->validate([
            "numbers" => "required|string", // Comma-separated numbers
            "game_id" => "required|integer",
            "first_crossing" => "required|string",
            "second_crossing" => "required|string",
            "points" => "required|integer",
        ]);

        // Extract numbers as an array
        $numbers = explode(',', $request->input('numbers'));
        $firstCrossing = $request->input('first_crossing');
        $secondCrossing = $request->input('second_crossing');

        // Include first and second crossing numbers if not already in array
        if (!in_array($firstCrossing, $numbers)) {
            $numbers[] = $firstCrossing;
        }
        if (!in_array($secondCrossing, $numbers)) {
            $numbers[] = $secondCrossing;
        }

        // Calculate total amount
        $pointsPerNumber = $request->input('points');
        $totalAmount = count($numbers) * $pointsPerNumber;

        // Get user
        $user = Auth::user();

        // Check wallet balance
        if ($user->wallet_balance < $totalAmount) {
            return redirect()->route('play.page')->with('error', 'Insufficient wallet balance!');
        }

        // Deduct amount from wallet
        $user->wallet_balance -= $totalAmount;
        $user->save();

        // Get game name
        $game = GameModel::find($request->input('game_id'));
        $gameName = $game ? $game->name : "Unknown Game";

        // Save each bet in the database
        $game_id = $request->input('game_id');
        foreach ($numbers as $number) {
            BetModel::create([
                'user_id' => $user->id,
                'bet_type' => "num_to_num",
                'game_id' => $game_id,
                'number' => $number,
                'amount' => $pointsPerNumber,
                'status' => "pending",
            ]);
        }

        // Redirect with success message
        return redirect()->route('play.page')->with(
            'success-bet',
            "Your 'Number to Number' bets for '{$gameName}' have been placed successfully! Total Points: {$totalAmount}"
        );
    }
    public function place_bet_tap_play(Request $request)
    {
      // Validate the request
      $request->validate([
        "jodi" => "required|array",
        "game_id" => "required|integer",
    ]);

    // Get the jodi array and remove null values
    $jodi = $request->input('jodi');
    $filteredJodi = array_filter($jodi, function ($value) {
        return !is_null($value); // Remove null values
    });

    // Calculate the total amount
    $totalAmount = array_sum($filteredJodi);

    // Get user_id and user data
    $user = Auth::user();

    // Check if user has sufficient balance
    if ($user->wallet_balance < $totalAmount) {
        return redirect()->route('play.page')->with('error', 'Insufficient wallet balance!');
    }

    // Deduct the total amount from the user's wallet balance
    $user->wallet_balance -= $totalAmount;
    $user->save();

    // Fetch the game name
    $game = GameModel::find($request->input('game_id'));
    $gameName = $game ? $game->name : "Unknown Game";

    // Save each bet in the database
    $game_id = $request->input('game_id');
    foreach ($filteredJodi as $number => $amount) {
        BetModel::create([
            'user_id' => $user->id,
            'bet_type' => "tap-play",
            'game_id' => $game_id,
            'number' => $number,
            'amount' => $amount,
            'status' => "pending",
        ]);
    }

    // Redirect to the play page with a success message, including total amount and game name
    return redirect()->route('play.page')->with(
        'success-bet',
        "Your bets for '{$gameName}' have been placed successfully! Total Points: {$totalAmount}"
    );

    }
}
