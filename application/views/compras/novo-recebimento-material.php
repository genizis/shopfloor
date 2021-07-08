<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active"><a
                    href="<?php echo base_url() ?>compras/recebimento-material">Recebimento de Material</a></li>
            <li class="breadcrumb-item active">Novo Recebimento de Material</a></li>
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
                                <div class="form-row">
                                    <div class="form-group col-md-2">
                                        <label class="control-label" for="inputNumPedido">Número do Pedido</label>
                                        <input class="form-control" id="inputNumPedido" type="text" readonly
                                            value="<?= $pedido->num_pedido_compra ?>">
                                    </div>
                                    <div class="form-group col-md-7">
                                        <label class="control-label" for="inputCodFornecedor">Fornecedor</label>
                                        <input class="form-control" id="inputCodFornecedor" type="text" readonly
                                            value="<?= $pedido->cod_fornecedor ?> - <?= $pedido->nome_fornecedor ?>">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputDateEmissao">Data de Emissão</label>
                                        <input type="text" class="form-control" id="inputDateEmissao"
                                            name="DataEmissao" readonly
                                            value="<?= str_replace('-', '/', date("d-m-Y", strtotime($pedido->data_emissao))) ?>">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="inputDateEntrega">Data de Entrega</label>
                                        <input type="text" class="form-control" id="inputDateEntrega"
                                            name="DataEntrega" readonly
                                            value="<?= str_replace('-', '/', date("d-m-Y", strtotime($pedido->data_entrega))) ?>">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label" for="inputValorPedido">Valor do Pedido</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">R$</span>
                                            </div>
                                            <input type="text" class="form-control"
                                                id="inputValorPedido" type="text" name="TotalPedidoVenda" data-mask="#.##0,00" data-mask-reverse="true"
                                                value="<?= number_format($pedido->valor_pedido, 2, ',', '.') ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label" for="inputDesconto">Desconto</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <?php
                                                        if($pedido->tipo_desconto == 1){
                                                            echo "R$";
                                                        }elseif($pedido->tipo_desconto == 2){
                                                            echo "%";
                                                        }
                                                    ?>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control"
                                                id="inputDesconto" type="text" name="ValorDesconto" data-mask="#.##0,00" data-mask-reverse="true"
                                                value="<?= number_format($pedido->valor_desconto, 2, ',', '.') ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label" for="inputTotalLiquido">Valor Líquido</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">R$</span>
                                            </div>
                                            <input type="text" class="form-control"
                                                id="inputTotalLiquido" type="text" name="TotalLiquido" data-mask="#.##0,00" data-mask-reverse="true"
                                                value="<?php if($pedido->valor_desconto != 0){
                                                                if($pedido->tipo_desconto == 1){
                                                                    echo number_format($pedido->valor_pedido - $pedido->valor_desconto, 2, ',', '.');
                                                                }elseif($pedido->tipo_desconto == 2){
                                                                    echo number_format($pedido->valor_pedido - (round($pedido->valor_pedido * ($pedido->valor_desconto / 100), 2)), 2, ',', '.');
                                                                }
                                                            }else{
                                                                echo number_format($pedido->valor_pedido, 2, ',', '.');
                                                            }
                                                        ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="inputObservacao">Observações do Pedido de Compra</label>
                                        <textarea class="form-control" rows="3" id="inputObservacao"
                                            name="ObsPedidoCompra" readonly><?= $pedido->observacoes ?></textarea>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div lass="row">
                                            <ul class="nav nav-tabs">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#recebimento">Recebimento de Material</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#produto">Produtos do Pedido</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane fade active show" id="recebimento">
                                                <div class="row  button-pane">
                                                    <div class="col-lg-12 col-md-12 col-xs-12">
                                                        <button data-toggle="modal" data-target="#inserir-recebimento"
                                                            type="button" class="btn btn-outline-primary btn-sm"><i
                                                                class="fas fa-plus-circle"></i> Receber Material</button>
                                                        <button data-toggle="modal" data-target="#estorna-recebimento"
                                                            type="button" class="btn btn-outline-danger btn-sm" id="btnEstorno" disabled><i
                                                                class="fas fa-undo"></i>
                                                            Estornar Recebimento</button>
                                                        <button data-toggle="modal" data-target="#recebimentos-pedido" type="button"
                                                                class="btn btn-outline-secondary btn-sm"><i class="fas fa-list"></i> Recebimentos do Pedido</button>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-xs-12">
                                                        <form class="needs-validation" novalidate   
                                                            action="<?= base_url("compras/recebimento-material/estornar-recebimento-material/{$pedido->num_pedido_compra}") ?>"
                                                            method="POST" id="EstornaRecebimento">
                                                            <table class="table table-bordered table-hover">
                                                                <thead class="thead-light">
                                                                    <tr>
                                                                        <th scope="col" class="text-center">#</th>
                                                                        <th scope="col" class="text-center">Código Recebimento</th>
                                                                        <th scope="col" class="text-center">Data Recebimento</th>
                                                                        <th scope="col">Serie</th>
                                                                        <th scope="col">Nota Fiscal</th>
                                                                        <th scope="col" class="text-center">Total Bruto</th> 
                                                                        <th scope="col" class="text-center">Valor Desconto</th>                                                                     
                                                                        <th scope="col" class="text-center">Total Líquido</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $totalBruto = 0;
                                                                          $totalDesconto = 0;
                                                                          $totalLiquido = 0;

                                                                        foreach($lista_recebimento as $key_recebimento => $recebimento) {
                                                                            $totalBruto = $totalBruto + $recebimento->valor_total;
                                                                            $totalDesconto = $totalDesconto + $recebimento->valor_desconto;
                                                                            $totalLiquido = $totalLiquido + ($recebimento->valor_total - $recebimento->valor_desconto); ?>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="checkbox text-center">
                                                                                <input name="estornar_todos[]" type="checkbox"
                                                                                    value="<?= $recebimento->cod_recebimento_material ?>" />
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center"><a href="#" data-toggle="modal"
                                                                            data-target="#produto-recebimento<?= $recebimento->cod_recebimento_material ?>">
                                                                            <?= $recebimento->cod_recebimento_material ?></a>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <?= str_replace('-', '/', date("d-m-Y", strtotime($recebimento->data_recebimento))) ?>
                                                                        </td>
                                                                        <td><?= $recebimento->serie ?></td>
                                                                        <td><?= $recebimento->nota_fiscal ?></td>
                                                                        <td class="text-center">R$
                                                                            <?= number_format($recebimento->valor_total, 2, ',', '.') ?>
                                                                        </td>
                                                                        <td class="text-center">R$
                                                                            <?= number_format($recebimento->valor_desconto, 2, ',', '.') ?>
                                                                        </td>
                                                                        <td class="text-center">R$
                                                                            <?= number_format($recebimento->valor_total - $recebimento->valor_desconto, 2, ',', '.') ?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                            <?php if ($lista_recebimento == false) { ?>
                                                            <div class="text-center">
                                                                <p>Nenhum recebimento de material realizado</p>
                                                            </div>
                                                            <?php }else{ ?>
                                                            <div class="row">
                                                                <div class="col-md-8"></div>
                                                                <div class="col-md-4">
                                                                    <table class="table table-bordered">
                                                                        <tbody>                                                            
                                                                            <tr>
                                                                                <th class="table-light">Compra Bruto</th>
                                                                                <td class="text-right"><strong>R$ <?= number_format($totalBruto, 2, ',', '.') ?></strong></td>
                                                                            </tr> 
                                                                            <tr>
                                                                                <th class="table-light">Total Desconto</th>
                                                                                <td class="text-right" id="inputTotalDesconto">
                                                                                    R$ <?= number_format($totalDesconto, 2, ',', '.'); ?>
                                                                                </td>
                                                                            </tr>
                                                                            <tr class="">
                                                                                <th class="table-light"><strong>Compra Líquido</strong></th>
                                                                                <td class="text-right text-teal"><strong id="inputFaturadoLiq"> 
                                                                                    R$ <?= number_format($totalLiquido, 2, ',', '.'); ?>
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
                                            </div>
                                            <div class="tab-pane fade" id="produto">
                                                <table class="table table-bordered table-hover">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th scope="col" class="text-center">Cód Produto</th>
                                                            <th scope="col">Nome do Produto</th>
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
                                                            <td class="text-center"><a href="#" data-toggle="modal"
                                                                   data-target="#produto-ordem<?= $produto->cod_produto ?>">
                                                                <?= $produto->cod_produto ?></a>
                                                            </td>
                                                            <td><?= $produto->nome_produto ?></td>
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
                                <div class="row float-right">
                                    <div class="col-lg-12 col-md-12 col-xs-12">
                                        <a href="<?php echo base_url() ?>compras/recebimento-material" type="button"
                                            class="btn btn-secondary">Fechar</a>
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


<div class="modal fade" id="estorna-recebimento" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Estornar Recebimento de Material</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirma o estorno do(s) recebimento(s) selecionado(s)?
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="EstornaRecebimento">Confirma</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="inserir-recebimento">
    <div class="modal-dialog modal-dialog-centered modal-xxl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Receber Material</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="mb-0 needs-validation" novalidate
                    action="<?= base_url("compras/recebimento-material/inserir-recebimento/{$pedido->num_pedido_compra}/{$pedido->cod_fornecedor}") ?>"
                    method="POST" id="InserirRecebimento">
                    <div class="row">                    
                        <div class="col-lg-12 col-md-12 col-xs-12">                        
                            <div class="form-row">                                
                                <div class="form-group col-md-5">
                                    <label class="control-label" for="inputDataRecebimento">Data do Recebimento <span class="text-danger">*</span></label>
                                    <input class="form-control" id="inputDataRecebimento" type="text"
                                        name="DataRecebimento" value="<?php if(set_value('DataRecebimento') == ""){
                                                                echo str_replace('-', '/', date("d-m-Y"));
                                                            }else{ echo set_value('DataRecebimento'); } ?>" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="inputSerie">Serie</label>
                                    <input class="form-control" id="inputSerie" type="text"
                                        name="Serie" value="<?= set_value('Serie'); ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="inputNotaFiscal">Nota Fiscal</label>
                                    <input class="form-control" id="inputNotaFiscal" type="text" name="NotaFiscal"
                                        value="<?= set_value('NotaFiscal'); ?>">
                                </div>                                
                            </div>                                
                        </div>
                    </div>                    
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <h6>Totais do Pedido</h6>
                            <table class="table table-bordered table-reporte">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center">Total Bruto</th> 
                                        <th class="text-center">Total Desconto</th>
                                        <th class="text-center">Total Líquido</th>
                                    </tr>
                                </thead>
                                <tbody>  
                                    <?php if ($lista_produto != false) { 
                                        $valorPendente = 0;
                                        if($pedido->valor_pendente > 0){
                                            $valorPendente = $pedido->valor_pendente;
                                        }else{
                                            $valorPendente = $pedido->valor_pedido;
                                        }
                                    ?>                                                          
                                    <tr>
                                        <td class="text-center" id="inputValorBruto"><strong>R$ <?= number_format($valorPendente, 2, ',', '.') ?></strong></td>
                                        <td class="text-center">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">R$</span>
                                                </div>
                                                <input class="form-control text-center" id="inputValorDesconto" name="ValorDesconto" type="text" 
                                                        data-mask="#.##0,00" data-mask-reverse="true"
                                                        value="<?php if($pedido->valor_desconto != 0){
                                                                        if($pedido->tipo_desconto == 1){
                                                                            echo number_format($pedido->valor_desconto, 2, ',', '.');
                                                                        }elseif($pedido->tipo_desconto == 2){
                                                                            echo number_format(round($pedido->valor_pedido * ($pedido->valor_desconto / 100), 2), 2, ',', '.');
                                                                        }
                                                                    }else{
                                                                        echo number_format(0, 2, ',', '.');
                                                                    }
                                                                ?>">
                                            </div>
                                        </td>
                                        <td class="text-center text-teal"><strong id="inputValorLiq">R$ 
                                            <?php if($pedido->valor_desconto != 0){
                                                    if($pedido->tipo_desconto == 1){
                                                        echo number_format($valorPendente - $pedido->valor_desconto, 2, ',', '.');
                                                    }elseif($pedido->tipo_desconto == 2){
                                                        echo number_format($valorPendente - (round($valorPendente * ($pedido->valor_desconto / 100), 2)), 2, ',', '.');
                                                    }
                                                  }else{
                                                    echo number_format($valorPendente, 2, ',', '.');
                                                  }
                                            ?>
                                        </strong></td>
                                    </tr> 
                                    <?php } ?>                                                         
                                </tbody>
                            </table>
                            <?php if ($lista_produto == false) { ?>
                            <div class="text-center">
                                <p>Nenhum produto de compra adicionado</p>
                            </div>
                            <?php } ?>
                        </div>
                    </div>                                       
                    <hr>
                    <div>
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#produto-ped">Produtos do Pedido</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#financeiro">Condição de Pagamento</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="produto-ped">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-hover table-reporte">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Produto de Compra</th>
                                                <th scope="col">Tipo Produto</th> 
                                                <th scope="col" class="text-center">Un</th> 
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
                                                <td>
                                                    <input class="form-control text-center" id="inputQuantRecebida<?= $produto->cod_produto ?>" name="quantRecebida[<?= $produto->cod_produto ?>]" type="text" 
                                                    data-mask="#.##0,000" data-mask-reverse="true"
                                                    value="<?= number_format($produto->quant_pedida, 3, ',', '.') ?>" required>
                                                </td> 
                                                <td>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">R$</span>
                                                        </div>
                                                        <input class="form-control text-center" id="inputValorCompra<?= $produto->cod_produto ?>" name="ValorCompra[<?= $produto->cod_produto ?>]" type="text" 
                                                            data-mask="#.##0,00" data-mask-reverse="true"
                                                            value="<?= number_format($produto->total_compra, 2, ',', '.') ?>" required>
                                                    </div>
                                                </td>  
                                                <?php } ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <?php if ($lista_produto == false) { ?>
                                    <div class="text-center">
                                        <p>Nenhuma ordem de compra adicionada</p>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="financeiro">
                            <div class="row">                    
                                <div class="col-md-12 mt-3">  
                                    <div class="form-row">
                                        <div class="form-group col-md-5">
                                            <label>Método de Pagamento</label>
                                            <select class="selectpicker show-tick form-control"
                                                data-live-search="true" data-actions-box="true" title="Selecione um Método de Pagamento"
                                                name="CodMetodoPagamento" data-style="btn-input-primary">
                                                <?php foreach($lista_metodo_pagamento as $key_metodo_pagamento => $metodo_pagamento) { ?>
                                                <option value="<?= $metodo_pagamento->cod_metodo_pagamento ?>"
                                                    <?php if($metodo_pagamento->cod_metodo_pagamento == set_value('CodMetodoPagamento')) echo "selected"; ?>>
                                                    <?= $metodo_pagamento->cod_metodo_pagamento ?> - <?= $metodo_pagamento->nome_metodo_pagamento ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label>Conta Financeira </label>
                                            <select class="selectpicker show-tick form-control"
                                                    data-live-search="true" data-actions-box="true" title="Selecione uma Conta Financeira"
                                                    name="CodConta" data-style="btn-input-primary" required>
                                                <?php foreach($lista_conta as $key_conta => $conta) { ?>
                                                <option value="<?= $conta->cod_conta ?>"
                                                <?php if($conta->cod_conta == $empresa->conta_padrao) echo "selected"; ?>>
                                                <?= $conta->cod_conta ?> - <?= $conta->nome_conta ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                            <div class="help-block with-errors"></div>
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
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Centro de Custo</label>
                                            <select class="selectpicker show-tick form-control"
                                                    data-live-search="true" data-actions-box="true" title="Selecione um Centro de Custo"
                                                    name="CodCentroCusto" data-style="btn-input-primary">
                                                <?php foreach($lista_centro_custo as $key_centro_custo => $centro_custo) { ?>
                                                <option value="<?= $centro_custo->cod_centro_custo ?>"
                                                <?php if($centro_custo->cod_centro_custo == $empresa->centro_custo_compras) echo "selected"; ?>>
                                                <?= $centro_custo->cod_centro_custo ?> - <?= $centro_custo->nome_centro_custo ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Conta Contábil</label>
                                            <select class="selectpicker show-tick form-control" id="inputContaContabil<?= $produto->cod_produto ?>"
                                                    data-live-search="true" data-actions-box="true" title="Selecione uma Conta Contábil"
                                                    name="CodContaContabil" data-style="btn-input-primary">
                                                <?php foreach($lista_conta_contabil as $key_conta_contabil => $conta_contabil) { ?>
                                                <option value="<?= $conta_contabil->cod_conta_contabil ?>"
                                                <?php if($conta_contabil->cod_conta_contabil == $empresa->conta_contabil_compras) echo "selected"; ?>>
                                                <?= $conta_contabil->cod_conta_contabil ?> - <?= $conta_contabil->nome_conta_contabil ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>                             
                                </div>
                            </div>  
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-hover table-reporte">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col" class="text-center">Parcela</th>
                                                <th scope="col" class="text-center">Data Vencimento</th> 
                                                <th scope="col" class="text-center">Valor Parcela</th>
                                            </tr>
                                        </thead>
                                        <tbody id="pacela-table">
                                            <tr id="avista">
                                                <td class="text-center">1/1</td>
                                                <td>
                                                    <input type="text" class="form-control text-center" id="inputDataVencimento1"
                                                        name="DataVencimento[1]"
                                                        value="<?php if(set_value('DataVencimento[1]') == ""){
                                                                            echo str_replace('-', '/', date("d-m-Y"));
                                                                        }else{ echo set_value('DataVencimento[1]'); } ?>" required>
                                                </td>
                                                <td class="text-center">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">R$</span>
                                                        </div>
                                                        <input class="form-control text-center" id="inputValorParcela1" name="ValorParcela[1]" type="text" 
                                                            data-mask="#.##0,00" data-mask-reverse="true"
                                                            value="<?php if($pedido->valor_desconto != 0){
                                                                            if($pedido->tipo_desconto == 1){
                                                                                echo number_format(round($valorPendente - $pedido->valor_desconto, 2), 2, ',', '.');
                                                                            }elseif($pedido->tipo_desconto == 2){
                                                                                echo number_format($valorPendente - (round($valorPendente * ($pedido->valor_desconto / 100), 2)), 2, ',', '.');
                                                                            }
                                                                        }else{
                                                                            echo number_format($valorPendente, 2, ',', '.');
                                                                        }
                                                                    ?>" required>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <hr>                    
                    <div class="row">                    
                        <div class="col-md-12"> 
                            <div>
                                <div class="form-group">
                                    <label for="inputObservacao">Observações do Recebimento</label>
                                    <textarea class="form-control" rows="3" id="inputObservacao	" name="ObservReceb"><?= set_value('ObservReceb'); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="InserirRecebimento"><i class="fas fa-plus-circle"></i>
                    Receber Material</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<?php foreach($lista_produto as $key_produto => $produto) { ?>
<div class="modal fade" id="produto-ordem<?= $produto->cod_produto ?>">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ordens de Compra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-body-scroll">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <table class="table table-bordered table-striped table-reporte">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="text-center">Ord de Compra</th>
                                    <th scope="col" class="text-center">Data Necessidade</th>                                                      
                                    <th scope="col" class="text-center">Quant Pedida</th>
                                    <th scope="col" class="text-center">Quant Atendida</th>
                                    <th scope="col" class="text-center">Total da Compra</th>
                                    <th scope="col" class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($lista_ordem_compra as $key_ordem_compra => $ordem_compra) { 
                                      if($ordem_compra->cod_produto == $produto->cod_produto) {?>
                                <tr>
                                    <td scope="row"  class="text-center">
                                        <?= $ordem_compra->num_ordem_compra ?>
                                    </td>
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
                                                    echo "<span class='badge badge-primary'>Atendido Parcial</span>";
                                                    break;
                                                case 3:
                                                    echo "<span class='badge badge-teal'>Atendido Total</span>";
                                                break;
                                            } 

                                        }                                                        
                                    ?>
                                    </td>
                                </tr>
                                <?php } } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<div class="modal fade" id="recebimentos-pedido">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Recebimentos do Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-body-scroll">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <table class="table table-bordered table-striped table-reporte">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="text-center">Data Recebimento</th>
                                    <th scope="col" class="text-center">Recebimento</th>
                                    <th scope="col">Produto de Compra</th>  
                                    <th scope="col">Tipo do Produto</th>        
                                    <th scope="col" class="text-center">Un</th> 
                                    <th scope="col" class="text-center">Qtde Recebida</th>
                                    <th scope="col" class="text-center">Total da Compra</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($lista_recebimento_pedido as $key_recebimento_pedido => $recebimento_pedido) { ?>
                                <tr>
                                    <td class="text-center">
                                        <?= str_replace('-', '/', date("d-m-Y", strtotime($recebimento_pedido->data_movimento))) ?>
                                    </td>
                                    <td class="text-center"><?= $recebimento_pedido->cod_recebimento_material ?></td>
                                    <td><?= $recebimento_pedido->cod_produto ?> - <?= $recebimento_pedido->nome_produto ?></td>                                    
                                    <td><?= $recebimento_pedido->nome_tipo_produto ?></td>
                                    <td class="text-center"><?= $recebimento_pedido->cod_unidade_medida ?></td>
                                    <td class="text-center">
                                        <?= number_format($recebimento_pedido->quant_movimentada, 3, ',', '.') ?>
                                    </td>
                                    <td class="text-center">
                                        R$ <?= number_format($recebimento_pedido->valor_movimento, 2, ',', '.') ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php if ($lista_recebimento_pedido == false) { ?>
                        <div class="text-center">
                            <p>Nenhum recebimento de material realizado</p>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<?php foreach($lista_recebimento as $key_recebimento => $recebimento) { ?>
<div class="modal fade" id="produto-recebimento<?= $recebimento->cod_recebimento_material ?>">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Produtos Recebidos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-body-scroll">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <table class="table table-bordered table-striped table-reporte">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="text-center">Data Recebimento</th>
                                    <th scope="col" class="text-center">Recebimento</th>
                                    <th scope="col">Produto de Compra</th>  
                                    <th scope="col">Tipo do Produto</th>        
                                    <th scope="col" class="text-center">Un</th> 
                                    <th scope="col" class="text-center">Qtde Recebida</th>
                                    <th scope="col" class="text-center">Total da Compra</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($lista_recebimento_pedido as $key_recebimento_pedido => $recebimento_pedido) { 
                                      if($recebimento_pedido->cod_recebimento_material == $recebimento->cod_recebimento_material) {?>
                                <tr>
                                    <td class="text-center">
                                        <?= str_replace('-', '/', date("d-m-Y", strtotime($recebimento_pedido->data_movimento))) ?>
                                    </td>
                                    <td class="text-center"><?= $recebimento_pedido->cod_recebimento_material ?></td>
                                    <td><?= $recebimento_pedido->cod_produto ?> - <?= $recebimento_pedido->nome_produto ?></td>                                    
                                    <td><?= $recebimento_pedido->nome_tipo_produto ?></td>
                                    <td class="text-center"><?= $recebimento_pedido->cod_unidade_medida ?></td>
                                    <td class="text-center">
                                        <?= number_format($recebimento_pedido->quant_movimentada, 3, ',', '.') ?>
                                    </td>
                                    <td class="text-center">
                                        R$ <?= number_format($recebimento_pedido->valor_movimento, 2, ',', '.') ?>
                                    </td>
                                </tr>
                                <?php } } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<script>
$(function() {
     $.applyDataMask();
});
    
$("[name='estornar_todos[]']").click(function() {
    var cont = $("[name='estornar_todos[]']:checked").length;
    $("#btnEstorno").prop("disabled", cont ? false : true);
});

$('#inputFornecedor').selectpicker({
    style: 'btn-input-primary'
});

$('#inputDataRecebimento').datepicker({
    uiLibrary: 'bootstrap4'
});

$('#inputDataVencimento1').datepicker({
    uiLibrary: 'bootstrap4'
});

<?php foreach($lista_produto as $key_produto => $produto) { ?>
jQuery('#inputValorCompra' + "<?php echo $produto->cod_produto; ?>").on('keyup', function() {

    calcTotalCompra();
    
});
<?php } ?>

jQuery('#inputValorDesconto').on('keyup', function() {
    calcTotalCompra();
});

function calcTotalCompra() { 

    var totalBruto = 0;
    var valorDesconto = parseFloat(jQuery('#inputValorDesconto').val() != '' ? (jQuery('#inputValorDesconto').val().split('.').join('')).replace(',', '.') : 0);
    var totalLiquido = 0;

    <?php foreach($lista_produto as $key_produto => $produto) { ?> 
        var totalBruto = totalBruto + parseFloat(jQuery('#inputValorCompra' + '<?= $produto->cod_produto ?>').val() != '' ? (jQuery('#inputValorCompra' + '<?= $produto->cod_produto ?>').val().split('.').join('')).replace(',', '.') : 0);
    <?php } ?>

    totalLiquido = round(totalBruto - valorDesconto, 2);

    $("#inputValorBruto").html("<strong>R$ " + totalBruto.toLocaleString("pt-BR", {
            style: "decimal",
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
    }) + "</strong>");

    $("#inputValorLiq").html("R$ " + totalLiquido.toLocaleString("pt-BR", {
            style: "decimal",
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
    }));

    var quantParcela = $('#inputParcelas').val();

    var valorTotal = totalLiquido;
    var acumulado = 0;

    for (var i = 1; i <= quantParcela; i++) { 

        valorParcela = round((valorTotal / quantParcela), 2);
        acumulado = acumulado + valorParcela;

        if(i == quantParcela && acumulado != valorTotal){
            valorParcela = valorParcela + (valorTotal - acumulado);
        }

        $('#inputValorParcela' + i).val(valorParcela.toLocaleString("pt-BR", {
                                        style: "decimal",
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    }));

    }
    
};

$("#inputParcelas").change(function() {

    var quantParcela = $('#inputParcelas').val();

    var dataParcela = new Date(String($('#inputDataVencimento1').val().split('/').reverse().join('-')));

    var valorTotal = parseFloat(jQuery('#inputValorLiq').text() != '' ? (jQuery('#inputValorLiq').text().split('.').join('')).replace(',', '.').replace('R$', '') : 0);
    var acumulado = 0;

    $("#pacela-table").empty();

    for (var i = 1; i <= quantParcela; i++) {   
        
        valorParcela = round((valorTotal / quantParcela), 2);
        acumulado = acumulado + valorParcela;

        if(i == quantParcela && acumulado != valorTotal){
            valorParcela = valorParcela + (valorTotal - acumulado);
        }

        var newRow = $("<tr>");	    
        var cols = "";
        
        // Número da parcela
        cols += '<td class="text-center">' + i + '/' + quantParcela + '</td>';
        
        if(i > 1){
            var currentDay = dataParcela.getDate();
            var currentMonth = dataParcela.getMonth();
            dataParcela.setMonth(currentMonth + 1, currentDay);
        }     

        
        //Data de vencimento previsto
        cols += '<td>';
        cols += '<input type="text" class="form-control text-center" id="inputDataVencimento' + i + '"';
        cols += 'name="DataVencimento[' + i + ']"';
        cols += 'value="' + dataParcela.toLocaleDateString('pt-BR', {timeZone: 'UTC'}) + '" required>';
        cols += '</td>';
        
        // Valor da parcela
        cols += '<td>';
        cols += '<div class="input-group">';
        cols += '<div class="input-group-prepend">';
        cols += '<span class="input-group-text">R$</span>';
        cols += '</div>';
        cols += '<input class="form-control text-center" id="inputValorParcela' + i + '" name="ValorParcela[' + i + ']" type="text" ';
        cols += 'data-mask="#.##0,00" data-mask-reverse="true"';
        cols += 'value="' + valorParcela.toLocaleString("pt-BR", {
                                    style: "decimal",
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                            });
        cols += '" required>';
        cols += '</div>';
        cols += '</td>';	    

        newRow.append(cols);	    
        $("#pacela-table").append(newRow);

        $('#inputDataVencimento' + i).datepicker({
            uiLibrary: 'bootstrap4'
        });

    }

    $.applyDataMask();
    

    return;	  

});

const round = (num, places) => {
	return +(parseFloat(num).toFixed(places));
}

</script>

<?php $this->load->view('gerais/footer'); ?>