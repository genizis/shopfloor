<body class="bg-default">

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5QG4XHV"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('pedidos-vendedor') ?>"><img src="<?= base_url('img/logo.png') ?>"
                    class="img-fluid" alt=""></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01"
                aria-controls="navbarColor01" aria-expanded="false" aria-label="	Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php if($menu == 'Pedidos Vendedor') echo "active"; ?>"
                            href="<?= base_url('vendas/pedido-venda-vendedor') ?>">Minhas Vendas</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="nav-item dropdown show-on-hover margem-direita-10">
                        <a class="nav-link " href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"><?= getDadosUsuarioLogado()['nome_usuario'] ?></a>
                        <div class="dropdown-menu" aria-labelledby="dropdown01">
                            <span class="dropdown-label text-dark"><?= getDadosUsuarioLogado()['nome_empresa'] ?></span>
                            <span class="dropdown-label text-dark">ID Cliente:
                                <?= getDadosUsuarioLogado()['id_empresa'] ?></span>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= base_url('logout-vendedor') ?>">Sair</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

	<div class="modal fade bd-example-modal-lg" data-backdrop="static" data-keyboard="false" tabindex="-1" id="spinner">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="spinner-grow text-light" style="width: 7rem; height: 7rem;" role="status">
					<span class="sr-only">Loading...</span>
				</div>
			</div>
		</div>
	</div>