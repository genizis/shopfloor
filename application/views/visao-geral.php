<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;">
        <div style="position: absolute; top: 20; right: 20;">

            <?php if($dias_periodo <= 5) { ?>
            <div class="toast" data-autohide="false" id="myToast">
                <div class="toast-header">
                    <strong class="mr-auto"><i class="fas fa-bell text-danger"></i> Período de validade próximo do
                        fim!</strong>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                </div>
                <div class="toast-body">
                    Seu acesso ao ShopFloor expirará em <strong><?= $dias_periodo ?> dia(s)</strong>,
                    entre em contato conosco através do telefone (42) 9 8819 2794 ou pelo e-mail
                    contato@shopfloor.com.br para renovação</a>
                </div>
            </div>
            <?php } ?>

            <?php if($num_produto == 0) { ?>
            <div class="toast" data-autohide="false" id="myToast1">
                <div class="toast-header">
                    <strong class="mr-auto"><i class="fas fa-bell text-info"></i> Seja bem-vindo ao ShopFloor!</strong>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                </div>
                <div class="toast-body">
                    Comece cadastrando seus produtos vendidos e comprados clicando <a
                        href="<?= base_url('produto/novo-produto') ?>">aqui!</a>
                </div>
            </div>
            <?php } ?>

            <?php if($num_produto == 0) { ?>
            <div class="toast" data-autohide="false" id="myToast2">
                <div class="toast-header">
                    <strong class="mr-auto"><i class="fas fa-bell text-info"></i> Não se esqueça da estrutura de
                        produto!</strong>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
                </div>
                <div class="toast-body">
                    Crie a lista de materiais dos seus produtos produzidos clicando <a
                        href="<?= base_url('estrutura-produto/nova-estrutura-produto') ?>">aqui!</a>
                </div>
            </div>
            <?php } ?>

        </div>
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 class="display-4"><?= $empresa->nome_empresa ?></h1>
                <h1 class="text-muted">Olá, <?= getDadosUsuarioLogado()['nome_usuario'] ?></h1>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="mb-2"><strong>Precisa de ajuda com o ShopFloor?</strong></h5>
                        <p class="card-text text-dark">Nós temos um canal específico para isto, entre em contato conosco através do e-mail: <a href="mailto:suporte@shopfloor.com.br" class="text-info">suporte@shopfloor.com.br</a></p>
                        <p class="card-text text-dark">Responderemos o mais breve possível!</p>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <p class="card-text text-dark">Para apoio comercial ou dúvida sobre seu plano, entre em contato conosco através do e-mail: <a href="mailto:comercial@shopfloor.com.br" class="text-info">comercial@shopfloor.com.br</a> ou pelo telefone <i>(42) 9 8819 2794</i></p>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="mb-2"><strong>Tem alguma crítica ou sugestão de melhoria?</strong></h5>
                        <p class="card-text text-dark">Também temos um canal específico para isto, envie-nos um e-mail para o endereço <a href="mailto:sugestoes@shopfloor.com.br" class="text-info">sugestoes@shopfloor.com.br</a></p>
                    </div>
                </div>                
            </div>
            <div class="col-md-8">
                <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                    <?php $active = "active"; if(getDadosUsuarioLogado()['producao'] == 1) { ?>
                    <li class="nav-item">
                        <a class="nav-link text-dark <?php echo $active; $active = ""; ?>" id="producao-tab" data-toggle="tab" href="#producao"
                            role="tab" aria-controls="producao" aria-selected="true"><strong>PRODUÇÃO</strong></a>
                    </li>
                    <?php } ?>
                    <?php if(getDadosUsuarioLogado()['vendas'] == 1) { ?>
                    <li class="nav-item">
                        <a class="nav-link text-dark <?php echo $active; $active = ""; ?>" id="vendas-tab" data-toggle="tab" href="#vendas" role="tab"
                            aria-controls="vendas" aria-selected="false"><strong>VENDAS</strong></a>
                    </li>
                    <?php } ?>
                    <?php if(getDadosUsuarioLogado()['compras'] == 1) { ?>
                    <li class="nav-item">
                        <a class="nav-link text-dark <?php echo $active; $active = ""; ?>" id="compras-tab" data-toggle="tab" href="#compras" role="tab"
                            aria-controls="compras" aria-selected="false"><strong>COMPRAS</strong></a>
                    </li>
                    <?php } ?>
                    <?php if(getDadosUsuarioLogado()['estoque'] == 1) { ?>
                    <li class="nav-item">
                        <a class="nav-link text-dark <?php echo $active; $active = ""; ?>" id="estoque-tab" data-toggle="tab" href="#estoque" role="tab"
                            aria-controls="estoque" aria-selected="false"><strong>ESTOQUE</strong></a>
                    </li>
                    <?php } ?>
                    <?php if(getDadosUsuarioLogado()['financeiro'] == 1) { ?>
                    <li class="nav-item">
                        <a class="nav-link text-dark <?php echo $active; $active = ""; ?>" id="financeiro-tab" data-toggle="tab" href="#financeiro"
                            role="tab" aria-controls="financeiro" aria-selected="false"><strong>FINANCEIRO</strong></a>
                    </li>
                    <?php } ?>
                </ul>
                <div class="card  mb-5">
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <?php $active = "show active"; if(getDadosUsuarioLogado()['producao'] == 1) { ?>
                            <div class="tab-pane fade <?php echo $active; $active = ""; ?>" id="producao" role="tabpanel"
                                aria-labelledby="producao-tab">
                                <div class="row mb-4">
                                    <div class="col-md-5 text-center">
                                        <h1 class="<?php if($custo_total->custo_total > 0) echo "text-danger"; ?> display-4 mt-4 font-weight-bold">R$
                                            <?= number_format($custo_total->custo_total, 2, ',', '.') ?></h1>
                                        <p class="card-text lead text-muted mb-3 font-weight-lighterer">Custo de produção no
                                            período</p>
                                    </div>
                                    <div class="col-md-7">
                                        <canvas id="graph-producao" height="100"></canvas>
                                    </div>
                                </div>
                                <table class="table table-borderless small mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="text-center">Ord Produção</th>
                                            <th scope="col">Produto</th>
                                            <th scope="col" class="text-center">Data Entrega</th>
                                            <th scope="col" class="text-center">Qtde Produção</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($lista_producoes as $key_producoes => $producoes) { ?>
                                        <tr>
                                            <td class="text-center"><a
                                                    href="<?= base_url("producao/reporte-producao/novo-reporte-producao/{$producoes->num_ordem_producao}") ?>"><?= $producoes->num_ordem_producao ?></a></td>
                                            <td><?= $producoes->cod_produto ?> - <?= $producoes->nome_produto ?></td>
                                            <td class="text-center">
                                                <?= str_replace('-', '/', date("d-m-Y", strtotime($producoes->data_fim))) ?>
                                            </td>
                                            <td class="text-center">
                                                <?= number_format($producoes->quant_planejada, 3, ',', '.') ?>
                                                <?= $producoes->cod_unidade_medida ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php if ($lista_producoes == false) { ?>
                                <div class="text-center mt-3">
                                    <p class="mb-0 text-muted">Sem produção pendente</p>
                                </div>
                                <?php } ?>
                            </div>
                            <?php } ?>
                            <?php if(getDadosUsuarioLogado()['vendas'] == 1) { ?>
                            <div class="tab-pane fade <?php echo $active; $active = ""; ?>" id="vendas" role="tabpanel" aria-labelledby="vendas-tab">
                                <div class="row mb-4">
                                    <div class="col-md-5 text-center">
                                        <h1 class="<?php if($venda_total->valor_total > 0) echo "text-teal"; ?> display-4 mt-4 font-weight-bold">R$
                                            <?= number_format($venda_total->valor_total, 2, ',', '.') ?></h1>
                                        <p class="card-text lead text-muted mb-3 font-weight-lighter">Vendas efetuadas no
                                            período</p>
                                    </div>
                                    <div class="col-md-7">
                                        <canvas id="graph-vendas" height="100"></canvas>
                                    </div>
                                </div>
                                <table class="table table-borderless small mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="text-center">Pedido Venda</th>
                                            <th scope="col">Cliente</th>
                                            <th scope="col" class="text-center">Data Entrega</th>
                                            <th scope="col" class="text-center">Total Pedido</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($lista_pedido_venda as $key_vendas => $vendas) { ?>
                                        <tr>
                                            <td class="text-center"><a href="<?= base_url("vendas/faturamento-pedido/novo-faturamento-pedido/{$vendas->num_pedido_venda}") ?>"><?= $vendas->num_pedido_venda ?></a>
                                            </td>
                                            <td><?= $vendas->cod_cliente ?> - <?= $vendas->nome_cliente ?></td>
                                            <td class="text-center">
                                                <?= str_replace('-', '/', date("d-m-Y", strtotime($vendas->data_entrega))) ?>
                                            </td>
                                            <td class="text-center text-teal">R$
                                                <?= number_format($vendas->valor_total_pedido, 2, ',', '.') ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table> 
                                <?php if ($lista_pedido_venda == false) { ?>
                                <div class="text-center mt-3">
                                    <p class="mb-0 text-muted">Sem vendas pendentes</p>
                                </div>
                                <?php } ?>                               
                            </div>
                            <?php } ?>
                            <?php if(getDadosUsuarioLogado()['compras'] == 1) { ?>
                            <div class="tab-pane fade <?php echo $active; $active = ""; ?>" id="compras" role="tabpanel" aria-labelledby="compras-tab">
                                <div class="row mb-4">
                                    <div class="col-md-5 text-center">
                                        <h1 class="<?php if($compra_total->valor_total > 0) echo "text-warning"; ?> display-4 mt-4 font-weight-bold">R$
                                            <?= number_format($compra_total->valor_total, 2, ',', '.') ?></h1>
                                        <p class="card-text lead text-muted mb-3 font-weight-lighter">Compras efetuadas no
                                            período</p>
                                    </div>
                                    <div class="col-md-7">
                                        <canvas id="graph-compras" height="100"></canvas>
                                    </div>
                                </div>
                                <table class="table table-borderless small mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="text-center">Pedido Compra</th>
                                            <th scope="col">Fornecedor</th>
                                            <th scope="col" class="text-center">Data Entrega</th>
                                            <th scope="col" class="text-center">Total Pedido</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($lista_pedido_compra as $key_compras => $compras) { ?>
                                        <tr>
                                            <td class="text-center"><a href="<?= base_url("compras/recebimento-material/novo-recebimento-material/{$compras->num_pedido_compra}") ?>"><?= $compras->num_pedido_compra ?></a>
                                            </td>
                                            <td><?= $compras->cod_fornecedor ?> - <?= $compras->nome_fornecedor ?></td>
                                            <td class="text-center">
                                                <?= str_replace('-', '/', date("d-m-Y", strtotime($compras->data_entrega))) ?>
                                            </td>
                                            <td class="text-center text-warning">R$
                                                <?= number_format($compras->valor_total_pedido, 2, ',', '.') ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php if ($lista_pedido_compra == false) { ?>
                                <div class="text-center mt-3">
                                    <p class="mb-0 text-muted">Sem compras pendentes</p>
                                </div>
                                <?php } ?>
                            </div>
                            <?php } ?>
                            <?php if(getDadosUsuarioLogado()['estoque'] == 1) { ?>
                            <div class="tab-pane fade <?php echo $active; $active = ""; ?>" id="estoque" role="tabpanel" aria-labelledby="estoque-tab">
                                <div class="row mb-4">
                                    <div class="col-md-5 text-center">
                                        <h1 class="display-4 text-dark mt-4 font-weight-bold">R$
                                            <?= number_format($total_estoque->total_estoq, 2, ',', '.') ?></h1>
                                        <p class="card-text lead text-muted mb-3 font-weight-lighter">Valor em estoque</p>
                                    </div>
                                    <div class="col-md-7">
                                        <canvas id="graph-estoque" height="100"></canvas>
                                    </div>
                                </div>
                                <table class="table table-borderless small mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="text-center">Código</th>
                                            <th scope="col">Produto</th>
                                            <th scope="col">Motivo</th>
                                            <th scope="col" class="text-center">Estoq Atual</th>
                                            <th scope="col" class="text-center">Estoq Mínimo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($lista_estoque as $key_estoque => $estoque) { ?>
                                        <tr>
                                            <td class="text-center"><a href="<?= base_url("estoque/posicao-estoque/movimento-produto/{$estoque->cod_produto}") ?>"><?= $estoque->cod_produto ?></a>
                                            </td>
                                            <td><?= $estoque->nome_produto ?></td>
                                            <td>
                                                <?php if($estoque->quant_estoq >= 0) {
                                                      echo "Abaixo do estoque mínimo";
                                                  }else{
                                                      echo "Estoque negativo";
                                                  } ?>
                                            </td>
                                            <td
                                                class="text-center <?php if($estoque->quant_estoq < 0) echo "text-danger"; else echo "text-warning"; ?>">
                                                <?= number_format($estoque->quant_estoq, 3, ',', '.') ?>
                                                <?= $estoque->cod_unidade_medida ?>
                                            </td>
                                            <td class="text-center">
                                                <?= number_format($estoque->estoq_min, 3, ',', '.') ?>
                                                <?= $estoque->cod_unidade_medida ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php if ($lista_estoque == false) { ?>
                                <div class="text-center mt-3">
                                    <p class="mb-0 text-muted">Sem pendências no estoque</p>
                                </div>
                                <?php } ?>
                            </div>
                            <?php } ?>
                            <?php if(getDadosUsuarioLogado()['financeiro'] == 1) { ?>
                            <div class="tab-pane fade <?php echo $active; $active = ""; ?>" id="financeiro" role="tabpanel" aria-labelledby="financeiro-tab">
                                <div class="row mb-4">
                                    <div class="col-md-5 text-center">
                                        <h1 class="display-4 mt-4 font-weight-bold <?php if($total_conta->total_conta > 0) echo "text-teal";
                                                                                        elseif($total_conta->total_conta < 0) echo "text-danger";
                                                                                        else echo "text-dark"; ?>">R$
                                            <?= number_format($total_conta->total_conta, 2, ',', '.') ?></h1>
                                        <p class="card-text lead text-muted mb-3 font-weight-lighter">Saldo disponível</p>
                                    </div>
                                    <div class="col-md-7">
                                        <canvas id="graph-financeiro" height="100"></canvas>
                                    </div>
                                </div>
                                <table class="table table-borderless small mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="text-center">Título</th>                                            
                                            <th scope="col">Descrição</th>
                                            <th scope="col" class="text-center">Vencimento</th>
                                            <th scope="col" class="text-center">Valor Título</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($lista_titulos as $key_titulos => $titulos) { ?>
                                        <tr>
                                            <td class="text-center"><a href="<?php if($titulos->tipo_movimento == 1) echo base_url("financeiro/contas-receber"); 
                                                                                   elseif($titulos->tipo_movimento == 2) echo base_url("financeiro/contas-pagar");?>"><?= $titulos->cod_movimento_conta ?></a>
                                            </td>                                            
                                            <td><?= $titulos->desc_movimento ?></td>
                                            <td
                                                class="text-center 
                                                            <?php if($titulos->data_vencimento < date('Y-m-d')) echo "text-danger"; ?>
                                                            <?php if($titulos->data_vencimento == date('Y-m-d')) echo "text-warning"; ?>">
                                                <?= str_replace('-', '/', date("d-m-Y", strtotime($titulos->data_vencimento))) ?>
                                                <?php if($titulos->data_vencimento < date('Y-m-d')) { ?>
                                                <span class="badge badge-danger">
                                                    <?php 
                                                        $date1 = date_create($titulos->data_vencimento);
                                                        $date2 = date_create(date('Y-m-d'));
                                                        $diff = date_diff($date1,$date2);
                                                        echo $diff->format("%a"); 
                                                    ?>
                                                </span>
                                                <?php } ?>
                                            </td>
                                            <td
                                                class="text-center <?php if($titulos->tipo_movimento == 1) echo "text-teal"; else echo "text-danger"; ?>">
                                                R$ <?php if($titulos->tipo_movimento == 2) echo "-"; ?><?= number_format($titulos->valor_titulo, 2, ',', '.') ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php if ($lista_titulos == false) { ?>
                                <div class="text-center mt-3">
                                    <p class="mb-0 text-muted">Sem títulos pendentes</p>
                                </div>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>



<script>
new Chart(document.getElementById("graph-producao"), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($label_cod_prod); ?>,
        datasets: [{
            label: "Custo Total",
            backgroundColor: ["#15a689", "#8e5ea2", "#adb5bd"],
            data: <?php echo json_encode($valor_custo_prod); ?>
        }]
    },
    options: {
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var indice = tooltipItem.index;
                    return "R$ " + tooltipItem.yLabel.toLocaleString("pt-BR", {
                        style: "decimal",
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                    });
                },
                title: function(tooltipItem, data) {
                    var indice = tooltipItem[0].index;
                    var desc_produto = <?php echo json_encode($label_nome_prod); ?>;
                    return tooltipItem[0].xLabel + " - " + desc_produto[indice];
                }
            }
        },
        legend: {
            display: false
        },
        scales: {
            xAxes: [{
                gridLines: {
                    display: false,
                }
            }],
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    maxTicksLimit: 4,
                    callback: function(value, index, values) {
                        return "R$ " + value.toLocaleString("pt-BR", {
                            style: "decimal",
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                    }
                },
                gridLines: {
                    display: false,
                }
            }]
        }
    }
});

new Chart(document.getElementById("graph-vendas"), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($label_cod_cli); ?>,
        datasets: [{
            label: "Venda Total",
            backgroundColor: ["#15a689", "#8e5ea2", "#adb5bd"],
            data: <?php echo json_encode($valor_custo_cli); ?>
        }]
    },
    options: {
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var indice = tooltipItem.index;
                    return "R$ " + tooltipItem.yLabel.toLocaleString("pt-BR", {
                        style: "decimal",
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                    });
                },
                title: function(tooltipItem, data) {
                    var indice = tooltipItem[0].index;
                    var nome_cliente = <?php echo json_encode($label_nome_cli); ?>;
                    return tooltipItem[0].xLabel + " - " + nome_cliente[indice];
                }
            }
        },
        legend: {
            display: false
        },
        scales: {
            xAxes: [{
                gridLines: {
                    display: false,
                }
            }],
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    maxTicksLimit: 4,
                    callback: function(value, index, values) {
                        return "R$ " + value.toLocaleString("pt-BR", {
                            style: "decimal",
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                    }
                },
                gridLines: {
                    display: false,
                }
            }]
        }
    }
});

new Chart(document.getElementById("graph-compras"), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($label_cod_for); ?>,
        datasets: [{
            label: "Compra Total",
            backgroundColor: ["#15a689", "#8e5ea2", "#adb5bd"],
            data: <?php echo json_encode($valor_custo_for); ?>
        }]
    },
    options: {
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var indice = tooltipItem.index;
                    return "R$ " + tooltipItem.yLabel.toLocaleString("pt-BR", {
                        style: "decimal",
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                    });
                },
                title: function(tooltipItem, data) {
                    var indice = tooltipItem[0].index;
                    var nome_fornecedor = <?php echo json_encode($label_nome_for); ?>;
                    return tooltipItem[0].xLabel + " - " + nome_fornecedor[indice];
                }
            }
        },
        legend: {
            display: false
        },
        scales: {
            xAxes: [{
                gridLines: {
                    display: false,
                }
            }],
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    maxTicksLimit: 4,
                    callback: function(value, index, values) {
                        return "R$ " + value.toLocaleString("pt-BR", {
                            style: "decimal",
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                    }
                },
                gridLines: {
                    display: false,
                }
            }]
        }
    }
});

new Chart(document.getElementById("graph-estoque"), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($label_cod_est); ?>,
        datasets: [{
            label: "Estoque Total",
            backgroundColor: ["#15a689", "#8e5ea2", "#adb5bd"],
            data: <?php echo json_encode($valor_custo_est); ?>
        }]
    },
    options: {
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var indice = tooltipItem.index;
                    return "R$ " + tooltipItem.yLabel.toLocaleString("pt-BR", {
                        style: "decimal",
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                    });
                },
                title: function(tooltipItem, data) {
                    var indice = tooltipItem[0].index;
                    var nome_estoque = <?php echo json_encode($label_nome_est); ?>;
                    return tooltipItem[0].xLabel + " - " + nome_estoque[indice];
                }
            }
        },
        legend: {
            display: false
        },
        scales: {
            xAxes: [{
                gridLines: {
                    display: false,
                }
            }],
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    maxTicksLimit: 4,
                    callback: function(value, index, values) {
                        return "R$ " + value.toLocaleString("pt-BR", {
                            style: "decimal",
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                    }
                },
                gridLines: {
                    display: false,
                }
            }]
        }
    }
});

new Chart(document.getElementById("graph-financeiro"), {
    type: 'bar',
    data: {
        labels: ["Total Entradas", "Total Saídas"],
        datasets: [{
            label: "Estoque Total",
            backgroundColor: ["#15a689", "#d9534f"],
            data: [<?php echo $lista_titulos_confirmados->total_entrada; ?>, <?php echo $lista_titulos_confirmados->total_saida; ?>],
        }]
    },
    options: {
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var indice = tooltipItem.index;
                    return "R$ " + tooltipItem.yLabel.toLocaleString("pt-BR", {
                        style: "decimal",
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                    });
                },
            }
        },
        legend: {
            display: false
        },
        scales: {
            xAxes: [{
                gridLines: {
                    display: false,
                }
            }],
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    maxTicksLimit: 4,
                    callback: function(value, index, values) {
                        return "R$ " + value.toLocaleString("pt-BR", {
                            style: "decimal",
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                    }
                },
                gridLines: {
                    display: false,
                }
            }]
        }
    }
});


$(document).ready(function() {
    $("#myToast").toast('show');
});
$(document).ready(function() {
    $("#myToast1").toast('show');
});
$(document).ready(function() {
    $("#myToast2").toast('show');
});
$(document).ready(function() {
    $("#myToast3").toast('show');
});
$(document).ready(function() {
    $("#myToast4").toast('show');
});
</script>

</script>

<?php $this->load->view('gerais/footer'); ?>