<?php

namespace App\Http\Controllers;

use App\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PositionController extends Controller
{
    //
    public function index()
    {
        return view('pages.admin.master_position');
    }

    public function get(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $position = Position::where('id',  intval($request->id))->first();
        if ($position) {
            return response()->json($position, 200);
        }
        return response()->json();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:255',
        ]);

        $position = new Position();
        $position->name = $request->name;
        if ($position->save()) {
            return response()->json(['message' => 'Item "' . $position->name . '" berhasil ditambahkan.'], 200);
        }
        return response()->json();
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'name' => 'required|min:3|max:255',
        ]);

        $position = Position::find(intval($request->id));
        $position->name = $request->name;
        if ($position->save()) {
            return response()->json(['message' => 'Item berhasil diubah menjadi "' . $position->name . '".'], 200);
        }
        return response()->json();
    }

    public function destroy(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|not_in:' . Auth::user()->position->id,
        ]);

        $position = Position::find(intval($request->id));
        if ($position->delete(intval($request->id))) {
            return response()->json(['message' => 'Item "' . $position->name . '" berhasil dihapus.'], 200);
        }
        return response()->json();
    }

    public function restore(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $position = Position::onlyTrashed()->find(intval($request->id));
        if ($position->restore()) {
            return response()->json(['message' => 'Item "' . $position->name . '" berhasil direstore.'], 200);
        }
        return response()->json();
    }

    public function destroy_permanent(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $position = Position::onlyTrashed()->find(intval($request->id));
        if ($position->forceDelete()) {
            return response()->json(['message' => 'Item "' . $position->name . '" secara permanen dihapus.'], 200);
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

        $sql_total = Position::get()->count();
        $sql_data = Position::when($search, function ($q, $search) {
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

        $sql_total = Position::onlyTrashed()->get()->count();
        $sql_data = Position::onlyTrashed()->when($search, function ($q, $search) {
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
