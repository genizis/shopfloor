<link href="<?= base_url('/css/print.css'); ?>" rel = "stylesheet" type = "text/css" />

<table class="printer-ticket">
 	<thead>
		<tr>
			<th class="title" colspan="3"><?= $empresa->nome_empresa ?></th>
		</tr>
		<tr>
			<th colspan="3"><?= str_replace("-", "/", date("d-m-Y", strtotime($venda->data_caixa))) ?></th>
		</tr>
		<tr>
			<th colspan="3">
            <?php 
                if($venda->cod_cliente <> 0)
                    echo $cliente->nome_cliente;
                else
                    echo "Consumidor Final"; ?><br />                
			<?= $venda->cnpj_cpf ?>
            <?php 
				if($venda->cod_cliente <> 0) {
					if($cliente->endereco != "")
						echo "<br />" . $cliente->endereco . ", " . $cliente->numero . " - " . $cliente->bairro . "<br>";
					if($cliente->nome_cidade != "")
						echo $cliente->nome_cidade . " - " . $cliente->uf .  "<br>";
					if($cliente->cep != "")
						echo $cliente->cep;
				}
                 ?>                 
			</th>
		</tr>
		<tr>
			<th class="ttu" colspan="3">
				<b>Cupom não fiscal</b>
			</th>
		</tr>
	</thead>
	<tbody>
        <?php 
            foreach($lista_produto as $key_produto => $produto) { ?>
		<tr class="top">
			<td colspan="3"><?= $produto->cod_produto ?> - <?= $produto->nome_produto ?></td>
		</tr>
		<tr>
			<td>R$ <?= number_format($produto->valor_unit, 2, ",", ".") ?></td>
			<td><?= number_format($produto->quant_venda, 3, ",", ".") ?></td>
			<td>R$ <?= number_format($produto->quant_venda * $produto->valor_unit, 2, ",", ".") ?></td>
		</tr>
        <?php } ?>
	</tbody>
	<tfoot>
		<tr class="sup ttu p--0">
			<td colspan="3">
				<b>Totais</b>
			</td>
		</tr>
		<tr class="ttu">
			<td colspan="2">Sub-total</td>
			<td align="right">R$ <?= number_format($venda->sub_total, 2, ',', '.') ?></td>
		</tr>
		<tr class="ttu">
			<td colspan="2">Desconto</td>
			<td align="right">R$ <?php
                                    if($venda->tipo_desconto == 1)
                                        echo number_format($venda->valor_desconto, 2, ',', '.');
                                    else{
                                        echo number_format($venda->sub_total * ($venda->valor_desconto / 100), 2, ',', '.');
                                    }
                                 ?></td>
		</tr>
		<tr class="ttu">
			<td colspan="2">Total</td>
			<td align="right">R$ <?php
                                    if($venda->tipo_desconto == 1)
                                        echo number_format($venda->sub_total - $venda->valor_desconto, 2, ',', '.');
                                    else{
                                        echo number_format($venda->sub_total - ($venda->sub_total * ($venda->valor_desconto / 100)), 2, ',', '.');
                                   }
                                 ?></td>
		</tr>
		<tr class="sup ttu p--0">
			<td colspan="3">
				<b>Pagamentos</b>
			</td>
		</tr>
        <?php foreach($lista_metodo as $key_lista_metodo => $metodo_caixa) { ?>
		<tr class="ttu">
			<td colspan="2"><?= $metodo_caixa->nome_metodo_pagamento ?></td>
			<td align="right">R$ <?= number_format($metodo_caixa->valor_pagamento, 2, ',', '.') ?></td>
		</tr>
        <?php } ?>
		<tr class="sup">
			<td colspan="3" align="center">
				<b>Pedido:</b> <?= $venda->num_venda_caixa ?>
			</td>
		</tr>
		<tr class="sup">
			<td colspan="3" align="center">
				www.shopfloor.com.br
			</td>
		</tr>
	</tfoot>
</table>