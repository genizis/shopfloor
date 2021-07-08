<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active">Resultado por Conta Contábil</a></li>
        </ol>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="<?= base_url('relatorios/resultado-conta-contabil') ?>" method="get" class="mb-0 needs-validation" novalidate>
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
                            <select id="inputContaContabil" name="contaContabil[]" data-style="btn-input-primary"
                                multiple data-actions-box="true"
                                class="selectpicker show-tick form-control" data-live-search="true"
                                data-actions-box="true">
                                <?php $chave_conta_contabil = 0; 
                                foreach($lista_conta_contabil as $key_conta_contabil => $conta_contabil) { ?>
                                <option value="<?= $conta_contabil->cod_conta_contabil ?>" <?php if($cod_conta_contabil != null){if($conta_contabil->cod_conta_contabil == $cod_conta_contabil[$chave_conta_contabil]){ 
                                  if((count($cod_conta_contabil) - 1) > $chave_conta_contabil) {$chave_conta_contabil = $chave_conta_contabil + 1; } 
                                  echo "selected"; }}?>>
                                    <?= $conta_contabil->cod_conta_contabil ?> -
                                    <?= $conta_contabil->nome_conta_contabil ?></option>
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
            <div class="col-md-4">
                <div class="card mb-2">
                    <div class="card-body text-center">
                        <h1
                            class="<?php if($total_conta_contabil->receita > 0) echo "text-teal"; ?> mb-0 font-weight-bold">
                            R$ <?= number_format($total_conta_contabil->receita, 2, ',', '.') ?></h1>
                        <p class="lead text-muted font-weight-lighter mb-0">Receitas no período</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-2">
                    <div class="card-body text-center">
                        <h1
                            class="<?php if($total_conta_contabil->despesa > 0) echo "text-danger"; ?> mb-0 font-weight-bold">
                            R$ <?= number_format($total_conta_contabil->despesa, 2, ',', '.') ?></h1>
                        <p class="lead text-muted font-weight-lighter mb-0">Despesas no período</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-2">
                    <div class="card-body text-center">
                        <h1
                            class="mb-0 <?php if(($total_conta_contabil->receita - $total_conta_contabil->despesa) > 0) echo "text-teal";
                                              if(($total_conta_contabil->receita - $total_conta_contabil->despesa) < 0) echo "text-danger"; ?> font-weight-bold">
                            R$
                            <?= number_format(($total_conta_contabil->receita - $total_conta_contabil->despesa), 2, ',', '.') ?>
                        </h1>
                        <p class="lead text-muted font-weight-lighter mb-0">Resultado</p>
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
                                            <th scope="col">Conta Contábil</th>
                                            <th scope="col" class="text-center">Receitas</th>
                                            <th scope="col" class="text-center">Despesas</th>
                                            <th scope="col" class="text-center">Resultado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($lista_conta_resumida as $key_conta_resumida => $conta_resumida) { ?>
                                        <tr>
                                            <td scope="row"
                                                class="<?php if($conta_resumida->count_filho > 0) echo "reg-bold"; ?>">
                                                <?php
                                    for($i = 1; $i <= substr_count($conta_resumida->cod_conta_contabil, '.'); $i++){
                                        echo "&emsp;&emsp;";
                                    }
                                    ?>
                                                <?= $conta_resumida->cod_conta_contabil ?> -
                                                <?= $conta_resumida->nome_conta_contabil ?>
                                            </td>
                                            <td
                                                class="text-center <?php if($entrada[$conta_resumida->cod_conta_contabil] > 0) echo "text-teal"; ?> <?php if($conta_resumida->count_filho > 0) echo "reg-bold"; ?>">
                                                R$
                                                <?= number_format($entrada[$conta_resumida->cod_conta_contabil], 2, ',', '.') ?>
                                            </td>
                                            <td
                                                class="text-center <?php if($saida[$conta_resumida->cod_conta_contabil] > 0) echo "text-danger"; ?> <?php if($conta_resumida->count_filho > 0) echo "reg-bold"; ?>">
                                                R$
                                                <?= number_format($saida[$conta_resumida->cod_conta_contabil], 2, ',', '.') ?>
                                            </td>
                                            <td
                                                class="text-center <?php if(($entrada[$conta_resumida->cod_conta_contabil] - $saida[$conta_resumida->cod_conta_contabil]) > 0) echo "text-teal";
                                                                 if(($entrada[$conta_resumida->cod_conta_contabil] - $saida[$conta_resumida->cod_conta_contabil]) < 0) echo "text-danger"; ?> <?php if($conta_resumida->count_filho > 0) echo "reg-bold"; ?>">
                                                R$
                                                <?= number_format(($entrada[$conta_resumida->cod_conta_contabil] - $saida[$conta_resumida->cod_conta_contabil]), 2, ',', '.') ?>
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
                                <table class="table table-bordered table-hover table-reporte small">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="text-center">Data de Vencimento</th>
                                            <th scope="col">Conta Contábil</th>
                                            <th scope="col">Conta Financeira</th>
                                            <th scope="col" class="text-center">Tíulo</th>
                                            <th scope="col">Descrição</th>
                                            <th scope="col" class="text-center">Parcela</th>
                                            <th scope="col" class="text-center">Valor do Título</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($lista_conta_detalhada as $key_conta_detalhada => $conta_detalhada) { ?>
                                        <tr>
                                            <td class="text-center">
                                                <?= str_replace('-', '/', date("d-m-Y", strtotime($conta_detalhada->data_vencimento))) ?>
                                            </td>
                                            <td><?= $conta_detalhada->cod_conta_contabil ?> -
                                                <?= $conta_detalhada->nome_conta_contabil ?></td>
                                            <td scope="row"><?= $conta_detalhada->cod_conta ?> -
                                                <?= $conta_detalhada->nome_conta ?></td>
                                            <td class="text-center"><?= $conta_detalhada->cod_movimento_conta ?></td>
                                            <td><?= $conta_detalhada->desc_movimento ?></td>
                                            <td class="text-center"><?= $conta_detalhada->parcela ?></td>
                                            <td
                                                class="text-center <?php if($conta_detalhada->tipo_movimento == 2) echo "text-danger"; ?>
                                                           <?php if($conta_detalhada->tipo_movimento == 1) echo "text-teal"; ?>">
                                                R$ <?php if($conta_detalhada->tipo_movimento == 2) echo "-"; ?><?= number_format($conta_detalhada->valor_titulo, 2, ',', '.') ?>
                                            </td>
                                        </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                                <?php if ($lista_conta_detalhada == false) { ?>
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