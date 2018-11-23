<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="zxx">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <title>{{ getenv('APP_NAME') }} -  Clientes Vips</title>
    <!--Favicon-->
    <link rel="shortcut icon" type="image/png" href="site/images/favicon.png">
    <!--Bootstrap CSS-->
    <link rel="stylesheet" type="text/css" href="site/css/bootstrap.css">
    <!--Owl Carousel CSS-->
    <link rel="stylesheet" type="text/css" href="site/css/owl.carousel.min.css">
    <!--Magnific PopUp Stylesheet-->
    <link rel="stylesheet" type="text/css" href="site/css/magnific-popup.css">
    <!--Icofont CSS-->
    <link rel="stylesheet" type="text/css" href="site/css/icofont.css">
    <!--Mailer CSS-->
    <link rel="stylesheet" type="text/css" href="mailer/mailer-style.css">
    <!--Animate CSS-->
    <link rel="stylesheet" type="text/css" href="site/css/animate.css">
    <!--Bootsnav CSS-->
    <link rel="stylesheet" type="text/css" href="site/css/bootsnav.css">
    <!--Main CSS-->
    <link rel="stylesheet" type="text/css" href="site/css/style.css">
    <!--Responsive CSS-->
    <link rel="stylesheet" type="text/css" href="site/css/responsive.css">

    <style>
        .selecionado {
            background-color: #cd0fd8 !important;
            border-color: #cd0fd8 !important;
            color: #fff !important;
        }
    </style>

    <!--Modanizr JS-->
    <script src="site/js/modernizr.custom.js"></script>
    <!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>

<body>
    <!--Start Preloader-->
    <div class="preloader">
        <div class="spinner">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
        </div>
    </div>
    <!--End Preloader-->

    <!--Start Body Wrap-->
    <div id="body-wrap">
        <!--Start Header-->
        <header id="header">
            <nav class="navbar navbar-default bootsnav" data-spy="affix" data-offset-top="10">
                <div class="container">
                    <!-- Start Atribute Navigation -->
                    <div class="attr-nav">
                        <ul>
                            <li><a href="https://play.google.com/store/apps/details?id=com.connectvalle.achei.palmas"><i class="icofont icofont-download-alt"></i> Baixar App</a></li>
                        </ul>
                    </div>
                    <!-- End Atribute Navigation -->

                    <!-- Start Header Navigation -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                            <i class="icofont icofont-navigation-menu"></i>
                        </button>
                        <a class="navbar-brand" href="/clientesvips" style="color:white;font-size: 25px;font-weight: 700; margin-top: 12px;">                            
                            {{ getenv('APP_NAME') }}
                        </a>
                    </div>
                    <!-- End Header Navigation -->

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="navbar-menu">
                        <ul class="nav navbar-nav navbar-right" data-in="fadeIn" data-out="fadeOut">
                            <li class="active"><a href="#header">Home</a></li>                            
                            <li><a href="#features">Vantagens</a></li>                            
                            <li><a href="#contact">Contato</a></li>
                            <li><a id="registro" href="#pricing">Registro</a></li>
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                </div>
            </nav>
            <div class="clearfix"></div>
        </header>
        <!--End Header-->

        <!--Start Banner Section-->
        <section id="banner" class="gradient-bg full-height">
            <!--Start Container-->
            <div class="container">
                <!--Start Row-->
                <div class="row">
                    <!--Start Banner Caption-->
                    <div class="col-md-6">
                        <div class="caption-content">
                            <h1 class="font-700 color-white text-uppercase wow fadeInUp" data-wow-delay="0.1s">Seja um cliente VIP!</h1>
                            <p class="color-white wow fadeInUp" data-wow-delay="0.2s">Conheça todas as vantagens que o nosso aplicativo proporciona para você!</p>
                            <div class="caption-btn wow fadeInUp" data-wow-delay="0.3s">
                                <a class="font-600" href="#pricing">Quero ser VIP!</a>
                                <a class="font-600" href="https://play.google.com/store/apps/details?id=com.connectvalle.achei.palmas"><i class="icofont icofont-download-alt"></i> Baixar App</a>
                            </div>
                        </div>
                    </div>
                    <!--End Banner Caption-->

                    <!--Start Banner Image-->
                    <div class="col-md-6">
                        <div class="banner-img wow fadeIn" data-wow-delay="0.4s">
                            <img src="site/images/app.png" class="img-responsive" alt="Image" style="padding-top: 50px; max-width: 600px;">
                        </div>
                    </div>
                    <!--End Banner Image-->
                </div>
                <!--End Row-->
            </div>
            <!--End Container-->
        </section>
        <!--End Banner Section-->

        
        <!--Start Features Section-->
        <section id="features" >
            <!--Start Container-->
            <div class="container">
                <!--Start Heading Row-->
                <div class="row">
                    <!--Start Heading content-->
                    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                        <div class="section-heading text-center">
                            <h2 class="font-700 color-base text-uppercase wow fadeInUp" data-wow-delay="0.1s">Vantagens do Cliente VIP</h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">
                            O Achei Mais Descontos proporciona para você cliente vip, descontos especiais em Pizzarias, lanchonetes, padarias,farmácias, manutenção de veículos, cabelereiros, Pet shop, lavanderia, lava jato, manicure, e muito mais. Confira as vantagens. 
                            </p>
                        </div>
                    </div>
                    <!--End Heading content-->
                </div>
                <!--End Heading Row-->

                <!--Start Feature Items Row-->
                <div class="row">
                    <!--Start Feature Item-->
                    <div class="col-md-3 col-sm-6">
                        <div class="feature-single text-center wow fadeIn" data-wow-delay="0.1s">
                            <i class="icofont icofont-price gradient-bg-1 color-white"></i>
                            <h5 class="font-600">Cupons de Desconto</h5>
                            <p>
                            De forma fácil  e rápida  realize  o donwload de cupons de desconto, você  não  precisa imprimir  o cupom pois ele fica salvo  no seu celular é  só  apresentar o cupom e ganhar  seu desconto.
                            </p>
                        </div>
                    </div>
                    <!--End Feature Item-->

                    <!--Start Feature Item-->
                    <div class="col-md-3 col-sm-6">
                        <div class="feature-single text-center wow fadeIn" data-wow-delay="0.2s">
                            <i class="icofont icofont-sale-discount gradient-bg-1 color-white"></i>
                            <h5 class="font-600">Promoções  exclusivas</h5>
                            <p>
                            O cliente vip conta com promoções  exclusivas, em diversos produtos e serviços. Olha só  que legal você  pode ver sem sair de casa as melhores  promoções  da cidade. 
                            </p>
                        </div>
                    </div>
                    <!--End Feature Item-->

                    <!--Start Feature Item-->
                    <div class="col-md-3 col-sm-6">
                        <div class="feature-single text-center wow fadeIn" data-wow-delay="0.3s">
                            <i class="icofont icofont-gift gradient-bg-1 color-white"></i>
                            <h5 class="font-600">Cupons para aniversariantes</h5>
                            <p>
                            Chegou o seu dia!!!  Aproveite com os descontos exclusivos  para você comprar  presente  e economizar.
                            </p>
                        </div>
                    </div>
                    <!--End Feature Item-->

                    <!--Start Feature Item-->
                    <div class="col-md-3 col-sm-6">
                        <div class="feature-single text-center wow fadeIn" data-wow-delay="0.4s">
                            <i class="icofont icofont-id-card gradient-bg-1 color-white"></i>
                            <h5 class="font-600">Cartão  Fidelidade</h5>
                            <p>Participe de clube de cartão  fidelidade  para clientes vips. Você  pode concorrer a prêmios, brindes, e  descontos nas lojas credenciadas.</p>
                        </div>
                    </div>
                    <!--End Feature Item-->
                </div>
                <!--End Feature Items Row-->
            </div>
            <!--End Container-->
        </section>
        <!--End Features Section-->

      
        <!--Start Demo Video Section-->
        <section id="demo-video" class="bg-cover position-relative">
            <div class="overlay"></div>
            <!--Start Container-->
            <div class="container">
                <!--Start Row-->
                <div class="row">
                    <!--Start Video Content-->
                    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                        <div class="video-content text-center">
                            <h2 class="font-700 text-uppercase color-white wow fadeInUp" data-wow-delay="0.1s">Conheça o nosso Aplicativo!</h2>
                            <p class="color-white wow fadeInUp" data-wow-delay="0.2s">Veja este vídeo e fique por dentro das funcionalidades que o aplicativo fornece aos lojistas e clientes.</p>
                            <div class="video-popup-icon position-relative">
                                <div class="pulse1"></div>
                                <div class="pulse2"></div>
                                <a class="popup-video" href="https://www.youtube.com/watch?v=ezogt6PgDto"><i class="icofont icofont-play-alt-2"></i></a>
                            </div>

                        </div>
                    </div>
                    <!--End Video Content-->
                </div>
                <!--End Row-->
            </div>
            <!--End Container-->
        </section>
        <!--End Demo Video Section-->

                   
        <!--Start Contact Section-->
        <section id="contact" class="bg-gray">
            <!--Start Container-->
            <div class="container">
                <!--Start Heading Row-->
                <div class="row">
                    <!--Start Heading Col-->
                    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                        <!--Start Heading-->
                        <div class="section-heading text-center">
                            <h2 class="font-700 color-base text-uppercase wow fadeInUp" data-wow-delay="0.1s">Entre em contato</h2>                            
                        </div>
                        <!--End Heading-->
                    </div>
                    <!--End Heading Col-->
                </div>
                <!--End Heading Row-->

                <!--Start Contact Info-->
                <div class="contact-info">
                    <!--Start Row-->
                    <div class="row">
                        <!--Start Contact Info Single-->
                        <div class="col-sm-6">
                            <div class="contact-info-single text-center wow fadeIn" data-wow-delay="0.1s">
                                <i class="icofont icofont-email gradient-bg-1 color-white"></i>
                                <p>acheipalmasapp@gmail.com</p>
                            </div>
                        </div>
                        <!--End Contact Info Single-->

                        <!--Start Contact Info Single-->
                        <div class="col-sm-6">
                            <div class="contact-info-single text-center wow fadeIn" data-wow-delay="0.2s">
                                <i class="icofont icofont-phone gradient-bg-1 color-white"></i>
                                <p>+63 98486-6017</p>
                            </div>
                        </div>
                        <!--End Contact Info Single-->                      
                        
                    </div>
                    <!--End Row-->
                </div>
                <!--End Contact Info-->
               
            </div>
            <!--End Container-->
        </section>
        <!--End Contact Section-->

            <!--Start Pricing Section-->
            <section id="pricing">
            <!--Start Container-->
            <div class="container">
                <!--Start Heading Row-->
                <div class="row">
                    <!--Start Heading Content-->
                    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                        <div class="section-heading text-center">
                            <h2 class="font-700 color-base text-uppercase wow fadeInUp" data-wow-delay="0.1s">Escolha um plano</h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">Selecione um plano abaixo e informe seus dados para concluir seu registro como cliente VIP na plataforma Achei Mais Descontos.</p>
                        </div>
                    </div>
                    <!--End Heading Content-->
                </div>
                <!--End Heading Row-->

                <!--Start Pricing Row-->
                <div class="row">

                    <div class="col-md-3 col-sm-6"></div>
                    
                    <!--Start Pricing Table-->
                    <div class="col-md-3 col-sm-6">
                        <div class="pricing-table-single text-center wow fadeIn" data-wow-delay="0.1s">
                            <div class="pricing-title">
                                <h3 class="font-700">Básico</h3>
                            </div>
                            <div class="price-amount">
                                <h2 class="font-700 color-base2"><span>R$</span> 10.00 <sub class="font-600"></sub></h2>
                            </div>
                            <div class="pricing-details">
                                <ul>
                                    <li class="font-500">Durante 6 Meses</li>                                    
                                </ul>
                            </div>
                            <div class="pricing-btn">
                                <a class="font-600" id="plano_1" style="cursor: pointer;" onclick="SELECIONAR_PLANO(1)">Escolher</a>
                            </div>
                        </div>
                    </div>
                    <!--End Pricing Table-->

                    <!--Start Pricing Table-->
                    <div class="col-md-3 col-sm-6">
                        <div class="pricing-table-single text-center wow fadeIn" data-wow-delay="0.2s">
                            <div class="pricing-title">
                                <h3 class="font-700">Premium</h3>
                            </div>
                            <div class="price-amount">
                                <h2 class="font-700 color-base2"><span>R$</span> 20.00</h2>
                            </div>
                            <div class="pricing-details">
                                <ul>
                                    <li class="font-500">Durante 1 Ano</li>                                    
                                </ul>
                            </div>
                            <div class="pricing-btn">
                                <a class="font-600" id="plano_2" style="cursor: pointer;" onclick="SELECIONAR_PLANO(2)">Escolher</a>
                            </div>
                        </div>
                    </div>
                    <!--End Pricing Table-->

                   <div class="col-md-3 col-sm-6"></div>

                    
                </div>
                <!--End Pricing Row-->
            </div>
            <!--End Container-->
        </section>
        <!--End Pricing Section-->

        <!--Start Contact Section-->
        <a style="display:none;" id="link-registro" href="contact2"></a>
        <section id="contact2" >
            <!--Start Container-->
            <div class="container">
                
                <br>
                <br>

                <!--Start Contact Form Content-->
                <div class="contact-form-content">
                    <!--Start Row-->
                    <div class="row">
                        <!--Start Contact Form-->
                        <div class="col-md-12">
                            <div class="contact-form">
                                <h3 class="font-600 text-center">Registre-se como VIP</h3>                                                                

                                <form action="/cadastrar-cliente-vip" method="post">
                                    {{ csrf_field() }}
                                    <div class="col-md-2">
                                    </div>

                                    <div class="col-md-8">

                                            @if(Session::has('errors'))      
                                            <div class="widget tag-cloud" >                                            
                                                <h4><a style="background-color: red; border-radius: unset; width: 100%;"  
                                                        class="font-500">                                                          
                                                        {{ $errors->first() }} <i style="float:right; margin-top: 10px;" class="icofont icofont-close"></i>
                                                    </a>      
                                                </h4>                                      
                                            </div>                  
                                            @endif                          
                                        
                                        
                                        <input type="text" id="plano" name="plano" style="display:none">

                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Nome" id="name" name="name" value="{{ old('name') }}" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control" placeholder="Email" id="email" name="email"  value="{{ old('email') }}" required>
                                        </div>                                        
                                        
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <select type="text" class="form-control" id="sexo" name="sexo" style="height: 50px;" required> 
                                                    <option>Sexo</option>
                                                    <option>Masculino</option>
                                                    <option>Feminio</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input type="date" class="form-control" placeholder="Data de Nascimento" id="nascimento"  value="{{ old('nascimento') or '' }}" name="nascimento" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <input type="password" class="form-control" placeholder="Senha" id="password" name="password" required>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input type="password" class="form-control" placeholder="Confirmação de Senha" id="password_confirmation" name="password_confirmation" required>
                                            </div>
                                        </div>
                                    
                                        <div class="row col-md-12">                                            
                                            <p>
                                                <input type="checkbox" style="height: unset;" required/>
                                                Li e concordo com os <a href="/termodeuso.pdf" target="_blank" style="text-decoration: underline;">termos de uso</a>.
                                            </p>
                                        </div>

                                        <div class="contact-btn">
                                            <button class="font-500 gradient-bg-1 color-white" type="submit">Finalizar</button>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                                                    
                                    </div>
                                    
                                </form>
                                <div id="form-messages"></div>
                            </div>
                        </div>
                        <!--End Contact Form-->

                        
                        
                            <div class="google-map" style="display:none;">
                                <h3 class="font-600 text-center">Find Us In Google Map</h3>
                                <div id="map"></div>
                            </div>
                        
                    </div>
                    <!--End Row-->
                </div>
                <!--End Contact Form Content-->
            </div>
            <!--End Container-->
        </section>
        <!--End Contact Section-->    


        <br>
        <br>
        <!--Start Footer-->
        <footer id="footer">
            <!--Start Container-->
            <div class="container">
                <!--Start Row-->
                <div class="row">
                    <!--Start Footer Social-->
                    <div class="col-sm-4">
                        <div class="footer-social text-left wow fadeIn" data-wow-delay="0.1s">
                            <ul>
                                <li><a href="https://www.facebook.com/acheimaisdescontos/"><i  class="icofont icofont-social-facebook"></i></a></li>                                                                
                            </ul>
                        </div>
                    </div>
                    <!--End Footer Social-->

                    <!--Start Copyright Text-->
                    <div class="col-sm-8">
                        <div class="copyright-text text-right wow fadeIn" data-wow-delay="0.2s">
                            <p class="color-white">&copy; 2018 Achei Mais Descontos</p>
                        </div>
                    </div>
                    <!--End Copyright Text-->
                </div>
                <!--End Row-->
            </div>
            <!--End Container-->

            <!--Start ClickToTop-->
            <div class="click-to-top">
                <a class="gradient-bg" href="#header"><i class="icofont icofont-simple-up"></i></a>
            </div>
            <!--End ClickToTop-->
        </footer>
        <!--End Footer-->
    </div>
    <!--End Body Wrap-->

    <!--jQuery JS-->
    <script src="site/js/jquery.min.js"></script>
    <!--Google Map API-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4yKUBz0tTKwfw8zY8mYOR7MAZy9coIMg&callback" async defer></script>
    <script src="site/js/map.js"></script>
    <!--Counter JS-->
    <script src="site/js/waypoints.js"></script>
    <script src="site/js/jquery.counterup.min.js"></script>
    <!--Bootstrap JS-->
    <script src="site/js/bootstrap.min.js"></script>
    <!--Magnic PopUp JS-->
    <script src="site/js/magnific-popup.min.js"></script>
    <!--Owl Carousel JS-->
    <script src="site/js/owl.carousel.min.js"></script>
    <!--Wow JS-->
    <script src="site/js/wow.min.js"></script>
    <!--Bootsnavs JS-->
    <script src="site/js/bootsnav.js"></script>
    <!--Contact Form JS-->
    <script src="mailer/ajax-contact-form.js"></script>
    <!--Main-->
    <script src="site/js/custom.js"></script>

    <script>        
        function SELECIONAR_PLANO(id){            
            $('.selecionado').removeClass('selecionado');
            $('#plano_'+id).addClass('selecionado');
            $('#plano').val(id);
        }

        @if(Session::has('errors'))     
        setTimeout(() => {            
            $('#registro').click();
        }, 1000);   
        @endif
    </script>

</body>

</html>
