<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active"><a href="<?php echo base_url() ?>estoque/requisicao-material">Requisição de Material</a></li>
            <li class="breadcrumb-item active">Editar Requisição de Material</a></li>
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
                                <form action="<?= base_url("estoque/requisicao-material/editar-requisicao-material/{$requisicao->cod_requisicao_material}") ?>" method="POST" id="RequisicaoMaterial" class="mb-0 needs-validation" novalidate>
                                    <div class="form-row"> 
                                        <div class="form-group col-md-4">
                                            <label for="inputCodRequisicaoMaterial">Código da Requisição de Material</label>
                                            <input type="text" class="form-control" id="inputCodRequisicaoMaterial"
                                                name="CodRequisicaoEstoque" 
                                                value="<?= $requisicao->cod_requisicao_material ?>" readonly>
                                        </div>                                      
                                        <div class="form-group col-md-4">
                                            <label for="inputDataEmissao">Data de Emissão</label>
                                            <input type="text" class="form-control" id="inputDataEmissao"
                                                name="DataEmissao" readonly
                                                value="<?= str_replace('-', '/', date("d-m-Y", strtotime($requisicao->data_emissao))) ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputDataRequisicao">Data da Requisição <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputDataRequisicao" <?php if($requisicao->status == 2){ echo "readonly"; } ?>
                                                name="DataRequisicao" value="<?= str_replace('-', '/', date("d-m-Y", strtotime($requisicao->data_requisicao))) ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputObservacao">Observações da Requisição de Material</label>
                                            <textarea class="form-control" rows="3" id="inputObservacao" <?php if($requisicao->status == 2){ echo "readonly"; } ?>
                                                name="ObsRequisicaoMaterial"><?= $requisicao->observacoes ?></textarea>
                                        </div>
                                    </div>
                                </form>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6>Produtos da Requisição</h6>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-xs-12">
                                                <button data-toggle="modal" data-target="#adicionar-produto" type="button" <?php if($requisicao->status == 2){ echo "disabled"; } ?>
                                                        class="btn btn-outline-primary btn-sm"><i class="fas fa-check-circle"></i> Adicionar Produto</button>
                                                <button data-toggle="modal" data-target="#elimina-produto" type="button"
                                                        class="btn btn-outline-danger btn-sm" id="btnExcluir" disabled><i
                                                            class="fas fa-trash-alt"></i>
                                                        Excluir</button>
                                            </div>
                                        </div>
                                        <form action="<?= base_url("estoque/requisicao-material/excluir-produto/{$requisicao->cod_requisicao_material}") ?>"
                                                method="POST" id="DeleteProduto" class="needs-validation" novalidate>
                                            <table class="table table-bordered table-hover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th scope="col" class="text-center">#</th>
                                                        <th scope="col" class="text-center">Código</th>
                                                        <th scope="col">Produto da Requisição</th>                                                        
                                                        <th scope="col">Tipo do Produto</th>  
                                                        <th scope="col" class="text-center">Un</th>                                                    
                                                        <th scope="col" class="text-center">Quant Requisição</th>
                                                    </tr>
                                                </thead>
                                                <tbody> 
                                                    <?php foreach($lista_produto as $key_produto => $produto) { ?>
                                                    <tr>
                                                        <td>
                                                            <div class="checkbox text-center">
                                                                <input name="excluir_todos[]" type="checkbox"
                                                                        value="<?= $produto->seq_produto_requisicao_material ?>" 
                                                                <?php if($requisicao->status == 2){ echo "disabled"; } ?>/>
                                                            </div>
                                                        </td>
                                                        <td scope="row"  class="text-center">
                                                            <a href="#" data-toggle="modal"
                                                                        data-target="#editar-produto<?= $produto->seq_produto_requisicao_material ?>">
                                                                <?= $produto->cod_produto ?>
                                                            </a>
                                                        </td>
                                                        <td><?= $produto->nome_produto ?></td>
                                                        <td><?= $produto->nome_tipo_produto ?></td>
                                                        <td class="text-center"><?= $produto->cod_unidade_medida ?></td>                                                              
                                                        <td class="text-center"><?= number_format($produto->quant_requisicao, 3, ',', '.') ?></td>                                   
                                                    </tr>
                                                    <?php } ?>                                                    
                                                </tbody>
                                            </table>
                                            <?php if ($lista_produto == false) { ?>
                                            <div class="text-center">
                                                <p>Nenhum produto de requisição adicionadoo</p>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>                                    
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="btn btn-outline-teal" <?php if($requisicao->status == 2 || $lista_produto == false){ echo "disabled"; } ?>
                                            data-toggle="modal" data-target="#atende-requisicao" type="button"><i class="fas fa-check"></i> Atender Requisição</button>
                                            <button class="btn btn-outline-danger" <?php if($requisicao->status == 1){ echo "disabled"; } ?>
                                            data-toggle="modal" data-target="#estorna-requisicao" type="button"><i class="fas fa-undo"></i> Estornar Requisição</button>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row float-right">
                                                <div class="col-md-12">
                                                    <button type="submit" form="RequisicaoMaterial" class="btn btn-primary"
                                                        name="Opcao" value="salvar" <?php if($requisicao->status == 2){ echo "disabled"; } ?>><i class="fas fa-save"></i> Salvar</button>                                            
                                                    <a href="<?php echo base_url() ?>estoque/requisicao-material"
                                                        class="btn btn-secondary">Cancelar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="adicionar-produto">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Produto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form class="mb-0 needs-validation" novalidate
                            action="<?= base_url("estoque/requisicao-material/adicionar-produto/{$requisicao->cod_requisicao_material}") ?>" 
                            method="post" id='formAdicionarProduto'>
                            <div class="form-row">                                        
                                <div class="form-group col-md-12">
                                    <label for="inputProdutoRequisicao">Produto de Requisição <span class="text-danger">*</span></label>
                                    <select id="inputProdutoRequisicao" class="selectpicker show-tick form-control"
                                        data-live-search="true" data-actions-box="true" data-style="btn-input-primary"
                                        title="Selecione um Produto" name="CodProduto" required>
                                        <?php foreach($lista_produto_req as $key_produto_req => $produto_req) { ?>
                                        <option value="<?= $produto_req->cod_produto ?>"
                                        <?php if($produto_req->cod_produto == set_value('CodProduto')) echo "selected"; ?>>
                                            <?= $produto_req->cod_produto ?> -
                                            <?= $produto_req->nome_produto ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">                                        
                                <div class="form-group col-md-4">
                                    <label for="inputTipoProduto">Tipo de Produto</label>
                                    <input type="text" class="form-control" id="inputTipoProduto"
                                        readonly name="TipoProduto" value="<?= set_value('TipoProduto'); ?>">
                                </div>                                    
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="inputUnidadeMedida">Unidade de
                                        Medida</label>
                                    <input class="form-control" id="inputUnidadeMedida" type="text"
                                        readonly name="UnidadeMedida" value="<?= set_value('UnidadeMedida'); ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="inputQuantRequisicao">Quantidade Requisição <span class="text-danger">*</span></label>
                                    <input class="form-control" id="inputQuantRequisicao" type="text" data-mask="#.##0,000" data-mask-reverse="true"
                                        name="QuantRequisicao" value="<?= set_value('QuantRequisicao'); ?>" required>
                                </div>                                      
                            </div> 
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="formAdicionarProduto"><i class="fas fa-check-circle"></i> Adicionar Produto</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<?php foreach($lista_produto as $key_produto => $produto) { ?>
<div class="modal fade" id="editar-produto<?= $produto->seq_produto_requisicao_material ?>">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Produto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form class="mb-0 needs-validation" novalidate
                            action="<?= base_url("estoque/requisicao-material/editar-produto/{$requisicao->cod_requisicao_material}/{$produto->seq_produto_requisicao_material}") ?>"
                            method='post' id='formEditarProduto<?= $produto->seq_produto_requisicao_material ?>'>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="control-label" for="inputProdutoCompraEdit">Produto de Compra</label>
                                    <input class="form-control" id="inputProdutoCompraEdit" type="text"
                                        name="CodProdutoEdit" value="<?= $produto->cod_produto ?> - <?= $produto->nome_produto ?>" readonly>
                                </div>                                
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="inputTipoProdutoEdit">Tipo de Produto</label>
                                    <input class="form-control" id="inputTipoProdutoEdit" type="text"
                                        name="TipoProdutoEdit" value="<?= $produto->nome_tipo_produto ?>" readonly>
                                </div> 
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="inputUnidadeMedidaEdit">Unidade de Medida</label>
                                    <input class="form-control" id="inputUnidadeMedidaEdit" type="text"
                                        name="UnidadeMedidaEdit" value="<?= $produto->cod_unidade_medida ?>" readonly>
                                </div>                                                              
                                <div class="form-group col-md-4">
                                    <label for="inputQuantRequisicaoEdit">Quantidade Requisição <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="<?= $produto->quant_requisicao ?>" data-mask="#.##0,000" data-mask-reverse="true"
                                        id="inputQuantRequisicaoEdit" name="QuantRequisicaoEdit" <?php if($requisicao->status == 2){ echo "readonly"; } ?> required>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="formEditarProduto<?= $produto->seq_produto_requisicao_material ?>"
                <?php if($requisicao->status == 2){ echo "disabled"; } ?>><i class="fas fa-save"></i>
                    Salvar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<?php } ?>

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
                Confirma eliminação do(s) produto(s) da requisição selecionado(s)?
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="DeleteProduto">Confirma</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="atende-requisicao" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Atender Requisição</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirma atendimento da requisição de material?
            </div>
            <div class="modal-footer">
                <form class="mb-0 needs-validation" novalidate
                      action="<?= base_url("estoque/requisicao-material/atender-requisicao/{$requisicao->cod_requisicao_material}") ?>"
                      method='post'>                
                    <button type="submit" class="btn btn-primary">Confirma</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="estorna-requisicao" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Estornar Requisição</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirma estorno da requisição de material?
            </div>
            <div class="modal-footer">
                <form class="mb-0 needs-validation" novalidate
                      action="<?= base_url("estoque/requisicao-material/estorno-requisicao/{$requisicao->cod_requisicao_material}") ?>"
                      method='post'>                
                    <button type="submit" class="btn btn-primary">Confirma</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

$(function() {
     $.applyDataMask();
});

$("[name='excluir_todos[]']").click(function() {
    var cont = $("[name='excluir_todos[]']:checked").length;
    $("#btnExcluir").prop("disabled", cont ? false : true);
});

$("#inputProdutoRequisicao").change(function() {

    var baseurl = "<?php echo base_url(); ?>";

    var produto = $("#inputProdutoRequisicao").val();

    $.post(baseurl + "ajax/busca-produto", {
        produto: produto
    }, function(valor) {
        var aValor = valor.split('|');
        console.log(aValor);
        $("#inputUnidadeMedida").val(aValor[0]);
        $("#inputTipoProduto").val(aValor[1]);
        $("#inputValorUnitario").val(aValor[2]);
    });

});

<?php if($requisicao->status != 2){ ?>

    $('#inputDataRequisicao').datepicker({
        uiLibrary: 'bootstrap4'
    });

<?php } ?>

</script>

<?php $this->load->view('gerais/footer'); ?>