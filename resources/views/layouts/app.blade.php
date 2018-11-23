<!doctype html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>@yield('title') | {{ getenv('APP_NAME') }}</title>
        <meta name="description" content="Dashboard UI Kit">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,600" rel="stylesheet">

        <!-- Favicon -->
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

        <!-- Stylesheet -->
        <link rel="stylesheet" href="/css/main.min.css?v=1.4">        
    </head>
    <body class="o-page">
        <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

        <div class="o-page__sidebar js-page-sidebar">
            <div class="c-sidebar">
                <a class="c-sidebar__brand" href="#">
                @if(!isset(Auth::user()->tipo))                        
                    {{ getenv('APP_NAME') }} Admin
                @endif
                @if(isset(Auth::user()->tipo))                        
                    {{ getenv('APP_NAME') }}
                @endif
                </a>
                
                <h4 class="c-sidebar__title">MENU</h4>
                <ul class="c-sidebar__list">

                    <li class="c-sidebar__item">
                        @if(!isset(Auth::user()->tipo))
                        <a class="c-sidebar__link" href="/admin/dashboard">
                            <i class="fa fa-home u-mr-xsmall"></i>Dashboard
                        </a>
                        @endif
                        @if(isset(Auth::user()->tipo) && Auth::user()->tipo == 0)
                        <a class="c-sidebar__link" href="/empresa/dashboard">
                            <i class="fa fa-home u-mr-xsmall"></i>Dashboard
                        </a>
                        @endif
                    </li>

                    @if(!isset(Auth::user()->tipo))
                    
                    <li class="c-sidebar__item">
                        <a class="c-sidebar__link" href="/admin/banners">
                            <i class="fa fa-file-image-o u-mr-xsmall"></i>Banners
                        </a>
                    </li>

                    <li class="c-sidebar__item">
                        <a class="c-sidebar__link" href="/admin/categorias-empresas">
                            <i class="fa fa-bars u-mr-xsmall"></i>Categorias de Empresas
                        </a>
                    </li>

                    <li class="c-sidebar__item">
                        <a class="c-sidebar__link" href="/admin/categorias">
                            <i class="fa fa-bars u-mr-xsmall"></i>Categorias de Produtos
                        </a>
                    </li>

                    <li class="c-sidebar__item">
                        <a class="c-sidebar__link" href="/admin/empresas">
                            <i class="fa fa-building u-mr-xsmall"></i>Empresas
                        </a>
                    </li>
                    
                    <li class="c-sidebar__item">
                        <a class="c-sidebar__link" href="/admin/usuarios">
                            <i class="fa fa-users u-mr-xsmall"></i>Usuários
                        </a>
                    </li>

                    <li class="c-sidebar__item">
                        <a class="c-sidebar__link" href="/admin/avaliacoes">
                            <i class="fa fa-comments u-mr-xsmall"></i>Avaliações
                        </a>
                    </li>

                    <li class="c-sidebar__item">
                        <a class="c-sidebar__link" href="/admin/mensagens">
                            <i class="fa fa-envelope u-mr-xsmall"></i>Mensagens
                        </a>
                    </li>

                    <li class="c-sidebar__item">
                        <a class="c-sidebar__link" href="/admin/notificar">
                            <i class="fa fa-bullhorn u-mr-xsmall"></i>Notificar
                        </a>
                    </li>
                                      
                    <li class="c-sidebar__item">
                        <a class="c-sidebar__link" href="/admin/configuracoes">
                            <i class="fa fa-cogs u-mr-xsmall"></i>Configurações
                        </a>
                    </li>
                    @endif

                    @if(isset(Auth::user()->tipo) && Auth::user()->tipo == 0)                    
                    <li class="c-sidebar__item">
                        <a class="c-sidebar__link" href="/empresa/consumidores">
                            <i class="fa fa-users u-mr-xsmall"></i>Consumidores
                        </a>
                    </li>
                     <li class="c-sidebar__item">
                        <a class="c-sidebar__link" href="/empresa/aniversariantes">
                            <i class="fa fa-birthday-cake u-mr-xsmall"></i>Aniversariantes
                        </a>
                    </li>
                    <li class="c-sidebar__item">
                        <a class="c-sidebar__link" href="/empresa/produtos">
                            <i class="fa fa-cubes u-mr-xsmall"></i>Produtos
                        </a>
                    </li>
                    <li class="c-sidebar__item">
                        <a class="c-sidebar__link" href="/empresa/premios">
                            <i class="fa fa-trophy u-mr-xsmall"></i>Prêmios
                        </a>
                    </li>
                    <li class="c-sidebar__item">
                        <a class="c-sidebar__link" href="/empresa/validar-cupom">
                            <i class="fa fa-qrcode u-mr-xsmall"></i>Validar Cupom
                        </a>
                    </li>
                    
                    <li class="c-sidebar__item">
                        <a class="c-sidebar__link" href="/empresa/fidelidade">
                            <i class="fa fa-vcard u-mr-xsmall"></i>Cartão Fidelidade
                        </a>
                    </li>

                    <li class="c-sidebar__item">
                        <a class="c-sidebar__link" href="/empresa/notificar">
                            <i class="fa fa-bullhorn u-mr-xsmall"></i>Notificar
                        </a>
                    </li>
                    @php
                        $qtd_msg = DB::table('mensagens as m')->where('para', Auth::user()->id)->where('status',0)->count();
                    @endphp
                    <li class="c-sidebar__item">
                        <a class="c-sidebar__link" href="/empresa/mensagens">
                            <i class="fa fa-envelope u-mr-xsmall"></i>Mensagens @if($qtd_msg > 0)({{$qtd_msg}})@endif
                        </a>
                    </li>
                    <li class="c-sidebar__item">
                        <a class="c-sidebar__link" href="/empresa/pedidos">
                            <i class="fa fa-shopping-cart u-mr-xsmall"></i>Pedidos
                        </a>
                    </li>
                    <li class="c-sidebar__item">
                        <a class="c-sidebar__link" href="/empresa/horarios">
                            <i class="fa fa-calendar u-mr-xsmall"></i>Horários de Funcionamento
                        </a>
                    </li>
                    <li class="c-sidebar__item">
                        <a class="c-sidebar__link" href="/empresa/horarios-entrega">
                            <i class="fa fa-clock-o u-mr-xsmall"></i>Horários de Entrega
                        </a>
                    </li>
                    <li class="c-sidebar__item">
                        <a class="c-sidebar__link" href="/empresa/avaliacoes">
                            <i class="fa fa-comments u-mr-xsmall"></i>Avaliações
                        </a>
                    </li>
                    @endif

                    <li class="c-sidebar__item">
                        @if(!isset(Auth::user()->tipo))
                        <a class="c-sidebar__link" href="/admin/minha-conta">
                            <i class="fa fa-user u-mr-xsmall"></i>Minha Conta
                        </a>
                        @endif
                        @if(isset(Auth::user()->tipo) && Auth::user()->tipo == 0)
                        <a class="c-sidebar__link" href="/empresa/minha-conta">
                            <i class="fa fa-user u-mr-xsmall"></i>Minha Conta
                        </a>
                        @endif                        
                    </li>

                    <!-- <li class="c-sidebar__item has-submenu">
                        <a class="c-sidebar__link" data-toggle="collapse" href="#sidebar-submenu" aria-expanded="true" aria-controls="sidebar-submenu">
                            <i class="fa fa-file u-mr-xsmall"></i>Relatórios
                        </a>
                        <ul class="c-sidebar__submenu collapse" id="sidebar-submenu" style="">
                            <li><a class="c-sidebar__link" href="#">Cupons Validados Por Empresa</a></li>
                            <li><a class="c-sidebar__link" href="#">Submenu link</a></li>
                            <li><a class="c-sidebar__link" href="#">Submenu link</a></li>
                        </ul>
                    </li> -->
                </ul>

            </div><!-- // .c-sidebar -->
        </div><!-- // .o-page__sidebar -->

        <main class="o-page__content">
            <header class="c-navbar u-mb-medium">
                <button class="c-sidebar-toggle u-mr-small">
                    <span class="c-sidebar-toggle__bar"></span>
                    <span class="c-sidebar-toggle__bar"></span>
                    <span class="c-sidebar-toggle__bar"></span>
                </button><!-- // .c-sidebar-toggle -->

                <h2 class="c-navbar__title u-mr-auto">@yield('title')</h2>
                
                <!-- <div class="c-dropdown u-hidden-down@mobile">
                    <a class="c-notification dropdown-toggle" href="#" id="dropdownMenuUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="c-notification__icon">
                            <i class="fa fa-user-o"></i>
                        </span>
                        <span class="c-notification__number">3</span>
                    </a>

                    <div class="c-dropdown__menu c-dropdown__menu--large dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuUser">
                        <a href="#" class="c-dropdown__item dropdown-item o-media">
                            <span class="o-media__img u-mr-xsmall">
                                <span class="c-avatar c-avatar--xsmall">
                                    <img class="c-avatar__img" src="/dashboard/img/avatar2-72.jpg" alt="User's Profile Picture">
                                </span>
                            </span>
                            <div class="o-media__body">
                                <h6 class="u-mb-zero">Someone mentioned you</h6>
                                <p class="u-text-mute">You have recieved a mention on twitter, check it out!</p>
                            </div>
                        </a>
                        <a href="#" class="c-dropdown__item dropdown-item o-media">
                            <span class="o-media__img u-mr-xsmall">
                                <span class="c-avatar c-avatar--xsmall">
                                    <img class="c-avatar__img" src="img/avatar3-72.jpg" alt="User's Profile Picture">
                                </span>
                            </span>
                            <div class="o-media__body">
                                <h6 class="u-mb-zero">Recieved a Payment</h6>
                                <p class="u-text-mute">You have recieved a mention on twitter, check it out!</p>
                            </div>
                        </a>
                        <a href="#" class="c-dropdown__item dropdown-item o-media">
                            <span class="o-media__img u-mr-xsmall">
                                <span class="c-avatar c-avatar--xsmall">
                                    <img class="c-avatar__img" src="img/avatar4-72.jpg" alt="User's Profile Picture">
                                </span>
                            </span>
                            <div class="o-media__body">
                                <h6 class="u-mb-zero">You got a promotion</h6>
                                <p class="u-text-mute">You have recieved a mention on twitter, check it out!</p>
                            </div>
                        </a>
                    </div>
                </div> -->

                <!-- <div class="c-dropdown dropdown u-mr-medium u-ml-small u-hidden-down@mobile">
                    <a class="c-notification dropdown-toggle" href="#" id="dropdownMenuAlerts" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="c-notification__icon">
                            <i class="fa fa-bell-o"></i>
                        </span>
                        <span class="c-notification__number">3</span>
                    </a>

                    <div class="c-dropdown__menu c-dropdown__menu--large dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuAlerts">
                        <a href="#" class="c-dropdown__item dropdown-item o-media">
                            <span class="o-media__img u-mr-xsmall">
                                <span class="c-avatar c-avatar--xsmall">
                                    <span class="c-avatar__img u-bg-success u-flex u-justify-center u-align-items-center">
                                        <i class="fa fa-check u-text-large u-color-white"></i>
                                    </span>
                                </span>
                                
                            </span>
                            <div class="o-media__body">
                                <h6 class="u-mb-zero">Completed a task</h6>
                                <p class="u-text-mute">You have recieved a mention on twitter, check it out!</p>
                            </div>
                        </a>

                        <a href="#" class="c-dropdown__item dropdown-item o-media">
                            <span class="o-media__img u-mr-xsmall">
                                <span class="c-avatar c-avatar--xsmall">
                                    <span class="c-avatar__img u-bg-fancy u-flex u-justify-center u-align-items-center">
                                        <i class="fa fa-calendar u-text-large u-color-white"></i>
                                    </span>
                                </span>
                                
                            </span>
                            <div class="o-media__body">
                                <h6 class="u-mb-zero">Company meetup</h6>
                                <p class="u-text-mute">You have recieved a mention on twitter, check it out!</p>
                            </div>
                        </a>
                        <a href="#" class="c-dropdown__item dropdown-item o-media">
                            <span class="o-media__img u-mr-xsmall">
                                <span class="c-avatar c-avatar--xsmall">
                                    <span class="c-avatar__img u-bg-primary u-flex u-justify-center u-align-items-center">
                                        <i class="fa fa-info u-text-large u-color-white"></i>
                                    </span>
                                </span>
                                
                            </span>
                            <div class="o-media__body">
                                <h6 class="u-mb-zero">Someone mentioned you</h6>
                                <p class="u-text-mute">You have recieved a mention on twitter, check it out!</p>
                            </div>
                        </a>
                    </div>
                </div>-->

                <div class="c-dropdown dropdown">
                    <a style="color:#354052; text-decoration:none;">
                        <!-- <img class="c-avatar__img" src="img/avatar-72.jpg" alt="User's Profile Picture"> -->
                        {{ Auth::user()->name }}
                    </a> 
                    <a  href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" style="margin-left: 15px;">
                        <!-- <img class="c-avatar__img" src="img/avatar-72.jpg" alt="User's Profile Picture"> -->
                        Sair
                    </a>

                    <!-- <div class="c-dropdown__menu dropdown-menu dropdown-menu-right" aria-labelledby="dropdwonMenuAvatar">
                        <a class="c-dropdown__item dropdown-item" href="#">Perfil</a>
                        <a class="c-dropdown__item dropdown-item" href="#">Sair</a>
                        <!-- <a class="c-dropdown__item dropdown-item" href="#">View Activity</a>
                        <a class="c-dropdown__item dropdown-item" href="#">Manage Roles</a> 
                    </div> -->
                </div> 
            </header>

            @yield('content')
            
        </main><!-- // .o-page__content -->
        

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>

        <script src="/js/main.min.js?v=1.4"></script>
        <script src="/js/sweetalert2.all.js"></script>
        
        @yield('scripts')

    </body>
</html>