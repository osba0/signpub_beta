<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="/images/favicon2.png">
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
        <nav class="navbar navbar-expand-md py-0 navbar-light bg-white shadow-sm">
            <div class="container position-relative">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="/images/signpub.png" height="40" alt="{{ config('app.name', 'Laravel') }}">
                </a>
                @auth
                    <button id="notif" type="button" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre class="outline-none btn btn-transparent ms-0 py-0 pe-0 position-absolute d-md-none d-lg-none d-xxl-none d-xs-block notifMobile">
                      <span class="material-symbols-outlined">notifications</span><span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        @if(auth()->user()->unreadNotifications->count()>=10)
                        10+
                        @else
                        {{ auth()->user()->unreadNotifications->count()}}
                        @endif
                       <span class="visually-hidden">unread messages</span>
                    
                    </button>
                   
                    @include('layouts.notification') 
                @endauth
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
                                    <a class="nav-link px-4 py-3 fs-6 fw-bold {{ \Request::is('login') ? 'text-dark border-bottom border-warning border-4' : 'text-secondary'}}" href="{{ route('login') }}"><span class="align-middle material-symbols-outlined">account_circle</span> {{ __('Se connecter') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link px-4 py-3 fs-6 fw-bold {{ \Request::is('register') ? 'text-dark border-bottom border-warning border-4' : 'text-secondary'}}" href="{{ route('register') }}"><span class="align-middle material-symbols-outlined mx-1">person_add</span>{{ __('Créer un compte') }}</a>
                                </li>
                            @endif
                        @else
                            @if(auth()->user()->hasRole(\App\Models\UserRole::ROLE_ADMIN))
                                <li class="nav-item border-start border-end">
                                    <a href="{{ url('/') }}" class="nav-link px-4 py-3 fs-6 fw-bold {{ \Request::is('admin/home') ? 'text-dark border-4 border-bottom border-warning ' : 'text-secondary'}}" ><!--span class="material-symbols-outlined align-middle">team_dashboard</span--> Tableau de bord</a>
                                </li>
                                <li class="nav-item border-end">
                                    <a href="{{ route('statistique.index') }}" class="nav-link px-4 py-3 fs-6 fw-bold {{ \Request::is('admin/statistique') ? 'text-dark border-bottom border-warning border-4' : 'text-secondary'}}" ><!--span class="material-symbols-outlined align-middle">equalizer</span-->Statistiques</a>
                                </li>
                                <li class="nav-item border-start border-end">
                                    <a href="{{ route('index.client') }}" class="nav-link px-4 py-3 fs-6 fw-bold {{ \Request::is('admin/clients') ? 'text-dark border-4 border-bottom border-warning ' : 'text-secondary'}}" ><!--span class="material-symbols-outlined align-middle">settings_accessibility</span-->Clients</a>
                                </li>
                                <li class="nav-item border-end">
                                    <a href="{{ route('admin.user') }}" class="nav-link px-4 py-3 fs-6 fw-bold {{ \Request::is('admin/users') ? 'text-dark border-bottom border-warning border-4' : 'text-secondary'}}" ><!--span class="material-symbols-outlined align-middle">supervised_user_circle</span-->Employés</a>
                                </li>
                                <li class="nav-item border-end">
                                    <a href="{{ route('config.index') }}" class="nav-link px-4 py-3 fs-6 fw-bold {{ \Request::is('admin/config') ? 'text-dark border-bottom border-warning border-4' : 'text-secondary'}}" ><!--span class="material-symbols-outlined align-middle">settings</span-->Configuration</a>
                                </li>
                            @endif
                            @auth
                             <li class="nav-item d-flex align-items-center dropdown hidden-xs">
                                <button id="notif" type="button" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre class="outline-none btn btn-transparent ms-0 py-0 pe-0 position-relative hidden-xs">
                                  <span class="material-symbols-outlined">notifications</span><span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    @if(auth()->user()->unreadNotifications->count()>=10)
                                    10+
                                    @else
                                    {{ auth()->user()->unreadNotifications->count()}}
                                    @endif
                                   <span class="visually-hidden">unread messages</span>
                                
                                </button>
                                @include('layouts.notification') 
                            </li>
                           
                            @endauth
                          
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link px-4 py-3 fs-6 fw-bold text-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                   {{ Auth::user()->name }}  <span class="material-symbols-outlined align-middle">account_circle</span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a href="{{ route('user.profil') }}" class="dropdown-item border-bottom pb-2">
                                        <span class="material-symbols-outlined align-middle">account_box</span> Mon Compte</a>
                                    <a href="/change-password" class="dropdown-item border-bottom py-2">
                                        <span class="material-symbols-outlined align-middle">key</span>  Modifier Mot de passe</a>
                                    <a class="dropdown-item pt-2" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <span class="material-symbols-outlined align-middle">logout</span>  {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                             <li class="nav-item bg-light px-3">
                                    <a class="nav-link px-0 py-3 fs-6 fw-bold text-secondary" title="Déconnexion" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><span class="align-middle material-symbols-outlined">logout</span> {{ __('Déconnexion') }}</a>
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

         <footer  class="text-center text-lg-start text-secondary py-0 bg-light">
            <!-- Grid container -->
            <div class="container p-4 pb-0">
                 @guest
              <!-- Section: Links -->
              <section class="border-top border-2 border-secondary d-none">
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

              <hr class="my-3 d-none">
            @endguest
              <!-- Section: Copyright -->
              <section class="p-3 pt-0 border-top border-1 border-secondary">
                <div class="row d-flex align-items-center">
                  <!-- Grid column -->
                  <div class="col-md-7 col-lg-8 text-center text-md-start">
                    <!-- Copyright -->
                    <div class="p-3">
                      © {{ now()->year }} Copyright:
                      <a class="text-warning" href="#"
                         >SignPub</a
                        >
                    </div>
                    <!-- Copyright -->
                  </div>
                  <!-- Grid column -->

                  <!-- Grid column -->
                  <div class="col-md-5 col-lg-4 ml-lg-0 text-center text-md-end">
                        <!-- Button trigger modal -->
                    <button type="button" class="btn btn-transparent outline-none" data-bs-toggle="modal" data-bs-target="#credit">
                      Developed by OSBA
                    </button>
                    
                  </div>
                  <!-- Grid column -->
                </div>
              </section>
              <!-- Section: Copyright -->
            </div>
    <!-- Grid container -->
  </footer>
    </div>


<!-- Modal -->
<div class="modal fade" id="credit" tabindex="-1" aria-labelledby="creditLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="creditLabel">Crédits</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div>Ce site a été conçu et développé par OSBA.</div>
          <hr>
        <div><span class="material-symbols-outlined align-middle text-warning">call</span> +221 77 567-03-62</div>
        <hr>
         <div><span class="material-symbols-outlined align-middle text-warning">mail</span> osm.cre.dev@gmail.com</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>
