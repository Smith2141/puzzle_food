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
            $table->id();
            $table->foreignId('user_id')->comment('Пользователь')->constrained();
            // $table->jsonb('order_composition')->comment('Состав заказа');
            $table->boolean('is_paid')->comment('Заказ оплачен')->default(0);
            $table->boolean('is_cooked')->comment('Заказ готов')->default(0);
            $table->boolean('is_delivered')->comment('Заказ доставлен')->default(0);
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
