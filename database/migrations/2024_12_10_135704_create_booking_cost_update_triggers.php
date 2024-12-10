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
            --Триггерная функция для обновления стоимости бронирования
            CREATE OR REPLACE FUNCTION update_booking_cost()
            RETURNS trigger AS $$
            BEGIN
              -- Получаем стоимость тарифа
              NEW.Стоимость := (
                SELECT Цена_за_сутки
                FROM Тариф
                WHERE Код_тарифа = (
                  SELECT Код_тарифа
                  FROM Номер
                  WHERE Номер_комнаты = NEW.Номер_комнаты
                )
              );

              -- Добавляем стоимость услуг, если они есть
              IF EXISTS (SELECT 1 FROM Включение WHERE Номер_бронирования = NEW.Номер_бронирования) THEN
                NEW.Стоимость := NEW.Стоимость + (
                    SELECT SUM(Стоимость)
                    FROM Услуга
                    WHERE Код_услуги IN (
                        SELECT Код_услуги
                        FROM Включение
                        WHERE Номер_бронирования = NEW.Номер_бронирования
                    )
                );
            END IF;

              RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ");
        DB::statement("
            -- Триггер для обновления стоимости бронирования при вставке
            CREATE TRIGGER update_booking_cost_trigger
            BEFORE INSERT ON Бронирование
            FOR EACH ROW
            EXECUTE PROCEDURE update_booking_cost();
        ");
        DB::statement("
            -- Триггер для обновления стоимости бронирования при изменении номера комнаты или услуг
            CREATE TRIGGER update_booking_cost_trigger_update
            BEFORE UPDATE ON Бронирование
            FOR EACH ROW
            EXECUTE PROCEDURE update_booking_cost();
        ");
        DB::statement("
            -- Триггер для обновления стоимости бронирования при изменении таблицы `Включение`
            CREATE TRIGGER update_booking_cost_trigger_inclusion
            AFTER INSERT OR UPDATE OR DELETE ON Включение
            FOR EACH ROW
            EXECUTE PROCEDURE update_booking_cost();
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_cost_update_triggers');
        DB::statement("drop trigger if exists update_booking_cost_trigger_inclusion on Включение");
        DB::statement("drop trigger if exists update_booking_cost_trigger_update on Бронирование");
        DB::statement("drop trigger if exists update_booking_cost_trigger on Бронирование");
        DB::statement("drop function if exists update_booking_cost()");
    }
};
