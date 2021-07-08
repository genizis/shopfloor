<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url() ?>unidade-medida">Unidade de Medida</a></li>
            <li class="breadcrumb-item active">Editar Unidade de Medida</li>
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
                                <div class="alert alert-danger alert-dismissible fade show" id="alert" role="alert">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <strong>Atenção!</strong> <?= $this->session->flashdata('sucesso') ?>
                                </div>
                                <?php } $this->session->set_flashdata('sucesso', ''); ?>
                                <form class="needs-validation" novalidate
                                    action="<?= base_url("unidade-medida/editar-unidade-medida/{$unidademedida->cod_unidade_medida}") ?>"
                                    method='post'>
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="inputCodUnidadeMedida">Código da Unidade de Medida</label>
                                            <input type="text" class="form-control" id="inputCodUnidadeMedida"
                                                name='CodUnidadeMedida'
                                                value="<?= $unidademedida->cod_unidade_medida ?>" readonly>
                                        </div>
                                        <div class="form-group col-md-9">
                                            <label for="inputNomeUnidadeMedida">Nome da Unidade de Medida <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputNomeUnidadeMedida"
                                                name='NomeUnidadeMedida'
                                                value="<?= $unidademedida->nome_unidade_medida ?>" value="<?= set_value('NomeUnidadeMedida'); ?>" required>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row float-right">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                                Salvar</button>
                                            <a href="<?php echo base_url() ?>unidade-medida"
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

<?php $this->load->view('gerais/footer'); ?>