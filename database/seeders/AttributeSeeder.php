<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Coupon;
use App\Models\Quantity;
use App\Models\Size;
use App\Models\Type;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $quantities = [
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '8',
            '9',
            '10',
            '20',
            '50',
            '100',
            '150',
            '200',
            '250',
            '500',
            '1000',
            '2500',
            '5000',
        ];

        foreach ($quantities as $quantity) {
            Quantity::create([
                'number' => $quantity
            ]);
        }

        $categories = [
            'Paper Type',
            'Size',
            'Coating',
            'Print Sides',
            'Round Corners',
            'Raised Spot UV',
            'Foil Option',
            'Foil Color',
            'Lamination',
            'Finishing',
            'Color',
            'Material',
            'Sides',
            'Hemming',
            'Pole Pockets'
        ];

        foreach ($categories as $category) {
            Attribute::create(['name' => $category]);
        }

        $paper_types = [
            '14PT Cover (Coated 2 Sides)',
            '16PT Cover (Coated 2 Sides)',
            '14 PT Cover (Coated 1 Side)',
            '100# Classic Crest (Natural White)',
            '100# Classic Crest Linen (Solar White)',
            '100# Classic Crest Linen (Natural White)',
            '100# Classic Crest (Solar White)',
            '100# Uncoated Cover (White)',
            '20PT White Plastic',
            '20PT Clear Plastic',
            '20PT Frosted Plastic'
        ];

        foreach ($paper_types as $paper_type) {
            Type::create([
                'attribute_id' => 1,
                'name' => $paper_type
            ]);
        }

        $sizes = [
            '3.5" x 2" (Horizontal)',
            '2" x 3.5" (Vertical)',
            '2" x 2" (Square)',
            '3.35" x 2.16" (European)',
        ];

        foreach ($sizes as $size) {
            Type::create([
                'attribute_id' => 2,
                'name' => $size
            ]);
        }

        $coatings = [
            'Gloss Front, Uncoated Back',
            'UV High-Gloss Front, Uncoated Back',
        ];

        foreach ($coatings as $coating) {
            Type::create([
                'attribute_id' => 3,
                'name' => $coating
            ]);
        }

        $print_sides = [
            '2 Sided',
            '1 Sided',
        ];

        foreach ($print_sides as $print_side) {
            Type::create([
                'attribute_id' => 4,
                'name' => $print_side
            ]);
        }

        $round_corners = [
            'No',
            '1/8" Round, 4 Corners',
            '1/4" Round, 4 Corners',
            '1/8" Round, 2 Corners',
            '1/4" Round, 2 Corners',
        ];

        foreach ($round_corners as $round_corner) {
            Type::create([
                'attribute_id' => 5,
                'name' => $round_corner
            ]);
        }

        $laminations = [
            'Silk Lamination, 2 Sides',
            'No',
            'Matte',
            'Gloss',
            'Gloss Gold Glitter',
        ];

        foreach ($laminations as $lamination) {
            Type::create([
                'attribute_id' => 9,
                'name' => $lamination
            ]);
        }

        $finishings = [
            'Semi-Gloss, 2 Sides',
            'UV High-Gloss Coated, 2 Sides',
            'Soft Touch Lamination, 2 Sides',
            'Matte (Satin) Lamination, 2 Sides'
        ];

        foreach ($finishings as $finishing) {
            Type::create([
                'attribute_id' => 10,
                'name' => $finishing
            ]);
        }

        $colors = [
            '4/0(Full Color Front, No Back)',
            '4/4(Full Color Both Sides)'
        ];

        foreach ($colors as $color) {
            Type::create([
                'attribute_id' => 11,
                'name' => $color
            ]);
        }

        $materials = [
            '13oz Matte Vinyl',
            '16oz Matte Vinyl'
        ];

        foreach ($materials as $material) {
            Type::create([
                'attribute_id' => 12,
                'name' => $material
            ]);
        }

        $sides = [
            '1 Side Printing',
            '2 Side Printing'
        ];

        foreach ($sides as $side) {
            Type::create([
                'attribute_id' => 13,
                'name' => $side
            ]);
        }

        $hemmings = [
            'Hemming 4 Sides',
            'No Hemming'
        ];

        foreach ($hemmings as $hemming) {
            Type::create([
                'attribute_id' => 14,
                'name' => $hemming
            ]);
        }

        $pockets = [
            'No Pole Pockets',
            '3" Pole Pockets Top & Bottom',
            '3" Pole Pockets Left & Right',
            '3" Pole Pockets 4 Sides',
            '3" Pole Pockets Top Only',
            '3" Pole Pockets Left Only',
            '3" Pole Pockets Right Only'
        ];

        foreach ($pockets as $pocket) {
            Type::create([
                'attribute_id' => 15,
                'name' => $pocket
            ]);
        }

        $sizes = [
            [
                'ft' => "2 x 4",
                'in' => '24 x 48',
            ],
            [
                'ft' => "2 x 6",
                'in' => '24 x 72',
            ],
            [
                'ft' => "2 x 8",
                'in' => '24 x 96',
            ],
            [
                'ft' => "3 x 4",
                'in' => '36 x 48',
            ],
            [
                'ft' => "3 x 6",
                'in' => '36 x 72',
            ],
            [
                'ft' => "3 x 8",
                'in' => '36 x 96',
            ],
            [
                'ft' => "4 x 4",
                'in' => '48 x 48',
            ],
            [
                'ft' => "4 x 6",
                'in' => '48 x 72',
            ],
            [
                'ft' => "4 x 8",
                'in' => '48 x 96',
            ],
            [
                'ft' => "4 x 10",
                'in' => '48 x 120',
            ],
        ];

        foreach ($sizes as $size) {
            Size::create($size);
        }

        Coupon::create([
            'name' => 'Test',
            'percent' => 10,
            'limit' => 0,
        ]);

    }
}
