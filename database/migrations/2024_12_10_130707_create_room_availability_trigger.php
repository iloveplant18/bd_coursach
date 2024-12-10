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
            -- Триггер для проверки доступности номера при создании бронирования
            CREATE OR REPLACE FUNCTION check_room_availability()
            RETURNS trigger AS $$
            BEGIN
                -- Проверяем, есть ли пересечения дат бронирования для данного номера
                IF EXISTS (
                    SELECT 1
                    FROM Бронирование
                    WHERE Номер_комнаты = NEW.Номер_комнаты
                    AND (
                        (NEW.Дата_заезда BETWEEN Дата_заезда AND Дата_выезда)
                        OR (NEW.Дата_выезда BETWEEN Дата_заезда AND Дата_выезда)
                        OR (NEW.Дата_заезда <= Дата_заезда AND NEW.Дата_выезда >= Дата_выезда)
                    )
                AND NEW.Номер_бронирования != Номер_бронирования
                ) THEN
                    RAISE EXCEPTION 'Номер уже забронирован в указанные даты.';
                END IF;

                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ");
        DB::statement("
            CREATE TRIGGER check_room_availability_trigger
            BEFORE INSERT ON Бронирование
            FOR EACH ROW
            EXECUTE PROCEDURE check_room_availability();
        ");
        DB::statement("
            CREATE TRIGGER check_room_availability_trigger_update
            BEFORE UPDATE ON Бронирование
            FOR EACH ROW
            EXECUTE PROCEDURE check_room_availability();
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("drop trigger if exists check_room_availability_trigger on Бронирование");
        DB::statement("drop trigger if exists check_room_availability_trigger_update on Бронирование");
        DB::statement("drop function if exists check_room_availability()");
    }
};
