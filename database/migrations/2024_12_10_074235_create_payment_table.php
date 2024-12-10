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
        Schema::create('Оплата', function (Blueprint $table) {
            $table->id('Номер_транзакции');
            $table->decimal('Сумма', 10, 2);
            $table->date('Дата');
            $table->foreignId('Номер_бронирования')
                ->constrained('Бронирование', 'Номер_бронирования')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Оплата');
    }
};
