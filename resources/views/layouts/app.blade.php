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
                                    <a class="nav-link px-4 py-4 fs-6 fw-bold {{ \Request::is('login') ? 'text-white border-bottom border-warning border-4' : 'text-secondary'}}" href="{{ route('login') }}"><span class="align-middle material-symbols-outlined">account_circle</span> {{ __('Se connecter') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link px-4 py-4 fs-6 fw-bold {{ \Request::is('register') ? 'text-white border-bottom border-warning border-4' : 'text-secondary'}}" href="{{ route('register') }}"><span class="align-middle material-symbols-outlined mx-1">person_add</span>{{ __('Créer un compte') }}</a>
                                </li>
                            @endif
                        @else
                            @if(auth()->user()->hasRole(\App\Models\UserRole::ROLE_ADMIN))
                                <li class="nav-item">
                                    <a href="{{ route('admin.user') }}" class="nav-link px-4 py-4 fs-6 fw-bold text-secondary" >Clients</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.user') }}" class="nav-link px-4 py-4 fs-6 fw-bold text-secondary" >Comptes</a>
                                </li>
                            @endif
                          
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link px-4 py-4 fs-6 fw-bold text-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
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

         <footer  class="text-center text-lg-start text-white bg-dark border-top border-4 border-warning">
            <!-- Grid container -->
            <div class="container p-4 pb-0">
              <!-- Section: Links -->
              <section class="">
                <!--Grid row-->
                <div class="row">
                  <!-- Grid column -->
                  <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h6 class="mb-4 font-weight-bold fw-bold fs-4 text-warning">
                      SignApp
                    </h6>
                    <p>
                     La supervision de vos commandes est facile lorsque vous avez cette application à votre service. 
                    </p>
                  </div>
                  <!-- Grid column -->

                  <hr class="w-100 clearfix d-md-none" />

                  <!-- Grid column -->
                  <div class="col-md-3 mb-md-0 mb-4 d-flex">
                    <div class="con con-1 w-100 py-5">
                        <div class="con-info w-100 text-center">
                            <div class="icon d-flex align-items-center justify-content-center">
                                <div class="stat d-flex align-items-center justify-content-center bg-warning">
                                    <span class="material-symbols-outlined fs-1">call</span>
                                </div>
                                
                            </div>
                            <div class="text pt-3">
                            <span class="h6">(+221) 77 567 03 62</span>
                            </div>
                        </div>
                    </div>
                </div>
                  <!-- Grid column -->

                  <hr class="w-100 clearfix d-md-none" />

                  <!-- Grid column -->
                  <div class="col-md-3 mb-md-0 mb-4 d-flex border-secondary border-start border-end border-1">
                        <div class="con con-2 w-100 py-5">
                            <div class="con-info w-100 text-center">
                                <div class="icon d-flex align-items-center justify-content-center">
                                    <div class="stat d-flex align-items-center justify-content-center bg-warning">
                                       <span class="material-symbols-outlined fs-1">mail</span>
                                   </div>
                                </div>
                                <div class="text pt-3">
                                    <span class="h6">info@signpub.sn</span>
                                </div>
                            </div>
                        </div>
                    </div>

                  <!-- Grid column -->
                  <hr class="w-100 clearfix d-md-none" />

                  <!-- Grid column -->
          
                    <div class="col-md-3 mb-md-0 mb-4 d-flex">
                        <div class="con con-3 w-100 py-5">
                            <div class="con-info w-100 text-center">
                                <div class="icon d-flex align-items-center justify-content-center">
                                    <div class="stat d-flex align-items-center justify-content-center bg-warning">
                                        <span class="material-symbols-outlined fs-1">pin_drop</span>
                                    </div>
                                </div>
                                <div class="text pt-3">
                                    <span class="h6">Rue 5 Fass, Dakar - SENEGAL</span>
                                </div>
                            </div>
                        </div>
                    </div>
                  
                  <!-- Grid column -->
                </div>
                <!--Grid row-->
              </section>
              <!-- Section: Links -->

              <hr class="my-3">

              <!-- Section: Copyright -->
              <section class="p-3 pt-0">
                <div class="row d-flex align-items-center">
                  <!-- Grid column -->
                  <div class="col-md-7 col-lg-8 text-center text-md-start">
                    <!-- Copyright -->
                    <div class="p-3">
                      © {{ now()->year }} Copyright:
                      <a class="text-white" href="https://mdbootstrap.com/"
                         >SignPub</a
                        >
                    </div>
                    <!-- Copyright -->
                  </div>
                  <!-- Grid column -->

                  <!-- Grid column -->
                  <div class="col-md-5 col-lg-4 ml-lg-0 text-center text-md-end">
                    Made by OSBA
                  </div>
                  <!-- Grid column -->
                </div>
              </section>
              <!-- Section: Copyright -->
            </div>
    <!-- Grid container -->
  </footer>
    </div>
</body>
</html>
