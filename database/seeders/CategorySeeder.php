<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Business Cards',
            'Marketing Materials',
            'Banners & Signs',
            'Stands & Displays',
            'Labels & Stickers',
            'Packaging & Boxes',
            'Gifts & Promos'
        ];

        foreach ($categories as $c => $category){
            Category::create(
                [
                    'name' => $category,
                    'order' => $c,
                ]
            );
        }

        $subs = [
            1 => [
                'Standard Business Cards',
                'Luxury Business Cards'
            ],
            2 => [
                'Marketing Materials',
                'Catalogs & Books',
                'Calendars',
                'Mailing & EDDM',
                'Menus'
            ],
            3 => [
                'Banners / Posters',
                'Adhesive Products',
                'Banner Stands',
                'Rigid Boards',
                'Signs',
                'COVID-19 Items',
                'Services'
            ],
            4 => [
                'Trade Show Displays',
                'Flags',
                'Standing Displays'
            ],
            5 => [
                'Roll Labels',
                'Stickers on Sheet',
                'Individual Stickers'
            ],
            6 => [
                'Folding Cartons',
                'Sleeves and Inserts'
            ],
            7 => [
                'Promo Products',
                'Wall Art',
                'Holiday Favorites'
            ],
        ];

        foreach ($subs as $c => $subcategories){
            foreach ($subcategories as $subcategory){
                Category::create(
                    [
                        'name' => $subcategory,
                        'parent' => $c,
                    ]
                );
            }
        }
    }
}
