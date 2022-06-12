<?php

namespace App\Http\Controllers;

use App\Agenda;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'verified']);
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $agenda = new Agenda;
        $monthly_agendas = $agenda->leftJoin('presents', function ($join) {
            $join->on('agendas.id', '=', 'presents.agenda_id')
                ->where('presents.user_id', '=', Auth::user()->id);
        })
            ->whereMonth('start', '=', Carbon::now())->where(function ($query) {
                $query->whereNull('workunit_id')->orWhereRaw('FIND_IN_SET("' . Auth::user()->workunit_id . '",workunit_id)');
            })->orderBy('start', 'asc')->get();

        return view('pages.home', compact('monthly_agendas'));
    }

    public function profile_settings_index()
    {
        return view('pages.profile_settings');
    }

    public function profile_settings_get()
    {
        $user = User::where('id',  intval(Auth::user()->id))->first();
        if ($user) {
            return response()->json($user, 200);
        }
    }

    public function profile_settings_update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:255',
            'username' =>
            'required|min:4|max:18|unique:users,username,' . Auth::user()->id,
            'handphone' => 'required|min:8|max:16',
            'nip' => 'required|digits:18',
        ]);

        $user = User::find(intval(Auth::user()->id));
        $user->name = strtoupper($request->name);
        $user->username = $request->username;
        $user->handphone = $request->handphone;
        $user->nip = $request->nip;
        if ($user->save()) {
            return response()->json(['message' => 'Data Profil berhasil dirubah.'], 200);
        }
        return response()->json();
    }

    public function profile_settings_password_update(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required|max:255',
            'password' => 'required|confirmed|min:8|max:255',
        ]);

        $password_hash = Auth::user()->password;
        if (Hash::check($request->old_password, $password_hash)) {
            $user = User::find(intval(Auth::user()->id));
            $user->password = Hash::make($request->password);
            if ($user->save()) {
                return redirect(route('profile_settings'))->with('status', 'Profile updated!');
            }
        } else {
            return redirect(route('profile_settings'))->with('error', 'Password lama salah.');
        }
    }
}
