@extends('layouts.app')

@section('content')
<div class="container">
    
    @if(auth()->user()->hasRole(\App\Models\UserRole::ROLE_ADMIN))
        <div class="row">
            <div class="col-md-9">
                <h3 class="text-warning border-bottom border-warning border-2 mb-4">Liste des Employés</h3>
            </div>
            <div class="col-md-3 text-end mb-3">
                <a href="{{ route('user.create') }}" class="btn btn-primary text-nowrap"><span class="material-symbols-outlined align-middle">add</span>  Créer un nouveau compte</a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <user-data-table url="{{ route('user.list') }}">
                </user-data-table>
            </div>
        </div>
    @else
    <div class="row">
        <div class="col-md-12">
            <div class="badge bg-danger">Accés non autorisé!</div>
        </div>
    </div>
    @endif
</div>
@endsection
