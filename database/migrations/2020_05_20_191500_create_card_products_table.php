<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_products', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('cart_id');
			$table->index('cart_id');
			$table->integer('product_id');
			$table->string('product_title');
			$table->integer('product_group_id');
			$table->string('product_image_url',32)->nullable();
			$table->integer('quantity');
			
			$table->integer('include_exchange')->default(0);
			$table->integer('include_seal')->default(0);
						
			$table->decimal('product_price',8,2);
			$table->decimal('include_exchange_price',8,2)->nullable();
			$table->decimal('include_seal_price',8,2)->nullable();
			//product_price + include_exchange_price + include_seal_price = unit_price
			//unit_price*quantity = total_price
			$table->decimal('unit_price',8,2);
			$table->decimal('total_price',8,2);
			$table->string('ref_item',512)->nullable(); 
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
        Schema::dropIfExists('card_products');
    }
}
