<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Client;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        /*$random = \Str::random(40);
        var_dump($random); die();*/
        $result = User::create([
            'name' => $data['name'],
            'username' => \Str::slug($data['name']).random_int(0, 999), //$data['username'],
            'email' => $data['email'],
            'is_admin' => false,
            'password' => Hash::make($data['password']),
        ]);

        if($result){
            $user = User::get()->where('email', $data['email'])->first()->toArray();

            Client::create([
                'user'       => $user['id'],
                'company'    => $data['company'],
                'address'    => $data['address'],
                'phone_code' => $data['area_code'],
                'phone'      => $data['phone'],
                'account_type_id'    => $data['type-compte']
            ]);
            return $result;
        }else{
            return $result;
        }
        
    }
}
