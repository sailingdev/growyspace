<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('title',256);
			$table->string('title2',256)->nullable();
			$table->decimal('price',8,2);
			$table->integer('mark_id')->nullable();
			$table->integer('model_id')->nullable();
			$table->integer('motorization_id')->nullable();
			$table->integer('power_id')->nullable();
			$table->tinyInteger('number_of_places')->nullable();
			$table->integer('model_year')->nullable();
			$table->string('gearbox',8)->nullable();
			$table->integer('mileage')->nullable();
			$table->string('fuel',16)->nullable();
			$table->text('description')->nullable();
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
        Schema::dropIfExists('cars');
    }
}
