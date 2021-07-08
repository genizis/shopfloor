<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url() ?>usuario">Usuário</a></li>
            <li class="breadcrumb-item active">Editar Usuário</li>
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
                                <form action="<?= base_url("usuario/editar-usuario/{$usuario->email}") ?>" method="POST" class="needs-validation" novalidate>
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
                                        <div class="form-group col-md-12">
                                            <label for="inputTipoAcesso">Tipo de Acesso <span class="text-danger">*</span></label></label>
                                            <select id="inputTipoAcesso" name="TipoAcesso" 
                                                class="selectpicker show-tick form-control"
                                                data-style="btn-input-primary" data-actions-box="true" title="Informe a Forma de Desconto">                                                
                                                <option value="0" <?php if($usuario->tipo_acesso == 0) echo "selected" ?>>Usuário Comum</option>
                                                <option value="1" <?php if($usuario->tipo_acesso == 1) echo "selected" ?>>Usuário Administrador</option>
                                            </select>
                                        </div>
                                    </div>                                    
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
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input autocomplete="off" type="radio" id="radioAtivo" name="Ativo"
                                                    <?php if($usuario->ativo == 1) echo "checked" ?>
                                                    class="custom-control-input" value="1">
                                                <label class="custom-control-label" for="radioAtivo">Usuário Ativo</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input autocomplete="off" type="radio" id="radioInativo" name="Ativo"
                                                    <?php if($usuario->ativo == 2) echo "checked" ?>
                                                    class="custom-control-input" value="2">
                                                <label class="custom-control-label" for="radioInativo">Usuário Inativo</label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr> 
									<div class="form-row">
										<label for="inputTipoAcesso">Módulos Liberados</label></label>
									</div>
									<div class="form-row">
										<div class="form-group col-md-2">
											<div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="inputProducao" 
                                                <?php if($usuario->producao == 1) echo "checked" ?> value="1" name="Producao">
												<label class="custom-control-label" for="inputProducao">Produção</label>
											</div>
										</div>
										<div class="form-group col-md-2">
											<div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="inputVendas" 
                                                <?php if($usuario->vendas == 1) echo "checked" ?>  value="1" name="Vendas">
												<label class="custom-control-label" for="inputVendas">Vendas</label>
											</div>
										</div>
										<div class="form-group col-md-2">
											<div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="inputCompras"
                                                <?php if($usuario->compras == 1) echo "checked" ?> value="1" name="Compras">
												<label class="custom-control-label" for="inputCompras">Compras</label>
											</div>
										</div>
										<div class="form-group col-md-2">
											<div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="inputEstoque"
                                                <?php if($usuario->estoque == 1) echo "checked" ?> value="1" name="Estoque">
												<label class="custom-control-label" for="inputEstoque">Estoque</label>
											</div>
										</div>
										<div class="form-group col-md-2">
											<div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="inputFinanceiro"
                                                <?php if($usuario->financeiro == 1) echo "checked" ?> value="1" name="Financeiro">
												<label class="custom-control-label" for="inputFinanceiro">Financeiro</label>
											</div>
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