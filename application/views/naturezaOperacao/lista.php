<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>



<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active">Ordem de Produção</li>
        </ol>
    </div>
</section>

<section>
    <div class="container" id="app">

        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <a href="<?php echo base_url() ?>natureza-operacao/nova"
                                    type="button" class="btn btn-info"><i class="fas fa-plus-circle"></i> Nova Ordem de
                                    Produção</a>
                                <button data-toggle="modal" data-target="#elimina-ordem" type="button"
                                    class="btn btn-danger"id="btnExcluir" disabled><i class="fas fa-trash-alt"></i> Excluir</button>
                            </div>
                            <div class="col-md-3">
                                <form action="<?= base_url('producao/ordem-producao') ?>" method="GET" class=" needs-validation" novalidate>
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
                                <form action="<?= base_url('producao/ordem-producao/excluir-ordem-producao') ?>"
                                    method="POST" id="formDelete" class="mb-0 needs-validation" novalidate>
                                    <table class="table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col" class="text-center">#</th>
                                                <th scope="col" class="text-center">Ord Produção</th>
                                                <th scope="col">Produto de Produção</th>
                                                <th scope="col" class="text-center">Unid Medida</th>
                                                <th scope="col" class="text-center">Qtde Planejada</th>
                                                <th scope="col" class="text-center">Qtde Produzida</th>
                                                <th scope="col" class="text-center">Data Fim</th>
                                                <th scope="col" class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($lista_ordem as $key_ordem => $ordem) { ?>
                                            <tr>
                                                <td>
                                                    <div class="checkbox text-center">
                                                        <input name="excluir_todos[]" type="checkbox"
                                                            <?php if($ordem->count_mov > 0) echo "disabled"; ?>
                                                            value="<?= $ordem->num_ordem_producao ?>" />
                                                    </div>
                                                </td>
                                                <td scope="row" class="text-center"><a
                                                        href="<?= base_url("producao/ordem-producao/editar-ordem-producao/{$ordem->num_ordem_producao}") ?>"><?= $ordem->num_ordem_producao?></a>
                                                </td>
                                                <td class="limit-text-70" data-toggle="tooltip" data-placement="bottom" 
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
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <?php if($lista_ordem == false) { ?>
                                    <div class="text-center">
                                        <p class="text-muted mb-0">Nenhuma ordem de produção encontrada</p>
                                    </div>
                                    <?php } ?>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
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
                <h5 class="modal-title">Eliminar Ordem de Produção</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirma eliminação da(s) ordem(s) de produção selecionada(s)?
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

<script src="<?= base_url('/assets/js/app.js'); ?>" type="text/javascript"></script>

<?php $this->load->view('gerais/footer'); ?>

