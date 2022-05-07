<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

    <link rel="stylesheet" href="https://fonts.sandbox.google.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md py-0 navbar-light bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="/images/signpub.png" height="40" alt="{{ config('app.name', 'Laravel') }}">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link px-4 py-3 fs-6 fw-bold {{ \Request::is('login') ? 'text-white border-bottom border-warning border-4' : 'text-secondary'}}" href="{{ route('login') }}"><span class="align-middle material-symbols-outlined">account_circle</span> {{ __('Se connecter') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link px-4 py-3 fs-6 fw-bold {{ \Request::is('register') ? 'text-white border-bottom border-warning border-4' : 'text-secondary'}}" href="{{ route('register') }}"><span class="align-middle material-symbols-outlined mx-1">person_add</span>{{ __('Créer un compte') }}</a>
                                </li>
                            @endif
                        @else
                            @if(auth()->user()->hasRole(\App\Models\UserRole::ROLE_ADMIN))
                                <li class="nav-item">
                                    <a href="{{ route('admin.user') }}" class="nav-link px-4 py-3 fs-6 fw-bold text-secondary" >Clients</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.user') }}" class="nav-link px-4 py-3 fs-6 fw-bold text-secondary" >Comptes</a>
                                </li>
                            @endif
                          
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link px-4 py-3 fs-6 fw-bold text-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @auth
            <div class="container">
            
                    <div class="row d-none">
                        <div class="col-md-12">
                            <div id="carouselExampleIndicators" class="carousel slide bg-secondary py-5 mt-3 mb-5" data-bs-ride="carousel">
                                  <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                  </div>
                                  <div class="carousel-inner">
                                    <div class="carousel-item active">
                                      <ul class="steps">
                                          <li class="step step-success">
                                            <div class="step-content">
                                              <span class="step-circle">1</span>
                                              <span class="step-text">Step 1</span>
                                            </div>
                                          </li>
                                          <li class="step step-active">
                                            <div class="step-content">
                                              <span class="step-circle">2</span>
                                              <span class="step-text">Step 2</span>
                                            </div>
                                          </li>
                                          <li class="step">
                                            <div class="step-content">
                                              <span class="step-circle">3</span>
                                              <span class="step-text">Step 3</span>
                                            </div>
                                          </li>
                                          <li class="step">
                                            <div class="step-content">
                                              <span class="step-circle"><span class="text-warning material-symbols-outlined">local_shipping</span></span>
                                              <span class="step-text">Step 4</span>
                                            </div>
                                          </li>
                                        </ul>
                                    </div>
                                    <div class="carousel-item">
                                      2
                                    </div>
                                    <div class="carousel-item">
                                      3
                                    </div>
                                  </div>
                                  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                  </button>
                                  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                  </button>
                            </div>
                        </div>
                    </div>
                </div>

                
                @endauth
            @yield('content')
        </main>
    </div>
</body>
</html>
