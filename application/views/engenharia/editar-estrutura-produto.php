<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url() ?>estrutura-produto">Estrutura de Produto</a>
            </li>
            <li class="breadcrumb-item active">Editar Estrutura de Produto</li>
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
                                <form action="<?= base_url("estrutura-produto/editar-estrutura-produto/{$estrutura->cod_produto}") ?>" method="POST"
                                    id="EstruturaProd" class="needs-validation" novalidate> 
                                    <div class="form-row">
                                        <div class="form-group col-md-9">
                                            <label class="control-label" for="inputCodProduto">Produto de Produção</label>
                                            <input class="form-control" id="inputCodProduto" type="text" readonly
                                                value="<?= $estrutura->cod_produto?> - <?= $estrutura->nome_produto ?>" name="CodProduto">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label" for="inputUn">Unidade de Medida</label>
                                            <input class="form-control" id="inputUn" type="text" readonly
                                                value="<?= $estrutura->cod_unidade_medida ?>">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label class="control-label" for="inputTipoProduto">Tipo de Produto</label>
                                            <input class="form-control" id="inputTipoProduto" type="text" readonly
                                                value="<?= $estrutura->nome_tipo_produto ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputQuantProducao">Quantidade de Produção <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputQuantProducao"
                                                data-mask="#.##0,000" data-mask-reverse="true"
                                                value="<?= $estrutura->quant_producao ?>" name="QuantProducao" required>
                                        </div>
                                    </div>
                                </form>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6>Lista de Materiais</h6>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-xs-12 mb-0">
                                                <button data-toggle="modal" data-target="#inserir-componente" type="button"
                                                    class="btn btn-outline-info btn-sm"><i class="fas fa-plus-circle"></i> Novo
                                                    Componente</button>
                                                <button data-toggle="modal" data-target="#elimina-componente" type="button"
                                                    class="btn btn-outline-danger btn-sm" id="excluirComponente" disabled><i
                                                        class="fas fa-trash-alt"></i>
                                                    Excluir</button>
                                            </div>
                                        </div>
                                        <form action="<?= base_url('estrutura-produto/excluir-estrutura-componente') ?>" method="POST"
                                                id="DeleteComponente" class="needs-validation" novalidate>
                                            <input type="hidden" name="CodProdudoProd" value="<?= $estrutura->cod_produto ?>">
                                            <table class="table table-bordered table-hover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th scope="col" class="text-center">#</th>
                                                        <th scope="col" class="text-center">Componente</th>
                                                        <th scope="col">Nome do Produto</th>
                                                        <th scope="col" class="text-center">Un</th>
                                                        <th scope="col">Tipo de Produto</th>
                                                        <th scope="col" class="text-center">Quantidade de Consumo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($lista_componente as $key_componente => $componente) { ?>
                                                    <tr>
                                                        <td>
                                                            <div class="checkbox text-center">
                                                                <input name="excluir_todos[]" type="checkbox"
                                                                    value="<?= $componente->seq_estrutura_componente ?>" />
                                                            </div>
                                                        </td>
                                                        <td class="text-center"><a
                                                                href="#" 
                                                                data-toggle="modal" data-target="#editar-componente<?= $componente->seq_estrutura_componente ?>">
                                                                    <?= $componente->cod_produto_componente ?>
                                                                </a>
                                                        </td>
                                                        <td><?= $componente->nome_produto ?></td>
                                                        <td class="text-center"><?= $componente->cod_unidade_medida ?></td>
                                                        <td><?= $componente->nome_tipo_produto ?></td>
                                                        <td class="text-center"><?= number_format($componente->quant_consumo, 3, ',', '.') ?></td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            <?php if ($lista_componente == false) { ?>
                                            <div class="text-center">
                                                <p>Nenhum produto adicionado</p>
                                            </div>
                                            <?php } ?>
                                        </form>
                                    </div>
                                </div>                                
                                <hr>
                                <div class="row float-right">
                                    <div class="col-lg-12 col-md-12 col-xs-12">
                                        <button type="submit" form="EstruturaProd" class="btn btn-primary" name="Opcao"
                                            value="salvar"><i class="fas fa-save"></i> Salvar</button>
                                        <a href="<?php echo base_url() ?>estrutura-produto" class="btn btn-secondary">Cancelar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="elimina-componente" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Componente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirma eliminação do(s) componente(s) selecionado(s)?
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="DeleteComponente">Confirma</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="inserir-componente">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Novo Componente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <form action="<?= base_url('estrutura-produto/inserir-estrutura-componente') ?>" method='post'
                            id='formComponente' class="needs-validation" novalidate>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <input type="hidden" name="CodProdudoProd" value="<?= $estrutura->cod_produto ?>">
                                    <label for="inputProdutoCons">Componente de Produção <span class="text-danger">*</span></label>
                                    <select id="inputProdutoCons" class="selectpicker show-tick form-control" data-style="btn-input-primary"
                                        data-live-search="true" data-actions-box="true" title="Selecione um Produto"
                                        name="CodProdutoCons" required>
                                        <?php foreach($lista_produto_cons as $key_produto_cons => $produto_cons) { ?>
                                        <option value="<?= $produto_cons->cod_produto ?>"
                                        <?php if($produto_cons->cod_produto == set_value('CodProdutoCons')) echo "selected"; ?>>
                                            <?= $produto_cons->cod_produto ?> - <?= $produto_cons->nome_produto ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>                                
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputUnCons">Unidade de Medida</label>
                                    <input type="text" id="inputUnCons" class="form-control" name="UnidadeMedidaCons"
                                        readonly="" value="<?= set_value('UnidadeMedidaCons'); ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputTipoProdutoCons">Tipo do Produto</label>
                                    <input type="text" id="inputTipoProdutoCons" class="form-control" name="TipoProdutoCons"
                                        readonly value="<?= set_value('TipoProdutoCons'); ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputQuantConsumo">Quantidade de Consumo <span class="text-danger">*</span></label>
                                    <input type="text" id="inputQuantConsumo" class="form-control" data-mask="#.##0,000" data-mask-reverse="true"
                                        name="QuantConsumo" value="<?= set_value('QuantConsumo') ?>" required>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="formComponente"><i class="fas fa-save"></i>
                    Salvar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<?php foreach($lista_componente as $key_componente => $componente) { ?>
<div class="modal fade" id="editar-componente<?= $componente->seq_estrutura_componente ?>">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Componente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <form action="<?= base_url("estrutura-produto/salvar-estrutura-componente/{$estrutura->cod_produto}/{$componente->seq_estrutura_componente}") ?>" method='post'
                            id='formComponenteEdit<?= $componente->seq_estrutura_componente ?>' class="needs-validation" novalidate>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputProdutoConsEdit">Componente de Produção</label>
                                    <input type="text" id="inputProdutoConsEdit" class="form-control"
                                        value="<?= $componente->cod_produto_componente ?> - <?= $componente->nome_produto ?>" readonly>
                                </div>                                
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputUnConsEdit">Unidade de Medida</label>
                                    <input type="text" id="inputUnConsEdit" class="form-control"
                                        value="<?= $componente->cod_unidade_medida ?>" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputTipoProdutoConsEdit">Tipo do Produto</label>
                                    <input type="text" id="inputTipoProdutoConsEdit" class="form-control"
                                        value="<?= $componente->nome_tipo_produto ?>" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputQuantConsumoEdit">Quantidade de Consumo <span class="text-danger">*</span></label>
                                    <input type="text" id="inputQuantConsumoEdit" class="form-control" data-mask="#.##0,000" data-mask-reverse="true"
                                        name="QuantConsumoEdit" value="<?= number_format($componente->quant_consumo, 3, ',', '.') ?>" required>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="formComponenteEdit<?= $componente->seq_estrutura_componente ?>"><i class="fas fa-save"></i>
                    Salvar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<script>
$(function() {
     $.applyDataMask();
});

$("[name='excluir_todos[]']").click(function() {
    var cont = $("[name='excluir_todos[]']:checked").length;
    $("#excluirComponente").prop("disabled", cont ? false : true);
});

$("#inputProdutoCons").change(function() {

    var baseurl = "<?php echo base_url(); ?>";

    var produto = $("#inputProdutoCons").val();

    $.post(baseurl + "ajax/busca-produto", {
        produto: produto
    }, function(valor) {
        var aValor = valor.split('|');
        console.log(aValor);
        $("#inputUnCons").val(aValor[0]);
        $("#inputTipoProdutoCons").val(aValor[1]);
    });

});

</script>

<?php $this->load->view('gerais/footer'); ?>