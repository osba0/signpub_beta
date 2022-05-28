@extends('layouts.app')

@section('content')
<div class="container">
    <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Mes commandes</a></li>
        <li class="breadcrumb-item active" aria-current="page">Nouvelle commande</li>
      </ol>
    </nav>
    <div class="row">
        <div class="col-md-12">
            <div class="h3 text-warning border-bottom border-warning border-2 mb-4">Formulaire de commande</div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <order-create-edit
                    :list-matiere='@json($matiere)' 
                    route={{route('order.store')}}
                    url-back={{route('order.create')}}
            >
            </order-create-edit>
        </div>
    </div>
</div>      
@endsection