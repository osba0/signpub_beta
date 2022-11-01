<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StatusOrder;
use App\Models\UserRole;
use App\Models\Order;
use App\Models\Client;
use App\Models\Type;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $status = StatusOrder::getStatusOrder();
        
        if($user->is_admin){
             return redirect('/admin/home');
        }

        // Get statistique
        $countNewOrder   = Order::get()->where("user_id", $user->id)->where("status", StatusOrder::INITIE)->count();
        $countPrint  = Order::get()->where("user_id", $user->id)->where("status", StatusOrder::EN_SALLE_DE_TIRAGE)->count();
        $countDecoupe = Order::get()->where("user_id", $user->id)->where("status", StatusOrder::EN_SALLE_DE_DECOUPE)->count();
        $countImpressionDirecte = Order::get()->where("user_id", $user->id)->where("status", StatusOrder::IMPRESSION_DIRECTE)->count();
        $countFinition   = Order::get()->where("user_id", $user->id)->where("status", StatusOrder::EN_FINITION)->count();
        $countDone       = Order::get()->where("user_id", $user->id)->where("status", StatusOrder::ATTENTE_POUR_LIVRAISON)->count();

        return view('home', compact('status', 'countNewOrder', 'countPrint','countDecoupe','countImpressionDirecte',  'countFinition', 'countDone'));
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function adminHome()

    {
        $user = Auth::user();

        $validationStatus='';
        $actualStatus='';

        $canEdit = 0;
        $isAdmin = 0;
        $canCreate=0;
        $canFiltreStatus = 0;

        $matiere = Type::where("status", true)->orderBy('isOther', 'asc')->get()->toArray();
        $clients = Client::get()->toArray();
 


        if($user->hasRole(UserRole::ROLE_SECRETARIAT) || $user->hasRole(UserRole::ROLE_ADMIN)){
           $isAdmin = 1;
           $canFiltreStatus = 1;
        }

        if($user->hasRole(UserRole::ROLE_SECRETARIAT) || $user->hasRole(UserRole::ROLE_ADMIN)){
           $canEdit = 1;
           $actualStatus= -1;
           $validationStatus= -1;
           $canFiltreStatus = 1;
        }
        if($user->hasRole(UserRole::ROLE_ADMIN)){
            $canCreate = 1;
        }

         if($user->hasRole(UserRole::ROLE_RECEPTION)){
            $actualStatus = StatusOrder::INITIE;
            $validationStatus= 0;
            $canCreate = 1;
        }

        if($user->hasRole(UserRole::ROLE_SECRETARIAT)){
            $validationStatus = strval(StatusOrder::EN_SALLE_DE_TIRAGE).'-'.strval(StatusOrder::EN_SALLE_DE_DECOUPE);
            $actualStatus = StatusOrder::INITIE;
        }
        if($user->hasRole(UserRole::ROLE_SALLE_TIRAGE_ROULEAU) || $user->hasRole(UserRole::ROLE_SALLE_TIRAGE_FEUILLE)){
            $validationStatus = StatusOrder::EN_FINITION;
            $actualStatus = StatusOrder::EN_SALLE_DE_TIRAGE;
        }
        if($user->hasRole(UserRole::ROLE_SALLE_DECOUPE)){
            $validationStatus = StatusOrder::EN_FINITION;
            $actualStatus = StatusOrder::EN_SALLE_DE_DECOUPE;
        }
        if($user->hasRole(UserRole::ROLE_IMPRESSION_DIRECTE)){
            $validationStatus = StatusOrder::EN_FINITION;
            $actualStatus = StatusOrder::IMPRESSION_DIRECTE;
        }
         if($user->hasRole(UserRole::ROLE_FINITION)){
            $validationStatus = StatusOrder::ATTENTE_POUR_LIVRAISON;
            $actualStatus = StatusOrder::EN_FINITION;
        }
        $status = StatusOrder::getStatusOrderForMng();

        // Get statistique
        $countNewOrder   = Order::get()->where("status", StatusOrder::INITIE)->count();
        $countPrint      = Order::get()->where("status", StatusOrder::EN_SALLE_DE_TIRAGE)->count();
        $countDecoupe      = Order::get()->where("status", StatusOrder::EN_SALLE_DE_DECOUPE)->count();
        $countImpressionDirecte      = Order::get()->where("status", StatusOrder::IMPRESSION_DIRECTE)->count();
        $countFinition   = Order::get()->where("status", StatusOrder::EN_FINITION)->count();
        $countDone       = Order::get()->where("status", StatusOrder::ATTENTE_POUR_LIVRAISON)->count();

        $totalOrder   = Order::get()->where("status", '>=', StatusOrder::INITIE)->count();
        $totalClient   = Client::get()->count();
        
        return view('admin.adminHome', compact('status', 'validationStatus', 'actualStatus', 'countNewOrder', 'countPrint','countDecoupe', 'countImpressionDirecte', 'countFinition', 'countDone', 'canEdit', 'totalOrder', 'totalClient', 'isAdmin', 'canFiltreStatus', 'matiere', 'clients', 'canCreate'));
    }
}
