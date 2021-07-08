<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url() ?>produto">Produto</a></li>
            <li class="breadcrumb-item active">Novo Produto</li>
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
                                    <strong>Atenção!</strong> <?= $this->session->flashdata('erro'); ?>
                                </div>
                                <?php } $this->session->set_flashdata('erro', '');  ?>
                                <?php if ($this->session->flashdata('sucesso') <> ""){ ?>
                                <div class="alert alert-success alert-dismissible fade show" id="alert" role="alert">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong>Muito bem!</strong>
                                    <?= $this->session->flashdata('sucesso'); ?>
                                </div>
                                <?php } $this->session->set_flashdata('sucesso', ''); ?>                                
                                <form action='novo-produto' method='post' class="needs-validation" novalidate>
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="inputCodProduto">Código do Produto <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputCodProduto" oninput="handleInput(event)"
                                                name="CodProduto" value="<?= set_value('CodProduto'); ?>" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputNomeProduto">Nome do Produto <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputNomeProduto"
                                                name="NomeProduto" value="<?= set_value('NomeProduto'); ?>" required>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputTipoProduto">Tipo do Produto <span class="text-danger">*</span></label>
                                            <select id="inputTipoProduto" name="TipoProduto" data-style="btn-input-primary"
                                                class="selectpicker show-tick form-control" data-live-search="true"
                                                data-actions-box="true" title="Informe o Tipo de Produto" required>
                                                <?php foreach($lista_tipo_produto as $key_tipo_produto => $tipoProduto) { ?>
                                                <option value="<?= $tipoProduto->cod_tipo_produto ?>" <?php if($tipoProduto->cod_tipo_produto == set_value('TipoProduto')) echo "selected"; ?>><?= $tipoProduto->nome_tipo_produto ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="inputDescricao">Descrição do Produto</label>
                                        <textarea class="form-control" rows="3" id="inputDescricao" name="DescProduto"><?= set_value('DescProduto'); ?></textarea>
                                    </div>                                                                       
                                    <hr>
                                    <div class="form-row">                                        
                                        <div class="form-group col-md-4">
                                            <label for="inputUnidadeMedida">Unidade de Medida <span class="text-danger">*</span></label>
                                            <select id="inputUnidadeMedida" name="UnidadeMedida" data-style="btn-input-primary"
                                                class="selectpicker show-tick form-control" data-live-search="true"
                                                data-actions-box="true" title="Informe a Unidade de Medida" required>
                                                <?php foreach($lista_unidade_medida as $key_unidade_medida => $unidadeMedida) { ?>
                                                <option value="<?= $unidadeMedida->cod_unidade_medida ?>" <?php if($unidadeMedida->cod_unidade_medida == set_value('UnidadeMedida')) echo "selected"; ?>><?= $unidadeMedida->cod_unidade_medida ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="control-label" for="inputCustoMedio">Custo Médio <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">R$</span>
                                                </div>
                                                <input type="text" class="form-control" class="form-control"
                                                    id="inputCustoMedio" type="text" name="CustoMedio" data-mask="#.##0,00" data-mask-reverse="true"
                                                    value="<?= set_value('CustoMedio'); ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="control-label" for="inputPrecoVenda">Preço de Venda</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">R$</span>
                                                </div>
                                                <input type="text" class="form-control" class="form-control"
                                                    id="inputPrecoVenda" type="text" name="PrecoVenda" data-mask="#.##0,00" data-mask-reverse="true"
                                                    value="<?= set_value('PrecoVenda'); ?>">
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="form-row">  
                                        <div class="form-group col-md-4">
                                            <label for="inputQuantEstoque">Quantidade em Estoque <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputQuantEstoque" data-mask="#.##0,000" data-mask-reverse="true"
                                                name="QuantEstoque" value="<?= set_value('QuantEstoque'); ?>" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputEstoqueMin">Estoque Mínimo <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputEstoqueMin" data-mask="#.##0,000" data-mask-reverse="true"
                                                name="EstoqMinimo" value="<?= set_value('EstoqMinimo'); ?>" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputTempoAbastecimento">Tempo de Abastecimento (Dias) <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputTempoAbastecimento" data-mask="#.##0" data-mask-reverse="true"
                                                name="TempoAbastecimento" value="<?= set_value('TempoAbastecimento'); ?>" required>
                                        </div>                                
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="checkSaldoNegativo" name="SaldoNegativo" value="1" checked>
                                        <label class="custom-control-label" for="checkSaldoNegativo">Permitir Saldo Negativo</label>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-row">                                        
                                        <div class="form-group col-md-6">
                                            <label for="inputNCM">NCM</label>
                                            <select id="inputNCM" name="NCM" data-style="btn-input-primary"
                                                class="selectpicker show-tick form-control" data-live-search="true"
                                                data-actions-box="true" title="Informe a NCM do Produto">
                                                <?php foreach($lista_ncm as $key_ncm => $ncm) { ?>
                                                <option value="<?= $ncm->cod_ncm ?>" <?php if($ncm->cod_ncm == set_value('NCM')) echo "selected"; ?>>
                                                    <?= substr($ncm->desc_ncm, 0, 102) ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div> 
                                        <div class="form-group col-md-6">
                                            <label for="inputOrigemProduto">Origem do Produto</label>
                                            <select id="inputOrigemProduto" name="OrigemProduto" data-style="btn-input-primary"
                                                class="selectpicker show-tick form-control" data-live-search="true"
                                                data-actions-box="true" title="Informe a Origem do Produto">
                                                <option value="0" <?php if(set_value('OrigemProduto') == 0) echo "selected"; ?>>
                                                    0 - Nacional
                                                </option>
                                                <option value="1" <?php if(set_value('OrigemProduto') == 1) echo "selected"; ?>>
                                                    1 - Estrangeira - Importação direta
                                                </option>
                                                <option value="2" <?php if(set_value('OrigemProduto') == 2) echo "selected"; ?>>
                                                    2 - Estrangeira - Adquirida no mercado interno
                                                </option>
                                                <option value="3" <?php if(set_value('OrigemProduto') == 3) echo "selected"; ?>>
                                                    3 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40%
                                                </option>
                                                <option value="4" <?php if(set_value('OrigemProduto') == 4) echo "selected"; ?>>
                                                    4 - Nacional, cuja produção tenha sido feita em conformidade com a MP 252(MP do BEM)
                                                </option>
                                                <option value="5" <?php if(set_value('OrigemProduto') == 5) echo "selected"; ?>>
                                                    5 - Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40%
                                                </option>
                                                <option value="6" <?php if(set_value('OrigemProduto') == 6) echo "selected"; ?>>
                                                    6 - Estrangeira - Importação direta, sem similar nacional, constante em lista de Resolução CAMEX
                                                </option>
                                                <option value="7" <?php if(set_value('OrigemProduto') == 7) echo "selected"; ?>>
                                                    7 - Estrangeira - Adquirida no mercado interno, sem similar nacional, constante em lista de Resolução CAMEX
                                                </option>
                                                <option value="8" <?php if(set_value('OrigemProduto') == 8) echo "selected"; ?>>
                                                    8 - Nacional, mercadoria ou bem com Conteúdo de Importação superior a 70%
                                                </option>
                                            </select>
                                        </div>                                       
                                    </div> 
                                    <div class="form-row">                                        
                                        <div class="form-group col-md-6">
                                            <label for="inputCEST">CEST</label>
                                            <select id="inputCEST" name="CEST" data-style="btn-input-primary"
                                                class="selectpicker show-tick form-control" data-live-search="true"
                                                data-actions-box="true" title="Informe o CEST do Produto">
                                                <?php foreach($lista_cest as $key_cest => $cest) { ?>
                                                <option value="<?= $cest->cod_cest ?>" <?php if($cest->cod_cest == set_value('CEST')) echo "selected"; ?>>
                                                    <?= $cest->cod_cest ?> - <?= substr($cest->desc_cest, 0, 102) ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div> 
                                        <div class="form-group col-md-3">
                                            <label class="control-label" for="inputPesoLiq">Peso Líquido</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">KG</span>
                                                </div>
                                                <input type="text" class="form-control" class="form-control"
                                                    id="inputPesoLiq" type="text" data-mask="#.##0,000" data-mask-reverse="true"
                                                    name="PesoLiq" value="<?= set_value('PesoLiq'); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label" for="inputPesoBruto">Peso Bruto</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">KG</span>
                                                </div>
                                                <input type="text" class="form-control" class="form-control"
                                                    id="inputPesoBruto" type="text" data-mask="#.##0,000" data-mask-reverse="true"
                                                    name="PesoBruto" value="<?= set_value('PesoBruto'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row float-right">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                            <button type="submit" class="btn btn-primary" name="Opcao" value="salvar"><i
                                                    class="fas fa-save"></i> Salvar</button>
                                            <button type="submit" class="btn btn-info" name="Opcao"
                                                value="salvarContinuar">Salvar e Continuar</button>
                                            <a href="<?php echo base_url() ?>produto"
                                                class="btn btn-secondary">Cancelar</a>
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
<script>
$(function() {
     $.applyDataMask();
});

function handleInput(e) {
    var ss = e.target.selectionStart;
    var se = e.target.selectionEnd;
    e.target.value = e.target.value.toUpperCase().replace(/\s/g, '');
    e.target.selectionStart = ss;
    e.target.selectionEnd = se;
}

</script>

<?php $this->load->view('gerais/footer'); ?>