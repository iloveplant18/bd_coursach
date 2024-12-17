<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('Включение', function (Blueprint $table) {
            $table->id('Номер_применения');
            $table->foreignId('Номер_бронирования')
                ->constrained('Бронирование', 'Номер_бронирования')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('Код_услуги')
                ->constrained('Услуга', 'Код_услуги')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->enum('Состояние', ['выполнено', 'ожидает'])->default('ожидает');
            $table->date('Дата_включения');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Включение');
    }
};
