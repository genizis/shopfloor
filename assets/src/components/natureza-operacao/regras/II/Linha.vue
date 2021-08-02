<template>
	<tr >
		<td @click="abrirModal()" class="pointer">
			<a href="#" v-if="form.estados.length == 0 ">Qualquer estado</a> <a href="#" v-else> 
				<small v-for="(item, keyest) in form.estados">{{keyest!=0?', ':' '}}{{item}}</small>
			</a>

		</td>
		<td @click="abrirModal()" class="pointer">
			<label class="fs-15"> <a href="#" v-if="form.produtos.length == 0 ">Qualquer</a> <a href="#" v-else> Alguns </a></label>
		</td>
		<td @click="abrirModal()" class="pointer"><input type="text" class="form-control" readonly="" :value="form.Aliquota"></td>
		<td @click="abrirModal()" class="pointer">
			<input type="text" class="form-control" readonly="" :value="valorCodigo(form.situacaoTributaria,situacaoTributaria)">
		</td>
		<td>
			<i class="fas fa-trash pointer red" @click="removeRegra"> </i>
		</td>
	</tr>
</template>

<script>
import CriarEditar from './CriarEditar';

export default {
	props: ['estados','situacaoTributaria','form','item','formulariopai','idcont'],
	data() {
		return {
			mostrar:false
		};
	},
	mounted() {
		//Se cadastro
		if(this.idcont!=1  && this.form.cad==true)	this.abrirModal();

		if(this.form.cad){

			Vue.set(this.form,'situacaoTributaria', 2);
		}
	},
	methods: {
		valorCodigo(cod, lista){
			let index = this.buscarIndexArray(lista,'id',cod);
			if(index == -1) return '';
			return cod+' - '+lista[index].texto;
		},
		abrirModal() {
			var $this = this;
			this.$modal.show(
				CriarEditar,
				{
					titulo: "II",
					estados:$this.estados,
					form: $this.form,
					situacaoTributaria:$this.situacaoTributaria,
					formulariopai:$this.formulariopai
				},
				{
					height: "auto",
					width: "50%",
					classes: "modalDinamico modalDinamico-open",
				}
				);
		},
		removeRegra(){
			this.$emit('removeRegra',this.item.id);
		}
	}
}
</script>