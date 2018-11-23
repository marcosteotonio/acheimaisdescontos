<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Definir Nova Senha | {{ getenv('APP_NAME') }}</title>        
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,600" rel="stylesheet">

        <!-- Favicon -->
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

        <!-- Stylesheet -->
        <link rel="stylesheet" href="/css/main.min.css?v=1.4">
    </head>
    <body class="c-login-wrapper">
        <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

        <div class="c-login" style="top:50%">
            <header class="c-login__head">
                <span class="c-login__icon">
                    <i class="u-h2 fa fa-key"></i>
                </span>
                <h1 class="c-login__title">DEFINIR NOVA SENHA</h1>
                <div class="col-12" style="text-align:center;">
                    <p class="u-h6 u-text-mute">Olá {{ $usuario->name }}, informe sua nova senha no formulário abaixo</p>
                </div>
            </header>
            
            <form class="c-login__content" action="/definir-senha/{{ $usuario->email }}/{{ $usuario->remember_token }}" method="POST">

                {{ csrf_field() }}                                

                @if(Session::has('erro'))
                <div class="c-alert c-alert--danger alert">
                    <i class="c-alert__icon fa fa-times-circle"></i> {{ Session::get('erro') }}
                    <button class="c-close" data-dismiss="alert" type="button">×</button>
                </div>
                @endif

                @if (Session::has('errors'))
                    @foreach ($errors->all() as $error)
                    <div class="c-alert c-alert--danger alert">
                        <i class="c-alert__icon fa fa-times-circle"></i> {{ $error }}
                        <button class="c-close" data-dismiss="alert" type="button">×</button>
                    </div>    
                    @endforeach
                @endif
                                
                <div class="row">

                    <div class="col-md-12 c-field u-mb-small">
                        <label class="c-field__label" for="input2">Nova Senha</label> 
                        <input class="c-input" type="password" id="input2" placeholder="******" name="password" required>
                    </div>
                    
                    <div class="col-md-12 c-field u-mb-small">
                        <label class="c-field__label" for="password_c">Repetir Nova Senha</label> 
                        <input class="c-input" type="password" id="password_c" placeholder="******" name="password_c" required>
                    </div>

                </div>
                    
                <button class="c-btn c-btn--info c-btn--fullwidth" type="submit">Definir Nova Senha</button>                
            </form>  
     
        </div>        

        <script src="/js/main.min.js?v=1.4"></script>
        
    </body>
</html>