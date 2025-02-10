<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameRateModel extends Model
{
    use HasFactory;
    protected $table = "game_rates";
    protected $fillable = ['game_id','jodi_rate','andar_rate','bahar_rate'];

    public function game()
    {
        return $this->belongsTo(GameModel::class, 'game_id');
    }
}
