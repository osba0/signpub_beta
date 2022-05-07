@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12 col-sm-6 col-xxl-3 d-flex">
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
        <div class="col-12 col-sm-6 col-xxl-3 d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h3 class="mb-2">{{ $countPrint }}</h3>
                            <p class="mb-2">En salle de Tirage</p>
                            <div class="mb-0">
                                <a href="#" class="text-warning">Afficher</a>
                            </div>
                        </div>
                        <div class="d-inline-block ms-3">
                            <div class="stat border d-flex align-items-center justify-content-center border-3 border-warning">
                               <span class="text-warning material-symbols-outlined">print</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xxl-3 d-flex">
            <div class="card flex-fill">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h3 class="mb-2">{{ $countFinition }}</h3>
                            <p class="mb-2">En finition</p>
                            <div class="mb-0">
                               <a href="#" class="text-warning">Afficher</a>
                            </div>
                        </div>
                        <div class="d-inline-block ms-3">
                            <div class="stat border d-flex align-items-center justify-content-center border-3 border-warning">
                               <span class="text-warning material-symbols-outlined">palette</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xxl-3 d-flex">
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
    <div class="row mb-3">
        <div class="col-md-9">
            <h3 class="text-warning border-bottom border-warning border-2">Historique</h3>
        </div>
        <div class="col-md-3 text-end">
            <a href="{{ route('order.create') }}" class="btn btn-success">Nouvel commande</a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <order-data-table 
            :order-status='@json($status)' 
            url="{{ route('order.list') }}"
            :order-inite = {{ \App\Models\StatusOrder::INITIE }}>
            </order-data-table>
        </div>
    </div>
</div>
@endsection
