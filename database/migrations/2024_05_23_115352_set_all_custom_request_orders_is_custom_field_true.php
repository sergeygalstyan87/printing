<?php

use Illuminate\Database\Migrations\Migration;

class SetAllCustomRequestOrdersIsCustomFieldTrue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Models\Order::where('status', 'customRequest')->update(['is_custom' => 1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Models\Order::where('status', 'customRequest')->update(['is_custom' => 0]);
    }
}
