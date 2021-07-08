<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active">Reporte de Produção</li>
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
                                <form action="<?= base_url('producao/reporte-producao') ?>" method="GET" class=" needs-validation" novalidate>
                                    <div class="input-group">
                                        <input type="text" class="form-control search" name="buscar" value="<?= $filter ?>">
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
                                                <th scope="col" class="text-center">Ord Prod</th>
                                                <th scope="col">Produto de Produção</th>
                                                <th scope="col" class="text-center">Un</th>
                                                <th scope="col" class="text-center">Qtde Planejada</th>
                                                <th scope="col" class="text-center">Qtde Produzida</th>
                                                <th scope="col" class="text-center">Data Fim</th>
                                                <th scope="col" class="text-center">Status</th>
                                                <th scope="col" class="text-center">#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($lista_ordem as $key_ordem => $ordem) { ?>
                                            <tr>
                                                <td scope="row" class="text-center"><a target="_blank"
                                                        href="<?= base_url("producao/ordem-producao/editar-ordem-producao/{$ordem->num_ordem_producao}") ?>"><?= $ordem->num_ordem_producao ?></a>
                                                </td>
                                                <td class="limit-text-50" data-toggle="tooltip" data-placement="bottom" 
                                                    title="<?= $ordem->cod_produto ?> - <?= $ordem->nome_produto ?>"><?= $ordem->cod_produto ?> - <?= $ordem->nome_produto ?></td>
                                                <td class="text-center"><?= $ordem->cod_unidade_medida ?></td>
                                                <td class="text-center">
                                                    <?= number_format($ordem->quant_planejada, 3, ',', '.') ?></td>
                                                <td class="text-center">
                                                    <?= number_format($ordem->quant_produzida, 3, ',', '.') ?></td>
                                                <td class="text-center">
                                                    <?= str_replace('-', '/', date("d-m-Y", strtotime($ordem->data_fim))) ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                        if($ordem->data_fim < date('Y-m-d') && $ordem->status != 3 && $ordem->status != 4 && $ordem->quant_produzida == 0){
                                                            echo "<span class='badge badge-danger'>Atrasada</span>";

                                                        }else{
                                                            switch ($ordem->status) {
                                                                case 1:
                                                                    echo "<span class='badge badge-secondary'>Pendente</span>";
                                                                    break;
                                                                case 2:
                                                                    echo "<span class='badge badge-info'>Produzido Parcial</span>";
                                                                    break;
                                                                case 3:
                                                                    echo "<span class='badge badge-teal'>Produzido Total</span>";
                                                                    break;
                                                                case 4:
                                                                    echo "<span class='badge badge-dark'>Estornado</span>";
                                                                    break;
                                                            } 

                                                        }                                                        
                                                    ?>
                                                </td>
                                                <td class="text-center"><a
                                                        href="<?= base_url("producao/reporte-producao/novo-reporte-producao/{$ordem->num_ordem_producao}") ?>"
                                                        type="button"
                                                        class="btn btn-outline-primary btn-sm">Reportar Produção</a>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <?php if ($lista_ordem == false) { ?>
                                    <div class="text-center">
                                        <p class="text-muted mb-0">Nenhuma ordem de produção encontrada</p>
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