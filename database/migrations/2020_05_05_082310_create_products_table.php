<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('title',128)->nullable();
			$table->string('title2',512)->nullable();
			$table->string('san_data_id',16)->nullable();
			$table->integer('group_id')->nullable();
			$table->string('category_id')->nullable();
			$table->string('mark_id')->nullable();
			$table->string('model_id')->nullable();
			$table->string('motorization_id')->nullable();
			$table->string('power_id')->nullable();
			$table->longText('description')->nullable();
			$table->index('group_id');
			$table->index('category_id');
			$table->index('mark_id');
			$table->index('model_id');
			$table->index('motorization_id');
			$table->index('power_id');
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
        Schema::dropIfExists('products');
    }
}
