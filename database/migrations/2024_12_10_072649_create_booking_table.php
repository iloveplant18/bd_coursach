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
        Schema::create('Бронирование', function (Blueprint $table) {
            $table->id('Номер_бронирования');
            $table->date('Дата_совершения_бронирования')->default(now());
            $table->date('Дата_заезда');
            $table->date('Дата_выезда');
            $table->decimal('Стоимость', 10, 2);
            $table->foreignId('Номер_комнаты')
                ->constrained('Номер', 'Номер_комнаты')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('Код_клиента')
                ->constrained('Клиент', 'Код_клиента')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('Номер_работника')
                ->constrained('Персонал', 'Номер_работника')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Бронирование');
    }
};
