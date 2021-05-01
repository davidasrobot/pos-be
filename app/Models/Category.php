<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'enabled', 'name'
    ];

    protected $hidden = [
        'craeted_at', 'updated_at'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
