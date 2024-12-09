<?php

use Illuminate\Support\Facades\DB;

beforeAll(function () {
//    create tarif
    $tariffId = DB::table('Тариф')->insertGetId([
        'Название' => 'тестовый тариф',
        'Цена_за_сутки' => 100,
    ]);
//    create room
    $roomId = 101;
    DB::table('Номер')->insertGetId([
        'Номер_комнаты' => $roomId,
        'Код_тарифа' => $tariffId,
        'Этаж' => 1,
        'Количество_мест' => 1,
        'Свободен' => true,
    ]);
//    create admin(personal)
    $personalId = DB::table('Персонал')->insertGetId([
        'ФИО' => $tariffId,
        'Дата_рождения' => '2024-01-01',
        'Должность' => 'Администратор'
    ]);
//    create client
    $clientId = DB::table('Клиент')->insertGetId([
        'Номер_телефона' => '+79829823838',
        'Дата_рождения' => '2024-01-01',
        'Адрес_проживания' => 'address',
        'Паспорт' => '0900990990',
        'ФИО' => 'Гаенко Иван ЙОу',
    ]);
//    create booking
    DB::table('Бронирование')->insert([
        'Дата_совершения_бронирования' => now(),
        'Дата_заезда' => '2024-01-01',
        'Дата_выезда' => '2024-02-02',
        'Стоимость' => 3000,
        'Номер_комнаты' => $roomId,
        'Код_клиента' => $clientId,
        'Номер_работника' => $personalId,
    ]);
});

test('booking update not available to guest', function () {
    $response = $this->get('/booking/101');
    $response->assertRedirect('/login');
});

