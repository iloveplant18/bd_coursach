<?php

namespace App\Http\Controllers;

use App\Models\Inclusion;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class DefaultController extends Controller
{
    public function dashboard() {
        $client = Auth::user()?->client;
        $booking = $client?->bookings->sortBy('Дата_заезда')->first();
        $todayInclusions = null;
        if (Gate::allows('do-personal-action')) {
            $todayInclusions = Inclusion::where('Дата_включения', now()->format('Y-m-d'))
                ->whereNot(function (EloquentBuilder $query) {
                    $query->has('realization');
                })
                ->with(['service', 'booking.client.user'])
                ->take(5)
                ->get();
        }
        return view('dashboard', [
            'nearestBooking' => $booking,
            'todayInclusions' => $todayInclusions,
        ]);
    }
}
