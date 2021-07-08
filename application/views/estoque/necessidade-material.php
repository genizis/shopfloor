<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active">Necessidade de Material</li>
        </ol>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <a href="<?php echo base_url() ?>estoque/necessidade-material/novo-calculo-necessidade"
                                    type="button" class="btn btn-info"><i class="fas fa-plus-circle"></i> Novo Cálculo de Necessidade</a>
                                <button data-toggle="modal" data-target="#elimina-calculo" type="button"
                                    class="btn btn-danger"id="btnExcluir" disabled><i class="fas fa-trash-alt"></i> Excluir</button>
                            </div>
                            <div class="col-md-3">
                                <form action="<?= base_url('estoque/necessidade-material') ?>" method="GET" class=" needs-validation" novalidate>
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
                                <form action="<?= base_url('estoque/necessidade-material/excluir-calculo') ?>"
                                    method="POST" id="formDelete" class="mb-0 needs-validation" novalidate>
                                    <table class="table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col" class="text-center">#</th>
                                                <th scope="col" class="text-center">Código do Cálculo</th>
                                                <th scope="col" class="text-center">Data Início</th>
                                                <th scope="col" class="text-center">Data Fim</th>
                                                <th scope="col" class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($lista_calculo as $key_calculo => $calculo) { ?>
                                            <tr>
                                                <td>
                                                    <div class="checkbox text-center">
                                                        <input name="excluir_todos[]" type="checkbox"
                                                            <?php if($calculo->status != 1) echo "disabled"; ?>
                                                            value="<?= $calculo->cod_calculo_necessidade ?>" />
                                                    </div>
                                                </td>
                                                <td scope="row" class="text-center"><a
                                                        href="<?= base_url("estoque/necessidade-material/editar-calculo-necessidade/{$calculo->cod_calculo_necessidade}") ?>"><?= $calculo->cod_calculo_necessidade?></a>
                                                </td>
                                                <td class="text-center">
                                                    <?= str_replace('-', '/', date("d-m-Y", strtotime($calculo->data_inicio))) ?>
                                                </td>
                                                <td class="text-center">
                                                    <?= str_replace('-', '/', date("d-m-Y", strtotime($calculo->data_fim))) ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                        switch ($calculo->status) {
                                                            case 1:
                                                                echo "<span class='badge badge-secondary'>Em Planejamento</span>";
                                                                break;
                                                            case 2:
                                                                echo "<span class='badge badge-info'>Calculado</span>";
                                                                break;
                                                            case 3:
                                                                echo "<span class='badge badge-teal'>Efetivado</span>";
                                                                break;
                                                            case 4:
                                                                echo "<span class='badge badge-dark'>Estornado</span>";
                                                                break;
                                                        }                                                        
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <?php if($lista_calculo == false) { ?>
                                    <div class="text-center">
                                        <p class="text-muted mb-0">Nenhuma cálculo de necessidade de material encontrado</p>
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

<?php $this->load->view('gerais/footer'); ?>