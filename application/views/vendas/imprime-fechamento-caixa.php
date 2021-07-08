<link href="<?= base_url('/css/print.css'); ?>" rel = "stylesheet" type = "text/css" />

<table class="printer-ticket">
 	<thead>
        <tr>
			<th class="title" colspan="3"><?= $empresa->nome_empresa ?></th>
		</tr>
        <tr>
			<th class="ttu" colspan="3">
				<b>Fechamento de Caixa</b>
			</th>
		</tr>        
		<tr>
			<th colspan="3"><?= str_replace("-", "/", date("d-m-Y", strtotime($frente_caixa->data_caixa))) ?></th>
		</tr>		
	</thead>
	<tfoot>
        <tr class="sup ttu p--0">
			<td colspan="3">
				<b>Vendas</b>
			</td>
		</tr>
        <tr class="ttu">
			<td>Total Vendido</td>
			<td align="right" colspan="2">R$ <?= number_format($frente_caixa->total_venda_geral, 2, ',', '.') ?></td>
		</tr>
		<tr class="ttu">
			<td>Total Desconto</td>
			<td align="right" colspan="2">R$ <?= number_format($frente_caixa->total_venda_geral - $frente_caixa->total_venda_liquido, 2, ',', '.') ?></td>
		</tr>
		<tr class="ttu">
			<td>Total Líquido</td>
			<td align="right" colspan="2">R$ <?= number_format($frente_caixa->total_venda_liquido, 2, ',', '.') ?></td>
		</tr>
		<tr class="sup ttu p--0">
			<td colspan="3">
				<b>Valores do Caixa</b>
			</td>
		</tr>
		<tr class="ttu">
			<td>Saldo Inicial Caixa</td>
			<td align="right" colspan="2">R$ <?= number_format($frente_caixa->saldo_inicial, 2, ',', '.') ?></td>
		</tr>
		<tr class="ttu">
			<td>Total Recolhimento</td>
			<td align="right" colspan="2">R$ <?= number_format($frente_caixa->total_recolhimento, 2, ',', '.') ?></td>
		</tr>
		<tr class="ttu">
			<td>Total Incremento</td>
			<td align="right" colspan="2">R$ <?= number_format($frente_caixa->total_incremento, 2, ',', '.') ?></td>
		</tr>        
        <tr class="ttu">
			<td>Total Vendas Caixa</td>
			<td align="right" colspan="2">R$ <?= number_format($frente_caixa->total_venda, 2, ',', '.') ?></td>
		</tr>
        <tr class="ttu">
			<td>Saldo Final Caixa</td>
			<td align="right" colspan="2">R$ <?= number_format($frente_caixa->saldo_inicial + $frente_caixa->total_venda + $frente_caixa->total_incremento - $frente_caixa->total_recolhimento, 2, ',', '.') ?></td>
		</tr>        
		<tr class="sup ttu p--0">
			<td colspan="3">
				<b>Pagamentos</b>
			</td>
		</tr>
        <?php foreach($recebeimento_metodo as $key_recebeimento_metodo => $recebimento) { ?>
		<tr class="ttu">
			<td><?= $recebimento->nome_metodo_pagamento ?></td>
			<td align="right" colspan="2">R$ <?= number_format($recebimento->total_venda, 2, ',', '.') ?></td>
		</tr>
        <?php if($recebeimento_metodo == false) { ?>	
        <tr class="nreg">
			<td colspan="3">Nenhuma venda realizada</td>
		</tr>
        <?php } ?>	
        <?php } ?>
        <tr class="sup ttu p--0">
			<td colspan="3">
				<b>Recolhimento / Incremento</b>
			</td>
		</tr>
        <?php foreach($movimento_caixa as $key_movimento_caixa => $movimento) { ?>
		<tr class="ttu">
			<td><?php 
                                if($movimento->tipo_movimento == 1)
                                    echo "Incremento";
                                else
                                    echo "Recolhimento";
                            ?></td>
			<td align="right" colspan="2">R$ <?= number_format($movimento->valor_movimento, 2, ',', '.') ?></td>
		</tr>
        <?php } ?>
        <?php if($movimento_caixa == false) { ?>	
        <tr class="nreg">
			<td colspan="3">Nenhum recolhimento ou incremento realizado</td>
		</tr>
        <?php } ?>
		<tr class="sup">
			<td colspan="3" align="center">
				www.shopfloor.com.br
			</td>
		</tr>
	</tfoot>
</table>