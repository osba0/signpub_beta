@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="h2">Créer un nouvel utilisateur</div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <user-create-edit
                    :user-roles='@json($roles)'
                    route={{route('user.store')}}
                    url-back={{route('admin.user')}}
            >
            </user-create-edit>
        </div>
    </div>
</div>      
@endsection