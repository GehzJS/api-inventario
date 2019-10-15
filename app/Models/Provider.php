<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $fillable = [
        'name', 'email', 'phone'
    ];

    public function inputs()
    {
        return $this->hasMany(Input::class);
    }
}
