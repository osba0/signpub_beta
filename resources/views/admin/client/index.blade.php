@extends('layouts.app')

@section('content')
<div class="container">
    @if(auth()->user()->hasRole(\App\Models\UserRole::ROLE_ADMIN))
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h3 class="text-warning border-bottom border-warning border-2 mb-4 text-nowrap">Liste des Clients</h3>
            </div>
            <div class="col-md-12">
                <client-data-table url="{{ route('client.list') }}">
                </client-data-table>
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
