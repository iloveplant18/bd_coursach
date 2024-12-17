<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Inclusion;
use App\Models\Service;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InclusionController extends Controller
{
    public static array $inclusionPeriod = ['future', 'today', 'passed'];

    public function index(Request $request) {
        $request->validate([
            'currentPersonal' => ['nullable'],
            'future' => ['nullable'],
            'today' => ['nullable'],
            'passed' => ['nullable'],
        ]);
        $inclusions = Inclusion::orderByDesc('Дата_включения')
            ->when($request->currentPersonal, function (Builder $query) {
                $query->whereHas('realization', function (Builder $query) {
                    $currentPersonalNumber = Auth::user()->personal->Номер_работника;
                    $query->where('Осуществление.Номер_работника', $currentPersonalNumber);
                });
            })
            ->when($request->future || $request->today || $request->passed, function (Builder $query) use($request) {
                $operator = '<';
                if ($request->future) {
                    $operator = '>';
                } elseif ($request->today) {
                    $operator = '=';
                }
                $query->where('Дата_включения', $operator, now()->format('Y-m-d'));
            })
            ->with(['realization.personal.user', 'service', 'booking.client.user'])
            ->paginate(10);
        return view('inclusions.index', [
            'inclusions' => $inclusions,
        ]);
    }

    public function create(Booking $booking) {
        $services = Service::paginate(10);
        return view('inclusions.create', [
            'services' => $services,
            'booking' => $booking,
        ]);
    }

    public function store(Request $request, Booking $booking) {
        $current_date = now()->format('Y-m-d');

        $request->validate([
            'service_date' => [
                'required',
                'date',
                'date_format:m/d/Y',
                "after_or_equal:$current_date",
                "after_or_equal:$booking->Дата_заезда",
                "before_or_equal:$booking->Дата_выезда"
            ],
            'service_code' => [
                'required',
                'exists:Услуга,Код_услуги',
            ],
        ]);

        Inclusion::create([
            'Номер_бронирования' => $booking->Номер_бронирования,
            'Код_услуги' => $request->service_code,
            'Дата_включения' => $request->service_date,
        ]);

        return redirect(route('bookings.show', $booking->Номер_бронирования));
    }

    public function destroy(Request $request, Booking $booking) {
        // @TODO check is inclusion completed
        $request->validate([
            'inclusion_number' => ['required', 'exists:Включение,Номер_применения'],
        ]);

        $inclusionNumbers = $booking->inclusions->pluck('Номер_применения');
        if ($inclusionNumbers->contains($request->inclusion_number)) {
            Inclusion::destroy($request->inclusion_number);
        }

        return redirect(route('bookings.show', $booking->Номер_бронирования));
    }
}
