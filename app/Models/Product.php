<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'barcode', 'price', 'stock', 'provider_id'
    ];

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
    
    public function inputs()
    {
        return $this->hasMany(Input::class);
    }

    public function outputs()
    {
        return $this->hasMany(Output::class);
    }
}
