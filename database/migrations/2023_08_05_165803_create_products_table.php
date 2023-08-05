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
            $table->string('r')->nullable();
            $table->string('sku')->nullable();
            $table->string('title')->nullable();
            $table->string('goodUrl')->nullable();
            $table->text('description')->nullable();
            $table->string('categoryAll')->nullable();
            $table->string('purpose')->nullable();
            $table->string('rollWidth')->nullable();
            $table->string('density')->nullable();
            $table->string('madeIn')->nullable();
            $table->string('fabricTone')->nullable();
            $table->string('patternType')->nullable();
            $table->string('fabricStructure')->nullable();
            $table->float('price')->nullable();
            $table->float('regularPrice')->nullable();
            $table->float('salePrice')->nullable();
            $table->string('imgUrl')->nullable();
            $table->string('allImgUrl')->nullable();
            $table->string('optDiscount')->nullable();
            $table->string('saleDiscount')->nullable();
            $table->string('cutDiscount')->nullable();
            $table->string('rollDiscount')->nullable();
            $table->string('prodStatus')->nullable();
            $table->softDeletes();
            $table->timestamps();
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
