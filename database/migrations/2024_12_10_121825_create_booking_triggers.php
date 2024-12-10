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
            CREATE OR REPLACE FUNCTION get_booking_services(booking_id INTEGER)
            RETURNS TABLE (
                Номер_бронирования INTEGER,
                Описание_услуги VARCHAR(255),
                Стоимость DECIMAL(10,2)
            ) AS $$
            BEGIN
              RETURN QUERY
              SELECT
                в.Номер_бронирования,
                у.Описание_услуги,
                у.Стоимость
              FROM Включение AS в
              JOIN Услуга AS у ON в.Код_услуги = у.Код_услуги
              WHERE
                в.Номер_бронирования = booking_id;
            END;
            $$ LANGUAGE plpgsql;
        ");
        DB::statement("
            CREATE OR REPLACE FUNCTION calculate_total_booking_cost(booking_id INTEGER)
            RETURNS NUMERIC AS $$
            DECLARE
              total_cost NUMERIC;
            BEGIN
              SELECT COALESCE(SUM(у.Стоимость), 0) INTO total_cost
              FROM Включение AS в
              JOIN Услуга AS у ON в.Код_услуги = у.Код_услуги
              WHERE в.Номер_бронирования = booking_id;
              RETURN total_cost;
            END;
            $$ LANGUAGE plpgsql;
        ");
        DB::statement("
            CREATE OR REPLACE FUNCTION get_client_booking_history(client_id INTEGER)
            RETURNS TABLE (
                Номер_бронирования INTEGER,
                Дата_совершения_бронирования TIMESTAMP WITHOUT TIME ZONE,
                Стоимость DECIMAL(10, 2),
                Статус VARCHAR(255)  --Здесь тип данных был изменен
            ) AS $$
            BEGIN
              RETURN QUERY
              SELECT
                b.Номер_бронирования,
                b.Дата_совершения_бронирования,
                b.Стоимость,
                'Активное'::VARCHAR(255) AS Статус --Здесь явно указан тип данных
              FROM Бронирование AS b
              WHERE
                b.Код_клиента = client_id
              UNION ALL
              SELECT
                o.Номер_бронирования,
                o.Дата_отмены,
                o.Стоимость,
                'Отмененное'::VARCHAR(255) AS Статус --Здесь явно указан тип данных
              FROM Отмененные_бронирования AS o
              WHERE
                o.Код_клиента = client_id;
            END;
            $$ LANGUAGE plpgsql;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("drop function if exists get_booking_services(booking_id INTEGER)");
        DB::statement("drop function if exists calculate_total_booking_cost(booking_id INTEGER)");
        DB::statement("drop FUNCTION if exists get_client_booking_history(client_id INTEGER)");
    }
};
