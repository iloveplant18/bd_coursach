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
            CREATE OR REPLACE FUNCTION cancellation_percentage()
            RETURNS NUMERIC AS $$
            DECLARE
              total_bookings BIGINT;
              cancelled_bookings BIGINT;
            BEGIN
              SELECT COUNT(*) INTO total_bookings FROM Бронирование;
              SELECT COUNT(*) INTO cancelled_bookings FROM Отмененные_бронирования;

              IF total_bookings + cancelled_bookings = 0 THEN
                RETURN 0; -- Избегаем деления на ноль
              ELSE
                RETURN (cancelled_bookings::NUMERIC / (total_bookings + cancelled_bookings)::NUMERIC) * 100;
              END IF;
            END;
            $$ LANGUAGE plpgsql;

        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("drop function if exists cancellation_percentage()");
    }
};
