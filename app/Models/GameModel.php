<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameModel extends Model
{
    use HasFactory;
    protected $table = "games";
    protected $fillable = ['name', 'close_time', 'result_time', 'status'];


    // Relationship with GameRateModel
    public function rates()
    {
        return $this->hasOne(GameRateModel::class, 'game_id');
    }

    // Relationship with GameResultModel
    public function timings()
    {
        return $this->hasOne(GameTimeModel::class, 'game_id');
    }

    public function results()
    {
        return $this->hasMany(GameResultModel::class, 'game_id');
    }
    public function bets()
    {
        return $this->hasMany(BetModel::class);
    }
}
