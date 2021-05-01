<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'phone_number', 'point'
    ];

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
