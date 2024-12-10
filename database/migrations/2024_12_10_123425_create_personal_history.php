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
        Schema::create('Персонал_история', function (Blueprint $table) {
            $table->id('ID');
            $table->timestamp('Дата_изменения');
            $table->integer('Номер_работника');
            $table->string('Старая_ФИО', 255);
            $table->string('Новое_ФИО', 255);
            $table->string('Старая_Должность', 255);
            $table->string('Новая_Должность', 255);
        });
        Schema::create('Персонал_уволены', function (Blueprint $table) {
            $table->id('Номер_работника');
            $table->string('ФИО', 255)->nullable();
            $table->date('Дата_рождения')->nullable();
            $table->string('Должность', 255)->nullable();
            $table->timestamp('Дата_увольнения')->nullable();
        });
        DB::statement("
            -- Триггер для отслеживания изменений в должности сотрудника
            CREATE OR REPLACE FUNCTION log_personnel_changes()
            RETURNS trigger AS $$
            BEGIN
              INSERT INTO Персонал_история (
                    Дата_Изменения,
                    Номер_работника,
                    Старое_ФИО,
                    Новая_ФИО,
                    Старая_Должность,
                    Новая_Должность
                ) VALUES (
                    NOW(),
                    NEW.Номер_работника,
                    OLD.ФИО,
                    NEW.ФИО,
                    OLD.Должность,
                    NEW.Должность
                );
              RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ");
        DB::statement("
            CREATE TRIGGER personnel_changes_trigger
            AFTER UPDATE ON Персонал
            FOR EACH ROW
                EXECUTE PROCEDURE log_personnel_changes();
        ");
        DB::statement("
            -- Триггер для отслеживания удаления сотрудника
            CREATE OR REPLACE FUNCTION log_personnel_deletion()
            RETURNS trigger AS $$
            BEGIN
              INSERT INTO Персонал_уволены (
                    Номер_работника,
                    ФИО,
                    Дата_рождения,
                    Должность,
                    Дата_увольнения
                ) VALUES (
                    OLD.Номер_работника,
                    OLD.ФИО,
                    OLD.Дата_рождения,
                    OLD.Должность,
                    NOW()
                );
              RETURN OLD; -- Возвращаем старые данные для каскадного удаления
            END;
            $$ LANGUAGE plpgsql;
        ");
        DB::statement("
            CREATE TRIGGER personnel_deletion_trigger
            AFTER DELETE ON Персонал
            FOR EACH ROW
                EXECUTE PROCEDURE log_personnel_deletion();
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Персонал_история');
        Schema::dropIfExists('Персонал_уволены');
        DB::statement("drop trigger if exists personnel_changes_trigger on Персонал");
        DB::statement("drop function if exists log_personnel_changes()");
        DB::statement("drop trigger if exists personnel_deletion_trigger on Персонал");
        DB::statement("drop function if exists log_personnel_deletion()");
    }
};
