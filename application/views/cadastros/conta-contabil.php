<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active">Conta Contábil</li>
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
                                <a href="<?php echo base_url() ?>conta-contabil/nova-conta-contabil" type="button"
                                    class="btn btn-info"><i class="fas fa-plus-circle"></i> Nova Conta Contábil</a>
                                <button data-toggle="modal" data-target="#elimina-conta-contabil" type="button"
                                    class="btn btn-danger" id="btnExcluir" disabled><i class="fas fa-trash-alt"></i> Excluir</button>
                            </div>
                            <div class="col-md-3">
                                <form action="<?= base_url('conta-contabil') ?>" method="GET" class="needs-validation" novalidate>
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
                                <form class="mb-0"
                                    action="<?= base_url('conta-contabil/excluir-conta-contabil') ?>" method="POST"
                                    id="formDelete" class="mb-0 needs-validation" novalidate>
                                    <table class="table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col" class="text-center">#</th>
                                                <th scope="col">Código</th>
                                                <th scope="col">Nome da Conta Contábil</th>
                                                <th scope="col" class="text-center">Ativo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($lista_conta_contabil as $key_conta_contabil => $conta_contabil) { ?>
                                            <tr>
                                                <td>
                                                    <div class="checkbox text-center">
                                                        <input name="excluir_todos[]" type="checkbox"
                                                        <?php if($conta_contabil->count_mov > 0 || $conta_contabil->count_filho > 0) echo "disabled"; ?>
                                                            value="<?= $conta_contabil->cod_conta_contabil ?>" />
                                                    </div>
                                                </td>
                                                <td scope="row"><a
                                                        href="<?= base_url("conta-contabil/editar-conta-contabil/{$conta_contabil->cod_conta_contabil}") ?>"><?= $conta_contabil->cod_conta_contabil ?></a>
                                                </td>
                                                <td scope="row"><?= $conta_contabil->nome_conta_contabil ?></td>
                                                <td class="text-center">
                                                    <?php if($conta_contabil->ativo == 1) {
                                                            echo "<span class='badge badge-teal'>Ativo</span>";
                                                        }else{
                                                            echo "<span class='badge badge-secondary'>Inativo</span>";
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <?php if ($lista_conta_contabil == false) { ?>
                                    <div class="text-center">
                                        <p class="text-muted mb-0">Nenhuma conta contábil encontrada</p>
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

<div class="modal fade" id="elimina-conta-contabil" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Conta Contábil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirma eliminação do(s) conta(s) de contábil(eis) selecionada(s)?
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