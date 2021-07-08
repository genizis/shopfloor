<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active">Recebimento de Material</li>
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
                            </div>
                            <div class="col-md-3">
                                <form action="<?= base_url('compras/recebimento-material') ?>" method="GET" class="needs-validation" novalidate>
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
                                                <th scope="col" class="text-center">Ped Compra</th>
                                                <th scope="col">Fornecedor</th>
                                                <th scope="col" class="text-center">Data Emissão</th>
                                                <th scope="col" class="text-center">Data Entrega</th>
                                                <th scope="col" class="text-center">Valor Total</th>
                                                <th scope="col" class="text-center">Status</th>
                                                <th scope="col" class="text-center">#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($lista_pedido as $key_pedido => $pedido) { ?>
                                            <tr>
                                                <td class="text-center"><a target="_blank"
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
                                                            echo "<span class='badge badge-danger'>Atrasada</span>";
                                                        }elseif($pedido->valor_total == 0){
                                                            echo "<span class='badge badge-secondary'>Em digitação</span>";
                                                        }elseif($pedido->quant_pendente == 0){
                                                            echo "<span class='badge badge-teal'>Atendido Total</span>";
                                                        }elseif($pedido->quant_pendente != 0){
                                                            echo "<span class='badge badge-info'>Pendente</span>";
                                                        }                                                        
                                                    ?>
                                                </td>
                                                <td class="text-center"><a
                                                        href="<?= base_url("compras/recebimento-material/novo-recebimento-material/{$pedido->num_pedido_compra}") ?>"
                                                        type="button"
                                                        class="btn btn-outline-primary btn-sm">Receber Material</a>
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
</script>

<?php $this->load->view('gerais/footer'); ?>