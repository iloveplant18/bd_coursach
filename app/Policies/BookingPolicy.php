<?php

namespace App\Policies;

use App\Models\User;

class BookingPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function create(?User $user) {
//        if ($user?->client_code) {
//            return true;
//        }
    }
}
