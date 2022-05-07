@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="h2">Commande n° <?= $order["id"] ?></div>
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <order-edit
                    :list-matiere='@json($matiere)' 
                    :data-order='@json($order)'
                    route={{route('order.update')}}
                    url-back={{route('home')}}
            >
            </order-edit>
        </div>
    </div>
</div>      
@endsection