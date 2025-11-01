<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $items =[
            [
                'name' => 'Classic bag',
                'price' => 90.00,
                'image_url' => '/images/bag.jpg',
                'description' => 'Classic bag, classic but does not lose style.',
                'quantity' => 50,
                'created_at' => now(), 
                'updated_at' => now(),
            ],
              [
                'name' => 'Business book',
                'price' => 20.00,
                'image_url' => '/images/book.jpg',
                'description' => 'Book that teaches how to start business.',
                'quantity' => 50,
                'created_at' => now(), 
                'updated_at' => now(),
            ],
              [
                'name' => 'Black hoodie',
                'price' => 50.00,
                'image_url' => '/images/hoodie.jpg',
                'description' => 'Stylish hoodie for run or hangout.',
                'quantity' => 50,
                'created_at' => now(), 
                'updated_at' => now(),
            ],
              [
                'name' => 'Chelsea jersey',
                'price' => 99.00,
                'image_url' => '/images/jersey.jpg',
                'description' => 'Chelsea home jersey, choice of champions.',
                'quantity' => 50,
                'created_at' => now(), 
                'updated_at' => now(),
            ],
              [
                'name' => 'Laptop',
                'price' => 2000.00,
                'image_url' => '/images/laptop.jpg',
                'description' => 'Branded laptop for work or studies.',
                'quantity' => 50,
                'created_at' => now(), 
                'updated_at' => now(),
            ],
              [
                'name' => 'Phone',
                'price' => 2500.00,
                'image_url' => '/images/phone.jpg',
                'description' => 'Phone for everyone to connect with each other.',
                'quantity' => 50,
                'created_at' => now(), 
                'updated_at' => now(),
            ],
              [
                'name' => 'Sneaker',
                'price' => 390.00,
                'image_url' => '/images/sneaker.jpg',
                'description' => 'Stylish sneaker that catches attention from everyone.',
                'quantity' => 50,
                'created_at' => now(), 
                'updated_at' => now(),
            ],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}
