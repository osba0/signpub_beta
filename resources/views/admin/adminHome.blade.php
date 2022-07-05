@extends('layouts.app')

@section('content')
<div class="container">
    @if(auth()->user()->hasRole(\App\Models\UserRole::ROLE_ADMIN))
     <div class="row mb-4 dasboard-client">
        <div class="col-12 col-sm-12 col-xxl-4 d-flex">
            <div class="illustration flex-fill card">
                <div class="p-0 d-flex flex-fill card-body">
                    <div class="g-0 w-100 row">
                        <div class="col-6"><div class="illustration-text p-3 m-1">
                            <h4 class="illustration-text">Bienvenu(e), <br> <?= auth()->user()->name ?></h4>
                            <p class="mb-0 text-danger fw-bold">Administrateur</p></div>
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
                            <h3 class="mb-2">{{ str_pad($totalOrder, 2, '0', STR_PAD_LEFT) }}</h3>
                            <p class="mb-2 fs-4 fw-light">Total Commandes</p>
                            <div class="mb-0">
                                <a href="#" class="text-warning d-none">Afficher</a>
                            </div>
                        </div>
                        <div class="d-inline-block ms-3">
                            <div class="stat d-flex align-items-center justify-content-center border-3 border-warning">
                               <span class="text-warning material-symbols-outlined">receipt_long</span>
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
                            <h3 class="mb-2">{{ str_pad($totalClient, 2, '0', STR_PAD_LEFT) }}</h3>
                            <p class="mb-2 fs-4 fw-light">Total clients</p>
                            <div class="mb-0">
                               <a href="/admin/clients" class="text-warning">Afficher</a>
                            </div>
                        </div>
                        <div class="d-inline-block ms-3">
                            <div class="stat  d-flex align-items-center justify-content-center border-3 border-warning">
                                <span class="text-warning material-symbols-outlined">group</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
    </div>
     <div class="row mb-4 dasboard-client">
         <div class="col-12 col-sm-6 col-xxl d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h3 class="mb-2">{{ $countNewOrder }}</h3>
                            <p class="mb-2 mt-3 fw-normal fs-6">En cours de validation</p>
                            <div class="mb-0">
                                <a href="#" class="text-warning d-none">Afficher</a>
                            </div>
                        </div>
                        <div class="d-inline-block ms-3 statePosition position-absolute">
                            <div class="stat d-flex align-items-center justify-content-center border-warning">
                               <span class="text-warning material-symbols-outlined">timer</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xxl d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h3 class="mb-2">{{ $countPrint }}</h3>
                            <p class="mb-2 fw-normal mt-3 fs-6">En salle de Tirage</p>
                            <div class="mb-0">
                                <a href="#" class="text-warning d-none">Afficher</a>
                            </div>
                        </div>
                        <div class="d-inline-block ms-3 statePosition position-absolute">
                            <div class="stat  d-flex align-items-center justify-content-center  border-warning">
                               <span class="text-warning material-symbols-outlined">print</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xxl d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h3 class="mb-2">{{ $countImpressionDirecte }}</h3>
                            <p class="mb-2 fw-normal mt-3 fs-6">Impression Directe</p>
                            <div class="mb-0">
                                <a href="#" class="text-warning d-none">Afficher</a>
                            </div>
                        </div>
                        <div class="d-inline-block ms-3 statePosition position-absolute">
                            <div class="stat  d-flex align-items-center justify-content-center  border-warning">
                               <span class="text-warning material-symbols-outlined">format_color_fill</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <div class="col-12 col-sm-6 col-xxl d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h3 class="mb-2">{{ $countDecoupe }}</h3>
                            <p class="mb-2 fw-normal mt-3 fs-6">En salle de Découpe</p>
                            <div class="mb-0">
                                <a href="#" class="text-warning d-none">Afficher</a>
                            </div>
                        </div>
                        <div class="d-inline-block ms-3 statePosition position-absolute">
                            <div class="stat  d-flex align-items-center justify-content-center  border-warning">
                               <span class="text-warning material-symbols-outlined">cut</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xxl d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h3 class="mb-2">{{ $countDone }}</h3>
                            <p class="mb-2 fw-normal mt-3 fs-6">En Finition</p>
                            <div class="mb-0">
                               <a href="#" class="text-warning d-none">Afficher</a>
                            </div>
                        </div>
                        <div class="d-inline-block ms-3">
                            <div class="stat d-flex align-items-center justify-content-center border-warning">
                                <span class="text-warning material-symbols-outlined">palette</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
        <div class="col-12 col-sm-6 col-xxl d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h3 class="mb-2">{{ $countDone }}</h3>
                            <p class="mb-2 fw-normal mt-3 fs-6">Prête pour livraison</p>
                            <div class="mb-0">
                               <a href="#" class="text-warning d-none">Afficher</a>
                            </div>
                        </div>
                        <div class="d-inline-block ms-3 statePosition position-absolute">
                            <div class="stat d-flex align-items-center justify-content-center border-warning">
                                <span class="text-warning material-symbols-outlined">local_shipping</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
    </div>
    @endif
    @if(auth()->user()->hasRole(\App\Models\UserRole::ROLE_SECRETARIAT)) 
    <div class="row mb-4 dasboard-client">
        <div class="col-12 col-sm-6 col-xxl-4 d-flex">
            <div class="illustration flex-fill card">
                <div class="p-0 d-flex flex-fill card-body">
                    <div class="g-0 w-100 row">
                        <div class="col-6">
                            <div class="illustration-text p-3 m-1">
                                <h4 class="illustration-text">Bienvenu(e), <br> <?= auth()->user()->name ?></h4>
                                <span class="fs-6 fw-light">Poste</span>
                                <p class="mb-0 text-warning fw-bold">SECRETARIAT</p>
                            </div>
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
                            <p class="mb-2 fw-light fs-4">En cours de validation</p>
                            <div class="mb-0">
                                <a href="#" class="text-warning d-none">Afficher</a>
                            </div>
                        </div>
                        <div class="d-inline-block ms-3">
                            <div class="stat d-flex align-items-center justify-content-center border-warning">
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
                            <p class="mb-2 fw-light fs-4">Prête pour livraison</p>
                            <div class="mb-0">
                               <a href="#" class="text-warning d-none">Afficher</a>
                            </div>
                        </div>
                        <div class="d-inline-block ms-3">
                            <div class="stat d-flex align-items-center justify-content-center">
                                <span class="text-warning material-symbols-outlined">local_shipping</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
    </div>
    @endif
    @if(auth()->user()->hasRole(\App\Models\UserRole::ROLE_SALLE_TIRAGE_ROULEAU) || auth()->user()->hasRole(\App\Models\UserRole::ROLE_SALLE_TIRAGE_FEUILLE)) 
    <div class="row mb-4 dasboard-client">
        <div class="col-12 col-sm-12 col-xxl-4 d-flex">
            <div class="illustration flex-fill card">
                <div class="p-0 d-flex flex-fill card-body">
                    <div class="g-0 w-100 row">
                        <div class="col-6">
                            <div class="illustration-text p-3 m-1">
                                <h4 class="illustration-text">Bienvenu(e), <br> <?= auth()->user()->name ?></h4>
                                <span class="fs-6 fw-light">Poste</span>
                                 <p class="mb-0 fw-bold">SALLE DE TIRAGE</p>
                            </div>
                        </div>
                        <div class="align-self-center justify-content-center text-center col-6 fs-80">
                            <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-xxl-4 d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h3 class="mb-2">{{ $countPrint }}</h3>
                            <p class="mb-2 fw-light fs-4">En Salle de tirage</p>
                            <div class="mb-0">
                                <a href="#" class="text-info d-none">Afficher</a>
                            </div>
                        </div>
                        <div class="d-inline-block ms-3">
                            <div class="stat d-flex align-items-center justify-content-center ">
                               <span class="text-warning material-symbols-outlined">print</span>
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

    @if(auth()->user()->hasRole(\App\Models\UserRole::ROLE_SALLE_DECOUPE)) 

    <div class="row mb-4 dasboard-client">
        <div class="col-12 col-sm-12 col-xxl-4 d-flex">
            <div class="illustration flex-fill card">
                <div class="p-0 d-flex flex-fill card-body">
                    <div class="g-0 w-100 row">
                        <div class="col-6">
                            <div class="illustration-text p-3 m-1">
                                <h4 class="illustration-text">Bienvenu(e), <br> <?= auth()->user()->name ?></h4>
                                <span class="fs-6 fw-light">Poste</span>
                                 <p class="mb-0 fw-bold text-uppercase">SALLE DE Découpe</p>
                            </div>
                        </div>
                        <div class="align-self-center justify-content-center text-center col-6 fs-80">
                            <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-xxl-4 d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h3 class="mb-2">{{ $countDecoupe }}</h3>
                            <p class="mb-2 fw-normal fs-4">En Salle de découpe</p>
                            <div class="mb-0">
                                <a href="#" class="text-info d-none">Afficher</a>
                            </div>
                        </div>
                        <div class="d-inline-block ms-3">
                            <div class="stat d-flex align-items-center justify-content-center ">
                               <span class="text-warning material-symbols-outlined">cut</span>
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

     @if(auth()->user()->hasRole(\App\Models\UserRole::ROLE_IMPRESSION_DIRECTE)) 

    <div class="row mb-4 dasboard-client">
        <div class="col-12 col-sm-12 col-xxl-4 d-flex">
            <div class="illustration flex-fill card">
                <div class="p-0 d-flex flex-fill card-body">
                    <div class="g-0 w-100 row">
                        <div class="col-6">
                            <div class="illustration-text p-3 m-1">
                                <h4 class="illustration-text">Bienvenu(e), <br> <?= auth()->user()->name ?></h4>
                                <span class="fs-6 fw-light">Poste</span>
                                 <p class="mb-0 fw-bold text-uppercase">Impression directe</p>
                            </div>
                        </div>
                        <div class="align-self-center justify-content-center text-center col-6 fs-80">
                            <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-xxl-4 d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h3 class="mb-2">{{ $countImpressionDirecte }}</h3>
                            <p class="mb-2 fw-normal fs-4">Impression directe</p>
                            <div class="mb-0">
                                <a href="#" class="text-info d-none">Afficher</a>
                            </div>
                        </div>
                        <div class="d-inline-block ms-3">
                            <div class="stat d-flex align-items-center justify-content-center ">
                               <span class="text-warning material-symbols-outlined">format_color_fill</span>
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
    <div class="row mb-4 dasboard-client">
        <div class="col-12 col-sm-12 col-xxl-4 d-flex">
            <div class="illustration flex-fill card">
                <div class="p-0 d-flex flex-fill card-body">
                    <div class="g-0 w-100 row">
                        <div class="col-6"><div class="illustration-text p-3 m-1">
                            <h4 class="illustration-text">Bienvenu(e), <br> <?= auth()->user()->name ?></h4>
                            <span class="fs-6 fw-light">Poste</span>
                            <p class="mb-0 fw-bold">SALLE DE FINITION</p></div>
                        </div>
                        <div class="align-self-center justify-content-center text-center col-6 fs-80">
                            <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-xxl-4 d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h3 class="mb-2">{{ $countFinition }}</h3>
                            <p class="mb-2 fw-normal fs-4">En Salle de finition</p>
                            <div class="mb-0">
                                <a href="#" class="text-success d-none">Afficher</a>
                            </div>
                        </div>
                        <div class="d-inline-block ms-3">
                            <div class="stat d-flex align-items-center justify-content-center">
                               <span class="text-warning material-symbols-outlined">palette</span>
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
    
    <div class="row mb-3">
        <div class="col-md-12">
            <h3 class="text-warning border-bottom border-warning border-2">Commandes en cours</h3>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
                <order-list-data-table 
                :order-status='@json($status ?? "")'  
                :value-status = {{ $validationStatus }}
                :current-status = {{ $actualStatus }}
                :attente-livraison = {{ \App\Models\StatusOrder::ATTENTE_POUR_LIVRAISON }}
                :order-livre = {{ \App\Models\StatusOrder::LIVRE }}
                :can-edit = {{ $canEdit }}
                :is-admin = {{ $isAdmin }}
                url="{{ route('orders') }}"
                :can-fitre-status={{ $canFiltreStatus }}
                >
                </order-list-data-table>
        </div>
    </div>
</div>
@endsection
