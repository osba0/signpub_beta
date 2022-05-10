<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StatusOrder;
use App\Models\UserRole;
use App\Models\Order;

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
        $countPrint      = Order::get()->where("user_id", $user->id)->where("status", StatusOrder::EN_SALLE_DE_TIRAGE)->count();
        $countFinition   = Order::get()->where("user_id", $user->id)->where("status", StatusOrder::EN_FINITION)->count();
        $countDone       = Order::get()->where("user_id", $user->id)->where("status", StatusOrder::ATTENTE_POUR_LIVRAISON)->count();

        return view('home', compact('status', 'countNewOrder', 'countPrint', 'countFinition', 'countDone'));
        
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
         if($user->hasRole(UserRole::ROLE_SECRETARIAT) || $user->hasRole(UserRole::ROLE_ADMIN)){
           $canEdit = 1;
        }

        if($user->hasRole(UserRole::ROLE_SECRETARIAT)){
            $validationStatus = StatusOrder::EN_SALLE_DE_TIRAGE;
            $actualStatus = StatusOrder::INITIE;
        }
        if($user->hasRole(UserRole::ROLE_SALLE_TIRAGE_ROULEAU)){
            $validationStatus = StatusOrder::EN_FINITION;
            $actualStatus = StatusOrder::EN_SALLE_DE_TIRAGE;
        }
         if($user->hasRole(UserRole::ROLE_FINITION)){
            $validationStatus = StatusOrder::ATTENTE_POUR_LIVRAISON;
            $actualStatus = StatusOrder::EN_FINITION;
        }
        $status = StatusOrder::getStatusOrderForMng();

        // Get statistique
        $countNewOrder   = Order::get()->where("status", StatusOrder::INITIE)->count();
        $countPrint      = Order::get()->where("status", StatusOrder::EN_SALLE_DE_TIRAGE)->count();
        $countFinition   = Order::get()->where("status", StatusOrder::EN_FINITION)->count();
        $countDone       = Order::get()->where("status", StatusOrder::ATTENTE_POUR_LIVRAISON)->count();
        
        return view('admin.adminHome', compact('status', 'validationStatus', 'actualStatus', 'countNewOrder', 'countPrint', 'countFinition', 'countDone', 'canEdit'));
    }
}
