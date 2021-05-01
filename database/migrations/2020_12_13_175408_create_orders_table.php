<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->increments('id');
            $table->unsignedInteger('cart_id');
            $table->unsignedInteger('user_id');
            $table->string('name_of_receiver');
            $table->string('province');
            $table->string('city');
            $table->text('address');
            $table->string('postal_code');
            $table->string('phone');
            $table->string('shipment_type_name');
            $table->string('shipment_type_price');
            $table->string('total_order_price');
            $table->string('order_state')->default('ORDER_STATUS_IN_PROGRESS')->comment('وضعیت سفارش که توسط ادمین مشخص میشود');
            $table->string('payment_status')->default('NOT_PAID')->comment('وضعیت پرداختی کاربر در درگاه بانک');
            ;
            $table->timestamps();

            $table->foreign('cart_id')->references('id')->on('carts');
            $table->foreign('user_id')->references('id')->on('users');
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
