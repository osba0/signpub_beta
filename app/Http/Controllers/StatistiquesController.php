<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\UserCollection;
use App\Models\UserRole;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatistiquesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users =User::where('is_admin', true)->get();

        $tireurs = []; $tireursID = [];
        foreach($users as $user){
            if($user->hasRole(UserRole::ROLE_SALLE_TIRAGE_ROULEAU) || $user->hasRole(UserRole::ROLE_SALLE_TIRAGE_FEUILLE) || $user->hasRole(UserRole::ROLE_SALLE_DECOUPE)){
                  $tireurs[] = [
                            "id" => $user->id,
                            "name" => $user->name
                          ];
                $tireursID[] = $user->id;

            }
        }
       
        return view('admin.statistique.index', compact('tireursID', 'tireurs'));
    }
    public function getSurfaceTireur(Request $request){
       
        $result = DB::table('log_orders')
        ->leftJoin('orders', 'orders.id', '=', 'log_orders.order_id') 
        ->leftJoin('users', 'log_orders.user_id', '=', 'users.id')
        ->groupBy('users.id')
        ->select( 
            DB::raw('SUM(orders.long * orders.larg) as total_surface'), 
            DB::raw('SUM(orders.unit) as total_unite'), 
            'users.name as user')->whereBetween('log_orders.created_at', [request('filtre.dateDebut'), request('filtre.dateFin')]);
        if(request('filtre.tireur')!=""){
            
            $result = $result->where('log_orders.user_id', request('filtre.tireur'))->get()->toArray();
        }else{
            $result = $result->whereIn('log_orders.user_id', request('allTireurs'))->get()->toArray();
        }

        return response([
                "code" => 0,
                "result" => $result 
            ]);
      
      
        
    }
}
