<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTireMarkWidthHeightDiameterChargeSpeedesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tire_mark_width_height_diameter_charge_speedes', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('name');
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
        Schema::dropIfExists('tire_mark_width_height_diameter_charge_speedes');
    }
}
