<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RoomsController extends Controller
{
    public function index(Request $request): View {
        $request->validate([
            'start_date' => ['date', 'nullable'],
            'end_date' => ['date', 'nullable', 'gte:start_date'],
            'room_type' => ['string', 'nullable'],
        ]);
        $isRequestParametersExists = $request->start_date && $request->end_date;
        $room = DB::table('Номер')->when($isRequestParametersExists, function($query) use ($request) {
            $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
            $end_date = Carbon::parse($request->end_date)->format('Y-m-d');
            $query->whereRaw("not exists (
                select * from Бронирование
                where Номер.Номер_комнаты = Бронирование.Номер_комнаты and
                (
                    (Дата_заезда >= '$start_date' and Дата_заезда <= '$end_date')
                    or (Дата_выезда >= '$start_date' and Дата_выезда <= '$end_date')
                ))");
        })
        ->join('Тариф', 'Тариф.Код_тарифа',  '=', 'Номер.Код_тарифа')
        ->when($request->room_type, function($query) use ($request) {
            $query->where('Название', '=', $request->room_type);
        })->get();
        $roomTypes = DB::table('Тариф')->get();
        return view('rooms.index', [
            'rooms' => $room,
            'roomTypes' => $roomTypes,
        ]);
    }

    public function show(int $id): View {
        $room = DB::table('Номер')
            ->join('Тариф', 'Тариф.Код_тарифа', '=', 'Номер.Код_тарифа')
            ->where('Номер_комнаты', '=', $id)
            ->first();
        return view('rooms.show', ['room' => $room]);
    }
}
