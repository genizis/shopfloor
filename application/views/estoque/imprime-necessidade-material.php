<?php $this->load->view('gerais/header' , $menu); ?>

<section>
    <div class="container-cupom mt-5">
        <div class="row border-bottom border-dark mb-3">
            <div class="col-6">
                <h3 class="text-black-50">
                    <?php
                    switch ($necessidade->status) {
                        case 1:
                            echo "<span class='badge badge-secondary'>Em Planejamento</span>";
                            break;
                        case 2:
                            echo "<span class='badge badge-info'>Calculado</span>";
                            break;
                        case 3:
                            echo "<span class='badge badge-teal'>Efetivado</span>";
                            break;
                    }                                                        
                ?>
                </h3>
            </div>
            <div class="col-6 text-right">
                <h3 class="text-black-50 mb-3">Cálculo de Necessidade <strong
                        class="text-dark"><?= $necessidade->cod_calculo_necessidade ?></strong></h3>
            </div>
        </div>
        <div class="row border-bottom border-dark mb-3">
            <div class="col-12">
                <h1 class="text-uppercase mb-2"><strong><?= $empresa->nome_empresa ?></strong></h1>
                <h3 class="text-muted mb-3">
                    Entregas previstas de
                    <strong
                        class="text-dark"><?= str_replace("-", "/", date("d-m-Y", strtotime($necessidade->data_inicio))) ?></strong>
                    a
                    <strong
                        class="text-dark"><?= str_replace("-", "/", date("d-m-Y", strtotime($necessidade->data_fim))) ?></strong>
                </h3>
            </div>
        </div>
        <?php if($necessidade->observacoes != ""){ ?>
        <div class="row border-bottom border-dark mb-3">
            <div class="col-12">
                <p class="lead text-uppercase"><?= $necessidade->observacoes ?></p>
            </div>
        </div>
        <?php } ?>
        <?php if($lista_pedido != false) { ?>
        <div class="row border-bottom border-dark mb-3">
            <div class="col-12">
                <h3 class="text-uppercase mb-2"><strong>Pedidos a Entregar</strong></h3>
            </div>
            <table class="table table-bordered table-hover h4 mb-4">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" class="text-center">Ped Venda</th>
                        <th scope="col">Nome do Cliente</th>
                        <th scope="col" class="text-center">Data de Emissão</th>
                        <th scope="col" class="text-center">Data de Entrega</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($lista_pedido as $key_pedido => $pedido) { ?>
                    <tr>
                        <td scope="row" class="text-center">
                            <?= $pedido->num_pedido_venda ?>
                        </td>
                        <td><span class="text-black-50"><?= $pedido->cod_cliente ?></span> -
                            <?= $pedido->nome_cliente ?></td>
                        <td class="text-center">
                            <?= str_replace('-', '/', date("d-m-Y", strtotime($pedido->data_emissao))) ?>
                        </td>
                        <td class="text-center">
                            <?= str_replace('-', '/', date("d-m-Y", strtotime($pedido->data_entrega))) ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php } ?>
        <?php if($lista_producao != false) { ?>
        <div class="row border-bottom border-dark mb-3">
            <div class="col-12">
                <h3 class="text-uppercase mb-2"><strong>Produtos a Produzir</strong></h3>
            </div>            
            <table class="table table-bordered table-hover h4 mb-4">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Produto de Produção</th>
                        <th scope="col" class="text-center">Unid Medida</th>
                        <th scope="col" class="text-center">Qtde Necessária
                        </th>
                        <th scope="col" class="text-center">Data Necessidade
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($lista_producao as $key_producao => $producao) { ?>
                    <tr>
                        <td><span class="text-black-50"><?= $producao->cod_produto ?></span> -
                            <?= $producao->nome_produto ?></td>
                        <td class="text-center">
                            <?= $producao->cod_unidade_medida ?>
                        </td>
                        <td class="text-center">
                            <?= number_format($producao->quant_necessidade, 3, ',', '.') ?>
                        </td>
                        <td class="text-center">
                            <?= str_replace('-', '/', date("d-m-Y", strtotime($producao->data_necessidade))) ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php } ?>
        <?php if($lista_compra != false) { ?>
        <div class="row border-bottom border-dark mb-3">
            <div class="col-12">
                <h3 class="text-uppercase mb-2"><strong>Produtos a Comprar</strong></h3>
            </div>             
            <table class="table table-bordered table-hover h4 mb-4">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Produto de Compra</th>
                        <th scope="col" class="text-center">Unid Medida</th>
                        <th scope="col" class="text-center">Qtde Necessária</th>
                        <th scope="col" class="text-center">Data Necessidade
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($lista_compra as $key_compra => $compra) { ?>
                    <tr>
                        <td><span class="text-black-50"><?= $compra->cod_produto ?></span> - <?= $compra->nome_produto ?></td>
                        <td class="text-center">
                            <?= $compra->cod_unidade_medida ?>
                        </td>
                        <td class="text-center">
                            <?= number_format($compra->quant_necessidade, 3, ',', '.') ?>
                        </td>
                        <td class="text-center">
                            <?= str_replace('-', '/', date("d-m-Y", strtotime($compra->data_necessidade))) ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php } ?>
        <div class="text-center h5">
            www.shopfloor.com.br
        </div>
    </div>
</section>

<?php $this->load->view('gerais/footer'); ?>