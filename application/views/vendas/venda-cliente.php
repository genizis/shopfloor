<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active">Venda por Cliente</a></li>
        </ol>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="<?= base_url('relatorios/venda-cliente') ?>" method="get" class="mb-0 needs-validation" novalidate>
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
                            <select id="inputCliente" name="cliente[]" data-style="btn-input-primary" multiple
                                data-actions-box="true" class="selectpicker show-tick form-control"
                                data-live-search="true" data-actions-box="true" title="Clientes">
                                <?php $chave_cliente = 0; foreach($lista_cliente as $key_cliente => $cliente) { ?>
                                <option value="<?= $cliente->cod_cliente ?>" <?php if($cod_cliente != null){if($cliente->cod_cliente == $cod_cliente[$chave_cliente]){ 
                                  if((count($cod_cliente) - 1) > $chave_cliente) {$chave_cliente = $chave_cliente + 1; } 
                                  echo "selected"; }}?>>
                                    <?= $cliente->cod_cliente ?> -
                                    <?= $cliente->nome_cliente ?></option>
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
                        <h1 class="<?php if($total_venda->valor_total > 0) echo "text-teal"; ?> mb-0 font-weight-bold">
                            R$
                            <?= number_format($total_venda->valor_total, 2, ',', '.') ?></h1>
                        <p class="lead text-muted font-weight-lighter mb-0">Total vendido</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card  mb-2">
                    <div class="card-body text-center">
                        <h1
                            class="<?php if($total_venda->total_desconto > 0) echo "text-warning"; ?> mb-0 font-weight-bold">
                            R$
                            <?= number_format($total_venda->total_desconto, 2, ',', '.') ?></h1>
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
                            aria-controls="home" aria-selected="true">Venda Resumida</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                            aria-controls="profile" aria-selected="false">Venda Detalhada</a>
                    </li>
                </ul>
                <div class="card  mb-5">
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <table class="table table-bordered table-hover table-reporte small">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Cliente</th>
                                            <th scope="col" class="text-center">CNPJ</th>
                                            <th scope="col" class="text-center">Valor Total Desconto</th>
                                            <th scope="col" class="text-center">Valor Total Vendido</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($lista_cliente_resumida as $key_cliente_resumida => $cliente_resumida) { ?>
                                        <tr>
                                            <td>
                                            <?php
                                                if($cliente_resumida->cod_cliente <> 0)
                                                    echo $cliente_resumida->cod_cliente . " - " . $cliente_resumida->nome_cliente;
                                                else
                                                    echo "Consumidor Final";
                                            ?>
                                            </td>
                                            <td class="text-center"><?= $cliente_resumida->cnpj_cpf ?></td>
                                            <td class="text-center <?php if($cliente_resumida->total_desconto > 0) echo "text-warning"; ?>">
                                                R$ <?= number_format($cliente_resumida->total_desconto, 2, ',', '.') ?>
                                            </td>
                                            <td class="text-center text-teal">
                                                R$ <?= number_format($cliente_resumida->total_venda, 2, ',', '.') ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php if ($lista_cliente_resumida == false) { ?>
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
                                            <th scope="col">Cliente</th>
                                            <th scope="col">Produto de Venda</th>
                                            <th scope="col">Tipo do Produto</th>
                                            <th scope="col" class="text-center">Un</th>
                                            <th scope="col" class="text-center">Quant Venda</th>
                                            <th scope="col" class="text-center">Total da Venda</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($lista_cliente_detalhada as $key_cliente_detalhada => $cliente_detalhada) { ?>
                                        <tr>
                                            <td class="text-center">
                                                <?= str_replace('-', '/', date("d-m-Y", strtotime($cliente_detalhada->data_movimento))) ?>
                                            </td>
                                            <td>
                                            <?php
                                                if($cliente_detalhada->cod_cliente <> 0)
                                                    echo $cliente_detalhada->cod_cliente . " - " . $cliente_detalhada->nome_cliente;
                                                else
                                                    echo "Consumidor Final";
                                            ?>
                                            </td>
                                            <td scope="row"><?= $cliente_detalhada->cod_produto ?> -
                                                <?= $cliente_detalhada->nome_produto ?></td>
                                            <td><?= $cliente_detalhada->nome_tipo_produto ?></td>
                                            <td class="text-center"><?= $cliente_detalhada->cod_unidade_medida ?></td>
                                            <td class="text-center">
                                                <?= number_format($cliente_detalhada->quant_movimentada, 3, ',', '.') ?>
                                            </td>
                                            <td class="text-center text-teal">
                                                R$
                                                <?= number_format($cliente_detalhada->valor_movimento, 2, ',', '.') ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php if ($lista_cliente_detalhada == false) { ?>
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