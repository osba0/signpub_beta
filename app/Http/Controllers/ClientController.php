<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClientCollection;
use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

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
        ->select('clients.*', 'account_types.name as typeCompte', 'users.name as name','users.last_seen as lastSee','users.username as username', DB::raw('count(orders.user_id) as total_cmd'), )->where("is_admin", 0)->paginate($length);

        
        //$clients = $query->where('id', true)->paginate($length);

        return new ClientCollection($clients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
