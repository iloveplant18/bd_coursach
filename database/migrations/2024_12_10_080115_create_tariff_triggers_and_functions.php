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
        DB::statement("
            -- Триггерная функция
            CREATE OR REPLACE FUNCTION check_tariff_name_count()
            RETURNS trigger AS $$
            BEGIN
              IF NEW.Название NOT IN ('Люкс', 'Стандартный', 'Эконом') THEN
                RAISE EXCEPTION 'Название тарифа должно быть `Люкс`, `Стандартный` или `Эконом`.';
              END IF;

              -- Проверка количества записей в таблице
              IF (SELECT COUNT(*) FROM Тариф) >= 3 THEN
                RAISE EXCEPTION 'Превышено максимальное количество тарифов.';
              END IF;

              RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ");
        DB::statement("
            -- Триггер
            CREATE TRIGGER check_tariff_name_count
            BEFORE INSERT ON Тариф
            FOR EACH ROW
            EXECUTE PROCEDURE check_tariff_name_count();
        ");

        DB::statement("
            -- Триггерная функция
            CREATE OR REPLACE FUNCTION check_tariff_name()
            RETURNS trigger AS $$
            BEGIN
              IF NEW.Название NOT IN ('Люкс', 'Стандартный', 'Эконом') THEN
                RAISE EXCEPTION 'Название тарифа должно быть `Люкс`, `Стандартный` или `Эконом`.';
              END IF;
              RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ");

        DB::statement("
            -- Триггер
            CREATE TRIGGER check_tariff_name_trigger
            BEFORE UPDATE ON Тариф
            FOR EACH ROW
            EXECUTE PROCEDURE check_tariff_name();
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            drop trigger if exists check_tariff_name_count on Тариф
        ");
        DB::statement("
            drop function if exists check_tariff_name_count
        ");
        DB::statement("
            drop trigger if exists check_tariff_name_trigger on Тариф
        ");
        DB::statement("
            drop function if exists check_tariff_name
        ");
    }
};
