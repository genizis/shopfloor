<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active">Venda por Produto</a></li>
        </ol>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="<?= base_url('relatorios/venda-produto') ?>" method="get" class="mb-0 needs-validation" novalidate>
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
                        <div class="form-group col-md-6">
                            <select id="inputProduto" name="produto[]" data-style="btn-input-primary" multiple
                                data-actions-box="true" class="selectpicker show-tick form-control"
                                data-live-search="true" data-actions-box="true" title="Produtos Vendidos">
                                <?php $chave_produto = 0; foreach($lista_produto_vend as $key_produto_vend => $produto_vend) { ?>
                                <option value="<?= $produto_vend->cod_produto ?>" <?php if($cod_produto != null){if($produto_vend->cod_produto == $cod_produto[$chave_produto]){ 
                                  if((count($cod_produto) - 1) > $chave_produto) {$chave_produto = $chave_produto + 1; } 
                                  echo "selected"; }}?>>
                                    <?= $produto_vend->cod_produto ?> -
                                    <?= $produto_vend->nome_produto ?></option>
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
                        <h1 class="<?php if($total_venda->valor_total > 0) echo "text-teal"; ?> mb-0 font-weight-bold">R$
                            <?= number_format($total_venda->valor_total, 2, ',', '.') ?></h1>
                        <p class="lead text-muted font-weight-lighter mb-0">Total vendido</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                            aria-controls="home" aria-selected="true">Venda Resumida</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                            aria-controls="profile" aria-selected="false">Venda Detalhada</a>
                    </li>
                </ul>
                <div class="card mb-5">
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <table class="table table-bordered table-hover table-reporte small">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Produto de Venda</th>
                                            <th scope="col">Tipo do Produto</th>
                                            <th scope="col" class="text-center">Unid Medida</th>
                                            <th scope="col" class="text-center">Quant Vendido</th>
                                            <th scope="col" class="text-center">Total Vendido</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($lista_venda_resumida as $key_venda_resumida => $venda_resumida) { ?>
                                        <tr>
                                            <td scope="row"><?= $venda_resumida->cod_produto ?> -
                                                <?= $venda_resumida->nome_produto ?></td>
                                            <td><?= $venda_resumida->nome_tipo_produto ?></td>
                                            <td class="text-center"><?= $venda_resumida->cod_unidade_medida ?></td>
                                            <td class="text-center">
                                                <?= number_format($venda_resumida->quant_vendido, 3, ',', '.') ?>
                                            </td>
                                            <td class="text-center text-teal">
                                                R$ <?= number_format($venda_resumida->total_vendido, 2, ',', '.') ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php if ($lista_venda_resumida == false) { ?>
                                <div class="text-center">
                                    <p class="text-muted mb-0">Nenhuma informação encontrada</p>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <table class="table table-bordered table-hover table-reporte small">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="text-center">Data da Venda</th>
                                            <th scope="col" class="text-center">Tipo de Venda</th>
                                            <th scope="col" class="text-center">Pedido / Data Caixa</th>
                                            <th scope="col" class="text-center">Faturamento / Venda Caixa</th>
                                            <th scope="col">Produto de Venda</th>
                                            <th scope="col">Tipo do Produto</th>
                                            <th scope="col" class="text-center">Un</th>
                                            <th scope="col" class="text-center">Quant Vendido</th>
                                            <th scope="col" class="text-center">Total da Venda</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($lista_venda_detalhada as $key_venda_detalhada => $venda_detalhada) { ?>
                                        <tr>
                                            <td class="text-center">
                                                <?= str_replace('-', '/', date("d-m-Y", strtotime($venda_detalhada->data_movimento))) ?>
                                            </td>
                                            <td class="text-center">
                                                <?= $venda_detalhada->tipo_venda ?>
                                            </td>
                                            <td class="text-center"><?= $venda_detalhada->pedido ?></td>
                                            <td class="text-center"><?= $venda_detalhada->venda ?></td>
                                            <td scope="row"><?= $venda_detalhada->cod_produto ?> -
                                                <?= $venda_detalhada->nome_produto ?></td>
                                            <td><?= $venda_detalhada->nome_tipo_produto ?></td>
                                            <td class="text-center"><?= $venda_detalhada->cod_unidade_medida ?></td>
                                            <td class="text-center">
                                                <?= number_format($venda_detalhada->quant_movimentada, 3, ',', '.') ?>
                                            </td>
                                            <td class="text-center text-teal">
                                                R$ <?= number_format($venda_detalhada->valor_movimento, 2, ',', '.') ?>
                                            </td>
                                        </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                                  <?php if ($lista_venda_detalhada == false) { ?>
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