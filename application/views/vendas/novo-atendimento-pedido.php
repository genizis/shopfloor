<?php $this->load->view('gerais/header'); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active"><a href="<?php echo base_url() ?>vendas/atendimento-pedido">Atendimento
                    de Pedido</a></li>
            <li class="breadcrumb-item active">Novo Atendimento de Pedido</li>
        </ol>
    </div>
</section>


<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12">
                <div class="card border-light mb-3">
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
                                    <div class="form-group col-md-1">
                                        <label for="inputPedido">Num do Pedido</label>
                                        <input type="text" class="form-control" id="inputPedido"
                                            value="<?= $produto->num_pedido_venda ?>" readonly>
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label for="inputCliente">Cliente</label>
                                        <input type="text" class="form-control" id="inputCliente"
                                            value="<?= $produto->cod_cliente ?> - <?= $produto->nome_cliente ?>"
                                            readonly>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="control-label" for="inputDataEmissao">Data de Emissão</label>
                                        <input class="form-control" id="inputDataEmissao" type="text"
                                            value="<?= str_replace('-', '/', date("d-m-Y", strtotime($produto->data_emissao))) ?>"
                                            readonly>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="control-label" for="inputDataEntrega">Data de Entrega</label>
                                        <input class="form-control" id="inputDataEntrega" type="text"
                                            value="<?= str_replace('-', '/', date("d-m-Y", strtotime($produto->data_entrega))) ?>"
                                            readonly>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="control-label" for="inputPedidoVenda">Valor do Pedido</label>
                                        <input class="form-control" id="inputPedidoVenda" type="text" readonly=""
                                            value="R$ <?= number_format($produto->valor_pedido, 2, ',', '.') ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputProdutoVenda">Produto de Venda</label>
                                        <input type="text" class="form-control" id="inputProdutoVenda"
                                            value="<?= $produto->cod_produto ?> - <?= $produto->nome_produto ?>"
                                            readonly>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="control-label" for="inputUnidadeMedida">Unidade de
                                            Medida</label>
                                        <input class="form-control" id="inputUnidadeMedida" type="text"
                                            value="<?= $produto->cod_unidade_medida ?>" readonly>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="control-label" for="inputQuantPedido">Quantidade
                                            Pedida</label>
                                        <input class="form-control" id="inputQuantPedido" type="text"
                                            value="<?= number_format($produto->quant_pedida, 3, ',', '.') ?>" readonly>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="control-label" for="inputQuantAtendida">Quantidade
                                            Atendida</label>
                                        <input class="form-control" id="inputQuantAtendida" type="text" readonly=""
                                            value="<?= number_format($produto->quant_atendida, 3, ',', '.') ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="inputObservacao">Observações do Pedido</label>
                                        <textarea class="form-control" rows="3" id="inputObservacao"
                                            readonly><?= $produto->observacoes ?></textarea>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-xs-12">
                                                <h6>Saídas de Material</h6>
                                                <button data-toggle="modal" data-target="#inserir-saida" type="button"
                                                    class="btn btn-outline-primary btn-sm"><i
                                                        class="fas fa-plus-circle"></i> Inserir Venda</button>
                                                <button data-toggle="modal" data-target="#estorna-saida" type="button"
                                                    class="btn btn-outline-danger btn-sm"
                                                    id="btnEstorno" disabled><i
                                                        class="fas fa-undo"></i>
                                                    Estornar Venda</button>
                                            </div>
                                        </div>
                                        <form class=" needs-validation" novalidate
                                            action="<?= base_url("vendas/atendimento-pedido/estornar-atendimento-pedido/{$produto->seq_produto_venda}") ?>"
                                            method="POST" id="EstornaSaida">
                                            <table class="table table-bordered table-hover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th scope="col" class="text-center">#</th>
                                                        <th scope="col" class="text-center">Data da Saída</th>
                                                        <th scope="col" class="text-center">Serie</th>
                                                        <th scope="col" class="text-center">Nota Fiscal</th>                                                        
                                                        <th scope="col" class="text-center">Quantidade Vendida</th>
                                                        <th scope="col" class="text-center">Valor de Venda</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($lista_movimento as $key_movimento => $movimento) { ?>
                                                    <tr>
                                                        <td>
                                                            <div class="checkbox text-center">
                                                                <input name="estornar_todos[]" type="checkbox"
                                                                    value="<?= $movimento->cod_movimento_pv?>" />
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <?= str_replace('-', '/', date("d-m-Y", strtotime($movimento->data_saida))) ?>
                                                        </td>
                                                        <td class="text-center"><?= $movimento->serie ?></td>
                                                        <td class="text-center"><?= $movimento->nota_fiscal ?></td>                                                        
                                                        <td class="text-center">
                                                            <?= number_format($movimento->quant_saida, 3, ',', '') ?>
                                                        </td>
                                                        <td class="text-center">R$
                                                            <?= number_format($movimento->valor_venda, 2, ',', '.') ?>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            <?php if ($lista_movimento == false) { ?>
                                            <div class="text-center">
                                                <p>Nenhuma saída realizada</p>
                                            </div>
                                            <?php } ?>
                                        </form>
                                    </div>
                                </div>
                                <hr>
                                <div class="row float-right">
                                    <div class="col-lg-12 col-md-12 col-xs-12 margem-baixo-10">
                                        <a href="<?php echo base_url() ?>vendas/atendimento-pedido" type="button"
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

<div class="modal fade" id="estorna-saida" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Estornar Saída de Material</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirma o estorno da(s) saída(s) selecionada(s)?
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="EstornaSaida">Confirma</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="inserir-saida">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Inserir Venda de Produto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <form class=" needs-validation" novalidate
                            action="<?= base_url("vendas/atendimento-pedido/inserir-saida/{$produto->seq_produto_venda}/{$produto->cod_produto}/") ?>"
                            method="POST" id="InserirSaida">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="control-label" for="inputDataSaida">Data de Saída <span class="text-danger">*</span></label>
                                    <input class="form-control" id="inputDataSaida" type="text" placeholder="Data Saída"
                                        name="DataSaida" value="<?php if(set_value('DataSaida') == ""){
                                                                echo str_replace('-', '/', date("d-m-Y"));
                                                            }else{ echo set_value('DataSaida'); } ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label" for="inputQuantSaida">Quantidade de Saída <span class="text-danger">*</span></label>
                                    <input class="form-control" id="inputQuantSaida" type="text" name="QuantSaida"
                                        placeholder="Quantidade Saída" value="<?= set_value('QuantSaida'); ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="control-label" for="inputValorVenda">Valor de Venda <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" class="form-control" class="form-control"
                                            id="inputValorVenda" type="text" name="ValorVenda"
                                            placeholder="Valor de Venda" value="<?= set_value('ValorVenda'); ?>">
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="inputSerie">Serie</label>
                                    <input class="form-control" id="inputSerie" type="text" placeholder="Serie"
                                        name="Serie" value="<?= set_value('Serie'); ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="inputNotaFiscal">Nota Fiscal</label>
                                    <input class="form-control" id="inputNotaFiscal" type="text" name="NotaFiscal"
                                        placeholder="Nota Fiscal" value="<?= set_value('NotaFiscal'); ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputObservacao">Observações do Faturamento</label>
                                    <textarea class="form-control" rows="3" id="inputObservacao	" name="Observacoes"
                                        placeholder="Descreva o Faturamento"><?= set_value('Observacoes'); ?></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="InserirSaida"><i class="fas fa-plus-circle"></i> Inserir
                    Venda</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
$("[name='estornar_todos[]']").click(function() {
    var cont = $("[name='estornar_todos[]']:checked").length;
    $("#btnEstorno").prop("disabled", cont ? false : true);
});

$('#inputDataSaida').datepicker({
    uiLibrary: 'bootstrap4'
});

$('#inputQuantSaida').mask("###0,000", {
    reverse: true
});

$('#inputValorVenda').mask("#.##0,00", {
    reverse: true
});
</script>

<?php $this->load->view('gerais/footer'); ?>