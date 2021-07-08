<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active">Venda por Vendedor</a></li>
        </ol>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="<?= base_url('relatorios/venda-vendedor') ?>" method="get" class="mb-0 needs-validation" novalidate>
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
                            <select id="inputVendedor" name="vendedor[]" data-style="btn-input-primary" multiple
                                data-actions-box="true" class="selectpicker show-tick form-control"
                                data-live-search="true" data-actions-box="true" title="Vendedores">
                                <?php $chave_vendedor = 0; foreach($lista_vendedor as $key_vendedor => $vendedor) { ?>
                                <option value="<?= $vendedor->cod_vendedor ?>" <?php if($cod_vendedor != null){if($vendedor->cod_vendedor == $cod_vendedor[$chave_vendedor]){ 
                                  if((count($cod_vendedor) - 1) > $chave_vendedor) {$chave_vendedor = $chave_vendedor + 1; } 
                                  echo "selected"; }}?>>
                                    <?= $vendedor->cod_vendedor ?> -
                                    <?= $vendedor->nome_vendedor ?></option>
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
                        <h1 class="<?php if($total_venda->total_venda > 0) echo "text-teal"; ?> mb-0 font-weight-bold">
                            R$
                            <?= number_format($total_venda->total_venda, 2, ',', '.') ?></h1>
                        <p class="lead text-muted font-weight-lighter mb-0">Total vendido</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card  mb-2">
                    <div class="card-body text-center">
                        <h1
                            class="<?php if($total_venda->total_comissao > 0) echo "text-info"; ?> mb-0 font-weight-bold">
                            R$
                            <?= number_format($total_venda->total_comissao, 2, ',', '.') ?></h1>
                        <p class="lead text-muted font-weight-lighter mb-0">Total comissão</p>
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
                                            <th scope="col">Vendedor</th>
                                            <th scope="col" class="text-center">Valor Total Vendido</th>
                                            <th scope="col" class="text-center">Valor Total Comissão</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($lista_vendedor_resumida as $key_vendedor_resumida => $vendedor_resumida) { ?>
                                        <tr>
                                            <td><?= $vendedor_resumida->cod_vendedor ?> -
                                                <?= $vendedor_resumida->nome_vendedor ?>
                                            </td>
                                            <td class="text-center <?php if($vendedor_resumida->total_venda > 0) echo "text-teal"; ?>">
                                                R$ <?= number_format($vendedor_resumida->total_venda, 2, ',', '.') ?>
                                            </td>
                                            <td class="text-center <?php if($vendedor_resumida->total_comissao > 0) echo "text-info"; ?>">
                                                R$ <?= number_format($vendedor_resumida->total_comissao, 2, ',', '.') ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php if ($lista_vendedor_resumida == false) { ?>
                                <div class="text-center">
                                    <p class="text-muted mb-0">Nenhuma informação encontrada</p>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <table class="table table-bordered table-hover table-reporte small">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="text-center">Data de Faturamento</th>
                                            <th scope="col">Vendedor</th>   
                                            <th scope="col">Cliente</th>                                           
                                            <th scope="col" class="text-center">Pedido de Venda</th>
                                            <th scope="col" class="text-center">Faturamento</th>
                                            <th scope="col" class="text-center">Total Venda</th>
                                            <th scope="col" class="text-center">Perc Comissão</th>
                                            <th scope="col" class="text-center">Total Comissão</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($lista_vendedor_detalhada as $key_vendedor_detalhada => $vendedor_detalhada) { ?>
                                        <tr>
                                            <td class="text-center">
                                                <?= str_replace('-', '/', date("d-m-Y", strtotime($vendedor_detalhada->data_faturamento))) ?>
                                            </td>
                                            <td><?= $vendedor_detalhada->cod_vendedor ?> -
                                                <?= $vendedor_detalhada->nome_vendedor ?>
                                            </td>    
                                            <td><?= $vendedor_detalhada->cod_cliente ?> -
                                                <?= $vendedor_detalhada->nome_cliente ?>
                                            </td>                                         
                                            <td class="text-center"><?= $vendedor_detalhada->num_pedido_venda ?></td>
                                            <td class="text-center"><?= $vendedor_detalhada->cod_faturamento_pedido ?></td>
                                            <td class="text-center <?php if($vendedor_detalhada->total_venda > 0) echo "text-teal"; ?>">
                                                R$ <?= number_format($vendedor_detalhada->total_venda, 2, ',', '.') ?>
                                            </td>
                                            <td class="text-center ">
                                                <?= number_format($vendedor_detalhada->perc_comissao, 2, ',', '.') ?>%
                                            </td>
                                            <td class="text-center <?php if($vendedor_detalhada->total_comissao > 0) echo "text-info"; ?>">
                                                R$ <?= number_format($vendedor_detalhada->total_comissao, 2, ',', '.') ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php if ($lista_vendedor_detalhada == false) { ?>
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