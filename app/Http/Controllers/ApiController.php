<?php

namespace App\Http\Controllers;

use App\Position;
use App\StatusAgenda;
use App\Workunit;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    //
    public function get_workunits(Request $request)
    {
        $workunits = Workunit::when($request->search, function ($q, $search) {
            return $q->where('name', 'like', '%' . $search . '%');
        })->get();
        return response()->json($workunits);
    }

    public function get_positions(Request $request)
    {
        $positions = Position::when($request->search, function ($q, $search) {
            return $q->where('name', 'like', '%' . $search . '%');
        })->get();
        return response()->json($positions);
    }

    public function get_status_agendas(Request $request)
    {
        $status_agendas = StatusAgenda::when($request->search, function ($q, $search) {
            return $q->where('name', 'like', '%' . $search . '%');
        })->get();
        return response()->json($status_agendas);
    }
}
