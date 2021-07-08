<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url() ?>conta-contabil">Conta Contábil</a></li>
            <li class="breadcrumb-item active">Nova Conta Contábil</li>
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
                                <form action='nova-conta-contabil' method='post' class="needs-validation" novalidate>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputCodContaContabilPai">Conta Contábil Pai</label>
                                            <select id="inputCodContaContabilPai" class="selectpicker show-tick form-control"
                                                data-live-search="true" data-actions-box="true"
                                                title="Selecione uma Conta Contábil" data-style="btn-input-primary" name="CodContaContabilPai">
                                                <?php foreach($lista_conta_contabil as $key_conta_contabil => $conta_contabil) { ?>
                                                <option value="<?= $conta_contabil->cod_conta_contabil ?>"
                                                <?php if($conta_contabil->cod_conta_contabil == set_value('CodContaContabilPai')) echo "selected"; ?>>
                                                    <?= $conta_contabil->cod_conta_contabil ?> -
                                                    <?= $conta_contabil->nome_conta_contabil ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row ">                                        
                                        <div class="form-group col-md-3">
                                            <label for="inputCodContaContabil">Código Conta Contábil <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" id="inputCodContaContabilComp" class="form-control text-right" readonly>
                                                <input type="text" name='CodContaContabil' value="<?= set_value('CodContaContabil'); ?>" class="form-control"
                                                data-mask="#0" data-mask-reverse="true" required>                                              
                                            </div>
                                        </div>
                                        <div class="form-group col-md-9">
                                            <label for="inputNomeContaContabil">Nome da Conta Contábil <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputNomeContaContabil"
                                                name='NomeContaContabil' value="<?= set_value('NomeContaContabil'); ?>" required>
                                        </div>
                                    </div>                                    
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="radioAtivo" name="Ativo"
                                                    <?php if(set_value('Ativo') == 1) echo "checked";  ?>
                                                    class="custom-control-input" checked value="1">
                                                <label class="custom-control-label" for="radioAtivo">Ativa</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="radioInativo" name="Ativo"
                                                    <?php if(set_value('Ativo') == 2) echo "checked";  ?>
                                                    class="custom-control-input" value="2">
                                                <label class="custom-control-label" for="radioInativo">Inativa</label>
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
                                            <a href="<?php echo base_url() ?>conta-contabil"
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

$("#inputCodContaContabilPai").change(function(){

    $("#inputCodContaContabilComp").val($("#inputCodContaContabilPai").val() + ".");
    
});  
</script>

<?php $this->load->view('gerais/footer'); ?>