@extends('layouts.app')

@section('content')
<div class="container">
    @if(auth()->user()->hasRole(\App\Models\UserRole::ROLE_ADMIN))
      
    <statistique-surface-tireur url-back="{{ route('statistique.index') }}" :list-tireurs='@json($tireurs)'  :id-tireurs='@json($tireursID)'>
        
    </statistique-surface-tireur>
      
    @else
    <div class="row">
        <div class="col-md-12">
            <div class="badge bg-danger">Accés non autorisé!</div>
        </div>
    </div>
    @endif
</div>
@endsection
