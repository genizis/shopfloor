<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active">Posição de Estoque</li>
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
                            <div class="col-md-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <a href="<?= base_url("estoque/posicao-estoque/{$mes_anterior}/{$ano_anterior}") ?>" class="btn btn-secondary"><i class="fas fa-angle-left"></i></a>
                                    </div>
                                    <input type="text" class="form-control search text-center" value="<?= $mes ?>/<?= $ano ?>" readonly>
                                    <div class="input-group-append">
                                        <a href="<?= base_url("estoque/posicao-estoque/{$mes_seguinte}/{$ano_seguinte}") ?>" class="btn btn-secondary <?php if(date(''.$ano.'-'.$mes.'-01') == date('Y-m-01')) echo "disabled"; ?>"
                                        ><i class="fas fa-angle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7"></div>
                            <div class="col-md-3">
                                <form action="<?= base_url("estoque/posicao-estoque/{$mes}/{$ano}") ?>" method="GET" class=" needs-validation" novalidate>
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
                                <div class="">
                                    <table class="table table-hover table-reporte">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col" class="text-center">Cód Produto</th>
                                                <th scope="col">Nome do Produto</th>
                                                <th scope="col">Tipo de Produto</th>
                                                <th scope="col" class="text-center">Unid Medida</th>
                                                <th scope="col" class="text-center">Qtde em Estoque</th>
                                                <th scope="col" class="text-center">Valor em Estoque</th>
                                                <th scope="col" class="text-center">#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($lista_produto as $key_produto => $produto) { 
                                                    if(date(''.$ano.'-'.$mes.'-01') == date('Y-m-01')){
                                                        $quantEstoq = $produto->quant_estoq;
                                                    }else{
                                                        $quantEstoq = $produto->quant_estoq + $produto->quant_saida - $produto->quant_entrada;
                                                    } ?>
                                            <tr>
                                                <td class="text-center"><a target="_blank"
                                                        href="<?= base_url("produto/editar-produto/{$produto->cod_produto}") ?>"><?= $produto->cod_produto ?></a>
                                                </td>
                                                <td><?= $produto->nome_produto ?></td>
                                                <td><?= $produto->nome_tipo_produto ?></td>
                                                <td class="text-center"><?= $produto->cod_unidade_medida ?></td>
                                                <td
                                                    class="text-center <?php if($quantEstoq < 0) echo "text-danger"; ?>">
                                                    <?= number_format($quantEstoq, 3, ',', '.') ?>
                                                </td>
                                                <td
                                                    class="text-center <?php if($quantEstoq < 0) echo "text-danger"; ?>">
                                                    R$ <?= number_format($produto->custo_medio * $quantEstoq, 2, ',', '.') ?>
                                                </td>
                                                <td class="text-center"><a
                                                        href="<?= base_url("estoque/posicao-estoque/movimento-produto/{$produto->cod_produto}") ?>"
                                                        type="button" class="btn btn-outline-primary btn-sm">Consultar
                                                        Movimentações</a>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <?php if ($lista_produto == false) { ?>
                                    <div class="text-center">
                                        <p class="text-muted mb-0">Nenhuma produto encontrado</p>
                                    </div>
                                    <?php } ?>
                                </div>
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