<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url() ?>metodo-pagamento">Método de Pagamento</a></li>
            <li class="breadcrumb-item active">Novo Método de Pagamento</li>
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
                                <form action='novo-metodo-pagamento' method='post' class="needs-validation" novalidate>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputNomeMetodoPagamento">Nome do Metodo de Pagamento <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputNomeMetodoPagamento"
                                                name='NomeMetodoPagamento' value="<?= set_value('NomeMetodoPagamento'); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label>Conta Financeira Padrão</label>
                                            <select class="selectpicker show-tick form-control" data-live-search="true"
                                                data-actions-box="true" title="Selecione uma Conta Financeira"
                                                name="CodConta" data-style="btn-input-primary">
                                                <?php foreach($lista_conta as $key_conta => $conta) { ?>
                                                <option value="<?= $conta->cod_conta ?>">
                                                    <?= $conta->cod_conta ?> - <?= $conta->nome_conta ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputTaxaOperacao">Taxa de Operação</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="inputTaxaOperacao" name="TaxaOperacao" data-mask="##0,00" data-mask-reverse="true"
                                                value="<?= set_value('TaxaOperacao'); ?>">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputDiasRecebimento">Dias para Recebimento</label>
                                            <input type="text" class="form-control" id="inputDiasRecebimento"
                                                name="DiasRecebimento" data-mask="##0" data-mask-reverse="true"
                                                value="<?= set_value('DiasRecebimento'); ?>">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row float-right">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                            <button type="submit" class="btn btn-primary" name="Opcao" value="salvar"><i
                                                    class="fas fa-save"></i> Salvar</button>
                                            <button type="submit" class="btn btn-info" name="Opcao"
                                                value="salvarContinuar">Salvar e Continuar</button>
                                            <a href="<?php echo base_url() ?>metodo-pagamento"
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
</script>

<?php $this->load->view('gerais/footer'); ?>