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
CREATE OR REPLACE FUNCTION find_unpaid_bookings()
RETURNS TABLE (
    Номер_бронирования BIGINT,
    Стоимость_бронирования DECIMAL(10, 2),
    Долг DECIMAL(10, 2),
    ФИО_клиента VARCHAR(255),
    Код_клиента INTEGER
) AS $$
BEGIN
  RETURN QUERY
  SELECT
    b.Номер_бронирования::BIGINT,   -- Явно приводим к BIGINT
    b.Стоимость::DECIMAL(10, 2),      -- Явно приводим к DECIMAL(10, 2)
    (b.Стоимость - COALESCE((
      SELECT
        SUM(о.Сумма)
      FROM Оплата AS о
      WHERE
        о.Номер_бронирования = b.Номер_бронирования
    ), 0))::DECIMAL(10, 2) AS Долг,     -- Явно приводим к DECIMAL(10, 2)
    c.ФИО::VARCHAR(255) AS ФИО_клиента, -- Явно приводим к VARCHAR(255)
    b.Код_клиента::INTEGER   -- Явно приводим к INTEGER
  FROM Бронирование AS b
  JOIN Клиент AS c ON b.Код_клиента = c.Код_клиента
  WHERE
    b.Стоимость > COALESCE((
      SELECT
        SUM(о.Сумма)
      FROM Оплата AS о
      WHERE
        о.Номер_бронирования = b.Номер_бронирования
    ), 0);
END;
$$ LANGUAGE plpgsql;

        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('drop function if exists find_unpaid_bookings()');
    }
};
