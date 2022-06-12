<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function index()
    {
        return view('pages.moderator.user_list');
    }

    public function get(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $user = User::with('workunit')->with('position')->where('id',  intval($request->id))->first();
        if ($user) {
            return response()->json($user, 200);
        }
        return response()->json();
    }

    // public function store(Request $request)
    // {
    //     $this->validate($request, [
    //         'name' => 'required|string|min:3|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:8|confirmed',
    //         'nip' => 'required|numeric|digits:18',
    //         'handphone' => 'required|min:8|max:16',
    //         'username' => 'required|string|min:4|max:18|unique:users',
    //         'workunit_id' => 'required|numeric',
    //         'position_id' => 'required|numeric'
    //     ]);

    //     $user = new User();
    //     $user->name = $request->name;
    //     $user->email = $request->email;
    //     $user->password = $request->password;
    //     $user->nip = $request->nip;
    //     $user->handphone = $request->handphone;
    //     $user->username = $request->username;
    //     $user->workunit_id = $request->workunit_id;
    //     $user->position_id = $request->position_id;
    //     $user->email_verified_at = $request->email_verified_at;
    //     if ($user->save()) {
    //         return response()->json(['message' => 'Item "' . $user->name . '" berhasil ditambahkan.'], 200);
    //     }
    //     return response()->json();
    // }

    // public function update(Request $request)
    // {
    //     $this->validate($request, [
    //         'id' => 'required',
    //         'name' => 'required|string|min:3|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:8|confirmed',
    //         'nip' => 'required|numeric|digits:18',
    //         'handphone' => 'required|min:8|max:16',
    //         'username' => 'required|string|min:4|max:18|unique:users',
    //         'workunit_id' => 'required|numeric',
    //         'position_id' => 'required|numeric'
    //     ]);

    //     $user = User::find(intval($request->id));
    //     $user->name = $request->name;
    //     $user->email = $request->email;
    //     $user->password = $request->password;
    //     $user->nip = $request->nip;
    //     $user->handphone = $request->handphone;
    //     $user->username = $request->username;
    //     $user->workunit_id = $request->workunit_id;
    //     $user->position_id = $request->position_id;
    //     $user->email_verified_at = $request->email_verified_at;
    //     if ($user->save()) {
    //         return response()->json(['message' => 'Item berhasil diubah menjadi "' . $user->name . '".'], 200);
    //     }
    //     return response()->json();
    // }

    public function destroy(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|not_in:' . Auth::user()->id,
        ]);

        if (Auth::user()->role == 'moderator') {
            $user = User::whereNotIn('role', ['moderator', 'admin'])->find(intval($request->id));
        } else {
            $user = User::whereNotIn('role', ['admin'])->find(intval($request->id));
        }
        if ($user->delete(intval($request->id))) {
            return response()->json(['message' => 'Item "' . $user->name . '" berhasil dihapus.'], 200);
        }
        return response()->json();
    }

    public function restore(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $user = User::onlyTrashed()->find(intval($request->id));
        if ($user->restore()) {
            return response()->json(['message' => 'Item "' . $user->name . '" berhasil direstore.'], 200);
        }
        return response()->json();
    }

    public function destroy_permanent(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $user = User::onlyTrashed()->find(intval($request->id));
        if ($user->forceDelete()) {
            return response()->json(['message' => 'Item "' . $user->name . '" secara permanen dihapus.'], 200);
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

        $sql_total = User::with('workunit')->with('position')->get()->count();
        $sql_data = User::with('workunit')->with('position')->when($search, function ($q, $search) {
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

        $sql_total = User::onlyTrashed()->with('workunit')->with('position')->get()->count();
        $sql_data = User::onlyTrashed()->with('workunit')->with('position')->when($search, function ($q, $search) {
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
