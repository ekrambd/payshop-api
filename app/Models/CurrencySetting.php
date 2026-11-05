<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_currency',
        'usd_rate',
        'usd_symbol',
        'jpn_rate',
        'jpn_symbol',
        'ksa_riyal',
        'riyal_symbol',
        'bdt_rate',
        'bdt_symbol',
        'uae_rate',
        'uae_symbol',
    ];
}
