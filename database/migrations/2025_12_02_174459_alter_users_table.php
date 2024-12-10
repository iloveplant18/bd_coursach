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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('personal_number')
                ->nullable()
                ->references('Номер_работника')
                ->on('Персонал')
                ->constrained();
            $table->foreignId('client_code')
                ->nullable()
                ->references('Код_клиента')
                ->on('Клиент')
                ->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_personal_number_foreign');
            $table->dropForeign('users_client_code_foreign');
        });
    }
};
