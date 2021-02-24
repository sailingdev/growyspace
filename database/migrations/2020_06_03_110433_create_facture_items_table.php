<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFactureItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facture_items', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('facture_id');
			$table->index('facture_id');
			$table->integer('category_id');
			$table->index('category_id');
			$table->string('reference');
			$table->integer('quantity');
			$table->decimal('unit_price',8,2);
			$table->decimal('total_price',8,2);
			$table->decimal('total_TTC_price',8,2);
			$table->tinyInteger('extra_charges')->default(0);
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
        Schema::dropIfExists('facture_items');
    }
}
