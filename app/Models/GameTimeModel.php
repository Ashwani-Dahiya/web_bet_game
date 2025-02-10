<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameTimeModel extends Model
{
    use HasFactory;
    protected $table = "game_timings";
    protected $fillable = ['game_id','open_time','close_time','days_available'];

    public function game()
    {
        return $this->belongsTo(GameModel::class, 'game_id');
    }
}
