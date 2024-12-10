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
        Schema::create('Отмененные_бронирования', function (Blueprint $table) {
            $table->id('Номер_бронирования');
            $table->date('Дата_совершения_бронирования')->default(now())->nullable();
            $table->date('Дата_заезда')->nullable();
            $table->date('Дата_выезда')->nullable();
            $table->decimal('Стоимость', 10, 2)->nullable();
            $table->integer('Номер_комнаты')->nullable();
            $table->integer('Код_клиента')->nullable();
            $table->integer('Номер_работника')->nullable();
            $table->timestamp('Дата_отмены')->nullable();
        });
        DB::statement("
            CREATE OR REPLACE FUNCTION log_cancelled_booking()
            RETURNS trigger AS $$
            BEGIN
              INSERT INTO Отмененные_бронирования (
                Номер_бронирования,
                Дата_совершения_бронирования,
                Дата_заезда,
                Дата_выезда,
                Стоимость,
                Номер_комнаты,
                Код_клиента,
                Номер_работника,
                Дата_отмены
            ) VALUES (
                OLD.Номер_бронирования,
                OLD.Дата_совершения_бронирования,
                OLD.Дата_заезда,
                OLD.Дата_выезда,
                OLD.Стоимость,
                OLD.Номер_комнаты,
                OLD.Код_клиента,
                OLD.Номер_работника,
                NOW()
              );
              RETURN OLD;
            END;
            $$ LANGUAGE plpgsql;
        ");
        DB::statement("
            CREATE TRIGGER log_cancelled_booking_trigger
            AFTER DELETE ON Бронирование
            FOR EACH ROW
            EXECUTE PROCEDURE log_cancelled_booking();
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Отмененные_бронирования');
        DB::statement("drop trigger if exists log_cancelled_booking_trigger on Бронирование");
        DB::statement("drop function if exists log_cancelled_booking()");
    }
};
