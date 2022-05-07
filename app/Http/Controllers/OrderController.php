<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Resources\OrderCollection;
use App\Http\Resources\TypeCollection;
use App\Models\Order;
use App\Models\StatusOrder;
use App\Models\Type;
use App\Models\UserRole;


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
        $sortBy = $request->input('column');
        $orderBy = $request->input('dir');
        $searchValue = $request->input('search');

        $query = Order::eloquentQuery($sortBy, $orderBy, $searchValue);
        
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
        $matiere = Type::get()->where("status", true)->toArray();

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
            $store = Order::create([
                'type_id'    => request('matiere'),
                'long'    => request('long'),
                'larg'    => request('larg'),
                'comment' => request('commentaire'),
                'unit'    => request('unit'),
                'user_id'    => $user->id,
                'images' => '',
                'status' => StatusOrder::INITIE
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

        $query = Order::eloquentQuery($sortBy, $orderBy, $searchValue);

        
        if($user->hasRole(UserRole::ROLE_SALLE_TIRAGE_ROULEAU)){
           $query = $query->where("status", StatusOrder::EN_SALLE_DE_TIRAGE);
        }
        if($user->hasRole(UserRole::ROLE_FINITION)){
           $query = $query->where("status", StatusOrder::EN_FINITION);
        }
        
        $orders = $query->paginate($length);

        return new OrderCollection($orders);
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
        $user = Auth::user();
        
        $result = Order::get()->where("id", $id)->where('user_id', $user->id)->first();
        
        if(!$result){
            abort(404);
        }
        $order = $result->toArray();
        $matiere = Type::get()->where("status", true)->toArray();

        return view('order.edit', compact('matiere', 'order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $status)
    { 
        Order::where('id', $id)
              ->update([
                "status" => $status
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
    public function updateOrder(Request $request)
    { 
        Order::where('id', request('id'))->where('user_id', request('user_id'))
              ->update([
                'type_id'    => request('type_id'),
                'long'    => request('long'),
                'larg'    => request('larg'),
                'comment' => request('comment'),
                'unit'    => request('unit')
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
        $matiere = Type::get()->where("status", true)->toArray();

        return view('admin.order.edit', compact('matiere', 'order'));
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
