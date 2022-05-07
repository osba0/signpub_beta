@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="h2">Formulaire de commande</div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <order-create-edit
                    :list-matiere='@json($matiere)' 
                    route={{route('order.store')}}
                    url-back={{route('home')}}
            >
            </order-create-edit>
        </div>
    </div>
</div>      
@endsection