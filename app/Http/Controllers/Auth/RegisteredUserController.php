<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'date' => ['required', 'date', 'date_format:m/d/Y'],
            'passport' => ['required', 'digits:10', 'unique:Клиент,Паспорт'],
            'tel' => ['required', 'regex:/^\+7\d{10}/', 'unique:Клиент,Номер_телефона'],
            'address' => ['required', 'string', 'max:255'],
        ]);

        $id = DB::table('Клиент')->insertGetId([
            'Дата_рождения' => Carbon::parse($request->date),
            'Номер_телефона' => $request->tel,
            'Адрес_проживания' => $request->address,
            'Паспорт' => $request->passport,
        ], 'Код_клиента');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'client_code' => $id,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    public function createPersonal(): View {
        return view('auth.register_personal');
    }

    public function storePersonal(Request $request): RedirectResponse {
        $posts = [
            'officiant' => 'Официант',
            'cleaner' => 'Горничная',
            'admin' => 'Администратор',
        ];
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'date' => ['required', 'date', 'date_format:m/d/Y'],
            'post' => ['required', 'string', 'in:'.implode(',', array_keys($posts))],
        ]);

        $id = DB::table('Персонал')->insertGetId([
            'Дата_рождения' => Carbon::parse($request->date),
            'Должность' => $posts[$request->post],
        ], 'Номер_работника');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'personal_number' => $id,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
