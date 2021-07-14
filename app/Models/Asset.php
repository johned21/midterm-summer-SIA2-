<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'ml_id',
        'ml_server',
        'in_game_name',
        'rank'
    ];

    public function container() {
        return $this->belongsTo('App\Models\Asset', 'in_game_name', 'id');
    }
}
