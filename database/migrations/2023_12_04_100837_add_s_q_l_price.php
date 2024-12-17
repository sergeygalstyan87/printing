<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSQLPrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function($table) {
            $table->double('sqr_price',13,4)->default(null);
        });
        //ALTER TABLE `products` CHANGE `max_width` `max_width` FLOAT(2) NOT NULL DEFAULT '0';
        //ALTER TABLE `products` CHANGE `shipping_price` `shipping_price` FLOAT(2) NOT NULL DEFAULT '0';
        //ALTER TABLE `products` CHANGE `max_height` `max_height` FLOAT NOT NULL DEFAULT '0';
        //ALTER TABLE `products` CHANGE `default_width` `default_width` FLOAT(2) NOT NULL DEFAULT '0';
        //ALTER TABLE `products` CHANGE `default_height` `default_height` FLOAT(2) NOT NULL DEFAULT '0';
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
