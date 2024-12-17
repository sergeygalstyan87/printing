<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1;$i < 150; $i++) {
            Product::create([
                'images' => [
                    "1660482443product-1.jpg",
                    "1660482443product-2.jpg"
                ],
                'title' => 'Product ' . $i,
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem minima neque porro tempore? A, accusantium amet asperiores dignissimos fugiat id laborum nisi nulla sequi voluptatibus. Ab at, blanditiis dolorum error est eum ex exercitationem explicabo impedit, ipsa mollitia nesciunt nostrum numquam officiis omnis quisquam repudiandae saepe sapiente temporibus vel velit.',
                'category_id' => rand(1,7)
            ]);
        }
    }
}
