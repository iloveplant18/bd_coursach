<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Tariff;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('Номер', function (Blueprint $table) {
            $table->id('Номер_комнаты');
            $table->foreignId('Код_тарифа')->constrained(
                table: 'Тариф', column: 'Код_тарифа'
            )->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('Этаж');
            $table->integer('Количество_мест');
            $table->boolean('Свободен')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Номер');
    }
};
