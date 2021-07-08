<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active">Ordem de Compra</li>
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
                            <div class="col-md-8">
                                <button data-toggle="modal" data-target="#gerar-pedido" type="button"
                                    class="btn btn-primary" id="btnPedido" disabled><i class="fas fa-check-circle"></i> Gerar Pedido de Compra</button>
                                <a href="<?php echo base_url() ?>compras/ordem-compra/nova-ordem-compra" type="button"
                                    class="btn btn-info"><i class="fas fa-plus-circle"></i> Nova Ordem de Compra</a>
                                <button data-toggle="modal" data-target="#elimina-ordem" type="button"
                                    class="btn btn-danger" id="btnExcluir" disabled><i class="fas fa-trash-alt"></i> Excluir</button>                                
                            </div>
                            <div class="col-md-4">
                                <form action="<?= base_url('compras/ordem-compra') ?>" method="GET" class="needs-validation" novalidate>
                                    <div class="input-group">
                                        <input type="text" class="form-control search" name="buscar">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <?= $opcao ?>
                                            </button>
                                            <div class="dropdown-menu">
                                            <button name="selecao" value="OrdensSemPedido" class="dropdown-item" type="submit" href="#">Ordens sem pedido</button>
                                            <button name="selecao" value="OrdensComPedido" class="dropdown-item" type="submit" href="#">Ordens com Pedido</button>
                                            <button name="selecao" value="TodasOrdens" class="dropdown-item" type="submit" href="#">Todas as Ordens</button>
                                            </div>
                                        </div>
                                        <div class="input-group-append">
                                            <button name="selecao" value="<?= $select ?>" type="submit" class="btn btn-secondary"><i
                                                    class="fas fa-search"></i> Buscar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
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
                                <form action="<?= base_url('compras/ordem-compra/excluir-ordem') ?>" method="POST"
                                    id="formDelete"  class="mb-0 needs-validation" novalidate>
                                    <table class="table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col" class="text-center">#</th>
                                                <th scope="col" class="text-center">Ord Compra</th>
                                                <th scope="col">Produto de Compra</th>
                                                <th scope="col" class="text-center">Unid Medida</th>
                                                <th scope="col" class="text-center">Quant Pedida</th>
                                                <th scope="col" class="text-center">Quant Atendida</th>
                                                <th scope="col" class="text-center">Data de Necessidade</th>
                                                <th scope="col" class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($lista_ordem as $key_ordem => $ordem) { ?>
                                            <tr>
                                                <td>
                                                    <div class="checkbox text-center">
                                                        <input name="selecionar_todos[]" type="checkbox" id="inputSelecionar"
                                                            value="<?= $ordem->num_ordem_compra ?>" <?php if($ordem->num_pedido_compra != null) echo "disabled"; ?>/>
                                                    </div>
                                                </td>
                                                <td class="text-center"><a
                                                        href="<?= base_url("compras/ordem-compra/editar-ordem-compra/{$ordem->num_ordem_compra}") ?>"><?= $ordem->num_ordem_compra ?></a>
                                                </td>
                                                <td><?= $ordem->cod_produto ?> - <?= $ordem->nome_produto ?></td>
                                                <td class="text-center"><?= $ordem->cod_unidade_medida ?></td>
                                                <td class="text-center">
                                                    <?= number_format($ordem->quant_pedida, 3, ',', '.') ?></td>
                                                <td class="text-center">
                                                    <?= number_format($ordem->quant_atendida, 3, ',', '.') ?></td>
                                                <td class="text-center">
                                                    <?= str_replace('-', '/', date("d-m-Y", strtotime($ordem->data_necessidade))) ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                        if($ordem->data_necessidade < date('Y-m-d') && $ordem->status != 3){
                                                            echo "<span class='badge badge-danger'>Atrasada</span>";

                                                        }else{
                                                            switch ($ordem->status) {
                                                                case 1:
                                                                    echo "<span class='badge badge-secondary'>Pendente</span>";
                                                                    break;
                                                                case 2:
                                                                    echo "<span class='badge badge-info'>Recebida Parcial</span>";
                                                                    break;
                                                                case 3:
                                                                    echo "<span class='badge badge-teal'>Recebida Total</span>";
                                                                    break;
                                                            } 

                                                        }                                                        
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <?php if ($lista_ordem == false) { ?>
                                    <div class="text-center">
                                        <p class="text-muted mb-0">Nenhuma ordem de compra encontrada</p>
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

<div class="modal fade" id="elimina-ordem" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Ordem de Compra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirma eliminação da(s) ordem(s) de compra selecionada(s)?
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="formDelete">Confirma</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="gerar-pedido">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gerar Pedido de Compra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="mb-0 needs-validation" novalidate
                   action="<?= base_url('compras/pedido-compra/gerar-pedido-compra') ?>" method="POST" id="PedidoCompra">
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <input type="hidden" class="form-control" id="inputSelecionado"
                                    name="selecionado" 
                                    value="">
                            <label for="inputFornecedor">Fornecedor <span class="text-danger">*</span></label>
                            <select id="inputFornecedor" class="selectpicker show-tick form-control"
                                    data-live-search="true" data-actions-box="true" data-style="btn-input-primary"
                                    title="Selecione um Fornecedor" name="CodFornecedor">
                                <?php foreach($lista_fornecedor as $key_fornecedor => $fornecedor) { ?>
                                <option value="<?= $fornecedor->cod_fornecedor ?>"
                                <?php if($fornecedor->cod_fornecedor == set_value('CodFornecedor')) echo "selected"; ?>>
                                <?= $fornecedor->cod_fornecedor ?> -
                                <?= $fornecedor->nome_fornecedor ?></option>
                                <?php } ?>
                            </select>
                        </div>                                        
                        <div class="form-group col-md-2">
                            <label for="inputDateEmissao">Data de Emissão <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="inputDateEmissao"
                                    name="DataEmissao" 
                                    value="<?php if(set_value('DataEmissao') == ""){
                                                    echo str_replace('-', '/', date("d-m-Y"));
                                                }else{ echo set_value('DataEmissao'); } ?>">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputDateEntrega">Data de Entrega <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="inputDateEntrega"
                                    name="DataEntrega" value="<?= set_value('DataEntrega'); ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputObservacao">Observações do Pedido de Compra</label>
                            <textarea class="form-control" rows="3" id="inputObservacao"
                                    name="ObsPedidoCompra"><?= set_value('ObsPedidoCompra'); ?></textarea>
                        </div>
                    </div>                                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="PedidoCompra"><i class="fas fa-check-circle"></i> Gerar Pedido de Compra</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
$('.page-item>a').addClass("page-link");

$("[name='selecionar_todos[]']").click(function() {
    var cont = $("[name='selecionar_todos[]']:checked").length;
    $("#btnExcluir").prop("disabled", cont ? false : true);
});

$("[name='selecionar_todos[]']").click(function() {
    var cont = $("[name='selecionar_todos[]']:checked").length;
    $("#btnPedido").prop("disabled", cont ? false : true);
});

$('#inputDateEmissao').datepicker({
    uiLibrary: 'bootstrap4'
});

$('#inputDateEntrega').datepicker({
    uiLibrary: 'bootstrap4'
});

$("#btnPedido").on('click', function(){

    var selecionado = [];
    var i = 0;

    $("input[name='selecionar_todos[]']:checked").each(function () {
        selecionado[i] =  $(this).val(); 
        i = i + 1;       
    });

    $("#inputSelecionado").val(selecionado);
    console.log(selecionado);
    
});

</script>

<?php $this->load->view('gerais/footer'); ?>