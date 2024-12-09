<?php

namespace App\Providers;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventSilentlyDiscardingAttributes($this->app->isLocal());
        Gate::define('do-client-action', function ($user) {
            return $user->client_code;
        });
        Gate::define('do-personal-action', function ($user) {
            return $user->personal_number;
        });
        Gate::define('update-booking', function (User $user, Booking $booking) {
            if ($user->client_code) {
                return $booking->Код_клиента === $user->client_code;
            }
            $personal = DB::table('Персонал')->where('Номер_работника', '=', $user->personal_number);
            return $personal->Должность === 'Администратор';
        });
    }
}
