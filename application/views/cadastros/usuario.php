<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active">Usuário</li>
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
                            <div class="col-md-9">
                                <a href="<?php echo base_url() ?>usuario/novo-usuario" type="button"
                                    class="btn btn-info <?php if($empresa->num_usuario >= $empresa->quant_usuarios) echo "disabled"; ?>"><i class="fas fa-plus-circle"></i> Novo Usuário</a>
                            </div>
                            <div class="col-md-3">
                                <form action="<?= base_url('usuario') ?>" method="GET" class="needs-validation" novalidate>
                                    <div class="input-group">
                                        <input type="text" class="form-control search" name="buscar">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-secondary"><i
                                                    class="fas fa-search"></i> Buscar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div> 
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
                                <form action="<?= base_url('usuario/excluir-usuario') ?>" method="POST" id="formDelete" class="needs-validation" novalidate>
                                    <table class="table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">E-mail</th>
                                                <th scope="col">Nome do Usuário</th>                                                
                                                <th scope="col">Tipo de Acesso</th>
                                                <th scope="col" class="text-center">Ativo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($lista_usuario as $key_usuario => $usuario) { ?>
                                            <tr>
                                                <td scope="row"><a
                                                        href="<?= base_url("usuario/editar-usuario/{$usuario->email}") ?>"><?= $usuario->email ?></a>
                                                </td>
                                                <td><?= $usuario->nome_usuario ?></td>
                                                <td>
                                                    <?php
                                                        switch ($usuario->tipo_acesso) {
                                                            case 0:
                                                                echo "Usuário Comum";
                                                                break;
                                                            case 1:
                                                                echo "Usuário Administrador";
                                                                break;
                                                        }                                                        
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                        switch ($usuario->ativo) {
                                                            case 0:
                                                                echo "<span class='badge badge-secondary'>Inativo</span>";
                                                                break;
                                                            case 1:
                                                                echo "<span class='badge badge-teal'>Ativo</span>";
                                                                break;                                                            
                                                        }                                                        
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <?php if ($lista_usuario == false) { ?>
                                    <div class="text-center">
                                        <p>Nenhum usuário encontrado</p>
                                    </div>
                                    <?php } ?>
                                </form>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-xs-12">
                                <div>
                                    <?= $pagination; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>

$('.page-item>a').addClass("page-link");

</script>

<?php $this->load->view('gerais/footer'); ?>