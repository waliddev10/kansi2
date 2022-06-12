<?php

namespace App\Http\Controllers;

use App\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class UpcomingAgendaController extends Controller
{
    //
    public function index()
    {
        $upcoming_agendas = Agenda::where('start', '>', Carbon::now())->where(function ($query) {
            $query->whereNull('workunit_id')->orWhereRaw('FIND_IN_SET("' . Auth::user()->workunit_id . '",workunit_id)');
        })->orderBy('start', 'asc')->get()->groupBy(function ($date) {
            return Carbon::parse($date->start)->isoFormat('MMMM YYYY');
        });

        return view('pages.upcoming_agenda', compact('upcoming_agendas'));
    }

    public function get_api()
    {
        $upcoming_agendas = Agenda::where('start', '>', Carbon::now())
            // ->where(function ($query) {
            //     $query->whereNull('workunit_id')->orWhereRaw('FIND_IN_SET("' . Auth::user()->workunit_id . '",workunit_id)');
            // })
            ->get()
            // ->groupBy(function ($date) {
            //     return Carbon::parse($date->start)->isoFormat('MMMM YYYY');
            // })
        ;

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil ditemukan.',
            'rows' => count($upcoming_agendas),
            'data' => $upcoming_agendas
        ], 200);
    }
}
