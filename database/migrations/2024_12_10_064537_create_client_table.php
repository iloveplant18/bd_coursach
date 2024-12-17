<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('Клиент', function (Blueprint $table) {
            $table->increments('Код_клиента')->primary();
            $table->string('ФИО', 255)->nullable();
            $table->string('Номер_телефона', 20)->unique();
            $table->date('Дата_рождения')->nullable();
            $table->string('Адрес_проживания', 255)->nullable();
            $table->string('Паспорт', 20)->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Клиент');
    }
};
