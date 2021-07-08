<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active"><a href="<?php echo base_url() ?>producao/ordem-producao">Ordem de Produção</a></li>
            <li class="breadcrumb-item active">Nova Ordem de Produção</a></li>
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
                                <form class="mb-0 needs-validation" novalidate
                                      action="<?= base_url('producao/ordem-producao/nova-ordem-producao') ?>" method="POST" id="OrdemProd">
                                    <div class="form-row">                                        
                                        <div class="form-group col-md-6">
                                            <label for="inputProdutoOrdem">Produto de Produção <span class="text-danger">*</span></label>
                                            <select id="inputProdutoOrdem" class="selectpicker show-tick form-control"
                                                data-live-search="true" data-actions-box="true" name="CodProduto" data-style="btn-input-primary"
                                                title="Selecione um Produto" required>
                                                <?php foreach($lista_produto_prod as $key_produto_prod => $produto_prod) { ?>
                                                <option value="<?= $produto_prod->cod_produto ?>"
                                                <?php if($produto_prod->cod_produto == set_value('CodProduto')) echo "selected"; ?>>
                                                    <?= $produto_prod->cod_produto ?> -
                                                    <?= $produto_prod->nome_produto ?></option>
                                                <?php } ?>
                                            </select>
										</div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label" for="inputTipoProduto">Tipo de Produto</label>
                                            <input class="form-control" id="inputTipoProduto" type="text" name="TipoProduto"
                                                readonly value="<?= set_value('TipoProduto'); ?>">
                                        </div>
										<div class="form-group col-md-3">
                                            <label class="control-label" for="inputUn">Unidade de Medida</label>
                                            <input class="form-control" id="inputUn" type="text" name="UnidadeMedida"
                                                readonly value="<?= set_value('UnidadeMedida'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputPedidoVenda">Pedido de Venda</label>
                                            <select id="inputPedidoVenda" class="selectpicker show-tick form-control"
                                                data-live-search="true" data-actions-box="true" name="PedidoVenda" data-style="btn-input-primary"
                                                title="Selecione um Pedido">
                                                <?php foreach($lista_pedido as $key_pedido => $pedido) { ?>
                                                <option value="<?= $pedido->num_pedido_venda ?>"
                                                <?php if($pedido->num_pedido_venda == set_value('PedidoVenda')) echo "selected"; ?>>
                                                    <?= $pedido->num_pedido_venda ?> -
                                                    <?= $pedido->nome_cliente ?></option>
                                                <?php } ?>
                                            </select>
										</div>										
                                    </div>
                                    <hr>
                                    <div class="form-row">
										<div class="form-group col-md-4">
                                            <label for="inputDataEmissao">Data Emissão <span class="text-danger">*</span></label>
											<input type="text" class="form-control" name="DataEmissao" 
											value="<?php if(set_value('DataEmissao') == ""){
                                                                echo str_replace('-', '/', date("d-m-Y"));
                                                            }else{ echo set_value('DataEmissao'); } ?>"
                                                id="inputDataEmissao" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputDataFim">Data Fim <span class="text-danger">*</span></label>
											<input type="text" class="form-control" name="DataFim"
											value="<?= set_value('DataFim'); ?>"
                                                id="inputDataFim" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputQtdePlanejada">Quantidade Planejada <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputQtdePlanejada" name="QuantPlanejada"
												data-mask="#.##0,000" data-mask-reverse="true" 
												value="<?= set_value('QuantPlanejada'); ?>" required>
										</div> 
									</div>
									<div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputObservacao">Observações da Ordem de Produção</label>
                                            <textarea class="form-control" rows="3" id="inputObservacao"
                                                name="ObsOrdemProducao"><?= set_value('ObsOrdemProducao'); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="inputPlanejaOrdem" name="PlanejaOrdens" value="1">
                                                <label class="custom-control-label" for="inputPlanejaOrdem">Planejar Ordens dos Produtos da Estrutura</label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h6>Lista de Materiais</h6>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-xs-12">
                                                    <button type="button" class="btn btn-outline-info btn-sm" data-toggle="tooltip" data-placement="bottom" 
                                                    title="Você deve primeiramente salvar a ordem de produção antes de inserir os componentes" disabled><i class="fas fa-plus-circle"></i> Novo
                                                        Componente</button>
                                                    <button type="button"
                                                        class="btn btn-outline-danger btn-sm" data-toggle="tooltip" data-placement="bottom" 
                                                    title="Você deve primeiramente salvar oa ordem de produção antes de excluir os componentes" disabled><i class="fas fa-trash-alt"></i>
                                                        Excluir</button>
                                                </div>
                                            </div>
                                            <table class="table table-bordered table-hover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th scope="col" class="text-center">#</th>
                                                        <th scope="col" class="text-center">Código</th>
                                                        <th scope="col">Nome do Produto</th>
                                                        <th scope="col">Tipo do Produto</th>
                                                        <th scope="col" class="text-center">Un</th>                                                        
                                                        <th scope="col" class="text-center">Quant Consumo</th>
                                                        <th scope="col" class="text-center">Quant Estoque</th>
                                                    </tr>
                                                </thead>
                                                <tbody>                                                    
                                                </tbody>
											</table>
											<div class="text-center" id="divAviso">
                                                <p id="pAviso">Nenhum componente cadastrado</p>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="#" class="btn btn-outline-warning disabled"
                                                type="button"><i class="fas fa-print"></i> Imprimir Ordem</a>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row float-right">
                                                <div class="col-md-12">
                                                    <button type="submit" form="OrdemProd" class="btn btn-primary"
                                                        name="Opcao" value="salvar"><i class="fas fa-save"></i> Salvar</button>
                                                    <button class="btn btn-info" disabled><i class="fas fa-cogs"></i> Reportar Produção</button>
                                                    <a href="<?php echo base_url() ?>producao/ordem-producao"
                                                        class="btn btn-secondary">Cancelar</a>
                                                </div>
                                            </div>
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

$("#inputProdutoOrdem").change(function() {

	var baseurl = "<?php echo base_url(); ?>";

	var produto = $("#inputProdutoOrdem").val();

	$.post(baseurl + "ajax/busca-produto", {
		produto: produto
	}, function(valor) {
		var aValor = valor.split('|');
		console.log(aValor);
		$("#inputUn").val(aValor[0]);
		$("#inputTipoProduto").val(aValor[1]);
	});

});

$('#inputDataEmissao').datepicker({
    uiLibrary: 'bootstrap4'
});

$('#inputDataFim').datepicker({
    uiLibrary: 'bootstrap4'
});

</script>

<?php $this->load->view('gerais/footer'); ?>