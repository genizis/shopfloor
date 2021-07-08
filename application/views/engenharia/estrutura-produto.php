<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active">Estrutura de Produto</li>
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
                                <a href="<?php echo base_url() ?>estrutura-produto/nova-estrutura-produto" type="button"
                                    class="btn btn-info"><i class="fas fa-plus-circle"></i> Nova Estrutura de
                                    Produto</a>
                                <button data-toggle="modal" data-target="#elimina-produto" type="button"
                                    class="btn btn-danger" id="btnExcluir" disabled><i class="fas fa-trash-alt"></i> Excluir</button>
                            </div>
                            <div class="col-md-3">
                                <form action="<?= base_url('estrutura-produto') ?>" method="GET" class="needs-validation" novalidate>
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
                                <form action="<?= base_url('estrutura-produto/excluir-estrutura-produto') ?>"
                                    method="POST" id="formDelete" class="mb-0 needs-validation" novalidate>
                                    <table class="table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col" class="text-center">#</th>
                                                <th scope="col" class="text-center">Código Produto</th>
                                                <th scope="col">Nome do Produto</th>                                                
                                                <th scope="col">Tipo do Produto</th>
                                                <th scope="col" class="text-center">Unid Medida</th>
                                                <th scope="col" class="text-center">Quant Produção</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($lista_estrutura as $key_estrutura => $estrutura) { ?>
                                            <tr>
                                                <td>
                                                    <div class="checkbox text-center">
                                                        <input name="excluir_todos[]" type="checkbox"
                                                            value="<?= $estrutura->cod_produto ?>"
                                                            <?php if($estrutura->cont_componente != 0) echo "disabled"; ?> />
                                                    </div>
                                                </td>
                                                <td scope="row" class="text-center"><a
                                                    href="<?= base_url("estrutura-produto/editar-estrutura-produto/{$estrutura->cod_produto}") ?>"><?= $estrutura->cod_produto ?></a>
                                                </td>
                                                <td><?= $estrutura->nome_produto ?></td>                                                
                                                <td><?= $estrutura->nome_tipo_produto ?></td>
                                                <td class="text-center"><?= $estrutura->cod_unidade_medida ?></td>
                                                <td class="text-center"><?= number_format($estrutura->quant_producao, 3, ',', '.') ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <?php if ($lista_estrutura == false) { ?>
                                    <div class="text-center">
                                        <p class="text-muted mb-0">Nenhuma estrutura de produto encontrada</p>
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

<div class="modal fade" id="elimina-produto" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Estrutura</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirma eliminação da(s) estrutura(s) selecionada(s)?
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="formDelete">Confirma</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
$("[name='excluir_todos[]']").click(function() {
    var cont = $("[name='excluir_todos[]']:checked").length;
    $("#btnExcluir").prop("disabled", cont ? false : true);
});

$('.page-item>a').addClass("page-link");
</script>

<?php $this->load->view('gerais/footer'); ?>