<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //
    protected $table ="items";
    protected $fillable= ["name", "price", "image_url", "description", "quantity"];

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
