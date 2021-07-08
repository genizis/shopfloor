<?php $this->load->view('gerais/header'); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active">Atendimento de Pedido</li>
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
                                <form action="<?= base_url('vendas/atendimento-pedido') ?>" method="GET"
                                    class="pull-right needs-validation" novalidate>
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
                                <div class="">
                                    <table class="table table-hover table-reporte">
                                        <thead class="thead-light">
                                            <tr>

                                                <th scope="col" class="text-center">Pedido Venda</th>
                                                <th scope="col">Cliente</th>
                                                <th scope="col">Produto Venda</th>
                                                <th scope="col">Un</th>
                                                <th scope="col" class="text-center">Qtde Pedida</th>
                                                <th scope="col" class="text-center">Qtde Atendida</th>
                                                <th scope="col" class="text-center">Vlr Pedido</th>
                                                <th scope="col" class="text-center">Data Entrega</th>
                                                <th scope="col" class="text-center">Status</th>
                                                <th scope="col" class="text-center">#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($lista_pedido as $key_pedido => $pedido) { ?>
                                            <tr>
                                                <td scope="row" class="text-center"><a target="_blank"
                                                        href="<?= base_url("vendas/pedido-venda/editar-pedido-venda/{$pedido->num_pedido_venda}") ?>"><?= $pedido->num_pedido_venda ?></a>
                                                </td>
                                                <td><?= $pedido->cod_cliente ?> - <?= $pedido->nome_cliente ?></td>
                                                <td><?= $pedido->cod_produto ?> - <?= $pedido->nome_produto ?></td>
                                                <td><?= $pedido->cod_unidade_medida ?></td>
                                                <td class="text-center">
                                                    <?= number_format($pedido->quant_pedida, 3, ',', '.') ?></td>
                                                <td class="text-center">
                                                    <?= number_format($pedido->quant_atendida, 3, ',', '.') ?></td>
                                                <td class="text-center">
                                                    R$ <?= number_format($pedido->valor_pedido, 2, ',', '.') ?></td>
                                                <td class="text-center">
                                                    <?= str_replace('-', '/', date("d-m-Y", strtotime($pedido->data_entrega))) ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                        if($pedido->data_entrega < date('Y-m-d') && $pedido->status != 3){
                                                            echo "<span class='badge badge-danger'>Atrasada</span>";

                                                        }else{
                                                            switch ($pedido->status) {
                                                                case 1:
                                                                    echo "<span class='badge badge-secondary'>Pendente</span>";
                                                                    break;
                                                                case 2:
                                                                    echo "<span class='badge badge-primary'>Atendido Parcial</span>";
                                                                    break;
                                                                case 3:
                                                                    echo "<span class='badge badge-success'>Atendido Total</span>";
                                                                    break;
                                                            } 

                                                        }                                                        
                                                    ?>
                                                </td>
                                                <td class="text-center"><a
                                                        href="<?= base_url("vendas/atendimento-pedido/novo-atendimento-pedido/{$pedido->seq_produto_venda}") ?>"
                                                        type="button"
                                                        class="btn btn-outline-primary btn-sm">Atendimento</a>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <?php if ($lista_pedido == false) { ?>
                                    <div class="text-center">
                                        <p>Nenhum pedido de venda encontrado</p>
                                    </div>
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
        </div>
    </div>
</section>

<script>
$('.page-item>a').addClass("page-link");

$("[name='excluir_todos[]']").click(function() {
    var cont = $("[name='excluir_todos[]']:checked").length;
    $("#btnExcluir").prop("disabled", cont ? false : true);
});
</script>

<?php $this->load->view('gerais/footer'); ?>