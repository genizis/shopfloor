<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active">Pedido de Compra</li>
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
                            <div class="col-md-9">
                                <a href="<?php echo base_url() ?>compras/pedido-compra/novo-pedido-compra" type="button"
                                    class="btn btn-info"><i class="fas fa-plus-circle"></i> Novo Pedido de Compra</a>
                                <button data-toggle="modal" data-target="#elimina-pedido" type="button"
                                    class="btn btn-danger" id="btnExcluir" disabled><i class="fas fa-trash-alt"></i> Excluir</button>
                            </div>
                            <div class="col-md-3">
                                <form action="<?= base_url('compras/pedido-compra') ?>" method="GET" class="needs-validation" novalidate>
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
                            <div class="col-md-12">
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
                                <form action="<?= base_url('compras/pedido-compra/excluir-pedido') ?>" method="POST"
                                    id="formDelete" class="mb-0 needs-validation" novalidate>
                                    <table class="table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col" class="text-center">#</th>
                                                <th scope="col" class="text-center">Ped Compra</th>
                                                <th scope="col">Fornecedor</th>
                                                <th scope="col" class="text-center">Data Emissão</th>
                                                <th scope="col" class="text-center">Data Entrega</th>
                                                <th scope="col" class="text-center">Valor Total</th>
                                                <th scope="col" class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($lista_pedido as $key_pedido => $pedido) { ?>
                                            <tr>
                                                <td>
                                                    <div class="checkbox text-center">
                                                        <input name="excluir_todos[]" type="checkbox"
                                                            value="<?= $pedido->num_pedido_compra ?>" 
                                                            <?php if($pedido->valor_total > 0 || $pedido->estornado > 0){ echo "disabled"; } ?>/>
                                                    </div>
                                                </td>                                                
                                                <td  class="text-center"><a
                                                        href="<?= base_url("compras/pedido-compra/editar-pedido-compra/{$pedido->num_pedido_compra}") ?>"><?= $pedido->num_pedido_compra ?></a>
                                                </td>
                                                <td><?= $pedido->cod_fornecedor ?> - <?= $pedido->nome_fornecedor ?></td>
                                                <td class="text-center">
                                                    <?= str_replace('-', '/', date("d-m-Y", strtotime($pedido->data_emissao))) ?>
                                                </td>
                                                <td class="text-center">
                                                    <?= str_replace('-', '/', date("d-m-Y", strtotime($pedido->data_entrega))) ?>
                                                </td>                                                
                                                <td class="text-center">
                                                    R$ <?= number_format($pedido->valor_total, 2, ',', '.') ?></td>                                                
                                                <td class="text-center">
                                                    <?php
                                                        if($pedido->data_entrega < date('Y-m-d') && $pedido->quant_pendente != 0 && $pedido->valor_total != 0){
                                                            echo "<span class='badge badge-danger'>Atrasado</span>";
                                                        }elseif($pedido->valor_total == 0 && $pedido->estornado == 0){
                                                            echo "<span class='badge badge-secondary'>Em digitação</span>";
                                                        }elseif($pedido->valor_total == 0 && $pedido->estornado != 0){
                                                            echo "<span class='badge badge-dark'>Estornado</span>";
                                                        }elseif($pedido->quant_pendente == 0){
                                                            echo "<span class='badge badge-teal'>Recebido Total</span>";
                                                        }elseif($pedido->quant_pendente != 0){
                                                            echo "<span class='badge badge-info'>Pendente</span>";
                                                        }                                                        
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <?php if ($lista_pedido == false) { ?>
                                    <div class="text-center">
                                        <p class="text-muted mb-0">Nenhum pedido de compra encontrado</p>
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

<div class="modal fade" id="elimina-pedido" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Pedido de Compra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirma eliminação do(s) pedido(s) de compra selecionado(s)?
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="formDelete">Confirma</button>
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
</script>

<?php $this->load->view('gerais/footer'); ?>