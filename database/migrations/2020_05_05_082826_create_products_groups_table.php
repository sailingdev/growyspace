<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('name',32)->nullable();
			$table->decimal('price',8,2)->default(0.00);
			$table->decimal('price2',8,2)->default(0.00);
			$table->string('image_url')->nullable();
			$table->integer('rank')->default(0);
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
        Schema::dropIfExists('products_groups');
    }
}
