<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function address(){
        return $this->belongsTo(Address::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function stars(){
        return $this->hasMany(Star::class);
    }
}
