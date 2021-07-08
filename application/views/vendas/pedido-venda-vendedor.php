<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu-vendedor', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Minhas Vendas</li>
        </ol>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12">
                        <div class="row">
                            <div class="col-md-3">
                                <a href="<?php echo base_url() ?>vendas/pedido-venda-vendedor/novo-pedido-venda-vendedor" type="button"
                                    class="btn btn-block btn-info mb-2"><i class="fas fa-plus-circle"></i> Novo Pedido
                                    de Venda</a>
                            </div>
                            <div class="col-md-6"></div>
                            <div class="col-md-3">
                                <form action="<?= base_url('vendas/pedido-venda-vendedor') ?>" method="GET"
                                    class=" needs-validation" novalidate>
                                    <div class="input-group">
                                        <input type="text" class="form-control search" name="buscar">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-secondary"><i
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
                                <div class="list-group mb-2">
                                    <?php foreach($lista_pedido as $key_pedido => $pedido) { ?>
                                    <a href="<?= base_url("vendas/pedido-venda-vendedor/editar-pedido-venda-vendedor/{$pedido->num_pedido_venda}") ?>"
                                        class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-2"><strong><?= $pedido->cod_cliente ?> - <?= $pedido->nome_cliente ?></strong></h5>
                                            <h5><?= $pedido->num_pedido_venda ?></h5>
                                        </div>
                                        <h5 class="mb-2">
                                            <strong class="text-teal">R$ <?php if($pedido->valor_desconto != 0){
                                                            if($pedido->tipo_desconto == 1){
                                                                echo number_format($pedido->valor_total_pedido - $pedido->valor_desconto, 2, ',', '.');
                                                            }elseif($pedido->tipo_desconto == 2){
                                                                echo number_format($pedido->valor_total_pedido - ($pedido->valor_total_pedido * ($pedido->valor_desconto / 100)), 2, ',', '.');
                                                            }
                                                        }else{
                                                            echo number_format($pedido->valor_total_pedido, 2, ',', '.');
                                                        }
                                                    ?></strong></h5>
                                        <p class="mb-2">Data Emiss. <?= str_replace('-', '/', date("d-m-Y", strtotime($pedido->data_emissao))) ?>, Data Entreg. <?= str_replace('-', '/', date("d-m-Y", strtotime($pedido->data_entrega))) ?></p>
                                        <span><?php  
                                                    switch ($pedido->situacao) {
                                                        case 1:
                                                            echo "<span class='badge badge-secondary'>Em Orçamento</span>";
                                                            break;
                                                        case 2:
                                                            echo "<span class='badge badge-danger'>Orçamento Reprovado</span>";
                                                            break;
                                                        case 3:
                                                            echo "<span class='badge badge-info'>Venda Confirmada</span>";
                                                            break;
                                                    }

                                                    if($pedido->count_faturamento > 0)
                                                        echo " <span class='badge badge-teal'>Faturado</span>";
                                                    ?></span>
                                    </a>
                                    <?php } ?>
                                </div>                                
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
</section>

<div class="modal fade" id="elimina-pedido" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Pedido Venda</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirma eliminação do(s) pedido(s) de venda selecionado(s)?
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="formDelete">Confirma</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="importa-atendimento" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Importar Atendimentos - Vendas Externas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAtendimento" class="mb-0 needs-validation" novalidate
                    action="<?= base_url("vendas/importar-atendimentos-vendas-externas") ?>" method="GET">
                    <div class="form-group">
                        <label for="inputDataAtendimento">Data dos Atendimentos</label>
                        <input type="text" class="form-control" id="inputDataAtendimento" name="DataAtendimento"
                            value="<?= str_replace('-', '/', date("d-m-Y")) ?>">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="formAtendimento" id="btnSpinner">Confirma</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
$('.page-item>a').addClass("page-link");

$("[name='excluir_todos[]']").click(function() {
    var cont = $("[name='excluir_todos[]']:checked").length;
    $("#btnExcluir").prop("disabled", cont ? false : true);
});

$('#inputDataAtendimento').datepicker({
    uiLibrary: 'bootstrap4'
});
</script>

<?php $this->load->view('gerais/footer'); ?>