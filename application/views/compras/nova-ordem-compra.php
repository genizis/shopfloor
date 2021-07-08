<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active"><a href="<?php echo base_url() ?>compras/ordem-compra">Ordem de Compra</a></li>
            <li class="breadcrumb-item active">Nova Ordem de Compra</a></li>
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
                                <form action="<?= base_url('compras/ordem-compra/nova-ordem-compra') ?>" method="POST" class="needs-validation" novalidate>
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
                                        <div class="form-group col-md-4">
                                            <label class="control-label" for="dateEntregaCompra">Data de Necessidade <span class="text-danger">*</span></label>
                                            <input class="form-control" id="dateEntregaCompra" type="text"
                                                name="DataNecessidade" value="<?= set_value('DataNecessidade'); ?>" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="control-label" for="inputQtdePedida">Quantidade Pedida <span class="text-danger">*</span></label>
                                            <input class="form-control" id="inputQtdePedida" type="text" data-mask="#.##0,000" data-mask-reverse="true"
                                                name="QuantPedida" value="<?= set_value('QuantPedida'); ?>" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="control-label" for="inputQtdeAtendida">Quantidade
                                                Atendida</label>
                                            <input class="form-control" id="inputQtdeAtendida" type="text" data-mask="#.##0,000" data-mask-reverse="true"
                                                readonly name="QuantAtendida" value="0,000">
                                        </div>                                        
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputObservacao">Observações da Ordem de Compra</label>
                                            <textarea class="form-control" rows="3" id="inputObservacao"
                                                name="ObsOrdemCompra"><?= set_value('ObsOrdemCompra'); ?></textarea>
                                        </div>
                                    </div>                                    
                                    <hr>
                                    <div class="row float-right">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                            <button type="submit" class="btn btn-primary" name="Opcao" value="salvar"><i
                                                    class="fas fa-save"></i> Salvar</button>
                                            <button type="submit" class="btn btn-info" name="Opcao"
                                                value="salvarContinuar">Salvar e Continuar</button>
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