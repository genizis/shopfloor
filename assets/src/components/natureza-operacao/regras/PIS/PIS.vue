<template>
	<div class="row">
		<table class="table table-sm">
			<thead>
				<tr>
					<td>
						Destino(s)
					</td>
					<td>
						Produto(s)
					</td>
					<td>
						Alíq. %
					</td>
					<td>
						Base %
					</td>
					<td >
						Situação tributária
					</td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<Linha :formulariopai="formulariopai" :estados="estados" :situacaoTributaria="situacaoTributaria" v-for="regra in formularios" :key="regra.id" :idcont="regra.idcont" :item="regra" :form="regra.form" @removeRegra="removeRegra"></Linha>
			</tbody>
		</table>
		<div class="col-12 text-right">
			<a href="#" class="pointer" @click="addRegra">Adicionar Regra <i class="fas fa-plus"></i></a>
		</div>

		
	</div>
</template>

<script>

import Linha from './Linha';

export default {
	props: ['estados','formularios','formulariopai'],
	data() {
		return {
			mostrar:false,
			regras:[],
			regraCont:0,
			situacaoTributaria:[
			{id:'49', texto:'Outras Operações de Saída'},
			{id:'50', texto:'Operação com Direito a Crédito - Vinculada Exclusivamente a Receita Tributada no Mercado Interno'},
			{id:'51', texto:'Operação com Direito a Crédito – Vinculada Exclusivamente a Receita Não Tributada no Mercado Interno'},
			{id:'52', texto:'Operação com Direito a Crédito - Vinculada Exclusivamente a Receita de Exportação'},
			{id:'53', texto:'Operação com Direito a Crédito - Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno'},
			{id:'54', texto:'Operação com Direito a Crédito - Vinculada a Receitas Tributadas no Mercado Interno e de Exportação'},
			{id:'55', texto:'Operação com Direito a Crédito - Vinculada a Receitas Não-Tributadas no Mercado Interno e de Exportação'},
			{id:'56', texto:'Operação com Direito a Crédito - Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno, e de Exportação'},
			{id:'60', texto:'Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita Tributada no Mercado Interno'},
			{id:'61', texto:'Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita Não-Tributada no Mercado Interno'},
			{id:'62', texto:'Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita de Exportação'},
			{id:'63', texto:'Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno'},
			{id:'64', texto:'Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas no Mercado Interno e de Exportação'},
			{id:'65', texto:'Crédito Presumido - Operação de Aquisição Vinculada a Receitas Não-Tributadas no Mercado Interno e de Exportação'},
			{id:'66', texto:'Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno, e de Exportação'},
			{id:'67', texto:'Crédito Presumido - Outras Operações'},
			{id:'70', texto:'Operação de Aquisição sem Direito a Crédito'},
			{id:'71', texto:'Operação de Aquisição com Isenção'},
			{id:'72', texto:'Operação de Aquisição com Suspensão'},
			{id:'73', texto:'Operação de Aquisição a Alíquota Zero'},
			{id:'74', texto:'Operação de Aquisição sem Incidência da Contribuição'},
			{id:'75', texto:'Operação de Aquisição por Substituição Tributária'},
			{id:'98', texto:'Outras Operações de Entrada'},
			{id:'99', texto:'Outras operações'},
			{id:'01', texto:'Operação tributável (alíquota normal, cumulativo ou não)'},
			{id:'02', texto:'Operação tributável (alíquota diferenciada)'},
			{id:'03', texto:'Operação tributável (alíquota por unidade de produto)'},
			{id:'04', texto:'Operação tributável (tributação monofásica, alíquota zero)'},
			{id:'05', texto:'Operação tributável (Substituição Tributária)'},
			{id:'06', texto:'Operação tributável (alíquota zero)'},
			{id:'07', texto:'Operação isenta da contribuição'},
			{id:'08', texto:'Operação sem incidência da contribuição'},
			{id:'09', texto:'Operação com suspensão da contribuição'},
			]
		};
	},
	mounted() {
		
		if(this.formulariopai.cadastro){//Se cadastro 
			this.addRegra();
		}else{
			this.regraCont++;
		} 

		$(document).ready(function() {
			$('.collapse').collapse();
		});
	},
	methods: {
		addRegra(){
			this.regraCont++;

			this.formularios.push({
				cad:true, 
				id:'cad'+this.regraCont,
				idcont:this.regraCont,
				form:{
					cad:true, 
					estados:[],
					produtos:[]
				}
			});

		},
		removeRegra(key){
			let index = this.buscarIndexArray(this.formularios,'id',key);
			var item = this.formularios[index];

			var $this = this;
			if (item.cad) {
				$this.formularios.splice(index, 1);
			}else{
				var $this = this;
				alertify
				.confirm(
					"alerta",
					"Tem certeza que deseja excluir essa regra?",
					function () {
						axios
						.get("/ajax/excluir-regra-natureza-operacao?id="+item.form.id+"&&regra=PIS")
						.then((response) => {
							if (response.data.resultado) {
								alertify.success(response.data.msg);
								$this.formularios.splice(index, 1);
							} else {
								alertify.error(response.data.msg);
							}
						});
					},
					function () {}
					)
				.set("labels", { ok: "Sim", cancel: "Cancelar" })
				.set("closable", true)
				.set("basic", false)
				.closeOthers();
			}
		}

	},    components: { Linha }
}
</script>