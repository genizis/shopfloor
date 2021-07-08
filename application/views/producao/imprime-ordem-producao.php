<?php $this->load->view('gerais/header' , $menu); ?>

<section>
    <div class="container-cupom mt-5">
        <div class="row border-bottom border-dark mb-3">
            <div class="col-6">
                <h3 class="text-black-50"><?= str_replace("-", "/", date("d-m-Y", strtotime($ordem->data_emissao))) ?>
                </h3>
            </div>
            <div class="col-6 text-right">
                <h3 class="text-black-50 mb-3">Ordem de Produção <strong
                        class="text-dark"><?= $ordem->num_ordem_producao ?></strong></h3>
            </div>
        </div>
        <div class="row border-bottom border-dark mb-3">
            <div class="col-12">
                <h1 class="text-uppercase mb-2"><strong><?= $empresa->nome_empresa ?></strong></h1>
                <h3 class="text-muted mb-3">Data de Produção: <strong
                        class="text-dark"><?= str_replace("-", "/", date("d-m-Y", strtotime($ordem->data_fim))) ?></strong>
                </h3>
            </div>
        </div>
        <?php if($ordem->observacoes != ""){ ?>
        <div class="row border-bottom border-dark mb-3">
            <div class="col-12">
                <p class="lead text-uppercase"><?= $ordem->observacoes ?></p>
            </div>
        </div>
        <?php } ?>
        <div class="row border-bottom border-dark mb-3">
            <table class="table table-bordered table-hover h4 mb-4">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Produto Produção</th>
                        <th scope="col" class="text-center">Un</th>
                        <th scope="col" class="text-center">Quant Prevista</th>
                        <th scope="col" class="text-center">Quant Produzida</th>
                        <th scope="col" class="text-center">Quant Perdida</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span class="text-black-50"><?= $ordem->cod_produto ?></span> - <?= $ordem->nome_produto ?></td>
                        <td class="text-center"><?= $ordem->cod_unidade_medida ?></td>
                        <td class="text-center"><?= number_format($ordem->quant_planejada, 3, ",", ".") ?></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row border-bottom border-dark mb-3">
            <table class="table table-bordered table-hover h4 mb-4">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Produto Consumo</th>
                        <th scope="col" class="text-center">Un</th>
                        <th scope="col" class="text-center">Cons Previsto</th>
                        <th scope="col" class="text-center">Cons Realizado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                            foreach($lista_produto as $key_produto => $produto) { ?>
                    <tr>
                        <td><span class="text-black-50"><?= $produto->cod_produto ?></span> - <?= $produto->nome_produto ?></td>
                        <td class="text-center"><?= $produto->cod_unidade_medida ?></td>
                        <td class="text-center"><?= number_format($produto->quant_consumo, 3, ",", ".") ?></td>
                        <td class="text-center"></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php if ($lista_produto == false) { ?>
            <div class="text-center">
                <p>Nenhum produto de consumo</p>
            </div>
            <?php } ?>
        </div>
        <div class="row border-bottom border-dark mb-3">
            <h5 class="text-muted">Observações da Produção</h5>
            <div class="col-12 border mb-4">
                <br> <br> <br> <br> <br>
            </div>
        </div>
        <div class="text-center h5">
            www.shopfloor.com.br
        </div>
    </div>
</section>

<?php $this->load->view('gerais/footer'); ?>