<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Models\UserList;
use App\Models\UserRole;
use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user.index');
    }

    public function getListUser(Request $request){
        $length = $request->input('length');
        $sortBy = $request->input('column');
        $userBy = $request->input('dir');
        $searchValue = $request->input('search');

        $query = UserList::eloquentQuery($sortBy, $userBy, $searchValue);
        
        $users = $query->where('is_admin', true)->where('username', '!=' , "root")->paginate($length);

        return new UserCollection($users);
    }

    public function getInfoClient($id){

        $client = DB::table('clients')->leftJoin('account_types', 'clients.account_type_id', '=', 'account_types.id')->select('clients.*', 'account_types.name as typeCompte')->where("clients.user", $id)->first();

        return response([
            "error" => 0,
            "company"  => $client->company,
            "address" => $client->address,
            "phone_code"   => $client->phone_code, 
            "phone"   => $client->phone,
            "typeCompte" => $client->typeCompte,
            "phoneUnique"  => $client->phone
        ]);
        
        
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = UserRole::getRoleList();
        return view('admin.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $usernameExist = User::get()->where('username', request('username'))->first();
        
        if($usernameExist){
            return response([
                "code" => 1,
                "message" => "Identifiant existe déjà!"
            ]);
        }

        try{            
            $store = User::create([
                'name' => request('full_name'),
                'username' => request('username'),
                'email' => \Str::slug(request('full_name')).random_int(0, 999).'@yopmail.com', //request('email'),
                "roles"    => array(request('roles')),
                'is_admin' => true,
                "is_notify"    => request('notifcationClient'),
                "email_verified_at"    => Carbon::now(),
                'password' => Hash::make(request('password'))
            ]);

        }catch(\Exceptions $e){
              return response([
                "code" => 1,
                "message" => $e->getMessage()
            ]);
        }

        if($store){
            return response([
                "code" => 0,
                "message" => "OK"
            ]);
        }else{
            return response([
                "code" => 1,
                "message" => "KO"
            ]);
        }
    }

    public function getProfil()
    {
        $user = Auth::user();
        $query=User::where('id', $user->id)->get();
        $data = new UserCollection($query);

        $is_admin = $user->is_admin;

        return view('actionUser.account', compact('data', 'is_admin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function UpdateUserSimple(Request $request)
    {
       
       $user = User::where('id', request('user.id'));
       
       $userUpdate = $user->update([
            "name" => request('user.name')
           ]);

        $client = Client::where('user', request('user.id'));

        $userUpdate = $client->update([
            "company" => request('infos.enterprise'),
            "phone_code" => request('infos.phone_code'),
            "phone" => request('infos.phoneUnique'),
            "address" => request('infos.address')
        ]);

         return response([
                "code" => 0,
                "message" => "OK"
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
