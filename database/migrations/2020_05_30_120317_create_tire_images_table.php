<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTireImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tire_images', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('tire_id');
			$table->string('image_url',64);
			$table->integer('is_main')->default(0);
			$table->tinyInteger('rank')->default(0);
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
        Schema::dropIfExists('tire_images');
    }
}
