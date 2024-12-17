<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request, Booking $booking) {
        $request->validate([
            'money' => ['required', 'integer', 'numeric'],
        ]);

        Payment::create([
            'Номер_бронирования' => $booking->Номер_бронирования,
            'Сумма' => $request->money,
            'Дата' => now()->format('Y-m-d'),
        ]);

        return redirect(route('statistics'));
    }
}
