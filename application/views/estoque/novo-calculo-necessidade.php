<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active"><a
                    href="<?php echo base_url() ?>estoque/necessidade-material">Necessidade de Material</a></li>
            <li class="breadcrumb-item active">Novo Cálculo de Necessidade</a></li>
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
                                <form action="<?= base_url('estoque/necessidade-material/novo-calculo-necessidade') ?>"
                                    method="POST" id="CalculoNecessidade" class=" needs-validation" novalidate>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="inputDataInicio">Data Início <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputDataInicio"
                                                name="DataInicio" value="<?= set_value('DataInicio') ?>" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputDataFim">Data Fim <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputDataFim" name="DataFim"
                                                value="<?= set_value('DataFim'); ?>" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputTipoCalc">Tipo de Cálculo</label>
                                            <select id="inputTipoCalc" class="selectpicker show-tick form-control"
                                                 data-actions-box="true" data-style="btn-input-primary" name="TipoCalc">
                                                <option value="1" selected>Quantidade Líquida</option>
                                                <option value="2">Quantidade Bruta</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputObservacao">Observações do Cálculo</label>
                                            <textarea class="form-control" rows="3" id="inputObservacao"
                                                name="ObsCalculo"><?= set_value('ObsCalculo'); ?></textarea>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h6>Pedidos e Ordens</h6>
                                            <div lass="row">
                                                <ul class="nav nav-tabs">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" data-toggle="tab"
                                                            href="#pedidos">Pedidos Considerados</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab"
                                                            href="#ordens-estoque">Produtos a Produzir</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab"
                                                            href="#ordens-compra">Produtos
                                                            a Comprar</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="tab-content">
                                                <div class="tab-pane fade active show" id="pedidos">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-xs-12 mt-2">
                                                            <button type="button" class="btn btn-outline-primary btn-sm"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Você deve primeiramente salvar o cálculo de necessidade antes de atualizar lista de pedidos de venda"
                                                                disabled><i class="fas fa-sync-alt"></i> Atualizar Lista
                                                                de Pedidos</button>
                                                            <button type="button" class="btn btn-outline-danger btn-sm"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Você deve primeiramente salvar o cálculo de necessidade antes de excluir os pedidos de venda"
                                                                disabled><i class="fas fa-trash-alt"></i>
                                                                Excluir</button>
                                                        </div>
                                                    </div>
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
                                                        </tbody>
                                                    </table>
                                                    <div class="text-center" id="divAviso">
                                                        <p id="pAviso">Nenhum pedido de venda encontrado</p>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="ordens-estoque">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-xs-12 mt-2">
                                                            <button type="button" class="btn btn-outline-primary btn-sm"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Você deve primeiramente salvar o cálculo de necessidade antes de adicionar uma ordem de produção"
                                                                disabled><i class="fas fa-check-circle"></i> Adicionar
                                                                Produto</button>
                                                            <button type="button" class="btn btn-outline-danger btn-sm"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Você deve primeiramente salvar o cálculo de necessidade antes de excluir as ordens de produção"
                                                                disabled><i class="fas fa-trash-alt"></i>
                                                                Excluir</button>
                                                        </div>
                                                    </div>
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
                                                        </tbody>
                                                    </table>
                                                    <div class="text-center" id="divAviso">
                                                        <p id="pAviso">Nenhum produto de produtção adicionado</p>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="ordens-compra">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-xs-12 mt-2">
                                                            <button type="button" class="btn btn-outline-primary btn-sm"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Você deve primeiramente salvar o cálculo de necessidade antes de adicionar uma ordem de compra"
                                                                disabled><i class="fas fa-check-circle"></i> Adicionar
                                                                Produto</button>
                                                            <button type="button" class="btn btn-outline-danger btn-sm"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="Você deve primeiramente salvar o cálculo de necessidade antes de excluir as ordens de compra"
                                                                disabled><i class="fas fa-trash-alt"></i>
                                                                Excluir</button>
                                                        </div>
                                                    </div>
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
                                                        </tbody>
                                                    </table>
                                                    <div class="text-center" id="divAviso">
                                                        <p id="pAviso">Nenhum produto de compra adicionado</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="btn btn-outline-warning" disabled><i
                                                    class="fas fa-calculator"></i> Calcular Necessidade</button>
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
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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