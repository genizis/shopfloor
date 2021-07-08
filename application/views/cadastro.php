<?php $this->load->view('gerais/header' , $menu); ?>

<body class="bg-default">

    <section>
        <div class="container">
            <div class="row login">
                <div class="col-md-7 text-center">
                    <img src="<?= base_url('img/logo-cad.png') ?>" class="img-fluid mb-5" alt="">
                    <h1 class="mb-2">Sistema de gestão completo para sua empresa</h3>
                        <h3 class="text-secondary light">Cadastre-se e teste gratuitamente por 30 dias</h3>
                        <div class="row mt-5">
                            <div class="col-md-3">
                                <div class="mt-5">
                                    <i class="fas fa-4x fa-cogs text-danger mb-4"></i>
                                    <h3 class="h4 mb-2">Produção</h3>
                                    <p class="text-muted mb-0">Transformação dos produtos acabados e baixa de estoque de
                                        insumos</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mt-5">
                                    <i class="fas fa-4x fa-shopping-cart text-danger mb-4"></i>
                                    <h3 class="h4 mb-2">Compras</h3>
                                    <p class="text-muted mb-0">Pedidos e recebimentos de materiais integrado com contas
                                        a pagar</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mt-5">
                                    <i class="fas fa-4x  fa-cash-register text-danger mb-4"></i>
                                    <h3 class="h4 mb-2">Vendas</h3>
                                    <p class="text-muted mb-0">Faturamento de pedidos de venda integrado com contas a
                                        receber</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mt-5">
                                    <i class="fas fa-4x fa-wallet text-danger mb-4"></i>
                                    <h3 class="h4 mb-2">Financeiro</h3>
                                    <p class="text-muted mb-0">Controle de pagamentos, recebimentos e gestão de fluxo de
                                        caixa</p>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="col-md-5">
                    <?php if ($this->session->flashdata('erro') <> ""){ ?>
                    <div class="alert alert-danger alert-dismissible fade show" id="alert" role="alert">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Atenção!</strong> <?= $this->session->flashdata('erro') ?>
                    </div>
                    <?php } $this->session->set_flashdata('erro', '');  ?>
                    <?php if ($this->session->flashdata('sucesso') <> ""){ ?>
                    <div class="alert alert-success alert-dismissible fade show" id="alert" role="alert">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Muito bem!</strong>
                        <?= $this->session->flashdata('sucesso', '') ?>
                    </div>
                    <?php } $this->session->set_flashdata('sucesso', ''); ?>
                    <form action="<?= base_url('comece-agora') ?>" method="POST" id="OrdemProd" class="mb-0 needs-validation" novalidate>
                        <fieldset>
                            <legend class="text-primary"><strong>Informações da sua empresa</strong></legend>
                            <div class="card  mb-4">
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label>Tipo Pessoa</label>
                                            <div class="btn-group btn-block" data-toggle="buttons">
                                                <label class="btn btn-outline-secondary">
                                                    <input type="radio" id="radioJuridica" name="TipoPessoa" value="1"
                                                        <?php if(set_value('TipoPessoa') == 1 || set_value('TipoPessoa') == "") echo 'checked'; ?>>
                                                    Jurídica
                                                </label>
                                                <label class="btn btn-outline-secondary">
                                                    <input type="radio" id="radioFisica" name="TipoPessoa" value="2"
                                                        <?php if(set_value('TipoPessoa') == 2) echo 'checked'; ?>>
                                                    Física
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-8">
                                            <label for="inputCPFCNPJ"><span id="labelTipoPessoa">CNPJ</span> <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" class="form-control"
                                                    id="inputCPFCNPJ" name="CnpjCpf"
                                                    value="<?= set_value('CnpjCpf'); ?>" required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-info" type="button"
                                                        id="btnConsultaCNPJ">Consultar CNPJ</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputNomeEmpresa">Nome da Empresa <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputNomeEmpresa"
                                                name="NomeEmpresa" value="<?= set_value('NomeEmpresa'); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputRazaoSocial">Razão Social</label>
                                            <input type="text" class="form-control" id="inputRazaoSocial"
                                                name="RazaoSocial" value="<?= set_value('RazaoSocial'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputTelefoneFixo">Telefone Fixo</label>
                                            <input type="text" class="form-control" id="inputTelefoneFixo"
                                                name="TelFixo" value="<?= set_value('TelFixo'); ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputTelefoneCelular">Telefone Celular <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputTelefoneCelular"
                                                name="TelCel" value="<?= set_value('TelCel'); ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <legend class="text-primary"><strong>Seus dados de acesso</strong></legend>
                            <div class="card ">
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputEmailUsuario">Seu E-mail <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputEmailUsuario" name="Email"
                                                value="<?= set_value('Email'); ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputNomeUsuario">Seu Nome <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputNomeUsuario"
                                                name="NomeUsuario" value="<?= set_value('NomeUsuario'); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputSenha1">Senha <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="inputSenha1" name="Senha1" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputSenha2">Confirma a Senha <span
                                                    class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="inputSenha2" name="Senha2" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="checkTermos" name="TermosCondicoes" value="1" required>
                                                <label class="custom-control-label" for="checkTermos">
                                                    Li e concordo com os <a
                                                        href="http://blog.shopfloor.com.br/termos-condicoes-uso/"
                                                        target="_blank" class="text-info">termos e condições de uso</a>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-teal btn-lg btn-block mt-2">Comece Agora seu
                                        Teste Grátis de 30 dias</button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

<script>
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
            $("#inputNomeEmpresa").val(data.fantasia);
            $("#inputRazaoSocial").val(data.nome);
            bucaCEP();
            console.log(data);
        }
    })
});

$('#inputCPFCNPJ').mask('00.000.000/0000-00', {
    reverse: true
});

$("#radioJuridica").change(function() {
    $('#labelTipoPessoa').text("CNPJ");
    $('#inputCPFCNPJ').mask('00.000.000/0000-00', {
        reverse: true
    });

    $("#btnConsultaCNPJ").prop("disabled", false);
});

$("#radioFisica").change(function() {
    $('#labelTipoPessoa').text("CPF");
    $('#inputCPFCNPJ').mask('000.000.000-00', {
        reverse: true
    });

    $("#btnConsultaCNPJ").prop("disabled", true);
});

$('#inputTelefoneFixo').mask('(00) 0000-0000');

$('#inputTelefoneCelular').mask('(00) 0 0000-0000');
</script>

<?php $this->load->view('gerais/footer'); ?>