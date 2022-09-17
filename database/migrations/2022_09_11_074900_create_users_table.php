<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->comment('Пользователи');
            $table->id();
            $table->string('name')->comment('Имя');
            $table->string('patronymic')->comment('Отчество')->nullable();
            $table->string('last_name')->comment('Фамилия');
            $table->string('phone')->comment('Телефон');
            $table->string('email')->comment('Почта')->unique();
            $table->string('address')->comment('Адрес доставки');
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
        Schema::dropIfExists('users');
    }
}
