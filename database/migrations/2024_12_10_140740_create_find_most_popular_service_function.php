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
            CREATE OR REPLACE FUNCTION most_popular_service()
            RETURNS TABLE (
                Описание_услуги VARCHAR(255),
                Количество_бронирований BIGINT  -- Изменено на BIGINT
            ) AS $$
            BEGIN
              RETURN QUERY
              SELECT
                у.Описание_услуги,
                COUNT(в.Номер_бронирования) AS Количество_бронирований
              FROM Включение AS в
              JOIN Услуга AS у ON в.Код_услуги = у.Код_услуги
              GROUP BY
                у.Описание_услуги
              ORDER BY
                Количество_бронирований DESC
              LIMIT 1;
            END;
            $$ LANGUAGE plpgsql;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("drop function if exists most_popular_service();");
    }
};
