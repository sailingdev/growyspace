<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductGroupImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_group_images', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('group_id');
			$table->tinyInteger('rank')->default(0);
			$table->index('group_id');
			$table->string('image_url');
			$table->integer('is_main')->default(0);
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
        Schema::dropIfExists('product_group_images');
    }
}
