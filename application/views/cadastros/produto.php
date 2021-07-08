<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active">Produto</li>
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
                                <a href="<?php echo base_url() ?>produto/novo-produto" type="button"
                                    class="btn btn-info"><i class="fas fa-plus-circle"></i> Novo Produto</a>
                                <button data-toggle="modal" data-target="#elimina-produto" type="button"
                                    class="btn btn-danger" disabled id="btnExcluir"><i class="fas fa-trash-alt"></i> Excluir</button>
                            </div>
                            <div class="col-md-3">
                                <form action="<?= base_url('produto') ?>" method="GET" class="needs-validation" novalidate>
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
                                <form action="<?= base_url('produto/excluir-produto') ?>" method="POST" id="formDelete" class="mb-0 needs-validation" novalidate>
                                    <table class="table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col" class="text-center">#</th>
                                                <th scope="col" class="text-center">Código Produto</th>
                                                <th scope="col">Nome Produto</th>
                                                
                                                <th scope="col">Tipo de Produto</th>
                                                <th scope="col" class="text-center">Unid Medida</th>
                                                <th scope="col" class="text-center">Custo Médio</th>
                                                <th scope="col" class="text-center">Quant Estoque</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($lista_produto as $key_produto => $produto) { ?>
                                            <tr>
                                                <td>
                                                    <div class="checkbox text-center">
                                                        <input name="excluir_todos[]" type="checkbox"
                                                            value="<?= $produto->cod_produto ?>" />
                                                    </div>
                                                </td>
                                                <td scope="row" class="text-center"><a
                                                        href="<?= base_url("produto/editar-produto/{$produto->cod_produto}") ?>"><?= $produto->cod_produto ?></a>
                                                </td>
                                                <td><?= $produto->nome_produto ?></td>                                                
                                                <td><?= $produto->nome_tipo_produto ?></td>
                                                <td class="text-center"><?= $produto->cod_unidade_medida ?></td>
                                                <td
                                                    class="text-center">
                                                    R$ <?= number_format($produto->custo_medio, 2, ',', '.') ?></td>
                                                <td
                                                    class="text-center <?php if($produto->quant_estoq < 0) echo "text-danger" ?>">
                                                    <?= number_format($produto->quant_estoq, 3, ',', '.') ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <?php if ($lista_produto == false) { ?>
                                    <div class="text-center">
                                        <p class="text-muted mb-0">Nenhum produto encontrado</p>
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
                <h5 class="modal-title">Eliminar Produto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirma eliminação do(s) produto(s) selecionado(s)?
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="formDelete">Confirma</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="importa-conta-azul" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Importar Produto Conta Azul</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirma importação do(s) produto(s) do Conta Azul?
            </div>
            <div class="modal-footer">
                <a href="produto/importa-produto-conta-azul" class="btn btn-primary">Confirma</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exporta-conta-azul" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Exporta Produto Conta Azul</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirma exportação do(s) produto(s) do Conta Azul?
            </div>
            <div class="modal-footer">
                <a href="produto/exporta-produto-conta-azul" class="btn btn-primary">Confirma</a>
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