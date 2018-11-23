<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Registro | {{ getenv('APP_NAME') }}</title>        
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

        <div class="c-login" >
            <header class="c-login__head">
                <span class="c-login__icon">
                    <i class="u-h2 fa fa-sign-in"></i>
                </span>
                <h1 class="c-login__title">REGISTRO</h1>
                <div class="col-12" style="text-align:center;">
                    <p class="u-h6 u-text-mute">Preencha o formulário abaixo para cadastrar sua empresa</p>
                </div>
            </header>
            
            <form class="c-login__content" action="/registrar" method="POST">

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
                
                <div class="c-field u-mb-small">
                    <label class="c-field__label" for="name">Fantasia</label> 
                    <input class="c-input" type="text" id="name" placeholder="Nome da sua empresa" name="name" required> 
                </div>

                <div class="c-field u-mb-small">
                    <label class="c-field__label" for="cnpj">CNPJ</label> 
                    <input class="c-input" type="text" id="cnpj" placeholder="CNPJ da sua empresa" name="cnpj" required> 
                </div>

                <div class="c-field u-mb-small">
                    <label class="c-field__label" for="input1">E-mail</label> 
                    <input class="c-input" type="email" id="input1" placeholder="admin@admin.com" name="email" required> 
                </div>

                <div class="row">

                    <div class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="input2">Senha</label> 
                        <input class="c-input" type="password" id="input2" placeholder="******" name="password" required>
                    </div>
                    
                    <div class="col-md-6 c-field u-mb-small">
                        <label class="c-field__label" for="password_c">Repetir Senha</label> 
                        <input class="c-input" type="password" id="password_c" placeholder="******" name="password_c" required>
                    </div>

                </div>
                    
                <button class="c-btn c-btn--info c-btn--fullwidth" type="submit">Registrar</button>
                <div style="text-align:center;margin-bottom: 10px;">
                    <a class="c-login__footer-link u-left" href="/recuperar-senha" style="text-align:center;">Esqueceu sua senha?</a><br>
                    <a class="c-login__footer-link u-right" href="/login" >Voltar para Login</a>
                </div>
            </form>  

            <footer class="c-login__footer">
                <br>
                <br>
                <br>
            </footer>

                
        </div>        

        <script src="/js/main.min.js?v=1.4"></script>
        
    </body>
</html>