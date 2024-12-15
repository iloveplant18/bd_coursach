<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Client;
use App\Models\Personal;
use App\Models\Room;
use App\Models\Service;
use App\Models\Tariff;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::truncate();
        Client::truncate();

        $client = Client::factory()->create([
            'Номер_телефона' => '+79799799799',
            'Дата_рождения' => '07-11-2001',
            'Адрес_проживания' => 'Москва',
            'Паспорт' => '0000000000',
        ]);
        User::factory()->for($client)->create([
            'name' => 'Клиент',
            'email' => 'client@client.client',
            'password' => 'clientclient',
        ]);
        $personal = Personal::factory()->create([
            'Дата_рождения' => '05-05-2017',
            'Должность' => 'Администратор'
        ]);
        User::factory()->for($personal)->create([
            'name' => 'Администратор',
            'email' => 'admin@admin.admin',
            'password' => 'adminadmin',
        ]);
        $officiant = Personal::factory()->create([
            'Должность' => 'Официант',
        ]);
        User::factory()->for($officiant)->create([
            'name' => 'Официант',
            'email' => 'officiant@officiant.officiant',
            'password' => 'officiantofficiant',
        ]);

        Booking::factory()->count(3)->oneAfterAnother()->for(
            $client
        )->for(
            $personal
        )->for(
            Room::factory()->for(
                Tariff::factory()
            )
        )->create();

        Service::factory()->count(40)->create();
    }
}
