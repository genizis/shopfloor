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

		<div class="form-group col-md-3">
			<label for="IncluirFreteBase">
				Incluir frete na base do IPI 
			</label>
			<input type="checkbox" id="IncluirFreteBase" v-model="formulariopai.IncluirFreteBase"  name="IncluirFreteBase">
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
			{id:'01', texto:'Tributado'},
			{id:'02', texto:'Não tributado'}
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