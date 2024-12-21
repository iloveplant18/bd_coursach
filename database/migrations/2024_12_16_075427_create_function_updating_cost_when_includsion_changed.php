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
        DB::statement(
            'create function update_booking_cost_by_inclusion() returns trigger
                    language plpgsql
                as
                $$
                begin
                    update Бронирование set Стоимость = (
                            select sum(Услуга.Стоимость) from Услуга
                              join Включение
                              on Услуга.Код_услуги = Включение.Код_услуги
                                  join Бронирование
                                  on Бронирование.Номер_бронирования = Включение.Номер_бронирования
                        ) where Номер_бронирования = NEW."Номер_бронирования";
                    return NEW;
                end
            $$;'
        );

        DB::statement('
            create trigger update_booking_cost_after_insert_inclusion
            after insert on Включение
            for each row
            execute procedure update_booking_cost_by_inclusion();
        ');
        DB::statement('
            create trigger update_booking_cost_after_update_inclusion
            after update on Включение
            for each row
            execute procedure update_booking_cost_by_inclusion();
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('drop trigger if exists update_booking_cost_after_insert_inclusion on Включение');
        DB::statement('drop trigger if exists update_booking_cost_after_update_inclusion on Включение');
        DB::statement('drop function if exists update_booking_cost_by_inclusion();');
    }
};
