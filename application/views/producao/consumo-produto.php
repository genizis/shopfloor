<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active">Consumo por Produto</a></li>
        </ol>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="<?= base_url('relatorios/consumo-produto') ?>" method="get" class="mb-0 needs-validation" novalidate>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <input class="form-control" id="inputDataInicio" type="text"
                                        name="DataInicio"
                                        value="<?= str_replace('-', '/', date("d-m-Y", strtotime($dataInicio))) ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <input class="form-control" id="inputDataFim" type="text"
                                        name="DataFim"
                                        value="<?= str_replace('-', '/', date("d-m-Y", strtotime($dataFim))) ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <select id="inputProduto" name="produtoProduzido[]" data-style="btn-input-primary" multiple
                                data-actions-box="true" class="selectpicker show-tick form-control"
                                data-live-search="true" data-actions-box="true" title="Produtos Produzidos">
                                <?php $chave_produto = 0; foreach($lista_produto_prod as $key_produto_prod => $produto_prod) { ?>
                                <option value="<?= $produto_prod->cod_produto ?>" <?php if($cod_produto_produzido != null){if($produto_prod->cod_produto == $cod_produto_produzido[$chave_produto]){ 
                                  if((count($cod_produto_produzido) - 1) > $chave_produto) {$chave_produto = $chave_produto + 1; } 
                                  echo "selected"; }}?>>
                                    <?= $produto_prod->cod_produto ?> -
                                    <?= $produto_prod->nome_produto ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <select id="inputProduto" name="produtoConsumido[]" data-style="btn-input-primary" multiple
                                data-actions-box="true" class="selectpicker show-tick form-control"
                                data-live-search="true" data-actions-box="true" title="Produtos Consumidos">
                                <?php $chave_produto = 0; foreach($lista_produto_cons as $key_produto_cons => $produto_cons) { ?>
                                <option value="<?= $produto_cons->cod_produto ?>" <?php if($cod_produto_consumido != null){if($produto_cons->cod_produto == $cod_produto_consumido[$chave_produto]){ 
                                  if((count($cod_produto_consumido) - 1) > $chave_produto) {$chave_produto = $chave_produto + 1; } 
                                  echo "selected"; }}?>>
                                    <?= $produto_cons->cod_produto ?> -
                                    <?= $produto_cons->nome_produto ?></option>
                                <?php } ?>
                            </select>
                        </div>                        
                        <div class="form-group col-md-2">
                            <button type="submit" class="btn btn-outline-primary btn-block">Atualizar Dados</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-2">
                    <div class="card-body text-center">
                        <h1
                            class="<?php if($total_producao->custo_consumo > 0) echo "text-danger"; ?> mb-0 font-weight-bold">
                            R$ <?= number_format($total_producao->custo_consumo, 2, ',', '.') ?></h1>
                        <p class="lead text-muted font-weight-lighter mb-0">Custo total</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                            aria-controls="home" aria-selected="true">Consumo Resumido</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                            aria-controls="profile" aria-selected="false">Consumo Detalhado</a>
                    </li>
                </ul>
                <div class="card  mb-5">
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <table class="table table-bordered table-hover table-reporte small">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Produto de Produção</th>
                                            <th scope="col" class="text-center">Quant Produção</th>
                                            <th scope="col">Produto de Consumo</th>
                                            <th scope="col">Tipo do Produto</th>
                                            <th scope="col" class="text-center">Unid Medida</th>
                                            <th scope="col" class="text-center">Quant Consumo</th>
                                            <th scope="col" class="text-center">Consumo Médio</th>
                                            <th scope="col" class="text-center">Custo Produto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($lista_consumo_resumida as $key_consumo_resumida => $consumo_resumida) { ?>
                                        <tr>
                                            <td scope="row"><?= $consumo_resumida->produto_producao ?> -
                                                <?= $consumo_resumida->nome_producao ?></td>
                                            <td
                                                class="text-center <?php if($consumo_resumida->quant_reportada > 0) echo "text-teal"; ?>">
                                                <?= number_format($consumo_resumida->quant_reportada, 3, ',', '.') ?>
                                            </td>
                                            <td scope="row"><?= $consumo_resumida->cod_produto ?> -
                                                <?= $consumo_resumida->nome_produto ?></td>
                                            <td><?= $consumo_resumida->nome_tipo_produto ?></td>
                                            <td class="text-center"><?= $consumo_resumida->cod_unidade_medida ?></td>
                                            <td
                                                class="text-center <?php if($consumo_resumida->quant_consumo > 0) echo "text-warning"; ?>">
                                                <?= number_format($consumo_resumida->quant_consumo, 3, ',', '.') ?>
                                            </td>
                                            <td
                                                class="text-center <?php if($consumo_resumida->quant_consumo > 0) echo "text-info"; ?>">
                                                <?= number_format($consumo_resumida->quant_consumo / $consumo_resumida->quant_reportada, 3, ',', '.') ?>
                                            </td>
                                            <td
                                                class="text-center <?php if($consumo_resumida->custo_consumo > 0) echo "text-danger"; ?>">
                                                R$
                                                <?= number_format($consumo_resumida->custo_consumo, 2, ',', '.') ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php if ($lista_consumo_resumida == false) { ?>
                                <div class="text-center">
                                    <p class="text-muted mb-0">Nenhuma informação encontrada</p>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <table class="table table-bordered table-hover table-reporte small">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="text-center">Data de Consumo</th>
                                            <th scope="col" class="text-center">Ordem de Produção</th>
                                            <th scope="col" class="text-center">Reporte de Produção</th>
                                            <th scope="col">Produto Produzido</th>
                                            <th scope="col" class="text-center">Quant Produzido</th>
                                            <th scope="col">Produto Consumido</th>
                                            <th scope="col">Tipo do Produto</th>
                                            <th scope="col" class="text-center">Un</th>
                                            <th scope="col" class="text-center">Quant Consumo</th>
                                            <th scope="col" class="text-center">Médio Consumo</th>
                                            <th scope="col" class="text-center">Custo Produto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($lista_consumo_detalhado as $key_consumo_detalhado => $consumo_detalhado) { ?>
                                        <tr>
                                            <td class="text-center">
                                                <?= str_replace('-', '/', date("d-m-Y", strtotime($consumo_detalhado->data_movimento))) ?>
                                            </td>
                                            <td class="text-center"><?= $consumo_detalhado->num_ordem_producao ?></td>
                                            <td class="text-center"><?= $consumo_detalhado->cod_reporte_producao ?></td>
                                            <td scope="row"><?= $consumo_detalhado->produto_acabado ?> -
                                                <?= $consumo_detalhado->nome_acabado ?></td>
                                            <td
                                                class="text-center <?php if($consumo_detalhado->quant_reportada > 0) echo "text-teal"; ?>">
                                                <?= number_format($consumo_detalhado->quant_reportada, 3, ',', '.') ?>
                                            </td>
                                            <td scope="row"><?= $consumo_detalhado->cod_produto ?> -
                                                <?= $consumo_detalhado->nome_produto ?></td>                                            
                                            <td><?= $consumo_detalhado->nome_tipo_produto ?></td>
                                            <td class="text-center"><?= $consumo_detalhado->cod_unidade_medida ?></td>
                                            <td
                                                class="text-center <?php if($consumo_detalhado->quant_movimentada > 0) echo "text-warning"; ?>">
                                                <?= number_format($consumo_detalhado->quant_movimentada, 3, ',', '.') ?>
                                            </td>
                                            <td
                                                class="text-center <?php if($consumo_detalhado->quant_movimentada > 0) echo "text-info"; ?>">
                                                <?= number_format($consumo_detalhado->quant_movimentada / $consumo_detalhado->quant_reportada, 3, ',', '.') ?>
                                            </td>
                                            <td
                                                class="text-center <?php if($consumo_detalhado->valor_movimento > 0) echo "text-danger"; ?>">
                                                R$
                                                <?= number_format($consumo_detalhado->valor_movimento, 2, ',', '.') ?>
                                            </td>
                                        </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                                <?php if ($lista_consumo_detalhado == false) { ?>
                                <div class="text-center">
                                    <p class="text-muted mb-0">Nenhuma informação encontrada</p>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>

    </div>
</section>

<script>
$('#inputDataInicio').datepicker({
    uiLibrary: 'bootstrap4'
});
$('#inputDataFim').datepicker({
    uiLibrary: 'bootstrap4'
});
</script>

<?php $this->load->view('gerais/footer'); ?>