<?php $this->load->view('gerais/header' , $menu); ?>

<body class="bg-default">
    <div class="modal fade bd-example-modal-lg" data-backdrop="static" data-keyboard="false" tabindex="-1" id="spinner">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="spinner-grow text-light" style="width: 7rem; height: 7rem;" role="status">
					<span class="sr-only">Loading...</span>
				</div>
			</div>
		</div>
	</div>

    <section>
        <div class="container">
            <div class="row login">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <div class="text-center">
                        <img src="<?= base_url('img/logo-login.png') ?>" class="img-fluid mb-3" alt="">
                    </div>
                    <div class="card ">
                        <div class="card-body">
                            <legend><strong>Acessar a minha conta</strong></legend>
                            <hr>
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
                            <form action="<?= base_url('login') ?>" method="POST" id="login" class="mb-0 needs-validation" novalidate>
                                <fieldset>   
                                    <div class="form-row">                                 
                                        <div class="form-group col-md-12">
                                            <label class="col-form-label" for="inputEmailUsuario">E-mail <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputEmailUsuario" name="Email" 
                                                value="<?= set_value('Email') ?>">
                                        </div>
                                    </div>
                                    <div class="form-row"> 
                                        <div class="form-group col-md-12">
                                            <label class="col-form-label" for="inputSenha1">Senha <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="inputSenha" name="Senha">
                                        </div> 
                                    </div>
                                    <button type="submit" form="login" class="btn btn-outline-teal btn-lg btn-block mt-2">Entrar</button>                                   
                                </fieldset>
                            </form>                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-xs-3"></div>
            </div>
        </div>
    </section>

    <script>
    $('#inputCPFCNPJ').mask('00.000.000/0000-00', {
        reverse: true
    });

    $("#radioJuridica").change(function() {
        $('#inputCPFCNPJ').mask('00.000.000/0000-00', {
            reverse: true
        });
    });

    $("#radioFisica").change(function() {
        $('#inputCPFCNPJ').mask('000.000.000-00', {
            reverse: true
        });
    });

    $('#inputTelefoneFixo').mask('(00) 0000-0000');

    $('#inputTelefoneCelular').mask('(00) 0 0000-0000');
    </script>

    <?php $this->load->view('gerais/footer'); ?>