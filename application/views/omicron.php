<!DOCTYPE html>
<html lang="pt">

<head>

    <!-- Google Tag Manager -->
    <script>
    (function(w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
            'gtm.start': new Date().getTime(),
            event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s),
            dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.src =
            'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-5QG4XHV');
    </script>
    <!-- End Google Tag Manager -->

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-6KRKW1QJ23"></script>
    <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-6KRKW1QJ23');
    </script>

    <!-- Tags Facebook -->
    <meta property="og:url" content="https://shopfloor.com.br" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="ShopFloor - ERP online e compacto para sua empresa" />
    <meta property="og:description"
        content="Software que controla a linha de produção de forma simples, rápida e eficiente. Além de gerenciar as áreas de compra e venda, financeira, estoque e muito mais!" />
    <meta property="og:image" content="<?php echo base_url('img/cover.jpg') ?>" />
    <meta property="fb:app_id" content="1076836432769187" />

    <meta name="twitter:image" content="<?php echo base_url('img/cover.jpg') ?>" />

    <meta charset="utf-8">
    <meta name="twitter:card" content="summary" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
        content="Software que controla a linha de produção de forma simples, rápida e eficiente. Além de gerenciar as áreas de compra e venda, financeira, estoque e muito mais!">
    <meta name="keywords"
        content="ShooFloor, ERP, Sistema de Gestão, Produção, Nota Fiscal, Compras, Vendas, Financeiro">
    <meta name="author" content="ShopFloor">

    <link rel="shortcut icon" href="<?php echo base_url('img/logo-ico.ico') ?>" type="image/x-icon" />

    <title>ShopFloor - ERP online e compacto para sua empresa</title>

    <!-- Boostrap -->
    <link href="<?= base_url('/css/bootstrap.css'); ?>" rel="stylesheet" type="text/css" />

    <!-- Font Awesome Icons -->
    <link href="<?= base_url('/fontawesome-free/css/all.css'); ?>" rel="stylesheet" type="text/css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic'
        rel='stylesheet' type='text/css'>

    <!-- Plugin CSS -->
    <link href="<?= base_url('/css/magnific-popup.css'); ?>" rel="stylesheet" type="text/css" />

    <!-- Theme CSS - Includes Bootstrap -->
    <link href="<?= base_url('/css/creative.css'); ?>" rel="stylesheet" type="text/css" />

</head>

<body id="page-top">

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5QG4XHV" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <!-- Load Facebook SDK for JavaScript -->
    <div id="fb-root"></div>
    <script>
    window.fbAsyncInit = function() {
        FB.init({
            xfbml: true,
            version: 'v6.0'
        });
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = 'https://connect.facebook.net/pt_BR/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    </script>

    <!-- Your customer chat code -->
    <div class="fb-customerchat" attribution=setup_tool page_id="100170578264778" theme_color="#325D88"
        logged_in_greeting="Olá! Como podemos te ajudar?" logged_out_greeting="Olá! Como podemos te ajudar?">
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="#page-top">&nbsp</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto my-2 my-lg-0">
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="<?php echo base_url() ?>comece-agora">Comece
                            Agora</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#services">Como Funciona</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#contact">Contato</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="<?php echo base_url() ?>login">Entrar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Masthead -->
    <header class="masthead">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-10 align-self-end">
                    <h1 class="text-uppercase text-white font-weight-bold">UM ERP Compacto e online para o Gerenciamento
                        da sua Empresa</h1>
                    <hr class="divider my-4">
                </div>
                <div class="col-lg-8 align-self-baseline">
                    <p class="text-white-75 font-weight-light mb-5">Software que controla a linha de produção de forma
                        simples, rápida e eficiente. Além de gerenciar as áreas de compra e venda, financeira, estoque e
                        muito mais!</p>
                    <a class="btn btn-primary btn-xl js-scroll-trigger" href="#services">Saiba Mais</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Services Section -->
    <section class="page-section" id="services">
        <div class="container">
            <h2 class="text-center mt-0">Como funciona?</h2>
            <p class="text-center text-muted mb-3">Veja abaixo o que podemos oferecer à sua empresa</p>
            <hr class="divider my-4">
            <div class="row">
                <div class="col-lg-4 col-md-6 text-center">
                    <div class="mt-5">
                        <i class="fas fa-4x fa-sitemap text-secondary mb-4"></i>
                        <h3 class="h4 mb-2">Engenharia de produto</h3>
                        <p class="text-muted mb-0">Defina a lista de materiais e seu consumo na transformação dos
                            produtos.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 text-center">
                    <div class="mt-5">
                        <i class="fas fa-4x fa-cogs text-secondary mb-4"></i>
                        <h3 class="h4 mb-2">Gestão de produção</h3>
                        <p class="text-muted mb-0">Crie ordens, reporte à produção e transforme os insumos da indústria
                            em produtos acabados.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 text-center">
                    <div class="mt-5">
                        <i class="fas fa-4x fa-dolly text-secondary mb-4"></i>
                        <h3 class="h4 mb-2">Movimentação de materiais</h3>
                        <p class="text-muted mb-0">Controle o estoque por meio de baixas automáticas dos itens
                            comprados, vendidos e produzidos. E monitore periodicamente as movimentações pelo
                            inventário.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 text-center">
                    <div class="mt-5">
                        <i class="fas fa-4x fa-shopping-cart text-secondary mb-4"></i>
                        <h3 class="h4 mb-2">Controle de compra</h3>
                        <p class="text-muted mb-0">Crie ordens, emita e receba pedidos de compra para coordenar o
                            estoque dos insumos da produção.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 text-center">
                    <div class="mt-5">
                        <i class="fas fa-4x fa-shopping-bag  text-secondary mb-4"></i>
                        <h3 class="h4 mb-2">Controle de venda</h3>
                        <p class="text-muted mb-0">Emita, imprima e fature os pedidos de venda da empresa. Gerencie seus
                            vendedores e pagamentos de comissão.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 text-center ">
                    <div class="mt-5">
                        <i class="fas fa-4x fa-clipboard-list text-secondary mb-4"></i>
                        <h3 class="h4 mb-2">Necessidade de materiais (MRP)</h3>
                        <p class="text-muted mb-0">Obtenha cálculos automáticos da necessidade de compra e produção de materiais, baseados na data de entrega dos pedidos.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 text-center">
                    <div class="mt-5">
                        <i class="fas fa-4x  fa-cash-register text-secondary mb-4"></i>
                        <h3 class="h4 mb-2">Frente de caixa</h3>
                        <p class="text-muted mb-0">Registre vendas, controle movimentações e faça fechamentos diários de
                            caixa. </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 text-center ">
                    <div class="mt-5">
                        <i class="fas fa-4x  fa-hand-holding-usd text-secondary mb-4"></i>
                        <h3 class="h4 mb-2">Gestão financeira</h3>
                        <p class="text-muted mb-0">Controle os pagamentos, recebimentos e administre o fluxo de caixa.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 text-center">
                    <div class="mt-5">
                        <i class="fas fa-4x fa-calculator text-secondary mb-4"></i>
                        <h3 class="h4 mb-2">Custo de produto</h3>
                        <p class="text-muted mb-0">Obtenha automaticamente o cálculo do custo dos itens produzidos e
                            adquiridos.</p>
                    </div>
                </div>
                
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="page-section bg-primary" id="about">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="text-white mt-0">Nossos planos e preços</h2>
                    <p class="text-white-50 mb-4">Escolha o plano ideal para sua empresa.</p>
                    <hr class="divider light my-4">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 ">
                    <div class="card border-secondary mb-3">
                        <div class="card-body">
                            <h3 class="card-title mb-4"><span class="badge badge-secondary">Básico</span></h3>
                            <h3 class="card-title font-weight-bold mb-0">R$ 119,99/mês</h3>
                            <h5 class="text-muted mb-3">Plano Anual</h5>
                            <h3 class="card-title font-weight-bold mb-0">R$ 180,00/mês</h3>
                            <h5 class="text-muted mb-3">Plano Mensal</h5>
                            <hr>
                            <p class="card-text mb-0 text-dark"><i class="fas fa-check"></i> Até <strong>2</strong>
                                usuários</p>
                            <p class="card-text mb-0 text-dark"><i class="fas fa-check"></i> Acesso a todos módulos</p>
                            <a class="btn btn-secondary btn-xl btn-block js-scroll-trigger mt-3"
                                href="<?php echo base_url() ?>comece-agora">Quero Testar</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 ">
                    <div class="card border-warning mb-3">
                        <div class="card-body">
                            <h3 class="card-title mb-4"><span class="badge badge-warning">Intermediário</span></h3>
                            <h3 class="card-title font-weight-bold mb-0">R$ 146,96/mês</h3>
                            <h5 class="text-muted mb-3">Plano Anual</h5>
                            <h3 class="card-title font-weight-bold mb-0">R$ 207,00/mês</h3>
                            <h5 class="text-muted mb-3">Plano Mensal</h5>
                            <hr>
                            <p class="card-text mb-0 text-dark"><i class="fas fa-check"></i> Até <strong>5</strong>
                                usuários</p>
                            <p class="card-text mb-0 text-dark"><i class="fas fa-check"></i> Acesso a todos módulos</p>
                            <a class="btn btn-warning btn-xl btn-block js-scroll-trigger mt-3"
                                href="<?php echo base_url() ?>comece-agora">Quero Testar</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 ">
                    <div class="card border-info mb-3">
                        <div class="card-body">
                            <h3 class="card-title mb-4"><span class="badge badge-info">Avançado</span></h3>
                            <h3 class="card-title font-weight-bold mb-0">R$ 187,92/mês</h3>
                            <h5 class="text-muted mb-3">Plano Anual</h5>
                            <h3 class="card-title font-weight-bold mb-0">R$ 248,00/mês</h3>
                            <h5 class="text-muted mb-3">Plano Mensal</h5>
                            <hr>
                            <p class="card-text mb-0 text-dark"><i class="fas fa-check"></i> Até <strong>10</strong>
                                usuários</p>
                            <p class="card-text mb-0 text-dark"><i class="fas fa-check"></i> Acesso a todos módulos</p>
                            <a class="btn btn-info btn-xl btn-block js-scroll-trigger mt-3"
                                href="<?php echo base_url() ?>comece-agora">Quero Testar</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 ">
                    <div class="card border-success mb-3">
                        <div class="card-body">
                            <h3 class="card-title mb-4"><span class="badge badge-success">Premium</span></h3>
                            <h3 class="card-title font-weight-bold mb-0">R$ 224,89/mês</h3>
                            <h5 class="text-muted mb-3">Plano Anual</h5>
                            <h3 class="card-title font-weight-bold mb-0">R$ 285,00/mês</h3>
                            <h5 class="text-muted mb-3">Plano Mensal</h5>
                            <hr>
                            <p class="card-text mb-0 text-dark"><i class="fas fa-check"></i> Até <strong>15</strong>
                                usuários</p>
                            <p class="card-text mb-0 text-dark"><i class="fas fa-check"></i> Acesso a todos módulos</p>
                            <a class="btn btn-success btn-xl btn-block js-scroll-trigger mt-3"
                                href="<?php echo base_url() ?>comece-agora">Quero Testar</a>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <!-- Review Section -->
    <section class="page-section bg-secondary" id="contact">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <h2 class="mt-0 text-light">Opinião dos nossos clientes</h2>
                    <hr class="divider light my-4">
                    <img src="img/clientes/boleta.png" class="border border-light rounded-circle mb-5 mt-3" width="150">
                    <p class="text-light font-italic ">"O ShopFloor foi uma solução encontrada após meses de procura.
                        Buscava
                        um sistema de fácil utilização, que as funções fossem intuitivas e que não precisasse
                        percorrer um longo caminho para fazer atividades simples. Com o ShopFloor encontrei isso,
                        facilitando ainda mais o controle da minha empresa, da produção à minha gestão financeira!"
                    <p class="text-light mb-4 font-weight-bold">- Leonardo do <a
                            href="https://www.facebook.com/cookiedoboleta/" class="text-white" target="_blank"
                            style="text-decoration: underline;">Cookie do Boleta</a></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <!-- Footer -->
    <footer class="bg-dark text-white">
        <!-- Grid container -->
        <div class="container p-4">
            <!-- Section: Social media -->
            <section class="mb-4 text-center">
                <!-- Facebook -->
                <a class="btn btn-outline-light btn-floating m-1" href="https://www.facebook.com/shopfloor.com.br"
                    role="button" target="_blank"><i class="fab fa-facebook-f"></i></a>

                <!-- Instagram -->
                <a class="btn btn-outline-light btn-floating m-1" href="https://www.instagram.com/shopfloor_erp/"
                    role="button" target="_blank"><i class="fab fa-instagram"></i></a>

                <!-- Linkedin -->
                <a class="btn btn-outline-light btn-floating m-1" href="https://www.linkedin.com/company/shopfloor-erp"
                    role="button" target="_blank"><i class="fab fa-linkedin-in"></i></a>
            </section>
            <!-- Section: Social media -->

            <!-- Section: Form -->
            <section class="mb-5">
                <form action="">
                    <!--Grid row-->
                    <div class="row d-flex justify-content-center">
                        <!--Grid column-->
                        <div class="col-auto">
                            <p class="pt-2">
                                <strong>Assine nossa newsletter</strong>
                            </p>
                        </div>
                        <!--Grid column-->

                        <!--Grid column-->
                        <div class="col-md-5 col-12">
                            <!-- Email input -->
                            <div class="form-outline form-white mb-4">
                                <input type="email" id="form5Example2" class="form-control" />
                            </div>
                        </div>
                        <!--Grid column-->

                        <!--Grid column-->
                        <div class="col-auto">
                            <!-- Submit button -->
                            <button type="submit" class="btn btn-outline-light mb-4">
                                Assinar!
                            </button>
                        </div>
                        <!--Grid column-->
                    </div>
                    <!--Grid row-->
                </form>
            </section>
            <!-- Section: Form -->

            <!-- Section: Links -->
            <section class="">
                <!--Grid row-->
                <div class="row">
                    <!--Grid column-->
                    <div class="col-lg-3 col-md-12 mb-4 mb-md-0">
                        <h5>O ShopFloor</h5>
                        
                        <p>
                        O Shopfloor é 100% online, você pode acessar de qualquer lugar! 
                        Gerenciando sua empresa mesmo à distância.
                        </p>
                        <ul class="list-unstyled mb-0">
                            <li>
                            <i class="far fa-envelope text-muted"></i> <a href="#!" class="text-white">contato@shopfloor.com.br</a>
                            </li>
                            <li>
                            <i class="fab fa-whatsapp text-muted"></i> (42) 9 8819-2794
                            </li>
                            <li>
                            <i class="fas fa-map-marker-alt  text-muted"></i> Guarapuava/PR
                            </li>
                        </ul>
                    </div>

                    <!--Grid column-->
                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0 text-center">
                        <h5>Acessos</h5>

                        <ul class="list-unstyled mb-0">
                            <li>
                                <a href="https://shopfloor.com.br/login" class="text-white">Login</a>
                            </li>
                            <li>
                                <a href="https://shopfloor.com.br/login-vendedor" class="text-white">Login do Vendedor</a>
                            </li>
                            <li>
                                <a href="https://shopfloor.com.br/comece-agora" class="text-white">Quero testar</a>
                            </li>
                            <li>
                                <a href="http://blog.shopfloor.com.br/termos-condicoes-uso/" class="text-white">Termos de uso</a>
                            </li>
                        </ul>
                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0 text-center">
                        <h5>Suporte</h5>

                        <ul class="list-unstyled mb-0">
                            <li>
                                <a href="https://blog.shopfloor.com.br/category/base-conhecimento/" class="text-white" target="_blank">Base de Conhecimento</a>
                            </li>
                            <li>
                                <a href="https://blog.shopfloor.com.br/category/novas-funcionalidades/" class="text-white" target="_blank">Novas Funcionalidades</a>
                            </li>
                            <li>
                                <a href="https://blog.shopfloor.com.br/category/apoio-teorico/" class="text-white" target="_blank">Apoio Teórico</a>
                            </li>
                            <li>
                                <a href="https://blog.shopfloor.com.br" class="text-white" target="_blank">Blog do ShopFloor</a>
                            </li>
                        </ul>
                    </div>
                    <!--Grid column-->

                    <!--Grid column-->
                    <div class="col-lg-3 col-md-6 mb-4 mb-md-0 text-center">
                        <h5>Funcionalidades</h5>

                        <ul class="list-unstyled mb-0">
                            <li>
                                <a href="http://blog.shopfloor.com.br/2021/04/04/controle-de-frente-de-caixa" class="text-white" target="_blank">Frente de Caixa</a>
                            </li>
                            <li>
                                <a href="http://blog.shopfloor.com.br/2021/04/04/cadastro-de-estrutura-de-produto/" class="text-white" target="_blank">Engenharia de Produto</a>
                            </li>
                        </ul>
                    </div>
                    <!--Grid column-->
                </div>
                <!--Grid row-->
            </section>
            <!-- Section: Links -->
        </div>
        <!-- Grid container -->

        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2021 Copyright - ShopFloor
        </div>
        <!-- Copyright -->
    </footer>
    <!-- Footer -->


    <script src="<?= base_url('/js/jquery-3.4.1.min.js'); ?>" type="text/javascript"></script>

    <!-- Bootstrap core JavaScript -->
    <script src="<?= base_url('/js/bootstrap.bundle.min.js'); ?>" type="text/javascript"></script>

    <!-- Plugin JavaScript -->
    <script src="<?= base_url('/js/jquery.easing.min.js'); ?>" type="text/javascript"></script>
    <script src="<?= base_url('/js/jquery.magnific-popup.min.js'); ?>" type="text/javascript"></script>

    <!-- Custom scripts for this template -->

    <script src="<?= base_url('/js/creative.min.js'); ?>" type="text/javascript"></script>

</body>

</html>