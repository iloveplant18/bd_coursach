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
            CREATE OR REPLACE FUNCTION employee_termination_percentage()
            RETURNS NUMERIC AS $$
            DECLARE
              total_employees BIGINT;
              terminated_employees BIGINT;
            BEGIN
              SELECT COUNT(*) INTO total_employees FROM Персонал;
              SELECT COUNT(*) INTO terminated_employees FROM Персонал_уволены;

              IF total_employees = 0 THEN
                RETURN 0; -- Избегаем деления на ноль, если нет работающих сотрудников
              ELSE
                RETURN (terminated_employees::NUMERIC / (total_employees + terminated_employees)::NUMERIC) * 100;
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
        DB::statement("drop function if exists employee_termination_percentage()");
    }
};
