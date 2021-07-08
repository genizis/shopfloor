<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active">Frente de Caixa</li>
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
                                        <a href="<?= base_url("vendas/frente-caixa/{$diaAnterior}") ?>"
                                            class="btn btn-secondary"><i class="fas fa-angle-left"></i></a>
                                    </div>
                                    <input type="text" class="form-control search text-center"
                                        value="<?= str_replace('-', '/', date("d-m-Y", strtotime($dia))) ?>" readonly>
                                    <div class="input-group-append">
                                        <a href="<?= base_url("vendas/frente-caixa/{$diaSeguinte}") ?>"
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
                                    <tbody>
                                        <tr>
                                            <td>Saldo Inicial</td>
                                            <td class="text-right text-teal">R$
                                                <?php 
                                                    if($frente_caixa == true)
                                                        echo number_format($frente_caixa->saldo_inicial, 2, ',', '.');
                                                    else
                                                        echo number_format(0, 2, ',', '.');
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Recolhimento</td>
                                            <td class="text-right text-danger">R$
                                                <?php 
                                                    if($frente_caixa == true)
                                                        echo number_format($frente_caixa->total_recolhimento, 2, ',', '.');
                                                    else
                                                        echo number_format(0, 2, ',', '.');
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Incremento</td>
                                            <td class="text-right text-teal">R$
                                                <?php 
                                                    if($frente_caixa == true)
                                                        echo number_format($frente_caixa->total_incremento, 2, ',', '.');
                                                    else
                                                        echo number_format(0, 2, ',', '.');
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Total em Vendas</td>
                                            <td class="text-right text-teal">R$
                                                <?php 
                                                    if($frente_caixa == true)
                                                        echo number_format($frente_caixa->total_venda, 2, ',', '.');
                                                    else
                                                        echo number_format(0, 2, ',', '.');
                                                ?>
                                            </td>
                                        </tr>
                                        <tr class="border-top">
                                            <td><strong>SALDO FINAL</strong></td>
                                            <td class="text-right <?php 
                                                                    if($frente_caixa == true){
                                                                        if($frente_caixa->saldo_inicial + $frente_caixa->total_venda + $frente_caixa->total_incremento - $frente_caixa->total_recolhimento > 0)
                                                                            echo "text-teal";
                                                                        elseif($frente_caixa->saldo_inicial + $frente_caixa->total_venda + $frente_caixa->total_incremento - $frente_caixa->total_recolhimento == 0)
                                                                            echo "text-dark";
                                                                        else
                                                                            echo "text-danger";
                                                                    } ?>">
                                                <strong>R$
                                                    <?php 
                                                    if($frente_caixa <> null)
                                                        echo number_format($frente_caixa->saldo_inicial + $frente_caixa->total_venda + $frente_caixa->total_incremento - $frente_caixa->total_recolhimento, 2, ',', '.');
                                                    else
                                                        echo number_format(0, 2, ',', '.');
                                                ?>
                                                </strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <?php if($frente_caixa == false ){?>
                                <button data-toggle="modal" data-target="#abrir-caixa" type="button"
                                    class="btn btn-primary btn-block"><i class="fas fa-cash-register"></i>
                                    Abrir Caixa
                                </button>
                                <?php }elseif($frente_caixa->data_hora_fechamento == null){?>
                                <button data-toggle="modal" data-target="#fechar-caixa" type="button"
                                    class="btn btn-teal btn-block"
                                    <?php if($frente_caixa->saldo_inicial + $frente_caixa->total_venda + $frente_caixa->total_incremento - $frente_caixa->total_recolhimento < 0) echo "disabled"; ?>><i
                                        class="fas fa-cash-register"></i>
                                    Fechar Caixa
                                </button>
                                <?php }elseif($frente_caixa->data_hora_fechamento != null){?>
                                <button data-toggle="modal" data-target="#reabrir-caixa" type="button"
                                    class="btn btn-warning btn-block"><i class="fas fa-cash-register"></i>
                                    Reabrir Caixa
                                </button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card  mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div lass="row">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#venda">Venda de
                                                Caixa</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#incremento">Incremento /
                                                Recolhimento</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="venda">
                                        <div class="row  button-pane">
                                            <div class="col-md-12">
                                                <a href="<?php echo base_url("vendas/frente-caixa/{$dia}/nova-venda-caixa") ?>"
                                                    type="button"
                                                    class="btn btn-info btn-sm <?php if($frente_caixa == false || $frente_caixa->data_hora_fechamento != null) echo "disabled"; ?>"><i
                                                        class="fas fa-plus-circle"></i> Nova
                                                    Venda</a>
                                                <button data-toggle="modal" data-target="#estorna-venda" type="button"
                                                    class="btn btn-danger btn-sm" id="btnEstornarVenda" disabled><i
                                                        class="fas fa-undo"></i>
                                                    Estornar</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php if ($this->session->flashdata('erro') <> ""){ ?>
                                                <div class="alert alert-danger alert-dismissible fade show mt-2 mb-0"
                                                    id="alert" role="alert">
                                                    <button type="button" class="close"
                                                        data-dismiss="alert">&times;</button>
                                                    <strong>Atenção!</strong> <?= $this->session->flashdata('erro') ?>
                                                </div>
                                                <?php } $this->session->set_flashdata('erro', ''); ?>
                                                <?php if ($this->session->flashdata('sucesso') <> ""){ ?>
                                                <div class="alert alert-success alert-dismissible fade show mt-2 mb-0"
                                                    id="alert" role="alert">
                                                    <button type="button" class="close"
                                                        data-dismiss="alert">&times;</button>
                                                    <strong>Muito bem!</strong>
                                                    <?= $this->session->flashdata('sucesso') ?>
                                                </div>
                                                <?php } $this->session->set_flashdata('sucesso', ''); ?>
                                                <form
                                                    action="<?= base_url("vendas/frente-caixa/estorno-venda/{$dia}") ?>"
                                                    method="POST" id="formEstornaVendas" class="mb-0 needs-validation" novalidate>
                                                    <table class="table table-hover table-bordered">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th scope="col" class="text-center">#</th>
                                                                <th scope="col" class="text-center">Venda</th>
                                                                <th scope="col">Cliente</th>
                                                                <th scope="col" class="text-center">Valor da Venda</th>
                                                                <th scope="col" class="text-center">Receb em Dinheiro
                                                                </th>
                                                                <th scope="col" class="text-center">Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach($venda_caixa as $key_venda_caixa => $venda) { ?>
                                                            <tr>
                                                                <td>
                                                                    <div class="checkbox text-center">
                                                                        <input name="selecionar_vendas[]"
                                                                            type="checkbox"
                                                                            <?php if($frente_caixa->data_hora_fechamento != null) echo "disabled"; ?>
                                                                            value="<?= $venda->num_venda_caixa ?>"
                                                                            <?php if($venda->status == 3) echo "disabled"; ?> />
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    <a
                                                                        href="<?= base_url("vendas/frente-caixa/editar-venda-caixa/{$venda->num_venda_caixa}") ?>"><?= $venda->num_venda_caixa ?></a>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                if($venda->cod_cliente <> 0)
                                                                    echo $venda->cod_cliente . " - " . $venda->nome_cliente;
                                                                else
                                                                    echo "Consumidor Final";
                                                            ?>
                                                                </td>
                                                                <td class="text-center" id="ValorTitulo">
                                                                    R$
                                                                    <?= number_format($venda->valor_total_pedido, 2, ',', '.') ?>
                                                                </td>
                                                                <td class="text-center text-teal" id="ValorTitulo">
                                                                    R$
                                                                    <?= number_format($venda->valor_dinheiro_pedido, 2, ',', '.') ?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?php if($venda->status == 1){ ?>
                                                                    <span class='badge badge-primary'>Venda Salva</span>
                                                                    <?php } ?>
                                                                    <?php if($venda->status == 2){ ?>
                                                                    <span class='badge badge-teal'>Venda
                                                                        Efetivada</span>
                                                                    <?php } ?>
                                                                    <?php if($venda->status == 3){ ?>
                                                                    <span class='badge badge-dark'>Estornado</span>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                    <?php if($venda_caixa == false) { ?>
                                                    <div class="text-center">
                                                        <p class="text-muted mb-0">Nenhum venda realizada</p>
                                                    </div>
                                                    <?php } ?>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="incremento">
                                        <div class="row  button-pane">
                                            <div class="col-md-12">
                                                <button data-toggle="modal" data-target="#inserir-movimento"
                                                    type="button" class="btn btn-info btn-sm" id="btnInserirMovimento"
                                                    <?php if($frente_caixa == false || $frente_caixa->data_hora_fechamento != null) echo "disabled"; ?>><i
                                                        class="fas fa-plus-circle"></i> Inserir Movimento</button>
                                                <button data-toggle="modal" data-target="#delete-movimento"
                                                    type="button" class="btn btn-danger btn-sm" id="btnExcluirMovimento"
                                                    disabled><i class="fas fa-trash-alt"></i> Excluir</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php if ($this->session->flashdata('erro') <> ""){ ?>
                                                <div class="alert alert-danger alert-dismissible fade show mt-2 mb-0"
                                                    id="alert" role="alert">
                                                    <button type="button" class="close"
                                                        data-dismiss="alert">&times;</button>
                                                    <strong>Atenção!</strong> <?= $this->session->flashdata('erro') ?>
                                                </div>
                                                <?php } $this->session->set_flashdata('erro', ''); ?>
                                                <?php if ($this->session->flashdata('sucesso') <> ""){ ?>
                                                <div class="alert alert-success alert-dismissible fade show mt-2 mb-0"
                                                    id="alert" role="alert">
                                                    <button type="button" class="close"
                                                        data-dismiss="alert">&times;</button>
                                                    <strong>Muito bem!</strong>
                                                    <?= $this->session->flashdata('sucesso') ?>
                                                </div>
                                                <?php } $this->session->set_flashdata('sucesso', ''); ?>
                                                <form
                                                    action="<?= base_url("vendas/frente-caixa/excluir-movimento/{$dia}") ?>"
                                                    method="POST" id="formDeleteMovimentos" class="mb-0 needs-validation" novalidate>
                                                    <table class="table table-hover table-bordered">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th scope="col" class="text-center">#</th>
                                                                <th scope="col" class="text-center">Cod Movimento</th>
                                                                <th scope="col" class="text-center">Tipo Movimento</th>
                                                                <th scope="col" class="text-center">Valor Movimento</th>
                                                                <th scope="col">Observação</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach($movimento_caixa as $key_movimento_caixa => $movimento) { ?>
                                                            <tr>
                                                                <td>
                                                                    <div class="checkbox text-center">
                                                                        <input name="selecionar_movimentos[]"
                                                                            type="checkbox"
                                                                            <?php if($frente_caixa->data_hora_fechamento <> null) echo "disabled"; ?>
                                                                            value="<?= $movimento->cod_movimento_frente_caixa ?>" />
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?= $movimento->cod_movimento_frente_caixa ?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?php 
                                                                if($movimento->tipo_movimento == 1)
                                                                    echo "Incremento";
                                                                else
                                                                    echo "Recolhimento";
                                                                ?>
                                                                </td>
                                                                <td class="text-center <?php if($movimento->tipo_movimento == 1) echo "text-teal"; else echo "text-danger"; ?>"
                                                                    id="ValorTitulo">
                                                                    R$
                                                                    <?= number_format($movimento->valor_movimento, 2, ',', '.') ?>
                                                                </td>
                                                                <td>
                                                                    <?= $movimento->observacao ?>
                                                                </td>
                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                    <?php if($movimento_caixa == false) { ?>
                                                    <div class="text-center">
                                                        <p class="text-muted mb-0">Nenhum movimento realizado</p>
                                                    </div>
                                                    <?php } ?>
                                                </form>
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

<div class="modal fade" id="abrir-caixa" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Abrir Caixa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url("vendas/abrir-caixa/{$dia}") ?>" method='post' class="mb-0 needs-validation" novalidate
                    id="AbrirCaixa">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="control-label" for="inputValorUnitario">Saldo Inicial do Caixa <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">R$</span>
                                </div>
                                <input type="text" class="form-control" class="form-control" id="inputValorUnitario"
                                    type="text" name="SaldoInicial" data-mask="#.##0,00" data-mask-reverse="true"
                                    value="<?= set_value('SaldoInicial'); ?>">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="AbrirCaixa">Confirma</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="inserir-movimento" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Inserir Movimento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url("vendas/inserir-movimento/{$dia}") ?>" method='post' class="mb-0 needs-validation" novalidate
                    id="InserirMovimento">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="control-label">Tipo de Movimento</label>
                            <select id="inputAmbiente" class="selectpicker show-tick form-control"
                                data-actions-box="true" name="TipoMovimento" data-style="btn-input-primary">
                                <option value="1">
                                    Incremento
                                </option>
                                <option value="2">
                                    Recolhimento
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="control-label" for="inputValorMovimento">Valor Movimento <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">R$</span>
                                </div>
                                <input type="text" class="form-control" class="form-control" id="inputValorMovimento"
                                    type="text" name="ValorMovimento" data-mask="#.##0,00" data-mask-reverse="true"
                                    value="<?= set_value('ValorMovimento'); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputObservacao">Observações</label>
                            <textarea class="form-control" rows="3"
                                name="ObsMovimento"><?= set_value('ObsMovimento'); ?></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="InserirMovimento">Confirma</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="estorna-venda" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Estornar Vendas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirma estorno da(s) venda(s) selecionada(s)?
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="Acao" value="Confirmar"
                    form="formEstornaVendas">Confirma</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete-movimento" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Movimentos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirma eliminação do(s) movimento(s) selecionado(s)?
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="Acao" value="Confirmar"
                    form="formDeleteMovimentos">Confirma</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="reabrir-caixa" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reabrir Caixa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url("vendas/reabrir-caixa/{$dia}") ?>" method='post' class="mb-0 needs-validation" novalidate
                    id="ReabrirCaixa">
                    Confirma reabertura do caixa?
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="Acao" value="Confirmar"
                    form="ReabrirCaixa">Confirma</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="fechar-caixa" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Fechar Caixa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url("vendas/fechar-caixa/{$dia}") ?>" method='post' class="mb-0 needs-validation" novalidate
                    id="fechaCaixa">
                    <table class="table table-bordered table-hover  table-striped table-reporte">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Forma de Pagamento</th>
                                <th scope="col" class="text-center">Data de Vencimento</th>
                                <th scope="col" class="text-center">Total Vendido</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($recebeimento_metodo as $key_recebeimento_metodo => $recebimento) { ?>
                            <tr>
                                <td><?= $recebimento->cod_metodo_pagamento ?> -
                                    <?= $recebimento->nome_metodo_pagamento ?></td>
                                <?php if($recebimento->dias_recebimento <> 0) { ?>
                                <td class="text-center">
                                    <?= str_replace('-', '/', date("d-m-Y", strtotime('+' . $recebimento->dias_recebimento . ' day', strtotime($recebimento->data_caixa)))) ?>
                                </td>
                                <?php }else{ ?>
                                <td class="text-center">
                                    <?= str_replace('-', '/', date("d-m-Y", strtotime($recebimento->data_caixa))) ?>
                                </td>
                                <?php } ?>
                                <td class="text-center text-teal">R$
                                    <?= number_format($recebimento->total_venda, 2, ',', '.') ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php if($recebeimento_metodo == false) { ?>
                    <div class="text-center">
                        <p class="text-muted mb-0">Nenhuma venda realizada</p>
                    </div>
                    <?php } ?>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-warning" name="Acao" value="Confirmar"
                    form="fechaCaixa">Confirma</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
$('.page-item>a').addClass("page-link");

$("[name='selecionar_vendas[]']").click(function() {
    var cont = $("[name='selecionar_vendas[]']:checked").length;
    $("#btnEstornarVenda").prop("disabled", cont ? false : true);
});

$("[name='selecionar_movimentos[]']").click(function() {
    var cont = $("[name='selecionar_movimentos[]']:checked").length;
    $("#btnExcluirMovimento").prop("disabled", cont ? false : true);
});

$(function() {
    $.applyDataMask();
});
</script>

<?php $this->load->view('gerais/footer'); ?>