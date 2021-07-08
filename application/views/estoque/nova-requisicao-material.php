<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active"><a href="<?php echo base_url() ?>estoque/requisicao-material">Requisição de Material</a></li>
            <li class="breadcrumb-item active">Nova Requisição de Material</a></li>
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
                                <form action="<?= base_url('estoque/requisicao-material/nova-requisicao-material') ?>" method="POST" id="RequisicaoMaterial"
                                    class="mb-0 needs-validation" novalidate>
                                    <div class="form-row">                                       
                                        <div class="form-group col-md-6">
                                            <label for="inputDataEmissao">Data de Emissão <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputDataEmissao"
                                                name="DataEmissao" 
                                                value="<?php if(set_value('DataEmissao') == ""){
                                                                echo str_replace('-', '/', date("d-m-Y"));
                                                            }else{ echo set_value('DataEmissao'); } ?>" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputDataRequisicao">Data da Requisição <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputDataRequisicao"
                                                name="DataRequisicao" value="<?= set_value('DataRequisicao'); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputObservacao">Observações da Requisição de Material</label>
                                            <textarea class="form-control" rows="3" id="inputObservacao"
                                                name="ObsRequisicaoMaterial"><?= set_value('ObsRequisicaoMaterial'); ?></textarea>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h6>Produtos da Requisição</h6>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-xs-12">
                                                    <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="bottom" 
                                                            title="Você deve primeiramente salvar o cabeçalho da requisição antes de adicionar um produto" disabled><i class="fas fa-check-circle"></i> Adicionar Produto</button>
                                                    <button type="button"
                                                            class="btn btn-outline-danger btn-sm" data-toggle="tooltip" data-placement="bottom" 
                                                            title="Você deve primeiramente salvar o cabeçalho da requisição antes de excluir os produtos" disabled><i class="fas fa-trash-alt"></i>
                                                            Excluir</button>
                                                </div>
                                            </div>
                                            <table class="table table-bordered table-hover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th scope="col" class="text-center">#</th>
                                                        <th scope="col" class="text-center">Código</th>
                                                        <th scope="col">Produto da Requisição</th>                                                        
                                                        <th scope="col">Tipo do Produto</th>  
                                                        <th scope="col" class="text-center">Un</th>                                                    
                                                        <th scope="col" class="text-center">Quant Requisição</th>
                                                    </tr>
                                                </thead>
                                                <tbody>                                                                                                       
                                                </tbody>
                                            </table>
                                            <div class="text-center" id="divAviso">
                                                <p id="pAviso">Nenhum produto de requisição adicionado</p>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="btn btn-outline-teal" disabled><i class="fas fa-check"></i> Atender Requisição</button>
                                            <button class="btn btn-outline-danger" disabled><i class="fas fa-undo"></i> Estornar Requisição</button>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row float-right">
                                                <div class="col-md-12">
                                                    <button type="submit" form="RequisicaoMaterial" class="btn btn-primary"
                                                            name="Opcao" value="salvar"><i class="fas fa-save"></i> Salvar</button>                                                        
                                                    <a href="<?php echo base_url() ?>estoque/requisicao-material"
                                                            class="btn btn-secondary">Cancelar</a>
                                                </div>
                                            </div>
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

$('#inputDataEmissao').datepicker({
    uiLibrary: 'bootstrap4'
});

$('#inputDataRequisicao').datepicker({
    uiLibrary: 'bootstrap4'
});

</script>

<?php $this->load->view('gerais/footer'); ?>