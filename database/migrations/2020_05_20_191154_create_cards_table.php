<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('token',32)->unique();
			$table->decimal('subtotal',10,2);
			$table->integer('shipping_id')->nullable();
			$table->integer('products_count')->nullable();
			$table->decimal('shipping_price',5,2)->nullable();
			$table->decimal('coupon_price',5,2)->nullable();
			$table->decimal('order_total_price',8,2)->nullable();
			$table->string('colissimo_address')->nullable();
			$table->text('info_text')->nullable();
			
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
        Schema::dropIfExists('cards');
    }
}
