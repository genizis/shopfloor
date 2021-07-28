<template>
<div class="modal-content"><!-- BODY -->

		<div class="modal-header"><!-- HEADER -->
			<h5 class="modal-title">{{ titulo }}</h5>
			<button type="button" class="close" aria-label="Close" 
			v-on:click="$emit('close')">
			<span aria-hidden="true">×</span>
		</button>
	</div><!-- FIM HEADER -->

	<div class=" modal-body" ref="formCadastro" id="formRegra"><!-- BODY -->
<br>
		<h5 class="text-center">
			Impostos
		</h5>
		<ul class="list-group list-group-flush">
			<li class="list-group-item"> [VALOR_BASE_ICMS] - Valor total da base do ICMS</li>

			<li class="list-group-item"> [VALOR_ICMS] - Valor total do ICMS</li>

			<li class="list-group-item"> [VALOR_BASE_DIFERIMENTO] - Valor total da base do diferimento do ICMS</li>

			<li class="list-group-item"> [VALOR_DIFERIMENTO] - Valor total do diferimento do ICMS</li>

			<li class="list-group-item"> [ICMS_PRESUMIDO] - Valor total do ICMS presumido</li>

			<li class="list-group-item"> [VALOR_CREDITO_ICMS] - Valor total do crédito do ICMS (somente contribuintes do SIMPLES)</li>

			<li class="list-group-item"> [ALIQUOTA_CREDITO_ICMS] - Alíquota de crédito do ICMS (somente contribuintes do SIMPLES)</li>

			<li class="list-group-item"> [VALOR_ICMS_ST] - Valor total do ICMS ST</li>

			<li class="list-group-item"> [VALOR_ICMS_RETIDO] - Valor total do ICMS retido</li>

			<li class="list-group-item"> [ALIQUOTA_ICMS_RETIDO] - Alíquota do ICMS retido</li>

			<li class="list-group-item"> [VALOR_BASE_ICMS_RETENCAO] - Valor total da base do ICMS retido</li>

			<li class="list-group-item"> [APROX_TRIB] - Informações dos tributos aproximados conforme Lei da transparência</li>

			<li class="list-group-item"> [VALOR_PIS] - Valor total do PIS</li>

			<li class="list-group-item"> [VALOR_COFINS] - Valor total do COFINS</li>

			<li class="list-group-item"> [VALOR_FCP] - Valor total do FCP</li>

			<li class="list-group-item"> [VALOR_RET_IR] - Valor do IR retido</li>

			<li class="list-group-item"> [VALOR_RET_CSLL] - Valor do CSLL retido</li>

			<li class="list-group-item"> [VALOR_RET_PIS] - Valor do PIS retido</li>

			<li class="list-group-item"> [VALOR_RET_COFINS] - Valor do COFINS retido</li>

			<li class="list-group-item"> [VALOR_RET_ISS] - Valor do ISS retido</li>
		</ul>
		<br>
		<h5 class="text-center">
			Outras informações
		</h5>
		<ul class="list-group list-group-flush">
			<li class="list-group-item"> [PESO_LIQUIDO] - Valor total do peso líquido dos produtos</li>

			<li class="list-group-item"> [PESO_BRUTO] - Valor total do peso bruto dos produtos</li>

			<li class="list-group-item"> [NUMERO_CUPOM] - Número do cupom fiscal caso tenha sido gerado em ECF</li>

			<li class="list-group-item"> [NUMERO_PEDIDO] - Números dos pedidos de venda que estão vinculados à nota</li>

			<li class="list-group-item"> [NOME_FANTASIA] - Nome fantasia do destinatário</li>

			<li class="list-group-item"> [PEDIDO_COMPRA] - Número(s) do(s) pedido(s) de compra informado(s) na tag xPed</li>

			<li class="list-group-item"> [NOME_VENDEDOR] - Nome do vendedor associado a venda</li>

			<li class="list-group-item"> [NUMERO_DI] - Número da Declaração de Importação (DI)</li>

			<li class="list-group-item"> [DATA_REGISTRO_DI] - Data de registro da DI</li>

			<li class="list-group-item"> [LOCAL_DESEMBARACO] - Local de desembaraço</li>
		</ul>

</div><!-- FIM BODY -->


</div><!-- FIM CONTENT -->
</template>

<script>
// <ContactsList />
// import ContactsList from './ContactsList';
export default {
	props: ['titulo'],
	data() {
		return {
			
		};
	},
	mounted() {
		
	},
	methods: {
}//,    components: { Cabecalho,ListaContato,Conversa}
}
</script>