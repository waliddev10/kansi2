<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModeratorAdminController extends Controller
{
    //
    public function index()
    {
        return view('pages.admin.moderator_list');
    }

    public function admin_index()
    {
        return view('pages.admin.admin_list');
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $user = User::find(intval($request->id));
        if ($user->role == 'user') {
            $user->role = 'moderator';
        } elseif ($user->role == 'moderator') {
            $user->role = 'user';
        }

        if ($user->save()) {
            return response()->json(['message' => 'User berhasil diubah.'], 200);
        }

        return response()->json();
    }

    public function admin_update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|not_in:' . Auth::user()->id,
        ]);

        $user = User::find(intval($request->id));
        if ($user->role == 'moderator') {
            $user->role = 'admin';
        } elseif ($user->role == 'admin') {
            $user->role = 'moderator';
        }

        if ($user->save()) {
            return response()->json(['message' => 'User berhasil diubah.'], 200);
        }

        return response()->json();
    }

    # -----------------------------------------------------------------
    # SCRIPT RESPONSE DATATABLE ---------------------------------------
    # Pusing Banget Ga Tuh!
    # Semangat
    # -----------------------------------------------------------------
    public function datatable_moderator(Request $request)
    {
        $search = $request->search['value'];
        $limit = $request->length;
        $start = $request->start;
        $order_index = $request->order[0]['column'];
        $order_field = $request->columns[$order_index]['data'];
        $order_ascdesc = $request->order[0]['dir'];
        $sql_total = User::with('workunit')->with('position')->where('role', 'moderator')->get()->count();
        $sql_data = User::with('workunit')->with('position')->where('role', 'moderator')->when($search, function ($q, $search) {
            return $q->where('name', 'like', '%' . $search . '%')->orWhere('nip', '%' . $search . '%')->orWhere('email', '%' . $search . '%');
        })->skip($start)->take($limit)->orderBy($order_field, $order_ascdesc)->get();

        ($search) ? $sql_filter = count($sql_data) : $sql_filter = $sql_total;

        $callback = [
            'draw' => intval($request->draw),
            'recordsTotal' => intval($sql_total),
            'recordsFiltered' => intval($sql_filter),
            'data' => $sql_data
        ];

        return response()->json($callback, 200)->header('Content-Type', 'application/json');
    }

    public function datatable_user(Request $request)
    {
        $search = $request->search['value'];
        $limit = $request->length;
        $start = $request->start;
        $order_index = $request->order[0]['column'];
        $order_field = $request->columns[$order_index]['data'];
        $order_ascdesc = $request->order[0]['dir'];

        $sql_total = User::with('workunit')->with('position')->where('role', 'user')->get()->count();
        $sql_data = User::with('workunit')->with('position')->where('role', 'user')->when($search, function ($q, $search) {
            return $q->where('name', 'like', '%' . $search . '%')->orWhere('nip', '%' . $search . '%')->orWhere('email', '%' . $search . '%');
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

    public function datatable_admin(Request $request)
    {
        $search = $request->search['value'];
        $limit = $request->length;
        $start = $request->start;
        $order_index = $request->order[0]['column'];
        $order_field = $request->columns[$order_index]['data'];
        $order_ascdesc = $request->order[0]['dir'];

        $sql_total = User::with('workunit')->with('position')->where('role', 'admin')->get()->count();
        $sql_data = User::with('workunit')->with('position')->where('role', 'admin')->when($search, function ($q, $search) {
            return $q->where('name', 'like', '%' . $search . '%')->orWhere('nip', '%' . $search . '%')->orWhere('email', '%' . $search . '%');
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
