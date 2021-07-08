<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url() ?>estrutura-produto">Estrutura de Produto</a>
            </li>
            <li class="breadcrumb-item active">Nova Estrutura de Produto</li>
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
                                <form action="<?= base_url('estrutura-produto/nova-estrutura-produto') ?>" method="POST" id="EstruturaProd" class="needs-validation" novalidate>
                                    <div class="form-row">
                                        <div class="form-group col-md-9">
                                            <label for="inputProduto">Produto de Produção <span class="text-danger">*</span></label>
                                            <select id="inputProduto" class="selectpicker show-tick form-control"
                                               data-style="btn-input-primary" data-live-search="true" data-actions-box="true"
                                                title="Selecione um Produto" name="CodProduto" required>
                                                <?php foreach($lista_produto_prod as $key_produto_prod => $produto_prod) { ?>
                                                <option value="<?= $produto_prod->cod_produto ?>"
                                                <?php if($produto_prod->cod_produto == set_value('CodProduto')) echo "selected"; ?>>
                                                    <?= $produto_prod->cod_produto ?> -
                                                    <?= $produto_prod->nome_produto ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label" for="inputUn">Unidade de Medida</label>
                                            <input class="form-control" id="inputUn" type="text" name="UnidadeMedida"
                                                readonly value="<?= set_value('UnidadeMedida'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label class="control-label" for="inputTipoProduto">Tipo de Produto</label>
                                            <input class="form-control" id="inputTipoProduto" type="text" name="TipoProduto"
                                                readonly value="<?= set_value('TipoProduto'); ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputQuantProducao">Quantidade de Produção <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputQuantProducao" data-mask="#.##0,000" data-mask-reverse="true"
                                                name="QuantProducao" value="<?= set_value('QuantProducao'); ?>" required>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h6>Lista de Materiais</h6>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-xs-12">
                                                    <button type="button" class="btn btn-outline-info btn-sm" data-toggle="tooltip" data-placement="bottom" 
                                                    title="Você deve primeiramente salvar o produto antes de inserir os componentes" disabled><i class="fas fa-plus-circle"></i> Novo
                                                        Componente</button>
                                                    <button type="button"
                                                        class="btn btn-outline-danger btn-sm" data-toggle="tooltip" data-placement="bottom" 
                                                    title="Você deve primeiramente salvar o produto antes de excluir os componentes" disabled><i class="fas fa-trash-alt"></i>
                                                        Excluir</button>
                                                </div>
                                            </div>
                                            <table class="table table-bordered table-hover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th scope="col" class="text-center">#</th>
                                                        <th scope="col">Codigo do Componente</th>
                                                        <th scope="col">Nome do Componente</th>
                                                        <th scope="col">Unidade de Medida</th>
                                                        <th scope="col">Tipo de Produto</th>
                                                        <th scope="col">Quantidade de Consumo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>                                                    
                                                </tbody>
                                            </table>
                                            <div class="text-center" id="divAviso">
                                                <p id="pAviso">Nenhum componente cadastrado</p>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <hr>
                                    <div class="row float-right">
                                        <div class="col-lg-12 col-md-12 col-xs-12 margem-baixo-10">
                                            <button type="submit" form="EstruturaProd" class="btn btn-primary"
                                                name="Opcao" value="salvar"><i class="fas fa-save"></i> Salvar</button>
                                            <a href="<?php echo base_url() ?>estrutura-produto"
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

$("#inputProduto").change(function() {

    var baseurl = "<?php echo base_url(); ?>";

    var produto = $("#inputProduto").val();

    $.post(baseurl + "ajax/busca-produto", {
        produto: produto
    }, function(valor) {
        var aValor = valor.split('|');
        console.log(aValor);
        $("#inputUn").val(aValor[0]);
        $("#inputTipoProduto").val(aValor[1]);
    });

});

</script>

<?php $this->load->view('gerais/footer'); ?>