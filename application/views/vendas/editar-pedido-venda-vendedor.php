<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu-vendedor', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('vendas/pedido-venda-vendedor') ?>">Minhas Vendas</a></li>
            <li class="breadcrumb-item active">Editar Pedido de Venda</a></li>
        </ol>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 mb-3">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <?php if ($this->session->flashdata('erro') <> ""){ ?>
                        <div class="alert alert-danger alert-dismissible fade show" id="alert" role="alert">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Atenção!</strong> <?= $this->session->flashdata('erro') ?>
                        </div>
                        <?php } $this->session->set_flashdata('erro', ''); ?>
                        <?php if ($this->session->flashdata('sucesso') <> ""){ ?>
                        <div class="alert alert-success alert-dismissible fade show" id="alert" role="alert">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Muito bem!</strong>
                            <?= $this->session->flashdata('sucesso') ?>
                        </div>
                        <?php } $this->session->set_flashdata('sucesso', ''); ?>
                        <form class="mb-0 needs-validation" novalidate
                            action="<?= base_url("vendas/pedido-venda-vendedor/editar-pedido-venda-vendedor/{$pedido->num_pedido_venda}") ?>"
                            method="POST" id="PedidoVenda">
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label class="control-label" for="inputNumPedido">Número do Pedido</label>
                                    <input class="form-control" id="inputNumPedido" type="text" readonly
                                        value="<?= $pedido->num_pedido_venda ?>">
                                </div>
                                <div class="form-group col-md-7">
                                    <label class="control-label" for="inputCodCliente">Cliente</label>
                                    <input class="form-control" id="inputCodCliente" type="text" readonly
                                        value="<?= $pedido->cod_cliente ?> - <?= $pedido->nome_cliente ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputSituacao">Situação da Venda</label>
                                    <?php if($pedido->quant_atendida == 0) { ?>
                                    <select id="inputSituacao" class="selectpicker show-tick form-control"
                                        data-actions-box="true" data-style="btn-input-primary" name="Situacao">
                                        <option value="1" <?php if($pedido->situacao == 1) echo "selected"; ?>>
                                            Em Orçamento</option>
                                        <option value="2" <?php if($pedido->situacao == 2) echo "selected"; ?>>
                                            Orçamento Reprovado</option>
                                        <option value="3" <?php if($pedido->situacao == 3) echo "selected"; ?>>
                                            Venda Confirmada</option>
                                    </select>
                                    <?php }else{ ?>
                                    <input class="form-control" id="inputCodCliente" type="text" disabled value="<?php
                                                        if($pedido->situacao == 1) echo "Em Orçamento";
                                                        if($pedido->situacao == 2) echo "Orçamento Reprovado";
                                                        if($pedido->situacao == 3) echo "Venda Confirmada";
                                                       ?>">
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputDateEmissao">Data de Emissão</label>
                                    <input type="text" class="form-control" id="inputDateEmissao" name="DataEmissao"
                                        readonly
                                        value="<?= str_replace('-', '/', date("d-m-Y", strtotime($pedido->data_emissao))) ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputDateEntrega">Data de Entrega <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="inputDateEntrega" name="DataEntrega"
                                        value="<?= str_replace('-', '/', date("d-m-Y", strtotime($pedido->data_entrega))) ?>"
                                        required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputTipoDesconto">Desconto</label>
                                    <div class="input-group">
                                        <select id="inputTipoDesconto" class="selectpicker show-tick form-control"
                                            data-actions-box="true" data-style="btn-input-primary" name="TipoDesconto">
                                            <option value="1" <?php if($pedido->tipo_desconto == 1) echo "selected"; ?>>
                                                R$
                                            </option>
                                            <option value="2" <?php if($pedido->tipo_desconto == 2) echo "selected"; ?>>
                                                %
                                            </option>
                                        </select>
                                        <input type="text" class="form-control" data-mask="#.##0,00"
                                            data-mask-reverse="true" name="Desconto" id="inputDesconto"
                                            value="<?= number_format($pedido->valor_desconto, 2, ',', '.') ?>">
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputTipoFrete">Frete</label>
                                    <div class="input-group">
                                        <select id="inputTipoFrete" class="selectpicker show-tick form-control"
                                            data-actions-box="true" data-style="btn-input-primary" name="TipoFrete">
                                            <option value="1" <?php if($pedido->tipo_frete == 1) echo "selected"; ?>>CIF
                                                R$</option>
                                            <option value="2" <?php if($pedido->tipo_frete == 2) echo "selected"; ?>>FOB
                                                R$</option>
                                        </select>
                                        <input type="text" class="form-control" data-mask="#.##0,00"
                                            data-mask-reverse="true" name="Frete"
                                            value="<?= number_format($pedido->valor_frete, 2, ',', '.') ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputObservacao">Observações do Pedido de Venda</label>
                                    <textarea class="form-control" rows="3" id="inputObservacao"
                                        name="ObsPedidoVenda"><?= $pedido->observacoes ?></textarea>
                                </div>
                            </div>
                        </form>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <h6>Lista de Produtos</h6>
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-12">
                                        <button data-toggle="modal" data-target="#inserir-produto" type="button"
                                            class="btn btn-outline-info btn-sm btn-block mb-2"><i
                                                class="fas fa-plus-circle"></i> Adicionar
                                            Produto</button>
                                    </div>
                                </div>
                                <form class="mb-0 needs-validation" novalidate
                                    action="<?= base_url('vendas/pedido-venda/excluir-produto-venda') ?>" method="POST"
                                    id="DeleteProdutoVenda">
                                    <input type="hidden" name="NumPedidoVenda" value="<?= $pedido->num_pedido_venda ?>">
                                    <div class="list-group">
                                        <?php $total = 0; foreach($lista_produto_venda as $key_produto_venda => $produto_venda) { 
                                            $total = $total + ($produto_venda->valor_unitario * $produto_venda->quant_pedida); ?>
                                        <a href="#" data-toggle="modal"
                                            data-target="#editar-produto<?= $produto_venda->seq_produto_venda ?>"
                                            class="list-group-item list-group-item-action flex-column align-items-start">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h5 class="mb-2">
                                                    <strong>
                                                        <?= $produto_venda->cod_produto ?> -
                                                        <?= $produto_venda->nome_produto ?>
                                                    </strong>
                                                </h5>
                                            </div>
                                            <h5 class="mb-2">
                                                <strong><span class="text-teal">R$
                                                        <?= number_format($produto_venda->valor_unitario * $produto_venda->quant_pedida, 2, ',', '.') ?></span></strong>
                                            </h5>
                                            <p class="mb-2">
                                                Quant Ped.
                                                <?= number_format($produto_venda->quant_pedida, 3, ',', '.') ?>,
                                                Quant Atend.
                                                <?= number_format($produto_venda->quant_atendida, 3, ',', '.') ?>
                                            </p>
                                            <span>
                                                <?php
                                                            if($pedido->data_entrega < date('Y-m-d') && $produto_venda->status != 3 && $produto_venda->status != 4){
                                                                 echo "<span class='badge badge-danger'>Atrasado</span>";

                                                            }else{
                                                                switch ($produto_venda->status) {
                                                                    case 1:
                                                                        echo "<span class='badge badge-secondary'>Pendente</span>";
                                                                        break;
                                                                    case 2:
                                                                        echo "<span class='badge badge-info'>Atendido Parcial</span>";
                                                                        break;
                                                                    case 3:
                                                                        echo "<span class='badge badge-teal'>Atendido Total</span>";
                                                                        break;
                                                                    case 4:
                                                                        echo "<span class='badge badge-dark'>Estornado</span>";
                                                                        break;
                                                                } 

                                                            }                                                        
                                                        ?>
                                            </span>
                                        </a>
                                        <?php } ?>
                                    </div>
                                    <?php if ($lista_produto_venda == false) { ?>
                                    <div class="text-center">
                                        <p>Nenhum produto cadastrado</p>
                                    </div>
                                    <?php }else{ ?>
                                    <div class="row">
                                        <div class="col-md-8"></div>
                                        <div class="col-md-4 col-12">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <th class="table-light">Total</th>
                                                        <td class="text-right"><strong>R$
                                                                <?= number_format($total, 2, ',', '.') ?></strong>
                                                        </td>
                                                    </tr>
                                                    <?php if($pedido->tipo_frete == 1 && $pedido->valor_frete > 0){ ?>
                                                    <tr>
                                                        <th class="table-light">Frete</th>
                                                        <td class="text-right"><strong>R$
                                                                <?= number_format($pedido->valor_frete, 2, ',', '.') ?></strong>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                    <tr>
                                                        <?php if($pedido->tipo_frete == 1) $total = $total + $pedido->valor_frete; ?>
                                                        <th class="table-light">Desconto</th>
                                                        <td class="text-right" id="inputValorDesconto">
                                                            <?php if($pedido->tipo_desconto == 1) echo "R$"; ?>
                                                            <?= number_format($pedido->valor_desconto, 2, ',', '.'); ?>
                                                            <?php if($pedido->tipo_desconto == 2) echo "%"; ?>
                                                        </td>
                                                    </tr>
                                                    <tr class="">
                                                        <th class="table-light"><strong>Total Líquido</strong>
                                                        </th>
                                                        <td class="text-right text-teal"><strong id="inputValorLiq">R$
                                                                <?php if($pedido->valor_desconto != 0){
                                                                            if($pedido->tipo_desconto == 1){
                                                                                echo number_format($total - $pedido->valor_desconto, 2, ',', '.');
                                                                            }elseif($pedido->tipo_desconto == 2){
                                                                                echo number_format($total - ($total * ($pedido->valor_desconto / 100)), 2, ',', '.');
                                                                            }
                                                                         }else{
                                                                             echo number_format($total, 2, ',', '.');
                                                                         }
                                                                    ?>
                                                            </strong></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </form>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-12">
                                <button type="submit" form="PedidoVenda" class="btn btn-primary btn-block mb-2"
                                    name="Opcao" value="salvar"><i class="fas fa-save"></i> Salvar</button>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-12">
                                <button data-toggle="modal" data-target="#inserir-faturamento" type="button"
                                    class="btn btn-teal btn-block mb-2"
                                    <?php if ($lista_produto == false || $pedido->situacao != 3) echo "disabled"; ?>><i
                                        class="fas fa-dollar-sign"></i> Faturar Pedido</button>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-12">
                                <a href="#"
                                    class="btn btn-warning <?php if($pedido->situacao == 2) echo "disabled"; ?> btn-block mb-2"
                                    type="button" id="imprimir"><i class="fas fa-print"></i> Imprimir Pedido</a>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-12">
                                <a href="<?php echo base_url() ?>vendas/pedido-venda-vendedor"
                                    class="btn btn-secondary btn-block mb-2">Cancelar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="inserir-produto">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Produto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <form class="mb-0 needs-validation" novalidate
                            action="<?= base_url("vendas/pedido-venda-vendedor/inserir-produto-venda-vendedor/{$pedido->num_pedido_venda}") ?>"
                            method='post' id='formProdutoVenda'>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputProdutoVenda">Código do Produto <span
                                            class="text-danger">*</span></label>
                                    <select id="inputProdutoVenda" class="selectpicker show-tick form-control"
                                        data-live-search="true" data-actions-box="true" title="Selecione um Produto"
                                        name="CodProduto" required>
                                        <?php foreach($lista_produto as $key_produto => $produto) { ?>
                                        <option value="<?= $produto->cod_produto ?>" class="limit-text-50"
                                            <?php if($produto->cod_produto == set_value('CodProduto')) echo "selected"; ?>>
                                            <?= $produto->cod_produto ?> - <?= $produto->nome_produto ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="inputTipoProduto">Tipo de Produto</label>
                                    <input class="form-control" id="inputTipoProduto" type="text" name="TipoProduto"
                                        readonly value="<?= set_value('TipoProduto'); ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="inputUnidadeMedida">Unidade de Medida</label>
                                    <input class="form-control" id="inputUnidadeMedida" type="text" name="UnidadeMedida"
                                        readonly value="<?= set_value('UnidadeMedida'); ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputQuantPedida">Quantidade Pedida <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="inputQuantPedida" name="QuantPedida"
                                        data-mask="#.##0,000" data-mask-reverse="true"
                                        value="<?= set_value('QuantPedida'); ?>" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="inputValorUnitario">Valor do Unitário <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" class="form-control" class="form-control"
                                            id="inputValorUnitario" type="text" name="ValorUnitario"
                                            data-mask="#.##0,00" data-mask-reverse="true"
                                            value="<?= set_value('ValorUnitario'); ?>" required>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="inputTotalVenda">Valor Total</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" class="form-control" class="form-control" readonly
                                            id="inputTotalVenda" type="text" name="TotalVenda" data-mask="#.##0,00"
                                            data-mask-reverse="true" value="<?= set_value('TotalVenda'); ?>">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="formProdutoVenda"><i class="fas fa-save"></i>
                    Salvar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<?php foreach($lista_produto_venda as $key_produto_venda => $produto_venda) { ?>
<div class="modal fade" id="editar-produto<?= $produto_venda->seq_produto_venda ?>">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Produto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <form class="mb-0 needs-validation" novalidate
                            action="<?= base_url("vendas/pedido-venda-vendedor/salvar-produto-venda-vendedor/{$pedido->num_pedido_venda}/{$produto_venda->seq_produto_venda}") ?>"
                            method='post' id='formProdutoVendaEdit<?= $produto_venda->seq_produto_venda ?>'>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="control-label" for="inputProdutoVendaEdit">Produto de Venda</label>
                                    <input class="form-control" id="inputProdutoVendaEdit" type="text"
                                        name="CodProdutoEdit"
                                        value="<?= $produto_venda->cod_produto ?> - <?= $produto_venda->nome_produto ?>"
                                        readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="inputTipoProdutoEdit">Tipo de Produto</label>
                                    <input class="form-control" id="inputTipoProdutoEdit" type="text"
                                        name="TipoProdutoEdit" value="<?= $produto_venda->nome_tipo_produto ?>"
                                        readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="inputUnidadeMedidaEdit">Unidade de Medida</label>
                                    <input class="form-control" id="inputUnidadeMedidaEdit" type="text"
                                        name="UnidadeMedidaEdit" value="<?= $produto_venda->cod_unidade_medida ?>"
                                        readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputQuantPedidaEdit">Quantidade Pedida <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="<?= $produto_venda->quant_pedida ?>"
                                        data-mask="#.##0,000" data-mask-reverse="true" id="inputQuantPedidaEdit"
                                        name="QuantPedidaEdit">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="inputValorUnitarioEdit">Valor Unitário <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" class="form-control" class="form-control"
                                            id="inputValorUnitarioEdit" type="text" name="ValorUnitarioEdit"
                                            data-mask="#.##0,00" data-mask-reverse="true"
                                            value="<?= number_format($produto_venda->valor_unitario, 2, ',', '.') ?>">
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="inputValorTotalEdit">Valor Total</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" class="form-control" class="form-control" readonly
                                            id="inputValorTotalEdit" type="text" name="ValorTotalEdit"
                                            data-mask="#.##0,00" data-mask-reverse="true"
                                            value="<?= number_format($produto_venda->valor_unitario * $produto_venda->quant_pedida, 2, ',', '.') ?>">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"
                    form="formProdutoVendaEdit<?= $produto_venda->seq_produto_venda ?>"><i class="fas fa-save"></i>
                    Salvar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<div class="modal fade" id="inserir-faturamento">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Faturar Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="mb-0 needs-validation" novalidate
                    action="<?= base_url("vendas/faturamento-pedido/inserir-faturamento-vendedor/{$pedido->num_pedido_venda}/{$pedido->cod_cliente}") ?>"
                    method="POST" id="InserirFaturamento">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label class="control-label" for="inputDataFaturamento">Data do Faturamento <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" id="inputDataFaturamento" type="text"
                                        name="DataFaturamento" value="<?php if(set_value('DataFaturamento') == ""){
                                                                echo str_replace('-', '/', date("d-m-Y"));
                                                            }else{ echo set_value('DataFaturamento'); } ?>" required>
                                </div>
                                <div class="form-group col-md-5">
                                    <label>Método de Pagamento</label>
                                    <select class="selectpicker show-tick form-control" data-live-search="true"
                                        data-actions-box="true" title="Selecione um Método de Pagamento"
                                        name="CodMetodoPagamento" data-style="btn-input-primary" required>
                                        <?php foreach($lista_metodo_pagamento as $key_metodo_pagamento => $metodo_pagamento) { ?>
                                        <option value="<?= $metodo_pagamento->cod_metodo_pagamento ?>"
                                            <?php if($metodo_pagamento->cod_metodo_pagamento == set_value('CodMetodoPagamento')) echo "selected"; ?>>
                                            <?= $metodo_pagamento->cod_metodo_pagamento ?> -
                                            <?= $metodo_pagamento->nome_metodo_pagamento ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputParcelas">Parcelamento</label>
                                    <select id="inputParcelas" class="selectpicker show-tick form-control"
                                        name="Parcelas" data-style="btn-input-primary">
                                        <option value="1">1x</option>
                                        <option value="2">2x</option>
                                        <option value="3">3x</option>
                                        <option value="4">4x</option>
                                        <option value="5">5x</option>
                                        <option value="6">6x</option>
                                        <option value="7">7x</option>
                                        <option value="8">8x</option>
                                        <option value="9">9x</option>
                                        <option value="10">10x</option>
                                        <option value="11">11x</option>
                                        <option value="12">12x</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="list-group list-group-flush" id="pacela-table">
                                <li class="list-group-item row">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label class="control-label" for="inputDataFaturamento">Parcela</label>
                                            <input class="form-control" id="inputDataFaturamento" type="text"
                                                name="DataFaturamento" value="1/1" readonly>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="control-label" for="inputDataVencimento1">Data de Vencimento
                                                <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputDataVencimento1"
                                                name="DataVencimento[1]"
                                                value="<?php if(set_value('DataVencimento[1]') == ""){
                                                                                echo str_replace('-', '/', date("d-m-Y"));
                                                                            }else{ echo set_value('DataVencimento[1]'); } ?>" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="control-label" for="inputValorParcela1">Valor da Parcela <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">R$</span>
                                                </div>
                                                <input class="form-control" id="inputValorParcela1"
                                                    name="ValorParcela[1]" type="text" data-mask="#.##0,00"
                                                    data-mask-reverse="true" value="<?php if($pedido->valor_desconto != 0){
                                                                            if($pedido->tipo_desconto == 1){
                                                                                echo number_format($total - $pedido->valor_desconto, 2, ',', '.');
                                                                            }elseif($pedido->tipo_desconto == 2){
                                                                                echo number_format($total - ($total * ($pedido->valor_desconto / 100)), 2, ',', '.');
                                                                            }
                                                                         }else{
                                                                             echo number_format($total, 2, ',', '.');
                                                                         }
                                                                    ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <div class="form-group">
                                    <label for="inputObservacao">Observações do Faturamento</label>
                                    <textarea class="form-control" rows="3" id="inputObservacao	"
                                        name="ObservFatur"><?= set_value('ObservReceb'); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="InserirFaturamento"><i
                        class="fas fa-plus-circle"></i>
                    Faturar Pedido</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="elimina-produto" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Produto do Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirma eliminação do(s) produto(s) do pedido selecionado(s)?
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="DeleteProdutoVenda">Confirma</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
$(function() {
    $.applyDataMask();
});

$("[name='excluir_todos[]']").click(function() {
    var cont = $("[name='excluir_todos[]']:checked").length;
    $("#excluirProduto").prop("disabled", cont ? false : true);
});

$("#inputVendedor").change(function() {

    var baseurl = "<?php echo base_url(); ?>";

    var vendedor = $("#inputVendedor").val();

    $.post(baseurl + "ajax/busca-vendedor", {
        vendedor: vendedor
    }, function(valor) {
        console.log(valor);
        $("#inputPerComissao").val(valor);
    });

    $("#inputPerComissao").prop("disabled", false);

});

$(function() {
    //evnto que deve carregar a janela a ser impressa 
    $('#imprimir').click(function() {

        var iFrame = document.createElement("iframe");
        
        iFrame.style.display = "none";
        iFrame.src = "<?= base_url("vendas/imprimir-pedido-vendedor/{$pedido->num_pedido_venda}") ?>";
        document.body.appendChild(iFrame);

        iFrame.addEventListener("load", function() {
            iFrame.contentWindow.focus();
            iFrame.contentWindow.print();
        });
    });
});

$("#inputProdutoVenda").change(function() {

    var baseurl = "<?php echo base_url(); ?>";

    var produto = $("#inputProdutoVenda").val();

    $.post(baseurl + "ajax/busca-produto", {
        produto: produto
    }, function(valor) {
        var aValor = valor.split('|');
        console.log(aValor);
        $("#inputUnidadeMedida").val(aValor[0]);
        $("#inputTipoProduto").val(aValor[1]);
        $("#inputValorUnitario").val(aValor[3]);
    });

});

jQuery('#inputQuantPedida').on('keyup', function() {
    valTotal();
});

jQuery('#inputValorUnitario').on('keyup', function() {
    valTotal();
});

function valTotal() {

    var valUnit = parseFloat(jQuery('#inputValorUnitario').val() != '' ? (jQuery('#inputValorUnitario').val().split(
        '.').join('')).replace(',', '.') : 0);
    var quantPedida = parseFloat(jQuery('#inputQuantPedida').val() != '' ? (jQuery('#inputQuantPedida').val().split(
        '.').join('')).replace(',', '.') : 0);

    var totalVenda = valUnit * quantPedida;

    $("#inputTotalVenda").val(totalVenda.toLocaleString("pt-BR", {
        style: "decimal",
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }));

};

$('#inputDataFaturamento').datepicker({
    uiLibrary: 'bootstrap4'
});

$('#inputProdutoVenda').selectpicker({
    style: 'btn-input-primary'
});

$('#inputDateEntrega').datepicker({
    uiLibrary: 'bootstrap4'
});

jQuery('#inputTipoDesconto').change(function() {
    calcDesconto();
});

jQuery('#inputDesconto').on('keyup', function() {
    calcDesconto();
});

function calcDesconto() {

    var tipoDesconto = jQuery('#inputTipoDesconto').val();
    var valDesconto = parseFloat(jQuery('#inputDesconto').val() != '' ? (jQuery('#inputDesconto').val().split(
        '.').join('')).replace(',', '.') : 0);
    var valPedido = parseFloat(<?= $total ?>);

    var totalLiq = 0;
    var htmlDesconto = "";

    if (tipoDesconto == 1) {
        totalLiq = valPedido - valDesconto;
        htmlDesconto = "R$ " + valDesconto.toLocaleString("pt-BR", {
            style: "decimal",
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        })
    } else if (tipoDesconto == 2) {
        totalLiq = valPedido - (valPedido * (valDesconto / 100));
        htmlDesconto = valDesconto.toLocaleString("pt-BR", {
            style: "decimal",
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }) + " %";
    }



    $("#inputValorDesconto").html(htmlDesconto);

    $("#inputValorLiq").html("R$ " + totalLiq.toLocaleString("pt-BR", {
        style: "decimal",
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }));

};

$("#inputParcelas").change(function() {

    var quantParcela = $('#inputParcelas').val();

    var dataParcela = new Date(String($('#inputDataVencimento1').val().split('/').reverse().join(
        '-')));

    var valorTotal = parseFloat(jQuery('#inputValorLiq').text() != '' ? (jQuery('#inputValorLiq')
        .text()
        .split(
            '.').join('')).replace(',', '.').replace('R$', '') : 0);
    var acumulado = 0;

    $("#pacela-table").empty();

    for (var i = 1; i <= quantParcela; i++) {

        valorParcela = round((valorTotal / quantParcela), 2);
        acumulado = acumulado + valorParcela;

        if (i == quantParcela && acumulado != valorTotal) {
            valorParcela = valorParcela + (valorTotal - acumulado);
        }

        var newRow = $('<li class="list-group-item row">');
        var cols = "";

        if (i > 1) {
            var currentDay = dataParcela.getDate();
            var currentMonth = dataParcela.getMonth();
            dataParcela.setMonth(currentMonth + 1, currentDay);
        }

        cols += '<div class="form-row">';

        //Número de parcelamento        
        cols += '<div class="form-group col-md-4">';
        cols += '<label class="control-label" for="inputParcela' + i +
            '">Data de Vencimento <span class="text-danger">*</span></label>';
        cols += '<input type="text" class="form-control" id="inputParcela' + i + '"';
        cols += 'name="DataVencimento[' + i + ']"';
        cols += 'value="' + i + '/' + quantParcela + '" readonly>';
        cols += '</div>';

        //Data de vencimento previsto
        cols += '<div class="form-group col-md-4">';
        cols += '<label class="control-label" for="inputDataVencimento' + i +
            '">Data de Vencimento <span class="text-danger">*</span></label>';
        cols += '<input type="text" class="form-control" id="inputDataVencimento' + i + '"';
        cols += 'name="DataVencimento[' + i + ']"';
        cols += 'value="' + dataParcela.toLocaleDateString('pt-BR', {
            timeZone: 'UTC'
        }) + '" required>';
        cols += '</div>';

        // Valor da parcela
        cols += '<div class="form-group col-md-4">';
        cols += '<label class="control-label" for="inputValorParcela' + i +
            '">Valor da Parcela <span class="text-danger">*</span></label>';
        cols += '<div class="input-group">';
        cols += '<div class="input-group-prepend">';
        cols += '<span class="input-group-text">R$</span>';
        cols += '</div>';
        cols += '<input class="form-control" id="inputValorParcela' + i +
            '" name="ValorParcela[' +
            i + ']" type="text" ';
        cols += 'data-mask="#.##0,00" data-mask-reverse="true"';
        cols += 'value="' + valorParcela.toLocaleString("pt-BR", {
            style: "decimal",
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        cols += '" required>';
        cols += '</div>';
        cols += '</div>';

        cols += '</div>';
        cols += '</li>';

        newRow.append(cols);
        $("#pacela-table").append(newRow);

        $('#inputDataVencimento' + i).datepicker({
            uiLibrary: 'bootstrap4'
        });

    }

    $.applyDataMask();


    return;

});

$('#inputDataVencimento1').datepicker({
    uiLibrary: 'bootstrap4'
});

const round = (num, places) => {
    return +(parseFloat(num).toFixed(places));
}
</script>

<?php $this->load->view('gerais/footer'); ?>