<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url() ?>vendedor">Vendedor</a></li>
            <li class="breadcrumb-item active">Novo Vendedor</li>
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
                                <form action='novo-vendedor' method='post' class="mb-0 needs-validation" novalidate>
                                    <div class="form-row">
                                        <div class="form-group col-md-8">
                                            <label for="inputNomeVendedor">Nome do Vendedor <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputNomeVendedor"
                                                name="NomeVendedor" value="<?= set_value('NomeVendedor'); ?>" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputPerComissao">Percentual de Comissão</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="PerComissao" data-mask="##0,00" data-mask-reverse="true"
                                                value="<?= set_value('PerComissao') ?>">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
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
									<div class="form-row">
										<label for="inputTipoAcesso">Considerar no Cálculo de Comissão</label></label>
									</div>
									<div class="form-row">
										<div class="form-group col-md-2">
											<div class="custom-control custom-switch">
												<input type="checkbox" class="custom-control-input" id="inputFrete" value="1" name="Frete" checked>
												<label class="custom-control-label" for="inputFrete">Frete</label>
											</div>
										</div>
										<div class="form-group col-md-2">
											<div class="custom-control custom-switch">
												<input type="checkbox" class="custom-control-input" id="inputICMS" value="1" name="ICMS" checked>
												<label class="custom-control-label" for="inputICMS">ICMS</label>
											</div>
										</div>
										<div class="form-group col-md-2">
											<div class="custom-control custom-switch">
												<input type="checkbox" class="custom-control-input" id="inputICMSST" value="1" name="ICMS_ST" checked>
												<label class="custom-control-label" for="inputICMSST">ICMS ST</label>
											</div>
										</div>
										<div class="form-group col-md-2">
											<div class="custom-control custom-switch">
												<input type="checkbox" class="custom-control-input" id="inputIPI" value="1" name="IPI" checked>
												<label class="custom-control-label" for="inputIPI">IPI</label>
											</div>
										</div>
										<div class="form-group col-md-2">
											<div class="custom-control custom-switch">
												<input type="checkbox" class="custom-control-input" id="inputPIS" value="1" name="PIS" checked>
												<label class="custom-control-label" for="inputPIS">PIS</label>
											</div>
										</div>
                                        <div class="form-group col-md-2">
											<div class="custom-control custom-switch">
												<input type="checkbox" class="custom-control-input" id="inputCOFINS" value="1" name="COFINS" checked>
												<label class="custom-control-label" for="inputCOFINS">COFINS</label>
											</div>
										</div>
									</div>
                                    <hr>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputUsuario">Usuário</label>
                                            <input type="text" class="form-control" id="inputUsuario"
                                                name="Usuario" value="<?= set_value('Usuario'); ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputSenha">Senha</label>
                                            <input type="password" class="form-control" id="inputSenha"
                                                name="Senha">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input autocomplete="off" type="radio" id="radioAtivo" name="Ativo"
                                                    <?php if(set_value('Ativo') == 1) echo "checked";  ?>
                                                    class="custom-control-input" value="0" checked>
                                                <label class="custom-control-label" for="radioAtivo">Vendedor Ativo</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input autocomplete="off" type="radio" id="radioInativo" name="Ativo"
                                                    <?php if(set_value('Ativo') == 2) echo "checked";  ?>
                                                    class="custom-control-input" value="1">
                                                <label class="custom-control-label" for="radioInativo">Vendedor Inativo</label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row float-right">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                            <button type="submit" class="btn btn-primary" name="Opcao" value="salvar"><i
                                                    class="fas fa-save"></i> Salvar</button>
                                            <button type="submit" class="btn btn-info" name="Opcao"
                                                value="salvarContinuar">Salvar e Continuar</button>
                                            <a href="<?php echo base_url() ?>vendedor"
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

    $('#inputCidade').selectpicker({
        style: 'btn-input-primary'
    });  

    $('#inputTelefoneFixo').mask('(00) 0000-0000');

    $('#inputTelefoneCelular').mask('(00) 0 0000-0000'); 

    
</script>

<?php $this->load->view('gerais/footer'); ?>