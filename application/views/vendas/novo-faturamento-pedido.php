<?php $this->load->view('gerais/header', $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active"><a href="<?php echo base_url() ?>vendas/faturamento-pedido">Faturamento
                    de Pedido</a></li>
            <li class="breadcrumb-item active">Novo Faturamento de Pedido</li>
        </ol>
    </div>
</section>


<section>
    <div class="container" id="app">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12">
                <div class="card  mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-xs-12">
                                <?php if ($this->session->flashdata('erro') <> "") { ?>
                                    <div class="alert alert-danger alert-dismissible fade show" id="alert" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong>Atenção!</strong> <?= $this->session->flashdata('erro') ?>
                                    </div>
                                <?php }
                                $this->session->set_flashdata('erro', ''); ?>
                                <?php if ($this->session->flashdata('sucesso') <> "") { ?>
                                    <div class="alert alert-success alert-dismissible fade show" id="alert" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong>Muito bem!</strong>
                                        <?= $this->session->flashdata('sucesso') ?>
                                    </div>
                                <?php }
                                $this->session->set_flashdata('sucesso', ''); ?>
                                <div class="form-row">
                                    <div class="form-group col-md-2">
                                        <label for="inputPedido">Número do Pedido</label>
                                        <input type="text" class="form-control" id="inputPedido" value="<?= $pedido->num_pedido_venda ?>" readonly>
                                    </div>
                                    <div class="form-group col-md-7">
                                        <label for="inputCliente">Cliente</label>
                                        <input type="text" class="form-control" id="inputCliente" value="<?= $pedido->cod_cliente ?> - <?= $pedido->nome_cliente ?>" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label" for="inputDataEmissao">Data de Emissão</label>
                                        <input class="form-control" id="inputDataEmissao" type="text" value="<?= str_replace('-', '/', date("d-m-Y", strtotime($pedido->data_emissao))) ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label class="control-label" for="inputDataEntrega">Data de Entrega</label>
                                        <input class="form-control" id="inputDataEntrega" type="text" value="<?= str_replace('-', '/', date("d-m-Y", strtotime($pedido->data_entrega))) ?>" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label" for="inputValorPedido">Valor do Pedido</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">R$</span>
                                            </div>
                                            <input type="text" class="form-control" id="inputValorPedido" type="text" name="TotalPedidoVenda" data-mask="#.##0,00" data-mask-reverse="true" value="<?= number_format($pedido->valor_pedido, 2, ',', '.') ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label" for="inputDesconto">Desconto</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <?php
                                                    if ($pedido->tipo_desconto == 1) {
                                                        echo "R$";
                                                    } elseif ($pedido->tipo_desconto == 2) {
                                                        echo "%";
                                                    }
                                                    ?>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="inputDesconto" type="text" name="ValorDesconto" data-mask="#.##0,00" data-mask-reverse="true" value="<?= number_format($pedido->valor_desconto, 2, ',', '.') ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label" for="inputFrete">Frete</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <?php
                                                    if ($pedido->tipo_frete == 1) {
                                                        echo "CIF R$";
                                                    } elseif ($pedido->tipo_frete == 2) {
                                                        echo "FOB R$";
                                                    }
                                                    ?>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="inputFrete" type="text" name="inputFrete" data-mask="#.##0,00" data-mask-reverse="true" value="<?= number_format($pedido->valor_frete, 2, ',', '.') ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="inputObservacao">Observações do Pedido</label>
                                        <textarea class="form-control" rows="3" id="inputObservacao" readonly><?= $pedido->observacoes ?></textarea>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div lass="row">
                                            <ul class="nav nav-tabs">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#faturamento">Faturamentos do Pedido</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#produto">Produtos do
                                                        Pedido</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane fade active show" id="faturamento">
                                                <div class="row  button-pane">
                                                    <div class="col-md-12">
                                                        <button data-toggle="modal" data-target="#inserir-faturamento" type="button" class="btn btn-outline-primary btn-sm" <?php if ($lista_produto == false) echo "disabled"; ?>><i class="fas fa-plus-circle"></i> Inserir
                                                            Faturamento</button>
                                                        <button data-toggle="modal" data-target="#estorna-faturamento" type="button" class="btn btn-outline-danger btn-sm" id="btnEstorno" disabled><i class="fas fa-undo"></i>
                                                            Estornar Faturamento</button>
                                                        <button data-toggle="modal" data-target="#produto-faturado" type="button" class="btn btn-outline-secondary btn-sm"><i class="fas fa-list"></i> Produtos Faturados</button>
                                                    </div>
                                                </div>
                                                <form class="mb-0 needs-validation" novalidate action="<?= base_url("vendas/faturamento-pedido/estornar-faturamento-pedido/{$pedido->num_pedido_venda}") ?>" method="POST" id="EstornaSaida">
                                                    <table class="table table-bordered table-hover table-nf">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th scope="col" class="text-center">#</th>
                                                                <th scope="col" class="text-center">Faturamento</th>
                                                                <th scope="col" class="text-center">Data de Faturamento
                                                                </th>
                                                                <th scope="col" class="text-center">Serie</th>
                                                                <th scope="col" class="text-center">Nota Fiscal</th>
                                                                <th scope="col" class="text-center">Total Bruto</th>
                                                                <th scope="col" class="text-center">Valor Frete</th>
                                                                <th scope="col" class="text-center">Valor Desconto</th>
                                                                <th scope="col" class="text-center">Total Líquido</th>
                                                                <th scope="col" class="text-center">Status NF</th>
                                                                <th scope="col" class="text-center">#</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $totalBruto = 0;
                                                            $totalDesconto = 0;
                                                            $totalLiquido = 0;

                                                            foreach ($lista_faturamento as $key_faturamento => $faturamento) {
                                                                $totalBruto = $totalBruto + $faturamento->valor_total;
                                                                $totalDesconto = $totalDesconto + $faturamento->valor_desconto;
                                                                $totalLiquido = $totalLiquido + ($faturamento->valor_total - $faturamento->valor_desconto);
                                                                if ($pedido->tipo_frete == 1) $totalLiquido = $totalLiquido + $pedido->valor_frete; ?>
                                                                <tr>
                                                                    <td>
                                                                        <div class="checkbox text-center">
                                                                            <input name="estornar_todos[]" type="checkbox" value="<?= $faturamento->cod_faturamento_pedido ?>" />
                                                                        </div>
                                                                    </td>
                                                                    <td scope="row" class="text-center">
                                                                        <a href="#" data-toggle="modal" data-target="#produto-faturado<?= $faturamento->cod_faturamento_pedido ?>">
                                                                            <?= $faturamento->cod_faturamento_pedido ?>
                                                                        </a>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <?= str_replace('-', '/', date("d-m-Y", strtotime($faturamento->data_faturamento))) ?>
                                                                    </td>
                                                                    <td class="text-center"><?= $faturamento->serie ?></td>
                                                                    <td class="text-center"><?= $faturamento->nota_fiscal ?>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        R$
                                                                        <?= number_format($faturamento->valor_total, 2, ',', '.') ?>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        R$
                                                                        <?= number_format($faturamento->valor_frete, 2, ',', '.') ?>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        R$
                                                                        <?= number_format($faturamento->valor_desconto, 2, ',', '.') ?>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        R$
                                                                        <?= number_format($faturamento->valor_total + $faturamento->valor_frete - $faturamento->valor_desconto, 2, ',', '.') ?>
                                                                    </td>
                                                                    <td class="text-center text-muted">

                                                                        <?php
                                                                        if ($faturamento->notaFiscal == 0) {
                                                                            echo ' <span class="badge badge-secondary">
                                                                                NF Não
                                                                                Emitida</span>';
                                                                        } else {
                                                                            echo ' <span class="badge badge-success">
                                                                            NF Emitida</span>';
                                                                        }
                                                                        ?>

                                                                    </td>
                                                                    <td class="text-center">
                                                                        <?php if ($faturamento->notaFiscal != 0) : ?>
                                                                            <nota-fiscal-bottom :titulo="'Nota Fiscal de Venda'" :texto="'Exibir NF'" :tipo="'faturamento'" :idfaturamento="'<?= $faturamento->cod_faturamento_pedido ?>'" :class="'btn btn-secondary btn-sm'" />
                                                                            <?php else : ?>
                                                                            <nota-fiscal-bottom :titulo="'Emitir Nota Fiscal de Venda'" :texto="'Emitir NF'" :tipo="'faturamento'" :idfaturamento="'<?= $faturamento->cod_faturamento_pedido ?>'" :class="'btn btn-outline-teal btn-sm'" />
                                                                        
                                                                        <?php endif ?>

                                                                    </td>
                                                                    <td class="hidden">
                                                                        <a href="#" data-toggle="modal" data-target="#emitir-nf<?= $faturamento->cod_faturamento_pedido ?>" type="button" class="btn btn-outline-teal btn-sm">
                                                                            Emitir NasF</a>

                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                    <?php if ($lista_faturamento == false) { ?>
                                                        <div class="text-center">
                                                            <p>Nenhum faturamento realizado</p>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="row">
                                                            <div class="col-md-8"></div>
                                                            <div class="col-md-4">
                                                                <table class="table table-bordered">
                                                                    <tbody>
                                                                        <tr>
                                                                            <th class="table-light">Faturado Bruto</th>
                                                                            <td class="text-right"><strong>R$
                                                                                    <?= number_format($totalBruto, 2, ',', '.') ?></strong>
                                                                            </td>
                                                                        </tr>
                                                                        <?php if ($pedido->tipo_frete == 1 && $pedido->valor_frete > 0) { ?>
                                                                            <tr>
                                                                                <th class="table-light">Total Frete</th>
                                                                                <td class="text-right"><strong>R$ <?= number_format($pedido->valor_frete, 2, ',', '.') ?></strong></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                        <tr>
                                                                            <th class="table-light">Total Desconto</th>
                                                                            <td class="text-right" id="inputTotalDesconto">
                                                                                R$
                                                                                <?= number_format($totalDesconto, 2, ',', '.'); ?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr class="">
                                                                            <th class="table-light"><strong>Faturado
                                                                                    Líquido</strong></th>
                                                                            <td class="text-right text-teal"><strong id="inputFaturadoLiq">
                                                                                    R$
                                                                                    <?= number_format($totalLiquido, 2, ',', '.'); ?>
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
                                                            <th scope="col">Produto de Venda</th>
                                                            <th scope="col">Tipo do Produto</th>
                                                            <th scope="col" class="text-center">Un</th>
                                                            <th scope="col" class="text-center">Quant Pedida</th>
                                                            <th scope="col" class="text-center">Quant Atendida</th>
                                                            <th scope="col" class="text-center">Total da Venda</th>
                                                            <th scope="col" class="text-center">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($lista_produto as $key_produto_venda => $produto_venda) { ?>
                                                            <tr>
                                                                <td><?= $produto_venda->cod_produto ?> -
                                                                    <?= $produto_venda->nome_produto ?></td>
                                                                <td><?= $produto_venda->nome_tipo_produto ?></td>
                                                                <td class="text-center">
                                                                    <?= $produto_venda->cod_unidade_medida ?></td>
                                                                <td class="text-center">
                                                                    <?= number_format($produto_venda->quant_pedida, 3, ',', '.') ?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?= number_format($produto_venda->quant_atendida, 3, ',', '.') ?>
                                                                </td>
                                                                <td class="text-center">R$
                                                                    <?= number_format($produto_venda->valor_unitario * $produto_venda->quant_pedida, 2, ',', '.') ?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?php
                                                                    if ($pedido->data_entrega < date('Y-m-d') && $produto_venda->status != 3 && $produto_venda->status != 4) {
                                                                        echo "<span class='badge badge-danger'>Atrasado</span>";
                                                                    } else {
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
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                <?php if ($lista_produto == false) { ?>
                                                    <div class="text-center">
                                                        <p>Nenhum produto cadastrado</p>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row float-right">
                                    <div class="col-lg-12 col-md-12 col-xs-12">
                                        <a href="<?php echo base_url() ?>vendas/atendimento-pedido" type="button" class="btn btn-secondary">Fechar</a>
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

<div class="modal fade" id="estorna-faturamento" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Estornar Faturamento do Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirma o estorno do(s) faturamento(s) selecionada(s)?
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="EstornaSaida">Confirma</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="inserir-faturamento">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Faturar Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="mb-0 needs-validation" novalidate action="<?= base_url("vendas/faturamento-pedido/inserir-faturamento/{$pedido->num_pedido_venda}/{$pedido->cod_cliente}") ?>" method="POST" id="InserirFaturamento">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label class="control-label" for="inputDataFaturamento">Data do Faturamento <span class="text-danger">*</span></label>
                                    <input class="form-control" id="inputDataFaturamento" type="text" name="DataFaturamento" value="<?php if (set_value('DataFaturamento') == "") {
                                                                                                                                        echo str_replace('-', '/', date("d-m-Y"));
                                                                                                                                    } else {
                                                                                                                                        echo set_value('DataFaturamento');
                                                                                                                                    } ?>" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="inputSerie">Serie</label>
                                    <input class="form-control" id="inputSerie" type="text" name="Serie" value="<?= set_value('Serie'); ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="inputNotaFiscal">Nota Fiscal</label>
                                    <input class="form-control" id="inputNotaFiscal" type="text" name="NotaFiscal" value="<?= set_value('NotaFiscal'); ?>">
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
                                        <th class="text-center">Total Frete</th>
                                        <th class="text-center">Total Desconto</th>
                                        <th class="text-center">Total Líquido</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($pedido->tipo_frete == 1) $valorFrete = $pedido->valor_frete;
                                    else $valorFrete = 0;

                                    if ($lista_produto != false) {
                                        $valorPendente = 0;
                                        if ($pedido->valor_pendente > 0) {
                                            $valorPendente = $pedido->valor_pendente;
                                        } else {
                                            $valorPendente = $pedido->valor_pedido;
                                        }
                                    ?>
                                        <tr>
                                            <td class="text-center" id="inputValorBruto"><strong>R$
                                                    <?= number_format($valorPendente, 2, ',', '.') ?></strong>
                                                <input class="form-control text-center" id="inputBruto" name="ValorBruto" type="hidden" data-mask="#.##0,00" data-mask-reverse="true" value="<?= number_format($valorPendente, 2, ',', '.') ?>">
                                            </td>
                                            <td class="text-center">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">R$</span>
                                                    </div>
                                                    <input class="form-control text-center" id="inputValorFrete" name="ValorFrete" type="text" data-mask="#.##0,00" data-mask-reverse="true" value="<?= number_format($valorFrete, 2, ',', '.') ?>">
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">R$</span>
                                                    </div>
                                                    <input class="form-control text-center" id="inputValorDesconto" name="ValorDesconto" type="text" data-mask="#.##0,00" data-mask-reverse="true" value="<?php if ($pedido->valor_desconto != 0) {
                                                                                                                                                                                                                if ($pedido->tipo_desconto == 1) {
                                                                                                                                                                                                                    echo number_format($pedido->valor_desconto, 2, ',', '.');
                                                                                                                                                                                                                } elseif ($pedido->tipo_desconto == 2) {
                                                                                                                                                                                                                    echo number_format(($pedido->valor_pedido) * ($pedido->valor_desconto / 100), 2, ',', '.');
                                                                                                                                                                                                                }
                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                echo number_format(0, 2, ',', '.');
                                                                                                                                                                                                            }
                                                                                                                                                                                                            ?>">
                                                </div>
                                            </td>
                                            <td class="text-center text-teal"><strong id="inputValorLiq">R$
                                                    <?php if ($pedido->valor_desconto != 0) {
                                                        if ($pedido->tipo_desconto == 1) {
                                                            echo number_format(($valorPendente + $valorFrete) - $pedido->valor_desconto, 2, ',', '.');
                                                        } elseif ($pedido->tipo_desconto == 2) {
                                                            echo number_format(($valorPendente + $valorFrete) - (($valorPendente) * ($pedido->valor_desconto / 100)), 2, ',', '.');
                                                        }
                                                    } else {
                                                        echo number_format($valorPendente + $valorFrete, 2, ',', '.');
                                                    }
                                                    ?>
                                                </strong></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php if ($lista_produto == false) { ?>
                                <div class="text-center">
                                    <p>Nenhum produto de venda adicionado</p>
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
                                                <th scope="col">Produto de Venda</th>
                                                <th scope="col">Tipo do Produto</th>
                                                <th scope="col" class="text-center">Un</th>
                                                <th scope="col" class="text-center">Quant Vendida</th>
                                                <th scope="col" class="text-center">Total da Venda</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($lista_produto as $key_produto => $produto) {
                                                if (($produto->quant_pedida - $produto->quant_atendida) > 0) {
                                                    $quantSaldo = $produto->quant_pedida - $produto->quant_atendida;
                                                } else {
                                                    $quantSaldo = $produto->quant_pedida;
                                                }
                                            ?>
                                                <tr>
                                                    <td><?= $produto->cod_produto ?> - <?= $produto->nome_produto ?></td>
                                                    <td><?= $produto->nome_tipo_produto ?></td>
                                                    <td class="text-center"><?= $produto->cod_unidade_medida ?></td>
                                                    <td>
                                                        <input class="form-control text-center" id="inputQuantVendida<?= $produto->cod_produto ?>" name="quantVendida[<?= $produto->cod_produto ?>]" type="text" data-mask="#.##0,000" data-mask-reverse="true" value="<?= number_format($quantSaldo, 3, ',', '.') ?>" required>
                                                    </td>
                                                    <td class="text-center" id="inputValorVenda<?= $produto->cod_produto ?>">
                                                        R$
                                                        <?= number_format($quantSaldo * $produto->valor_unitario, 2, ',', '.') ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <?php if ($lista_produto == false) { ?>
                                        <div class="text-center">
                                            <p>Nenhum produto de venda adicionado</p>
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
                                            <select class="selectpicker show-tick form-control" data-live-search="true" data-actions-box="true" title="Selecione um Método de Pagamento" name="CodMetodoPagamento" data-style="btn-input-primary">
                                                <?php foreach ($lista_metodo_pagamento as $key_metodo_pagamento => $metodo_pagamento) { ?>
                                                    <option value="<?= $metodo_pagamento->cod_metodo_pagamento ?>" <?php if ($metodo_pagamento->cod_metodo_pagamento == set_value('CodMetodoPagamento')) echo "selected"; ?>>
                                                        <?= $metodo_pagamento->cod_metodo_pagamento ?> - <?= $metodo_pagamento->nome_metodo_pagamento ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label>Conta Financeira </label>
                                            <select class="selectpicker show-tick form-control" data-live-search="true" data-actions-box="true" title="Selecione uma Conta Financeira" name="CodConta" data-style="btn-input-primary" required>
                                                <?php foreach ($lista_conta as $key_conta => $conta) { ?>
                                                    <option value="<?= $conta->cod_conta ?>" <?php if ($conta->cod_conta == $empresa->conta_padrao) echo "selected"; ?>>
                                                        <?= $conta->cod_conta ?> - <?= $conta->nome_conta ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="inputParcelas">Parcelamento</label>
                                            <select id="inputParcelas" class="selectpicker show-tick form-control" name="Parcelas" data-style="btn-input-primary">
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
                                            <select class="selectpicker show-tick form-control" data-live-search="true" data-actions-box="true" title="Selecione um Centro de Custo" name="CodCentroCusto" data-style="btn-input-primary">
                                                <?php foreach ($lista_centro_custo as $key_centro_custo => $centro_custo) { ?>
                                                    <option value="<?= $centro_custo->cod_centro_custo ?>" <?php if ($centro_custo->cod_centro_custo == $empresa->centro_custo_vendas) echo "selected"; ?>>
                                                        <?= $centro_custo->cod_centro_custo ?> -
                                                        <?= $centro_custo->nome_centro_custo ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Conta Contábil</label>
                                            <select class="selectpicker show-tick form-control" id="inputContaContabil<?= $produto->cod_produto ?>" data-live-search="true" data-actions-box="true" title="Selecione uma Conta Contábil" name="CodContaContabil" data-style="btn-input-primary">
                                                <?php foreach ($lista_conta_contabil as $key_conta_contabil => $conta_contabil) { ?>
                                                    <option value="<?= $conta_contabil->cod_conta_contabil ?>" <?php if ($conta_contabil->cod_conta_contabil == $empresa->conta_contabil_vendas) echo "selected"; ?>>
                                                        <?= $conta_contabil->cod_conta_contabil ?> -
                                                        <?= $conta_contabil->nome_conta_contabil ?>
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
                                                    <input type="text" class="form-control text-center" id="inputDataVencimento1" name="DataVencimento[1]" value="<?php if (set_value('DataVencimento[1]') == "") {
                                                                                                                                                                        echo str_replace('-', '/', date("d-m-Y"));
                                                                                                                                                                    } else {
                                                                                                                                                                        echo set_value('DataVencimento[1]');
                                                                                                                                                                    } ?>" required>
                                                </td>
                                                <td class="text-center">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">R$</span>
                                                        </div>
                                                        <input class="form-control text-center" id="inputValorParcela1" name="ValorParcela[1]" type="text" data-mask="#.##0,00" data-mask-reverse="true" value="<?php if ($pedido->valor_desconto != 0) {
                                                                                                                                                                                                                    if ($pedido->tipo_desconto == 1) {
                                                                                                                                                                                                                        echo number_format(round(($valorPendente - $pedido->valor_desconto) + $valorFrete, 2), 2, ',', '.');
                                                                                                                                                                                                                    } elseif ($pedido->tipo_desconto == 2) {
                                                                                                                                                                                                                        echo number_format($valorPendente + $valorFrete - (round(($valorPendente) * ($pedido->valor_desconto / 100), 2)), 2, ',', '.');
                                                                                                                                                                                                                    }
                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                    echo number_format($valorPendente + $valorFrete, 2, ',', '.');
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
                                    <label for="inputObservacao">Observações do Faturamento</label>
                                    <textarea class="form-control" rows="3" id="inputObservacao	" name="ObservFatur"><?= set_value('ObservReceb'); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="InserirFaturamento"><i class="fas fa-plus-circle"></i>
                    Faturar Pedido</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="produto-faturado">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Produtos Faturados</h5>
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
                                    <th scope="col" class="text-center">Data Faturamento</th>
                                    <th scope="col" class="text-center">Faturamento</th>
                                    <th scope="col">Produto de Venda</th>
                                    <th scope="col">Tipo do Produto</th>
                                    <th scope="col" class="text-center">Un</th>
                                    <th scope="col" class="text-center">Qtde Vendida</th>
                                    <th scope="col" class="text-center">Total da Venda</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($lista_faturamento_produto as $key_faturamento_produto => $faturamento_produto) { ?>
                                    <tr>
                                        <td class="text-center">
                                            <?= str_replace('-', '/', date("d-m-Y", strtotime($faturamento_produto->data_movimento))) ?>
                                        </td>
                                        <td class="text-center">
                                            <?= $faturamento_produto->cod_faturamento_pedido ?></td>
                                        <td><?= $faturamento_produto->cod_produto ?> -
                                            <?= $faturamento_produto->nome_produto ?></td>
                                        <td><?= $faturamento_produto->nome_tipo_produto ?></td>
                                        <td class="text-center"><?= $faturamento_produto->cod_unidade_medida ?>
                                        </td>
                                        <td class="text-center">
                                            <?= number_format($faturamento_produto->quant_movimentada, 3, ',', '.') ?>
                                        </td>
                                        <td class="text-center">
                                            R$
                                            <?= number_format($faturamento_produto->valor_movimento, 2, ',', '.') ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php if ($lista_faturamento_produto == false) { ?>
                            <div class="text-center">
                                <p>Nenhum produto faturado</p>
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

<?php foreach ($lista_faturamento as $key_faturamento => $faturamento) { ?>
    <div class="modal fade" id="produto-faturado<?= $faturamento->cod_faturamento_pedido ?>">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Produtos Faturados</h5>
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
                                        <th scope="col" class="text-center">Data Faturamento</th>
                                        <th scope="col" class="text-center">Faturamento</th>
                                        <th scope="col">Produto de Venda</th>
                                        <th scope="col">Tipo do Produto</th>
                                        <th scope="col" class="text-center">Un</th>
                                        <th scope="col" class="text-center">Qtde Vendida</th>
                                        <th scope="col" class="text-center">Total da Venda</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($lista_faturamento_produto as $key_faturamento_produto => $faturamento_produto) {
                                        if ($faturamento_produto->cod_faturamento_pedido == $faturamento->cod_faturamento_pedido) { ?>
                                            <tr>
                                                <td class="text-center">
                                                    <?= str_replace('-', '/', date("d-m-Y", strtotime($faturamento_produto->data_movimento))) ?>
                                                </td>
                                                <td class="text-center">
                                                    <?= $faturamento_produto->cod_faturamento_pedido ?></td>
                                                <td><?= $faturamento_produto->cod_produto ?> -
                                                    <?= $faturamento_produto->nome_produto ?></td>
                                                <td><?= $faturamento_produto->nome_tipo_produto ?></td>
                                                <td class="text-center"><?= $faturamento_produto->cod_unidade_medida ?>
                                                </td>
                                                <td class="text-center">
                                                    <?= number_format($faturamento_produto->quant_movimentada, 3, ',', '.') ?>
                                                </td>
                                                <td class="text-center">
                                                    R$
                                                    <?= number_format($faturamento_produto->valor_movimento, 2, ',', '.') ?>
                                                </td>
                                            </tr>
                                    <?php }
                                    } ?>
                                </tbody>
                            </table>
                            <?php if ($lista_faturamento_produto == false) { ?>
                                <div class="text-center">
                                    <p>Nenhum produto faturado</p>
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
<?php } ?>

<?php foreach ($lista_faturamento as $key_faturamento => $faturamento) { ?>
    <div class="modal fade" id="emitir-nf<?= $faturamento->cod_faturamento_pedido ?>">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Emitir Nota Fiscal de Venda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="mb-0 needs-validation" novalidate action="<?= base_url("vendas/faturamento-pedido/inserir-faturamento/{$pedido->num_pedido_venda}/{$pedido->cod_cliente}") ?>" method="POST" id="InserirFaturamento">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-row">
                                    <div class="form-group col-md-7">
                                        <label for="inputCliente">Cliente</label>
                                        <input type="text" class="form-control" id="inputCliente" value="<?= $pedido->cod_cliente ?> - <?= $pedido->nome_cliente ?>" readonly>
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label for="inputCPFCNPJ">CNPJ/CPF</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" class="form-control" id="inputCPFCNPJ" name="CnpjCpf" value="<?= $cliente->cnpj_cpf ?>">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-info" type="button" id="btnConsultaCNPJ">Consultar
                                                    CNPJ</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="inputCEP">CEP</label>
                                        <input type="text" class="form-control" id="inputCEP" name="CEP" value="<?= $cliente->cep ?>" data-mask="00000-000">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputEndereco">Endereço</label>
                                        <input type="text" class="form-control" id="inputEndereco" name="Endereco" value="<?= $cliente->endereco ?>">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputNumero">Número</label>
                                        <input type="text" class="form-control" id="inputNumero" name="Numero" value="<?= $cliente->numero ?>">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="inputComplemento">Complemento</label>
                                        <input type="text" class="form-control" id="inputComplemento" name="Complemento" value="<?= $cliente->complemento ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputBairro">Bairro</label>
                                        <input type="text" class="form-control" id="inputBairro" name="Bairro" value="<?= $cliente->bairro ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputCidade">Cidade</label>
                                        <select class="form-control selectpicker show-tick" data-live-search="true" data-style="btn-input-primary" title="Selecione a Cidade" id="inputCidade" name="Cidade">
                                            <?php foreach ($lista_cidade as $key_cidade => $cidade) { ?>
                                                <option value="<?= $cidade->id ?>" <?php if ($cliente->cod_cidade == $cidade->id) echo "selected"; ?>>
                                                    <?= $cidade->nome ?> - <?= $cidade->uf ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputContribuinteICMS">Tipo de Contribuição ICMS</label>
                                        <select id="inputContribuinteICMS" name="ContribuinteICMS" data-style="btn-input-primary" class="selectpicker show-tick form-control" data-live-search="true" data-actions-box="true">
                                            <option value="9" <?php if ($cliente->tipo_contrib_icms == 9) echo "selected"; ?>>Não
                                                Contribuinte</option>
                                            <option value="1" <?php if ($cliente->tipo_contrib_icms == 1) echo "selected"; ?>>
                                                Contribuinte</option>
                                            <option value="2" <?php if ($cliente->tipo_contrib_icms == 2) echo "selected"; ?>>
                                                Contribuinte Isento</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputIE">Inscrição Estadual</label>
                                        <input type="text" class="form-control" id="inputIE" name="IE" value="<?= $cliente->insc_estadual ?>">
                                    </div>
                                </div>
                                <hr>
                                <div>
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#produtos-vendidos">Produtos
                                                da Nota</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#dados-frete">Dados de Frete</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="produtos-vendidos">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-produto-nf table-bordered table-reporte">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th class="text-center">#</th>
                                                            <th>Produto de Venda</th>
                                                            <th class="text-center">Un</th>
                                                            <th class="text-center">Qtde Vendida</th>
                                                            <th class="text-center">Total da Venda</th>
                                                            <th>NCM</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($lista_faturamento_produto as $key_faturamento_produto => $faturamento_produto) {
                                                            if ($faturamento_produto->cod_faturamento_pedido == $faturamento->cod_faturamento_pedido) { ?>
                                                                <tr colspan="6">
                                                                    <td class="text-center accordion-toggle">
                                                                        <a class="text-teal" data-toggle="collapse" data-target="#prod<?= $faturamento_produto->cod_produto ?>">
                                                                            <i class="fas fa-plus-circle"></i>
                                                                        </a>
                                                                    </td>
                                                                    <td><?= $faturamento_produto->cod_produto ?> -
                                                                        <?= $faturamento_produto->nome_produto ?></td>
                                                                    <td class="text-center">
                                                                        <?= $faturamento_produto->cod_unidade_medida ?>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <?= number_format($faturamento_produto->quant_movimentada, 3, ',', '.') ?>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        R$ <?= number_format($faturamento_produto->valor_movimento, 2, ',', '.') ?>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control text-center" id="inputTotalVenda" type="text" name="TotalVenda" value="<?= $faturamento_produto->cod_ncm ?>">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="6" class="hiddenRow">
                                                                        <div class="accordian-body collapse p-3" id="prod<?= $faturamento_produto->cod_produto ?>">
                                                                            <div class="form-row">
                                                                                <div class="form-group col-md-2">
                                                                                    <label for="inputOrigemProduto">CEST</label>
                                                                                    <input type="text" class="form-control" id="inputTotalVenda" type="text" name="TotalVenda" value="<?= $faturamento_produto->cod_cest ?>">
                                                                                </div>
                                                                                <div class="form-group col-md-5">
                                                                                    <label for="inputOrigemProduto">Origem do
                                                                                        Produto</label>
                                                                                    <select id="inputOrigemProduto" name="OrigemProduto" data-style="btn-input-primary" class="selectpicker show-tick form-control" data-live-search="true" data-actions-box="true" title="Informe a Origem do Produto">
                                                                                        <option value="0" <?php if ($faturamento_produto->cod_origem == 0) echo "selected"; ?>>
                                                                                            0 - Nacional
                                                                                        </option>
                                                                                        <option value="1" <?php if ($faturamento_produto->cod_origem == 1) echo "selected"; ?>>
                                                                                            1 - Estrangeira - Importação direta
                                                                                        </option>
                                                                                        <option value="2" <?php if ($faturamento_produto->cod_origem == 2) echo "selected"; ?>>
                                                                                            2 - Estrangeira - Adquirida no mercado
                                                                                            interno
                                                                                        </option>
                                                                                        <option value="3" <?php if ($faturamento_produto->cod_origem == 3) echo "selected"; ?>>
                                                                                            3 - Nacional, mercadoria ou bem com
                                                                                            Conteúdo de
                                                                                            Importação superior a 40%
                                                                                        </option>
                                                                                        <option value="4" <?php if ($faturamento_produto->cod_origem == 4) echo "selected"; ?>>
                                                                                            4 - Nacional, cuja produção tenha sido
                                                                                            feita em
                                                                                            conformidade com a MP 252(MP do BEM)
                                                                                        </option>
                                                                                        <option value="5" <?php if ($faturamento_produto->cod_origem == 5) echo "selected"; ?>>
                                                                                            5 - Nacional, mercadoria ou bem com
                                                                                            Conteúdo de
                                                                                            Importação inferior ou igual a 40%
                                                                                        </option>
                                                                                        <option value="6" <?php if ($faturamento_produto->cod_origem == 6) echo "selected"; ?>>
                                                                                            6 - Estrangeira - Importação direta, sem
                                                                                            similar
                                                                                            nacional, constante em lista de
                                                                                            Resolução CAMEX
                                                                                        </option>
                                                                                        <option value="7" <?php if ($faturamento_produto->cod_origem == 7) echo "selected"; ?>>
                                                                                            7 - Estrangeira - Adquirida no mercado
                                                                                            interno, sem
                                                                                            similar nacional, constante em lista de
                                                                                            Resolução
                                                                                            CAMEX
                                                                                        </option>
                                                                                        <option value="8" <?php if ($faturamento_produto->cod_origem == 8) echo "selected"; ?>>
                                                                                            8 - Nacional, mercadoria ou bem com
                                                                                            Conteúdo de
                                                                                            Importação superior a 70%
                                                                                        </option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="form-group col-md-5">
                                                                                    <label for="inputOrigemProduto">CFOP</label>
                                                                                    <select id="inputOrigemProduto" name="OrigemProduto" data-style="btn-input-primary" class="selectpicker show-tick form-control" data-live-search="true" data-actions-box="true" title="Informe a Origem do Produto">
                                                                                        <option value="0" <?php if ($faturamento_produto->cod_origem == 0) echo "selected"; ?>>
                                                                                            0 - Nacional
                                                                                        </option>
                                                                                        <option value="1" <?php if ($faturamento_produto->cod_origem == 1) echo "selected"; ?>>
                                                                                            1 - Estrangeira - Importação direta
                                                                                        </option>
                                                                                        <option value="2" <?php if ($faturamento_produto->cod_origem == 2) echo "selected"; ?>>
                                                                                            2 - Estrangeira - Adquirida no mercado
                                                                                            interno
                                                                                        </option>
                                                                                        <option value="3" <?php if ($faturamento_produto->cod_origem == 3) echo "selected"; ?>>
                                                                                            3 - Nacional, mercadoria ou bem com
                                                                                            Conteúdo de
                                                                                            Importação superior a 40%
                                                                                        </option>
                                                                                        <option value="4" <?php if ($faturamento_produto->cod_origem == 4) echo "selected"; ?>>
                                                                                            4 - Nacional, cuja produção tenha sido
                                                                                            feita em
                                                                                            conformidade com a MP 252(MP do BEM)
                                                                                        </option>
                                                                                        <option value="5" <?php if ($faturamento_produto->cod_origem == 5) echo "selected"; ?>>
                                                                                            5 - Nacional, mercadoria ou bem com
                                                                                            Conteúdo de
                                                                                            Importação inferior ou igual a 40%
                                                                                        </option>
                                                                                        <option value="6" <?php if ($faturamento_produto->cod_origem == 6) echo "selected"; ?>>
                                                                                            6 - Estrangeira - Importação direta, sem
                                                                                            similar
                                                                                            nacional, constante em lista de
                                                                                            Resolução CAMEX
                                                                                        </option>
                                                                                        <option value="7" <?php if ($faturamento_produto->cod_origem == 7) echo "selected"; ?>>
                                                                                            7 - Estrangeira - Adquirida no mercado
                                                                                            interno, sem
                                                                                            similar nacional, constante em lista de
                                                                                            Resolução
                                                                                            CAMEX
                                                                                        </option>
                                                                                        <option value="8" <?php if ($faturamento_produto->cod_origem == 8) echo "selected"; ?>>
                                                                                            8 - Nacional, mercadoria ou bem com
                                                                                            Conteúdo de
                                                                                            Importação superior a 70%
                                                                                        </option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <ul class="nav nav-tabs mt-3">
                                                                                <li class="nav-item">
                                                                                    <a class="nav-link active" data-toggle="tab" href="#icms<?= $faturamento_produto->cod_produto ?>">ICMS</a>
                                                                                </li>
                                                                                <li class="nav-item">
                                                                                    <a class="nav-link" data-toggle="tab" href="#ipi<?= $faturamento_produto->cod_produto ?>">IPI</a>
                                                                                </li>
                                                                                <li class="nav-item">
                                                                                    <a class="nav-link" data-toggle="tab" href="#pis<?= $faturamento_produto->cod_produto ?>">PIS</a>
                                                                                </li>
                                                                                <li class="nav-item">
                                                                                    <a class="nav-link" data-toggle="tab" href="#cofins<?= $faturamento_produto->cod_produto ?>">CONFINS</a>
                                                                                </li>
                                                                            </ul>
                                                                            <div class="tab-content">
                                                                                <div class="tab-pane fade active show impostos" role="tabpanel" aria-labelledby="home-tab" id="icms<?= $faturamento_produto->cod_produto ?>">
                                                                                    <div class="form-row mt-2">
                                                                                        <div class="form-group col-md-12">
                                                                                            <label for="inputOrigemProduto">Situação
                                                                                                Tributária
                                                                                                ICMS</label>
                                                                                            <select id="inputOrigemProduto" name="OrigemProduto" data-style="btn-input-primary" class="selectpicker show-tick form-control" data-live-search="true" data-actions-box="true" title="Informe a Origem do Produto">
                                                                                                <option value="0" <?php if ($faturamento_produto->cod_origem == 0) echo "selected"; ?>>
                                                                                                    0 - Nacional
                                                                                                </option>
                                                                                                <option value="1" <?php if ($faturamento_produto->cod_origem == 1) echo "selected"; ?>>
                                                                                                    1 - Estrangeira - Importação
                                                                                                    direta
                                                                                                </option>
                                                                                                <option value="2" <?php if ($faturamento_produto->cod_origem == 2) echo "selected"; ?>>
                                                                                                    2 - Estrangeira - Adquirida no
                                                                                                    mercado
                                                                                                    interno
                                                                                                </option>
                                                                                                <option value="3" <?php if ($faturamento_produto->cod_origem == 3) echo "selected"; ?>>
                                                                                                    3 - Nacional, mercadoria ou bem
                                                                                                    com Conteúdo
                                                                                                    de
                                                                                                    Importação superior a 40%
                                                                                                </option>
                                                                                                <option value="4" <?php if ($faturamento_produto->cod_origem == 4) echo "selected"; ?>>
                                                                                                    4 - Nacional, cuja produção
                                                                                                    tenha sido feita
                                                                                                    em
                                                                                                    conformidade com a MP 252(MP do
                                                                                                    BEM)
                                                                                                </option>
                                                                                                <option value="5" <?php if ($faturamento_produto->cod_origem == 5) echo "selected"; ?>>
                                                                                                    5 - Nacional, mercadoria ou bem
                                                                                                    com Conteúdo
                                                                                                    de
                                                                                                    Importação inferior ou igual a
                                                                                                    40%
                                                                                                </option>
                                                                                                <option value="6" <?php if ($faturamento_produto->cod_origem == 6) echo "selected"; ?>>
                                                                                                    6 - Estrangeira - Importação
                                                                                                    direta, sem
                                                                                                    similar
                                                                                                    nacional, constante em lista de
                                                                                                    Resolução
                                                                                                    CAMEX
                                                                                                </option>
                                                                                                <option value="7" <?php if ($faturamento_produto->cod_origem == 7) echo "selected"; ?>>
                                                                                                    7 - Estrangeira - Adquirida no
                                                                                                    mercado
                                                                                                    interno, sem
                                                                                                    similar nacional, constante em
                                                                                                    lista de
                                                                                                    Resolução
                                                                                                    CAMEX
                                                                                                </option>
                                                                                                <option value="8" <?php if ($faturamento_produto->cod_origem == 8) echo "selected"; ?>>
                                                                                                    8 - Nacional, mercadoria ou bem
                                                                                                    com Conteúdo
                                                                                                    de
                                                                                                    Importação superior a 70%
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-row">
                                                                                        <div class="form-group col-md-4">
                                                                                            <label class="" for="inputOrigemProduto">Valor
                                                                                                Base ICMS</label>
                                                                                            <div class="input-group">
                                                                                                <div class="input-group-prepend">
                                                                                                    <span class="input-group-text">R$</span>
                                                                                                </div>
                                                                                                <input type="text" class="form-control" id="inputTotalVenda" type="text" name="TotalVenda" data-mask="#.##0,00" data-mask-reverse="true" value="<?= number_format($faturamento_produto->valor_movimento, 2, ',', '.') ?>">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group col-md-4">
                                                                                            <label class="" for="inputOrigemProduto">Percentual ICMS</label>
                                                                                            <div class="input-group">
                                                                                                <input type="text" class="form-control" id="inputTotalVenda" type="text" name="TotalVenda" data-mask="#.##0,00" data-mask-reverse="true" value="<?= number_format($faturamento_produto->valor_movimento, 2, ',', '.') ?>">
                                                                                                <div class="input-group-append">
                                                                                                    <span class="input-group-text">%</span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group col-md-4">
                                                                                            <label for="inputOrigemProduto">Valor
                                                                                                ICMS</label>
                                                                                            <div class="input-group">
                                                                                                <div class="input-group-prepend mt-0">
                                                                                                    <span class="input-group-text">R$</span>
                                                                                                </div>
                                                                                                <input type="text" class="form-control" id="inputTotalVenda" type="text" name="TotalVenda" data-mask="#.##0,00" data-mask-reverse="true" value="<?= number_format($faturamento_produto->valor_movimento, 2, ',', '.') ?>">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-row">
                                                                                        <div class="form-group col-md-4">
                                                                                            <label class="" for="inputOrigemProduto">Valor
                                                                                                Base ICMS ST</label>
                                                                                            <div class="input-group">
                                                                                                <div class="input-group-prepend">
                                                                                                    <span class="input-group-text">R$</span>
                                                                                                </div>
                                                                                                <input type="text" class="form-control" id="inputTotalVenda" type="text" name="TotalVenda" data-mask="#.##0,00" data-mask-reverse="true" value="<?= number_format($faturamento_produto->valor_movimento, 2, ',', '.') ?>">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group col-md-4">
                                                                                            <label class="" for="inputOrigemProduto">Percentual ICMS ST</label>
                                                                                            <div class="input-group">
                                                                                                <input type="text" class="form-control" id="inputTotalVenda" type="text" name="TotalVenda" data-mask="#.##0,00" data-mask-reverse="true" value="<?= number_format($faturamento_produto->valor_movimento, 2, ',', '.') ?>">
                                                                                                <div class="input-group-append">
                                                                                                    <span class="input-group-text">%</span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group col-md-4">
                                                                                            <label for="inputOrigemProduto">Valor
                                                                                                ICMS ST</label>
                                                                                            <div class="input-group">
                                                                                                <div class="input-group-prepend mt-0">
                                                                                                    <span class="input-group-text">R$</span>
                                                                                                </div>
                                                                                                <input type="text" class="form-control" id="inputTotalVenda" type="text" name="TotalVenda" data-mask="#.##0,00" data-mask-reverse="true" value="<?= number_format($faturamento_produto->valor_movimento, 2, ',', '.') ?>">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="tab-pane fade impostos" role="tabpanel" aria-labelledby="home-tab" id="ipi<?= $faturamento_produto->cod_produto ?>">
                                                                                    <div class="form-row mt-2">
                                                                                        <div class="form-group col-md-12">
                                                                                            <label for="inputOrigemProduto">Situação
                                                                                                Tributária
                                                                                                IPI</label>
                                                                                            <select id="inputOrigemProduto" name="OrigemProduto" data-style="btn-input-primary" class="selectpicker show-tick form-control" data-live-search="true" data-actions-box="true" title="Informe a Origem do Produto">
                                                                                                <option value="0" <?php if ($faturamento_produto->cod_origem == 0) echo "selected"; ?>>
                                                                                                    0 - Nacional
                                                                                                </option>
                                                                                                <option value="1" <?php if ($faturamento_produto->cod_origem == 1) echo "selected"; ?>>
                                                                                                    1 - Estrangeira - Importação
                                                                                                    direta
                                                                                                </option>
                                                                                                <option value="2" <?php if ($faturamento_produto->cod_origem == 2) echo "selected"; ?>>
                                                                                                    2 - Estrangeira - Adquirida no
                                                                                                    mercado
                                                                                                    interno
                                                                                                </option>
                                                                                                <option value="3" <?php if ($faturamento_produto->cod_origem == 3) echo "selected"; ?>>
                                                                                                    3 - Nacional, mercadoria ou bem
                                                                                                    com Conteúdo
                                                                                                    de
                                                                                                    Importação superior a 40%
                                                                                                </option>
                                                                                                <option value="4" <?php if ($faturamento_produto->cod_origem == 4) echo "selected"; ?>>
                                                                                                    4 - Nacional, cuja produção
                                                                                                    tenha sido feita
                                                                                                    em
                                                                                                    conformidade com a MP 252(MP do
                                                                                                    BEM)
                                                                                                </option>
                                                                                                <option value="5" <?php if ($faturamento_produto->cod_origem == 5) echo "selected"; ?>>
                                                                                                    5 - Nacional, mercadoria ou bem
                                                                                                    com Conteúdo
                                                                                                    de
                                                                                                    Importação inferior ou igual a
                                                                                                    40%
                                                                                                </option>
                                                                                                <option value="6" <?php if ($faturamento_produto->cod_origem == 6) echo "selected"; ?>>
                                                                                                    6 - Estrangeira - Importação
                                                                                                    direta, sem
                                                                                                    similar
                                                                                                    nacional, constante em lista de
                                                                                                    Resolução
                                                                                                    CAMEX
                                                                                                </option>
                                                                                                <option value="7" <?php if ($faturamento_produto->cod_origem == 7) echo "selected"; ?>>
                                                                                                    7 - Estrangeira - Adquirida no
                                                                                                    mercado
                                                                                                    interno, sem
                                                                                                    similar nacional, constante em
                                                                                                    lista de
                                                                                                    Resolução
                                                                                                    CAMEX
                                                                                                </option>
                                                                                                <option value="8" <?php if ($faturamento_produto->cod_origem == 8) echo "selected"; ?>>
                                                                                                    8 - Nacional, mercadoria ou bem
                                                                                                    com Conteúdo
                                                                                                    de
                                                                                                    Importação superior a 70%
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-row">
                                                                                        <div class="form-group col-md-4">
                                                                                            <label class="" for="inputOrigemProduto">Valor
                                                                                                Base IPI</label>
                                                                                            <div class="input-group">
                                                                                                <div class="input-group-prepend">
                                                                                                    <span class="input-group-text">R$</span>
                                                                                                </div>
                                                                                                <input type="text" class="form-control" id="inputTotalVenda" type="text" name="TotalVenda" data-mask="#.##0,00" data-mask-reverse="true" value="<?= number_format($faturamento_produto->valor_movimento, 2, ',', '.') ?>">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group col-md-4">
                                                                                            <label class="" for="inputOrigemProduto">Percentual IPI</label>
                                                                                            <div class="input-group">
                                                                                                <input type="text" class="form-control" id="inputTotalVenda" type="text" name="TotalVenda" data-mask="#.##0,00" data-mask-reverse="true" value="<?= number_format($faturamento_produto->valor_movimento, 2, ',', '.') ?>">
                                                                                                <div class="input-group-append">
                                                                                                    <span class="input-group-text">%</span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group col-md-4">
                                                                                            <label for="inputOrigemProduto">Valor
                                                                                                IPI</label>
                                                                                            <div class="input-group">
                                                                                                <div class="input-group-prepend mt-0">
                                                                                                    <span class="input-group-text">R$</span>
                                                                                                </div>
                                                                                                <input type="text" class="form-control" id="inputTotalVenda" type="text" name="TotalVenda" data-mask="#.##0,00" data-mask-reverse="true" value="<?= number_format($faturamento_produto->valor_movimento, 2, ',', '.') ?>">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-row">
                                                                                        <div class="form-group col-md-6">
                                                                                            <label for="inputOrigemProduto">Código Enquad. IPI</label>
                                                                                            <select id="inputOrigemProduto" name="OrigemProduto" data-style="btn-input-primary" class="selectpicker show-tick form-control" data-live-search="true" data-actions-box="true" title="Informe a Origem do Produto">
                                                                                                <option value="0" <?php if ($faturamento_produto->cod_origem == 0) echo "selected"; ?>>
                                                                                                    0 - Nacional
                                                                                                </option>
                                                                                                <option value="1" <?php if ($faturamento_produto->cod_origem == 1) echo "selected"; ?>>
                                                                                                    1 - Estrangeira - Importação
                                                                                                    direta
                                                                                                </option>
                                                                                                <option value="2" <?php if ($faturamento_produto->cod_origem == 2) echo "selected"; ?>>
                                                                                                    2 - Estrangeira - Adquirida no
                                                                                                    mercado
                                                                                                    interno
                                                                                                </option>
                                                                                                <option value="3" <?php if ($faturamento_produto->cod_origem == 3) echo "selected"; ?>>
                                                                                                    3 - Nacional, mercadoria ou bem
                                                                                                    com Conteúdo
                                                                                                    de
                                                                                                    Importação superior a 40%
                                                                                                </option>
                                                                                                <option value="4" <?php if ($faturamento_produto->cod_origem == 4) echo "selected"; ?>>
                                                                                                    4 - Nacional, cuja produção
                                                                                                    tenha sido feita
                                                                                                    em
                                                                                                    conformidade com a MP 252(MP do
                                                                                                    BEM)
                                                                                                </option>
                                                                                                <option value="5" <?php if ($faturamento_produto->cod_origem == 5) echo "selected"; ?>>
                                                                                                    5 - Nacional, mercadoria ou bem
                                                                                                    com Conteúdo
                                                                                                    de
                                                                                                    Importação inferior ou igual a
                                                                                                    40%
                                                                                                </option>
                                                                                                <option value="6" <?php if ($faturamento_produto->cod_origem == 6) echo "selected"; ?>>
                                                                                                    6 - Estrangeira - Importação
                                                                                                    direta, sem
                                                                                                    similar
                                                                                                    nacional, constante em lista de
                                                                                                    Resolução
                                                                                                    CAMEX
                                                                                                </option>
                                                                                                <option value="7" <?php if ($faturamento_produto->cod_origem == 7) echo "selected"; ?>>
                                                                                                    7 - Estrangeira - Adquirida no
                                                                                                    mercado
                                                                                                    interno, sem
                                                                                                    similar nacional, constante em
                                                                                                    lista de
                                                                                                    Resolução
                                                                                                    CAMEX
                                                                                                </option>
                                                                                                <option value="8" <?php if ($faturamento_produto->cod_origem == 8) echo "selected"; ?>>
                                                                                                    8 - Nacional, mercadoria ou bem
                                                                                                    com Conteúdo
                                                                                                    de
                                                                                                    Importação superior a 70%
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="form-group col-md-6">
                                                                                            <label for="inputOrigemProduto">Código de Exceção da TIPI</label>
                                                                                            <input type="text" class="form-control" id="inputTotalVenda" type="text" name="TotalVenda" data-mask="#.##0,00" data-mask-reverse="true" value="<?= number_format($faturamento_produto->valor_movimento, 2, ',', '.') ?>">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="tab-pane fade impostos" role="tabpanel" aria-labelledby="home-tab" id="pis<?= $faturamento_produto->cod_produto ?>">
                                                                                    <div class="form-row mt-2">
                                                                                        <div class="form-group col-md-12">
                                                                                            <label for="inputOrigemProduto">Situação
                                                                                                Tributária
                                                                                                PIS</label>
                                                                                            <select id="inputOrigemProduto" name="OrigemProduto" data-style="btn-input-primary" class="selectpicker show-tick form-control" data-live-search="true" data-actions-box="true" title="Informe a Origem do Produto">
                                                                                                <option value="0" <?php if ($faturamento_produto->cod_origem == 0) echo "selected"; ?>>
                                                                                                    0 - Nacional
                                                                                                </option>
                                                                                                <option value="1" <?php if ($faturamento_produto->cod_origem == 1) echo "selected"; ?>>
                                                                                                    1 - Estrangeira - Importação
                                                                                                    direta
                                                                                                </option>
                                                                                                <option value="2" <?php if ($faturamento_produto->cod_origem == 2) echo "selected"; ?>>
                                                                                                    2 - Estrangeira - Adquirida no
                                                                                                    mercado
                                                                                                    interno
                                                                                                </option>
                                                                                                <option value="3" <?php if ($faturamento_produto->cod_origem == 3) echo "selected"; ?>>
                                                                                                    3 - Nacional, mercadoria ou bem
                                                                                                    com Conteúdo
                                                                                                    de
                                                                                                    Importação superior a 40%
                                                                                                </option>
                                                                                                <option value="4" <?php if ($faturamento_produto->cod_origem == 4) echo "selected"; ?>>
                                                                                                    4 - Nacional, cuja produção
                                                                                                    tenha sido feita
                                                                                                    em
                                                                                                    conformidade com a MP 252(MP do
                                                                                                    BEM)
                                                                                                </option>
                                                                                                <option value="5" <?php if ($faturamento_produto->cod_origem == 5) echo "selected"; ?>>
                                                                                                    5 - Nacional, mercadoria ou bem
                                                                                                    com Conteúdo
                                                                                                    de
                                                                                                    Importação inferior ou igual a
                                                                                                    40%
                                                                                                </option>
                                                                                                <option value="6" <?php if ($faturamento_produto->cod_origem == 6) echo "selected"; ?>>
                                                                                                    6 - Estrangeira - Importação
                                                                                                    direta, sem
                                                                                                    similar
                                                                                                    nacional, constante em lista de
                                                                                                    Resolução
                                                                                                    CAMEX
                                                                                                </option>
                                                                                                <option value="7" <?php if ($faturamento_produto->cod_origem == 7) echo "selected"; ?>>
                                                                                                    7 - Estrangeira - Adquirida no
                                                                                                    mercado
                                                                                                    interno, sem
                                                                                                    similar nacional, constante em
                                                                                                    lista de
                                                                                                    Resolução
                                                                                                    CAMEX
                                                                                                </option>
                                                                                                <option value="8" <?php if ($faturamento_produto->cod_origem == 8) echo "selected"; ?>>
                                                                                                    8 - Nacional, mercadoria ou bem
                                                                                                    com Conteúdo
                                                                                                    de
                                                                                                    Importação superior a 70%
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-row">
                                                                                        <div class="form-group col-md-4">
                                                                                            <label class="" for="inputOrigemProduto">Valor
                                                                                                Base PIS</label>
                                                                                            <div class="input-group">
                                                                                                <div class="input-group-prepend">
                                                                                                    <span class="input-group-text">R$</span>
                                                                                                </div>
                                                                                                <input type="text" class="form-control" id="inputTotalVenda" type="text" name="TotalVenda" data-mask="#.##0,00" data-mask-reverse="true" value="<?= number_format($faturamento_produto->valor_movimento, 2, ',', '.') ?>">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group col-md-4">
                                                                                            <label class="" for="inputOrigemProduto">Percentual PIS</label>
                                                                                            <div class="input-group">
                                                                                                <input type="text" class="form-control" id="inputTotalVenda" type="text" name="TotalVenda" data-mask="#.##0,00" data-mask-reverse="true" value="<?= number_format($faturamento_produto->valor_movimento, 2, ',', '.') ?>">
                                                                                                <div class="input-group-append">
                                                                                                    <span class="input-group-text">%</span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group col-md-4">
                                                                                            <label for="inputOrigemProduto">Valor
                                                                                                PIS</label>
                                                                                            <div class="input-group">
                                                                                                <div class="input-group-prepend mt-0">
                                                                                                    <span class="input-group-text">R$</span>
                                                                                                </div>
                                                                                                <input type="text" class="form-control" id="inputTotalVenda" type="text" name="TotalVenda" data-mask="#.##0,00" data-mask-reverse="true" value="<?= number_format($faturamento_produto->valor_movimento, 2, ',', '.') ?>">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="tab-pane fade impostos" role="tabpanel" aria-labelledby="home-tab" id="cofins<?= $faturamento_produto->cod_produto ?>">
                                                                                    <div class="form-row mt-2">
                                                                                        <div class="form-group col-md-12">
                                                                                            <label for="inputOrigemProduto">Situação
                                                                                                Tributária
                                                                                                COFINS</label>
                                                                                            <select id="inputOrigemProduto" name="OrigemProduto" data-style="btn-input-primary" class="selectpicker show-tick form-control" data-live-search="true" data-actions-box="true" title="Informe a Origem do Produto">
                                                                                                <option value="0" <?php if ($faturamento_produto->cod_origem == 0) echo "selected"; ?>>
                                                                                                    0 - Nacional
                                                                                                </option>
                                                                                                <option value="1" <?php if ($faturamento_produto->cod_origem == 1) echo "selected"; ?>>
                                                                                                    1 - Estrangeira - Importação
                                                                                                    direta
                                                                                                </option>
                                                                                                <option value="2" <?php if ($faturamento_produto->cod_origem == 2) echo "selected"; ?>>
                                                                                                    2 - Estrangeira - Adquirida no
                                                                                                    mercado
                                                                                                    interno
                                                                                                </option>
                                                                                                <option value="3" <?php if ($faturamento_produto->cod_origem == 3) echo "selected"; ?>>
                                                                                                    3 - Nacional, mercadoria ou bem
                                                                                                    com Conteúdo
                                                                                                    de
                                                                                                    Importação superior a 40%
                                                                                                </option>
                                                                                                <option value="4" <?php if ($faturamento_produto->cod_origem == 4) echo "selected"; ?>>
                                                                                                    4 - Nacional, cuja produção
                                                                                                    tenha sido feita
                                                                                                    em
                                                                                                    conformidade com a MP 252(MP do
                                                                                                    BEM)
                                                                                                </option>
                                                                                                <option value="5" <?php if ($faturamento_produto->cod_origem == 5) echo "selected"; ?>>
                                                                                                    5 - Nacional, mercadoria ou bem
                                                                                                    com Conteúdo
                                                                                                    de
                                                                                                    Importação inferior ou igual a
                                                                                                    40%
                                                                                                </option>
                                                                                                <option value="6" <?php if ($faturamento_produto->cod_origem == 6) echo "selected"; ?>>
                                                                                                    6 - Estrangeira - Importação
                                                                                                    direta, sem
                                                                                                    similar
                                                                                                    nacional, constante em lista de
                                                                                                    Resolução
                                                                                                    CAMEX
                                                                                                </option>
                                                                                                <option value="7" <?php if ($faturamento_produto->cod_origem == 7) echo "selected"; ?>>
                                                                                                    7 - Estrangeira - Adquirida no
                                                                                                    mercado
                                                                                                    interno, sem
                                                                                                    similar nacional, constante em
                                                                                                    lista de
                                                                                                    Resolução
                                                                                                    CAMEX
                                                                                                </option>
                                                                                                <option value="8" <?php if ($faturamento_produto->cod_origem == 8) echo "selected"; ?>>
                                                                                                    8 - Nacional, mercadoria ou bem
                                                                                                    com Conteúdo
                                                                                                    de
                                                                                                    Importação superior a 70%
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-row">
                                                                                        <div class="form-group col-md-4">
                                                                                            <label class="" for="inputOrigemProduto">Valor
                                                                                                Base COFINS</label>
                                                                                            <div class="input-group">
                                                                                                <div class="input-group-prepend">
                                                                                                    <span class="input-group-text">R$</span>
                                                                                                </div>
                                                                                                <input type="text" class="form-control" id="inputTotalVenda" type="text" name="TotalVenda" data-mask="#.##0,00" data-mask-reverse="true" value="<?= number_format($faturamento_produto->valor_movimento, 2, ',', '.') ?>">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group col-md-4">
                                                                                            <label class="" for="inputOrigemProduto">Percentual COFINS</label>
                                                                                            <div class="input-group">
                                                                                                <input type="text" class="form-control" id="inputTotalVenda" type="text" name="TotalVenda" data-mask="#.##0,00" data-mask-reverse="true" value="<?= number_format($faturamento_produto->valor_movimento, 2, ',', '.') ?>">
                                                                                                <div class="input-group-append">
                                                                                                    <span class="input-group-text">%</span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group col-md-4">
                                                                                            <label for="inputOrigemProduto">Valor
                                                                                                COFINS</label>
                                                                                            <div class="input-group">
                                                                                                <div class="input-group-prepend mt-0">
                                                                                                    <span class="input-group-text">R$</span>
                                                                                                </div>
                                                                                                <input type="text" class="form-control" id="inputTotalVenda" type="text" name="TotalVenda" data-mask="#.##0,00" data-mask-reverse="true" value="<?= number_format($faturamento_produto->valor_movimento, 2, ',', '.') ?>">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                        <?php }
                                                        } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="dados-frete">
                                        <div class="row">
                                            <div class="col-md-12">
                                                Teste
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" form="InserirFaturamento"><i class="fas fa-plus-circle"></i>
                        Faturar Pedido</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
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

    $('#inputDataFaturamento').datepicker({
        uiLibrary: 'bootstrap4'
    });

    $('#inputQuantSaida').mask("###0,000", {
        reverse: true
    });

    $('#inputValorVenda').mask("#.##0,00", {
        reverse: true
    });

    <?php foreach ($lista_produto as $key_produto => $produto) { ?>
        jQuery('#inputQuantVendida' + "<?php echo $produto->cod_produto; ?>").on('keyup', function() {

            var quantVendida = parseFloat(jQuery('#inputQuantVendida' +
                    "<?php echo $produto->cod_produto; ?>")
                .val() !=
                '' ?
                (jQuery('#inputQuantVendida' + "<?php echo $produto->cod_produto; ?>").val().split('.')
                    .join(
                        ''))
                .replace(',', '.') : 0);
            var precoUnitario = parseFloat("<?php echo $produto->valor_unitario; ?>");

            var totalVenda = quantVendida * precoUnitario;

            $("#inputValorVenda" + "<?= $produto->cod_produto ?>").html("R$ " + totalVenda.toLocaleString(
                "pt-BR", {
                    style: "decimal",
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }));

            calcTotalVenda();

        });
    <?php } ?>

    jQuery('#inputValorDesconto').on('keyup', function() {
        calcTotalVenda();
    });

    jQuery('#inputValorFrete').on('keyup', function() {
        calcTotalVenda();
    });

    function calcTotalVenda() {

        var totalBruto = 0;

        var valorFrete = parseFloat(jQuery('#inputValorFrete').val() != '' ? (jQuery(
                '#inputValorFrete').val()
            .split('.').join('')).replace(',', '.') : 0);

        var valorDesconto = parseFloat(jQuery('#inputValorDesconto').val() != '' ? (jQuery(
                '#inputValorDesconto').val()
            .split('.').join('')).replace(',', '.') : 0);

        var totalLiquido = 0;

        <?php foreach ($lista_produto as $key_produto => $produto) { ?>
            var totalBruto = totalBruto + parseFloat(jQuery('#inputValorVenda' + '<?= $produto->cod_produto ?>')
                .text() !=
                '' ?
                (jQuery('#inputValorVenda' + '<?= $produto->cod_produto ?>').text().split('.').join(''))
                .replace('R$',
                    '')
                .replace(',', '.') : 0);
        <?php } ?>

        totalLiquido = totalBruto + valorFrete - valorDesconto;

        $("#inputValorBruto").html("<strong>R$ " + totalBruto.toLocaleString("pt-BR", {
                style: "decimal",
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }) + "</strong> <input class='form-control text-center' id='inputBruto'" +
            "name='ValorBruto' type='hidden' data-mask='#.##0,00'" +
            "data-mask-reverse='true' value='<?= number_format($valorPendente, 2, ',', '.') ?>'>");

        $("#inputBruto").val(totalBruto.toLocaleString("pt-BR", {
            style: "decimal",
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));

        $("#inputValorLiq").html("R$ " + totalLiquido.toLocaleString("pt-BR", {
            style: "decimal",
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));

        var quantParcela = $('#inputParcelas').val();
        var acumulado = 0;

        for (var i = 1; i <= quantParcela; i++) {

            valorParcela = round((totalLiquido / quantParcela), 2);
            acumulado = acumulado + valorParcela;

            if (i == quantParcela && acumulado != totalLiquido) {
                valorParcela = valorParcela + (totalLiquido - acumulado);
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
            cols += '<input type="text" class="form-control text-center" id="inputDataVencimento' + i +
                '"';
            cols += 'name="DataVencimento[' + i + ']"';
            cols += 'value="' + dataParcela.toLocaleDateString('pt-BR', {
                timeZone: 'UTC'
            }) + '" required>';
            cols += '</td>';

            // Valor da parcela
            cols += '<td>';
            cols += '<div class="input-group">';
            cols += '<div class="input-group-prepend">';
            cols += '<span class="input-group-text">R$</span>';
            cols += '</div>';
            cols += '<input class="form-control text-center" id="inputValorParcela' + i +
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

    $('#inputDataVencimento1').datepicker({
        uiLibrary: 'bootstrap4'
    });



    const round = (num, places) => {
        return +(parseFloat(num).toFixed(places));
    }
</script>

<script src="<?= base_url('/assets/js/app.js'); ?>" type="text/javascript"></script>

<?php $this->load->view('gerais/footer'); ?>