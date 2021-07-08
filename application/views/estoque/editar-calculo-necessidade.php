<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active"><a
                    href="<?php echo base_url() ?>estoque/necessidade-material">Necessidade de Material</a></li>
            <li class="breadcrumb-item active">Editar Cálculo de Necessidade</a></li>
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
                                <form
                                    action="<?= base_url("estoque/necessidade-material/editar-calculo-necessidade/{$necessidade->cod_calculo_necessidade}") ?>"
                                    method="POST" id="CalculoNecessidade" class=" needs-validation" novalidate>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="inputDataInicio">Data Início</label>
                                            <input type="text" class="form-control" id="inputDataInicio"
                                                name="DataInicio"
                                                value="<?= str_replace('-', '/', date("d-m-Y", strtotime($necessidade->data_inicio))) ?>"
                                                readonly>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputDataFim">Data Fim</label>
                                            <input type="text" class="form-control" id="inputDataFim" name="DataFim"
                                                value="<?= str_replace('-', '/', date("d-m-Y", strtotime($necessidade->data_fim))) ?>"
                                                readonly>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputTipoCalc">Tipo de Cálculo</label>
                                            <select id="inputTipoCalc" class="selectpicker show-tick form-control" <?php if($necessidade->status != 1) echo "disabled"; ?>
                                                 data-actions-box="true" data-style="btn-input-primary" name="TipoCalc">
                                                <option value="1" <?php if($necessidade->tipo_calculo == 1) echo "selected"; ?>>Quantidade Líquida</option>
                                                <option value="2" <?php if($necessidade->tipo_calculo == 2) echo "selected"; ?>>Quantidade Bruta</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputObservacao">Observações do Cálculo</label>
                                            <textarea class="form-control" rows="3" id="inputObservacao"
                                                name="ObsCalculo" <?php if($necessidade->status == 3) echo "readonly"; ?>><?= $necessidade->observacoes ?></textarea>
                                        </div>
                                    </div>
                                </form>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6>Pedidos e Ordens</h6>
                                        <div lass="row">
                                            <ul class="nav nav-tabs">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#pedidos">Pedidos
                                                        Considerados</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab"
                                                        href="#ordens-producao">Produtos a Produzir</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#ordens-compra">Produtos
                                                        a Comprar</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane fade active show" id="pedidos">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-xs-12 mt-2">
                                                        <button data-toggle="modal" data-target="#atualiza-pedido"
                                                            type="button" class="btn btn-outline-primary btn-sm"
                                                            <?php if($necessidade->status != 1) echo "disabled"; ?>><i
                                                                class="fas fa-sync-alt"></i> Atualizar Lista
                                                            de Pedidos</button>
                                                        <button data-toggle="modal" data-target="#elimina-pedido"
                                                            type="button" class="btn btn-outline-danger btn-sm"
                                                            id="btnExcluirPedido" disabled><i
                                                                class="fas fa-trash-alt"></i>
                                                            Excluir</button>
                                                    </div>
                                                </div>
                                                <form
                                                    action="<?= base_url("estoque/necessidade-material/excluir-pedido-venda/{$necessidade->cod_calculo_necessidade}") ?>"
                                                    method="POST" id="formDeletePedido" class="mb-0 needs-validation"
                                                    novalidate>
                                                    <table class="table table-bordered table-hover">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th scope="col" class="text-center">#</th>
                                                                <th scope="col" class="text-center">Ped Venda</th>
                                                                <th scope="col">Nome do Cliente</th>
                                                                <th scope="col" class="text-center">Data de Emissão</th>
                                                                <th scope="col" class="text-center">Data de Entrega</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach($lista_pedido as $key_pedido => $pedido) { ?>
                                                            <tr>
                                                                <td>
                                                                    <div class="checkbox text-center">
                                                                        <input name="excluir_todos_pedidos[]"
                                                                            type="checkbox"
                                                                            <?php if($necessidade->status != 1) echo "disabled"; ?>
                                                                            value="<?= $pedido->num_pedido_venda ?>"
                                                                            <?php if($pedido->count_faturamento != 0) echo "disabled"; ?> />
                                                                    </div>
                                                                </td>
                                                                <td scope="row" class="text-center"><a href="#"
                                                                        data-toggle="modal"
                                                                        data-target="#produto-pedido<?= $pedido->num_pedido_venda ?>"><?= $pedido->num_pedido_venda ?></a>
                                                                </td>
                                                                <td><?= $pedido->cod_cliente ?> -
                                                                    <?= $pedido->nome_cliente ?></td>
                                                                <td class="text-center">
                                                                    <?= str_replace('-', '/', date("d-m-Y", strtotime($pedido->data_emissao))) ?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?= str_replace('-', '/', date("d-m-Y", strtotime($pedido->data_entrega))) ?>
                                                                </td>
                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                    <?php if ($lista_pedido == false) { ?>
                                                    <div class="text-center" id="divAviso">
                                                        <p id="pAviso">Nenhum pedido de venda encontrado</p>
                                                    </div>
                                                    <?php } ?>
                                                </form>
                                            </div>
                                            <div class="tab-pane fade" id="ordens-producao">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-xs-12 mt-2">
                                                        <button data-toggle="modal" data-target="#novo-produto-producao"
                                                            type="button" class="btn btn-outline-primary btn-sm"
                                                            <?php if($necessidade->status != 2) echo "disabled"; ?>><i
                                                                class="fas fa-check-circle"></i> Adicionar
                                                            Produto</button>
                                                        <button data-toggle="modal" data-target="#elimina-producao"
                                                            type="button" class="btn btn-outline-danger btn-sm"
                                                            id="btnExcluirProducao" disabled><i
                                                                class="fas fa-trash-alt"></i>
                                                            Excluir</button>
                                                    </div>
                                                </div>
                                                <form
                                                    action="<?= base_url("estoque/necessidade-material/excluir-produto-producao/{$necessidade->cod_calculo_necessidade}") ?>"
                                                    method="POST" id="formDeleteProducao" class="mb-0 needs-validation"
                                                    novalidate>
                                                    <table class="table table-bordered table-hover">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th scope="col" class="text-center">#</th>
                                                                <th scope="col" class="text-center">Código</th>
                                                                <th scope="col">Produto de Produção</th>
                                                                <th scope="col" class="text-center">Unid Medida</th>
                                                                <th scope="col" class="text-center">Qtde Necessidade
                                                                </th>
                                                                <th scope="col" class="text-center">Data Necessidade
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach($lista_ordem_producao as $key_producao => $producao) { ?>
                                                            <tr>
                                                                <td>
                                                                    <div class="checkbox text-center">
                                                                        <input name="excluir_todos_producao[]"
                                                                            type="checkbox" <?php if($necessidade->status == 3) echo "disabled"; ?>
                                                                            value="<?= $producao->cod_calculo_necessidade_produto ?>" />
                                                                    </div>
                                                                </td>
                                                                <td scope="row" class="text-center"><a href="#"
                                                                        data-toggle="modal"
                                                                        data-target="#editar-produto-producao<?= $producao->cod_calculo_necessidade_produto ?>"><?= $producao->cod_produto ?></a>
                                                                </td>
                                                                <td><?= $producao->nome_produto ?></td>
                                                                <td class="text-center">
                                                                    <?= $producao->cod_unidade_medida ?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?= number_format($producao->quant_necessidade, 3, ',', '.') ?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?= str_replace('-', '/', date("d-m-Y", strtotime($producao->data_necessidade))) ?>
                                                                </td>
                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                    <?php if ($lista_ordem_producao == false) { ?>
                                                    <div class="text-center" id="divAviso">
                                                        <p id="pAviso">Nenhum produto de produção adicionado</p>
                                                    </div>
                                                    <?php } ?>
                                                </form>
                                            </div>
                                            <div class="tab-pane fade" id="ordens-compra">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-xs-12 mt-2">
                                                        <button data-toggle="modal" data-target="#novo-produto-compra"
                                                            type="button" class="btn btn-outline-primary btn-sm"
                                                            <?php if($necessidade->status != 2) echo "disabled"; ?>><i
                                                                class="fas fa-check-circle"></i> Adicionar
                                                            Produto</button>
                                                        <button data-toggle="modal" data-target="#elimina-compra"
                                                            type="button" class="btn btn-outline-danger btn-sm"
                                                            id="btnExcluirCompra" disabled><i
                                                                class="fas fa-trash-alt"></i>
                                                            Excluir</button>
                                                    </div>
                                                </div>
                                                <form
                                                    action="<?= base_url("estoque/necessidade-material/excluir-produto-compra/{$necessidade->cod_calculo_necessidade}") ?>"
                                                    method="POST" id="formDeleteCompra" class="mb-0 needs-validation"
                                                    novalidate>
                                                    <table class="table table-bordered table-hover">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th scope="col" class="text-center">#</th>
                                                                <th scope="col" class="text-center">Código</th>
                                                                <th scope="col">Produto de Compra</th>
                                                                <th scope="col" class="text-center">Unid Medida</th>
                                                                <th scope="col" class="text-center">Qtde Pedida</th>
                                                                <th scope="col" class="text-center">Data Necessidade
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach($lista_ordem_compra as $key_compra => $compra) { ?>
                                                            <tr>
                                                                <td>
                                                                    <div class="checkbox text-center">
                                                                        <input name="excluir_todos_compra[]"
                                                                            type="checkbox" <?php if($necessidade->status == 3) echo "disabled"; ?>
                                                                            value="<?= $compra->cod_calculo_necessidade_produto ?>" />
                                                                    </div>
                                                                </td>
                                                                <td scope="row" class="text-center"><a href="#"
                                                                        data-toggle="modal"
                                                                        data-target="#editar-produto-compra<?= $compra->cod_calculo_necessidade_produto ?>"><?= $compra->cod_produto ?></a>
                                                                </td>
                                                                <td><?= $compra->nome_produto ?></td>
                                                                <td class="text-center">
                                                                    <?= $compra->cod_unidade_medida ?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?= number_format($compra->quant_necessidade, 3, ',', '.') ?>
                                                                </td>
                                                                <td class="text-center">
                                                                    <?= str_replace('-', '/', date("d-m-Y", strtotime($compra->data_necessidade))) ?>
                                                                </td>
                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                    <?php if ($lista_ordem_compra == false) { ?>
                                                    <div class="text-center" id="divAviso">
                                                        <p id="pAviso">Nenhum produto de compra adicionado</p>
                                                    </div>
                                                    <?php } ?>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <?php if($necessidade->status == 1) { ?>
                                        <button data-toggle="modal" data-target="#calcula-necessidade" <?php if ($lista_pedido == false) echo "disabled"; ?>
                                            class="btn btn-outline-warning"><i class="fas fa-calculator"></i> Calcular
                                            Necessidade</button>
                                        <?php } ?>
                                        <?php if($necessidade->status == 2) { ?>
                                        <button data-toggle="modal" data-target="#descalcula-necessidade"
                                            class="btn btn-outline-danger"><i class="fas fa-calculator"></i> Descalcular
                                            Necessidade</button>
                                        <?php } ?>
                                        <?php if($necessidade->status == 2) { ?>
                                        <button class="btn btn-outline-teal" data-toggle="modal"
                                            data-target="#confirma-ordens"
                                            <?php if($necessidade->status != 2) echo "disabled"; ?>><i
                                                class="fas fa-check"></i>
                                            Confirmar Ordens</button>
                                        <?php } ?>
                                        <?php if($necessidade->status == 3) { ?>
                                        <button class="btn btn-outline-danger" data-toggle="modal"
                                            data-target="#desconfirma-ordens"><i
                                                class="fas fa-check"></i>
                                            Desconfirmar Ordens</button>
                                        <?php } ?>
                                        <?php if($necessidade->status > 1) { ?>
                                        <a href="#" class="btn btn-outline-warning <?php if($pedido->situacao == 2) echo "disabled"; ?>"
                                            type="button" id="imprimir"><i class="fas fa-print"></i> Imprimir Necessidades</a>
                                        <?php } ?>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row float-right">
                                            <div class="col-md-12">
                                                <div class="col-md-12">
                                                    <button type="submit" form="CalculoNecessidade"
                                                        class="btn btn-primary" name="Opcao" value="salvar"><i
                                                            class="fas fa-save"></i>
                                                        Salvar</button>
                                                    <a href="<?php echo base_url() ?>estoque/necessidade-material"
                                                        class="btn btn-secondary">Cancelar</a>
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
        </div>
    </div>
</section>

<?php foreach($lista_pedido as $key_pedido => $pedido) { ?>
<div class="modal fade" id="produto-pedido<?= $pedido->num_pedido_venda ?>">
    <div class="modal-dialog modal-xxl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Produtos do Pedido de Venda</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-body-scroll">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="text-center">Código</th>
                                    <th scope="col">Nome do Produto</th>
                                    <th scope="col">Tipo do Produto</th>
                                    <th scope="col" class="text-center">Un</th>
                                    <th scope="col" class="text-center">Quant Pedida</th>
                                    <th scope="col" class="text-center">Quant Atendida</th>
                                    <th scope="col" class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($lista_produto as $key_produto => $produto_venda) { 
                                      if($pedido->num_pedido_venda == $produto_venda->num_pedido_venda) {?>
                                <tr>
                                    <td scope="row" class="text-center">
                                        <?= $produto_venda->cod_produto ?>
                                    </td>
                                    <td><?= $produto_venda->nome_produto ?></td>
                                    <td><?= $produto_venda->nome_tipo_produto ?></td>
                                    <td class="text-center"><?= $produto_venda->cod_unidade_medida ?></td>
                                    <td class="text-center">
                                        <?= number_format($produto_venda->quant_pedida, 3, ',', '.') ?>
                                    </td>
                                    <td class="text-center">
                                        <?= number_format($produto_venda->quant_atendida, 3, ',', '.') ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                            if($pedido->data_entrega < date('Y-m-d') && $produto_venda->status != 3 && $produto_venda->status != 4){
                                                echo "<span class='badge badge-danger'>Atrasado</span>";

                                            }else{
                                                switch ($produto_venda->status) {
                                                    case 1:
                                                        echo "<span class='badge badge-secondary'>Pendente</span>";
                                                        break;
                                                    case 2:
                                                        echo "<span class='badge badge-info'>Atendido Parcial</span>";
                                                        break;
                                                    case 3:
                                                        echo "<span class='badge badge-teal'>Atendido Total</span>";
                                                        break;
                                                    case 4:
                                                        echo "<span class='badge badge-dark'>Estornado</span>";
                                                        break;
                                                } 

                                            }                                                        
                                        ?>
                                    </td>
                                </tr>
                                <?php }} ?>
                            </tbody>
                        </table>
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

<div class="modal fade" id="atualiza-pedido" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Atualizar Lista de Pedidos de Venda</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirma atualização do(s) pedido(s) de venda?
            </div>
            <div class="modal-footer">
                <form class="mb-0 needs-validation" novalidate
                    action="<?= base_url("estoque/necessidade-material/atualiza-lista-pedidos/{$necessidade->cod_calculo_necessidade}") ?>"
                    method='post'>
                    <button type="submit" class="btn btn-primary">Confirma</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="elimina-pedido" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Pedido Venda</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirma eliminação do(s) pedido(s) de venda selecionado(s)?
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger" form="formDeletePedido">Confirma</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="elimina-producao" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Produto de Produção</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirma eliminação do(s) produto(s) de produção selecionado(s)?
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger" form="formDeleteProducao">Confirma</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="elimina-compra" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Produto de Compra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirma eliminação do(s) produto(s) de compra selecionado(s)?
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger" form="formDeleteCompra">Confirma</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="calcula-necessidade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Calcular Necessidade</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirma cálculo de necessidade de materiais?
            </div>
            <div class="modal-footer">
                <form class="mb-0 needs-validation" novalidate
                    action="<?= base_url("estoque/necessidade-material/calcula-necessidade/{$necessidade->cod_calculo_necessidade}") ?>"
                    method='post'>
                    <button type="submit" class="btn btn-warning">Confirma</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="descalcula-necessidade" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Descalcular Necessidade</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirma descálculo de necessidade de materiais?
            </div>
            <div class="modal-footer">
                <form class="mb-0 needs-validation" novalidate
                    action="<?= base_url("estoque/necessidade-material/descalcula-necessidade/{$necessidade->cod_calculo_necessidade}") ?>"
                    method='post'>
                    <button type="submit" class="btn btn-danger">Confirma</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirma-ordens" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Ordens de Compra e Produção</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirma geração das ordens de compra e produção?
                <form class="mb-0 mt-3 needs-validation" novalidate
                    action="<?= base_url("estoque/necessidade-material/confirma-ordem/{$necessidade->cod_calculo_necessidade}") ?>"
                    method='post' id="ConfirmaOrdem">
                    <div class="form-row text-center">
                        <div class="form-group col-md-6">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="inputOrdemProducao" value="1"
                                    name="OrdemProducao" checked>
                                <label class="custom-control-label" for="inputOrdemProducao">Ordens de Produção</label>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="inputOrdemCompra" value="1" name="OrdemCompra"
                                    checked>
                                <label class="custom-control-label" for="inputOrdemCompra">Ordens de Compra</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-teal" form="ConfirmaOrdem">Confirma</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="desconfirma-ordens" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Desconfirmar Ordens de Compra e Produção</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Desconfirma geração da(s) ordem(s)? <p class="mt-3"> As ordens já movimentadas, mesmo que estornadas, não serão eliminadas</p>
            </div>
            <div class="modal-footer">
                <form class="mb-0 needs-validation" novalidate
                    action="<?= base_url("estoque/necessidade-material/desconfirma-ordem/{$necessidade->cod_calculo_necessidade}") ?>"
                    method='post'>
                    <button type="submit" class="btn btn-danger">Confirma</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="novo-produto-producao">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Novo Produto de Produção</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form class="mb-0 needs-validation" novalidate
                            action="<?= base_url("estoque/necessidade-material/inserir-produto-producao/{$necessidade->cod_calculo_necessidade}") ?>"
                            method="post" id='formNovoProdutoProducao'>
                            <div class="form-row">
                                <div class="form-group col-md-9">
                                    <label for="inputProdutoProducao">Produto de Produção <span
                                            class="text-danger">*</span></label>
                                    <select id="inputProdutoProducao" class="selectpicker show-tick form-control"
                                        data-live-search="true" data-actions-box="true" name="CodProduto"
                                        data-style="btn-input-primary" title="Selecione um Produto" required>
                                        <?php foreach($lista_produto_prod as $key_produto_prod => $produto_prod) { ?>
                                        <option value="<?= $produto_prod->cod_produto ?>"
                                            <?php if($produto_prod->cod_produto == set_value('CodProduto')) echo "selected"; ?>>
                                            <?= $produto_prod->cod_produto ?> -
                                            <?= $produto_prod->nome_produto ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputTipoProdutoProducao">Tipo de Produto</label>
                                    <input type="text" class="form-control" id="inputTipoProdutoProducao" readonly
                                        name="TipoProdutoProducao" value="">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="inputUnidadeMedidaProducao">Unidade de
                                        Medida</label>
                                    <input class="form-control" id="inputUnidadeMedidaProducao" type="text" readonly
                                        name="UnidadeMedidaProducao" value="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="inputQuantNecessariaProducao">Quantidade
                                        Necessária <span class="text-danger">*</span></label>
                                    <input class="form-control" id="inputQuantNecessariaProducao" type="text"
                                        data-mask="#.##0,000" data-mask-reverse="true" name="QuantNecessariaProducao"
                                        value="<?= set_value('QuantNecessariaProducao'); ?>" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="inputDataNecessidadeProducao">Data de Necessidade
                                        <span class="text-danger">*</span></label>
                                    <input class="form-control" id="inputDataNecessidadeProducao" type="text"
                                        name="DataNecessidadeProducao"
                                        value="<?= set_value('DataNecessidadeProducao'); ?>" required>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="formNovoProdutoProducao"><i class="fas fa-save"></i>
                    Salvar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<?php foreach($lista_ordem_producao as $key_producao => $producao) { ?>
<div class="modal fade" id="editar-produto-producao<?= $producao->cod_calculo_necessidade_produto ?>">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Produto de Produção</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form class="mb-0 needs-validation" novalidate
                            action="<?= base_url("estoque/necessidade-material/salvar-produto-producao/{$producao->cod_calculo_necessidade_produto}/{$necessidade->cod_calculo_necessidade}") ?>"
                            method="post"
                            id='formEditarProdutoProducao<?= $producao->cod_calculo_necessidade_produto ?>'>
                            <div class="form-row">
                                <div class="form-group col-md-9">
                                    <label>Produto de Produção <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="inputTipoProdutoProducao" readonly
                                        name="TipoProdutoProducao"
                                        value="<?= $producao->cod_produto ?> - <?= $producao->nome_produto ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputTipoProdutoProducao">Tipo de Produto</label>
                                    <input type="text" class="form-control" id="inputTipoProdutoProducao" readonly
                                        name="TipoProdutoProducao" value="<?= $producao->nome_tipo_produto ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="control-label">Unidade de
                                        Medida</label>
                                    <input type="text" class="form-control" id="inputTipoProdutoProducao" readonly
                                        name="TipoProdutoProducao" value="<?= $producao->cod_unidade_medida ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="inputQuantNecessariaProducaoEdit">Quantidade
                                        Necessária <span class="text-danger">*</span></label>
                                    <input class="form-control" id="inputQuantNecessariaProducaoEdit" type="text"
                                        data-mask="#.##0,000" data-mask-reverse="true"
                                        name="QuantNecessariaProducaoEdit" value="<?= $producao->quant_necessidade ?>"
                                        required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Data de Necessidade
                                        <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text"
                                        value="<?= str_replace('-', '/', date("d-m-Y", strtotime($producao->data_necessidade))) ?>"
                                        readonly>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"
                    form="formEditarProdutoProducao<?= $producao->cod_calculo_necessidade_produto ?>"><i
                        class="fas fa-save"></i>
                    Salvar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<div class="modal fade" id="novo-produto-compra">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Novo Produto de Compra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form class="mb-0 needs-validation" novalidate
                            action="<?= base_url("estoque/necessidade-material/inserir-produto-compra/{$necessidade->cod_calculo_necessidade}") ?>"
                            method="post" id='formNovoProdutoCompra'>
                            <div class="form-row">
                                <div class="form-group col-md-9">
                                    <label for="inputProdutoCompra">Produto de Compra <span
                                            class="text-danger">*</span></label>
                                    <select id="inputProdutoCompra" class="selectpicker show-tick form-control"
                                        data-live-search="true" data-actions-box="true" data-style="btn-input-primary"
                                        title="Selecione um Produto" name="CodProduto" required>
                                        <?php foreach($lista_produto_comp as $key_produto_comp => $produto_comp) { ?>
                                        <option value="<?= $produto_comp->cod_produto ?>"
                                            <?php if($produto_comp->cod_produto == set_value('CodProduto')) echo "selected"; ?>>
                                            <?= $produto_comp->cod_produto ?> -
                                            <?= $produto_comp->nome_produto ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputTipoProdutoCompra">Tipo de Produto</label>
                                    <input type="text" class="form-control" id="inputTipoProdutoCompra" readonly
                                        name="TipoProdutoCompra" value="">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="inputUnidadeMedidaCompra">Unidade de
                                        Medida</label>
                                    <input class="form-control" id="inputUnidadeMedidaCompra" type="text" readonly
                                        name="UnidadeMedidaCompra" value="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="inputQuantNecessariaCompra">Quantidade
                                        Necessária <span class="text-danger">*</span></label>
                                    <input class="form-control" id="inputQuantNecessariaCompra" type="text"
                                        data-mask="#.##0,000" data-mask-reverse="true" name="QuantNecessariaCompra"
                                        value="<?= set_value('QuantNecessariaCompra'); ?>" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="inputDataNecessidadeCompra">Data de Necessidade
                                        <span class="text-danger">*</span></label>
                                    <input class="form-control" id="inputDataNecessidadeCompra" type="text"
                                        name="DataNecessidadeCompra" value="<?= set_value('DataNecessidadeCompra'); ?>"
                                        required>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="formNovoProdutoCompra"><i class="fas fa-save"></i>
                    Salvar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<?php foreach($lista_ordem_compra as $key_compra => $compra) { ?>
<div class="modal fade" id="editar-produto-compra<?= $compra->cod_calculo_necessidade_produto ?>">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Produto de Produção</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form class="mb-0 needs-validation" novalidate
                            action="<?= base_url("estoque/necessidade-material/salvar-produto-compra/{$compra->cod_calculo_necessidade_produto}/{$necessidade->cod_calculo_necessidade}") ?>"
                            method="post" id='formEditarProdutoCompra<?= $compra->cod_calculo_necessidade_produto ?>'>
                            <div class="form-row">
                                <div class="form-group col-md-9">
                                    <label>Produto de Produção <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="inputTipoProdutoCompra" readonly
                                        name="TipoProdutoCompra"
                                        value="<?= $compra->cod_produto ?> - <?= $compra->nome_produto ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputTipoProdutoCompra">Tipo de Produto</label>
                                    <input type="text" class="form-control" id="inputTipoProdutoCompra" readonly
                                        name="TipoProdutoCompra" value="<?= $compra->nome_tipo_produto ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="control-label">Unidade de
                                        Medida</label>
                                    <input type="text" class="form-control" id="inputTipoProdutoCompra" readonly
                                        name="TipoProdutoCompra" value="<?= $compra->cod_unidade_medida ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="inputQuantNecessariaCompraEdit">Quantidade
                                        Necessária <span class="text-danger">*</span></label>
                                    <input class="form-control" id="inputQuantNecessariaCompraEdit" type="text"
                                        data-mask="#.##0,000" data-mask-reverse="true" name="QuantNecessariaCompraEdit"
                                        value="<?= $compra->quant_necessidade ?>" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Data de Necessidade
                                        <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text"
                                        value="<?= str_replace('-', '/', date("d-m-Y", strtotime($compra->data_necessidade))) ?>"
                                        readonly>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"
                    form="formEditarProdutoCompra<?= $compra->cod_calculo_necessidade_produto ?>"><i
                        class="fas fa-save"></i>
                    Salvar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<script>
$(function() {
    $.applyDataMask();
});

$('#inputDataNecessidadeProducao').datepicker({
    uiLibrary: 'bootstrap4'
});

$('#inputDataNecessidadeCompra').datepicker({
    uiLibrary: 'bootstrap4'
});

$("[name='excluir_todos_pedidos[]']").click(function() {
    var cont = $("[name='excluir_todos_pedidos[]']:checked").length;
    $("#btnExcluirPedido").prop("disabled", cont ? false : true);
});

$("[name='excluir_todos_producao[]']").click(function() {
    var cont = $("[name='excluir_todos_producao[]']:checked").length;
    $("#btnExcluirProducao").prop("disabled", cont ? false : true);
});

$("[name='excluir_todos_compra[]']").click(function() {
    var cont = $("[name='excluir_todos_compra[]']:checked").length;
    $("#btnExcluirCompra").prop("disabled", cont ? false : true);
});

$("#inputProdutoProducao").change(function() {

    var baseurl = "<?php echo base_url(); ?>";

    var produto = $("#inputProdutoProducao").val();

    $.post(baseurl + "ajax/busca-produto", {
        produto: produto
    }, function(valor) {
        var aValor = valor.split('|');
        console.log(aValor);
        $("#inputUnidadeMedidaProducao").val(aValor[0]);
        $("#inputTipoProdutoProducao").val(aValor[1]);
    });

});

$("#inputProdutoCompra").change(function() {

    var baseurl = "<?php echo base_url(); ?>";

    var produto = $("#inputProdutoCompra").val();

    $.post(baseurl + "ajax/busca-produto", {
        produto: produto
    }, function(valor) {
        var aValor = valor.split('|');
        console.log(aValor);
        $("#inputUnidadeMedidaCompra").val(aValor[0]);
        $("#inputTipoProdutoCompra").val(aValor[1]);
    });

});

$(function(){ 
                   //evnto que deve carregar a janela a ser impressa 
    $('#imprimir').click(function(){ 

        var iFrame = document.createElement("iframe");
            iFrame.addEventListener("load", function () { 
            iFrame.contentWindow.focus();
            iFrame.contentWindow.print();
            window.setTimeout(function () {
                document.body.removeChild(iFrame);
            }, 0);
            });        
            iFrame.style.display = "none";
            iFrame.src = "<?= base_url("estoque/imprimir-necessidade-material/{$necessidade->cod_calculo_necessidade}") ?>";
            document.body.appendChild(iFrame);
    }); 
});
</script>

<?php $this->load->view('gerais/footer'); ?>