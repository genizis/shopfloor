<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active"><a href="<?php echo base_url() ?>vendas/pedido-venda">Pedido de Venda</a></li>
            <li class="breadcrumb-item active">Novo Pedido de Venda</a></li>
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
                                <form class="mb-0 needs-validation" novalidate
                                  action="<?= base_url('vendas/pedido-venda/novo-pedido-venda') ?>" method="POST" id="PedidoVenda">
                                    <div class="form-row">
                                        <div class="form-group col-md-9">
                                            <label for="inputCliente">Cliente <span class="text-danger">*</span></label>
                                            <select id="inputCliente" class="selectpicker show-tick form-control"
                                                data-live-search="true" data-actions-box="true"
                                                title="Selecione um Cliente" data-style="btn-input-primary" name="CodCliente" required>
                                                <?php foreach($lista_cliente as $key_cliente => $cliente) { ?>
                                                <option value="<?= $cliente->cod_cliente ?>"
                                                <?php if($cliente->cod_cliente == set_value('CodCliente')) echo "selected"; ?>>
                                                    <?= $cliente->cod_cliente ?> -
                                                    <?= $cliente->nome_cliente ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputSituacao">Situação da Venda</label>
                                            <select id="inputSituacao" class="selectpicker show-tick form-control"
                                                 data-actions-box="true" data-style="btn-input-primary" name="Situacao">
                                                <option value="1" selected>Orçamento</option>
                                                <option value="2">Orçamento Reprovado</option>
                                                <option value="3">Venda</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-9">
                                            <label for="inputVendedor">Vendedor</label>
                                            <select id="inputVendedor" class="selectpicker show-tick form-control"
                                                data-live-search="true" data-actions-box="true"
                                                title="Selecione um Vendedor" data-style="btn-input-primary" name="CodVendedor">
                                                <?php foreach($lista_vendedor as $key_vendedor => $vendedor) { ?>
                                                <option value="<?= $vendedor->cod_vendedor ?>"
                                                <?php if($vendedor->cod_vendedor == set_value('CodVendedor')) echo "selected"; ?>>
                                                    <?= $vendedor->cod_vendedor ?> -
                                                    <?= $vendedor->nome_vendedor ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputPerComissao">Percentual de Comissão</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="inputPerComissao" name="PerComissao" data-mask="##0,00" data-mask-reverse="true" 
                                                <?php if(set_value('CodVendedor') == null) echo "disabled"; ?>
                                                value="<?= set_value('PerComissao') ?>">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                        </div>                                        
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="inputDateEmissao">Data de Emissão <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputDateEmissao"
                                                name="DataEmissao" 
                                                value="<?php if(set_value('DataEmissao') == ""){
                                                                echo str_replace('-', '/', date("d-m-Y"));
                                                            }else{ echo set_value('DataEmissao'); } ?>" required> 
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputDateEntrega">Data de Entrega <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputDateEntrega"
                                                name="DataEntrega" value="<?= set_value('DataEntrega'); ?>" required>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputTipoDesconto">Desconto</label>
                                            <div class="input-group">
                                                <select id="inputTipoDesconto" class="selectpicker show-tick form-control"
                                                        data-actions-box="true" data-style="btn-input-primary" name="TipoDesconto">
                                                    <option value="1">R$</option>
                                                    <option value="2">%</option>
                                                </select>                                                
                                                <input type="text" class="form-control" data-mask="#.##0,00" data-mask-reverse="true"
                                                        name="Desconto" value="<?= set_value('Desconto'); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputTipoFrete">Frete</label>
                                            <div class="input-group">
                                                <select id="inputTipoFrete" class="selectpicker show-tick form-control"
                                                        data-actions-box="true" data-style="btn-input-primary" name="TipoFrete">
                                                    <option value="1">CIF R$</option>
                                                    <option value="2">FOB R$</option>
                                                </select>
                                                <input type="text" class="form-control" data-mask="#.##0,00" data-mask-reverse="true"
                                                        name="Frete" value="<?= set_value('Frete'); ?>">
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputObservacao">Observações do Pedido de Venda</label>
                                            <textarea class="form-control" rows="3" id="inputObservacao"
                                                name="ObsPedidoVenda"><?= set_value('ObsPedidoVenda'); ?></textarea>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h6>Lista de Produtos</h6>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-xs-12">
                                                    <button type="button" class="btn btn-outline-info btn-sm" data-toggle="tooltip" data-placement="bottom" 
                                                    title="Você deve primeiramente salvar o pedido antes de inserir os produtos" disabled><i class="fas fa-plus-circle"></i> Adicionar
                                                        Produto</button>
                                                    <button type="button"
                                                        class="btn btn-outline-danger btn-sm" data-toggle="tooltip" data-placement="bottom" 
                                                    title="Você deve primeiramente salvar o pedido antes de excluir os produtos" disabled><i class="fas fa-trash-alt"></i>
                                                        Excluir</button>
                                                </div>
                                            </div>
                                            <table class="table table-bordered table-hover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th scope="col" class="text-center">#</th>
                                                        <th scope="col" class="text-center">Código</th>
                                                        <th scope="col">Nome do Produto</th>                                                        
                                                        <th scope="col">Tipo do Produto</th>
                                                        <th scope="col" class="text-center">Un</th>
                                                        <th scope="col" class="text-center">Quant Pedida</th>
                                                        <th scope="col" class="text-center">Quant Atendida</th>
                                                        <th scope="col" class="text-center">Total da Venda</th>
                                                        <th scope="col" class="text-center">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>                                                    
                                                </tbody>
                                            </table>
                                            <div class="text-center" id="divAviso">
                                                <p id="pAviso">Nenhum produto adicionado</p>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="#" class="btn btn-outline-warning disabled"
                                                type="button"><i class="fas fa-print"></i> Imprimir Pedido</a>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row float-right">
                                                <div class="col-md-12">
                                                    <button type="submit" form="PedidoVenda" class="btn btn-primary"
                                                        name="Opcao" value="salvar"><i class="fas fa-save"></i> Salvar</button>
                                                    <button class="btn btn-info" disabled><i class="fas fa-dollar-sign"></i> Faturar Pedido</button>
                                                    <a href="<?php echo base_url() ?>vendas/pedido-venda"
                                                        class="btn btn-secondary">Cancelar</a>
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

    $(function() {
        $.applyDataMask();
    });

    $('#inputDateEmissao').datepicker({
        uiLibrary: 'bootstrap4'
    });

    $('#inputDateEntrega').datepicker({
        uiLibrary: 'bootstrap4'
    });

    $("#inputVendedor").change(function() {        

        var baseurl = "<?php echo base_url(); ?>";

        var vendedor = $("#inputVendedor").val();

        $.post(baseurl + "ajax/busca-vendedor", {
            vendedor: vendedor
        }, function(valor) {
            console.log(valor);
            $("#inputPerComissao").val(valor);
        });

        $( "#inputPerComissao" ).prop( "disabled", false );

    });

</script>

<?php $this->load->view('gerais/footer'); ?>