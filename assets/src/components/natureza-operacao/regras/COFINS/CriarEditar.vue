<template>
	<div class="modal-content"><!-- BODY -->

		<div class="modal-header"><!-- HEADER -->
			<h5 class="modal-title">{{ titulo }}</h5>
			<button type="button" class="close" aria-label="Close" 
			v-on:click="$emit('close')">
			<span aria-hidden="true">×</span>
		</button>
	</div><!-- FIM HEADER -->

	<div class="row modal-body" ref="formCadastro" id="formRegra"><!-- BODY -->

		<div class="col-11 caixa row">
			<div class="" id="estadoHeader" data-toggle="collapse" data-target="#estadoBody">
				<label class="fs-15">Quando for para <a href="#" v-if="form.estados.length == 0 ">Qualquer estado</a> <a href="#" v-else> 
					<small v-for="(item, keyest) in form.estados">{{keyest!=0?', ':' '}}{{item}}</small>
				</a></label>
			</div>

			<div id="estadoBody" class="collapse" aria-labelledby="estadoHeader" >
				<div class="card-body">
					<LinhaListaEstado :estados="estados" :form="form"></LinhaListaEstado>
				</div>
			</div>
		</div>

		<div class=" col-11 caixa row">

			<div class="" id="produtoHeader" data-toggle="collapse" data-target="#produtoBody" >
				<label class="fs-15">Quando for <a href="#" v-if="form.produtos.length == 0 ">Qualquer produto</a> <a href="#" v-else> Alguns produtos </a></label>
			</div>


			<div id="produtoBody" class="collapse col-12" aria-labelledby="produtoHeader" >
				<div class="card-body">
					<div class="row listaProdutos">
						<LinhaListaProduto v-for="produto in form.produtos" :key="produto.id" :item="produto"  @removeProduto="removeProduto"></LinhaListaProduto>
					</div>
					<a href="#" class="pointer" @click="addProduto"><i class="fas fa-plus"></i> Adicionar outro item</a>
				</div>
			</div>
		</div>

		<div class="col-11 caixa row">
			<label class="fs-15">Usar a seguinte regra de tributação</label>


			<div class="col-12" >
				<label>
					Situação tributária
				</label>

				<select class="form-control" v-model="form.situacaoTributaria">
					<option v-for="item in situacaoTributaria" :value="item.id">{{item.id}} - {{item.texto}}</option>
				</select>

			</div>

			<div class="col-4" v-if="!mulSe(form.situacaoTributaria,['04','05','06','07','08','09'])">
				<label>Aliquota %</label>
				<input type="text" class="form-control" v-model="form.Aliquota" v-money="money">
			</div>

			<div class="col-2" v-if="!mulSe(form.situacaoTributaria,['03','04','05','06','07','08','09'])">
				<label>Base %</label>
				<input type="text" class="form-control" v-money="money" v-model="form.Base">
			</div>


			<div class="col-12 text-right">
				<br>
			</div>

		</div>


		<div class="col-11 caixa row" >
			<div class="col-12">
				<label>Informações complementares</label>
				<input type="text" class="form-control" v-model="form.InformacoesComplementares" >
			</div>


			<div class="col-12">
				<label>Informações adicionais de interesse do fisco</label>
				<input type="text" class="form-control" v-model="form.InformacoesAdicionais" >
				<br>
			</div>

		</div>


	</div><!-- FIM BODY -->


	<div class="modal-footer col-12 text-right"> <!-- FOOTER -->
		<button type="button" class="btn btn-primary" 
		name="Opcao" value="salvar" @click="validarForm()"><i class="fas fa-save"></i> Salvar</button>
		<a href="#" v-on:click="$emit('close')" class="btn btn-secondary">Cancelar</a>
	</div><!-- FIM FOOTER -->

</div><!-- FIM CONTENT -->
</div>
</template>

<script>
import {VMoney} from 'v-money';
import LinhaListaProduto from '../LinhaListaProduto';
import LinhaListaEstado from '../LinhaListaEstado';
export default {
	props: ['form','titulo','estados','situacaoTributaria','formulariopai'],
	data() {
		return {
			money: {
				decimal: '.',
				thousands: '',
				prefix: '',
				suffix: '',
				precision: 2,
				masked: false /* doesn't work with directive */
			},
			mostrar:false,
			produtoCont:0
		};
	},
	mounted() {
		var $this = this;
		this.produtoCont = this.form.produtos.length;

		
		
	},
	methods: {
		addProduto(){
			this.produtoCont++;
			this.form.produtos.push({cad:true, id:'cad'+this.produtoCont, tipo:'NCM'});
		},
		removeProduto(key){
			let index = this.buscarIndexArray(this.form.produtos,'id',key);
			var produto = this.form.produtos[index];

			if (produto.cad) {
				this.form.produtos.splice(index, 1);
			}else{
				var $this = this;
				alertify
				.confirm(
					"alerta",
					"Tem certeza que deseja excluir esse parametro?",
					function () {
						axios
						.get("/ajax/excluir-vinculo-produto-natureza-operacao?id="+produto.id+"&&regra=COFINS")
						.then((response) => {
							if (response.data.resultado) {
								alertify.success(response.data.msg);
								$this.form.produtos.splice(index, 1);
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
		},
		validarForm(){
			var resultado = this.validarFormulario('#formRegra');

			if(resultado) this.$emit('close');

			//formCadastro
		},
	},    components: { LinhaListaProduto, LinhaListaEstado }
	, directives: {money: VMoney}
}
</script>