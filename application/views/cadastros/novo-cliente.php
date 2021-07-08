<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url() ?>cliente">Cliente</a></li>
            <li class="breadcrumb-item active">Novo Cliente</li>
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
                                <?php } $this->session->set_flashdata('erro', '');  ?>
                                <?php if ($this->session->flashdata('sucesso') <> ""){ ?>
                                <div class="alert alert-success alert-dismissible fade show" id="alert" role="alert">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong>Muito bem!</strong>
                                    <?= $this->session->flashdata('sucesso', '') ?>
                                </div>
                                <?php } $this->session->set_flashdata('sucesso', ''); ?>                                
                                <form action='novo-cliente' method='post' class="mb-0 needs-validation" novalidate>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputNomeCliente">Nome do Cliente <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputNomeCliente"
                                                name="NomeCliente" value="<?= set_value('NomeCliente'); ?>" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputRazaoSocial">Razão Social</label>
                                            <input type="text" class="form-control" id="inputRazaoSocial"
                                                name="RazaoSocial" value="<?= set_value('RazaoSocial'); ?>">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-row">
                                        <div class="form-group col-md-2">
											<label>Tipo Pessoa</label>
											<div class="btn-group btn-block" data-toggle="buttons">
												<label class="btn btn-outline-secondary">
													<input type="radio" id="radioJuridica" name="TipoPessoa" value="1"
													<?php if(set_value('TipoPessoa') == 1 || set_value('TipoPessoa') == "") echo 'checked'; ?>> Jurídica
												</label>
												<label class="btn btn-outline-secondary">
													<input type="radio" id="radioFisica" name="TipoPessoa" value="2"
													<?php if(set_value('TipoPessoa') == 2) echo 'checked'; ?>> Física
												</label>
											</div> 
										</div>
                                        <div class="form-group col-md-5">
                                            <label for="inputCPFCNPJ">CNPJ/CPF</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" class="form-control" id="inputCPFCNPJ"
                                                    name="CnpjCpf" value="<?= set_value('CnpjCpf'); ?>">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-info" type="button" id="btnConsultaCNPJ">Consultar CNPJ</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label for="inputSegmento">Segmento do Cliente</label>
                                            <select id="inputSegmento" name="Segmento"
                                                class="selectpicker show-tick form-control" data-live-search="true"
                                                data-actions-box="true" title="Informe o Segmento do Cliente">
                                                <?php foreach($lista_segmento as $key_segmento => $segmento) { ?>
                                                <option value="<?= $segmento->cod_segmento ?>" <?php if($segmento->cod_segmento == set_value('Segmento')) echo "selected"; ?>>
                                                    <?= $segmento->nome_segmento ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>                                    
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="inputContribuinteICMS">Tipo de Contribuição ICMS</label>
                                            <select id="inputContribuinteICMS" name="ContribuinteICMS" data-style="btn-input-primary"
                                                class="selectpicker show-tick form-control"
                                                data-actions-box="true">
                                                <option value="9" <?php if(set_value('ContribuinteICMS') == 9) echo "selected"; ?>>Não Contribuinte</option>
                                                <option value="1" <?php if(set_value('ContribuinteICMS') == 1) echo "selected"; ?>>Contribuinte</option>
                                                <option value="2" <?php if(set_value('ContribuinteICMS') == 2) echo "selected"; ?>>Contribuinte Isento</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputIE">Inscrição Estadual</label>
                                            <input type="text" class="form-control" id="inputIE"
                                                name="IE" value="<?= set_value('IE'); ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputIM">Inscrição Municipal</label>
                                            <input type="text" class="form-control" id="inputIM"
                                                name="IM" value="<?= set_value('IM'); ?>">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="inputTelefoneFixo">Telefone Fixo</label>
                                            <input type="text" class="form-control" id="inputTelefoneFixo"
                                                name="TelFixo" value="<?= set_value('TelFixo'); ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputTelefoneCelular">Telefone Celular</label>
                                            <input type="text" class="form-control" id="inputTelefoneCelular"
                                                name="TelCel" value="<?= set_value('TelCel'); ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputEmail">E-mail</label>
                                            <input type="text" class="form-control" id="inputEmail"
                                                name="Email" value="<?= set_value('Email'); ?>">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="inputCEP">CEP</label>
                                            <input type="text" class="form-control" id="inputCEP"
                                                 name="CEP" value="<?= set_value('CEP'); ?>" data-mask="00000-000">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputEndereco">Endereço</label>
                                            <input type="text" class="form-control" id="inputEndereco"
                                                 name="Endereco" value="<?= set_value('Endereco'); ?>">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="inputNumero">Número</label>
                                            <input type="text" class="form-control" id="inputNumero"
                                                name="Numero" value="<?= set_value('Numero'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="inputComplemento">Complemento</label>
                                            <input type="text" class="form-control" id="inputComplemento"
                                                name="Complemento" value="<?= set_value('Complemento'); ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputBairro">Bairro</label>
                                            <input type="text" class="form-control" id="inputBairro"
                                                name="Bairro" value="<?= set_value('Bairro'); ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputCidade">Cidade</label>
                                            <select class="form-control selectpicker show-tick" data-live-search="true"
                                                 title="Selecione a Cidade" id="inputCidade" name="Cidade"> 
                                                <?php foreach($lista_cidade as $key_cidade => $cidade) { ?>
                                                <option value="<?= $cidade->id ?>" <?php if($cidade->id == set_value('Cidade')) echo "selected"; ?>><?= $cidade->nome ?> - <?= $cidade->uf ?></option>
                                                <?php } ?>                                           
                                            </select>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row float-right">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                            <button type="submit" class="btn btn-primary" name="Opcao" value="salvar"><i
                                                    class="fas fa-save"></i> Salvar</button>
                                            <button type="submit" class="btn btn-info" name="Opcao"
                                                value="salvarContinuar">Salvar e Continuar</button>
                                            <a href="<?php echo base_url() ?>cliente"
                                                class="btn btn-secondary">Cancelar</a>
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

$("#inputCEP").blur(function(){
    bucaCEP();
});

function bucaCEP() {
    var cep = $("#inputCEP").val();
    var link ="https://ws.apicep.com/cep/" + cep + ".json";

    $.ajax({
        url: link,
        type: 'GET',
        success: function(data) {            
            $("#inputEndereco").val(data.address);
            $("#inputBairro").val(data.district);
            $("#inputCidade").selectpicker('val', $('option:contains("' + data.city + ' - ' + data.state + '")').val());
        }
    })
}

$( "#btnConsultaCNPJ").click(function() {

    var cnpj = $("#inputCPFCNPJ").val().replaceAll(".", "").replaceAll("/", "").replaceAll("-", "");
    var link ="https://www.receitaws.com.br/v1/cnpj/" + cnpj;

    $.ajax({
        url: link,
        type: 'GET',
        dataType: 'jsonp',
        headers: {
            'Content-Type':  'application/json',
            'Access-Control-Allow-Origin': 'http://localhost',
            "Authorization":"Bearer  af60c3794c78c9ec052a6e91ebb68c85259388f9131e0f8ae729e7efca6ec51e",
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

    $('#inputCidade').selectpicker({
        style: 'btn-input-primary'
    });

    $('#inputEstado').selectpicker({
        style: 'btn-input-primary'
    });

    $('#inputSegmento').selectpicker({
        style: 'btn-input-primary'
    }); 
    
    $('#inputCPFCNPJ').mask('00.000.000/0000-00', {
        reverse: true
    });    

    $('#inputTelefoneFixo').mask('(00) 0000-0000');

    $('#inputTelefoneCelular').mask('(00) 0 0000-0000');

    $("#radioJuridica").change(function() {
        $('#inputCPFCNPJ').mask('00.000.000/0000-00', {
            reverse: true
        });

        $("#btnConsultaCNPJ").prop("disabled", false);
    });

    $("#radioFisica").change(function() {
        $('#inputCPFCNPJ').mask('000.000.000-00', {
            reverse: true
        });

        $("#btnConsultaCNPJ").prop("disabled", true);
    });   

    
</script>

<?php $this->load->view('gerais/footer'); ?>