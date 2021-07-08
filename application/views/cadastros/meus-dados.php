<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active">Meus Dados</li>
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
                                <form action="<?= base_url("meus-dados") ?>" method="POST" class="needs-validation" novalidate>
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="inputUsuário">E-mail do Usuário</label>
                                            <input autocomplete="off" type="text" class="form-control" id="inputUsuário"
                                                name="Email" value="<?= $usuario->email ?>" readonly>
                                        </div>
                                        <div class="form-group col-md-9">
                                            <label for="inputNomeUsuário">Nome do Usuário <span class="text-danger">*</span></label>
                                            <input autocomplete="off" type="text" class="form-control" id="inputNomeUsuário"
                                                name="NomeUsuario" value="<?= $usuario->nome_usuario ?>">
                                        </div>
                                    </div>
                                    <hr>                                    
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputSenha1">Senha <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="inputSenha1"
                                                name="Senha1">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputSenha2">Confirma a Senha <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="inputSenha2"
                                                name="Senha2">
                                        </div>                                        
                                    </div>
                                    <hr> 
                                    <div class="row float-right">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                            <button type="submit" class="btn btn-primary" name="Opcao" value="salvar"><i
                                                    class="fas fa-save"></i> Salvar</button>
                                            <a href="<?php echo base_url() ?>usuario"
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
    
</script>

<?php $this->load->view('gerais/footer'); ?>