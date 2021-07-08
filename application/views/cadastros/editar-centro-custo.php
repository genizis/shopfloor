<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url() ?>centro-custo">Centro de Custo</a></li>
            <li class="breadcrumb-item active">Editar Centro de Custo</li>
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
                                      action="<?= base_url("centro-custo/editar-centro-custo/{$centro_custo->cod_centro_custo}") ?>"
                                      method='post'>
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="inputCodCentroCusto">Código Centro de Custo <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputCodCentroCusto"
                                                name='CodCentroCusto' value="<?= $centro_custo->cod_centro_custo ?>" readonly>
                                        </div>
                                        <div class="form-group col-md-9">
                                            <label for="inputNomeCentroCusto">Nome do Centro de Custo <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputNomeCentroCusto"
                                                name='NomeCentroCusto' value="<?= $centro_custo->nome_centro_custo ?>" required> 
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="radioAtivo" name="Ativo"
                                                    <?php if($centro_custo->ativo == 1) echo "checked";  ?>
                                                    class="custom-control-input" checked value="1">
                                                <label class="custom-control-label" for="radioAtivo">Ativa</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="radioInativo" name="Ativo"
                                                    <?php if($centro_custo->ativo == 2) echo "checked";  ?>
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
                                            <a href="<?php echo base_url() ?>centro-custo"
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