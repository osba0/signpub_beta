<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClientCollection;
use App\Models\User;
use App\Models\Client;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use File;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.client.index');
    }

    public function getListClient(Request $request){
        $length = $request->input('length');
        $sortBy = $request->input('column');
        $clientBy = $request->input('dir');
        $searchValue = $request->input('search');

        $query = Client::eloquentQuery($sortBy, $clientBy, $searchValue);

        
        $clients = $query->leftJoin('account_types', 'clients.account_type_id', '=', 'account_types.id')
        ->leftJoin('users', 'clients.user', '=', 'users.id')
        ->leftJoin('orders', 'clients.user', '=', 'orders.user_id')
        ->select('clients.*', 'account_types.name as typeCompte','account_types.id as type_id', 'users.name as name','users.email as email','users.last_seen as lastSee','users.username as username', DB::raw('count(orders.user_id) as total_cmd'), )->where("is_admin", 0)->paginate($length);

        
        //$clients = $query->where('id', true)->paginate($length);

        return new ClientCollection($clients);
    }

    public function deleteClient(Request $request){
     
        $hasLogo = Client::where('user', request('id'))->first()->toArray()["logo"];
        if(!is_null($hasLogo)){
            File::delete("assets/logoClients/".$hasLogo);
        }
      
                
                // Get all order of the client
                $allorder = Order::where('user_id', request('id'))->get()->toArray();
                $orderId=[];
                foreach($allorder as $order){
                    $orderId[] = $order["id"];
                }
                // Supprimer notif 
                foreach(auth()->user()->notifications as $notification){
                    if(in_array($notification->data['order_id'], $orderId)){

                        DB::table('notifications')->where('data->order_id', $notification->data['order_id'])->delete();
                       
                    }
                }
                // Supprimer commande de l'utilisateur 
                $resp = Order::whereIn('id', $orderId)->delete(); 


                $resp = User::where('id', request('id'))->delete();

                $resp = Client::where('user', request('id'))->delete();

            return response([
                "code" => 0,
                "message" => "OK"
            ]);

    
    
    }

    public function save(Request $request)
    {
        $random = \Str::random(6);
        $result = User::create([
            'name' => request('name'),
            'username' => \Str::slug(request('name')).random_int(0, 999), //$data['username'],
            'email' => request('email'),
            'is_admin' => false,
            'password' => Hash::make($random),
            'email_verified_at' => Carbon::now()->toDateTimeString()
        ]);

        if($result){
            $user = User::get()->where('email', request('email'))->first()->toArray();
            // Get logo
            $filename = '';

            if(!is_null($request->file('file'))){

                $file = $request->file('file');


                $current_date_time = Carbon::now()->toDateTimeString();
                $paseDate = explode(' ', $current_date_time);

                $filename = 'signpub_'.explode('.', $request->file('file')->getClientOriginalName())[0].'_'.$paseDate[0].'_'.str_replace(":","-",$paseDate[1]).'.'.$file->getClientOriginalExtension();
               
                $request->file->move("assets/logoClients/", $filename);
            }

            Client::create([
                'user'       => $user['id'],
                'password'   => $random,
                'company'    => request('company'),
                'address'    => request('address'),
                'phone_code' => request('area_code'),
                'phone'      => request('phone'),
                'account_type_id'    => request('typeCompte'),
                'logo' => $filename
            ]);

            return response([
                "code" => 0,
                "message" => "OK"
            ]);

        }else{

            return response([
                "code" => 1,
                "message" => ""
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        

        $filename = '';

        if(!is_null($request->file('file')) && request('nameLogo')==''){

            $file = $request->file('file');

            $current_date_time = Carbon::now()->toDateTimeString();
            $paseDate = explode(' ', $current_date_time);

            $filename = 'signpub_'.explode('.', $request->file('file')->getClientOriginalName())[0].'_'.request('numfact').'_'.$paseDate[0].'_'.str_replace(":","-",$paseDate[1]).'.'.$file->getClientOriginalExtension();
           
            $request->file->move("assets/logoClients/", $filename);
        }else{
            $filename = request('nameLogo');
        }

        $client =  Client::where('id','=',request('idClient'))->firstOrFail(); 
        
        $client->update([
                'company'    => request('company'),
                'address'    => request('address'),
                'phone_code' => request('area_code'),
                'phone'      => request('phone'),
                'account_type_id'    => request('typeCompte'),
                'logo' => $filename

          ]);

        $userClient =  User::where('id','=',request('userClient'))->firstOrFail(); 
        
        $userClient->update([
                'name'    => request('name'),
                'email'    => request('email')

          ]);

        



      return response([
            "code" => 0,
            "message" => "OK"
        ]);
}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        File::delete("assets/logoClients/".request('logo'));

        $client =  Client::where('logo','=',request('logo'))->firstOrFail(); 
        
        $client->update([
                'logo'    => ''
        ]);
        
        

        return response([
            "code" => 0,
            "message" => "OK"
        ]);
    }
}
