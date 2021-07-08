<?php $this->load->view('gerais/header' , $menu); ?>

<section>
    <div class="container-cupom mt-5">
        <div class="row border-bottom border-dark mb-3">
            <div class="col-6">
                <h3 class="text-black-50"><?= str_replace("-", "/", date("d-m-Y", strtotime($pedido->data_emissao))) ?>
                </h3>
            </div>
            <div class="col-6 text-right">
                <h3 class="text-black-50 mb-3"><?php
                                                if($pedido->situacao == 1) echo "Orçamento";
                                                if($pedido->situacao == 3) echo "Pedido de Venda";
                                            ?> <strong class="text-dark"><?= $pedido->num_pedido_venda ?></strong></h3>
            </div>
        </div>
        <div class="row border-bottom border-dark mb-3">
            <div class="col-6">
                <h1 class="text-uppercase"><strong><?= $empresa->nome_empresa ?></strong></h1>
                <?php if($empresa->endereco != ""){ ?>
                <h4 class="mt-1">
                    <?php echo $empresa->endereco . ", " . $empresa->numero . " - " . $empresa->bairro; ?></h4>
                <?php } ?>
                <?php if($empresa->nome_cidade != ""){ ?>
                <h4 class="mt-1"><?php echo $empresa->nome_cidade . "/" . $empresa->uf; ?></h4>
                <?php } ?>
                <?php if($empresa->cep != ""){ ?>
                <h4 class="mt-1"><?php echo $empresa->cep ?></h4>
                <?php } ?>
                <h4 class="mb-3 mt-3 text-black-50">CPF/CNPJ: <?= $empresa->cnpj_cpf ?></h4>
            </div>
            <div class="col-6 text-right">
                <h4 class="mb-1"><?= getDadosUsuarioLogado()["nome_usuario"] ?></h4>
                <h5 class="mb-3 text-black-50"><?= getDadosUsuarioLogado()["email"] ?></h5>
            </div>
        </div>
        <div class="row border-bottom border-dark mb-3">
            <div class="col-12 border border-dark mb-3">
                <h3 class="mb-1 mt-3 text-uppercase"><strong><?= $cliente->nome_cliente ?></strong></h3>
                <?php if($cliente->endereco != ""){ ?>
                <h4 class="mt-1">
                    <?php echo $cliente->endereco . ", " . $cliente->numero . " - " . $cliente->bairro; ?></h4>
                <?php } ?>
                <?php if($cliente->nome_cidade != ""){ ?>
                <h4 class="mt-1"><?php echo $cliente->nome_cidade . "/" . $cliente->uf; ?></h4>
                <?php } ?>
                <?php if($cliente->cep != ""){ ?>
                <h4 class="mt-1"><?php echo $cliente->cep ?></h4>
                <?php } ?>
                <h5 class="mb-1 text-black-50">CPF/CNPJ: <?= $cliente->cnpj_cpf ?></h5>
                <h5 class="mb-3 text-black-50"><?= $cliente->email ?></h5>
            </div>
        </div>
        <?php if($pedido->observacoes != ""){ ?>
        <div class="row border-bottom border-dark mb-3">
            <div class="col-12">
                <p class="lead text-uppercase"><?= $pedido->observacoes ?></p>
            </div>
        </div>
        <?php } ?>
        <div class="row border-bottom border-dark mb-3">
            <table class="table text-uppercase mb-3 h4">
                <thead>
                    <tr>
                        <th scope="col">Produto</th>
                        <th scope="col" class="text-center">Un</th>
                        <th scope="col" class="text-center">Valor Unitário</th>
                        <th scope="col" class="text-center">Quantidade</th>
                        <th scope="col" class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                            $total = 0; foreach($lista_produto as $key_produto => $produto) {
                            $total = $total +  ($produto->valor_unitario * $produto->quant_pedida);
                             ?>
                    <tr>
                        <td><span class="text-black-50"><?= $produto->cod_produto ?></span> -
                            <?= $produto->nome_produto ?></td>
                        <td class="text-center"><?= $produto->cod_unidade_medida ?></td>
                        <td class="text-center">R$ <?= number_format($produto->valor_unitario, 2, ",", ".") ?></td>
                        <td class="text-center"><?= number_format($produto->quant_pedida, 3, ",", ".") ?></td>
                        <td class="text-right">R$
                            <?= number_format($produto->valor_unitario * $produto->quant_pedida, 2, ",", ".") ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php if ($lista_produto == false) { ?>
            <div class="text-center">
                <p>Nenhum produto inserido</p>
            </div>
            <?php }else{ ?>
            <div class="col-6 border-top border-dark"></div>
            <div class="col-6 border-top border-dark">
                <div class="row">
                    <table class="table table-borderless h4 mb-4 mt">
                        <tbody>
                            <tr>
                                <th class="text-black-50 text-right">TOTAL</th>
                                <td class="text-right"><strong>R$ <?= number_format($total, 2, ",", ".") ?></strong>
                                </td>
                            </tr>
                            <?php if($pedido->tipo_frete == 1 && $pedido->valor_frete > 0){ ?>
                            <tr>
                                <th class="text-black-50 text-right">FRETE</th>
                                <td class="text-right"><strong>R$ <?= number_format($pedido->valor_frete, 2, ',', '.') ?></strong></td>
                            </tr>
                            <?php } ?>
                            <?php if($pedido->valor_desconto != 0){ ?>
                            <tr>
                                <th class="text-black-50 text-right">DESCONTO</th>
                                <td class="text-right" id="inputValorDesconto">
                                    <?php if($pedido->tipo_desconto == 1) echo "R$"; ?>
                                    <?= number_format($pedido->valor_desconto, 2, ",", "."); ?>
                                    <?php if($pedido->tipo_desconto == 2) echo "%"; ?>
                                </td>
                            </tr>
                            <?php } ?>
                            <tr class="h3">
                                <th class="table-light text-right"><strong>VALOR LÍQUIDO</strong></th>
                                <td class="text-right text-teal"><strong id="inputValorLiq">R$
                                        <?php 
                                            if($pedido->tipo_frete == 1) $total = $total + $pedido->valor_frete;
                                            
                                            if($pedido->valor_desconto != 0){
                                                if($pedido->tipo_desconto == 1){
                                                    echo number_format($total - $pedido->valor_desconto, 2, ",", ".");
                                                }elseif($pedido->tipo_desconto == 2){
                                                    echo number_format($total - ($total * ($pedido->valor_desconto / 100)), 2, ",", ".");
                                                }
                                            }else{
                                                echo number_format($total, 2, ",", ".");
                                            }
                                        ?>
                                    </strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php } ?>
            <hr>
        </div>
        <div class="text-center h5">
            www.shopfloor.com.br
        </div>
    </div>
</section>