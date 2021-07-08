<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active">Compra por Produto</a></li>
        </ol>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="<?= base_url('relatorios/compra-produto') ?>" method="get" class="mb-0 needs-validation" novalidate>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <input class="form-control" id="inputDataInicio" type="text" name="DataInicio"
                                        value="<?= str_replace('-', '/', date("d-m-Y", strtotime($dataInicio))) ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <input class="form-control" id="inputDataFim" type="text" name="DataFim"
                                        value="<?= str_replace('-', '/', date("d-m-Y", strtotime($dataFim))) ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <select id="inputProduto" name="produto[]" data-style="btn-input-primary" multiple
                                data-actions-box="true" class="selectpicker show-tick form-control"
                                data-live-search="true" data-actions-box="true">
                                <?php $chave_produto = 0; foreach($lista_produto_comp as $key_produto_comp => $produto_comp) { ?>
                                <option value="<?= $produto_comp->cod_produto ?>" <?php if($cod_produto != null){if($produto_comp->cod_produto == $cod_produto[$chave_produto]){ 
                                  if((count($cod_produto) - 1) > $chave_produto) {$chave_produto = $chave_produto + 1; } 
                                  echo "selected"; }}?>>
                                    <?= $produto_comp->cod_produto ?> -
                                    <?= $produto_comp->nome_produto ?></option>
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
            <div class="col-md-6">
                <div class="card  mb-2">
                    <div class="card-body text-center">
                        <h1
                            class="<?php if($total_compra->valor_total > 0) echo "text-warning"; ?> mb-0 font-weight-bold">
                            R$
                            <?= number_format($total_compra->valor_total, 2, ',', '.') ?></h1>
                        <p class="lead text-muted font-weight-lighter mb-0">Total comprado</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card  mb-2">
                    <div class="card-body text-center">
                        <h1
                            class="<?php if($total_compra->valor_desconto > 0) echo "text-teal"; ?> mb-0 font-weight-bold">
                            R$
                            <?= number_format($total_compra->valor_desconto, 2, ',', '.') ?></h1>
                        <p class="lead text-muted font-weight-lighter mb-0">Total desconto</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                            aria-controls="home" aria-selected="true">Compra Resumida</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                            aria-controls="profile" aria-selected="false">Compra Detalhada</a>
                    </li>
                </ul>
                <div class="card  mb-5">
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <table class="table table-bordered table-hover table-reporte small">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Produto de Compra</th>
                                            <th scope="col">Tipo do Produto</th>
                                            <th scope="col" class="text-center">Unid Medida</th>
                                            <th scope="col" class="text-center">Quant Comprada</th>
                                            <th scope="col" class="text-center">Valor Total da Compra</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($lista_compra_resumida as $key_compra_resumida => $compra_resumida) { ?>
                                        <tr>
                                            <td scope="row"><?= $compra_resumida->cod_produto ?> -
                                                <?= $compra_resumida->nome_produto ?></td>
                                            <td><?= $compra_resumida->nome_tipo_produto ?></td>
                                            <td class="text-center"><?= $compra_resumida->cod_unidade_medida ?></td>
                                            <td class="text-center">
                                                <?= number_format($compra_resumida->quant_comprada, 3, ',', '.') ?>
                                            </td>
                                            <td class="text-center text-warning">
                                                R$ <?= number_format($compra_resumida->total_compra, 2, ',', '.') ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php if ($lista_compra_resumida == false) { ?>
                                <div class="text-center">
                                    <p class="text-muted mb-0">Nenhuma informação encontrada</p>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <table class="table table-bordered table-hover table-reporte small">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="text-center">Data de Recebimento</th>
                                            <th scope="col" class="text-center">Pedido de Compra</th>
                                            <th scope="col" class="text-center">Recebimento</th>
                                            <th scope="col">Produto de Compra</th>
                                            <th scope="col">Tipo do Produto</th>
                                            <th scope="col" class="text-center">Un</th>
                                            <th scope="col" class="text-center">Quant Comprado</th>
                                            <th scope="col" class="text-center">Valor Total da Compra</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($lista_compra_detalhada as $key_compra_detalhada => $compra_detalhada) { ?>
                                        <tr>
                                            <td class="text-center">
                                                <?= str_replace('-', '/', date("d-m-Y", strtotime($compra_detalhada->data_movimento))) ?>
                                            </td>
                                            <td class="text-center"><?= $compra_detalhada->num_pedido_compra ?></td>
                                            <td class="text-center"><?= $compra_detalhada->cod_recebimento_material ?>
                                            </td>
                                            <td scope="row"><?= $compra_detalhada->cod_produto ?> -
                                                <?= $compra_detalhada->nome_produto ?></td>
                                            <td><?= $compra_detalhada->nome_tipo_produto ?></td>
                                            <td class="text-center"><?= $compra_detalhada->cod_unidade_medida ?></td>
                                            <td class="text-center">
                                                <?= number_format($compra_detalhada->quant_movimentada, 3, ',', '.') ?>
                                            </td>
                                            <td class="text-center text-warning">
                                                R$ <?= number_format($compra_detalhada->valor_movimento, 2, ',', '.') ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php if ($lista_compra_detalhada == false) { ?>
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