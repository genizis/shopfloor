<?php $this->load->view('gerais/header' , $menu); ?>

<section>
    <div class="container mt-5">
        <div class="row border-bottom border-muted mb-3 ">
            <div class="col-md-12">
                <h1 class="display-4">Pedido de Compra</h1>
            </div>
        </div>
        <div class="row border-bottom border-muted mb-3">
            <div class="col-6">
                <h3 class="text-muted">Data Entrega: <strong class="text-dark"><?= str_replace("-", "/", date("d-m-Y", strtotime($pedido->data_entrega))) ?></strong></h3>
            </div>
            <div class="col-6 text-right">
                <h3 class="text-muted mb-3">Número: <strong class="text-dark"><?= $pedido->num_pedido_compra ?></strong></h3>
            </div>
        </div>
        <div class="row border-bottom mb-3">
            <div class="col-12">
                <h1 class="mb-1"><?= $empresa->nome_empresa ?></h1>
                <h4 class="mb-1 text-muted"><?= $empresa->endereco ?> - <?= $empresa->bairro ?> - <?= $empresa->nome_cidade ?> - <?= $empresa->uf ?></h4>
                <h4 class="mb-3 text-muted">CPF/CNPJ: <?= $empresa->cnpj_cpf ?></h4>
                <h4 class="mb-1"><?= getDadosUsuarioLogado()["nome_usuario"] ?></h4>
                <h5 class="mb-3 text-muted"><?= getDadosUsuarioLogado()["email"] ?></h5>
            </div>
        </div>
        <div class="row border-bottom mb-3">
            <div class="col-12 border mb-3">
                <h3 class="mb-1 mt-3"><?= $fornecedor->nome_fornecedor ?></h3>
                <h5 class="mb-1 text-muted"><?= $fornecedor->endereco ?> - <?= $fornecedor->bairro ?> - <?= $fornecedor->nome_cidade ?> - <?= $fornecedor->uf ?></h5>
                <h5 class="mb-1 text-muted">CPF/CNPJ: <?= $fornecedor->cnpj_cpf ?></h5>
                <h5 class="mb-3 text-muted"><?= $fornecedor->email ?></h5>
            </div>
        </div>
        <div class="row border-bottom mb-3">
            <div class="col-12">
                <p class="lead"><?= $pedido->observacoes ?></p>
            </div>
        </div>
        <div class="row border-bottom mb-5">
            <div class="col-12">
                <table class="table table-bordered table-hover h4">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="text-center">Código</th>
                            <th scope="col">Descrição</th>
                            <th scope="col" class="text-center">Un</th> 
                            <th scope="col" class="text-center">Valor Unitário</th>
                            <th scope="col" class="text-center">Quantidade</th>
                            <th scope="col" class="text-center">Subtotal</th>                                                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $total = 0; foreach($lista_produto as $key_produto => $produto) {
                            $total = $total +  $produto->total_compra;?>
                        <tr>
                            <td class="text-center"><?= $produto->cod_produto ?></td>
                            <td><?= $produto->nome_produto ?></td>
                            <td class="text-center"><?= $produto->cod_unidade_medida ?></td>  
                            <td class="text-center">R$ <?= number_format($produto->total_compra / $produto->quant_pedida, 2, ",", ".") ?></td>                                                             
                            <td class="text-center"><?= number_format($produto->quant_pedida, 3, ",", ".") ?></td> 
                            <td class="text-center">R$ <?= number_format($produto->total_compra, 2, ",", ".") ?></td>                                   
                        </tr>
                        <?php } ?>                                                        
                    </tbody>
                </table>
                <?php if ($lista_produto == false) { ?>
                <div class="text-center">
                    <p>Nenhum produto inserido</p>
                </div>
                <?php }else{ ?>
                <div class="row">
                    <div class="col-7"></div>
                    <div class="col-5">
                        <table class="table table-bordered h4 mb-4">
                            <tbody>                                                            
                                <tr>
                                    <th class="table-light">Total</th>
                                    <td class="text-right"><strong>R$ <?= number_format($total, 2, ",", ".") ?></strong></td>
                                </tr> 
                                <tr>
                                    <th class="table-light">Desconto</th>
                                    <td class="text-right" id="inputValorDesconto">
                                        <?php if($pedido->tipo_desconto == 1) echo "R$"; ?>
                                        <?= number_format($pedido->valor_desconto, 2, ",", "."); ?>
                                        <?php if($pedido->tipo_desconto == 2) echo "%"; ?>
                                    </td>
                                </tr>
                                <tr class="">
                                    <th class="table-light"><strong>Valor Líquido</strong></th>
                                    <td class="text-right text-teal"><strong id="inputValorLiq">R$ 
                                    <?php 
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
            </div>
            <hr>
        </div>  
    </div>
</section>

<?php $this->load->view('gerais/footer'); ?>