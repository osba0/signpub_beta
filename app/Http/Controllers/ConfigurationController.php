<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Type;
use App\Http\Resources\TypeCollection;

class ConfigurationController extends Controller
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
        return view('admin.config.index');
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getListMatiere(Request $request)
    {
        $user = Auth::user();

        $length = $request->input('length');
        $sortBy = $request->input('column');
        $typeBy = $request->input('dir');
        $searchValue = $request->input('search');

        $query = Type::eloquentQuery($sortBy, $typeBy, $searchValue);

        $types = $query->paginate($length);

        return new TypeCollection($types);
    }

    public function updateOther(Request $request){
     

       $updateAll =  Type::where('isOther', 1)->update([
                'isOther'    => 0
               ]);

     
              Type::where('id', request('id'))->update([
            'isOther'    => 1
           ]);
      
      

        return response([
            "code" => 0,
            "message" => "OK"
        ]);
    }

    public function store(Request $request){

       $matiere = Type::create([
         'name' => request('name'),
         'status' => 1,
         'isOther' => 0
       ]);
       if($matiere){
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

     public function updateStatusMatiere(Request $request){
     
        $resp = Type::where('id', request('id'))->update([
            'status'    => request('status')
        ]);

        if($resp){

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


    public function deleteMatiere(Request $request){
     
        $resp = Type::where('id', request('id'))->delete();

        if($resp){

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
