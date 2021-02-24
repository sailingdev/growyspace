<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('user_id');
            $table->string('transaction_id',32)->nullable();
            $table->string('status')->nullable();
			$table->integer('products_count')->nullable();
			$table->decimal('subtotal',10,2);
			$table->integer('shipping_id')->nullable();
			$table->decimal('shipping_price',5,2)->nullable();
			$table->decimal('coupon_price',5,2)->nullable();
			$table->decimal('order_total_price',8,2)->nullable();
			$table->string('email')->nullable();
			$table->tinyInteger('is_professional')->default(0);
            $table->string('company',128)->nullable();
            $table->string('intra_VAT_number',16)->nullable();
            $table->string('RCS_number',64)->nullable();
			$table->string('shipping_address_phone')->nullable();
			$table->string('shipping_address_recipient_name')->nullable();
			$table->string('shipping_address_address')->nullable();
			$table->string('shipping_address_city')->nullable();
			$table->string('shipping_address_state')->nullable();
			$table->string('shipping_address_zip')->nullable();
			$table->string('shipping_address_country_id')->nullable();
			$table->longText('api_response')->nullable();
			$table->text('info_text')->nullable();
			$table->text('cancel_order_text')->nullable();
			$table->tinyInteger('by_facture')->default(1); 
			$table->tinyInteger('facture_id')->nullable(); 
			$table->string('payment_type'); 
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
        Schema::dropIfExists('orders');
    }
}
