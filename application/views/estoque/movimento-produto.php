<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active"><a href="<?php echo base_url() ?>estoque/posicao-estoque">Posição de Estoque</a></li>
            <li class="breadcrumb-item active">Movimentos do Produto</a></li>
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
                                <form class=" needs-validation" novalidate>
                                    <div class="form-row">
                                        <div class="form-group col-md-2">
                                            <label for="inputCodProduto">Código do Produto</label>
                                            <input type="text" class="form-control" id="inputCodProduto" value="<?= $produto->cod_produto ?>"
                                                readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputNomeProduto">Nome do Produto</label>
                                            <input type="text" class="form-control" id="inputNomeProduto"
                                                value="<?= $produto->nome_produto ?>" readonly>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="inputTipoProduto">Tipo de Produto</label>
                                            <input type="text" class="form-control" id="inputTipoProduto"
                                                value="<?= $produto->nome_tipo_produto ?>" readonly>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="inputUnidadeMedida">Unidade de Medida</label>
                                            <input type="text" class="form-control" id="inputUnidadeMedida" value="<?= $produto->cod_unidade_medida ?>"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="form-row"> 
                                        <div class="form-group col-md-3">
                                            <label for="inputQtdeEstoque">Quantidade em Estoque</label>
                                            <input type="text" class="form-control <?php if($produto->quant_estoq < 0) echo "text-danger" ?>" id="inputQtdeEstoque" value="<?= number_format($produto->quant_estoq, 3, ',', '.') ?>"
                                                readonly>
                                        </div> 
                                        <div class="form-group col-md-3">
                                            <label for="inputQtdeEstoque">Custo Médio</label>
                                            <input type="text" class="form-control" id="inputQtdeEstoque" value="R$ <?= number_format($produto->custo_medio, 2, ',', '.') ?>"
                                                readonly>
                                        </div> 
                                        <div class="form-group col-md-3">
                                            <label for="inputEstoqueMinimo">Estoque Mínimo</label>
                                            <input type="text" class="form-control" id="inputEstoqueMinimo"
                                                value="<?= number_format($produto->estoq_min, 3, ',', '.') ?>" readonly>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputTempoAbastecimento">Tempo de Abastecimento (Dias)</label>
                                            <input type="text" class="form-control" id="inputTempoAbastecimento"
                                                value="<?= $produto->tempo_abastecimento ?>" readonly>
                                        </div>                                        
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h6>Movimentos do Produto</h6>
                                                    <button data-toggle="modal" data-target="#inserir-movimento"
                                                        type="button" class="btn btn-outline-primary btn-sm"><i
                                                            class="fas fa-plus-circle"></i> Inserir Movimento</button>
                                                </div>
                                            </div>
                                            <table class="table table-bordered table-striped table-hover small">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th scope="col" class="text-center">Data do Movimento</th>
                                                        <th scope="col">Tipo do Movimento</th>
                                                        <th scope="col">Especie Movimento</th>                                                        
                                                        <th scope="col"  class="text-center">Origem Movimento</th>
                                                        <th scope="col" class="text-center">ID Origem</th>
                                                        <th scope="col" class="text-center">Quant Movimento</th>
                                                        <th scope="col" class="text-center">Valor Movimento</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach($lista_movimento as $key_movimento => $movimento) { ?>
                                                    <tr>
                                                        <td class="text-center">
                                                            <?= str_replace('-', '/', date("d-m-Y", strtotime($movimento->data_movimento))) ?>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                                switch ($movimento->tipo_movimento) {
                                                                    case 1:
                                                                        echo "Entrada em Estoque";
                                                                        break;
                                                                    case 2:
                                                                        echo "Saída de Estoque";
                                                                        break;
                                                                } 
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                                switch ($movimento->especie_movimento) {
                                                                    case 1:
                                                                        echo "Estoque Inicial";
                                                                        break;
                                                                    case 2:
                                                                        echo "Reporte de Produção";
                                                                        break;
                                                                    case 3:
                                                                        echo "Consumo de Material";
                                                                        break;
                                                                    case 4:
                                                                        echo "Compra de Material";
                                                                        break;
                                                                    case 5:
                                                                        echo "Faturamento de Pedido";
                                                                        break;
                                                                    case 6:
                                                                        echo "Estorno de Produção";
                                                                        break;
                                                                    case 7:
                                                                        echo "Estorno de Cosumo";
                                                                        break;
                                                                    case 8:
                                                                        echo "Devolução de Compra";
                                                                        break;
                                                                    case 9:
                                                                        echo "Devolução de Venda";
                                                                        break;
                                                                    case 10:
                                                                        echo "Movimentos Diversos de Entrada";
                                                                        break;
                                                                    case 11:
                                                                        echo "Movimentos Diversos de Saída";
                                                                        break;
                                                                    case 12:
                                                                        echo "Entrada em Estoque Conta Azul";
                                                                        break;
                                                                    case 13:
                                                                        echo "Saída de Estoque Conta Azul";
                                                                        break;
                                                                    case 14:
                                                                        echo "Entrada por Acerto de Inventário";
                                                                        break;
                                                                    case 15:
                                                                        echo "Saída por Acerto de Inventário";
                                                                        break;
                                                                    case 16:
                                                                        echo "Requisição de Material";
                                                                        break;
                                                                    case 17:
                                                                        echo "Estorno de Requisição de Material";
                                                                        break;
                                                                } 
                                                            ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php 
                                                                switch ($movimento->origem_movimento) {
                                                                    case 1:
                                                                        echo "Reporte de Produção";
                                                                        break;
                                                                    case 2:
                                                                        echo "Recebimento de Material";
                                                                        break;
                                                                    case 3:
                                                                        echo "Pedido de Venda";
                                                                        break;
                                                                    case 4:
                                                                        echo "Inventário";
                                                                        break;
                                                                    case 5:
                                                                        echo "Estoque";
                                                                        break;
                                                                    case 6:
                                                                        echo "Frente de Caixa";
                                                                        break;
                                                                } 
                                                            ?>
                                                        </td>
                                                        <td class="text-center"><?= $movimento->id_origem ?></td>                                                        
                                                        <td class="text-center <?php if($movimento->tipo_movimento == 2) echo "text-danger"; ?>"
                                                        <?php if($movimento->especie_movimento == 10 || $movimento->especie_movimento == 11){ ?>
                                                        data-original-title="999"  data-container="body" 
                                                        data-toggle="tooltip" data-placement="left" title="<?= $movimento->observacao ?>"                                                            
                                                        <?php } ?>>
                                                            <?= number_format($movimento->quant_movimentada, 3, ',', '.') ?>
                                                        </td>
                                                        <td class="text-center <?php if($movimento->tipo_movimento == 2) echo "text-danger"; ?>">
                                                            R$ <?= number_format($movimento->valor_movimento, 2, ',', '.') ?>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            <?php if ($lista_movimento == false) { ?>
                                            <div class="text-center">
                                                <p>Nenhum movimento encontrado</p>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                            <div>
                                                <?= $pagination; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row float-right">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                            <a href="<?php echo base_url() ?>estoque/posicao-estoque" type="button" class="btn btn-secondary">Fechar</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="inserir-movimento">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Inserir Movimento de Produto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <form class="mb-0 needs-validation" novalidate
                            action="<?= base_url("estoque/posicao-estoque/inserir-movimento/{$produto->cod_produto}") ?>"
                            method="POST" id="InserirMovimento">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputEspecieMovimento">Espécie do Movimento <span class="text-danger">*</span></label>
                                    <select id="inputEspecieMovimento" class="selectpicker show-tick form-control"
                                        data-actions-box="true"
                                        title="Selecione uma Especie de Movimento" name="EspecieMovimento" required>
                                        <option value="10" <?php if(set_value('EspecieMovimento') == "10") echo "selected"; ?>>Movimentos Diversos de Entrada</option>
                                        <option value="11" <?php if(set_value('EspecieMovimento') == "11") echo "selected"; ?>>Movimentos Diversos de Saída</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="inputDataMovimento">Data do Movimento <span class="text-danger">*</span></label>
                                    <input class="form-control" id="inputDataMovimento" type="text" name="DataMovimento"
                                        value="<?php if(set_value('DataMovimento') == ""){
                                                                echo str_replace('-', '/', date("d-m-Y"));
                                                            }else{ echo set_value('DataMovimento'); } ?>" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="inputQtdeMovimento">Quantidade do
                                        Movimento <span class="text-danger">*</span></label>
                                    <input class="form-control" id="inputQtdeMovimento" type="text" name="QuantMovimentada" data-mask="#.##0,000" data-mask-reverse="true"
                                        value="<?= set_value('QuantMovimentada') ?>" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="inputValorMovimento">Valor do Movimento <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" class="form-control" class="form-control"
                                            id="inputValorMovimento" type="text" name="ValorMovimento" data-mask="#.##0,00" data-mask-reverse="true"
                                            value="<?= set_value('ValorMovimento'); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputObservacao">Observação</label>
                                    <textarea class="form-control" rows="3" id="inputObservacao"
                                        name="Observacao"><?= set_value('Observacao'); ?></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="InserirMovimento"><i class="fas fa-plus-circle"></i> Inserir Movimento</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
$('.page-item>a').addClass("page-link");

$(function() {
     $.applyDataMask();
});

$('#inputEspecieMovimento').selectpicker({
    style: 'btn-input-primary'
});

$('#inputDataMovimento').datepicker({
    uiLibrary: 'bootstrap4'
});

</script>

<?php $this->load->view('gerais/footer'); ?>