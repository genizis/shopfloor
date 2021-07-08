<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active">Contas a Receber</li>
        </ol>
    </div>
</section>


<section>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card  mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <a href="<?= base_url("financeiro/contas-receber/{$mes_anterior}/{$ano_anterior}") ?>"
                                            class="btn btn-secondary"><i class="fas fa-angle-left"></i></a>
                                    </div>
                                    <input type="text" class="form-control search text-center"
                                        value="<?= $mes ?>/<?= $ano ?>" readonly>
                                    <div class="input-group-append">
                                        <a href="<?= base_url("financeiro/contas-receber/{$mes_seguinte}/{$ano_seguinte}") ?>"
                                            class="btn btn-secondary"><i class="fas fa-angle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card  mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-borderless table-sm mb-0 small2">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th scope="col" class="text-right">Confirmado</th>
                                            <th scope="col" class="text-right">Projetado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $saldoConfirTotal = 0; 
                                          $saldoProjTotal = 0; 
                                          foreach($lista_conta as $key_conta => $conta) { 
                                            if(date(''.$ano.'-'.$mes.'-01') == date('Y-m-01')){
                                                $saldoConta = $conta->saldo_conta;
                                            }else{
                                                $saldoConta = $conta->saldo_conta + $conta->valor_saida - $conta->valor_entrada;
                                            }
                                            
                                            $saldoProj = $saldoConta - $conta->proj_saida + $conta->proj_entrada;
                                            
                                            $saldoConfirTotal = $saldoConfirTotal + $saldoConta;
                                            $saldoProjTotal = $saldoProjTotal + $saldoProj;
                                            
                                            if($conta->cod_conta != 0 || $saldoConta != 0 || $saldoProj != 0) { ?>
                                        <tr>
                                            <td class="limit-text-15" data-toggle="tooltip" data-placement="bottom"
                                                title="<?= $conta->nome_conta ?>"><?= $conta->nome_conta ?></td>
                                            <td class="<?php if($saldoConta > 0) echo "text-teal";
                                                         if($saldoConta < 0) echo "text-danger"; ?> text-right">R$
                                                <?= number_format($saldoConta, 2, ',', '.') ?></td>
                                            <td class="<?php if($saldoProj > 0) echo "text-teal";
                                                         if($saldoProj < 0) echo "text-danger"; ?> text-right">R$
                                                <?= number_format($saldoProj, 2, ',', '.') ?></td>
                                        </tr>
                                        <?php }} ?>
                                        <tr class="border-top">
                                            <td><strong>TOTAL</strong></td>
                                            <td class="<?php if($saldoConfirTotal > 0) echo "text-teal";
                                                         if($saldoConfirTotal < 0) echo "text-danger"; ?> text-right">
                                                <strong>R$ <?= number_format($saldoConfirTotal, 2, ',', '.') ?></strong>
                                            </td>
                                            <td class="<?php if($saldoProjTotal > 0) echo "text-teal";
                                                         if($saldoProjTotal < 0) echo "text-danger"; ?> text-right">
                                                <strong>R$ <?= number_format($saldoProjTotal, 2, ',', '.') ?></strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <form action="<?= base_url("financeiro/contas-receber/{$mes}/{$ano}") ?>" method="get"
                            class="mb-0 needs-validation" novalidate>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <select class="selectpicker show-tick form-control" multiple data-live-search="true"
                                        data-actions-box="true" title="Cliente" data-style="btn-input-primary"
                                        name="ClienteFiltro[]">
                                        <?php $chave_cliente = 0; foreach($lista_cliente as $key_cliente => $cliente) { ?>
                                        <option value="<?= $cliente->cod_cliente ?>" <?php if($clienteFiltro != null){if($cliente->cod_cliente == $clienteFiltro[$chave_cliente]){ 
                                                if((count($clienteFiltro) - 1) > $chave_cliente) {$chave_cliente = $chave_cliente + 1; } 
                                                echo "selected"; }}?>>
                                            <?= $cliente->cod_cliente ?> -
                                            <?= $cliente->nome_cliente ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <select class="selectpicker show-tick form-control" multiple data-live-search="true"
                                        data-actions-box="true" title="Método de Pagamento"
                                        name="MetodoPagamentoFiltro[]" data-style="btn-input-primary">
                                        <?php $chave_metodo_pagamento = 0; foreach($lista_metodo_pagamento as $key_metodo_pagamento => $metodo_pagamento) { ?>
                                        <option value="<?= $metodo_pagamento->cod_metodo_pagamento ?>" <?php if($metodoPagamentoFiltro != null){if($metodo_pagamento->cod_metodo_pagamento == $metodoPagamentoFiltro[$chave_metodo_pagamento]){ 
                                                if((count($metodoPagamentoFiltro) - 1) > $chave_metodo_pagamento) {$chave_metodo_pagamento = $chave_metodo_pagamento + 1; } 
                                                echo "selected"; }}?>>
                                            <?= $metodo_pagamento->cod_metodo_pagamento ?> -
                                            <?= $metodo_pagamento->nome_metodo_pagamento ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <select class="selectpicker show-tick form-control" multiple data-live-search="true"
                                        data-actions-box="true" title="Conta Financeiro" name="ContaFinanceiraFiltro[]"
                                        data-style="btn-input-primary">
                                        <?php $chave_conta = 0; foreach($lista_conta as $key_conta => $conta) { ?>
                                        <option value="<?= $conta->cod_conta ?>" <?php if($contaFinanceiraFiltro != null){if($conta->cod_conta == $contaFinanceiraFiltro[$chave_conta]){ 
                                                if((count($contaFinanceiraFiltro) - 1) > $chave_conta) {$chave_conta = $chave_conta + 1; } 
                                                echo "selected"; }}?>>
                                            <?= $conta->cod_conta ?> - <?= $conta->nome_conta ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <select class="selectpicker show-tick form-control" multiple data-live-search="true"
                                        data-actions-box="true" title="Centro de Custo" name="CentroCustoFiltro[]"
                                        data-style="btn-input-primary">
                                        <?php $chave_centro_custo = 0; foreach($lista_centro_custo as $key_centro_custo => $centro_custo) { ?>
                                        <option value="<?= $centro_custo->cod_centro_custo ?>" <?php if($centroCustoFiltro != null){if($centro_custo->cod_centro_custo == $centroCustoFiltro[$chave_centro_custo]){ 
                                                if((count($centroCustoFiltro) - 1) > $chave_centro_custo) {$chave_centro_custo = $chave_centro_custo + 1; } 
                                                echo "selected"; }}?>>
                                            <?= $centro_custo->cod_centro_custo ?> -
                                            <?= $centro_custo->nome_centro_custo ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <select class="selectpicker show-tick form-control" multiple data-live-search="true"
                                        data-actions-box="true" title="Conta Contábil" name="ContaContabilFiltro[]"
                                        data-style="btn-input-primary">
                                        <?php $chave_conta_contabil = 0; foreach($lista_conta_contabil as $key_conta_contabil => $conta_contabil) { ?>
                                        <option value="<?= $conta_contabil->cod_conta_contabil ?>" <?php if($contaContabilFiltro != null){if($conta_contabil->cod_conta_contabil == $contaContabilFiltro[$chave_conta_contabil]){ 
                                                if((count($contaContabilFiltro) - 1) > $chave_conta_contabil) {$chave_conta_contabil = $chave_conta_contabil + 1; } 
                                                echo "selected"; }}?>>
                                            <?= $conta_contabil->cod_conta_contabil ?> -
                                            <?= $conta_contabil->nome_conta_contabil ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <select class="selectpicker show-tick form-control" multiple data-live-search="true"
                                        data-actions-box="true" title="Vendedor" name="VendedorFiltro[]"
                                        data-style="btn-input-primary">
                                        <?php $chave_vendedor = 0; foreach($lista_vendedor as $key_vendedor => $vendedor) { ?>
                                        <option value="<?= $vendedor->cod_vendedor ?>" <?php if($vendedorFiltro != null){if($vendedor->cod_vendedor == $vendedorFiltro[$chave_vendedor]){ 
                                                if((count($vendedorFiltro) - 1) > $chave_vendedor) {$chave_vendedor = $chave_vendedor + 1; } 
                                                echo "selected"; }}?>>
                                            <?= $vendedor->cod_vendedor ?> - <?= $vendedor->nome_vendedor ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-outline-primary btn-block">Filtrar
                                        Títulos</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card  mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <button data-toggle="modal" data-target="#inserir-titulo" type="button"
                                    class="btn btn-outline-info btn-sm"><i class="fas fa-plus-circle"></i> Novo
                                    Título</button>
                                <button data-toggle="modal" data-target="#confirma-titulo" type="button"
                                    class="btn btn-outline-teal btn-sm" id="btnConfirmar" disabled><i
                                        class="fas fa-check"></i> Confirmar</button>
                                <button data-toggle="modal" data-target="#elimina-titulo" type="button"
                                    class="btn btn-outline-danger btn-sm" id="btnExcluir" disabled><i
                                        class="fas fa-trash-alt"></i> Excluir</button>
                            </div>
                            <div class="col-md-3">
                                <h3 class="font-weight-bold mb-0 text-right text-teal" id="ValorTotalSel"></h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <?php if ($this->session->flashdata('erro') <> ""){ ?>
                                <div class="alert alert-danger alert-dismissible fade show mt-2 mb-0" id="alert"
                                    role="alert">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong>Atenção!</strong> <?= $this->session->flashdata('erro') ?>
                                </div>
                                <?php } $this->session->set_flashdata('erro', ''); ?>
                                <?php if ($this->session->flashdata('sucesso') <> ""){ ?>
                                <div class="alert alert-success alert-dismissible fade show mt-2 mb-0" id="alert"
                                    role="alert">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong>Muito bem!</strong>
                                    <?= $this->session->flashdata('sucesso') ?>
                                </div>
                                <?php } $this->session->set_flashdata('sucesso', ''); ?>
                                <form action="<?= base_url("financeiro/contas-receber/acao-titulo/{$mes}/{$ano}") ?>"
                                    method="POST" id="formAcao" class="mb-0 needs-validation" novalidate>
                                    <table class="table table-hover table-bordered small">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col" class="text-center">
                                                    <div class="checkbox text-center">
                                                        <input id="select-all" type="checkbox" />
                                                    </div>
                                                </th>
                                                <th scope="col" class="text-center">Título</th>
                                                <th scope="col" class="text-center">Data Vencimento</th>
                                                <th scope="col">Descrição</th>
                                                <th scope="col" class="text-center">Parcela</th>
                                                <th scope="col" class="text-center">Valor do Título</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($lista_contas_receber as $key_contas_receber => $contas_receber) { ?>
                                            <tr>
                                                <td>
                                                    <div class="checkbox text-center">
                                                        <input name="selecionar_todos[]" type="checkbox"
                                                            value="<?= $contas_receber->cod_movimento_conta ?>" />
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#editar-titulo<?= $contas_receber->cod_movimento_conta ?>">
                                                        <?= $contas_receber->cod_movimento_conta ?></a>
                                                </td>
                                                <td
                                                    class="text-center 
                                                            <?php if($contas_receber->data_vencimento < date('Y-m-d')) echo "text-danger"; ?>
                                                            <?php if($contas_receber->data_vencimento == date('Y-m-d')) echo "text-warning"; ?>">
                                                    <?= str_replace('-', '/', date("d-m-Y", strtotime($contas_receber->data_vencimento))) ?>
                                                    <?php if($contas_receber->data_vencimento < date('Y-m-d')) { ?>
                                                    <span class="badge badge-danger">
                                                        <?php 
                                                        $date1 = date_create($contas_receber->data_vencimento);
                                                        $date2 = date_create(date('Y-m-d'));
                                                        $diff = date_diff($date1,$date2);
                                                        echo $diff->format("%a"); 
                                                    ?>
                                                    </span>
                                                    <?php } ?>
                                                </td>
                                                <td class="limit-text-50" data-toggle="tooltip" data-placement="bottom"
                                                    title="<?= $contas_receber->desc_movimento ?>">
                                                    <?= $contas_receber->desc_movimento ?>
                                                </td>
                                                <td class="text-center"><?= $contas_receber->parcela ?></td>
                                                <td class="text-center text-teal"
                                                    id="ValorTitulo<?= $contas_receber->cod_movimento_conta ?>">
                                                    R$ <?= number_format($contas_receber->valor_titulo, 2, ',', '.') ?>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <?php if ($lista_contas_receber == false) { ?>
                                    <div class="text-center">
                                        <p class="text-muted mb-0">Nenhuma título encontrado</p>
                                    </div>
                                    <?php } ?>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-xs-12">
                                <div>
                                    <?= $pagination; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="elimina-titulo" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Título Contas a Receber</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirma eliminação do(s) título(s) selecionado(s)?
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="Acao" value="Eliminar"
                    form="formAcao">Confirma</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirma-titulo" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Título Contas a Receber</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Deseja confirmar o(s) título(s) selecionado(s)?
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="Acao" value="Confirmar"
                    form="formAcao">Confirma</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="inserir-titulo">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Título Contas a Receber</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <form class="mb-0 needs-validation" novalidate
                            action="<?= base_url("financeiro/contas-receber/inserir-titulo/{$mes}/{$ano}") ?>"
                            method='post' id='formTitulo'>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputDataCompetencia">Data de Competência <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="inputDataCompetencia"
                                        name="DataCompetencia" value="<?php if(set_value('DataCompetencia') == ""){
                                                                echo str_replace('-', '/', date("d-m-Y"));
                                                            }else{ echo set_value('DataCompetencia'); } ?>" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="inputValorTitulo">Valor do Título <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" class="form-control" class="form-control"
                                            id="inputValorTitulo" type="text" name="ValorTitulo" data-mask="#.##0,00"
                                            data-mask-reverse="true" value="<?= set_value('ValorTitulo'); ?>" required>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputParcelas">Parcelas</label>
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
                            <hr>
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
                                                    <input type="text" class="form-control text-center"
                                                        id="inputDataVencimento1" name="DataVencimento[1]"
                                                        value="<?php if(set_value('DataVencimento[1]') == ""){
                                                                            echo str_replace('-', '/', date("d-m-Y"));
                                                                        }else{ echo set_value('DataVencimento[1]'); } ?>" required>
                                                </td>
                                                <td class="text-center">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">R$</span>
                                                        </div>
                                                        <input class="form-control text-center" id="inputValorParcela1"
                                                            name="ValorParcela[1]" type="text" data-mask="#.##0,00"
                                                            data-mask-reverse="true"
                                                            value="<?= set_value('ValorTitulo'); ?>" required>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputCliente">Cliente <span class="text-danger">*</span></label>
                                    <select id="inputCliente" class="selectpicker show-tick form-control"
                                        data-live-search="true" data-actions-box="true" title="Selecione um Cliente"
                                        data-style="btn-input-primary" name="CodCliente">
                                        <?php foreach($lista_cliente as $key_cliente => $cliente) { ?>
                                        <option value="<?= $cliente->cod_cliente ?>"
                                            <?php if($cliente->cod_cliente == set_value('CodCliente')) echo "selected"; ?>>
                                            <?= $cliente->cod_cliente ?> -
                                            <?= $cliente->nome_cliente ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Método de Pagamento</label>
                                    <select class="selectpicker show-tick form-control" data-live-search="true"
                                        data-actions-box="true" title="Selecione um Método de Pagamento"
                                        name="CodMetodoPagamento" data-style="btn-input-primary">
                                        <?php foreach($lista_metodo_pagamento as $key_metodo_pagamento => $metodo_pagamento) { ?>
                                        <option value="<?= $metodo_pagamento->cod_metodo_pagamento ?>"
                                            <?php if($metodo_pagamento->cod_metodo_pagamento == set_value('CodMetodoPagamento')) echo "selected"; ?>>
                                            <?= $metodo_pagamento->cod_metodo_pagamento ?> -
                                            <?= $metodo_pagamento->nome_metodo_pagamento ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputConta">Conta <span class="text-danger">*</span></label>
                                    <select id="inputConta" class="selectpicker show-tick form-control"
                                        data-live-search="true" data-actions-box="true" title="Selecione uma Conta"
                                        name="CodConta" data-style="btn-input-primary" required>
                                        <?php foreach($lista_conta as $key_conta => $conta) { ?>
                                        <option value="<?= $conta->cod_conta ?>"
                                            <?php if($conta->cod_conta == set_value('CodConta')) echo "selected"; ?>>
                                            <?= $conta->cod_conta ?> - <?= $conta->nome_conta ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputContaContabil">Conta Contábil</label>
                                    <select id="inputContaContabil" class="selectpicker show-tick form-control"
                                        data-live-search="true" data-actions-box="true"
                                        title="Selecione uma Conta Contábil" name="CodContaContabil"
                                        data-style="btn-input-primary">
                                        <?php foreach($lista_conta_contabil as $key_conta_contabil => $conta_contabil) { ?>
                                        <option value="<?= $conta_contabil->cod_conta_contabil ?>"
                                            <?php if($conta_contabil->cod_conta_contabil == set_value('CodContaContabil')) echo "selected"; ?>>
                                            <?= $conta_contabil->cod_conta_contabil ?> -
                                            <?= $conta_contabil->nome_conta_contabil ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputCentroCusto">Centro de Custo</label>
                                    <select id="inputCentroCusto" class="selectpicker show-tick form-control"
                                        data-live-search="true" data-actions-box="true"
                                        title="Selecione um Centro de Custo" name="CodCentroCusto"
                                        data-style="btn-input-primary">
                                        <?php foreach($lista_centro_custo as $key_centro_custo => $centro_custo) { ?>
                                        <option value="<?= $centro_custo->cod_centro_custo ?>"
                                            <?php if($centro_custo->cod_centro_custo == set_value('CodCentroCustoa')) echo "selected"; ?>>
                                            <?= $centro_custo->cod_centro_custo ?> -
                                            <?= $centro_custo->nome_centro_custo ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="control-label" for="inputDescricao">Descrição Título</label>
                                    <input class="form-control" id="inputDescricao" type="text" name="Descricao"
                                        value="<?= set_value('Descricao') ?>">
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="inputConfirmar"
                                            name="Confirmar" value="1">
                                        <label class="custom-control-label" for="inputConfirmar">Confirmar
                                            Título</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row" id="dataConfirmacao" style="display: none">
                                <div class="form-group col-md-3">
                                    <label class="control-label">Data da Confirmação</label>
                                    <input type="text" class="form-control" id="inputDataConfirmacao"
                                        name="DataConfirmacao" value="<?= set_value('DataConfirmacao') ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="inputValorDescontoTaxas">Descontos e Taxas</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" class="form-control" class="form-control"
                                            id="inputValorDescontoTaxas" type="text" name="ValorDescontoTaxas"
                                            data-mask="#.##0,00" data-mask-reverse="true"
                                            value="<?= set_value('ValorDescontoTaxas'); ?>">
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="inputValorMultasJustos">Multas e Juros</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" class="form-control" class="form-control"
                                            id="inputValorMultasJustos" type="text" name="ValorMultasJustos"
                                            data-mask="#.##0,00" data-mask-reverse="true"
                                            value="<?= set_value('ValorMultasJustos'); ?>">
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="inputValorReceber">Valor a Pagar</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" class="form-control" class="form-control" readonly
                                            id="inputValorReceber" type="text" name="ValorReceber" data-mask="#.##0,00"
                                            data-mask-reverse="true" value="<?= set_value('ValorReceber'); ?>">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="formTitulo"><i class="fas fa-save"></i>
                    Salvar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<?php foreach($lista_contas_receber as $key_contas_receber => $contas_receber) { ?>
<div class="modal fade" id="editar-titulo<?= $contas_receber->cod_movimento_conta ?>">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Título Contas a Receber</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form class="mb-0 needs-validation" novalidate
                            action="<?= base_url("financeiro/contas-receber/editar-titulo/{$contas_receber->cod_movimento_conta}/{$mes}/{$ano}") ?>"
                            method='post' id='formTitulo<?= $contas_receber->cod_movimento_conta ?>'>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label class="control-label">Título</label>
                                    <input class="form-control" type="text"
                                        value="<?= $contas_receber->cod_movimento_conta ?>" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">Data de Competência</label>
                                    <input class="form-control" type="text"
                                        value="<?= str_replace('-', '/', date("d-m-Y", strtotime($contas_receber->data_competencia))) ?>"
                                        readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">Valor do Título <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" class="form-control" class="form-control"
                                            id="inputValorTitulo<?= $contas_receber->cod_movimento_conta ?>" type="text"
                                            name="ValorTitulo" data-mask="#.##0,00" data-mask-reverse="true"
                                            value="<?= $contas_receber->valor_titulo ?>" required>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Data de Vencimento <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control"
                                        id="inputDataVencimentoEdit<?= $contas_receber->cod_movimento_conta ?>"
                                        name="DataVencimento"
                                        value="<?= str_replace('-', '/', date("d-m-Y", strtotime($contas_receber->data_vencimento))) ?>"
                                        required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Cliente</label>
                                    <select class="selectpicker show-tick form-control" data-live-search="true"
                                        data-actions-box="true" title="Selecione um Cliente"
                                        data-style="btn-input-primary" name="CodCliente">
                                        <?php foreach($lista_cliente as $key_cliente => $cliente) { ?>
                                        <option value="<?= $cliente->cod_cliente ?>"
                                            <?php if($cliente->cod_cliente == $contas_receber->cod_emitente) echo "selected"; ?>>
                                            <?= $cliente->cod_cliente ?> -
                                            <?= $cliente->nome_cliente ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Método de Pagamento</label>
                                    <select class="selectpicker show-tick form-control" data-live-search="true"
                                        data-actions-box="true" title="Selecione um Método de Pagamento"
                                        name="CodMetodoPagamento" data-style="btn-input-primary">
                                        <?php foreach($lista_metodo_pagamento as $key_metodo_pagamento => $metodo_pagamento) { ?>
                                        <option value="<?= $metodo_pagamento->cod_metodo_pagamento ?>"
                                            <?php if($metodo_pagamento->cod_metodo_pagamento == $contas_receber->cod_metodo_pagamento) echo "selected"; ?>>
                                            <?= $metodo_pagamento->cod_metodo_pagamento ?> -
                                            <?= $metodo_pagamento->nome_metodo_pagamento ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Conta Financeira <span class="text-danger">*</span></label>
                                    <select class="selectpicker show-tick form-control" data-live-search="true"
                                        data-actions-box="true" title="Selecione uma Conta" name="CodConta"
                                        data-style="btn-input-primary" required>
                                        <?php foreach($lista_conta as $key_conta => $conta) { ?>
                                        <option value="<?= $conta->cod_conta ?>"
                                            <?php if($conta->cod_conta == $contas_receber->cod_conta) echo "selected"; ?>>
                                            <?= $conta->cod_conta ?> - <?= $conta->nome_conta ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Centro de Custo</label>
                                    <select class="selectpicker show-tick form-control" data-live-search="true"
                                        data-actions-box="true" title="Selecione um Centro de Custo"
                                        name="CodCentroCusto" data-style="btn-input-primary">
                                        <?php foreach($lista_centro_custo as $key_centro_custo => $centro_custo) { ?>
                                        <option value="<?= $centro_custo->cod_centro_custo ?>"
                                            <?php if($centro_custo->cod_centro_custo == $contas_receber->cod_centro_custo) echo "selected"; ?>>
                                            <?= $centro_custo->cod_centro_custo ?> -
                                            <?= $centro_custo->nome_centro_custo ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Conta Contábil</label>
                                    <select class="selectpicker show-tick form-control" data-live-search="true"
                                        data-actions-box="true" title="Selecione uma Conta Contábil"
                                        name="CodContaContabil" data-style="btn-input-primary">
                                        <?php foreach($lista_conta_contabil as $key_conta_contabil => $conta_contabil) { ?>
                                        <option value="<?= $conta_contabil->cod_conta_contabil ?>"
                                            <?php if($conta_contabil->cod_conta_contabil == $contas_receber->cod_conta_contabil) echo "selected"; ?>>
                                            <?= $conta_contabil->cod_conta_contabil ?> -
                                            <?= $conta_contabil->nome_conta_contabil ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="control-label">Descrição Título</label>
                                    <input class="form-control" type="text" name="Descricao"
                                        value="<?= $contas_receber->desc_movimento ?>">
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input"
                                            id="inputConfirmarEdit<?= $contas_receber->cod_movimento_conta ?>"
                                            name="Confirmar" value="1"
                                            <?php if($contas_receber->confirmado == 1) echo "checked"; ?>>
                                        <label class="custom-control-label"
                                            for="inputConfirmarEdit<?= $contas_receber->cod_movimento_conta ?>">Confirmar
                                            Título</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row" id="dataConfirmacao<?= $contas_receber->cod_movimento_conta ?>"
                                style="display: none">
                                <div class="form-group col-md-3">
                                    <label class="control-label"
                                        for="inputDataConfirmacao<?= $contas_receber->cod_movimento_conta ?>">Data de
                                        Confirmação <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control"
                                        id="inputDataConfirmacao<?= $contas_receber->cod_movimento_conta ?>"
                                        name="DataConfirmacao" value="<?= set_value('DataConfirmacao') ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label"
                                        for="inputValorDescontoTaxas<?= $contas_receber->cod_movimento_conta ?>">Descontos
                                        e Taxas</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" class="form-control" class="form-control"
                                            id="inputValorDescontoTaxas<?= $contas_receber->cod_movimento_conta ?>"
                                            type="text" name="ValorDescontoTaxas" data-mask="#.##0,00"
                                            data-mask-reverse="true" value="<?= $contas_receber->valor_desc_taxa ?>">
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label"
                                        for="inputValorMultasJustos<?= $contas_receber->cod_movimento_conta ?>">Multas e
                                        Juros</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" class="form-control" class="form-control"
                                            id="inputValorMultasJustos<?= $contas_receber->cod_movimento_conta ?>"
                                            type="text" name="ValorMultasJustos" data-mask="#.##0,00"
                                            data-mask-reverse="true" value="<?= $contas_receber->valor_juros_multa ?>">
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label"
                                        for="inputValorReceber<?= $contas_receber->cod_movimento_conta ?>">Valor a
                                        Receber</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" class="form-control" class="form-control" readonly
                                            id="inputValorReceber<?= $contas_receber->cod_movimento_conta ?>"
                                            type="text" name="ValorReceber" data-mask="#.##0,00"
                                            data-mask-reverse="true" value="<?= set_value('ValorReceber'); ?>">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"
                    form="formTitulo<?= $contas_receber->cod_movimento_conta ?>"><i class="fas fa-save"></i>
                    Salvar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<script>
$('.page-item>a').addClass("page-link");

$(function() {
    $.applyDataMask();
});

function calculaTitulo() {

    var cont = $("[name='selecionar_todos[]']:checked").length;
    $("#btnExcluir").prop("disabled", cont ? false : true);

    var total = 0;
    var indice = 0;
    $("input[name='selecionar_todos[]']:checked").each(function() {

        indice = $(this).val();

        valorTitulo = parseFloat(jQuery('#ValorTitulo' + indice).text() != '' ? (jQuery('#ValorTitulo' +
            indice).text().split('.').join('')).replace(',', '.').replace('R$', '') : 0);
        total = total + valorTitulo;

    });

    if (total > 0) {

        $('#ValorTotalSel').text('R$ ' + total.toLocaleString("pt-BR", {
            style: "decimal",
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));
    } else {
        $('#ValorTotalSel').text('');
    }

}

$('#select-all').click(function(event) {
    if (this.checked) {
        // Iterate each checkbox
        $("input[name='selecionar_todos[]']").each(function() {
            this.checked = true;
        });
    } else {
        $("input[name='selecionar_todos[]']").each(function() {
            this.checked = false;
        });
    }

    calculaTitulo();
});

$("[name='selecionar_todos[]']").click(function() {

    calculaTitulo();

});

$("[name='selecionar_todos[]']").click(function() {
    var cont = $("[name='selecionar_todos[]']:checked").length;
    $("#btnConfirmar").prop("disabled", cont ? false : true);
});

$('#inputDataVencimento1').datepicker({
    uiLibrary: 'bootstrap4'
});

$('#inputDataCompetencia').datepicker({
    uiLibrary: 'bootstrap4'
});

$('#inputDataConfirmacao').datepicker({
    uiLibrary: 'bootstrap4'
});

$("#inputConfirmar").on('change', function() {

    if ($("#dataConfirmacao").is(":hidden")) {
        $("#dataConfirmacao").show(300);
        $("#inputDataConfirmacao").val("<?= str_replace('-', '/', date("d-m-Y")) ?>");
        calcValorReceber();
    } else {
        $("#dataConfirmacao").hide(300);
        $("#inputDataConfirmacao").val("");
        $("#inputValorPagar").val("");
    };

});

jQuery('#inputValorTitulo').on('keyup', function() {
    calcValorReceber();
});
jQuery('#inputValorDescontoTaxas').on('keyup', function() {
    calcValorReceber();
});
jQuery('#inputValorMultasJustos').on('keyup', function() {
    calcValorReceber();
});

function calcValorReceber() {

    var chkConfirm = document.getElementById("inputConfirmar");
    if (chkConfirm.checked == true) {

        var valorTitulo = parseFloat(jQuery('#inputValorTitulo').val() != '' ? (jQuery('#inputValorTitulo').val().split(
            '.').join('')).replace(',', '.') : 0);
        var descTaxas = parseFloat(jQuery('#inputValorDescontoTaxas').val() != '' ? (jQuery('#inputValorDescontoTaxas')
            .val().split('.').join('')).replace(',', '.') : 0);
        var multJuros = parseFloat(jQuery('#inputValorMultasJustos').val() != '' ? (jQuery('#inputValorMultasJustos')
            .val().split('.').join('')).replace(',', '.') : 0);

        var totalPagar = valorTitulo - descTaxas + multJuros;

        $('#inputValorReceber').val(totalPagar.toLocaleString("pt-BR", {
            style: "decimal",
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));

    }

}

<?php foreach($lista_contas_receber as $key_contas_receber => $contas_receber) { ?>
$('#inputDataVencimentoEdit<?= $contas_receber->cod_movimento_conta ?>').datepicker({
    uiLibrary: 'bootstrap4'
});

$('#inputDataConfirmacao<?= $contas_receber->cod_movimento_conta ?>').datepicker({
    uiLibrary: 'bootstrap4'
});

$("#inputConfirmarEdit<?= $contas_receber->cod_movimento_conta ?>").on('change', function() {

    if ($("#dataConfirmacao<?= $contas_receber->cod_movimento_conta ?>").is(":hidden")) {
        $("#dataConfirmacao<?= $contas_receber->cod_movimento_conta ?>").show(300);
        $("#inputDataConfirmacao<?= $contas_receber->cod_movimento_conta ?>").val(
            "<?= str_replace('-', '/', date("d-m-Y")) ?>");
        calcValorReceberEdit(<?= $contas_receber->cod_movimento_conta ?>);
    } else {
        $("#dataConfirmacao<?= $contas_receber->cod_movimento_conta ?>").hide(300);
        $("#inputValorReceber<?= $contas_receber->cod_movimento_conta ?>").val("");
    };

});

jQuery('#inputValorTitulo<?= $contas_receber->cod_movimento_conta ?>').on('keyup', function() {
    calcValorReceberEdit(<?= $contas_receber->cod_movimento_conta ?>);
});
jQuery('#inputValorDescontoTaxas<?= $contas_receber->cod_movimento_conta ?>').on('keyup', function() {
    calcValorReceberEdit(<?= $contas_receber->cod_movimento_conta ?>);
});
jQuery('#inputValorMultasJustos<?= $contas_receber->cod_movimento_conta ?>').on('keyup', function() {
    calcValorReceberEdit(<?= $contas_receber->cod_movimento_conta ?>);
});

<?php } ?>

function calcValorReceberEdit(cod_movimento_conta) {

    var chkConfirm = document.getElementById("inputConfirmarEdit" + cod_movimento_conta);
    if (chkConfirm.checked == true) {

        var valorTitulo = parseFloat(jQuery('#inputValorTitulo' + cod_movimento_conta).val() != '' ? (jQuery(
            '#inputValorTitulo' + cod_movimento_conta).val().split('.').join('')).replace(',', '.') : 0);
        var descTaxas = parseFloat(jQuery('#inputValorDescontoTaxas' + cod_movimento_conta).val() != '' ? (jQuery(
            '#inputValorDescontoTaxas' + cod_movimento_conta).val().split('.').join('')).replace(',', '.') : 0);
        var multJuros = parseFloat(jQuery('#inputValorMultasJustos' + cod_movimento_conta).val() != '' ? (jQuery(
            '#inputValorMultasJustos' + cod_movimento_conta).val().split('.').join('')).replace(',', '.') : 0);

        var totalPagar = valorTitulo - descTaxas + multJuros;

        $('#inputValorReceber' + cod_movimento_conta).val(totalPagar.toLocaleString("pt-BR", {
            style: "decimal",
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));

    }
}

$("#inputParcelas").change(function() {

    var quantParcela = $('#inputParcelas').val();

    if (quantParcela > 1) {
        var chkConfirm = document.getElementById("inputConfirmar");
        chkConfirm.checked = false;
        chkConfirm.disabled = true;
        $("#dataConfirmacao").hide(300);
        $("#inputDataConfirmacao").val("");
    } else {
        var chkConfirm = document.getElementById("inputConfirmar");
        chkConfirm.disabled = false;
    }

    var dataParcela = new Date(String($('#inputDataVencimento1').val().split('/').reverse().join('-')));

    var valorTotal = parseFloat(jQuery('#inputValorTitulo').val() != '' ? (jQuery('#inputValorTitulo').val()
        .split('.').join('')).replace(',', '.') : 0);
    var acumulado = 0;

    $("#pacela-table").empty();

    for (var i = 1; i <= quantParcela; i++) {

        valorParcela = round((valorTotal / quantParcela), 2);
        acumulado = acumulado + valorParcela;

        if (i == quantParcela && acumulado != valorTotal) {
            valorParcela = valorParcela + (valorTotal - acumulado);
        }

        var newRow = $("<tr>");
        var cols = "";

        // Número da parcela
        cols += '<td class="text-center">' + i + '/' + quantParcela + '</td>';

        if (i > 1) {
            var currentDay = dataParcela.getDate();
            var currentMonth = dataParcela.getMonth();
            dataParcela.setMonth(currentMonth + 1, currentDay);
        }


        //Data de vencimento previsto
        cols += '<td>';
        cols += '<input type="text" class="form-control text-center" id="inputDataVencimento' + i + '"';
        cols += 'name="DataVencimento[' + i + ']"';
        cols += 'value="' + dataParcela.toLocaleDateString('pt-BR', {
            timeZone: 'UTC'
        }) + '">';
        cols += '</td>';

        // Valor da parcela
        cols += '<td>';
        cols += '<div class="input-group">';
        cols += '<div class="input-group-prepend">';
        cols += '<span class="input-group-text">R$</span>';
        cols += '</div>';
        cols += '<input class="form-control text-center" id="inputValorParcela' + i + '" name="ValorParcela[' +
            i + ']" type="text" ';
        cols += 'data-mask="#.##0,00" data-mask-reverse="true"';
        cols += 'value="' + valorParcela.toLocaleString("pt-BR", {
            style: "decimal",
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        cols += '">';
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

jQuery('#inputValorTitulo').on('keyup', function() {

    var quantParcela = $('#inputParcelas').val();

    var valorTotal = parseFloat(jQuery('#inputValorTitulo').val() != '' ? (jQuery('#inputValorTitulo').val()
        .split('.').join('')).replace(',', '.') : 0);
    var acumulado = 0;

    for (var i = 1; i <= quantParcela; i++) {

        valorParcela = round((valorTotal / quantParcela), 2);
        acumulado = acumulado + valorParcela;

        if (i == quantParcela && acumulado != valorTotal) {
            valorParcela = valorParcela + (valorTotal - acumulado);
        }

        $('#inputValorParcela' + i).val(valorParcela.toLocaleString("pt-BR", {
            style: "decimal",
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));

    }

});
</script>

<?php $this->load->view('gerais/footer'); ?>