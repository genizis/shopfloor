<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu-vendedor', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('vendas/pedido-venda-vendedor') ?>">Minhas Vendas</a></li>
            <li class="breadcrumb-item active">Novo Pedido de Venda</a></li>
        </ol>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 mb-3">
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
                            action="<?= base_url('vendas/pedido-venda-vendedor/novo-pedido-venda-vendedor') ?>"
                            method="POST" id="PedidoVenda">
                            <div class="form-row">
                                <div class="form-group col-md-9">
                                    <label for="inputCliente">Cliente <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select id="inputCliente" class="selectpicker show-tick form-control"
                                            data-live-search="true" data-actions-box="true" title="Selecione um Cliente"
                                            data-style="btn-input-primary" name="CodCliente" required>
                                            <?php foreach($lista_cliente as $key_cliente => $cliente) { ?>
                                            <option value="<?= $cliente->cod_cliente ?>" class="limit-text-50"
                                                <?php if($cliente->cod_cliente == set_value('CodCliente')) echo "selected"; ?>>
                                                <?= $cliente->cod_cliente ?> -
                                                <?= $cliente->nome_cliente ?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="input-group-append">
                                            <a href="#" data-toggle="modal" data-target="#novo-cliente" type="button"
                                                class="btn btn-outline-info btn-block">Novo Cliente</a>
                                        </div>
                                    </div>
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
                                <div class="form-group col-md-3">
                                    <label for="inputDateEmissao">Data de Emissão <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="inputDateEmissao" name="DataEmissao"
                                        value="<?php if(set_value('DataEmissao') == ""){
                                                                echo str_replace('-', '/', date("d-m-Y"));
                                                            }else{ echo set_value('DataEmissao'); } ?>" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputDateEntrega">Data de Entrega <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="inputDateEntrega" name="DataEntrega"
                                        value="<?= set_value('DataEntrega'); ?>" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputTipoDesconto">Desconto</label>
                                    <div class="input-group">
                                        <select id="inputTipoDesconto" class="selectpicker show-tick form-control"
                                            data-actions-box="true" data-style="btn-input-primary" name="TipoDesconto">
                                            <option value="1">R$</option>
                                            <option value="2">%</option>
                                        </select>
                                        <input type="text" class="form-control" data-mask="#.##0,00"
                                            data-mask-reverse="true" name="Desconto"
                                            value="<?= set_value('Desconto'); ?>">
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
                                        <input type="text" class="form-control" data-mask="#.##0,00"
                                            data-mask-reverse="true" name="Frete" value="<?= set_value('Frete'); ?>">
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
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-12">
                                            <button type="button" class="btn btn-outline-info btn-sm btn-block mb-2"
                                                data-toggle="tooltip" data-placement="bottom"
                                                title="Você deve primeiramente salvar o pedido antes de inserir os produtos"
                                                disabled><i class="fas fa-plus-circle"></i> Adicionar
                                                Produto</button>
                                        </div>
                                    </div>
                                    <div class="text-center mt-3" id="divAviso">
                                        <p id="pAviso">Nenhum produto adicionado</p>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-12">
                                    <button type="submit" form="PedidoVenda" class="btn btn-primary btn-block mb-2"
                                        name="Opcao" value="salvar"><i class="fas fa-save"></i> Salvar</button>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-12">
                                    <button class="btn btn-teal btn-block mb-2" disabled><i
                                            class="fas fa-dollar-sign"></i> Faturar Pedido</button>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-12">
                                    <a href="#" class="btn btn-warning disabled btn-block mb-2" type="button"><i
                                            class="fas fa-print"></i> Imprimir Pedido</a>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 col-12">
                                    <a href="<?php echo base_url() ?>vendas/pedido-venda-vendedor"
                                        class="btn btn-secondary btn-block">Cancelar</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="novo-cliente" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Novo Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action='novo-cliente' method='post' class="mb-0 needs-validation" novalidate>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputNomeCliente">Nome do Cliente <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="inputNomeCliente" name="NomeCliente"
                                value="<?= set_value('NomeCliente'); ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputRazaoSocial">Razão Social</label>
                            <input type="text" class="form-control" id="inputRazaoSocial" name="RazaoSocial"
                                value="<?= set_value('RazaoSocial'); ?>">
                        </div>
                    </div>
                    <hr>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label>Tipo Pessoa</label>
                            <div class="btn-group btn-block" data-toggle="buttons">
                                <label class="btn btn-outline-secondary">
                                    <input type="radio" id="radioJuridicaCliente" name="TipoPessoaCliente" value="1"
                                        <?php if(set_value('TipoPessoaCliente') == 1 || set_value('TipoPessoaCliente') == "") echo 'checked'; ?>>
                                    Jurídica
                                </label>
                                <label class="btn btn-outline-secondary">
                                    <input type="radio" id="radioFisicaCliente" name="TipoPessoaCliente" value="2"
                                        <?php if(set_value('TipoPessoaCliente') == 2) echo 'checked'; ?>> Física
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="inputCPFCNPJCliente">CNPJ/CPF</label>
                            <div class="input-group">
                                <input type="text" class="form-control" class="form-control" id="inputCPFCNPJCliente"
                                    name="CnpjCpf" value="<?= set_value('CnpjCpfCliente'); ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-info" type="button" id="btnConsultaCNPJ">Consultar
                                        CNPJ</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="inputSegmento">Segmento do Cliente</label>
                            <select id="inputSegmento" name="Segmento" class="selectpicker show-tick form-control"
                                data-style="btn-input-primary" data-live-search="true" data-actions-box="true"
                                title="Informe o Segmento do Cliente">
                                <?php foreach($lista_segmento as $key_segmento => $segmento) { ?>
                                <option value="<?= $segmento->cod_segmento ?>"
                                    <?php if($segmento->cod_segmento == set_value('Segmento')) echo "selected"; ?>>
                                    <?= $segmento->nome_segmento ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputContribuinteICMS">Tipo de Contribuição ICMS</label>
                            <select id="inputContribuinteICMS" name="ContribuinteICMS" data-style="btn-input-primary"
                                class="selectpicker show-tick form-control" data-actions-box="true">
                                <option value="9" <?php if(set_value('ContribuinteICMS') == 9) echo "selected"; ?>>Não
                                    Contribuinte</option>
                                <option value="1" <?php if(set_value('ContribuinteICMS') == 1) echo "selected"; ?>>
                                    Contribuinte</option>
                                <option value="2" <?php if(set_value('ContribuinteICMS') == 2) echo "selected"; ?>>
                                    Contribuinte Isento</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputIE">Inscrição Estadual</label>
                            <input type="text" class="form-control" id="inputIE" name="IE"
                                value="<?= set_value('IE'); ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputIM">Inscrição Municipal</label>
                            <input type="text" class="form-control" id="inputIM" name="IM"
                                value="<?= set_value('IM'); ?>">
                        </div>
                    </div>
                    <hr>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputTelefoneFixo">Telefone Fixo</label>
                            <input type="text" class="form-control" id="inputTelefoneFixo" name="TelFixo"
                                value="<?= set_value('TelFixo'); ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputTelefoneCelular">Telefone Celular</label>
                            <input type="text" class="form-control" id="inputTelefoneCelular" name="TelCel"
                                value="<?= set_value('TelCel'); ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputEmail">E-mail</label>
                            <input type="text" class="form-control" id="inputEmail" name="Email"
                                value="<?= set_value('Email'); ?>">
                        </div>
                    </div>
                    <hr>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputCEP">CEP</label>
                            <input type="text" class="form-control" id="inputCEP" name="CEP"
                                value="<?= set_value('CEP'); ?>" data-mask="00000-000">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEndereco">Endereço</label>
                            <input type="text" class="form-control" id="inputEndereco" name="Endereco"
                                value="<?= set_value('Endereco'); ?>">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputNumero">Número</label>
                            <input type="text" class="form-control" id="inputNumero" name="Numero"
                                value="<?= set_value('Numero'); ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputComplemento">Complemento</label>
                            <input type="text" class="form-control" id="inputComplemento" name="Complemento"
                                value="<?= set_value('Complemento'); ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputBairro">Bairro</label>
                            <input type="text" class="form-control" id="inputBairro" name="Bairro"
                                value="<?= set_value('Bairro'); ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputCidade">Cidade</label>
                            <select class="form-control selectpicker show-tick" data-live-search="true"
                                title="Selecione a Cidade" id="inputCidade" name="Cidade"
                                data-style="btn-input-primary">
                                <?php foreach($lista_cidade as $key_cidade => $cidade) { ?>
                                <option value="<?= $cidade->id ?>"
                                    <?php if($cidade->id == set_value('Cidade')) echo "selected"; ?>>
                                    <?= $cidade->nome ?> - <?= $cidade->uf ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSalvarCliente" class="btn btn-primary">Salvar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>


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

    $("#inputPerComissao").prop("disabled", false);

});

$("#btnSalvarCliente").click(function() {

    var baseurl = "<?php echo base_url(); ?>";

    var nomeCliente = $("#inputNomeCliente").val();
    var razaoSocial = $("#inputRazaoSocial").val();

    if ($("#radioJuridicaCliente").is(":checked") == true)
        var tipoPessoa = 1;
    if ($("#radioFisicaCliente").is(":checked") == true)
        var tipoPessoa = 2;

    var segmento = $("#inputSegmento").val();
    var contribuinteICMS = $("#inputContribuinteICMS").val();
    var cpfCnpj = $("#inputCPFCNPJCliente").val();
    var inscEstadual = $("#inputIE").val();
    var inscMunicipal = $("#inputIM").val();
    var telFixo = $("#inputTelefoneFixo").val();
    var telCel = $("#inputTelefoneCelular").val();
    var eMail = $("#inputEmail").val();
    var cep = $("#inputCEP").val();
    var endereco = $("#inputEndereco").val();
    var numero = $("#inputNumero").val();
    var complemento = $("#inputComplemento").val();
    var bairro = $("#inputBairro").val();
    var cidade = $("#inputCidade").val();

    $.post(baseurl + "ajax/inserir-cliente", {
        nomeCliente: nomeCliente,
        razaoSocial: razaoSocial,
        tipoPessoa: tipoPessoa,
        segmento: segmento,
        contribuinteICMS: contribuinteICMS,
        cpfCnpj: cpfCnpj,
        inscEstadual: inscEstadual,
        inscMunicipal: inscMunicipal,
        telFixo: telFixo,
        telCel: telCel,
        eMail: eMail,
        cep: cep,
        endereco: endereco,
        numero: numero,
        complemento: complemento,
        bairro: bairro,
        cidade: cidade
    }, function(data) {
        $('#novo-cliente').modal('hide');

        $("#inputCliente").html(data);
        $("#inputCliente").removeAttr('disabled');
        $('#inputCliente').selectpicker('refresh');
    });
});

$("#inputCEP").blur(function() {
    bucaCEP();
});

function bucaCEP() {
    var cep = $("#inputCEP").val();
    var link = "https://ws.apicep.com/cep/" + cep + ".json";

    $.ajax({
        url: link,
        type: 'GET',
        success: function(data) {
            $("#inputEndereco").val(data.address);
            $("#inputBairro").val(data.district);
            $("#inputCidade").selectpicker('val', $('option:contains("' + data.city + ' - ' + data.state +
                '")').val());
        }
    })
}

$("#btnConsultaCNPJ").click(function() {

    var cnpj = $("#inputCPFCNPJ").val().replaceAll(".", "").replaceAll("/", "").replaceAll("-", "");
    var link = "https://www.receitaws.com.br/v1/cnpj/" + cnpj;

    $.ajax({
        url: link,
        type: 'GET',
        dataType: 'jsonp',
        headers: {
            'Content-Type': 'application/json',
            'Access-Control-Allow-Origin': 'http://localhost',
            "Authorization": "Bearer  af60c3794c78c9ec052a6e91ebb68c85259388f9131e0f8ae729e7efca6ec51e",
        },
        success: function(data) {
            $("#inputNomeCliente").val(data.fantasia);
            $("#inputRazaoSocial").val(data.nome);
            $("#inputTelefoneFixo").val(data.telefone);
            $("#inputCEP").val(data.cep.replaceAll(".", ""));
            $("#inputNumero").val(data.numero);
            $("#inputComplemento").val(data.complemento);
            bucaCEP();
            console.log(data);
        }
    })
});

$('#inputCPFCNPJCliente').mask('00.000.000/0000-00', {
    reverse: true
});

$('#inputTelefoneFixo').mask('(00) 0000-0000');

$('#inputTelefoneCelular').mask('(00) 0 0000-0000');

$("#radioJuridicaCliente").change(function() {
    $('#inputCPFCNPJCliente').mask('00.000.000/0000-00', {
        reverse: true
    });

    $("#btnConsultaCNPJ").prop("disabled", false);
});

$("#radioFisicaCliente").change(function() {
    $('#inputCPFCNPJCliente').mask('000.000.000-00', {
        reverse: true
    });

    $("#btnConsultaCNPJ").prop("disabled", true);
});
</script>

<?php $this->load->view('gerais/footer'); ?>