@extends('layouts.app')

@section('content')
@foreach(auth()->user()->notifications as $notification)
    @if($notification->data['order_id']== $order['id'])
     {{ $notification->markAsRead() }}
    @endif
@endforeach

<div class="container">
    <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Accueil</a></li>
        <li class="breadcrumb-item active" aria-current="page">Commande #{{$order["id"]}}</li>
      </ol>
    </nav>
    <div class="row">
        <div class="col-md-12">
            <div class="h2  text-warning border-bottom border-warning border-2 mb-4">Commande n° <?= $order["id"] ?></div>
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <admin-order-edit
                    :list-matiere='@json($matiere)' 
                    :data-order='@json($order)'
                    route={{route('order.update')}}
                    url-back={{route('home')}}
            >
            </admin-order-edit>
        </div>
    </div>
</div>      
@endsection