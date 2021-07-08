<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url() ?>fornecedor">Fornecedor</a></li>
            <li class="breadcrumb-item active">Importar Fornecedor</li>
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
                            <div class="col-md-6">
                                <form action="<?= base_url('fornecedor/importar-fornecedor') ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="checkCabecalho" name="cabecalho" value="1" checked>
                                            <label class="custom-control-label" for="checkCabecalho">Minha planilha tem cabeçalho</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input search" name="arquivo" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                                            <label class="custom-file-label search">Escolha arquivo para importar</label>
                                        </div>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-secondary"><i class="fas fa-file-import"></i> Importar</button>
                                        </div>
                                    </div>                                    
                                    <small id="passwordHelpBlock" class="form-text text-muted">
                                        O arquivo a ser importado necessariamente precisa conter a estenção .xlsx ou .csv (excel) e o layout deve conter as colunas abaixo
                                    </small>
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
                                <form action="<?= base_url('fornecedir/excluir-fornecedor') ?>" method="POST" id="formDelete" class="needs-validation" novalidate>
                                    <table class="table table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <?php if($lista_fornecedor != null) { ?>
                                                <th scope="col" class="text-center">Código</th>
                                                <th scope="col" class="text-center">CNPJ/CPF</th>
                                                <th scope="col" class="text-center">Nome do Fornecedor</th>
                                                <th scope="col" class="text-center">Segmento do Fornecedor</th>
                                                <th scope="col" class="text-center">Telefone Fixo</th>
                                                <th scope="col" class="text-center">Telefone Celular</th>
                                                <th scope="col" class="text-center">E-mail</th>
                                                <th scope="col" class="text-center">Rua e Número</th>
                                                <th scope="col" class="text-center">Bairro</th>
                                                <th scope="col" class="text-center">Estado</th>
                                                <th scope="col" class="text-center">Cidade</th>
                                                <th scope="col" class="text-center">Resultado</th>
                                                <?php }else{ ?>
                                                <th scope="col" class="text-center">CNPJ/CPF</th>
                                                <th scope="col" class="text-center">Nome do Fornecedor <span class="text-danger">*</span></th>
                                                <th scope="col" class="text-center">Segmento do Fornecedor</th>
                                                <th scope="col" class="text-center">Telefone Fixo</th>
                                                <th scope="col" class="text-center">Telefone Celular</th>
                                                <th scope="col" class="text-center">E-mail</th>
                                                <th scope="col" class="text-center">Rua e Número</th>
                                                <th scope="col" class="text-center">Bairro</th>
                                                <th scope="col" class="text-center">Estado</th>
                                                <th scope="col" class="text-center">Cidade</th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if($lista_fornecedor != null) {
                                                  foreach($lista_fornecedor as $key_fornecedor => $fornecedor) { ?>
                                            <tr>
                                                <td class="text-center"><?= $fornecedor->cod_fornecedor ?></td>
                                                <td class="text-center"><?= $fornecedor->cnpj_cpf ?></td>
                                                <td class="text-center"><?= $fornecedor->nome_fornecedor ?></td>
                                                <td class="text-center"><?= $fornecedor->nome_segmento ?></td>
                                                <td class="text-center"><?= $fornecedor->tel_fixo ?></td>
                                                <td class="text-center"><?= $fornecedor->tel_cel ?></td>
                                                <td class="text-center"><?= $fornecedor->email ?></td>
                                                <td class="text-center"><?= $fornecedor->endereco ?></td>
                                                <td class="text-center"><?= $fornecedor->bairro ?></td>
                                                <td class="text-center"><?= $fornecedor->estado ?></td>
                                                <td class="text-center"><?= $fornecedor->cidade ?></td>
                                                <td class="text-center <?php if($fornecedor->resultado == 1) echo "text-teal"; 
                                                                         elseif($fornecedor->resultado == 2) echo "text-warning";
                                                                         elseif($fornecedor->resultado == 3) echo "text-danger"; ?>"><?= $fornecedor->desc_resultado ?></td>
                                            </tr>
                                            <?php }}else{ ?>
                                            <tr>
                                                <td class="text-center small">CNPJ ou CPF contendo máscara (Ex 00.000.000/0000-00 ou 000.000.000-00)</td>
                                                <td class="text-center small">Razão social do fornecedor</td>
                                                <td class="text-center small">Nome do segmento conforme opções do ShopFloor</td>
                                                <td class="text-center small">Telefone fixo contendo máscara (Ex (00) 0000-0000)</td>
                                                <td class="text-center small">Telefone celular contendo máscara (Ex (00) 0 0000-0000)</td>
                                                <td class="text-center small">E-mail válido do fornecedor</td>
                                                <td class="text-center small">Endereço do fornecedor</td>
                                                <td class="text-center small">Bairro do fornecedor</td>
                                                <td class="text-center small">Sigla do estado do fornecedor (Ex PR, SP, SC e etc...)</td>
                                                <td class="text-center small">Nome da cidade do fornecedor conforme opções do ShopFloor</td>
                                            </tr>                                            
                                            <?php } ?>
                                        </tbody>
                                    </table>
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
$('.page-item>a').addClass("page-link");

$("[name='excluir_todos[]']").click(function() {
    var cont = $("[name='excluir_todos[]']:checked").length;
    $("#btnExcluir").prop("disabled", cont ? false : true);
});

// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
</script>

<?php $this->load->view('gerais/footer'); ?>