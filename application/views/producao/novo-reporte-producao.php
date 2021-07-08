<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active"><a href="<?php echo base_url() ?>producao/reporte-producao">Reporte de
                    Produção</a></li>
            <li class="breadcrumb-item active">Novo Reporte Produção</a></li>
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
                                <form class=" needs-validation" novalidate>
                                    <div class="form-row">
                                        <div class="form-group col-md-2">
                                            <label for="inputOrdemProducao">Ordem de Produção</label>
                                            <input type="text" class="form-control" id="inputOrdemProducao"
                                                name="OrdemProducao"
                                                value="<?= $ordem->num_ordem_producao ?>" readonly>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label for="inputProdutoOrdem">Produto de Produção</label>
                                            <input type="text" class="form-control" id="inputProdutoOrdem"
                                                name="CodProduto"
                                                value="<?= $ordem->cod_produto ?> - <?= $ordem->nome_produto ?>"
                                                readonly>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="inputTipoProduto">Tipo de Produto</label>
                                            <input type="text" class="form-control"
                                                name="TipoProduto" id="inputTipoProduto"
                                                value="<?= $ordem->nome_tipo_produto ?>" readonly>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="inputUn">Unidade de Medida</label>
                                            <input type="text" class="form-control" id="inputUn"
                                                value="<?= $ordem->cod_unidade_medida ?>" readonly>
                                        </div>
                                        <div class="form-group col-md-1">
                                            <label class="control-label" for="inputStatus">Status</label>
                                            <input class="form-control" id="inputStatus" type="text"
                                                 value="<?php
                                                    if($ordem->data_fim < date('Y-m-d') && $ordem->status != 3){
                                                        echo "Atrasada";

                                                    }else{
                                                        switch ($ordem->status) {
                                                            case 1:
                                                                echo "Pendente";
                                                                break;
                                                            case 2:
                                                                echo "Prod Parcial";
                                                                break;
                                                            case 3:
                                                                echo "Prod Total";
                                                                break;
                                                        } 

                                                    }                                                        
                                                ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-row">                                        
                                        <div class="form-group col-md-4">
                                            <label for="inputDataFim">Data Fim</label>
                                            <input type="text" class="form-control" 
                                                name="DataFim" id="inputDataFim"
                                                value="<?= str_replace('-', '/', date("d-m-Y", strtotime($ordem->data_fim))) ?>"
                                                readonly>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputQuantPlanejada">Quantidade Planejada</label>
                                            <input type="text" class="form-control" id="inputQuantPlanejada"
                                                name="QuantPlanejada" data-mask="#.##0,000" data-mask-reverse="true"
                                                value="<?= $ordem->quant_planejada ?>" readonly>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputQuantProduzida">Quantidade Produzida</label>
                                            <input type="text" class="form-control" id="inputQuantProduzida"
                                                name="QuantProduzida" data-mask="#.##0,000" data-mask-reverse="true"
                                                value="<?= $ordem->quant_produzida ?>" readonly>
                                        </div>
                                    </div>
                                </form>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div lass="row">
                                            <ul class="nav nav-tabs">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#reporte">Reporte
                                                        de Produção</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#lista">Lista de
                                                        Materiais</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane fade active show" id="reporte">
                                                <div class="row button-pane">
                                                    <div class="col-lg-12 col-md-12 col-xs-12">
                                                        <button data-toggle="modal" data-target="#inserir-reporte"
                                                            type="button" class="btn btn-outline-primary btn-sm"><i
                                                                class="fas fa-plus-circle"></i> Reportar
                                                            Produção</button>
                                                        <button data-toggle="modal" data-target="#estorna-producao"
                                                            type="button" class="btn btn-outline-danger btn-sm"
                                                            id="btnExcluir" disabled><i
                                                                class="fas fa-undo"></i>
                                                            Estornar Reporte</button>
                                                        <button data-toggle="modal" data-target="#movimentos-ordem" type="button"
                                                            class="btn btn-outline-secondary btn-sm"><i class="fas fa-list"></i> Movimentos da
                                                            Ordem</button>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-xs-12">
                                                        <form class=" needs-validation" novalidate
                                                            action="<?= base_url("producao/reporte-producao/estornar-reporte-producao/{$ordem->num_ordem_producao}") ?>"
                                                            method="POST" id="EstornaReporte">
                                                            <table class="table table-bordered table-hover">
                                                                <thead class="thead-light">
                                                                    <tr>
                                                                        <th scope="col" class="text-center">#</th>
                                                                        <th scope="col" class="text-center">Reporte</th>
                                                                        <th scope="col" class="text-center">Data do
                                                                            Reporte</th>
                                                                        <th scope="col" class="text-center">Quant
                                                                            Reportada</th>
                                                                        <th scope="col" class="text-center">Quant
                                                                            Perdida</th>
                                                                        <th scope="col" class="text-center">Custo de Produção</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach($lista_reporte as $key_reporte => $reporte) { ?>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="checkbox text-center">
                                                                                <input name="estornar_todos[]"
                                                                                    type="checkbox"
                                                                                    value="<?= $reporte->cod_reporte_producao ?>" />
                                                                            </div>
                                                                        </td>
                                                                        <td scope="row" class="text-center"><a href="#" data-toggle="modal"
                                                                                data-target="#movimentos-reporte<?= $reporte->cod_reporte_producao ?>">
                                                                                <?= $reporte->cod_reporte_producao ?>
                                                                            </a>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <?= str_replace('-', '/', date("d-m-Y", strtotime($reporte->data_reporte))) ?>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <?= number_format($reporte->quant_reportada, 3, ',', '.') ?>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <?= number_format($reporte->quant_perdida, 3, ',', '.') ?>
                                                                        </td>
                                                                        <td class="text-center <?php if($reporte->custo_producao > 0) echo "text-danger"; ?>">
                                                                            R$ <?= number_format($reporte->custo_producao, 2, ',', '.') ?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                            <?php if ($lista_reporte == false) { ?>
                                                            <div class="text-center">
                                                                <p>Nenhum reporte realizado</p>
                                                            </div>
                                                            <?php } ?>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="lista">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table class="table table-bordered table-hover">
                                                            <thead class="thead-light">
                                                                <tr>
                                                                    <th scope="col">Produto de Consumo</th>
                                                                    <th scope="col">Tipo do Produto</th>
                                                                    <th scope="col" class="text-center">Unid Medida</th>                                                                    
                                                                    <th scope="col" class="text-center">Quant de Consumo</th>
                                                                    <th scope="col" class="text-center">Quant em Estoque</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach($lista_componente as $key_componente => $componente) { ?>
                                                                <tr>
                                                                    <td scope="row"><?= $componente->cod_produto ?> - <?= $componente->nome_produto ?></td>
                                                                    <td><?= $componente->nome_tipo_produto ?></td>
                                                                    <td class="text-center"><?= $componente->cod_unidade_medida ?></td>                                                                    
                                                                    <td class="text-center"><?= number_format($componente->quant_consumo, 3, ',', '.') ?>
                                                                    </td>
                                                                    <td class="text-center <?php if($componente->quant_estoq < 0) echo "text-danger" ?>">
                                                                    <?= number_format($componente->quant_estoq, 3, ',', '.') ?>
                                                                    </td>
                                                                </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                        <?php if ($lista_componente == false) { ?>
                                                        <div class="text-center">
                                                            <p>Nenhum componente adicionado</p>
                                                        </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-xs-12">
                                        <div class="float-right">
                                            <a href="<?php echo base_url() ?>producao/reporte-producao"
                                                class="btn btn-secondary">Fechar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="estorna-producao" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Estornar Reporte</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirma o estorno do(s) reporte(s) selecionado(s)?
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="EstornaReporte">Confirma</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="inserir-reporte">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reportar Produção</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="mb-0 needs-validation" novalidate
                    action="<?= base_url("producao/reporte-producao/reportar-producao/{$ordem->num_ordem_producao}/{$ordem->cod_produto}/{$ordem->quant_planejada}") ?>"
                            method="POST" id="InserirReporte">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-xs-12">
                            
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label class="control-label" for="inputDataReporte">Data do Reporte <span class="text-danger">*</span></label>
                                        <input class="form-control" id="inputDataReporte" type="text" name="DataReporte"
                                            value="<?php if(set_value('DataReporte') == "" && $ordem->data_fim > date('Y-m-d')){
                                                            echo str_replace('-', '/', date("d-m-Y"));
                                                        }elseif(set_value('DataReporte') == "" && $ordem->data_fim <= date('Y-m-d')){
                                                            echo str_replace('-', '/', date("d-m-Y", strtotime($ordem->data_fim)));
                                                        }else{ echo set_value('DataReporte'); } ?>" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="control-label" for="inputQuantProducao">Quantidade Produzida <span class="text-danger">*</span></label>
                                        <input class="form-control" id="inputQuantProducao" type="text" name="QuantProducao" data-mask="#.##0,000" data-mask-reverse="true"
                                            value="<?= set_value('QuantProduzida'); ?>" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="control-label" for="inputQuantPerda">Quantidade Perdida</label>
                                        <input class="form-control" id="inputQuantPerda" type="text" name="QuantPerda" data-mask="#.##0,000" data-mask-reverse="true"
                                            value="<?= set_value('QuantPerdida'); ?>">
                                    </div>
                                </div>
                            
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <h6>Produtos de Consumo</h6>                            
                            <table class="table table-bordered table-hover table-reporte">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Produto de Consumo</th>
                                        <th scope="col">Tipo do Produto</th>
                                        <th scope="col" class="text-center">Un</th> 
                                        <th scope="col" class="text-center">Quant Estoque</th>
                                        <th scope="col" class="text-center">Quant Consumo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($lista_componente as $key_componente => $componente) { ?>
                                    <tr>
                                        <td scope="row"><?= $componente->cod_produto ?> - <?= $componente->nome_produto ?></td>
                                        <td><?= $componente->nome_tipo_produto ?></td>
                                        <td class="text-center"><?= $componente->cod_unidade_medida ?></td>   
                                        <td class="text-center <?php if($componente->quant_estoq < 0) echo "text-danger" ?>">
                                        <?= number_format($componente->quant_estoq, 3, ',', '.') ?>
                                        </td>                                                                 
                                        <td>
                                            <input class="form-control text-center" id="inputConsumo<?= $componente->seq_componente_producao ?>" name="consumo[<?= $componente->seq_componente_producao ?>]" type="text" name="ZZZ" data-mask="#.##0,000" data-mask-reverse="true"
                                            value="0,000">
                                        </td>                                    
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <div class="form-row mb-0">
                                <div class="form-group col-md-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="inputConsumoPlan" name="ConsPlanejado" value="1">
                                        <label class="custom-control-label" for="inputConsumoPlan">Considerar Consumo Planejado</label>
                                    </div>
                                </div>
                            </div>
                            <?php if ($lista_componente == false) { ?>
                            <div class="text-center">
                                <p>Nenhum componente adicionado</p>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <hr>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputObservacao">Observações</label>
                            <textarea class="form-control" rows="3" id="inputObservacao"
                                        name="ObsReporte"><?= set_value('ObsReporte'); ?></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="InserirReporte"><i class="fas fa-plus-circle"></i> Reportar
                    Produção</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="movimentos-ordem">
    <div class="modal-dialog modal-xxl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Movimentos da Ordem de Produção</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-body-scroll">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <table class="table table-bordered table-striped table-reporte">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="text-center">Data Movto</th>
                                    <th scope="col" class="text-center">Reporte</th>
                                    <th scope="col">Especie Movto</th>
                                    <th scope="col">Produto</th>                                    
                                    <th scope="col" class="text-center">Un</th>  
                                    <th scope="col">Tipo Movto</th>                                  
                                    <th scope="col" class="text-center">Qtde Mov</th>
                                    <th scope="col" class="text-center">Valor Mov</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($lista_movimento_ordem as $key_movimento_ordem => $movimento_ordem) { ?>
                                <tr>
                                    <td class="text-center">
                                        <?= str_replace('-', '/', date("d-m-Y", strtotime($movimento_ordem->data_movimento))) ?>
                                    </td>
                                    <td class="text-center"><?= $movimento_ordem->cod_reporte_producao ?></td>
                                    <td>
                                        <?php 
                                            switch ($movimento_ordem->especie_movimento) {
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
                                            } 
                                        ?>
                                    </td>
                                    <td><?= $movimento_ordem->cod_produto ?> - <?= $movimento_ordem->nome_produto ?></td>
                                    <td class="text-center"><?= $movimento_ordem->cod_unidade_medida ?></td>
                                    <td>
                                        <?php 
                                            switch ($movimento_ordem->tipo_movimento) {
                                                case 1:
                                                    echo "Entrada em Estoque";
                                                    break;
                                                case 2:
                                                    echo "Saída de Estoque";
                                                    break;
                                            } 
                                        ?>
                                    </td>
                                    <td class="text-center <?php if($movimento_ordem->tipo_movimento == 2) echo "text-danger"; ?>">
                                        <?= number_format($movimento_ordem->quant_movimentada, 3, ',', '.') ?>
                                    </td>
                                    <td class="text-center <?php if($movimento_ordem->tipo_movimento == 2) echo "text-danger"; ?>">
                                        R$ <?= number_format($movimento_ordem->valor_movimento, 2, ',', '.') ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php if ($lista_movimento_ordem == false) { ?>
                        <div class="text-center">
                            <p>Nenhum movimento realizado</p>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<?php foreach($lista_reporte as $key_reporte => $reporte) { ?>
<div class="modal fade" id="movimentos-reporte<?= $reporte->cod_reporte_producao ?>">
    <div class="modal-dialog modal-xxl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Movimentos do Reporte de Produção</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-body-scroll">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <table class="table table-bordered table-striped table-reporte">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="text-center">Data Movto</th>
                                    <th scope="col">Especie Movto</th>
                                    <th scope="col">Produto</th>
                                    <th scope="col" class="text-center">Un</th>
                                    <th scope="col">Tipo Movto</th>
                                    <th scope="col" class="text-center">Qtde Mov</th>
                                    <th scope="col" class="text-center">Valor Mov</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($lista_movimento_ordem as $key_movimento_ordem => $movimento_ordem) { 
                                      if($reporte->cod_reporte_producao == $movimento_ordem->cod_reporte_producao) {?>
                                <tr>
                                    <td class="text-center">
                                        <?= str_replace('-', '/', date("d-m-Y", strtotime($movimento_ordem->data_movimento))) ?>
                                    </td>
                                    <td>
                                        <?php 
                                            switch ($movimento_ordem->especie_movimento) {
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
                                            } 
                                        ?>
                                    </td>
                                    <td><?= $movimento_ordem->cod_produto ?> - <?= $movimento_ordem->nome_produto ?></td>
                                    <td class="text-center"><?= $movimento_ordem->cod_unidade_medida ?></td>
                                    <td>
                                        <?php 
                                            switch ($movimento_ordem->tipo_movimento) {
                                                case 1:
                                                    echo "Entrada em Estoque";
                                                    break;
                                                case 2:
                                                    echo "Saída de Estoque";
                                                    break;
                                            } 
                                        ?>
                                    </td>
                                    <td class="text-center <?php if($movimento_ordem->tipo_movimento == 2) echo "text-danger"; ?>">
                                        <?= number_format($movimento_ordem->quant_movimentada, 3, ',', '.') ?>
                                    </td>
                                    <td class="text-center <?php if($movimento_ordem->tipo_movimento == 2) echo "text-danger"; ?>">
                                        R$ <?= number_format($movimento_ordem->valor_movimento, 2, ',', '.') ?>
                                    </td>
                                </tr>
                                <?php }} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label>Observações</label>
                        <textarea class="form-control" rows="3"
                                    readonly><?= $reporte->observacoes ?></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<script>
$(function() {
     $.applyDataMask();
});

$("[name='estornar_todos[]']").click(function() {
    var cont = $("[name='estornar_todos[]']:checked").length;
    $("#btnExcluir").prop("disabled", cont ? false : true);
});

jQuery('#inputQuantProducao').on('keyup', function() {
    valTotalConsumo();
});

jQuery('#inputQuantPerda').on('keyup', function() {
    valTotalConsumo();
});

function valTotalConsumo() {

    if($("#inputConsumoPlan").is(':checked') === false){

        var quantProd = parseFloat(jQuery('#inputQuantProducao').val() != '' ? (jQuery('#inputQuantProducao').val().split(
            '.').join('')).replace(',', '.') : 0);
        var quantPerd = parseFloat(jQuery('#inputQuantPerda').val() != '' ? (jQuery('#inputQuantPerda').val().split(
            '.').join('')).replace(',', '.') : 0);

        var quantPlan = parseFloat("<?= $ordem->quant_planejada ?>");
        var percCons = (quantProd + quantPerd) / quantPlan;

        var quantCons = 0;
        var quantConsCalc = 0;
        <?php foreach($lista_componente as $key_componente => $componente) { ?>
            quantCons = parseFloat("<?= $componente->quant_consumo ?>");
            quantConsCalc = quantCons * percCons;

            $("#inputConsumo<?= $componente->seq_componente_producao ?>").val(quantConsCalc.toLocaleString("pt-BR", {
                style: "decimal",
                minimumFractionDigits: 3,
                maximumFractionDigits: 3
            }));

        <?php } ?>
    }

    return;
};

$("#inputConsumoPlan").change(function() {
    
    if($("#inputConsumoPlan").is(':checked')){
        <?php foreach($lista_componente as $key_componente => $componente) { ?>

            quantCons = parseFloat("<?= $componente->quant_consumo ?>");

            $("#inputConsumo<?= $componente->seq_componente_producao ?>").val(quantCons.toLocaleString("pt-BR", {
                style: "decimal",
                minimumFractionDigits: 3,
                maximumFractionDigits: 3
            }));

        <?php } ?>
    }else{
        valTotalConsumo();
    }

});

$('#inputDataReporte').datepicker({
    uiLibrary: 'bootstrap4'
});
</script>

<?php $this->load->view('gerais/footer'); ?>