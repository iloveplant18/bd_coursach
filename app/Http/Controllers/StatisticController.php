<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    public function index() {
        $cancellationPercentage = $this->getCancellationPercentage();
        $mostPopularService = $this->getMostPopularService();
        $layoffPercentage = $this->getLayoffPercentage();
        $unpaidBookings = $this->getUnpaidBookings();
        return view('statistics', [
            'cancellationPercentage' => $cancellationPercentage,
            'mostPopularService' => $mostPopularService,
            'layoffPercentage' => $layoffPercentage,
            'unpaidBookings' => $unpaidBookings,
        ]);
    }

    private function getCancellationPercentage() {
        $value = DB::select('select cancellation_percentage()')[0]->cancellation_percentage;
        $value = number_format($value, 2);
        return $value;
    }

    private function getMostPopularService() {
        $value = DB::select('select most_popular_service()');
        $result = ['-', '-'];
        if (isset($value[0])) {
            $value = $value[0]->most_popular_service;
            $value = substr($value, 1, strlen($value) - 2);
            $result = explode(',', $value);
        }
        return [
            'name' => $result[0],
            'count' => $result[1],
        ];
    }

    private function getLayoffPercentage() {
        $value = DB::select('select employee_termination_percentage()')[0]->employee_termination_percentage;
        $value = number_format($value, 2);
        return $value;
    }

    private function getUnpaidBookings() {
        $functionResult = DB::select('select find_unpaid_bookings()');
        if (!isset($functionResult[0])) return null;
        $bookings = $functionResult[0]->find_unpaid_bookings;
        $bookingsCollection = collect($bookings);
        $result = $bookingsCollection->map(function ($item) {
            $value = explode(',', $item)[0];
            $bookingNumber = substr($value, 1, strlen($value) - 1);
            return $bookingNumber;
        });
        return Booking::find($result)->load('client.user')->loadSum('payments', 'Сумма');
    }
}
