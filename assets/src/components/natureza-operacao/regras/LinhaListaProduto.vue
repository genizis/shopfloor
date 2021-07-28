<template>
	
	<div class="col-12 row">
		<div class="col-3">
			<select class="form-control " v-model="item.tipo">
				<option value="NCM">NCM</option>
				<option value="Produto">Produto</option>
				<option value="GrupoProdutos">Grupo de produtos</option>
			</select>
		</div>

		<div class="col-8" v-show="item.tipo == 'NCM'">
			<select  ref="buscaNCM" class="form-control" v-model="item.ncm">
				<option v-if="item.ncmText!=''" :value="item.ncm">{{item.ncmText}}</option>
			</select>
		</div>

		<div class="col-8" v-show="item.tipo == 'Produto'" >
			<select ref="buscaProduto" v-model="item.produto">
				<option v-if="item.produtoText!=''" :value="item.produto">{{item.produtoText}}</option>
			</select>
		</div>

		<div class="col-8" v-show="item.tipo == 'GrupoProdutos'">
			<select  ref="buscaGrupoProdutos" v-model="item.grupoProdutos">
				<option v-if="item.grupoProdutosText!=''" :value="item.grupoProdutos">{{item.grupoProdutosText}}</option>
			</select>
		</div>


		<i class="fas fa-times col-1 pointer" @click="removeProduto"></i>

	</div>

</template>

<script>
export default {
	props: ['input_name','item'],
	data() {
		return {
			mostrar:false,
			tipoProduto:'NCM',
			valorNCM:''
		};
	},
	mounted() {
		var $this = this;
		$(function() {

			$($this.$refs.buscaNCM).change(function(event) {
				$this.item.ncmText =  $this.textoSelect(this);
				$this.item.ncm = $(this).val();
				
			});

			$($this.$refs.buscaProduto).change(function(event) {
				$this.item.produtoText = $this.textoSelect(this);
				$this.item.produto = $(this).val();
			});

			$($this.$refs.buscaGrupoProdutos).change(function(event) {
				$this.item.grupoProdutosText = $this.textoSelect(this);
				$this.item.grupoProdutos = $(this).val();
			});


			$this.selectAjaxDinamico(
				$($this.$refs.buscaNCM),
				'Buscar NCM...',
				'/ajax/busca-ncm-filtro', 
				(item) => {
					return {
						text: item.desc_ncm,
						id: item.cod_ncm
					}
				});

			$this.selectAjaxDinamico(
				$($this.$refs.buscaProduto),
				'Buscar produto...',
				'/ajax/busca-produto-filtro', 
				(item) => {
					return {
						text: item.nome_produto,
						id: item.cod_produto
					}
				});

			$this.selectAjaxDinamico(
				$($this.$refs.buscaGrupoProdutos),
				'Buscar grupo de produto...',
				'/ajax/busca-tipo-produto-filtro', 
				(item) => {
					return {
						text: item.nome_tipo_produto,
						id: item.cod_tipo_produto
					}
				});

		});
	},
	methods: {
		removeProduto(){
			this.$emit('removeProduto',this.item.id);
		}
}//,    components: { Cabecalho,ListaContato,Conversa}
}
</script>