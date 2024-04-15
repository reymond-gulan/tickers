<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomToken extends Model
{
    use HasFactory;

    protected $table = 'custom_tokens';

    public $timestamps = false;

    public $fillable = [
        'symbol',
        'user_id'
    ];
}
