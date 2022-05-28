@extends('layouts.app')

@section('content')

<div class="container">
    <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Accueil</a></li>
        <li class="breadcrumb-item active" aria-current="page">Mon Compte</li>
      </ol>
    </nav>
    <div class="row">
        <div class="col-md-12">
            <div class="h2  text-warning border-bottom border-warning border-2 mb-4">Mon Compte</div>
           
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <account-user
                    :data-user='@json($data)'
                    route={{route('user.update')}}
                    :is-admin='{{$is_admin}}'
            >
            </account-user>
        </div>
    </div>
</div>      
@endsection