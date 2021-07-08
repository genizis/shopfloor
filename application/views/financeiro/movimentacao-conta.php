<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active">Movimentação por Conta</a></li>
        </ol>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="<?= base_url('relatorios/movimentacao-conta') ?>" method="get" class="mb-0 needs-validation" novalidate>
                    <div class="form-row">
                        <div class="form-group col-md-3">
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
                        <div class="form-group col-md-2">
                            <select id="inputTipoData" name="tipoData" data-style="btn-input-primary"
                                data-actions-box="true" class="selectpicker show-tick form-control"
                                data-actions-box="true">
                                <option value="1" <?php if($tipoData == 1) echo "selected"; ?>>Data de Vencimento
                                </option>
                                <option value="2" <?php if($tipoData == 2) echo "selected"; ?>>Data de Confirmação
                                </option>
                                <option value="3" <?php if($tipoData == 3) echo "selected"; ?>>Data de Competência
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <select id="inputConta" name="conta[]" data-style="btn-input-primary" multiple
                                data-actions-box="true" class="selectpicker show-tick form-control"
                                data-live-search="true" data-actions-box="true">
                                <?php $chave_conta = 0; 
                                foreach($lista_conta as $key_conta => $conta) { ?>
                                <option value="<?= $conta->cod_conta ?>" <?php if($cod_conta != null){if($conta->cod_conta == $cod_conta[$chave_conta]){ 
                                  if((count($cod_conta) - 1) > $chave_conta) {$chave_conta = $chave_conta + 1; } 
                                  echo "selected"; }}?>>
                                    <?= $conta->cod_conta ?> -
                                    <?= $conta->nome_conta ?></option>
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
            <div class="col-md-4">
                <div class="card  mb-2">
                    <div class="card-body text-center">
                        <h1
                            class="<?php if($total_conta->entrada_confirm > 0) echo "text-teal"; ?> mb-0 font-weight-bold">
                            R$
                            <?= number_format($total_conta->entrada_confirm, 2, ',', '.') ?></h1>
                        <p class="lead text-muted font-weight-lighter mb-0">Entradas no período</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card  mb-2">
                    <div class="card-body text-center">
                        <h1
                            class="<?php if($total_conta->saida_confirm > 0) echo "text-danger"; ?> mb-0 font-weight-bold">
                            R$
                            <?= number_format($total_conta->saida_confirm, 2, ',', '.') ?></h1>
                        <p class="lead text-muted font-weight-lighter mb-0">Saídas no período</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card  mb-2">
                    <div class="card-body text-center">
                        <h1
                            class="mb-0 <?php if($total_conta->saldo_total > 0) echo "text-teal";
                                              if($total_conta->saldo_total < 0) echo "text-danger"; ?> font-weight-bold">
                            R$
                            <?= number_format($total_conta->saldo_total, 2, ',', '.') ?></h1>
                        <p class="lead text-muted font-weight-lighter mb-0">Saldo em conta</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                            aria-controls="home" aria-selected="true">Conta Resumida</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                            aria-controls="profile" aria-selected="false">Conta Detalhada</a>
                    </li>
                </ul>
                <div class="card  mb-5">
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <table class="table table-bordered table-hover table-reporte small">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Conta</th>
                                            <th scope="col" class="text-center">Entrada Confirmada</th>
                                            <th scope="col" class="text-center">Saída Confirmada</th>
                                            <th scope="col" class="text-center">Saldo em Conta</th>
                                            <th scope="col" class="text-center">Entrada Prevista</th>
                                            <th scope="col" class="text-center">Saída Prevista</th>
                                            <th scope="col" class="text-center">Saldo Projetado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($lista_conta_resumida as $key_conta_resumida => $conta_resumida) { ?>
                                        <tr>
                                            <td scope="row"><?= $conta_resumida->cod_conta ?> -
                                                <?= $conta_resumida->nome_conta ?></td>
                                            <td
                                                class="text-center <?php if($conta_resumida->entrada_confirm > 0) echo "text-teal"; ?>">
                                                R$ <?= number_format($conta_resumida->entrada_confirm, 2, ',', '.') ?>
                                            </td>
                                            <td
                                                class="text-center <?php if($conta_resumida->saida_confirm > 0) echo "text-danger"; ?>">
                                                R$ <?= number_format($conta_resumida->saida_confirm, 2, ',', '.') ?>
                                            </td>
                                            <td
                                                class="text-center <?php if($conta_resumida->saldo_conta > 0) echo "text-teal";
                                                                 if($conta_resumida->saldo_conta < 0) echo "text-danger"; ?>">
                                                R$ <?= number_format($conta_resumida->saldo_conta, 2, ',', '.') ?>
                                            </td>
                                            <td
                                                class="text-center <?php if($conta_resumida->entrada_proj > 0) echo "text-teal"; ?>">
                                                R$ <?= number_format($conta_resumida->entrada_proj, 2, ',', '.') ?>
                                            </td>
                                            <td
                                                class="text-center <?php if($conta_resumida->saida_proj > 0) echo "text-danger"; ?>">
                                                R$ <?= number_format($conta_resumida->saida_proj, 2, ',', '.') ?>
                                            </td>
                                            <td
                                                class="text-center <?php if(($conta_resumida->saldo_conta + $conta_resumida->entrada_proj - $conta_resumida->saida_proj) > 0) echo "text-teal";
                                                                 if(($conta_resumida->saldo_conta + $conta_resumida->entrada_proj - $conta_resumida->saida_proj) < 0) echo "text-danger"; ?>">
                                                R$
                                                <?= number_format(($conta_resumida->saldo_conta + $conta_resumida->entrada_proj - $conta_resumida->saida_proj), 2, ',', '.') ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php if ($lista_conta_resumida == false) { ?>
                                <div class="text-center">
                                    <p class="text-muted mb-0">Nenhuma informação encontrada</p>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <table class="table table-bordered table-hover table-reporte small2">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="text-center"></th>
                                            <th scope="col" class="text-center">
                                                <?php
                                            if($tipoData == "1"){
                                                echo "Data Vencimento";
                                            }elseif($tipoData == "2"){
                                                echo "Data Confirmação";
                                            }elseif($tipoData == "3"){
                                                echo "Data Competência";
                                            }
                                        ?>
                                            </th>
                                            <th scope="col">Conta</th>
                                            <th scope="col" class="text-center">Título</th>
                                            <th scope="col">Centro de Custo</th>
                                            <th scope="col">Conta Contábil</th>
                                            <th scope="col">Descrição</th>
                                            <th scope="col" class="text-center">Parcela</th>
                                            <th scope="col" class="text-center">Vlr Título</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($lista_movimento_detalhada as $key_movimento_detalhada => $titulo) { ?>
                                        <tr>
                                            <td class="text-center text-teal">
                                                <?php if($titulo->confirmado == 1) echo "<i class='fas fa-check-circle'></i>"; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php
                                            if($tipoData == "1"){
                                                echo str_replace('-', '/', date("d-m-Y", strtotime($titulo->data_vencimento)));
                                            }elseif($tipoData == "2"){
                                                echo str_replace('-', '/', date("d-m-Y", strtotime($titulo->data_confirmacao)));
                                            }elseif($tipoData == "3"){
                                                echo str_replace('-', '/', date("d-m-Y", strtotime($titulo->data_competencia)));
                                            }
                                            ?>
                                            </td>
                                            <td scope="row"><?= $titulo->cod_conta ?> - <?= $titulo->nome_conta ?></td>
                                            <td class="text-center"><?= $titulo->cod_movimento_conta ?></td>
                                            <td><?php if($titulo->cod_centro_custo != "") echo $titulo->cod_centro_custo . " - " . $titulo->nome_centro_custo ?>
                                            <td><?php if($titulo->cod_conta_contabil != "") echo $titulo->cod_conta_contabil . " - " . $titulo->nome_conta_contabil ?>
                                            </td>
                                            <td class="limit-text-50"><?= $titulo->desc_movimento ?></td>
                                            <td class="text-center"><?= $titulo->parcela ?></td>
                                            <td
                                                class="text-center <?php if($titulo->tipo_movimento == 2) echo "text-danger"; ?>
                                                           <?php if($titulo->tipo_movimento == 1) echo "text-teal"; ?>">
                                                R$
                                                <?php if($titulo->tipo_movimento == 2) echo "-"; ?>
                                                    <?php 
                                                        if($titulo->confirmado == 1) 
                                                            echo number_format($titulo->valor_confirmado, 2, ',', '.');
                                                        else
                                                            echo number_format($titulo->valor_titulo, 2, ',', '.');  ?>
                                            </td>
                                        </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                                <?php if ($lista_movimento_detalhada == false) { ?>
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
                <th scope="col" class="text-center" style="border: 1px solid; background-color: rgb(223, 215, 202)">
                    CONFIRMADO</th>                
                <th style="border: 1px solid; background-color: rgb(223, 215, 202)">CONTA</th>
                <th class="text-center" style="border: 1px solid; background-color: rgb(223, 215, 202)">TÍTULO</th>
                <th class="text-center" style="border: 1px solid; background-color: rgb(223, 215, 202)">DATA VENCIMENTO</th>
                <th class="text-center" style="border: 1px solid; background-color: rgb(223, 215, 202)">DATA CONFIRMAÇÃO</th>
                <th class="text-center" style="border: 1px solid; background-color: rgb(223, 215, 202)">DATA COMPETÊNCIA</th>
                <th style="border: 1px solid; background-color: rgb(223, 215, 202)">CONTA CONTÁBIL</th>
                <th style="border: 1px solid; background-color: rgb(223, 215, 202)">CENTRO DE CUSTO</th>
                <th style="border: 1px solid; background-color: rgb(223, 215, 202)">DESCRIÇÃO</th>
                <th style="border: 1px solid; background-color: rgb(223, 215, 202)">CLIENTE/FORNECEDOR</th>
                <th style="border: 1px solid; background-color: rgb(223, 215, 202)">VENDEDOR</th>
                <th class="text-center" style="border: 1px solid; background-color: rgb(223, 215, 202)">PARCELA</th>
                <th class="text-center" style="border: 1px solid; background-color: rgb(223, 215, 202)">TP MOVIMENTO
                </th>
                <th class="text-center" style="border: 1px solid; background-color: rgb(223, 215, 202)">VALOR TÍTULO
                </th>                
                <th class="text-center" style="border: 1px solid; background-color: rgb(223, 215, 202)">DESCONTO E TAXAS
                </th>                
                <th class="text-center" style="border: 1px solid; background-color: rgb(223, 215, 202)">MULTAS E JUROS
                </th>
                <th class="text-center" style="border: 1px solid; background-color: rgb(223, 215, 202)">VALOR CONFIRMADO
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($lista_movimento_detalhada as $key_movimento_detalhada => $titulo) { ?>
            <tr>
                <td class="text-center text-teal" style="border: 1px solid">
                    <?php if($titulo->confirmado == 1) echo "Sim"; else echo "Não"; ?></td>
                <td scope="row" style="border: 1px solid"><?= $titulo->cod_conta ?> - <?= $titulo->nome_conta ?></td>
                <td class="text-center" style="border: 1px solid"><?= $titulo->cod_movimento_conta ?></td>
                <td class="text-center" style="border: 1px solid"><?= str_replace('-', '/', date("d-m-Y", strtotime($titulo->data_vencimento))) ?></td>
                <td class="text-center" style="border: 1px solid"><?= str_replace('-', '/', date("d-m-Y", strtotime($titulo->data_confirmacao))) ?></td>
                <td class="text-center" style="border: 1px solid"><?= str_replace('-', '/', date("d-m-Y", strtotime($titulo->data_competencia))) ?></td>
                <td style="border: 1px solid">
                    <?php if($titulo->cod_conta_contabil != "") echo $titulo->cod_conta_contabil . " - " . $titulo->nome_conta_contabil ?>
                </td>
                <td style="border: 1px solid">
                    <?php if($titulo->cod_centro_custo != 0) echo $titulo->cod_centro_custo . " - " . $titulo->nome_centro_custo ?>
                </td>
                <td style="border: 1px solid"><?= $titulo->desc_movimento ?></td>
                <td style="border: 1px solid">
                    <?php if($titulo->cod_emitente != 0){
                        if($titulo->tipo_movimento == 1) echo $titulo->cod_emitente . " - " . $titulo->nome_cliente;
                        if($titulo->tipo_movimento == 2) echo $titulo->cod_emitente . " - " . $titulo->nome_fornecedor;                        
                      }
                ?>
                </td>
                <td style="border: 1px solid">
                    <?php if($titulo->cod_vendedor != 0){
                        echo $titulo->cod_vendedor . " - " . $titulo->nome_vendedor;                       
                      }
                ?>
                </td>
                <td class="text-center" style="border: 1px solid"><?= '="' . $titulo->parcela . '"' ?></td>
                <td class="text-center" style="border: 1px solid">
                    <?php 
                        switch ($titulo->tipo_movimento) {
                            case 1:
                                echo "Receita";
                                break;
                            case 2:
                                echo "Despesa";
                                break;
                        } 
                    ?>
                </td>
                <td class="text-center <?php if($titulo->tipo_movimento == 2) echo "text-danger"; ?>
                                       <?php if($titulo->tipo_movimento == 1) echo "text-teal"; ?>"
                    style="border: 1px solid">
                    R$ <?= number_format($titulo->valor_titulo, 2, ',', '.'); ?>
                </td>
                <td class="text-center <?php if($titulo->tipo_movimento == 2) echo "text-danger"; ?>
                                       <?php if($titulo->tipo_movimento == 1) echo "text-teal"; ?>"
                    style="border: 1px solid">
                    R$ <?= number_format($titulo->valor_desc_taxa, 2, ',', '.'); ?>
                </td>
                <td class="text-center <?php if($titulo->tipo_movimento == 2) echo "text-danger"; ?>
                                       <?php if($titulo->tipo_movimento == 1) echo "text-teal"; ?>"
                    style="border: 1px solid">
                    R$ <?= number_format($titulo->valor_juros_multa, 2, ',', '.'); ?>
                </td>
                <td class="text-center <?php if($titulo->tipo_movimento == 2) echo "text-danger"; ?>
                                       <?php if($titulo->tipo_movimento == 1) echo "text-teal"; ?>"
                    style="border: 1px solid">
                    R$ <?= number_format($titulo->valor_confirmado, 2, ',', '.'); ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</iframe>

<script>
$('#inputDataInicio').datepicker({
    uiLibrary: 'bootstrap4'
});
$('#inputDataFim').datepicker({
    uiLibrary: 'bootstrap4'
});

$("#btnExport").click(function(e) {
    var a = document.createElement('a');
    var data_type = 'data:application/vnd.ms-excel';
    var table_div = document.getElementById('downloadXLS');
    var table_html = table_div.outerHTML.replace(/ /g, '%20');
    a.href = data_type + ', ' + table_html;
    a.download = 'Movimento Conta.xls';
    a.click();
    e.preventDefault();
});
</script>

<?php $this->load->view('gerais/footer'); ?>