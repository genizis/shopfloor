<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active"><a href="<?php echo base_url() ?>estoque/inventario">Inventário</a></li>
            <li class="breadcrumb-item active">Editar Inventário</a></li>
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
                                <form action="<?= base_url("estoque/inventario/editar-inventario/{$inventario->num_inventario}") ?>" method="POST" id="Inventario" class="mb-0 needs-validation" novalidate>
                                    <div class="form-row"> 
                                        <div class="form-group col-md-4">
                                            <label for="inputNumInventario">Número do Inventário</label>
                                            <input type="text" class="form-control" id="inputNumInventario"
                                                name="NumInventario" 
                                                value="<?= $inventario->num_inventario ?>" readonly>
                                        </div>                                      
                                        <div class="form-group col-md-4">
                                            <label for="inputDataEmissao">Data de Emissão</label>
                                            <input type="text" class="form-control" id="inputDataEmissao"
                                                name="DataEmissao" readonly
                                                value="<?= str_replace('-', '/', date("d-m-Y", strtotime($inventario->data_emissao))) ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputDataExecucao">Data de Execução <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputDataExecucao" <?php if($inventario->status == 2){ echo "readonly"; } ?>
                                                name="DataExecucao" value="<?= str_replace('-', '/', date("d-m-Y", strtotime($inventario->data_execucao))) ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputObservacao">Observações do Inventário</label>
                                            <textarea class="form-control" rows="3" id="inputObservacao" <?php if($inventario->status == 2){ echo "readonly"; } ?>
                                                name="ObsInventario"><?= $inventario->observacoes ?></textarea>
                                        </div>
                                    </div>
                                </form>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6>Produtos Inventariados</h6>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-xs-12">
                                                <button data-toggle="modal" data-target="#adicionar-produto" type="button" <?php if($inventario->status == 2){ echo "disabled"; } ?>
                                                        class="btn btn-outline-primary btn-sm"><i class="fas fa-check-circle"></i> Adicionar Produto</button>
                                                <button data-toggle="modal" data-target="#elimina-produto" type="button"
                                                        class="btn btn-outline-danger btn-sm" id="btnExcluir" disabled><i
                                                            class="fas fa-trash-alt"></i>
                                                        Excluir</button>
                                            </div>
                                        </div>
                                        <form action="<?= base_url("estoque/inventario/excluir-produto/{$inventario->num_inventario}") ?>"
                                                method="POST" id="DeleteProduto" class="needs-validation" novalidate>
                                            <table class="table table-bordered table-hover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th scope="col" class="text-center">#</th>
                                                        <th scope="col" class="text-center">Código</th>
                                                        <th scope="col">Produto de Inventário</th>                                                        
                                                        <th scope="col">Tipo do Produto</th>  
                                                        <th scope="col" class="text-center">Un</th>                                                    
                                                        <th scope="col" class="text-center">Quant Contagem</th>
                                                        <th scope="col" class="text-center">Quant Estoque</th>
                                                        <th scope="col" class="text-center">Quant Acerto</th>
                                                    </tr>
                                                </thead>
                                                <tbody> 
                                                    <?php foreach($lista_produto as $key_produto => $produto) { 
                                                          if($inventario->status == 1){
                                                              $quantEstoq = $produto->quant_estoq;
                                                          }else{
                                                              $quantEstoq = $produto->quant_estoq_exec;
                                                          }?>
                                                    <tr>
                                                        <td>
                                                            <div class="checkbox text-center">
                                                                <input name="excluir_todos[]" type="checkbox"
                                                                        value="<?= $produto->seq_produto_inventario ?>" 
                                                                <?php if($inventario->status == 2){ echo "disabled"; } ?>/>
                                                            </div>
                                                        </td>
                                                        <td scope="row"  class="text-center">
                                                            <a href="#" data-toggle="modal"
                                                                        data-target="#editar-produto<?= $produto->seq_produto_inventario ?>">
                                                                <?= $produto->cod_produto ?>
                                                            </a>
                                                        </td>
                                                        <td><?= $produto->nome_produto ?></td>
                                                        <td><?= $produto->nome_tipo_produto ?></td>
                                                        <td class="text-center"><?= $produto->cod_unidade_medida ?></td>                                                              
                                                        <td class="text-center"><?= number_format($produto->quant_contagem, 3, ',', '.') ?></td> 
                                                        <td class="text-center"><?= number_format($quantEstoq, 3, ',', '.') ?></td> 
                                                        <td class="text-center  
                                                            <?php
                                                                if($quantEstoq > $produto->quant_contagem){
                                                                    echo "text-danger";
                                                                }elseif($quantEstoq < $produto->quant_contagem){
                                                                    echo "text-teal";
                                                                }
                                                            ?>
                                                        ">
                                                            <?php
                                                                if($quantEstoq > $produto->quant_contagem){
                                                                    echo "-" . number_format($quantEstoq - $produto->quant_contagem, 3, ',', '.');
                                                                }elseif($quantEstoq < $produto->quant_contagem){
                                                                    echo "+" . number_format($produto->quant_contagem - $quantEstoq, 3, ',', '.');
                                                                }elseif($quantEstoq == $produto->quant_contagem){
                                                                    echo number_format(0, 3, ',', '.');
                                                                }
                                                            ?>
                                                        </td>                                   
                                                    </tr>
                                                    <?php } ?>                                                    
                                                </tbody>
                                            </table>
                                            <?php if ($lista_produto == false) { ?>
                                            <div class="text-center">
                                                <p>Nenhuma produto de inventario adicionado</p>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>                                    
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="btn btn-outline-warning" <?php if($inventario->status == 2 || $lista_produto == false){ echo "disabled"; } ?>
                                            data-toggle="modal" data-target="#executa-inventario" type="button"><i class="far fa-list-alt"></i> Executar Inventário</button>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row float-right">
                                                <div class="col-md-12">
                                                    <button type="submit" form="Inventario" class="btn btn-primary"
                                                        name="Opcao" value="salvar" <?php if($inventario->status == 2){ echo "disabled"; } ?>><i class="fas fa-save"></i> Salvar</button>                                            
                                                    <a href="<?php echo base_url() ?>estoque/inventario"
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
                            action="<?= base_url("estoque/inventario/adicionar-produto/{$inventario->num_inventario}") ?>" 
                            method="post" id='formAdicionarProduto'>
                            <div class="form-row">                                        
                                <div class="form-group col-md-12">
                                    <label for="inputProdutoInventario">Produto de Inventário <span class="text-danger">*</span></label>
                                    <select id="inputProdutoInventario" class="selectpicker show-tick form-control"
                                        data-live-search="true" data-actions-box="true" data-style="btn-input-primary"
                                        title="Selecione um Produto" name="CodProduto" required>
                                        <?php foreach($lista_produto_inv as $key_produto_inv => $produto_inv) { ?>
                                        <option value="<?= $produto_inv->cod_produto ?>"
                                        <?php if($produto_inv->cod_produto == set_value('CodProduto')) echo "selected"; ?>>
                                            <?= $produto_inv->cod_produto ?> -
                                            <?= $produto_inv->nome_produto ?></option>
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
                                    <label class="control-label" for="inputQuantContagem">Quantidade Contagem <span class="text-danger">*</span></label>
                                    <input class="form-control" id="inputQuantContagem" type="text" data-mask="#.##0,000" data-mask-reverse="true"
                                        name="QuantContagem" value="<?= set_value('QuantContagem'); ?>" required>
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
<div class="modal fade" id="editar-produto<?= $produto->seq_produto_inventario ?>">
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
                            action="<?= base_url("estoque/inventario/editar-produto/{$inventario->num_inventario}/{$produto->seq_produto_inventario}") ?>"
                            method='post' id='formEditarProduto<?= $produto->seq_produto_inventario ?>'>
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
                                    <label for="inputQuantContagemEdit">Quantidade Contagem <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="<?= $produto->quant_contagem ?>" data-mask="#.##0,000" data-mask-reverse="true"
                                        id="inputQuantContagemEdit" name="QuantContagemEdit" <?php if($inventario->status == 2){ echo "readonly"; } ?> required>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="formEditarProduto<?= $produto->seq_produto_inventario ?>"
                <?php if($inventario->status == 2){ echo "disabled"; } ?>><i class="fas fa-save"></i>
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
                Confirma eliminação do(s) produto(s) de inventário selecionado(s)?
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="DeleteProduto">Confirma</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="executa-inventario" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Executar Inventário</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Após confirmação, as movimentações não poderão ser desfeitas.<br>Confirma execução do inventário?
            </div>
            <div class="modal-footer">
                <form class="mb-0 needs-validation" novalidate
                      action="<?= base_url("estoque/inventario/executar-inventario/{$inventario->num_inventario}") ?>"
                      method='post'>                
                    <button type="submit" class="btn btn-warning">Confirma</button>
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

$("#inputProdutoInventario").change(function() {

    var baseurl = "<?php echo base_url(); ?>";

    var produto = $("#inputProdutoInventario").val();

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

<?php if($inventario->status != 2){ ?>

    $('#inputDataExecucao').datepicker({
        uiLibrary: 'bootstrap4'
    });

<?php } ?>

</script>

<?php $this->load->view('gerais/footer'); ?>