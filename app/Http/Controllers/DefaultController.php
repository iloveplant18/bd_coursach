<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DefaultController extends Controller
{
    public function dashboard() {
        $client = Auth::user()->client;
        $booking = $client?->bookings->sortBy('Дата_заезда')->first();
        return view('dashboard', ['nearestBooking' => $booking]);
    }
}
