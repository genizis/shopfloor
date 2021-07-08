<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active">Faturamento de Pedido</li>
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
                            <div class="col-md-9"></div>
                            <div class="col-md-3">
                                <form action="<?= base_url('vendas/faturamento-pedido') ?>" method="GET" class=" needs-validation" novalidate>
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
                                                <th scope="col" class="text-center">Ped Venda</th>
                                                <th scope="col">Nome do Cliente</th>
                                                <th scope="col" class="text-center">Data de Emissão</th>
                                                <th scope="col" class="text-center">Data de Entrega</th>
                                                <th scope="col" class="text-center">Total do Pedido</th>
                                                <th scope="col" class="text-center">Total Faturado</th>
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
                                                <td class="text-center">
                                                    <?= str_replace('-', '/', date("d-m-Y", strtotime($pedido->data_emissao))) ?>
                                                </td>
                                                <td class="text-center">
                                                    <?= str_replace('-', '/', date("d-m-Y", strtotime($pedido->data_entrega))) ?>
                                                </td>
                                                <td class="text-center">R$
                                                <?php 
                                                    if($pedido->valor_desconto != 0){
                                                        if($pedido->tipo_desconto == 1){
                                                            echo number_format($pedido->valor_total_pedido - $pedido->valor_desconto, 2, ',', '.');
                                                        }elseif($pedido->tipo_desconto == 2){
                                                            echo number_format($pedido->valor_total_pedido - ($pedido->valor_total_pedido * ($pedido->valor_desconto / 100)), 2, ',', '.');
                                                        }
                                                    }else{
                                                        echo number_format($pedido->valor_total_pedido, 2, ',', '.');
                                                    }
                                                ?>
                                                </td>
                                                <td class="text-center">R$ <?=  number_format($pedido->valor_total_faturado - $pedido->total_desconto, 2, ',', '.') ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                        if($pedido->data_entrega < date('Y-m-d') && $ped_status[$pedido->num_pedido_venda] != 3 && $ped_status[$pedido->num_pedido_venda] != 4){
                                                            echo "<span class='badge badge-danger'>Atrasado</span>";

                                                        }else{
                                                            switch ($ped_status[$pedido->num_pedido_venda]) {
                                                                case 1:
                                                                    echo "<span class='badge badge-secondary'>Pendente</span>";
                                                                    break;
                                                                case 2:
                                                                    echo "<span class='badge badge-info'>Atendido Parcial</span>";
                                                                    break;
                                                                case 3:
                                                                    echo "<span class='badge badge-teal'>Atendido Total</span>";
                                                                    break;
                                                                case 4:
                                                                    echo "<span class='badge badge-dark'>Estornado</span>";
                                                                    break;
                                                            } 

                                                        }                                                        
                                                    ?>
                                                </td>
                                                <td class="text-center"><a
                                                        href="<?= base_url("vendas/faturamento-pedido/novo-faturamento-pedido/{$pedido->num_pedido_venda}") ?>"
                                                        type="button"
                                                        class="btn btn-outline-primary btn-sm">Faturar Pedido</a>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <?php if ($lista_pedido == false) { ?>
                                    <div class="text-center">
                                        <p class="text-muted mb-0">Nenhum pedido de venda encontrado</p>
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