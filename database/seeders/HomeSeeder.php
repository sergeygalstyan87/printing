<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Service;
use App\Models\Slider;
use Illuminate\Database\Seeder;

class HomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sliders = [
            [
                'image' => '1660481943slider-1.jpg',
                'title' => 'Sale offer',
                'big_title' => 'New Fashion Summer Sale',
                'description' => '<p>starting at $ <b>29</b>.99</p>',
                'button_text' => 'Shop Now ',
                'button_url' => '#',
                'title_color' => '#ff909d',
                'big_title_color' => '#222',
                'description_color' => '#777',
                'button_color' => '#ff909d',
                'button_text_color' => '#ffffff',
            ],
            [
                'image' => '1660481949slider-2.jpg',
                'title' => 'Trending item',
                'big_title' => "Women's latest fashion sale",
                'description' => '<p>starting at $ <b>29</b>.99</p>',
                'button_text' => 'Shop Now ',
                'button_url' => '#',
                'title_color' => '#ff909d',
                'big_title_color' => '#222',
                'description_color' => '#777',
                'button_color' => '#ff909d',
                'button_text_color' => '#ffffff',
            ],
            [
                'image' => '1660481954slider-3.jpg',
                'title' => 'Trending accessories',
                'big_title' => 'Modern Sunglasses',
                'description' => '<p>starting at $ <b>29</b>.99</p>',
                'button_text' => 'Shop Now ',
                'button_url' => '#',
                'title_color' => '#ff909d',
                'big_title_color' => '#222',
                'description_color' => '#777',
                'button_color' => '#ff909d',
                'button_text_color' => '#ffffff',
            ],
        ];

        foreach ($sliders as $slider){
            Slider::create($slider);
        }

        $services = [
            [
                'image' => '1666638847service_4_1.svg',
                'title' => 'Worldwide Delivery',
                'description' => 'For Order Over $100',
            ],
            [
                'image' => '1666638821service_4_3.svg',
                'title' => 'Next Day delivery',
                'description' => 'UK Orders Only',
            ],
            [
                'image' => '1666638792service_4_4.svg',
                'title' => 'Best Online Support',
                'description' => 'Hours: 8AM -11PM',
            ],
            [
                'image' => '1666638584service_4_2.svg',
                'title' => 'Return Policy',
                'description' => 'Easy & Free Return',
            ],
        ];

        foreach ($services as $service){
            Service::create($service);
        }

        Banner::create(
            [
                'image' => '1660480660banner.jpg',
                'title' => '25% discount',
                'title_color' => '#fff',
                'big_title' => 'Vegetables & Fruits',
                'big_title_color' => '#444',
                'description' => 'Starting @ $10',
                'description_color' => '#777',
                'button_text' => 'Shop Now ',
                'button_text_color' => '#777',
                'button_url' => '#',
            ]
        );
    }
}
