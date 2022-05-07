@extends('layouts.app')

@section('content')
<div class="container">
    @if(auth()->user()->hasRole(\App\Models\UserRole::ROLE_SECRETARIAT)) 
    <div class="row mb-4">
        <div class="col-12 col-sm-6 col-xxl-4 d-flex">
            <div class="illustration flex-fill card border border-warning border-3">
                <div class="p-0 d-flex flex-fill card-body">
                    <div class="g-0 w-100 row">
                        <div class="col-6"><div class="illustration-text p-3 m-1">
                            <h4 class="illustration-text">Bienvenu(e), <br> <?= auth()->user()->name ?></h4>
                            <p class="mb-0 text-warning fw-bold">SECRETARIAT</p></div>
                        </div>
                        <div class="align-self-center justify-content-center text-center col-6 fs-80">
                            <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xxl-4 d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h3 class="mb-2">{{ $countNewOrder }}</h3>
                            <p class="mb-2">En cours de validation</p>
                            <div class="mb-0">
                                <a href="#" class="text-warning">Afficher</a>
                            </div>
                        </div>
                        <div class="d-inline-block ms-3">
                            <div class="stat border d-flex align-items-center justify-content-center border-3 border-warning">
                               <span class="text-warning material-symbols-outlined">timer</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xxl-4 d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h3 class="mb-2">{{ $countDone }}</h3>
                            <p class="mb-2">Prête pour livraison</p>
                            <div class="mb-0">
                               <a href="#" class="text-warning">Afficher</a>
                            </div>
                        </div>
                        <div class="d-inline-block ms-3">
                            <div class="stat border d-flex align-items-center justify-content-center border-3 border-warning">
                                <span class="text-warning material-symbols-outlined">local_shipping</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if(auth()->user()->hasRole(\App\Models\UserRole::ROLE_SALLE_TIRAGE_ROULEAU) || auth()->user()->hasRole(\App\Models\UserRole::ROLE_SALLE_TIRAGE_FEUILLE) || auth()->user()->hasRole(\App\Models\UserRole::ROLE_SALLE_DECOUPE)) 
    <div class="row mb-4">
        <div class="col-12 col-sm-6 col-xxl-4 d-flex">
            <div class="illustration flex-fill card border border-info border-3">
                <div class="p-0 d-flex flex-fill card-body">
                    <div class="g-0 w-100 row">
                        <div class="col-6"><div class="illustration-text p-3 m-1">
                            <h4 class="illustration-text">Bienvenu(e), <br> <?= auth()->user()->name ?></h4>
                            <p class="mb-0 text-info fw-bold">SALLE DE TIRAGE</p></div>
                        </div>
                        <div class="align-self-center justify-content-center text-center col-6 fs-80">
                            <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xxl-4 d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h3 class="mb-2">{{ $countPrint }}</h3>
                            <p class="mb-2">En Salle de tirage</p>
                            <div class="mb-0">
                                <a href="#" class="text-info">Afficher</a>
                            </div>
                        </div>
                        <div class="d-inline-block ms-3">
                            <div class="stat border d-flex align-items-center justify-content-center border-3 border-info">
                               <span class="text-info material-symbols-outlined">print</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xxl-4 d-flex">
          
        </div>
    </div>
    @endif

    @if(auth()->user()->hasRole(\App\Models\UserRole::ROLE_FINITION)) 
    <div class="row mb-4">
        <div class="col-12 col-sm-6 col-xxl-4 d-flex">
            <div class="illustration flex-fill card border border-success border-3">
                <div class="p-0 d-flex flex-fill card-body">
                    <div class="g-0 w-100 row">
                        <div class="col-6"><div class="illustration-text p-3 m-1">
                            <h4 class="illustration-text">Bienvenu(e), <br> <?= auth()->user()->name ?></h4>
                            <p class="mb-0 text-success fw-bold">SALLE DE FINITION</p></div>
                        </div>
                        <div class="align-self-center justify-content-center text-center col-6 fs-80">
                            <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xxl-4 d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h3 class="mb-2">{{ $countFinition }}</h3>
                            <p class="mb-2">En Salle de finition</p>
                            <div class="mb-0">
                                <a href="#" class="text-success">Afficher</a>
                            </div>
                        </div>
                        <div class="d-inline-block ms-3">
                            <div class="stat border d-flex align-items-center justify-content-center border-3 border-success">
                               <span class="text-success material-symbols-outlined">palette</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xxl-4 d-flex">
          
        </div>
    </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-12">


            @if(auth()->user()->hasRole(\App\Models\UserRole::ROLE_ADMIN))  
                You are Admin.
            
            @else
           
                <order-list-data-table 
                :order-status='@json($status ?? "")'  
                :value-status = {{ $validationStatus }}
                :current-status = {{ $actualStatus }}
                :attente-livraison = {{ \App\Models\StatusOrder::ATTENTE_POUR_LIVRAISON }}
                :order-livre = {{ \App\Models\StatusOrder::LIVRE }}
                :can-edit = {{ $canEdit }}
                url="{{ route('orders') }}"
                >
                </order-list-data-table>
          
            @endif
        </div>
    </div>
</div>
@endsection
