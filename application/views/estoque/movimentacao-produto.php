<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active">Movimentação por Produto</a></li>
        </ol>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="<?= base_url('relatorios/movimentacao-produto') ?>" method="get" class="mb-0 needs-validation" novalidate>
                    <div class="form-row">
                        <div class="form-group col-md-3">
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
                        <div class="form-group col-md-5">
                            <select id="inputProduto" name="produto[]" data-style="btn-input-primary" multiple
                                data-actions-box="true" class="selectpicker show-tick form-control"
                                data-live-search="true" data-actions-box="true">
                                <?php $chave_produto = 0; foreach($lista_produto as $key_produto => $produto) { ?>
                                <option value="<?= $produto->cod_produto ?>" <?php if($cod_produto != null){if($produto->cod_produto == $cod_produto[$chave_produto]){ 
                                  if((count($cod_produto) - 1) > $chave_produto) {$chave_produto = $chave_produto + 1; } 
                                  echo "selected"; }}?>>
                                    <?= $produto->cod_produto ?> -
                                    <?= $produto->nome_produto ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <button type="submit" class="btn btn-outline-primary btn-block">Atualizar Dados</button>
                        </div>
                        <div class="form-group col-md-2">
                            <a href="<?= base_url() ?>" type="button" class="btn btn-outline-secondary btn-block"
                                id="btnExport">Exportar Excel</a>
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
                            class="<?php if($total_movimento->total_entrada > 0) echo "text-info"; ?> mb-0 font-weight-bold">
                            R$ <?= number_format($total_movimento->total_entrada, 2, ',', '.') ?>
                        </h1>
                        <p class="lead text-muted font-weight-lighter mb-0">Total entradas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card  mb-2">
                    <div class="card-body text-center">
                        <h1
                            class="<?php if($total_movimento->total_saida > 0) echo "text-warning"; ?> mb-0 font-weight-bold">
                            R$
                            <?= number_format($total_movimento->total_saida, 2, ',', '.') ?></h1>
                        <p class="lead text-muted font-weight-lighter mb-0">Total saídas</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                            aria-controls="home" aria-selected="true">Estoque Resumido</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                            aria-controls="profile" aria-selected="false">Estoque Detalhado</a>
                    </li>
                </ul>
                <div class="card  mb-5">
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <table class="table table-bordered table-hover table-reporte small">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Produto</th>
                                            <th scope="col">Tipo do Produto</th>
                                            <th scope="col" class="text-center">Unid Medida</th>
                                            <th scope="col" class="text-center">Quant Entrada</th>
                                            <th scope="col" class="text-center">Quant Saída</th>
                                            <th scope="col" class="text-center">Total Entrada</th>
                                            <th scope="col" class="text-center">Total Saída</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($lista_movimento_resumido as $key_movimento_resumido => $movimento_resumido) { ?>
                                        <tr>
                                            <td scope="row"><?= $movimento_resumido->cod_produto ?> -
                                                <?= $movimento_resumido->nome_produto ?></td>
                                            <td><?= $movimento_resumido->nome_tipo_produto ?></td>
                                            <td class="text-center"><?= $movimento_resumido->cod_unidade_medida ?></td>
                                            <td class="text-center">
                                                <?= number_format($movimento_resumido->quant_entrada, 3, ',', '.') ?>
                                            </td>
                                            <td class="text-center">
                                                <?= number_format($movimento_resumido->quant_saida, 3, ',', '.') ?>
                                            </td>
                                            <td class="text-center <?php if($movimento_resumido->total_entrada > 0) echo "text-info"; ?>">
                                                R$ <?= number_format($movimento_resumido->total_entrada, 2, ',', '.') ?>
                                            </td>
                                            <td class="text-center <?php if($movimento_resumido->total_saida > 0) echo "text-warning"; ?>">
                                                R$ <?= number_format($movimento_resumido->total_saida, 2, ',', '.') ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php if ($lista_movimento_resumido == false) { ?>
                                <div class="text-center">
                                    <p class="text-muted mb-0">Nenhuma informação encontrada</p>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <table class="table table-bordered table-hover table-reporte small">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="text-center">Data de Movimento</th>
                                            <th scope="col">Produto</th>
                                            <th scope="col">Tipo do Produto</th>
                                            <th scope="col" class="text-center">Un</th>
                                            <th scope="col">Especie Movimento</th>
                                            <th scope="col">Tipo do Movimento</th>
                                            <th scope="col" class="text-center">Quant Movimento</th>
                                            <th scope="col" class="text-center">Valor Movimento</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($lista_movimento_detalhado as $key_movimento_detalhado => $movimento_detalhado) { ?>
                                        <tr>
                                            <td class="text-center">
                                                <?= str_replace('-', '/', date("d-m-Y", strtotime($movimento_detalhado->data_movimento))) ?>
                                            </td>
                                            <td scope="row"><?= $movimento_detalhado->cod_produto ?> -
                                                <?= $movimento_detalhado->nome_produto ?></td>
                                            <td><?= $movimento_detalhado->nome_tipo_produto ?></td>
                                            <td class="text-center"><?= $movimento_detalhado->cod_unidade_medida ?></td>
                                            <td>
                                                <?php 
                                        switch ($movimento_detalhado->especie_movimento) {
                                            case 1:
                                                echo "Estoque Inicial";
                                                break;
                                            case 2:
                                                echo "Reporte de Produção";
                                                break;
                                            case 3:
                                                echo "Consumo de Material";
                                                break;
                                            case 4:
                                                echo "Compra de Material";
                                                break;
                                            case 5:
                                                echo "Venda de Material";
                                                break;
                                            case 6:
                                                echo "Estorno de Produção";
                                                break;
                                            case 7:
                                                echo "Estorno de Cosumo";
                                                break;
                                            case 8:
                                                echo "Devolução de Compra";
                                                break;
                                            case 9:
                                                echo "Devolução de Venda";
                                                break;
                                            case 10:
                                                echo "Movimentos Diversos de Entrada";
                                                break;
                                            case 11:
                                                echo "Movimentos Diversos de Saída";
                                                break;
                                            case 12:
                                                echo "Entrada em Estoque Conta Azul";
                                                break;
                                            case 13:
                                                echo "Saída de Estoque Conta Azul";
                                                break;
                                            case 14:
                                                echo "Entrada por Acerto de Inventário";
                                                break;
                                            case 15:
                                                echo "Saída por Acerto de Inventário";
                                                break;
                                            case 16:
                                                echo "Requisição de Material";
                                                break;
                                            case 17:
                                                echo "Estorno de Requisição de Material";
                                                break;
                                        } 
                                        ?>
                                            </td>
                                            <td>
                                                <?php 
                                        switch ($movimento_detalhado->tipo_movimento) {
                                            case 1:
                                                echo "Entrada em Estoque";
                                                break;
                                            case 2:
                                                echo "Saída de Estoque";
                                                break;
                                        } 
                                        ?>
                                            </td>
                                            <td class="text-center">
                                                <?= number_format($movimento_detalhado->quant_movimentada, 3, ',', '.') ?>
                                            </td>
                                            <td class="text-center <?php if($movimento_detalhado->tipo_movimento == 1) echo "text-info";
                                                                 else echo "text-warning"; ?>">
                                                R$
                                                <?= number_format($movimento_detalhado->valor_movimento, 2, ',', '.') ?>
                                            </td>
                                        </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                                <?php if ($lista_movimento_detalhado == false) { ?>
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

<iframe id="downloadXLS" style="display:none">
    <meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">
    <table>
        <thead>
            <tr>
                <th style="border: 1px solid; background-color: rgb(223, 215, 202)">DATA MOVIMENTO</th>
                <th style="border: 1px solid; background-color: rgb(223, 215, 202)">PRODUTO</th>
                <th style="border: 1px solid; background-color: rgb(223, 215, 202)">TIPO PRODUTO</th>
                <th style="border: 1px solid; background-color: rgb(223, 215, 202)">UN</th>
                <th style="border: 1px solid; background-color: rgb(223, 215, 202)">TP MOVIMENTO</th>
                <th style="border: 1px solid; background-color: rgb(223, 215, 202)">ESPECÍE MOVIMENTO</th>
                <th style="border: 1px solid; background-color: rgb(223, 215, 202)">ORIGEM MOVIMENTO</th>
                <th style="border: 1px solid; background-color: rgb(223, 215, 202)">ID ORIGEM</th>
                <th style="border: 1px solid; background-color: rgb(223, 215, 202)">CUSTO MÉDIO</th>
                <th style="border: 1px solid; background-color: rgb(223, 215, 202)">QUANT MOVIMENTO</th>
                <th style="border: 1px solid; background-color: rgb(223, 215, 202)">VLR MOVIMENTO</th>
                <th style="border: 1px solid; background-color: rgb(223, 215, 202)">OBSERVACAO</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($lista_movimento_detalhado as $key_movimento_detalhado => $movimento_detalhado) { ?>
            <tr>
                <td style="border: 1px solid">
                    <?= str_replace('-', '/', date("d-m-Y", strtotime($movimento_detalhado->data_movimento))) ?>
                </td>
                <td style="border: 1px solid"><?= $movimento_detalhado->cod_produto ?> -
                    <?= $movimento_detalhado->nome_produto ?></td>
                <td style="border: 1px solid"><?= $movimento_detalhado->nome_tipo_produto ?></td>
                <td style="border: 1px solid"><?= $movimento_detalhado->cod_unidade_medida ?></td>
                <td style="border: 1px solid">
                    <?php 
                    switch ($movimento_detalhado->tipo_movimento) {
                        case 1:
                            echo "Entrada em Estoque";
                            break;
                        case 2:
                            echo "Saída de Estoque";
                            break;
                    } 
                ?>
                </td>
                <td style="border: 1px solid">
                    <?php 
                    switch ($movimento_detalhado->especie_movimento) {
                        case 1:
                            echo "Estoque Inicial";
                            break;
                        case 2:
                            echo "Reporte de Produção";
                            break;
                        case 3:
                            echo "Consumo de Material";
                            break;
                        case 4:
                            echo "Compra de Material";
                            break;
                        case 5:
                            echo "Venda de Material";
                            break;
                        case 6:
                            echo "Estorno de Produção";
                            break;
                        case 7:
                            echo "Estorno de Cosumo";
                            break;
                        case 8:
                            echo "Devolução de Compra";
                            break;
                        case 9:
                            echo "Devolução de Venda";
                            break;
                        case 10:
                            echo "Movimentos Diversos de Entrada";
                            break;
                        case 11:
                            echo "Movimentos Diversos de Saída";
                            break;
                        case 12:
                            echo "Entrada em Estoque Conta Azul";
                            break;
                        case 13:
                            echo "Saída de Estoque Conta Azul";
                            break;
                        case 14:
                            echo "Entrada por Acerto de Inventário";
                            break;
                        case 15:
                            echo "Saída por Acerto de Inventário";
                            break;
                        case 16:
                            echo "Requisição de Material";
                            break;
                        case 17:
                            echo "Estorno de Requisição de Material";
                            break;
                    } 
                ?>
                </td>
                <td style="border: 1px solid">
                    <?php 
                    switch ($movimento_detalhado->origem_movimento) {
                        case 1:
                            echo "Reporte de Produção";
                            break;
                        case 2:
                            echo "Recebimento de Material";
                            break;
                        case 3:
                            echo "Pedido de Venda";
                            break;
                        case 4:
                            echo "Inventário";
                            break;
                        case 5:
                            echo "Estoque";
                            break;
                    } 
                ?>
                </td>
                <td style="border: 1px solid"><?= $movimento_detalhado->id_origem ?></td>
                <td style="border: 1px solid">
                    R$ <?= number_format($movimento_detalhado->custo_medio, 2, ',', '.') ?>
                </td>
                <td style="border: 1px solid">
                    <?= number_format($movimento_detalhado->quant_movimentada, 3, ',', '.') ?>
                </td>
                <td style="border: 1px solid">
                    R$ <?= number_format($movimento_detalhado->valor_movimento, 2, ',', '.') ?>
                </td>
                <td style="border: 1px solid">
                    <?= $movimento_detalhado->observacao ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</iframe>

<script>
$("#btnExport").click(function(e) {
    var a = document.createElement('a');
    var data_type = 'data:application/vnd.ms-excel';
    var table_div = document.getElementById('downloadXLS');
    var table_html = table_div.outerHTML.replace(/ /g, '%20');
    a.href = data_type + ', ' + table_html;
    a.download = 'Movimento Estoque.xls';
    a.click();
    e.preventDefault();
});

$('#inputDataInicio').datepicker({
    uiLibrary: 'bootstrap4'
});
$('#inputDataFim').datepicker({
    uiLibrary: 'bootstrap4'
});
</script>

<?php $this->load->view('gerais/footer'); ?>