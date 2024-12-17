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
              NEW.Стоимость = (
                SELECT Цена_за_сутки * greatest(NEW.Дата_выезда - NEW.Дата_заезда, 1)
                FROM Тариф
                WHERE Код_тарифа = (
                  SELECT Код_тарифа
                  FROM Номер
                  WHERE Номер_комнаты = NEW.Номер_комнаты
                )
              );

              -- Добавляем стоимость услуг, если они есть
              IF EXISTS (SELECT 1 FROM Включение WHERE Номер_бронирования = NEW.Номер_бронирования) THEN
                NEW.Стоимость = NEW.Стоимость + (
                    SELECT SUM(Услуга.Стоимость)
                    FROM Включение join Бронирование
                  on Включение.Номер_бронирования = Бронирование.Номер_бронирования
                  and Бронирование.Номер_бронирования = NEW.Номер_бронирования
                  join Услуга
                  on Услуга.Код_услуги = Включение.Код_услуги
                );
              END IF;

              RETURN NEW;
            END;
            $$ LANGUAGE plpgsql
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("drop trigger if exists update_booking_cost_trigger_update on Бронирование");
        DB::statement("drop trigger if exists update_booking_cost_trigger on Бронирование");
        DB::statement("drop function if exists update_booking_cost()");
    }
};
