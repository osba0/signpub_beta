@extends('layouts.app')

@section('content')
<div class="container">
    @if(auth()->user()->hasRole(\App\Models\UserRole::ROLE_ADMIN))
       
        <matiere-data-table url="{{ route('matiere.list') }}" url-back="{{ route('config.index') }}" :traitement-matiere='@json($traitementMatieres)'></matiere-data-table>
      
    @else
    <div class="row">
        <div class="col-md-12">
            <div class="badge bg-danger">Accés non autorisé!</div>
        </div>
    </div>
    @endif
</div>
@endsection
