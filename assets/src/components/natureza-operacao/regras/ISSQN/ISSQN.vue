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
			{id:0, texto:'Tributado'},
			{id:1, texto:'Isento'},
			{id:2, texto:'Outra situação'},
			],
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
						.get("/ajax/excluir-regra-natureza-operacao?id="+item.form.id+"&&regra=ISSQN")
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