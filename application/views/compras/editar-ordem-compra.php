<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active"><a href="<?php echo base_url() ?>compras/ordem-compra">Ordem de Compra</a></li>
            <li class="breadcrumb-item active">Editar Ordem de Compra</a></li>
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
                                <form action="<?= base_url("compras/ordem-compra/editar-ordem-compra/{$ordem->num_ordem_compra}") ?>" method="POST" class="needs-validation" novalidate>
                                    <div class="form-row">
                                        <div class="form-group col-md-2">
                                            <label class="control-label" for="inputOrdemCompra">Ordem de Compra</label>
                                            <input class="form-control" id="inputOrdemCompra" type="text"
                                                readonly name="OrdemCompra" 
                                                value="<?= $ordem->num_ordem_compra ?>">
                                        </div> 
                                        <div class="form-group col-md-5">
                                            <label class="control-label" for="inputProdutoCompra">Produto de Compra</label>
                                            <input class="form-control" id="inputProdutoCompra" type="text"
                                                readonly name="CodProduto" 
                                                value="<?= $ordem->cod_produto ?> - <?= $ordem->nome_produto ?>">
                                        </div> 
                                        <div class="form-group col-md-2">
                                            <label for="inputTipoProduto">Tipo de Produto</label>
                                            <input type="text" class="form-control" id="inputTipoProduto"
                                                readonly name="TipoProduto" value="<?= $ordem->nome_tipo_produto ?>">
                                        </div> 
                                        <div class="form-group col-md-2">
                                            <label class="control-label" for="inputUnidadeMedida">Unidade de
                                                Medida</label>
                                            <input class="form-control" id="inputUnidadeMedida" type="text"
                                                readonly name="UnidadeMedida" value="<?= $ordem->cod_unidade_medida ?>">
                                        </div>
                                        <div class="form-group col-md-1">
                                            <label class="control-label" for="inputStatus">Status da OC</label>
                                            <input class="form-control" id="inputStatus" type="text" readonly
                                                value="<?php
                                                    if($ordem->data_necessidade < date('Y-m-d')){
                                                        echo "Atrasada";

                                                    }else{
                                                        switch ($ordem->status) {
                                                            case 1:
                                                                echo "Pendente";
                                                                break;
                                                            case 2:
                                                                echo "Recebida Parcial";
                                                                break;
                                                            case 3:
                                                                echo "Recebida Total";
                                                                break;
                                                        } 

                                                    }                                                        
                                                ?>" name="StatusOC">
                                        </div>
                                    </div>
                                    <div class="form-row">                                        
                                        <div class="form-group col-md-4">
                                            <label class="control-label" for="dateEntregaCompra">Data de Necessidade <span class="text-danger">*</span></label>
                                            <input class="form-control" id="dateEntregaCompra" type="text"
                                                name="DataNecessidade" value="<?= str_replace('-', '/', date("d-m-Y", strtotime($ordem->data_necessidade))) ?>">
                                        </div>                                        
                                        <div class="form-group col-md-4">
                                            <label class="control-label" for="inputQtdePedida">Quantidade Pedida <span class="text-danger">*</span></label>
                                            <input class="form-control" id="inputQtdePedida" type="text" data-mask="#.##0,000" data-mask-reverse="true"
                                                name="QuantPedida" value="<?= $ordem->quant_pedida ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="control-label" for="inputQtdeAtendida">Quantidade
                                                Atendida</label>
                                            <input class="form-control" id="inputQtdeAtendida" type="text" data-mask="#.##0,000" data-mask-reverse="true"
                                                readonly name="QuantAtendida" value="<?= $ordem->quant_atendida ?>">
                                        </div>                               
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputObservacao">Observações da Ordem de Compra</label>
                                            <textarea class="form-control" rows="3" id="inputObservacao"
                                                name="ObsOrdemCompra"><?= $ordem->observacoes ?></textarea>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row float-right">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                            <button type="submit" class="btn btn-primary" name="Opcao" value="salvar"><i
                                                    class="fas fa-save"></i> Salvar</button>
                                            <a href="<?php echo base_url() ?>compras/ordem-compra"
                                                class="btn btn-secondary">Cancelar</a>
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

<script> 

$(function() {
     $.applyDataMask();
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
    });
});

$('#dateEntregaCompra').datepicker({
    uiLibrary: 'bootstrap4'
});

</script>

<?php $this->load->view('gerais/footer'); ?>