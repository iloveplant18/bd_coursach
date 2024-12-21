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
        Schema::create('Осуществление', function (Blueprint $table) {
            $table->id('Номер_осуществления');
            $table->foreignId('Номер_применения')
                ->constrained('Включение', 'Номер_применения')
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
        Schema::dropIfExists('Осуществление');
    }
};
