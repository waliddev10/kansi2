<?php

namespace App\Http\Controllers;

use App\StatusAgenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusAgendaController extends Controller
{
    //
    public function index()
    {
        return view('pages.admin.master_status_agenda');
    }

    public function get(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $status_agenda = StatusAgenda::where('id',  intval($request->id))->first();
        if ($status_agenda) {
            return response()->json($status_agenda, 200);
        }
        return response()->json();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:255',
        ]);

        $status_agenda = new StatusAgenda();
        $status_agenda->name = $request->name;
        if ($status_agenda->save()) {
            return response()->json(['message' => 'Item "' . $status_agenda->name . '" berhasil ditambahkan.'], 200);
        }
        return response()->json();
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'name' => 'required|min:3|max:255',
        ]);

        $status_agenda = StatusAgenda::find(intval($request->id));
        $status_agenda->name = $request->name;
        if ($status_agenda->save()) {
            return response()->json(['message' => 'Item berhasil diubah menjadi "' . $status_agenda->name . '".'], 200);
        }
        return response()->json();
    }

    public function destroy(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $status_agenda = StatusAgenda::find(intval($request->id));
        if ($status_agenda->delete(intval($request->id))) {
            return response()->json(['message' => 'Item "' . $status_agenda->name . '" berhasil dihapus.'], 200);
        }
        return response()->json();
    }

    public function restore(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $status_agenda = StatusAgenda::onlyTrashed()->find(intval($request->id));
        if ($status_agenda->restore()) {
            return response()->json(['message' => 'Item "' . $status_agenda->name . '" berhasil direstore.'], 200);
        }
        return response()->json();
    }

    public function destroy_permanent(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $status_agenda = StatusAgenda::onlyTrashed()->find(intval($request->id));
        if ($status_agenda->forceDelete()) {
            return response()->json(['message' => 'Item "' . $status_agenda->name . '" secara permanen dihapus.'], 200);
        }
        return response()->json();
    }

    # -----------------------------------------------------------------
    # SCRIPT RESPONSE DATATABLE ---------------------------------------
    # Pusing Banget Ga Tuh!
    # Semangat
    # -----------------------------------------------------------------
    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $limit = $request->length;
        $start = $request->start;
        $order_index = $request->order[0]['column'];
        $order_field = $request->columns[$order_index]['data'];
        $order_ascdesc = $request->order[0]['dir'];

        $sql_total = StatusAgenda::get()->count();
        $sql_data = StatusAgenda::when($search, function ($q, $search) {
            return $q->where('name', 'like', '%' . $search . '%');
        })->skip($start)->take($limit)->orderBy($order_field, $order_ascdesc)->get();

        ($search) ? $sql_filter = count($sql_data) : $sql_filter = $sql_total;

        $callback = [
            'draw' => $request->draw,
            'recordsTotal' => $sql_total,
            'recordsFiltered' => $sql_filter,
            'data' => $sql_data
        ];

        return response()->json($callback, 200)->header('Content-Type', 'application/json');
    }

    public function datatable_trash(Request $request)
    {
        $search = $request->search['value'];
        $limit = $request->length;
        $start = $request->start;
        $order_index = $request->order[0]['column'];
        $order_field = $request->columns[$order_index]['data'];
        $order_ascdesc = $request->order[0]['dir'];

        $sql_total = StatusAgenda::onlyTrashed()->get()->count();
        $sql_data = StatusAgenda::onlyTrashed()->when($search, function ($q, $search) {
            return $q->where('name', 'like', '%' . $search . '%');
        })->skip($start)->take($limit)->orderBy($order_field, $order_ascdesc)->get();

        ($search) ? $sql_filter = count($sql_data) : $sql_filter = $sql_total;

        $callback = [
            'draw' => $request->draw,
            'recordsTotal' => $sql_total,
            'recordsFiltered' => $sql_filter,
            'data' => $sql_data
        ];

        return response()->json($callback, 200)->header('Content-Type', 'application/json');
    }
}
