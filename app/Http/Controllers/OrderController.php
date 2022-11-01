<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Http\Resources\TypeCollection;
use App\Notifications\OrderNewNotification;
use App\Notifications\OrderStatusNotification;
use App\Models\Order;
use App\Models\StatusOrder;
use App\Models\Type;
use App\Models\UserRole;
use App\Models\User;
use App\Models\LogOrder;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;



class OrderController extends Controller
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
    public function index(Request $request)
    {
        $user = Auth::user();

        $length = $request->input('length');
        $status = $request->input('status');
        $sortBy = $request->input('column');
        $orderBy = $request->input('dir');
        $searchValue = $request->input('search');

        $query = Order::eloquentQuery($sortBy, $orderBy, $searchValue);

        if($status > 0){
            $query = $query->where("status", $status);
        }
        
        $orders = $query->where("user_id", $user->id)->paginate($length);

        return new OrderCollection($orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $matiere = Type::where("status", true)->orderBy('isOther', 'asc')->get()->toArray();

        return view('order.create', compact('matiere'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        try{ 
            $longeur = str_replace(' ', '', request('long')); 
            $largeur = str_replace(' ', '', request('larg'));      
            $order = Order::create([
                'type_id' => request('idMatiere'),
                'long'    => floatval(str_replace(',', '.', $longeur)),
                'larg'    => floatval(str_replace(',', '.', $largeur)),
                'comment' => (request('commentaire')==""? ' ':request('commentaire')),
                'unit'    => request('unit'),
                'user_id' => intval(request('client')), //$user->id,
                'autre_matiere' => (request('otherMatiere')==""? ' ':request('otherMatiere')),
                'images' => '',
                'status' => StatusOrder::INITIE,
                'agent'    => $user->username
            ]);

        }catch(\Exceptions $e){
              return response([
                "code" => 1,
                "message" => $e->getMessage()
            ]);
        }

        if($order){
            
            $users_notif = User::get()->where("is_admin", true)->where("is_notify", true);

            //$order->notify(new OrderNewNotification($receivers));

            Notification::send($users_notif, new OrderNewNotification($order));

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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOrders(Request $request)
    {
        $user = Auth::user();

        $length = $request->input('length');
        $sortBy = $request->input('column');
        $orderBy = $request->input('dir');
        $searchValue = $request->input('search');
        $status = $request->input('status');
        
        $query = Order::eloquentQuery($sortBy, $orderBy, $searchValue);

        
        if($user->hasRole(UserRole::ROLE_SALLE_TIRAGE_ROULEAU) || $user->hasRole(UserRole::ROLE_SALLE_TIRAGE_FEUILLE)){
           $query = $query->where("status", StatusOrder::EN_SALLE_DE_TIRAGE);
        }
        if($user->hasRole(UserRole::ROLE_SALLE_DECOUPE)){
           $query = $query->where("status", StatusOrder::EN_SALLE_DE_DECOUPE);
        }
        if($user->hasRole(UserRole::ROLE_IMPRESSION_DIRECTE)){
           $query = $query->where("status", StatusOrder::IMPRESSION_DIRECTE);
        }
        if($user->hasRole(UserRole::ROLE_FINITION)){
           $query = $query->where("status", StatusOrder::EN_FINITION);
        }

         if($status > 0){
            $query = $query->where("status", $status);
        }
        
        $orders = $query->paginate($length);

        return new OrderCollection($orders);
    }

   /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return View
     */
    public function orderShow(Order $order): View
    {
        $orderCurrent = Order::leftJoin('types', 'orders.type_id', '=', 'types.id')
        ->select('orders.*', 'types.traitement as traitement', 'types.status as statusType')->where('orders.id', $order['id'])->first()->toArray() ;
        $isdecoupe=0; 

        if($orderCurrent['traitement'] == StatusOrder::EN_SALLE_DE_DECOUPE){
            $isdecoupe=true; 
        }

        $isimpression=0; 

        if($orderCurrent['traitement'] == StatusOrder::IMPRESSION_DIRECTE){
            $isimpression=true; 
        }

        $data = new OrderResource($order);

        $status = StatusOrder::getStatusOrder();

        $statusLog = StatusOrder::getStatusOrderLog();

        $logs = LogOrder::where("order_id", $order->id)->get();
        
        $orderLogs = [];

        foreach($logs as $log){
            $orderLogs[] = [
                            "status" => $log['status'],
                            "user" => $log->user->name,
                            "date" => Carbon::parse($log->created_at)->format('d/m/Y H:i:s') 
                          ];
        }

        return view('admin.order.show', compact('data', 'status', 'statusLog', 'orderLogs', 'isdecoupe', 'isimpression'));
    }


     /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return View
     */
    public function orderView(Order $order): View
    {
        $user = Auth::user();
       
        if($order->user_id != $user->id){
            abort(404);
        }
        
        $orderCurrent = Order::leftJoin('types', 'orders.type_id', '=', 'types.id')
        ->select('orders.*', 'types.traitement as traitement', 'types.status as statusType')->where('orders.id', $order['id'])->first()->toArray() ;
        $isdecoupe=0; 

        if($orderCurrent['traitement'] == StatusOrder::EN_SALLE_DE_DECOUPE){
            $isdecoupe=true; 
        }

         $isimpression=0; 

        if($orderCurrent['traitement'] == StatusOrder::IMPRESSION_DIRECTE){
            $isimpression=true; 
        }



        $data = new OrderResource($order);

        $status = StatusOrder::getStatusOrder();

        $statusLog = StatusOrder::getStatusOrderLog();

        $logs = LogOrder::where("order_id", $order->id)->get();
        
        $orderLogs = [];

        foreach($logs as $log){
            $orderLogs[] = [
                            "status" => $log['status'],
                            "user" => $log->user->name,
                            "date" =>  Carbon::parse($log->created_at)->format('d/m/Y H:i:s') 
                          ];
        }

        return view('order.show', compact('data', 'status', 'statusLog', 'orderLogs', 'isdecoupe', 'isimpression'));
    }


    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        
        $result = Order::get()->where("id", $id)->where('user_id', $user->id)->first();
        
        if(!$result){
            abort(404);
        }
        $order = $result->toArray();
        $matiere = Type::orderBy('isOther', 'asc')->where("status", true)->get()->toArray();

        return view('order.edit', compact('matiere', 'order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $status, $idUser)
    { 
         foreach(auth()->user()->notifications as $notification){
            if($notification->data['order_id']== $id){
               $notification->markAsRead();
            }
        }



        $order = Order::leftJoin('types', 'orders.type_id', '=', 'types.id')
        ->select('orders.*', 'types.traitement as traitement', 'types.status as statusType')->where('orders.id', $id) ;

        $oldStatus = $order->first()->toArray();

       

        if($oldStatus['status'] == StatusOrder::INITIE){
           if($oldStatus['traitement'] == StatusOrder::EN_SALLE_DE_TIRAGE){
                $status = StatusOrder::EN_SALLE_DE_TIRAGE; 
           }
           if($oldStatus['traitement'] == StatusOrder::EN_SALLE_DE_DECOUPE){
                $status = StatusOrder::EN_SALLE_DE_DECOUPE; 
           }
           if($oldStatus['traitement'] == StatusOrder::IMPRESSION_DIRECTE){
                $status = StatusOrder::IMPRESSION_DIRECTE; 
           }
        }

        $order->update([
            "orders.status" => $status
           ]);

        // Historisation du changement de status
        LogOrder::create([
                'order_id'   => $id,
                'user_id'    => Auth::user()->id,
                'status'     => $oldStatus['status']
            ]);
        /*


        // Notification du changement de status au client
        $user = User::get()->where("id", $idUser);

        Notification::send($user, new OrderStatusNotification($status, $id));

        // Notification des employées en fonction du status
        $users =User::where('is_admin', true)->get();

        $id_employes = [];


        if($status == StatusOrder::EN_SALLE_DE_TIRAGE){
            foreach($users as $user){
                if($user->hasRole(UserRole::ROLE_SALLE_TIRAGE_ROULEAU) || $user->hasRole(UserRole::ROLE_SALLE_TIRAGE_FEUILLE) || $user->hasRole(UserRole::ROLE_SALLE_DECOUPE)){
                      $id_employes[] = $user->id;
                }
            }
        }

        if($status == StatusOrder::EN_FINITION){
            foreach($users as $user){
                if($user->hasRole(UserRole::ROLE_FINITION)){
                      $id_employes[] = $user->id;
                }
            }
        }

        if($status == StatusOrder::ATTENTE_POUR_LIVRAISON){
            foreach($users as $user){
                if($user->hasRole(UserRole::ROLE_ADMIN) || $user->hasRole(UserRole::ROLE_SECRETARIAT)){
                      $id_employes[] = $user->id;
                }
            }
        }

        


        $employes =User::whereIn('id', $id_employes)->get();

        Notification::send($employes, new OrderStatusNotification($status, $id));*/


       

        return response([
            "code" => 0,
            "message" => "OK"
        ]);
    }

    public function notificationOrder(Request $request, $id, $status, $idUser){

        // Notification du changement de status au client
        $user = User::get()->where("id", $idUser);

        Notification::send($user, new OrderStatusNotification($status, $id));

        // Notification des employées en fonction du status
        $users =User::where('is_admin', true)->get();

        $id_employes = [];


        if($status == StatusOrder::EN_SALLE_DE_TIRAGE){
            foreach($users as $user){
                if($user->hasRole(UserRole::ROLE_SALLE_TIRAGE_ROULEAU) || $user->hasRole(UserRole::ROLE_SALLE_TIRAGE_FEUILLE) || $user->hasRole(UserRole::ROLE_SALLE_DECOUPE)){
                      $id_employes[] = $user->id;
                }
            }
        }

        if($status == StatusOrder::EN_FINITION){
            foreach($users as $user){
                if($user->hasRole(UserRole::ROLE_FINITION)){
                      $id_employes[] = $user->id;
                }
            }
        }

        if($status == StatusOrder::ATTENTE_POUR_LIVRAISON){
            foreach($users as $user){
                if($user->hasRole(UserRole::ROLE_ADMIN) || $user->hasRole(UserRole::ROLE_SECRETARIAT)){
                      $id_employes[] = $user->id;
                }
            }
        }

        


        $employes =User::whereIn('id', $id_employes)->get();

        Notification::send($employes, new OrderStatusNotification($status, $id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateOrder(Request $request) 
    { 
        $longeur = str_replace(' ', '', request('long')); 
        $largeur = str_replace(' ', '', request('larg'));   

        Order::where('id', request('id'))->where('user_id', request('user_id'))
              ->update([
                'type_id'    => request('type_id'),
                'long'    => floatval(str_replace(',', '.', $longeur)),
                'larg'    => floatval(str_replace(',', '.', $largeur)),
                'comment' => (request('comment')==""? ' ':request('comment')),
                'unit'    => request('unit'),
                'autre_matiere' => (request('autre_matiere')==""? ' ':request('autre_matiere'))
               ]);

        return response([
            "code" => 0,
            "message" => "OK"
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editAdmin($id)
    {
        $user = Auth::user();
        
        $result = Order::get()->where("id", $id)->first();
        
        if(!$result){
            abort(404);
        }
        $order = $result->toArray();
        $matiere = Type::where("status", true)->orderBy('isOther', 'asc')->get()->toArray();

        return view('admin.order.edit', compact('matiere', 'order'));
    }

    
    public function deleteOrder(Request $request){
     
        $resp = Order::where('id', request('id'))->delete();

        if($resp){
            // delete notification
            DB::table('notifications')->where('data->order_id', request('id'))->delete();
            return response([
                "code" => 0,
                "message" => "OK"
            ]);

       }else{

            return response([
                "code" => 1,
                "message" => "Erreur!"
            ]);
       }
    
    }
}
