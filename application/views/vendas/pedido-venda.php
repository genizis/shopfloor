<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active">Pedido de Venda</li>
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
                            <div class="col-md-9">
                                <a href="<?php echo base_url() ?>vendas/pedido-venda/novo-pedido-venda" type="button"
                                    class="btn btn-info"><i class="fas fa-plus-circle"></i> Novo Pedido de Venda</a>
                                <?php if($empresa->integ_vendas_externas == 1){ ?>
                                <button id="btnIntegracao" type="button" class="btn btn-secondary dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Integração
                                </button>
                                <div class="dropdown-menu" aria-labelledby="btnIntegracao">
                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                        data-target="#importa-atendimento">Importar Atendimentos Vendas Externas</a>
                                </div>
                                <?php } ?>
                                <button data-toggle="modal" data-target="#elimina-pedido" type="button"
                                    class="btn btn-danger" id="btnExcluir" disabled><i class="fas fa-trash-alt"></i>
                                    Excluir</button>
                            </div>
                            <div class="col-md-3">
                                <form action="<?= base_url('vendas/pedido-venda') ?>" method="GET" class=" needs-validation" novalidate>
                                    <div class="input-group">
                                        <input type="text" class="form-control search" name="buscar">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-secondary"><i
                                                    class="fas fa-search"></i> Buscar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
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
                                <form action="<?= base_url('vendas/pedido-venda/excluir-pedido-venda') ?>" method="POST"
                                    id="formDelete"  class="mb-0 needs-validation" novalidate>
                                    <table class="table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col" class="text-center">#</th>
                                                <th scope="col" class="text-center">Ped Venda</th>
                                                <th scope="col">Nome do Cliente</th>
                                                <th scope="col" class="text-center">Data de Emissão</th>
                                                <th scope="col" class="text-center">Data de Entrega</th>
                                                <th scope="col" class="text-center">Total do Pedido</th>
                                                <th scope="col" class="text-center">Situação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($lista_pedido as $key_pedido => $pedido) { ?>
                                            <tr>
                                                <td>
                                                    <div class="checkbox text-center">
                                                        <input name="excluir_todos[]" type="checkbox"
                                                            value="<?= $pedido->num_pedido_venda ?>"
                                                            <?php if($pedido->count_faturamento != 0) echo "disabled"; ?> />
                                                    </div>
                                                </td>
                                                <td scope="row" class="text-center"><a
                                                        href="<?= base_url("vendas/pedido-venda/editar-pedido-venda/{$pedido->num_pedido_venda}") ?>"><?= $pedido->num_pedido_venda ?></a>
                                                </td>
                                                <td><?= $pedido->cod_cliente ?> - <?= $pedido->nome_cliente ?></td>
                                                <td class="text-center">
                                                    <?= str_replace('-', '/', date("d-m-Y", strtotime($pedido->data_emissao))) ?>
                                                </td>
                                                <td class="text-center">
                                                    <?= str_replace('-', '/', date("d-m-Y", strtotime($pedido->data_entrega))) ?>
                                                </td>
                                                <td class="text-center">R$
                                                    <?php if($pedido->valor_desconto != 0){
                                                            if($pedido->tipo_desconto == 1){
                                                                echo number_format($pedido->valor_total_pedido - $pedido->valor_desconto, 2, ',', '.');
                                                            }elseif($pedido->tipo_desconto == 2){
                                                                echo number_format($pedido->valor_total_pedido - ($pedido->valor_total_pedido * ($pedido->valor_desconto / 100)), 2, ',', '.');
                                                            }
                                                        }else{
                                                            echo number_format($pedido->valor_total_pedido, 2, ',', '.');
                                                        }
                                                    ?>
                                                </td>
                                                <td class="text-center"><?php  
                                                    switch ($pedido->situacao) {
                                                        case 1:
                                                            echo "<span class='badge badge-secondary'>Em Orçamento</span>";
                                                            break;
                                                        case 2:
                                                            echo "<span class='badge badge-danger'>Orçamento Reprovado</span>";
                                                            break;
                                                        case 3:
                                                            echo "<span class='badge badge-teal'>Venda Confirmada</span>";
                                                            break;
                                                    }
                                                ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <?php if ($lista_pedido == false) { ?>
                                    <div class="text-center">
                                        <p class="text-muted mb-0">Nenhum pedido de venda encontrado</p>
                                    </div>
                                    <?php } ?>
                                </form>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-xs-12">
                                <div>
                                    <?= $pagination; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
                <button type="submit" class="btn btn-primary" form="formDelete">Confirma</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="importa-atendimento" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Importar Atendimentos - Vendas Externas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAtendimento" class="mb-0 needs-validation" novalidate
                        action="<?= base_url("vendas/importar-atendimentos-vendas-externas") ?>"
                        method="GET">
                    <div class="form-group">
                        <label for="inputDataAtendimento">Data dos Atendimentos</label>
                        <input type="text" class="form-control" id="inputDataAtendimento" name="DataAtendimento"
                        value="<?= str_replace('-', '/', date("d-m-Y")) ?>">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="formAtendimento" id="btnSpinner">Confirma</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
$('.page-item>a').addClass("page-link");

$("[name='excluir_todos[]']").click(function() {
    var cont = $("[name='excluir_todos[]']:checked").length;
    $("#btnExcluir").prop("disabled", cont ? false : true);
});

$('#inputDataAtendimento').datepicker({
    uiLibrary: 'bootstrap4'
});

</script>

<?php $this->load->view('gerais/footer'); ?>