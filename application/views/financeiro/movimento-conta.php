<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active"><a href="<?php echo base_url() ?>financeiro/saldo-conta">Saldo por
                    Conta</a></li>
            <li class="breadcrumb-item active">Movimentos da Conta</a></li>
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
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="inputCodConta">Código da Conta</label>
                                        <input type="text" class="form-control" id="inputCodConta"
                                            value="<?= $conta->cod_conta ?>" readonly>
                                    </div>
                                    <div class="form-group col-md-7">
                                        <label for="inputNomeConta">Nome da Conta</label>
                                        <input type="text" class="form-control" id="inputNomeConta"
                                            value="<?= $conta->nome_conta ?>" readonly>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="inputAtivo">Situação Conta</label>
                                        <input type="text" class="form-control" id="inputAtivo" value="<?php if($conta->ativo == 1) {
                                                            echo "Ativa";
                                                        }else{
                                                            echo "Inativa";
                                                        }
                                                        ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label class="control-label" for="inputSaldoConfirmado">Saldo Confirmado</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span
                                                    class="input-group-text <?php if($conta->saldo_conta < 0) echo "text-danger";
                                                                                         elseif($conta->saldo_conta > 0) echo "text-teal"; ?>">R$</span>
                                            </div>
                                            <input type="text"
                                                class="form-control <?php if($conta->saldo_conta < 0) echo "text-danger";
                                                                                         elseif($conta->saldo_conta > 0) echo "text-teal"; ?>"
                                                id="inputSaldoConfirmado" type="text"
                                                value="<?= number_format($conta->saldo_conta, 2, ',', '.') ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label" for="inputEntradasPrevistas">Entradas
                                            Previstas</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span
                                                    class="input-group-text <?php if($conta->proj_entrada > 0) echo "text-teal"; ?>">R$</span>
                                            </div>
                                            <input type="text"
                                                class="form-control <?php if($conta->proj_entrada > 0) echo "text-teal"; ?>"
                                                id="inputEntradasPrevistas" type="text"
                                                value="<?= number_format($conta->proj_entrada, 2, ',', '.') ?>"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label" for="inputSaidasPrevistas">Saídas Previstas</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span
                                                    class="input-group-text <?php if($conta->proj_saida > 0) echo "text-danger"; ?>">R$</span>
                                            </div>
                                            <input type="text"
                                                class="form-control <?php if($conta->proj_saida > 0) echo "text-danger"; ?>"
                                                id="inputSaidasPrevistas" type="text"
                                                value="<?= number_format($conta->proj_saida, 2, ',', '.') ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label" for="inputSaldoPrevisto">Saldo Previsto</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span
                                                    class="input-group-text <?php if(($conta->saldo_conta + $conta->proj_entrada - $conta->proj_saida) < 0) echo "text-danger";
                                                                                          elseif(($conta->saldo_conta + $conta->proj_entrada - $conta->proj_saida) > 0) echo "text-teal"; ?>">R$</span>
                                            </div>
                                            <input type="text"
                                                class="form-control <?php if(($conta->saldo_conta + $conta->proj_entrada - $conta->proj_saida) < 0) echo "text-danger";
                                                                                          elseif(($conta->saldo_conta + $conta->proj_entrada - $conta->proj_saida) > 0) echo "text-teal"; ?>"
                                                id="inputSaldoPrevisto" type="text"
                                                value="<?= number_format($conta->saldo_conta + $conta->proj_entrada - $conta->proj_saida, 2, ',', '.') ?>"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h6>Movimentos da Conta</h6>
                                                <form class="mb-0 needs-validation" novalidate
                                                    action="<?= base_url("financeiro/saldo-conta/movimento-conta/{$conta->cod_conta}") ?>"
                                                    method="GET">
                                                    <div class="row">
                                                        <div class="col-md-7 mb-0">
                                                            <button data-toggle="modal" data-target="#inserir-titulo"
                                                                type="button"
                                                                class="btn btn-outline-info btn-sm mb-0"><i
                                                                    class="fas fa-plus-circle"></i> Novo
                                                                Lançamento</button>
                                                            <button data-toggle="modal" data-target="#transferencia"
                                                                type="button" class="btn btn-outline-warning btn-sm"><i
                                                                    class="fas fa-exchange-alt"></i> Nova
                                                                Transferência</button>
                                                            <button data-toggle="modal" data-target="#confirma-titulo"
                                                                type="button" class="btn btn-outline-teal btn-sm"
                                                                id="btnConfirmar" disabled><i class="fas fa-check"></i>
                                                                Confirmar</button>
                                                            <button data-toggle="modal" data-target="#elimina-titulo"
                                                                type="button" class="btn btn-outline-danger  btn-sm"
                                                                id="btnExcluir" disabled><i
                                                                    class="fas fa-trash-alt"></i> Excluir</button>
                                                        </div>
                                                        <div class="form-group col-md-3 mb-0">
                                                            <div class="form-row">
                                                                <div class="form-group col-md-6 mb-0">
                                                                    <input class="form-control form-control-sm"
                                                                        id="inputDataInicio" type="text"
                                                                        name="DataInicio"
                                                                        value="<?= str_replace('-', '/', date("d-m-Y", strtotime($dataInicio))) ?>">
                                                                </div>
                                                                <div class="form-group col-md-6 mb-0">
                                                                    <input class="form-control form-control-sm"
                                                                        id="inputDataFim" type="text" name="DataFim"
                                                                        value="<?= str_replace('-', '/', date("d-m-Y", strtotime($dataFim))) ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="submit"
                                                                class="btn btn-outline-primary btn-block btn-sm">Atualizar</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <form
                                            action="<?= base_url("financeiro/saldo-conta/movimento-conta/acao-titulo/{$conta->cod_conta}") ?>"
                                            method="POST" id="formAcao" class=" needs-validation" novalidate>
                                            <table class="table table-bordered table-striped table-hover small">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th scope="col" class="text-center">#</th>
                                                        <th scope="col" class="text-center">Data Mov</th>
                                                        <th scope="col" class="text-center">Título</th>
                                                        <th scope="col">Centro de Custo</th>
                                                        <th scope="col">Conta Contábil</th>
                                                        <th scope="col">Descrição</th>
                                                        <th scope="col" class="text-center">Parcela</th>
                                                        <th scope="col" class="text-center">Valor Mov</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($lista_titulos as $key_titulos => $titulo) { ?>
                                                    <tr>
                                                        <td>
                                                            <div class="checkbox text-center">
                                                                <?php if($titulo->confirmado != 1){ ?>
                                                                <input name="selecionar_todos[]" type="checkbox"
                                                                    value="<?= $titulo->cod_movimento_conta ?>" />
                                                                <?php }else{ echo "<i class='fas fa-check-circle text-teal'></i>"; }?>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <?= str_replace('-', '/', date("d-m-Y", strtotime($titulo->data_movimento))) ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="#" data-toggle="modal"
                                                                data-target="#editar-titulo<?= $titulo->cod_movimento_conta ?>">
                                                                <?= $titulo->cod_movimento_conta ?></a>
                                                        </td>
                                                        <td class="limit-text-30" data-toggle="tooltip"
                                                            data-placement="bottom"
                                                            title="<?php if($titulo->cod_centro_custo != "") echo $titulo->cod_centro_custo . " - " . $titulo->nome_centro_custo ?>">
                                                            <?php if($titulo->cod_centro_custo != "") echo $titulo->cod_centro_custo . " - " . $titulo->nome_centro_custo ?>
                                                        </td>
                                                        <td class="limit-text-30" data-toggle="tooltip"
                                                            data-placement="bottom"
                                                            title="<?php if($titulo->cod_conta_contabil != "") echo $titulo->cod_conta_contabil . " - " . $titulo->nome_conta_contabil ?>">
                                                            <?php if($titulo->cod_conta_contabil != "") echo $titulo->cod_conta_contabil . " - " . $titulo->nome_conta_contabil ?>
                                                        </td>
                                                        <td class="limit-text-50" data-toggle="tooltip"
                                                            data-placement="bottom"
                                                            title="<?= $titulo->desc_movimento ?>">
                                                            <?= $titulo->desc_movimento ?></td>
                                                        <td class="text-center"><?= $titulo->parcela ?></td>
                                                        <td
                                                            class="text-center <?php if($titulo->tipo_movimento == 2) echo "text-danger"; ?>
                                                                                <?php if($titulo->tipo_movimento == 1) echo "text-teal"; ?>">
                                                            R$ <?php if($titulo->tipo_movimento == 2) echo "-"; ?><?php if($titulo->confirmado == 1) echo number_format($titulo->valor_confirmado, 2, ',', '.');
                                                                     else echo number_format($titulo->valor_titulo, 2, ',', '.');
                                                              ?>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            <?php if ($lista_titulos == false) { ?>
                                            <div class="text-center">
                                                <p>Nenhum título encontrado</p>
                                            </div>
                                            <?php } ?>
                                        </form>
                                    </div>
                                </div>
                                <hr>
                                <div class="row float-right">
                                    <div class="col-lg-12 col-md-12 col-xs-12">
                                        <a href="<?php echo base_url() ?>financeiro/saldo-conta" type="button"
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
</section>

<div class="modal fade" id="elimina-titulo" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Título</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Confirma eliminação do(s) título(s) selecionado(s)?
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="Acao" value="Eliminar"
                    form="formAcao">Confirma</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirma-titulo" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Título</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Deseja confirmar o(s) título(s) selecionado(s)?
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="Acao" value="Confirmar"
                    form="formAcao">Confirma</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="inserir-titulo">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Lançamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <form class="mb-0 needs-validation" novalidate
                            action="<?= base_url("financeiro/saldo-conta/inserir-titulo/{$conta->cod_conta}") ?>"
                            method='post' id='formTitulo'>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputTipoMovimento">Tipo de Movimento</label>
                                    <select id="inputTipoMovimento" class="selectpicker show-tick form-control"
                                        data-actions-box="true" data-style="btn-input-primary" name="TipoMovimento">
                                        <option value="1">Receita</option>
                                        <option value="2">Despesa</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputDataCompetencia">Data de Competência <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="inputDataCompetencia"
                                        name="DataCompetencia" value="<?php if(set_value('DataCompetencia') == ""){
                                                                echo str_replace('-', '/', date("d-m-Y"));
                                                            }else{ echo set_value('DataCompetencia'); } ?>" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="inputValorTitulo">Valor do Título <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" class="form-control" class="form-control"
                                            id="inputValorTitulo" type="text" name="ValorTitulo" data-mask="#.##0,00"
                                            data-mask-reverse="true" value="<?= set_value('ValorTitulo'); ?>" required>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputDataVencimento">Data de Vencimento <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="inputDataVencimento"
                                        name="DataVencimento" value="<?php if(set_value('DataVencimento') == ""){
                                                                echo str_replace('-', '/', date("d-m-Y"));
                                                            }else{ echo set_value('DataVencimento'); } ?>" required>
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputCentroCusto">Centro de Custo</label>
                                    <select id="inputCentroCusto" class="selectpicker show-tick form-control"
                                        data-live-search="true" data-actions-box="true"
                                        title="Selecione um Centro de Custo" name="CodCentroCusto"
                                        data-style="btn-input-primary">
                                        <?php foreach($lista_centro_custo as $key_centro_custo => $centro_custo) { ?>
                                        <option value="<?= $centro_custo->cod_centro_custo ?>"
                                            <?php if($centro_custo->cod_centro_custo == set_value('CodCentroCusto')) echo "selected"; ?>>
                                            <?= $centro_custo->cod_centro_custo ?> -
                                            <?= $centro_custo->nome_centro_custo ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputContaContabil">Conta Contábil</label>
                                    <select id="inputContaContabil" class="selectpicker show-tick form-control"
                                        data-live-search="true" data-actions-box="true"
                                        title="Selecione uma Conta Contábil" name="CodContaContabil"
                                        data-style="btn-input-primary">
                                        <?php foreach($lista_conta_contabil as $key_conta_contabil => $conta_contabil) { ?>
                                        <option value="<?= $conta_contabil->cod_conta_contabil ?>"
                                            <?php if($conta_contabil->cod_conta_contabil == set_value('CodCentroCusto')) echo "selected"; ?>>
                                            <?= $conta_contabil->cod_conta_contabil ?> -
                                            <?= $conta_contabil->nome_conta_contabil ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="control-label" for="inputDescricao">Descrição Título</label>
                                    <input class="form-control" id="inputDescricao" type="text" name="Descricao"
                                        value="<?= set_value('Descricao') ?>">
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="inputConfirmar"
                                            name="Confirmar" value="1">
                                        <label class="custom-control-label" for="inputConfirmar">Confirmar
                                            Título</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row" id="dataConfirmacao" style="display: none">
                                <div class="form-group col-md-3">
                                    <label class="control-label">Data da Confirmação</label>
                                    <input type="text" class="form-control" id="inputDataConfirmacao"
                                        name="DataConfirmacao" value="<?= set_value('DataConfirmacao') ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="inputValorDescontoTaxas">Descontos e Taxas</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" class="form-control" class="form-control"
                                            id="inputValorDescontoTaxas" type="text" name="ValorDescontoTaxas"
                                            data-mask="#.##0,00" data-mask-reverse="true"
                                            value="<?= set_value('ValorDescontoTaxas'); ?>">
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="inputValorMultasJustos">Multas e Juros</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" class="form-control" class="form-control"
                                            id="inputValorMultasJustos" type="text" name="ValorMultasJustos"
                                            data-mask="#.##0,00" data-mask-reverse="true"
                                            value="<?= set_value('ValorMultasJustos'); ?>">
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="inputValorConfirmado">Valor a Pagar</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" class="form-control" class="form-control" readonly
                                            id="inputValorConfirmado" type="text" name="ValorConfirmado"
                                            data-mask="#.##0,00" data-mask-reverse="true"
                                            value="<?= set_value('ValorReceber'); ?>">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="formTitulo"><i class="fas fa-save"></i>
                    Salvar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="transferencia">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nova Transferência</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <form class="mb-0 needs-validation" novalidate
                            action="<?= base_url("financeiro/saldo-conta/inserir-transferencia/{$conta->cod_conta}") ?>"
                            method='post' id='formTransf'>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputConta">Conta Destino <span class="text-danger">*</span></label>
                                    <select id="inputConta" class="selectpicker show-tick form-control"
                                        data-live-search="true" data-actions-box="true" title="Selecione uma Conta"
                                        name="CodConta" data-style="btn-input-primary" required>
                                        <?php foreach($lista_conta as $key_conta => $conta) { ?>
                                        <option value="<?= $conta->cod_conta ?>"
                                            <?php if($conta->cod_conta == set_value('CodConta')) echo "selected"; ?>>
                                            <?= $conta->cod_conta ?> - <?= $conta->nome_conta ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputDataCompetenciaTrans">Data de Competência <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="inputDataCompetenciaTrans"
                                        name="DataCompetencia" value="<?php if(set_value('DataCompetencia') == ""){
                                                                echo str_replace('-', '/', date("d-m-Y"));
                                                            }else{ echo set_value('DataCompetencia'); } ?>" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label" for="inputValorTituloTrans">Valor do Título <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" class="form-control" class="form-control"
                                            id="inputValorTituloTrans" type="text" name="ValorTitulo" data-mask="#.##0,00"
                                            data-mask-reverse="true" value="<?= set_value('ValorTitulo'); ?>" required>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputDataVencimentoTrans">Data de Vencimento <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="inputDataVencimentoTrans"
                                        name="DataVencimento" value="<?php if(set_value('DataVencimento') == ""){
                                                                echo str_replace('-', '/', date("d-m-Y"));
                                                            }else{ echo set_value('DataVencimento'); } ?>" required>
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputCentroCustoTrans">Centro de Custo</label>
                                    <select id="inputCentroCustoTrans" class="selectpicker show-tick form-control"
                                        data-live-search="true" data-actions-box="true"
                                        title="Selecione um Centro de Custo" name="CodCentroCusto"
                                        data-style="btn-input-primary">
                                        <?php foreach($lista_centro_custo as $key_centro_custo => $centro_custo) { ?>
                                        <option value="<?= $centro_custo->cod_centro_custo ?>"
                                            <?php if($centro_custo->cod_centro_custo == set_value('CodCentroCusto')) echo "selected"; ?>>
                                            <?= $centro_custo->cod_centro_custo ?> -
                                            <?= $centro_custo->nome_centro_custo ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputContaContabilTrans">Conta Contábil</label>
                                    <select id="inputContaContabilTrans" class="selectpicker show-tick form-control"
                                        data-live-search="true" data-actions-box="true"
                                        title="Selecione uma Conta Contábil" name="CodContaContabil"
                                        data-style="btn-input-primary">
                                        <?php foreach($lista_conta_contabil as $key_conta_contabil => $conta_contabil) { ?>
                                        <option value="<?= $conta_contabil->cod_conta_contabil ?>"
                                            <?php if($conta_contabil->cod_conta_contabil == set_value('CodCentroCusto')) echo "selected"; ?>>
                                            <?= $conta_contabil->cod_conta_contabil ?> -
                                            <?= $conta_contabil->nome_conta_contabil ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="control-label" for="inputDescricaoTrans">Descrição Transferência</label>
                                    <input class="form-control" id="inputDescricaoTrans" type="text" name="Descricao"
                                        value="<?= set_value('Descricao') ?>">
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="inputConfirmarTrans"
                                            name="Confirmar" value="1">
                                        <label class="custom-control-label" for="inputConfirmarTrans">Confirmar
                                            Título</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row" id="dataConfirmacaoTrans" style="display: none">
                                <div class="form-group col-md-3">
                                    <label class="control-label">Data da Confirmação</label>
                                    <input type="text" class="form-control" id="inputDataConfirmacaoTrans"
                                        name="DataConfirmacao" value="<?= set_value('DataConfirmacao') ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="inputValorDescontoTaxasTrans">Descontos e Taxas</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" class="form-control" class="form-control"
                                            id="inputValorDescontoTaxasTrans" type="text" name="ValorDescontoTaxas"
                                            data-mask="#.##0,00" data-mask-reverse="true"
                                            value="<?= set_value('ValorDescontoTaxas'); ?>">
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="inputValorMultasJustosTrans">Multas e Juros</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" class="form-control" class="form-control"
                                            id="inputValorMultasJustosTrans" type="text" name="ValorMultasJustos"
                                            data-mask="#.##0,00" data-mask-reverse="true"
                                            value="<?= set_value('ValorMultasJustos'); ?>">
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label" for="inputValorConfirmadoTrans">Valor a Pagar</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" class="form-control" class="form-control" readonly
                                            id="inputValorConfirmadoTrans" type="text" name="ValorConfirmado"
                                            data-mask="#.##0,00" data-mask-reverse="true"
                                            value="<?= set_value('ValorReceber'); ?>">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="formTransf"><i class="fas fa-save"></i>
                    Salvar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<?php foreach($lista_titulos as $key_titulos => $titulo) { ?>
<div class="modal fade" id="editar-titulo<?= $titulo->cod_movimento_conta ?>">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Título</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <form class="mb-0 needs-validation" novalidate
                            action="<?= base_url("financeiro/saldo-conta/salvar-titulo/{$titulo->cod_movimento_conta}/{$titulo->cod_conta}") ?>"
                            method='post' id='formTitulo<?= $titulo->cod_movimento_conta ?>'>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="inputTituloEdit<?= $titulo->cod_movimento_conta ?>">Título</label>
                                    <input type="text" class="form-control" class="form-control"
                                        id="inputTituloEdit<?= $titulo->cod_movimento_conta ?>" type="text"
                                        value="<?= $titulo->cod_movimento_conta ?>" readonly>
                                </div>
                                <div class="form-group col-md-10">
                                    <label for="inputTipoMovimentoEdit<?= $titulo->cod_movimento_conta ?>">Tipo de
                                        Movimento</label>
                                    <input type="text" class="form-control" class="form-control"
                                        id="inputTipoMovimentoEdit<?= $titulo->cod_movimento_conta ?>" type="text"
                                        value="<?php if($titulo->tipo_movimento == 1){ echo "Receita"; }
                                                       elseif($titulo->tipo_movimento == 2){ echo "Despesa"; } ?>"
                                        readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="control-label">Data de Competência</label>
                                    <input class="form-control" type="text"
                                        value="<?= str_replace('-', '/', date("d-m-Y", strtotime($titulo->data_competencia))) ?>"
                                        readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label"
                                        for="inputValorTituloEdit<?= $titulo->cod_movimento_conta ?>">Valor do Título
                                        <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" class="form-control" class="form-control"
                                            id="inputValorTituloEdit<?= $titulo->cod_movimento_conta ?>" type="text"
                                            name="ValorTitulo" data-mask="#.##0,00" data-mask-reverse="true"
                                            value="<?= number_format($titulo->valor_titulo, 2, ',', '.') ?>"
                                            <?php if($titulo->confirmado == 1) echo "readonly"; ?> required>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputDataVencimentoEdit<?= $titulo->cod_movimento_conta ?>">Data de
                                        Vencimento <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control"
                                        id="inputDataVencimentoEdit<?= $titulo->cod_movimento_conta ?>"
                                        name="DataVencimento"
                                        value="<?= str_replace('-', '/', date("d-m-Y", strtotime($titulo->data_vencimento))) ?>"
                                        <?php if($titulo->confirmado == 1) echo "readonly"; ?> required>
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputCentroCusto">Centro de Custo</label>
                                    <?php if($titulo->confirmado == 1) { ?>
                                    <input type="text" class="form-control" class="form-control" type="text"
                                        value="<?php if($titulo->cod_centro_custo != null) echo $titulo->cod_centro_custo . " - " . $titulo->nome_centro_custo ?>"
                                        readonly>
                                    <?php }else{ ?>
                                    <select id="inputCentroCusto<?= $titulo->cod_movimento_conta ?>"
                                        class="selectpicker show-tick form-control" data-live-search="true"
                                        data-actions-box="true" title="Selecione um Centro de Custo"
                                        name="CodCentroCusto" data-style="btn-input-primary">
                                        <?php foreach($lista_centro_custo as $key_centro_custo => $centro_custo) { ?>
                                        <option value="<?= $centro_custo->cod_centro_custo ?>"
                                            <?php if($centro_custo->cod_centro_custo == $titulo->cod_centro_custo) echo "selected"; ?>>
                                            <?= $centro_custo->cod_centro_custo ?> -
                                            <?= $centro_custo->nome_centro_custo ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                    <?php } ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputContaContabil">Conta Contábil</label>
                                    <?php if($titulo->confirmado == 1) { ?>
                                    <input type="text" class="form-control" class="form-control" type="text"
                                        value="<?php if($titulo->cod_conta_contabil != null) echo $titulo->cod_conta_contabil . " - " . $titulo->nome_conta_contabil ?>"
                                        readonly>
                                    <?php }else{ ?>
                                    <select class="selectpicker show-tick form-control" data-live-search="true"
                                        data-actions-box="true" title="Selecione uma Conta Contábil"
                                        name="CodContaContabil" data-style="btn-input-primary">
                                        <?php foreach($lista_conta_contabil as $key_conta_contabil => $conta_contabil) { ?>
                                        <option value="<?= $conta_contabil->cod_conta_contabil ?>"
                                            <?php if($conta_contabil->cod_conta_contabil == $titulo->cod_conta_contabil) echo "selected"; ?>>
                                            <?= $conta_contabil->cod_conta_contabil ?> -
                                            <?= $conta_contabil->nome_conta_contabil ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="control-label"
                                        for="inputDescricaoEdit<?= $titulo->cod_movimento_conta ?>">Descrição
                                        Título</label>
                                    <input class="form-control"
                                        id="inputDescricaoEdit<?= $titulo->cod_movimento_conta ?>" type="text"
                                        name="Descricao" value="<?= $titulo->desc_movimento ?>"
                                        <?php if($titulo->confirmado == 1) echo "readonly"; ?>>
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input"
                                            id="inputConfirmarEdit<?= $titulo->cod_movimento_conta ?>" name="Confirmar"
                                            value="1" <?php if($titulo->confirmado == 1) echo "checked"; ?>>
                                        <label class="custom-control-label"
                                            for="inputConfirmarEdit<?= $titulo->cod_movimento_conta ?>">Confirmar
                                            Título</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row" id="dataConfirmacao<?= $titulo->cod_movimento_conta ?>"
                                <?php if($titulo->confirmado == 0) echo "style='display: none'"; ?>>
                                <div class="form-group col-md-3">
                                    <label class="control-label"
                                        for="inputDataConfirmacao<?= $titulo->cod_movimento_conta ?>">Data de
                                        Confirmação <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control"
                                        id="inputDataConfirmacao<?= $titulo->cod_movimento_conta ?>"
                                        name="DataConfirmacao" <?php if($titulo->confirmado == 1) echo "readonly"; ?>
                                        value="<?php if($titulo->confirmado == 1) echo str_replace('-', '/', date("d-m-Y", strtotime($titulo->data_confirmacao))); ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label"
                                        for="inputValorDescontoTaxas<?= $titulo->cod_movimento_conta ?>">Descontos e
                                        Taxas</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" class="form-control" class="form-control"
                                            <?php if($titulo->confirmado == 1) echo "readonly"; ?>
                                            id="inputValorDescontoTaxas<?= $titulo->cod_movimento_conta ?>" type="text"
                                            name="ValorDescontoTaxas" data-mask="#.##0,00" data-mask-reverse="true"
                                            value="<?= number_format($titulo->valor_desc_taxa, 2, ',', '.') ?>">
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label"
                                        for="inputValorMultasJustos<?= $titulo->cod_movimento_conta ?>">Multas e
                                        Juros</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" class="form-control" class="form-control"
                                            <?php if($titulo->confirmado == 1) echo "readonly"; ?>
                                            id="inputValorMultasJustos<?= $titulo->cod_movimento_conta ?>" type="text"
                                            name="ValorMultasJustos" data-mask="#.##0,00" data-mask-reverse="true"
                                            value="<?= number_format($titulo->valor_juros_multa, 2, ',', '.') ?>">
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label"
                                        for="inputValorConfirmado<?= $titulo->cod_movimento_conta ?>">Valor
                                        Confirmado</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">R$</span>
                                        </div>
                                        <input type="text" class="form-control" class="form-control" readonly
                                            id="inputValorConfirmado<?= $titulo->cod_movimento_conta ?>" type="text"
                                            name="ValorConfirmado" data-mask="#.##0,00" data-mask-reverse="true"
                                            value="<?= number_format($titulo->valor_confirmado, 2, ',', '.') ?>">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="formTitulo<?= $titulo->cod_movimento_conta ?>"><i
                        class="fas fa-save"></i>
                    Salvar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<script>
$('.page-item>a').addClass("page-link");

$("[name='selecionar_todos[]']").click(function() {
    var cont = $("[name='selecionar_todos[]']:checked").length;
    $("#btnExcluir").prop("disabled", cont ? false : true);
});

$("[name='selecionar_todos[]']").click(function() {
    var cont = $("[name='selecionar_todos[]']:checked").length;
    $("#btnConfirmar").prop("disabled", cont ? false : true);
});

$(function() {
    $.applyDataMask();
});

$('#inputDataVencimento').datepicker({
    uiLibrary: 'bootstrap4'
});

$('#inputDataCompetencia').datepicker({
    uiLibrary: 'bootstrap4'
});

$('#inputDataInicio').datepicker({
    uiLibrary: 'bootstrap4'
});

$('#inputDataFim').datepicker({
    uiLibrary: 'bootstrap4'
});

$('#inputDataConfirmacao').datepicker({
    uiLibrary: 'bootstrap4'
});

$('#inputDataConfirmacaoTrans').datepicker({
    uiLibrary: 'bootstrap4'
});

$('#inputDataVencimentoTrans').datepicker({
    uiLibrary: 'bootstrap4'
});

$('#inputDataCompetenciaTrans').datepicker({
    uiLibrary: 'bootstrap4'
});

$("#inputConfirmar").on('change', function() {

    if ($("#dataConfirmacao").is(":hidden")) {
        $("#dataConfirmacao").show(300);
        $("#inputDataConfirmacao").val("<?= str_replace('-', '/', date("d-m-Y")) ?>");
        calcValorTitulo();
    } else {
        $("#dataConfirmacao").hide(300);
        $("#inputDataConfirmacao").val("");
        $("#inputValorConfirmado").val("");
    };

});

$("#inputConfirmarTrans").on('change', function() {

    if ($("#dataConfirmacaoTrans").is(":hidden")) {
        $("#dataConfirmacaoTrans").show(300);
        $("#inputDataConfirmacaoTrans").val("<?= str_replace('-', '/', date("d-m-Y")) ?>");
        calcValorTituloTrans();
    } else {
        $("#dataConfirmacaoTrans").hide(300);
        $("#inputDataConfirmacaoTrans").val("");
        $("#inputValorConfirmadoTrans").val("");
    };

});

jQuery('#inputValorTitulo').on('keyup', function() {
    calcValorTitulo();
});
jQuery('#inputValorDescontoTaxas').on('keyup', function() {
    calcValorTitulo();
});
jQuery('#inputValorMultasJustos').on('keyup', function() {
    calcValorTitulo();
});

jQuery('#inputValorTituloTrans').on('keyup', function() {
    calcValorTituloTrans();
});
jQuery('#inputValorDescontoTaxasTrans').on('keyup', function() {
    calcValorTituloTrans();
});
jQuery('#inputValorMultasJustosTrans').on('keyup', function() {
    calcValorTituloTrans();
});

function calcValorTitulo() {

    var chkConfirm = document.getElementById("inputConfirmar");
    if (chkConfirm.checked == true) {

        var valorTitulo = parseFloat(jQuery('#inputValorTitulo').val() != '' ? (jQuery('#inputValorTitulo').val().split(
            '.').join('')).replace(',', '.') : 0);
        var descTaxas = parseFloat(jQuery('#inputValorDescontoTaxas').val() != '' ? (jQuery('#inputValorDescontoTaxas')
            .val().split('.').join('')).replace(',', '.') : 0);
        var multJuros = parseFloat(jQuery('#inputValorMultasJustos').val() != '' ? (jQuery('#inputValorMultasJustos')
            .val().split('.').join('')).replace(',', '.') : 0);

        var totalPagar = valorTitulo - descTaxas + multJuros;

        $('#inputValorConfirmado').val(totalPagar.toLocaleString("pt-BR", {
            style: "decimal",
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));

    }

}

function calcValorTituloTrans() {

    var chkConfirm = document.getElementById("inputConfirmarTrans");
    if (chkConfirm.checked == true) {

        var valorTitulo = parseFloat(jQuery('#inputValorTituloTrans').val() != '' ? (jQuery('#inputValorTituloTrans').val().split(
            '.').join('')).replace(',', '.') : 0);
        var descTaxas = parseFloat(jQuery('#inputValorDescontoTaxasTrans').val() != '' ? (jQuery('#inputValorDescontoTaxasTrans')
            .val().split('.').join('')).replace(',', '.') : 0);
        var multJuros = parseFloat(jQuery('#inputValorMultasJustosTrans').val() != '' ? (jQuery('#inputValorMultasJustosTrans')
            .val().split('.').join('')).replace(',', '.') : 0);

        var totalPagar = valorTitulo - descTaxas + multJuros;

        $('#inputValorConfirmadoTrans').val(totalPagar.toLocaleString("pt-BR", {
            style: "decimal",
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));

    }

}

<?php foreach($lista_titulos as $key_titulo => $titulo) { if($titulo->confirmado == 0) { ?>
$('#inputDataVencimentoEdit<?= $titulo->cod_movimento_conta ?>').datepicker({
    uiLibrary: 'bootstrap4'
});

$('#inputDataConfirmacao<?= $titulo->cod_movimento_conta ?>').datepicker({
    uiLibrary: 'bootstrap4'
});

$("#inputConfirmarEdit<?= $titulo->cod_movimento_conta ?>").on('change', function() {

    if ($("#dataConfirmacao<?= $titulo->cod_movimento_conta ?>").is(":hidden")) {
        $("#dataConfirmacao<?= $titulo->cod_movimento_conta ?>").show(300);
        $("#inputDataConfirmacao<?= $titulo->cod_movimento_conta ?>").val(
            "<?= str_replace('-', '/', date("d-m-Y")) ?>");
        calcValorTituloEdit(<?= $titulo->cod_movimento_conta ?>);
    } else {
        $("#dataConfirmacao<?= $titulo->cod_movimento_conta ?>").hide(300);
        $("#inputDataConfirmacao<?= $titulo->cod_movimento_conta ?>").val("");
        $("#inputValorConfirmado<?= $titulo->cod_movimento_conta ?>").val("");
    };

});

jQuery('#inputValorTitulo<?= $titulo->cod_movimento_conta ?>').on('keyup', function() {
    calcValorTituloEdit(<?= $titulo->cod_movimento_conta ?>);
});
jQuery('#inputValorDescontoTaxas<?= $titulo->cod_movimento_conta ?>').on('keyup', function() {
    calcValorTituloEdit(<?= $titulo->cod_movimento_conta ?>);
});
jQuery('#inputValorMultasJustos<?= $titulo->cod_movimento_conta ?>').on('keyup', function() {
    calcValorTituloEdit(<?= $titulo->cod_movimento_conta ?>);
});

function calcValorTituloEdit(cod_movimento_conta) {

    var chkConfirm = document.getElementById("inputConfirmarEdit" + cod_movimento_conta);
    if (chkConfirm.checked == true) {

        var valorTitulo = parseFloat(jQuery('#inputValorTituloEdit' + cod_movimento_conta).val() != '' ? (jQuery(
            '#inputValorTituloEdit' + cod_movimento_conta).val().split('.').join('')).replace(',', '.') : 0);
        var descTaxas = parseFloat(jQuery('#inputValorDescontoTaxas' + cod_movimento_conta).val() != '' ? (jQuery(
            '#inputValorDescontoTaxas' + cod_movimento_conta).val().split('.').join('')).replace(',', '.') : 0);
        var multJuros = parseFloat(jQuery('#inputValorMultasJustos' + cod_movimento_conta).val() != '' ? (jQuery(
            '#inputValorMultasJustos' + cod_movimento_conta).val().split('.').join('')).replace(',', '.') : 0);

        var totalPagar = valorTitulo - descTaxas + multJuros;

        $('#inputValorConfirmado' + cod_movimento_conta).val(totalPagar.toLocaleString("pt-BR", {
            style: "decimal",
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));

    }
}

<?php }else{ ?>



$("#inputConfirmarEdit<?= $titulo->cod_movimento_conta ?>").on('change', function() {

    if ($("#dataConfirmacao<?= $titulo->cod_movimento_conta ?>").is(":hidden")) {
        $("#dataConfirmacao<?= $titulo->cod_movimento_conta ?>").show(300);
    } else {
        $("#dataConfirmacao<?= $titulo->cod_movimento_conta ?>").hide(300);
    };

});
<?php }} ?>
</script>

<?php $this->load->view('gerais/footer'); ?>