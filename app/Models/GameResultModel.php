<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameResultModel extends Model
{
    use HasFactory;
    protected $table = 'game_results';
    protected $fillable = ['game_id', 'result_date', 'jodi_number', 'andar_number','bahar_number'];

    public function game()
    {
        return $this->belongsTo(GameModel::class, 'game_id');
    }
}
