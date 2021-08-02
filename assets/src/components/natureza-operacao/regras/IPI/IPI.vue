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

		<div class="form-group col-md-3">
			<label for="IncluirFreteBase">
				Incluir frete na base do IPI 
			</label>
			<input type="checkbox" id="IncluirFreteBase" v-model="formulariopai.IncluirFreteBase" value="1" name="IncluirFreteBase">
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
			{id:'', texto:'Sem IPI', codEnquadramento:[999,601,602,603,604,605,606,607,608]},
			{id:'50', texto:'Saída tributada', codEnquadramento:[999,601,602,603,604,605,606,607,608]},
			{id:'51', texto:'Saída tributada com alíquota zero', codEnquadramento:[ 999,601,602,603,604,605,606,607,608] },
			{id:'52', texto:'Saída isenta', codEnquadramento:[999,301,302,303,304,305,306,307,308,309,310,311,312,313,314,315,316,317,318,319,320,321,322,323,324,325,326,327,328,329,330,331,332,333,334,335,336,337,338,339,340,341,342,343,344,345,346,347,348,349,350,351] },
			{id:'53', texto:'Saída não-tributada', codEnquadramento: [99,601,602,603,604,605,606,607,608]},
			{id:'54', texto:'Saída imune', codEnquadramento:[999,1,2,3,4,5,6,7] },
			{id:'55', texto:'Saída com suspensão', codEnquadramento:[999,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165] },
			{id:'99', texto:'Outras saídas', codEnquadramento:[999,601,602,603,604,605,606,607,608] },
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
						.get("/ajax/excluir-regra-natureza-operacao?id="+item.form.id+"&&regra=IPI")
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