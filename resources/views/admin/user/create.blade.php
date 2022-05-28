@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-12">
            <h3 class="text-warning border-bottom border-warning border-2">Créer un nouvel utilisateur</h3>
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