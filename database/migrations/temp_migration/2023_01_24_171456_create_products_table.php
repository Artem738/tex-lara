<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    /*
return new class extends Migration

> php artisan migrate
*/

    public function up()
    {
        //https://laravel.com/docs/5.0/schema
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku');
            $table->string('title');
            $table->string('url_name');
            $table->string('good_url');
            $table->text('description')->nullable();
            $table->text('category_all')->nullable();
            $table->text('purpose')->nullable();
            $table->string('roll_width')->nullable();
            $table->string('density')->nullable();
            $table->string('made_in')->nullable();  //todo delete
            $table->unsignedBigInteger('country_id')->nullable(); // country
            $table->string('fabric_tone')->nullable();
            $table->string('pattern_type')->nullable();
            $table->string('fabric_structure')->nullable();
            $table->double('price', 15, 2)->nullable();
            $table->double('regular_price', 15, 2)->nullable();
            $table->double('sale_price', 15, 2)->nullable();
            $table->text('img_url')->nullable();
            $table->text('all_img_url')->nullable();
            $table->string('width')->nullable();
            $table->string('length')->nullable();
            $table->string('opt_discount')->nullable();
            $table->string('sale_discount')->nullable();
            $table->string('cut_discount')->nullable();
            $table->string('roll_discount')->nullable();
            $table->string('prod_status')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique('sku');

            $table->index('country_id','product_country_idx');
            $table->foreign('country_id', 'product_country_fk')->on('countries')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
