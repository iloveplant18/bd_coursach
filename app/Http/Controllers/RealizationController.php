<?php

namespace App\Http\Controllers;

use App\Models\Inclusion;
use App\Models\Realization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RealizationController extends Controller
{
    public function store(Request $request, Inclusion $inclusion) {
        $validator = Validator::make($request->all(), []);

//        TODO check is exists
        if (!$inclusion) {
            $validator->errors()->add('inclusion', 'inclusion not exists');
//        TODO check is already completed
        } elseif ($inclusion->realization) {
            $validator->errors()->add('inclusion', 'inclusion already completed');
//        TODO check is failed or in future
        } elseif ($inclusion->Дата_включения < now()->format('Y-m-d')) {
            $validator->errors()->add('inclusion', 'inclusion already failed');
        } elseif ($inclusion->Дата_включения > now()->format('Y-m-d')) {
            $validator->errors()->add('inclusion', "inclusion is in future. You can't complete future inclusion");
        }

//        create realization
        Realization::create([
            'Номер_применения' => $inclusion->Номер_применения,
            'Номер_работника' => Auth::user()->personal_number,
        ]);
//        redirect to inclusions.index
        return redirect(    route('inclusions.index'));
    }
}
