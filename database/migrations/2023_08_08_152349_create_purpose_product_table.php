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
        Schema::create('purpose_product', function (Blueprint $table) {
            $table->unsignedBigInteger('purpose_id');
            $table->unsignedBigInteger('product_id');

           //$table->primary(['purpose_id', 'product_id']);

            $table->foreign('purpose_id')->references('id')->on('purposes')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purpose_product');
    }
};
