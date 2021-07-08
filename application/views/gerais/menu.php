<body class="bg-default">

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5QG4XHV"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('visao-geral') ?>"><img src="<?= base_url('img/logo.png') ?>"
                    class="img-fluid" alt=""></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01"
                aria-controls="navbarColor01" aria-expanded="false" aria-label="	Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php if($menu == 'Visao Geral') echo "active"; ?>"
                            href="<?= base_url('visao-geral') ?>">Visão Geral</a>
                    </li>
                    <?php if(getDadosUsuarioLogado()['producao'] == 1) { ?>
                    <li class="nav-item dropdown show-on-hover dropdown-cols-2">
                        <a class="nav-link <?php if($menu == 'Producao') echo "active"; ?> dropdown-toggle" href="#"
                            id="dropdown01" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">Produção</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown01">
                            <div class="row">
                                <div class="col-md-6">
                                    <span class="dropdown-label">Controle</span>
                                    <a class="dropdown-item" href="<?= base_url('producao/ordem-producao') ?>">Ordem de
                                        Produção</a>
                                    <a class="dropdown-item" href="<?= base_url('producao/reporte-producao') ?>">Reporte
                                        de Produção</a>                                    
                                </div>
                                <div class="col-md-6">
                                    <span class="dropdown-label">Relatórios</span>
                                    <a class="dropdown-item"
                                        href="<?= base_url('relatorios/producao-produto') ?>">Produção por Produto</a>
                                    <a class="dropdown-item"
                                        href="<?= base_url('relatorios/consumo-produto') ?>">Consumo por Produto</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="<?= base_url('producao/indicadores-producao') ?>">Indicadores de
                                        Produção</a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php } ?>
                    <?php if(getDadosUsuarioLogado()['vendas'] == 1) { ?>
                    <li class="nav-item dropdown show-on-hover dropdown-cols-2">
                        <a class="nav-link <?php if($menu == 'Vendas') echo "active"; ?> dropdown-toggle" href="#"
                            id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Vendas</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown01">
                            <div class="row">
                                <div class="col-md-6">
                                    <span class="dropdown-label">Controle</span>
                                    <a class="dropdown-item" href="<?= base_url('vendas/pedido-venda') ?>">Pedido de
                                        Venda</a>
                                    <a class="dropdown-item"
                                        href="<?= base_url('vendas/faturamento-pedido') ?>">Faturamento de Pedido</a>
                                    <a class="dropdown-item"
                                        href="<?= base_url('vendas/frente-caixa') ?>">Frente de Caixa</a>
                                </div>
                                <div class="col-md-6">
                                    <span class="dropdown-label">Relatórios</span>
                                    <a class="dropdown-item" href="<?= base_url('relatorios/venda-produto') ?>">Venda
                                        por Produto</a>
                                    <a class="dropdown-item" href="<?= base_url('relatorios/venda-cliente') ?>">Venda
                                        por Cliente</a>
                                    <a class="dropdown-item" href="<?= base_url('relatorios/venda-vendedor') ?>">Venda
                                        por Vendedor</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="<?= base_url('vendas/indicadores-vendas') ?>">Indicadores de Vendas</a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php } ?>
                    <?php if(getDadosUsuarioLogado()['compras'] == 1) { ?>
                    <li class="nav-item dropdown show-on-hover dropdown-cols-2">
                        <a class="nav-link <?php if($menu == 'Compras') echo "active"; ?> dropdown-toggle" href="#"
                            id="dropdown01" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">Compras</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown01">
                            <div class="row">
                                <div class="col-md-6">
                                    <span class="dropdown-label">Controle</span>
                                    <a class="dropdown-item" href="<?= base_url('compras/ordem-compra') ?>">Ordem de
                                        Compra</a>
                                    <a class="dropdown-item" href="<?= base_url('compras/pedido-compra') ?>">Pedido de
                                        Compra</a>
                                    <a class="dropdown-item"
                                        href="<?= base_url('compras/recebimento-material') ?>">Recebimento de
                                        Material</a>
                                </div>
                                <div class="col-md-6">
                                    <span class="dropdown-label">Relatórios</span>
                                    <a class="dropdown-item" href="<?= base_url('relatorios/compra-produto') ?>">Compra
                                        Por Produto</a>
                                    <a class="dropdown-item"
                                        href="<?= base_url('relatorios/compra-fornecedor') ?>">Compra Por Fornecedor</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="<?= base_url('compras/indicadores-compras') ?>">Indicadores de Compras</a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php } ?>
                    <?php if(getDadosUsuarioLogado()['estoque'] == 1) { ?>
                    <li class="nav-item dropdown show-on-hover dropdown-cols-2">
                        <a class="nav-link <?php if($menu == 'Estoque') echo "active"; ?> dropdown-toggle" href="#"
                            id="dropdown01" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">Estoque</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown01">
                            <div class="row">
                                <div class="col-md-6">
                                    <span class="dropdown-label">Controle</span>
                                    
                                    <a class="dropdown-item" href="<?= base_url('estoque/necessidade-material') ?>">Necessidade de Materiais</a> 
                                    <a class="dropdown-item" href="<?= base_url('estoque/requisicao-material') ?>">Requisição de Material</a>
                                    <a class="dropdown-item" href="<?= base_url('estoque/inventario') ?>">Inventário</a>
                                    <a class="dropdown-item" href="<?= base_url('estoque/posicao-estoque') ?>">Posição
                                        de Estoque</a>
                                </div>
                                <div class="col-md-6">
                                    <span class="dropdown-label">Relatórios</span>
                                    <a class="dropdown-item"
                                        href="<?= base_url('relatorios/movimentacao-produto') ?>">Mov. por Produto</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="<?= base_url('estoque/indicadores-estoque') ?>">Indicadores de Estoque</a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php } ?>
                    <?php if(getDadosUsuarioLogado()['financeiro'] == 1) { ?>
                    <li class="nav-item dropdown show-on-hover dropdown-cols-2">
                        <a class="nav-link <?php if($menu == 'Financeiro') echo "active"; ?> dropdown-toggle" href="#"
                            id="dropdown01" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">Financeiro</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown01">
                            <div class="row">
                                <div class="col-md-6">
                                    <span class="dropdown-label">Controle</span>
                                    <a class="dropdown-item" href="<?= base_url('financeiro/contas-pagar') ?>">Contas a
                                        Pagar</a>
                                    <a class="dropdown-item" href="<?= base_url('financeiro/contas-receber') ?>">Contas
                                        a Receber</a>
                                    <a class="dropdown-item" href="<?= base_url('financeiro/saldo-conta') ?>">Saldo por
                                        Conta</a>
                                </div>
                                <div class="col-md-6">
                                    <span class="dropdown-label">Relatórios</span>
                                    <a class="dropdown-item"
                                        href="<?= base_url('relatorios/movimentacao-conta') ?>">Movimentos por Conta</a>
                                    <a class="dropdown-item"
                                        href="<?= base_url('relatorios/resultado-conta-contabil') ?>">Result por C.
                                        Contábil</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                        href="<?= base_url('financeiro/indicadores-financeiro') ?>">Indicadores
                                        Financeiros</a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php } ?>
                    <li class="nav-item dropdown show-on-hover dropdown-cols-2">
                        <a class="nav-link <?php if($menu == 'Cadastro') echo "active"; ?> dropdown-toggle" href="#"
                            id="dropdown01" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">Cadastros</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown01">
                            <div class="row">
                                <div class="col-md-6">
                                    <span class="dropdown-label">Produto</span>
                                    <?php if(getDadosUsuarioLogado()['producao'] == 1) { ?>
                                    <a class="dropdown-item" href="<?= base_url('produto') ?>">Produto</a>
                                    <?php } ?>
                                    <?php if(getDadosUsuarioLogado()['producao'] == 1) { ?>
                                    <a class="dropdown-item" href="<?= base_url('estrutura-produto') ?>">Estrutura de
                                        Produto</a>
                                    <?php } ?>
                                    <?php if(getDadosUsuarioLogado()['producao'] == 1) { ?>
                                    <a class="dropdown-item" href="<?= base_url('unidade-medida') ?>">Unidade de
                                        Medida</a>
                                    <a class="dropdown-item" href="<?= base_url('tipo-produto') ?>">Tipo de Produto</a>
                                    <?php } ?>
                                    <span class="dropdown-label">Pessoa</span>
                                    <?php if(getDadosUsuarioLogado()['vendas'] == 1) { ?>
                                    <a class="dropdown-item" href="<?= base_url('cliente') ?>">Cliente</a>
                                    <?php } ?>
                                    <?php if(getDadosUsuarioLogado()['compras'] == 1) { ?>
                                    <a class="dropdown-item" href="<?= base_url('fornecedor') ?>">Fornecedor</a>
                                    <?php } ?>
                                    <?php if(getDadosUsuarioLogado()['vendas'] == 1) { ?>
                                    <a class="dropdown-item" href="<?= base_url('vendedor') ?>">Vendedor</a>
                                    <?php } ?>
                                </div>
                                <div class="col-md-6">
                                    <span class="dropdown-label">Financeiro</span>
                                    <?php if(getDadosUsuarioLogado()['financeiro'] == 1) { ?>
                                    <a class="dropdown-item" href="<?= base_url('conta') ?>">Conta Financeira</a>
                                    <a class="dropdown-item" href="<?= base_url('metodo-pagamento') ?>">Método de Pagamento</a>
                                    <a class="dropdown-item" href="<?= base_url('conta-contabil') ?>">Conta Contábil</a>
                                    <a class="dropdown-item" href="<?= base_url('centro-custo') ?>">Centro de Custo</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li class="nav-item dropdown dropdown-icon-right show-on-hover margem-direita-10">
                        <a class="nav-link " href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"><i class="fas fa-user"></i></a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown01">
                            <span class="dropdown-label"><?= getDadosUsuarioLogado()['nome_usuario'] ?></span>
                            <div class="dropdown-divider"></div>
                            <span class="dropdown-label text-dark"><?= getDadosUsuarioLogado()['nome_empresa'] ?></span>
                            <span class="dropdown-label text-dark">ID Cliente:
                                <?= getDadosUsuarioLogado()['id_empresa'] ?></span>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= base_url('meus-dados') ?>">Meus Dados</a>
                            <a class="dropdown-item" href="<?= base_url('logout') ?>">Sair</a>
                        </div>
                    </li>
                    <?php if(getDadosUsuarioLogado()['tipo_acesso'] == 1) { ?>
                    <li class="nav-item dropdown show-on-hover">
                        <a class="nav-link " href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"><i class="fas fa-cog"></i></a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown01">
                            <a class="dropdown-item" href="<?= base_url('dados-empresa') ?>">Dados da Minha Empresa</a>
                            <a class="dropdown-item" href="<?= base_url('natureza-opercao') ?>">Natureza de Operação</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= base_url('usuario') ?>">Usuários da Empresa</a>
                        </div>
                    </li>
                    <?php } ?>
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