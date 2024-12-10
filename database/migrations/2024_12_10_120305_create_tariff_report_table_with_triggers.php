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
        Schema::create('Тариф_отчет', function (Blueprint $table) {
            $table->timestamp('Дата_изменения');
            $table->string('Название', 255)->nullable();
            $table->decimal('Старая_цена',10, 2)->nullable();
            $table->decimal('Новая_цена',10, 2)->nullable();
        });
        DB::statement("
            -- Триггерная функция
            CREATE OR REPLACE FUNCTION log_tariff_changes()
            RETURNS trigger AS $$
            BEGIN
              INSERT INTO Тариф_Отчет (
                Дата_Изменения,
                Название,
                Старая_Цена,
                Новая_Цена
              ) VALUES (
                NOW(),
                OLD.Название,
                OLD.Цена_за_сутки,
                NEW.Цена_за_сутки
              );
              RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ");
        DB::statement("
            -- Триггер
            CREATE TRIGGER log_tariff_changes_trigger
            AFTER UPDATE ON Тариф
            FOR EACH ROW
            EXECUTE PROCEDURE log_tariff_changes();
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Тариф_отчет');
        DB::statement("drop trigger if exists log_tariff_changes_trigger on Тариф");
        DB::statement("drop function if exists log_tariff_changes()");
    }
};
