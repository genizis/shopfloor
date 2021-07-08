<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active"><a href="<?php echo base_url() ?>compras/pedido-compra">Pedido de Compra</a>
            </li>
            <li class="breadcrumb-item active">Editar Pedido de Compra</a></li>
        </ol>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12">
                <div class="card  mb-3">
                    <div class="card-body">
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
                                <form class="needs-validation" novalidate
                                    action="<?= base_url("compras/pedido-compra/editar-pedido-compra/{$pedido->num_pedido_compra}") ?>"
                                    method="POST" id="PedidoCompra">
                                    <div class="form-row">
                                        <div class="form-group col-md-2">
                                            <label class="control-label" for="inputNumPedido">Número do Pedido</label>
                                            <input class="form-control" id="inputNumPedido" type="text" readonly
                                                value="<?= $pedido->num_pedido_compra ?>">
                                        </div>
                                        <div class="form-group col-md-10">
                                            <label class="control-label" for="inputCodFornecedor">Fornecedor</label>
                                            <input class="form-control" id="inputCodFornecedor" type="text" readonly
                                                value="<?= $pedido->cod_fornecedor ?> - <?= $pedido->nome_fornecedor ?>">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="inputDateEmissao">Data de Emissão</label>
                                            <input type="text" class="form-control" id="inputDateEmissao"
                                                name="DataEmissao" readonly
                                                value="<?= str_replace('-', '/', date("d-m-Y", strtotime($pedido->data_emissao))) ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputDateEntrega">Data de Entrega <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputDateEntrega"
                                                name="DataEntrega"
                                                value="<?= str_replace('-', '/', date("d-m-Y", strtotime($pedido->data_entrega))) ?>" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputTipoDesconto">Desconto</label>
                                            <div class="input-group">
                                                <select id="inputTipoDesconto" class="selectpicker show-tick form-control"
                                                        data-actions-box="true" data-style="btn-input-primary" name="TipoDesconto">
                                                    <option value="1" <?php if($pedido->tipo_desconto == 1) echo "selected"; ?>>R$</option>
                                                    <option value="2" <?php if($pedido->tipo_desconto == 2) echo "selected"; ?>>%</option>
                                                </select>
                                                <input type="text" class="form-control" data-mask="#.##0,00" data-mask-reverse="true"
                                                        name="Desconto" id="inputDesconto" value="<?= number_format($pedido->valor_desconto, 2, ',', '.') ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputObservacao">Observações do Pedido de Compra</label>
                                            <textarea class="form-control" rows="3" id="inputObservacao"
                                                name="ObsPedidoCompra"><?= $pedido->observacoes ?></textarea>
                                        </div>
                                    </div>
                                </form>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div lass="row">
                                            <ul class="nav nav-tabs">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#ordem">Ordens de Compra</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#produto">Produtos do Pedido</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane fade active show" id="ordem">
                                                <div class="row  button-pane">                                                
                                                    <div class="col-lg-12 col-md-12 col-xs-12">
                                                        <button data-toggle="modal" data-target="#adicionar-ordem" type="button"
                                                            class="btn btn-outline-primary btn-sm"><i class="fas fa-check-circle"></i> Adicionar
                                                                Ordem de Compra</button>
                                                        <button data-toggle="modal" data-target="#nova-ordem" type="button"
                                                            class="btn btn-outline-info btn-sm" ><i class="fas fa-plus-circle"></i> Nova
                                                                Ordem de Compra</button>
                                                        <button data-toggle="modal" data-target="#elimina-ordem" type="button"
                                                            class="btn btn-outline-danger btn-sm" id="excluirOrdem" disabled><i
                                                                class="fas fa-trash-alt"></i>
                                                            Excluir</button>
                                                    </div>
                                                </div>
                                                <form class="mb-0 needs-validation" novalidate
                                                    action="<?= base_url("compras/pedido-compra/excluir-ordem-compra/{$pedido->num_pedido_compra}") ?>"
                                                    method="POST" id="DeleteOrdemCompra">
                                                    <table class="table table-bordered table-hover">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th scope="col" class="text-center">#</th>
                                                                <th scope="col" class="text-center">Ord de Compra</th>
                                                                <th scope="col">Produto Compra</th>
                                                                <th scope="col" class="text-center">Un</th>
                                                                <th scope="col">Tipo do Produto</th>  
                                                                <th scope="col" class="text-center">Data Necessidade</th>                                                      
                                                                <th scope="col" class="text-center">Quant Pedida</th>
                                                                <th scope="col" class="text-center">Quant Atendida</th>
                                                                <th scope="col" class="text-center">Total da Compra</th>
                                                                <th scope="col" class="text-center">Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $total = 0; foreach($lista_ordem_compra as $key_ordem_compra => $ordem_compra) { 
                                                                $total = $total + ($ordem_compra->valor_unitario * $ordem_compra->quant_pedida); ?>
                                                            <tr>
                                                                <td>
                                                                    <div class="checkbox text-center">
                                                                        <input name="excluir_todos[]" type="checkbox"
                                                                            value="<?= $ordem_compra->num_ordem_compra ?>" 
                                                                        <?php if($ordem_compra->quant_atendida > 0){ echo "disabled"; } ?>/>
                                                                    </div>
                                                                </td>
                                                                <td scope="row"  class="text-center"><a href="#" data-toggle="modal"
                                                                        data-target="#editar-ordem<?= $ordem_compra->num_ordem_compra ?>">
                                                                        <?= $ordem_compra->num_ordem_compra ?>
                                                                    </a>
                                                                </td>
                                                                <td><?= $ordem_compra->cod_produto ?> - <?= $ordem_compra->nome_produto ?></td>
                                                                <td class="text-center"><?= $ordem_compra->cod_unidade_medida ?></td>
                                                                <td><?= $ordem_compra->nome_tipo_produto ?></td>
                                                                <td class="text-center"><?= str_replace('-', '/', date("d-m-Y", strtotime($ordem_compra->data_necessidade))) ?></td>
                                                                <td class="text-center"><?= number_format($ordem_compra->quant_pedida, 3, ',', '.') ?>
                                                                </td>
                                                                <td class="text-center"><?= number_format($ordem_compra->quant_atendida, 3, ',', '.') ?>
                                                                </td>
                                                                <td class="text-center">R$ <?= number_format($ordem_compra->valor_unitario * $ordem_compra->quant_pedida, 2, ',', '.') ?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?php
                                                                        if($ordem_compra->data_necessidade < date('Y-m-d') && $ordem_compra->status != 3){
                                                                            echo "<span class='badge badge-danger'>Atrasado</span>";

                                                                        }else{
                                                                            switch ($ordem_compra->status) {
                                                                                case 1:
                                                                                    echo "<span class='badge badge-secondary'>Pendente</span>";
                                                                                    break;
                                                                                case 2:
                                                                                    echo "<span class='badge badge-info'>Atendido Parcial</span>";
                                                                                    break;
                                                                                case 3:
                                                                                    echo "<span class='badge badge-teal'>Atendido Total</span>";
                                                                                    break;
                                                                            } 

                                                                        }                                                        
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                    <?php if ($lista_ordem_compra == false) { ?>
                                                    <div class="text-center">
                                                        <p>Nenhuma ordem de compra adicionada</p>
                                                    </div>
                                                    <?php }else{ ?>
                                                    <div class="row">
                                                        <div class="col-md-8"></div>
                                                        <div class="col-md-4">
                                                            <table class="table table-bordered">
                                                                <tbody>                                                            
                                                                    <tr>
                                                                        <th class="table-light">Total</th>
                                                                        <td class="text-right"><strong>R$ <?= number_format($total, 2, ',', '.') ?></strong></td>
                                                                    </tr> 
                                                                    <tr>
                                                                        <th class="table-light">Desconto</th>
                                                                        <td class="text-right" id="inputValorDesconto">
                                                                            <?php if($pedido->tipo_desconto == 1) echo "R$"; ?>
                                                                            <?= number_format($pedido->valor_desconto, 2, ',', '.'); ?>
                                                                            <?php if($pedido->tipo_desconto == 2) echo "%"; ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="">
                                                                        <th class="table-light"><strong>Total Líquido</strong></th>
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
                                            <div class="tab-pane fade" id="produto">
                                                <table class="table table-bordered table-hover">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th scope="col">Produto de Compra</th>
                                                            <th scope="col">Tipo do Produto</th>
                                                            <th scope="col" class="text-center">Un</th> 
                                                            <th scope="col" class="text-center">Quant Pedida</th>
                                                            <th scope="col" class="text-center">Quant Recebida</th>
                                                            <th scope="col" class="text-center">Total da Compra</th>                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach($lista_produto as $key_produto => $produto) { ?>
                                                        <tr>
                                                            <td><?= $produto->cod_produto ?> - <?= $produto->nome_produto ?></td>
                                                            <td><?= $produto->nome_tipo_produto ?></td>
                                                            <td class="text-center"><?= $produto->cod_unidade_medida ?></td>                                                              
                                                            <td class="text-center"><?= number_format($produto->quant_pedida, 3, ',', '.') ?></td> 
                                                            <td class="text-center"><?= number_format($produto->quant_recebida, 3, ',', '.') ?></td> 
                                                            <td class="text-center">R$ <?= number_format($produto->total_compra, 2, ',', '.') ?></td>                                   
                                                        </tr>
                                                        <?php } ?>                                                        
                                                    </tbody>
                                                </table>
                                                <?php if ($lista_produto == false) { ?>
                                                <div class="text-center">
                                                    <p>Nenhum produto inserido</p>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="#" class="btn btn-outline-warning"
                                            type="button" id="imprimir"><i class="fas fa-print"></i> Imprimir Pedido</a>
                                    </div>
                                    <div class="col-md-6">
                                            <div class="row float-right">
                                                <div class="col-md-12">
                                                    <button type="submit" form="PedidoCompra" class="btn btn-primary" name="Opcao"
                                                        value="salvar"><i class="fas fa-save"></i> Salvar</button>
                                                    <a href="<?php echo base_url() ?>compras/recebimento-material/novo-recebimento-material/<?= $pedido->num_pedido_compra ?>"
                                                        class="btn btn-info"><i class="fas fa-box-open"></i> Receber Material</a>
                                                    <a href="<?php echo base_url() ?>compras/pedido-compra"
                                                        class="btn btn-secondary">Cancelar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="adicionar-ordem">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Ordem Compra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form class="mb-0 needs-validation" novalidate
                            action="<?= base_url("compras/pedido-compra/adicionar-ordem-compra/{$pedido->num_pedido_compra}") ?>"
                            method='post' id='formOrdemCompra'>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputOrdemCompraAdic">Ordem de Compra <span class="text-danger">*</span></label>
                                    <select id="inputOrdemCompraAdic" class="selectpicker show-tick form-control"
                                        data-live-search="true" data-actions-box="true" title="Selecione uma Ordem de Compra"
                                        name="NumOrdemCompraAdic" data-style="btn-input-primary" required>
                                        <?php foreach($lista_ordem_sem_pedido as $key_ordem_compra => $ordem_compra) { ?>
                                        <option value="<?= $ordem_compra->num_ordem_compra ?>"
                                            <?php if($ordem_compra->num_ordem_compra == set_value('NumOrdemCompra')) echo "selected"; ?>>
                                            <?= $ordem_compra->num_ordem_compra ?> (<?= $ordem_compra->cod_produto ?> - <?= $ordem_compra->nome_produto ?>)
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="inputTipoProdutoAdic">Tipo de Produto</label>
                                    <input class="form-control" id="inputTipoProdutoAdic" type="text"
                                        name="TipoProdutoAdic" readonly
                                        value="<?= set_value('TipoProdutoAdic'); ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="inputUnidadeMedidaAdic">Unidade de Medida</label>
                                    <input class="form-control" id="inputUnidadeMedidaAdic" type="text"
                                        name="UnidadeMedidaAdic" readonly
                                        value="<?= set_value('UnidadeMedidaAdic'); ?>">
                                </div>
                            </div>
                            <div class="form-row">   
                                <div class="form-group col-md-3">
                                    <label for="inputDataNecessidadeAdic">Data de Necessidade</label>
                                    <input type="text" class="form-control" 
                                        id="inputDataNecessidadeAdic" name="DataNecessidadeAdic" readonly
                                        value="<?= set_value('DataNecessidadeAdic'); ?>">
                                </div>  
                                <div class="form-group col-md-3">
                                    <label for="inputQuantPedidaAdic">Quantidade Pedida <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" 
                                        id="inputQuantPedidaAdic" name="QuantPedidaAdic" data-mask="#.##0,000" data-mask-reverse="true"
                                        value="<?= set_value('QuantPedidaAdic'); ?>" required>
                                </div>                                
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="inputValorUnitarioAdic">Valor Unitário <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" class="form-control"
                                            id="inputValorUnitarioAdic" type="text" name="ValorUnitarioAdic" data-mask="#.##0,00" data-mask-reverse="true"
                                            value="<?= set_value('ValorUnitarioAdic'); ?>" required>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="inputTotalCompraAdic">Total da Compra</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" class="form-control"
                                            id="inputTotalCompraAdic" type="text" name="TotalCompraAdic" data-mask="#.##0,00" data-mask-reverse="true"
                                            value="<?= set_value('TotalCompraAdic'); ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputObservacaoOrdemAdic">Observações da Ordem de Compra</label>
                                    <textarea class="form-control" rows="3" id="inputObservacaoOrdemAdic" readonly
                                        name="ObsOrdemCompraAdic"><?= set_value('ObsOrdemCompraAdic'); ?></textarea>
                                </div>
                            </div> 
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="formOrdemCompra"><i class="fas fa-check-circle"></i> Adicionar
                                                        Ordem de Compra</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="nova-ordem">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nova Ordem Compra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form class="mb-0 needs-validation" novalidate
                            action="<?= base_url("compras/pedido-compra/nova-ordem-compra/{$pedido->num_pedido_compra}") ?>" 
                            method="post" id='formNovaOrdemCompra'>
                            <div class="form-row">                                        
                                <div class="form-group col-md-6">
                                    <label for="inputProdutoCompra">Produto de Compra <span class="text-danger">*</span></label>
                                    <select id="inputProdutoCompra" class="selectpicker show-tick form-control"
                                        data-live-search="true" data-actions-box="true" data-style="btn-input-primary"
                                        title="Selecione um Produto" name="CodProduto" required>
                                        <?php foreach($lista_produto_comp as $key_produto_comp => $produto_comp) { ?>
                                        <option value="<?= $produto_comp->cod_produto ?>"
                                        <?php if($produto_comp->cod_produto == set_value('CodProduto')) echo "selected"; ?>>
                                            <?= $produto_comp->cod_produto ?> -
                                            <?= $produto_comp->nome_produto ?></option>
                                        <?php } ?>
                                    </select>
                                </div>    
                                <div class="form-group col-md-3">
                                    <label for="inputTipoProduto">Tipo de Produto</label>
                                    <input type="text" class="form-control" id="inputTipoProduto"
                                        readonly name="TipoProduto" value="<?= set_value('TipoProduto'); ?>">
                                </div>                                    
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="inputUnidadeMedida">Unidade de
                                        Medida</label>
                                    <input class="form-control" id="inputUnidadeMedida" type="text"
                                        readonly name="UnidadeMedida" value="<?= set_value('UnidadeMedida'); ?>">
                                </div>
                            </div>
                            <div class="form-row">                                        
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="inputDataNecessidade">Data de Necessidade <span class="text-danger">*</span></label>
                                    <input class="form-control" id="inputDataNecessidade" type="text"
                                        name="DataNecessidade" value="<?= set_value('DataNecessidade'); ?>" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="inputQuantPedida">Quantidade Pedida <span class="text-danger">*</span></label>
                                    <input class="form-control" id="inputQuantPedida" type="text" data-mask="#.##0,000" data-mask-reverse="true"
                                        name="QuantPedida" value="<?= set_value('QuantPedida'); ?>" required>
                                </div>  
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="inputValorUnitario">Valor Unitário <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" class="form-control" class="form-control"
                                            id="inputValorUnitario" type="text" name="ValorUnitario" data-mask="#.##0,00" data-mask-reverse="true"
                                            value="<?= set_value('ValorUnitario'); ?>" required>
                                    </div>
                                </div> 
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="inputTotalCompra">Total da Compra</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" class="form-control"
                                            id="inputTotalCompra" type="text" name="TotalCompra" data-mask="#.##0,00" data-mask-reverse="true"
                                            value="<?= set_value('TotalCompra'); ?>" readonly>
                                    </div>
                                </div>                                     
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputObservacao">Observações da Ordem de Compra</label>
                                    <textarea class="form-control" rows="3" id="inputObservacao"
                                        name="ObsOrdemCompra"><?= set_value('ObsOrdemCompra'); ?></textarea>
                                </div>
                            </div>  
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="formNovaOrdemCompra"><i
                                            class="fas fa-save"></i> Salvar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<?php foreach($lista_ordem_compra as $key_ordem_compra => $ordem_compra) { ?>
<div class="modal fade" id="editar-ordem<?= $ordem_compra->num_ordem_compra ?>">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Ordem de Compra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form class="mb-0 needs-validation" novalidate
                            action="<?= base_url("compras/pedido-compra/salvar-ordem-compra/{$ordem_compra->num_ordem_compra}") ?>"
                            method='post' id='formOrdemCompraEdit<?= $ordem_compra->num_ordem_compra ?>'>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label class="control-label" for="inputOrdemCompraEdit">Ordem Compra</label>
                                    <input class="form-control" id="inputOrdemCompraEdit" type="text"
                                        name="NumOrdemCompraEdit" value="<?= $ordem_compra->num_ordem_compra ?>" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="inputProdutoCompraEdit">Produto de Compra</label>
                                    <input class="form-control" id="inputProdutoCompraEdit" type="text"
                                        name="CodProdutoEdit" value="<?= $ordem_compra->cod_produto ?> - <?= $ordem_compra->nome_produto ?>" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="inputUnidadeMedidaEdit">Unidade de Medida</label>
                                    <input class="form-control" id="inputUnidadeMedidaEdit" type="text"
                                        name="UnidadeMedidaEdit" value="<?= $ordem_compra->cod_unidade_medida ?>" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="inputTipoProdutoEdit">Tipo de Produto</label>
                                    <input class="form-control" id="inputTipoProdutoEdit" type="text"
                                        name="TipoProdutoEdit" value="<?= $ordem_compra->nome_tipo_produto ?>" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputDataNecessidadeEdit">Data de Necessidade</label>
                                    <input type="text" class="form-control" 
                                        id="inputDataNecessidadeEdit" name="DataNecessidade" readonly
                                        value="<?= str_replace('-', '/', date("d-m-Y", strtotime($ordem_compra->data_necessidade))) ?>">
                                </div>                                 
                                <div class="form-group col-md-3">
                                    <label for="inputQuantPedidaEdit">Quantidade Pedida <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="<?= $ordem_compra->quant_pedida ?>" data-mask="#.##0,000" data-mask-reverse="true"
                                        id="inputQuantPedidaEdit<?= $ordem_compra->num_ordem_compra ?>" name="QuantPedidaEdit">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="inputValorUnitarioEdit">Valor Unitário <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" class="form-control" class="form-control"
                                            id="inputValorUnitarioEdit<?= $ordem_compra->num_ordem_compra ?>" type="text" name="ValorUnitarioEdit" data-mask="#.##0,00" data-mask-reverse="true"
                                            value="<?= $ordem_compra->valor_unitario ?>" data-mask="#.##0,000" data-mask-reverse="true">
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="inputTotalCompraEdit">Total da Compra</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" class="form-control"
                                            id="inputTotalCompraEdit<?= $ordem_compra->num_ordem_compra ?>" type="text" name="TotalCompraEdit" data-mask="#.##0,00" data-mask-reverse="true"
                                            value="<?= number_format($ordem_compra->valor_unitario * $ordem_compra->quant_pedida, 2, ',', '.') ?>" readonly>
                                    </div>
                                </div> 
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputObservacaoOrdemEdit">Observações da Ordem de Compra</label>
                                    <textarea class="form-control" rows="3" id="inputObservacaoOrdemEdit" readonly
                                        name="ObsOrdemCompra"><?= $ordem_compra->observacoes ?></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="formOrdemCompraEdit<?= $ordem_compra->num_ordem_compra ?>"><i class="fas fa-save"></i>
                    Salvar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<div class="modal fade" id="elimina-ordem" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Ordem de Compra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirma eliminação da(s) ordem(s) de compra selecionado(s)?
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="DeleteOrdemCompra">Confirma</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
$(function() {
     $.applyDataMask();
});

$(function(){ 
                   //evnto que deve carregar a janela a ser impressa 
    $('#imprimir').click(function(){ 

        var iFrame = document.createElement("iframe");
            iFrame.addEventListener("load", function () { 
            iFrame.contentWindow.focus();
            iFrame.contentWindow.print();
            window.setTimeout(function () {
                document.body.removeChild(iFrame);
            }, 0);
            });        
            iFrame.style.display = "none";
            iFrame.src = "<?= base_url("compras/imprimir-pedido/{$pedido->num_pedido_compra}") ?>";
            document.body.appendChild(iFrame);
    }); 
}); 

$("[name='excluir_todos[]']").click(function() {
    var cont = $("[name='excluir_todos[]']:checked").length;
    $("#excluirOrdem").prop("disabled", cont ? false : true);
});

$("#inputOrdemCompraAdic").change(function() {

    var baseurl = "<?php echo base_url(); ?>";

    var ordem = $("#inputOrdemCompraAdic").val();

    $.post(baseurl + "ajax/busca-ordem-compra", {
        ordem: ordem
    }, function(valor) {
        var aValor = valor.split('|');
        console.log(aValor);        
        $("#inputTipoProdutoAdic").val(aValor[0]);
        $("#inputUnidadeMedidaAdic").val(aValor[1]);
        $("#inputDataNecessidadeAdic").val(aValor[2]);
        $("#inputQuantPedidaAdic").val(aValor[3]);
        $("#inputValorUnitarioAdic").val(aValor[4]);
        $("#inputTotalCompraAdic").val(aValor[5]);
        $("#inputObservacaoOrdemAdic").val(aValor[6]);
        
    });

});

$("#inputProdutoCompra").change(function() {

    var baseurl = "<?php echo base_url(); ?>";

    var produto = $("#inputProdutoCompra").val();

    $.post(baseurl + "ajax/busca-produto", {
        produto: produto
    }, function(valor) {
        var aValor = valor.split('|');
        console.log(aValor);
        $("#inputUnidadeMedida").val(aValor[0]);
        $("#inputTipoProduto").val(aValor[1]);
        $("#inputValorUnitario").val(aValor[2]);
    });

});

$('#inputDataNecessidade').datepicker({
    uiLibrary: 'bootstrap4'
});

$('#inputDateEntrega').datepicker({
    uiLibrary: 'bootstrap4'
});

jQuery('#inputQuantPedidaAdic').on('keyup', function() {
    valTotalAdic();
});

jQuery('#inputValorUnitarioAdic').on('keyup', function() {
    valTotalAdic();
});

function valTotalAdic() {

    var valUnit = parseFloat(jQuery('#inputValorUnitarioAdic').val() != '' ? (jQuery('#inputValorUnitarioAdic').val().split(
        '.').join('')).replace(',', '.') : 0);
    var quantPedida = parseFloat(jQuery('#inputQuantPedidaAdic').val() != '' ? (jQuery('#inputQuantPedidaAdic').val().split(
        '.').join('')).replace(',', '.') : 0);

    var totalCompra = valUnit * quantPedida;

    $("#inputTotalCompraAdic").val(totalCompra.toLocaleString("pt-BR", {
            style: "decimal",
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
    }));
    
};

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

    var totalCompra = valUnit * quantPedida;

    $("#inputTotalCompra").val(totalCompra.toLocaleString("pt-BR", {
            style: "decimal",
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
    }));
    
};

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

    if(tipoDesconto == 1){
        totalLiq = valPedido - valDesconto;
        htmlDesconto = "R$ " + valDesconto.toLocaleString("pt-BR", {
                                        style: "decimal",
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                })
    } else if(tipoDesconto == 2){
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

</script>

<?php $this->load->view('gerais/footer'); ?>