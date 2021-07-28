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
						CFOP
					</td>
					<td >
						Situação tributária
					</td>
					<td></td>
				</tr>
			</thead>
			<tbody>
				<Linha :formulariopai="formulariopai" :estados="estados" :CodigoSituacaoOperacao="CodigoSituacaoOperacao" :situacaoTributaria="situacaoTributaria" v-for="regra in formularios" :key="regra.id" :idcont="regra.idcont" :item="regra" :form="regra.form" @removeRegra="removeRegra"></Linha>
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
			CodigoSituacaoOperacao:[
			{ id:101, texto: 'Tributada com permissão de crédito' },
			{ id:102, texto: 'Tributada sem permissão de crédito' },
			{ id:103, texto: 'Isenção do ICMS para faixa de receita bruta' },
			{ id:201, texto: 'Tributada com permissão de crédito e com cobrança do ICMS por ST' },
			{ id:202, texto: 'Tributada sem permissão de crédito e com cobrança do ICMS por ST' },
			{ id:203, texto: 'Isenção do ICMS para faixa de receita bruta e com cobrança do ICMS por ST' },
			{ id:300, texto: 'Imune' },
			{ id:400, texto: 'Não tributada' },
			{ id:500, texto: 'ICMS cobrado anteriormente por ST ou por antecipação' },
			{ id:900, texto: 'Outros' },
			],
			situacaoTributaria:[
			{id:10, texto:'Tributada e com cobrança do ICMS por substituição tributária'},
			{id:20, texto:'Com redução de base de cálculo'},
			{id:30, texto:'Isenta ou não tributada e com cobrança do ICMS por substituição tributária'},
			{id:40, texto:'Isenta'},
			{id:41, texto:'Não tributada'},
			{id:50, texto:'Suspensão'},
			{id:51, texto:'Diferimento'},
			{id:60, texto:'ICMS cobrado anteriormente por substituição tributária'},
			{id:70, texto:'Com redução de base de cálculo e cobrança do ICMS por substituição tributária'},
			{id:90, texto:'Outras'},
			{id:'00', texto:'Tributada integralmente '},
			]
		};
	},
	mounted() {
		//Se cadastro 
		this.addRegra();
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
					estados:[],
					produtos:[]
				}
			});

		},
		removeRegra(key){
			let index = this.buscarIndexArray(this.formularios,'id',key);
			this.formularios.splice(index, 1);
		}

	},    components: { Linha }
}
</script>