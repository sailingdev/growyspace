<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTiresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tires', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('title',256);
			$table->decimal('price',8,2);
			$table->tinyInteger('type');
			$table->integer('tire_mark_id');
			$table->integer('tire_width_id');
			$table->integer('tire_height_id');
			$table->integer('tire_diameter_id');
			$table->integer('tire_charge_id');
			$table->integer('tire_speed_id');
			$table->integer('tire_season_id');
			$table->tinyInteger('runflat')->nullable();
			$table->tinyInteger('reinforced')->nullable();
			$table->text('description');
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
        Schema::dropIfExists('tires');
    }
}
