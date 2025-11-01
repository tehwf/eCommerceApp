<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    protected $fillable = ['user_id','product_id','type','name','price','quantity','image_url'];
    
    public static function updateOrCreateFromSessionItem($userId, $key, $item)
    {
        [$type, $productId] = explode('_', $key);

        self::updateOrCreate(
            [
                'user_id' => $userId,
                'product_id' => $productId,
            ],
            [
                'type' => $item['type'],
                'name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'image_url' => $item['image_url'],
            ]
        );
    }

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function item() 
    {
        return $this->belongsTo(Item::class);
    }
}
