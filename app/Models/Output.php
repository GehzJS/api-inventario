<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Output extends Model
{
    protected $fillable = [
        'state', 'operator', 'quantity', 'product_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
