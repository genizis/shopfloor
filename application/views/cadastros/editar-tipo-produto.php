<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url() ?>tipo-produto">Tipo de Produto</a></li>
            <li class="breadcrumb-item active">Editar Tipo de Produto</li>
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
                                    action="<?= base_url("tipo-produto/editar-tipo-produto/{$tipoproduto->cod_tipo_produto}") ?>"
                                    method='post'>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputNomeTipoProduto">Nome do Tipo de Produto <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputNomeTipoProduto"
                                                name='NomeTipoProduto' value="<?= $tipoproduto->nome_tipo_produto?>" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="radioProdutoProduzido" name="OrigemProduto"
                                                    class="custom-control-input" <?php if($tipoproduto->origem_produto == 1) echo "checked";  ?> value="1">
                                                <label class="custom-control-label" for="radioProdutoProduzido">Produto Produzido</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="radioProdutoComprado" name="OrigemProduto"
                                                    class="custom-control-input" <?php if($tipoproduto->origem_produto == 2) echo "checked";  ?> value="2">
                                                <label class="custom-control-label" for="radioProdutoComprado">Produto Comprado</label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row float-right">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                                Salvar</button>
                                            <a href="<?php echo base_url() ?>tipo-produto"
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