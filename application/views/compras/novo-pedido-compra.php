<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active"><a href="<?php echo base_url() ?>compras/pedido-compra">Pedido de Compra</a></li>
            <li class="breadcrumb-item active">Novo Pedido de Compra</a></li>
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
                                <form action="<?= base_url('compras/pedido-compra/novo-pedido-compra') ?>" method="POST" id="PedidoCompra" class="needs-validation" novalidate>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputFornecedor">Fornecedor <span class="text-danger">*</span></label>
                                            <select id="inputFornecedor" class="selectpicker show-tick form-control"
                                                data-live-search="true" data-actions-box="true" data-style="btn-input-primary"
                                                title="Selecione um Fornecedor" name="CodFornecedor" required>
                                                <?php foreach($lista_fornecedor as $key_fornecedor => $fornecedor) { ?>
                                                <option value="<?= $fornecedor->cod_fornecedor ?>"
                                                <?php if($fornecedor->cod_fornecedor == set_value('CodFornecedor')) echo "selected"; ?>>
                                                    <?= $fornecedor->cod_fornecedor ?> -
                                                    <?= $fornecedor->nome_fornecedor ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>  
                                    </div> 
                                    <div class="form-row">                                      
                                        <div class="form-group col-md-4">
                                            <label for="inputDateEmissao">Data de Emissão <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputDateEmissao"
                                                name="DataEmissao" 
                                                value="<?php if(set_value('DataEmissao') == ""){
                                                                echo str_replace('-', '/', date("d-m-Y"));
                                                            }else{ echo set_value('DataEmissao'); } ?>" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputDateEntrega">Data de Entrega <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputDateEntrega"
                                                name="DataEntrega" value="<?= set_value('DataEntrega'); ?>" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputTipoDesconto">Desconto</label>
                                            <div class="input-group">
                                                <select id="inputTipoDesconto" class="selectpicker show-tick form-control"
                                                        data-actions-box="true" data-style="btn-input-primary" name="TipoDesconto">
                                                    <option value="1">R$</option>
                                                    <option value="2">%</option>
                                                </select>
                                                <input type="text" class="form-control" data-mask="#.##0,00" data-mask-reverse="true"
                                                        name="Desconto" value="<?= set_value('Desconto'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputObservacao">Observações do Pedido de Compra</label>
                                            <textarea class="form-control" rows="3" id="inputObservacao"
                                                name="ObsPedidoCompra"><?= set_value('ObsPedidoCompra'); ?></textarea>
                                        </div>
                                    </div>
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
                                                            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="bottom" 
                                                            title="Você deve primeiramente salvar o pedido antes de adicionar uma ordem" disabled><i class="fas fa-check-circle"></i> Adicionar
                                                                Ordem de Compra</button>
                                                            <button type="button" class="btn btn-outline-info btn-sm" data-toggle="tooltip" data-placement="bottom" 
                                                            title="Você deve primeiramente salvar o pedido antes de criar um nova ordem" disabled><i class="fas fa-plus-circle"></i> Nova
                                                                Ordem de Compra</button>
                                                            <button type="button"
                                                                class="btn btn-outline-danger btn-sm" data-toggle="tooltip" data-placement="bottom" 
                                                            title="Você deve primeiramente salvar o pedido antes de excluir as ordens" disabled><i class="fas fa-trash-alt"></i>
                                                                Excluir</button>
                                                        </div>
                                                    </div>
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
                                                        </tbody>
                                                    </table>
                                                    <div class="text-center" id="divAviso">
                                                        <p id="pAviso">Nenhuma ordem de compra adicionada</p>
                                                    </div>
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
                                                        </tbody>
                                                    </table>
                                                    <div class="text-center" id="divAviso">
                                                        <p id="pAviso">Nenhum produto inserido</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="#" class="btn btn-outline-warning disabled"
                                                type="button"><i class="fas fa-print"></i> Imprimir Pedido</a>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row float-right">
                                                <div class="col-md-12">
                                                    <button type="submit" form="PedidoCompra" class="btn btn-primary"
                                                        name="Opcao" value="salvar"><i class="fas fa-save"></i> Salvar</button>
                                                    <button class="btn btn-info" disabled><i class="fas fa-box-open"></i> Receber Material</button>
                                                    <a href="<?php echo base_url() ?>compras/pedido-compra"
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

$('#inputDateEmissao').datepicker({
    uiLibrary: 'bootstrap4'
});

$('#inputDateEntrega').datepicker({
    uiLibrary: 'bootstrap4'
});

</script>

<?php $this->load->view('gerais/footer'); ?>