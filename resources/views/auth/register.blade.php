@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 bg-transparent">
                <div class="card-header py-3 bg-transparent fw-bold fs-4 border-2 border-warning text-warning">{{ __('Formulaire de création de compte') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Type de compte') }}</label>

                            <div class="col-md-6 d-flex align-items-center">
                                <div class="bg-light px-2 rounded me-3 d-flex">
                                    <input id="particulier" type="radio" class="form-check-input" name="type-compte"> 
                                    <label class="form-check-label fw-light ps-2" for="particulier">
                                        Particulier
                                    </label>  
                                </div>
                                <div class="bg-light px-2 rounded me-3 d-flex">
                                    <input id="revendeur" type="radio" class="form-check-input" name="type-compte">
                                    <label class="form-check-label fw-light ps-2" for="revendeur">
                                        Revendeur
                                    </label>   
                                </div>
                                <div class="bg-light px-2 rounded me-3 d-flex">
                                    <input id="entreprise" type="radio" class="form-check-input" name="type-compte">
                                    <label class="form-check-label fw-light ws-nowrap ps-2" for="entreprise">
                                        Entreprise / Association
                                    </label>   
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nom & Prénom') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                         

                         <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Téléphone') }}</label>

                            <div class="col-md-6 d-flex">  
                                <div class="col-3">
                                    <div class="input-group-desc">
                                    <input class="form-control" type="text" name="area_code">
                                    <label class="fw-light fs-6">Indicatif</label>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="input-group-desc ps-2">
                                    <input class="form-control" type="text" name="phone">
                                    <label class="fw-light fs-6">Numéro de téléphone</label>
                                    </div>
                                </div>
                                   
                            </div>
                          
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Mot de passe') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirmer le mot de passe') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Créer le compte') }}
                                </button>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6 offset-md-4">
                                <a href="/login" class="btn text-warning">
                                    <span class="material-symbols-outlined align-middle">arrow_back</span> {{ __('Retour à la page de login') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
