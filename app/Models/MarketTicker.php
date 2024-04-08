<?php

namespace App\Models;

// use Jenssegers\Mongodb\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketTicker extends Model
{
    use HasFactory;

    protected $table = 'market_tickers';

    public $fillable = [
        'symbol',
        'price_change',
        'price_change_percentage',
        'weighted_average_price',
        'open_time',
        'close_time',
        'number_of_trades',
        'latest_price',
        'volume',
        'dt'
    ];
}
