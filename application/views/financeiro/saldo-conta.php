<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active">Saldo Por Conta</li>
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
                                        <a href="<?= base_url("financeiro/saldo-conta/{$mes_anterior}/{$ano_anterior}") ?>" class="btn btn-secondary"><i class="fas fa-angle-left"></i></a>
                                    </div>
                                    <input type="text" class="form-control search text-center" value="<?= $mes ?>/<?= $ano ?>" readonly>
                                    <div class="input-group-append">
                                        <a href="<?= base_url("financeiro/saldo-conta/{$mes_seguinte}/{$ano_seguinte}") ?>" class="btn btn-secondary"
                                        ><i class="fas fa-angle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7"></div>
                            <div class="col-md-3">
                                <form action="<?= base_url("financeiro/saldo-conta/{$mes_anterior}/{$ano_anterior}") ?>" method="GET" class=" needs-validation" novalidate>
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
                                                <th scope="col" class="text-center">Cód Conta</th>
                                                <th scope="col">Nome da Conta</th>
                                                <th scope="col" class="text-center">Confirmado</th>
                                                <th scope="col" class="text-center">Projetado</th>
                                                <th scope="col" class="text-center">Status</th>
                                                <th scope="col" class="text-center">#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($lista_conta as $key_conta => $conta) { 
                                                    if(date(''.$ano.'-'.$mes.'-01') == date('Y-m-01')){
                                                        $saldoConta = $conta->saldo_conta;
                                                    }else{
                                                        $saldoConta = $conta->saldo_conta + $conta->valor_saida - $conta->valor_entrada;
                                                    }
                                                    
                                                    $saldoProj = $saldoConta - $conta->proj_saida + $conta->proj_entrada; ?>
                                            <tr>
                                                <td class="text-center"><a target="_blank"
                                                        href="<?= base_url("conta/editar-conta/{$conta->cod_conta}") ?>"><?= $conta->cod_conta ?></a>
                                                </td>
                                                <td><?= $conta->nome_conta ?></td>
                                                <td class="<?php if($saldoConta > 0) echo "text-teal";
                                                                if($saldoConta < 0) echo "text-danger"; ?> text-center">R$ <?= number_format($saldoConta, 2, ',', '.') ?></td>
                                                <td class="<?php if($saldoProj > 0) echo "text-teal";
                                                                if($saldoProj < 0) echo "text-danger"; ?> text-center">R$ <?= number_format($saldoProj, 2, ',', '.') ?></td>
                                                <td class="text-center">
                                                    <?php if($conta->ativo == 1) {
                                                            echo "<span class='badge badge-teal'>Ativo</span>";
                                                        }else{
                                                            echo "<span class='badge badge-secondary'>Inativo</span>";
                                                        }
                                                    ?>
                                                </td>
                                                <td class="text-center"><a
                                                        href="<?= base_url("financeiro/saldo-conta/movimento-conta/{$conta->cod_conta}") ?>"
                                                        type="button" class="btn btn-outline-primary btn-sm">Extrato da Conta</a>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <?php if ($lista_conta == false) { ?>
                                    <div class="text-center">
                                        <p class="text-muted mb-0">Nenhuma conta encontrada</p>
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