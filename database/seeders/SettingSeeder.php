<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            'shipping_price' => '12.14',
            'facebook' => '#',
            'twitter' => '#',
            'instagram' => '#',
            'etsy' => '#',
            'youtube' => '#',
            'free_shipping' => 'Free Shipping',
            'shipping_text' => 'This Week Order Over - $75',
            'address' => '14701 Arminta St Ste A Panorama City CA 91402',
            'phone' => '+1 (323) 886-6860',
            'call' => '+13238866860',
            'email' => 'support@yansprint.com',
            'call_text' => 'Call Us 9am-6pm',
            'mail_text' => 'Email Us 24/7',
            'working_text_1' => 'Monday - Friday',
            'working_hours_1' => '9am - 6pm',
            'working_text_2' => 'Saturday (pickup)',
            'working_hours_2' => '10am - 2pm',
            'map_link' => 'https://goo.gl/maps/pGft3rMy5m7SFQRS7',
            'map_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3299.370806978807!2d-118.45333039999998!3d34.213549199999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c2976c67c9d12d%3A0x1a077e43c00e9e3c!2sYans%20Print!5e0!3m2!1sen!2s!4v1666631351309!5m2!1sen!2s',
            'alert' => 'In observance of Thanksgiving, Yans Print will be closed on Thursday and Friday, November 24th and November 25th.  ',
        ];

        foreach ($settings as $key => $value){
            Setting::create([
                'key' => $key,
                'value' => $value,
            ]);
        }
    }
}
