<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Personal;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(Request $request): View {
        $types = ['current', 'past', 'future'];
        $request->validate([
            'type' => ['in:' . implode(',', $types)],
        ]);
        $bookings = DB::table('Бронирование')
            ->where( 'Код_клиента', '=', Auth::user()->client_code)
            ->orderBy('Дата_заезда')
            ->when(isset($request->type), function($query) use ($request) {
                if ($request->type === 'past') {
                    $query->where('Дата_выезда' < now());
                }
                elseif ($request->type === 'current') {
                    $query->where('Дата_заезда' >= now() && 'Дата_выезда' <= now());
                }
                else {
                    $query->where('Дата_выезда' > now());
                }
            })
            ->paginate(5);
        return view('bookings.index', ['bookings' => $bookings]);
    }

    public function store(Request $request) {
        $request->validate([
            'room_id' => ['required'],
            'start_date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    if (Carbon::parse($value) < now()->format('m/d/Y')) {
                        $fail("The start date must be in future");
                    }
            }],
            'end_date' => [
                'required',
                'date',
                function($attribute, $value, $fail) use ($request) {
                    $date = Carbon::parse($value);
                    if ($date < Carbon::parse($request->start_date)) {
                        $fail("The end date must be greater than the start date");
                    }
                    if ($date < now()->format('m/d/Y')) {
                        $fail("The end date must be in future");
                    }
            }],
            'is_available_at_period' => [function($attribute, $value, $fail) use ($request) {
                $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
                $end_date = Carbon::parse($request->end_date)->format('Y-m-d');
                $isPeriodAvailable = $this->checkIsPeriodAvailable($start_date, $end_date, $request->room_id);
                if (!$isPeriodAvailable) {
                    $fail("Room unavailable at this period");
                }
            }]
        ]);


        DB::table('Бронирование')->insert([
            'Дата_совершения_бронирования' => now()->format('Y-m-d'),
            'Дата_заезда' => $this->formatDate($request->start_date),
            'Дата_выезда' => $this->formatDate($request->end_date),
            'Номер_комнаты' => $request->room_id,
            'Код_клиента' => Auth::user()->client_code,
            'Номер_работника' => Personal::where('Должность', 'Администратор')->pluck('Номер_работника')->first(),
        ]);

        return redirect('/');
    }

    public function edit(Booking $booking) {
        return view('bookings.edit', ['booking' => $booking]);
    }

    public function update(Request $request, Booking $booking) {
        $request->validate([
            'start_date' => [
                'required',
                'date',
                'after_or_equal:now',
                'date_format:m/d/Y',
                function (string $attribute, mixed $value, Closure $fail) use ($booking) {
                    if (
                        $booking->Дата_заезда <= now()->format('Y-m-d')
                        && $booking->Дата_заезда !== $value
                    ) {
                        $fail('Cant update start date of current or passed booking');
                    }
            }],
            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date',
                'date_format:m/d/Y',
                function (string $attribute, mixed $value, Closure $fail) use ($booking) {
                    if (
                        $booking->Дата_выезда < now()->format('Y-m-d')
                        && $booking->Дата_выезда !== $value
                    ) {
                        $fail('Cant update end date of passed booking');
                    }
                },
            ],
            'is_available_at_period' => [function($attribute, $value, $fail) use ($request, $booking) {
                $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
                $end_date = Carbon::parse($request->end_date)->format('Y-m-d');
                $isPeriodAvailable = $this->checkIsPeriodAvailable($start_date, $end_date, $booking->Номер_комнаты);
                if (!$isPeriodAvailable) {
                    $fail("Room unavailable at this period");
                }
            }]
        ]);

        $booking->update([
            'Дата_заезда' => $this->formatDate($request->start_date),
            'Дата_выезда' => $this->formatDate($request->end_date),
        ]);

        return redirect('/bookings');
    }

    public function destroy(Request $request, Booking $booking) {
        $validator = Validator::make($request->all(), []);
        if ($booking->Дата_заезда <= now()->format('Y-m-d')) {
            $validator->errors()->add('booking', 'can not delete passed or started booking');
            return redirect(route('bookings.edit', $booking->Номер_бронирования))->withErrors($validator);
        }
        $booking->delete();
        return redirect('/bookings');
    }

    public function show(Booking $booking) {
        return view('bookings.show', [
            'booking' => $booking->load(['personal', 'room.tariff', 'inclusions.service'])
        ]);
    }

    private function checkIsPeriodAvailable(string $start_date, string $end_date, int $room_id): bool {
        $isPeriodAvailable = DB::table('Бронирование')
            ->whereRaw("
                $room_id = Бронирование.Номер_комнаты and
            (
                (Дата_заезда >= '$start_date' and Дата_заезда <= '$end_date')
                or (Дата_выезда >= '$start_date' and Дата_выезда <= '$end_date')
            )")->get()
            ->isEmpty();
        return $isPeriodAvailable;
    }

    private function formatDate($date): string {
        return Carbon::parse($date)->format('Y-m-d');
    }
}
