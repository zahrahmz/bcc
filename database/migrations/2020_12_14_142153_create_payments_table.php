<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id');
            $table->string('order_reference');
            $table->uuid('res_code')->nullable();
            $table->text('res_string')->nullable();
            $table->string('sale_order_id')->nullable();
            ;
            $table->string('sale_reference_id')->nullable();
            ;
            $table->string('card_holder_pan')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('total_order_price');
            $table->text('card_holder_info')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
