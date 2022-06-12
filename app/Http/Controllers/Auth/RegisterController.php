<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\Position;
use App\Workunit;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nip' => ['required', 'numeric', 'digits:18'],
            'handphone' => ['required', 'min:8', 'max:16'],
            'username' => ['required', 'string', 'min:4', 'max:18', 'unique:users'],
            'workunit_id' => ['required', 'numeric'],
            'position_id' => ['required', 'numeric']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => strtoupper($data['name']),
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'nip' => $data['nip'],
            'handphone' => $data['handphone'],
            'username' => $data['username'],
            'role' => 'user',
            'workunit_id' => $data['workunit_id'],
            'position_id' => $data['position_id'],
        ]);
    }

    public function showRegistrationForm()
    {
        $workunits = Workunit::orderBy('name', 'asc')->get();
        $positions = Position::orderBy('name', 'asc')->get();
        return view('auth.register', compact('workunits', 'positions'));
    }
}
