<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('provider');
			$table->string('facture_number');
			$table->date('date');
			$table->tinyInteger('TVA');
					
			$table->decimal('total_price',8,2);
			$table->decimal('total_TTC_price',8,2);
			$table->decimal('total_TVA_price',8,2);
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
        Schema::dropIfExists('factures');
    }
}
