<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TariffsController extends Controller
{
    public function index(): View {
        $tariffs = DB::table("Тариф")->get();
        return view('tariffs', ['tariffs' => $tariffs]);
    }

    public function update(Request $request) {
//        validate
        $request->validate([
            'id' => 'required|exists:Тариф,Код_Тарифа',
            'price' => 'required|numeric'
        ]);
//        update database
         DB::table('Тариф')
             ->where('Код_тарифа', $request->id)
             ->update([]);
//        redirect
        return redirect('/tariffs');
    }
}
