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
        Schema::create('pattern_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pattern_id')->unsigned();
            $table->unsignedBigInteger('product_id')->unsigned();
            $table->timestamps();

            $table->foreign('pattern_id')->references('id')->on('patterns')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pattern_product');
    }
};
