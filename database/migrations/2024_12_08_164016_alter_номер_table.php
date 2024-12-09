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
        Schema::table('Номер', function (Blueprint $table) {
            $table->increments('Номер_комнаты')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Номер', function (Blueprint $table) {
            $table->bigIncrements('Номер_комнаты')->change();
        });
    }
};
