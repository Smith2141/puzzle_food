<?php

use Illuminate\Support\Facades\DB;
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
            $table->comment('Заказы');
            $table->id();
            $table->foreignId('user_id')->comment('Пользователь')->constrained('users');
            $table->boolean('is_paid')->comment('Заказ оплачен')->default(0);
            $table->boolean('is_cooked')->comment('Заказ готов')->default(0);
            $table->boolean('is_delivered')->comment('Заказ доставлен')->default(0);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
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
