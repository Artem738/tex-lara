<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique();
            $table->string('name');
            $table->string('good_url')->unique();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('purpose_id')->nullable();
            $table->string('roll_width')->nullable();
            $table->string('roll_width_category')->nullable();
            $table->string('density')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('fabric_tone')->nullable();
            $table->string('pattern_type')->nullable();
            $table->string('fabric_structure')->nullable();
            $table->float('price')->nullable();
            $table->float('regular_price')->nullable();
            $table->float('sale_price')->nullable();
            $table->string('img_url')->nullable();
            $table->text('all_img_url')->nullable();
            $table->string('opt_discount')->nullable();
            $table->string('sale_discount')->nullable();
            $table->string('cut_discount')->nullable();
            $table->string('roll_discount')->nullable();
            $table->string('prod_status')->nullable();
            $table->string('similar_products')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');


           $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
