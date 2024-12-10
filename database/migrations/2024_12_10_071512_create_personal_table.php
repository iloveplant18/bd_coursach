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
        Schema::create('Персонал', function (Blueprint $table) {
            $table->id('Номер_работника');
            $table->string('ФИО', 255);
            $table->date('Дата_рождения');
            $table->string('Должность', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Персонал');
    }
};
