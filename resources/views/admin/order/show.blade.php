@extends('layouts.app')


@section('content')
   @foreach(auth()->user()->notifications as $notification)
        @if($notification->data['order_id']== $data['id'])
         {{ $notification->markAsRead() }}
        @endif
    @endforeach
    <div class="container">
          <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Accueil</a></li>
            <li class="breadcrumb-item active" aria-current="page">Commande #{{$data["id"]}}</li>
          </ol>
        </nav>
        <div class="row">
            <div class="col-md-12">
                <order-show :order-data='@json($data)'
                :order-status='@json($status ?? "")'  
                :order-logs= '@json($orderLogs)'
                :status-log = '@json($statusLog)'
                :isdecoupe-order = {{$isdecoupe}} 
                :isimpression-order = {{$isimpression}} 
                >
                </order-show>
            </div>
        </div>
    </div>
   
@endsection
