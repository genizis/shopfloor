<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>


<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active"><a href="<?php echo base_url() ?>natureza-operacao">Natureza da Operação</a></li>
            <li class="breadcrumb-item active">Nova Natureza da Operação</li>
        </ol>
    </div>
</section>

<section >

    <div class="container" id="app">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12">
                <div class="card  mb-3">
                    <div class="card-body">
                        <div class="row">
                            
                            <div class="col-lg-12 col-md-12 col-xs-12">

                                <natureza-operacao-form></natureza-operacao-form>

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

    $("#inputProdutoOrdem").change(function() {

     var baseurl = "<?php echo base_url(); ?>";

     var produto = $("#inputProdutoOrdem").val();

     $.post(baseurl + "ajax/busca-produto", {
      produto: produto
  }, function(valor) {
      var aValor = valor.split('|');
      console.log(aValor);
      $("#inputUn").val(aValor[0]);
      $("#inputTipoProduto").val(aValor[1]);
  });

 });

    $('#inputDataEmissao').datepicker({
        uiLibrary: 'bootstrap4'
    });

    $('#inputDataFim').datepicker({
        uiLibrary: 'bootstrap4'
    });

</script>


<script src="<?= base_url('/assets/js/app.js'); ?>" type="text/javascript"></script>

<?php $this->load->view('gerais/footer'); ?>