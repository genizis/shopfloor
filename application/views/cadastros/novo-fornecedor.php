<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url() ?>fornecedor">Fornecedor</a></li>
            <li class="breadcrumb-item active">Novo Fornecedor</li>
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
                                <form action='novo-fornecedor' method='post' class="needs-validation" novalidate>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputNomeFornecedor">Nome do Fornecedor <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputNomeFornecedor"
                                                name="NomeFornecedor" value="<?= set_value('NomeFornecedor'); ?>" required>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="radioJuridica" name="TipoPessoa"
                                                    class="custom-control-input" value="1" checked>
                                                <label class="custom-control-label" for="radioJuridica">Pessoa
                                                    Juríca</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="radioFisica" name="TipoPessoa"
                                                    class="custom-control-input" value="2"
                                                    <?php if(set_value('TipoPessoa') == 2) echo "checked";  ?>>
                                                <label class="custom-control-label" for="radioFisica">Pessoa
                                                    Física</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputCPFCNPJ">CPF/CNPJ</label>
                                            <input type="text" class="form-control" id="inputCPFCNPJ"
                                                name="CnpjCpf" value="<?= set_value('CnpjCpf'); ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputSegmento">Segmento do Fornecedor</label>
                                            <select id="inputSegmento" name="Segmento"
                                                class="selectpicker show-tick form-control" data-live-search="true"
                                                data-actions-box="true" title="Informe o Segmento do Fornecedor">
                                                <?php foreach($lista_segmento as $key_segmento => $segmento) { ?>
                                                <option value="<?= $segmento->cod_segmento ?>" <?php if($segmento->cod_segmento == set_value('Segmento')) echo "selected"; ?>>
                                                    <?= $segmento->nome_segmento ?></option>
                                                <?php } ?>
                                            </select>
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
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="inputRuaNumero">Rua e Número</label>
                                            <input type="text" class="form-control" id="inputRuaNumero"
                                                name="Endereco" value="<?= set_value('Endereco'); ?>">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputBairro">Bairro</label>
                                            <input type="text" class="form-control" id="inputBairro"
                                                name="Bairro" value="<?= set_value('Bairro'); ?>">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="inputEstado">Estado</label>
                                            <select id="inputEstado" name="Estado"
                                                class="selectpicker show-tick form-control" data-live-search="true"
                                                data-actions-box="true" title="Informe o Estado">
                                                <?php foreach($lista_estado as $key_estado => $estado) { ?>
                                                <option value="<?= $estado->id ?>" <?php if($estado->id == set_value('Estado')) echo "selected"; ?>><?= $estado->uf ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputCidade">Cidade</label>
                                            <select class="form-control selectpicker show-tick" data-live-search="true"
                                                 title="Selecione a Cidade" id="inputCidade" name="Cidade" disabled>                                            
                                            </select>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row float-right">
                                        <div class="col-lg-12 col-md-12 col-xs-12 margem-baixo-10">
                                            <button type="submit" class="btn btn-primary" name="Opcao" value="salvar"><i
                                                    class="fas fa-save"></i> Salvar</button>
                                            <button type="submit" class="btn btn-info" name="Opcao"
                                                value="salvarContinuar">Salvar e Continuar</button>
                                            <a href="<?php echo base_url() ?>fornecedor"
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

    $("#inputEstado").change(function(){

        var baseurl = "<?php echo base_url(); ?>";

        $("#inputCidade").attr('disabled', 'disabled');

        var estado = $("#inputEstado").val();

        $.post(baseurl+"ajax/busca-cidade", {
            estado : estado
            }, function(data){
                console.log(data);
                $("#inputCidade").html(data);
                $("#inputCidade").removeAttr('disabled');
                $('#inputCidade').selectpicker('refresh');
            });
            
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

    //Verifica o tipo de pessoa para aplicar mascara
    var tipoPessoa = "<?= set_value('TipoPessoa'); ?>";

    if((tipoPessoa == "2")) {
        $('#inputCPFCNPJ').mask('000.000.000-00', {
            reverse: true
        });
    }
    else {
        $('#inputCPFCNPJ').mask('00.000.000/0000-00', {
            reverse: true
        });
    }

    $("#radioJuridica").change(function() {
        $('#inputCPFCNPJ').mask('00.000.000/0000-00', {
            reverse: true
        });
    });

    $('#inputTelefoneFixo').mask('(00) 0000-0000');

    $('#inputTelefoneCelular').mask('(00) 0 0000-0000');


    $("#radioFisica").change(function() {
        $('#inputCPFCNPJ').mask('000.000.000-00', {
            reverse: true
        });
    });   

    
</script>

<?php $this->load->view('gerais/footer'); ?>