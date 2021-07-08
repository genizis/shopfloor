<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active"><a href="<?php echo base_url() ?>estoque/inventario">Inventário</a></li>
            <li class="breadcrumb-item active">Novo Inventário</a></li>
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
                                <form action="<?= base_url('estoque/inventario/novo-inventario') ?>" method="POST" id="Inventario" class=" needs-validation" novalidate>
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
                                            <label for="inputDataExecucao">Data de Execução <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputDataExecucao"
                                                name="DataExecucao" value="<?= set_value('DataExecucao'); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputObservacao">Observações do Inventário</label>
                                            <textarea class="form-control" rows="3" id="inputObservacao"
                                                name="ObsInventario"><?= set_value('ObsInventario'); ?></textarea>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h6>Produtos Inventariados</h6>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-xs-12">
                                                    <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" data-placement="bottom" 
                                                            title="Você deve primeiramente salvar o inventário antes de adicionar um produto" disabled><i class="fas fa-check-circle"></i> Adicionar Produto</button>
                                                    <button type="button"
                                                            class="btn btn-outline-danger btn-sm" data-toggle="tooltip" data-placement="bottom" 
                                                            title="Você deve primeiramente salvar o inventário antes de excluir os produtos" disabled><i class="fas fa-trash-alt"></i>
                                                            Excluir</button>
                                                </div>
                                            </div>
                                            <table class="table table-bordered table-hover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th scope="col" class="text-center">#</th>
                                                        <th scope="col" class="text-center">Código</th>
                                                        <th scope="col">Produto de Inventário</th>                                                        
                                                        <th scope="col">Tipo do Produto</th>  
                                                        <th scope="col" class="text-center">Un</th>                                                    
                                                        <th scope="col" class="text-center">Quant Contagem</th>
                                                        <th scope="col" class="text-center">Quant Estoque</th>
                                                        <th scope="col" class="text-center">Quant Acerto</th>
                                                    </tr>
                                                </thead>
                                                <tbody>                                                                                                       
                                                </tbody>
                                            </table>
                                            <div class="text-center" id="divAviso">
                                                <p id="pAviso">Nenhum produto de inventário adicionado</p>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button class="btn btn-outline-warning" disabled><i class="far fa-list-alt"></i> Executar Inventário</button>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row float-right">
                                                <div class="col-md-12">
                                                    <div class="col-md-12">
                                                        <button type="submit" form="Inventario" class="btn btn-primary"
                                                            name="Opcao" value="salvar"><i class="fas fa-save"></i> Salvar</button>                                                        
                                                        <a href="<?php echo base_url() ?>estoque/inventario"
                                                            class="btn btn-secondary">Cancelar</a>
                                                    </div>
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

$('#inputDataExecucao').datepicker({
    uiLibrary: 'bootstrap4'
});

</script>

<?php $this->load->view('gerais/footer'); ?>