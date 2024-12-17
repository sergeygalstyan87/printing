<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_title');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->text('type');
            $table->integer('qty')->default(1);
            $table->unsignedBigInteger('quantity_id')->nullable()->constrained('quantities')->onDelete('set null');
            $table->double('amount', 8, 2);
            $table->double('original_amount', 8, 2)->default(0.00);
            $table->json('attrs');
            $table->unsignedBigInteger('delivery_id')->constrained('deliveries')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project');
    }
}
