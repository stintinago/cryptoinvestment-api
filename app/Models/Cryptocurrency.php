<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cryptocurrency extends Model
{
    protected $fillable = [
        'name',
        'symbol',
        'cmc_id'
    ];

    public function priceHistories()
    {
        return $this->hasMany(PriceHistory::class);
    }
}
