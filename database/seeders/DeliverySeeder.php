<?php

namespace Database\Seeders;

use App\Models\Delivery;
use Illuminate\Database\Seeder;

class DeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'title' => '3 Business Days',
                'price' => 15,
            ],
            [
                'title' => 'Next Day',
                'price' => 25,
            ],
            [
                'title' => 'Express',
                'price' => 40,
            ],
        ];

        foreach ($types as $type){
            Delivery::create($type);
        }
    }
}
