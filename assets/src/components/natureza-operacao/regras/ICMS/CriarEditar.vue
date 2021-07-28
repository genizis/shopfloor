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

			<div class="col-12" v-if="formulariopai.codigoRegimeTrib == 0">
				<label for="CodigoSituacaoOperacao">
					Código de situação da operação - Simples nacional (CSOSN):  
				</label>

				<select class="form-control" required="" id="CodigoSituacaoOperacao" v-model="form.CodigoSituacaoOperacao">
					<option value="" >Selecione...</option>
					<option v-for="item in CodigoSituacaoOperacao" :value="item.id">{{item.id}} - {{item.texto}}</option>
				</select>

			</div>

			<div class="col-12" v-if="mulSe(formulariopai.codigoRegimeTrib,[1,2])">
				<label>
					Situação tributária
				</label>

				<select class="form-control" v-model="form.situacaoTributaria">
					<option v-for="item in situacaoTributaria" :value="item.id">{{item.id}} - {{item.texto}}</option>
				</select>

			</div>

			<div class="col-2" >
				<label>CFOP %</label>
				<input type="number" class="form-control" v-model="form.CFOP">
			</div>

			<div class="col-2">
				<label>FCP %</label>
				<input type="text" class="form-control" v-model="form.FCP" v-money="money">
			</div>

			<div class="col-3">
				<label for="ModalidadeBC">Modalidade BC</label>

				<select class="form-control " id="ModalidadeBC" name="ModalidadeBC" required="" v-model="form.ModalidadeBC">
					<option :value="item.id" v-for="item in ModalidadeBC">{{item.texto}}</option>
				</select>

			</div>

			<div class="col-2" v-if="form.ModalidadeBC == 1">
				<label>Valor Pauta</label>
				<input type="text" class="form-control" v-model="form.ValorPauta" v-money="money">
			</div>

			<div class="col-4" v-if="formulariopai.codigoRegimeTrib == 0 && 
			mulSe(form.CodigoSituacaoOperacao,[101,201,900])">
			<label>Alíquota aplicável de crédito</label>
			<input type="text" class="form-control" v-model="form.AliquotaAplicavel" v-money="money">
		</div>

		<div class="col-4" v-if="formulariopai.codigoRegimeTrib == 0 && 
		mulSe(form.CodigoSituacaoOperacao,[201,202,203,900])
		">
		<label>Alíquota ICMS (%)</label>
		<input type="text" class="form-control" v-model="form.AliquotaICMS" v-money="money">
	</div>

	<div class="col-4" v-if="formulariopai.codigoRegimeTrib == 0 && mulSe(form.CodigoSituacaoOperacao,[201,202,203,900])
	">
	<label>Base ICMS %</label>
	<input type="text" class="form-control" v-model="form.BaseICMS" v-money="money">
</div>

<div class="col-4" v-if="mulSe(formulariopai.codigoRegimeTrib,[1,2])">
	<label>Aliquota %</label>
	<input type="text" class="form-control" v-model="form.Aliquota" v-money="money">
</div>

<div class="col-4" v-if="mulSe(formulariopai.codigoRegimeTrib,[1,2])">
	<label>Presumido %</label>
	<input type="text" class="form-control" v-model="form.Presumido" v-money="money">
</div>

<div class="col-4" v-if="mulSe(formulariopai.codigoRegimeTrib,[1,2])">
	<label>Código do benefício fiscal na UF</label>
	<input type="number" class="form-control" v-model="form.CodigoBeneficioFiscal">
</div>

<div class="col-2" v-if="(mulSe(formulariopai.codigoRegimeTrib,[1,2])) && 
mulSe(form.situacaoTributaria,[20,51,60,70,90])">
<label>Base %</label>
<input type="text" class="form-control" v-money="money" v-model="form.Base">
</div>

<div class="col-4" v-if="(formulariopai.codigoRegimeTrib == 0 && 
form.CodigoSituacaoOperacao == 900) || (mulSe(formulariopai.codigoRegimeTrib,[1,2])) && 
mulSe(form.situacaoTributaria,[51,70,90])
">
<label>Diferimento %</label>
<input type="text" class="form-control" v-model="form.Diferimento" v-money="money">
</div>

<div class="col-3" v-if="
mulSe(formulariopai.codigoRegimeTrib,[1,2]) && 
mulSe(form.situacaoTributaria,[20,30,40,41,50,51,60,70,90])
">
<label>Motivo Desoneração</label>

<select class="form-control" v-model="form.MotivoDesoneracao">
	<option v-for="item in MotivoDesoneracao" :value="item.id">{{item.id}} - {{item.texto}}</option>
</select>

</div>

<div class="col-12 text-right">
	<br>
</div>


</div>
<div class="col-11 caixa row" v-if="(formulariopai.codigoRegimeTrib == 0 && 
mulSe(form.CodigoSituacaoOperacao,[201,202,203,500,900]) ) 

|| (mulSe(formulariopai.codigoRegimeTrib,[1,2])) 
&& 
mulSe(form.situacaoTributaria,[10,30,60,70,90])">
<label class="fs-15 col-12">Situação tributaria</label>

<div class="col-3">
	<label>Modalidade BC</label>

	<select class="form-control" v-model="form.stribModalidadeBC" >
		<option v-for="item in stribModalidadeBC" :value="item.id">{{item.texto}}</option>
	</select>
</div>

<div class="col-2" v-if="mulSe(form.stribModalidadeBC,[1,5])">
	<label>Valor Pauta</label>
	<input type="number" class="form-control" v-model="form.stribValorPauta">
</div>


<div class="col-4">
	<label>Aliquota ICMS %</label>
	<input type="text" class="form-control" v-model="form.stribAliquotaICMS" v-money="money">
</div>

<div class="col-3" v-if="mulSe(formulariopai.codigoRegimeTrib,[0])">
	<label>Base de Cálculo ICMS %</label>
	<input type="text" class="form-control" v-model="form.stribBaseCalculoICMS" v-money="money">
</div>

<div class="col-2" v-if="mulSe(formulariopai.codigoRegimeTrib,[1,2])">
	<label>Base</label>
	<input type="text" class="form-control" v-model="form.stribBase" v-money="money">
</div>

<div class="col-2" v-if="mulSe(formulariopai.codigoRegimeTrib,[1,2])">
	<label>MVA</label>
	<input type="text" class="form-control" v-model="form.stribMVA" v-money="money">
</div>

<div class="col-2" v-if="mulSe(formulariopai.codigoRegimeTrib,[1,2])">
	<label>PIS</label>
	<input type="text" class="form-control" v-model="form.stribPIS" v-money="money">
</div>

<div class="col-2" v-if="mulSe(formulariopai.codigoRegimeTrib,[1,2])">
	<label>COFINS</label>
	<input type="text" class="form-control" v-model="form.stribCOFINS" v-money="money">
</div>

<div class="col-3" v-if="mulSe(formulariopai.codigoRegimeTrib,[0])">
	<label>Margem Adic.ICMS %</label>
	<input type="text" class="form-control" v-model="form.stribMargemAdicionalICMS" v-money="money">
</div>

</div>

<div class="col-11 caixa row" v-if="(formulariopai.codigoRegimeTrib == 0 && 
mulSe(form.CodigoSituacaoOperacao,[500]) ) 
|| (mulSe(formulariopai.codigoRegimeTrib,[1,2])) 
&& 
mulSe(form.situacaoTributaria,[60])">
<label class="fs-15 col-12">Substituição tributária retida anteriormente</label>

<div class="col-3" v-if="mulSe(formulariopai.codigoRegimeTrib,[0])">
	<label>Base do ICMS Retido %</label>
	<input type="text" class="form-control" v-model="form.stBaseICMS" v-money="money">
</div>

<div class="col-3">
	<label>Alíquota ICMS Retido %</label>
	<input type="text" class="form-control" v-model="form.stAliquotaICMS" v-money="money">
</div>

</div>

<div class="col-11 caixa row" v-if="formulariopai.consumidorFinal">
	<label class="fs-15 col-12">ICMS partilha</label>

	<div class="col-3">
		<label>Tipo de tributação</label>
		<select class="form-control" v-model="form.paTipoTributacao" >
			<option v-for="item in paTipoTributacao" :value="item.id">{{item.texto}}</option>
		</select>
	</div>

	<div class="col-3" v-if="form.paTipoTributacao == 'N'">
		<label>Base de cálculo (%)</label>
		<input type="text" class="form-control" v-model="form.paBaseCalculo" v-money="money">
	</div>

	<div class="col-4" v-if="form.paTipoTributacao == 'N'">
		<label>Alíquota Interna UF de destino (%)</label>
		<input type="text" class="form-control" v-model="form.paAliquotaInternaUFDestino" v-money="money">
	</div>

	<div class="col-3" v-if="form.paTipoTributacao == 'N'">
		<label>Alíquota do FCP (%)
		</label>
		<input type="text" class="form-control" v-model="form.paAliquota
		" v-money="money">
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
</template>

<script>
import {VMoney} from 'v-money';
import LinhaListaProduto from '../LinhaListaProduto';
import LinhaListaEstado from '../LinhaListaEstado';
export default {
	props: ['form','titulo','estados','situacaoTributaria','CodigoSituacaoOperacao','formulariopai'],
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
			ModalidadeBC:[
			{id:0, texto: 'Margem Valor Agregado (%)'},
			{id:1, texto: 'Pauta (valor)'},
			{id:2, texto: 'Preço Tabelado Máx. (valor)'},
			{id:3, texto: 'Valor da operação'},
			],
			MotivoDesoneracao:[
			{id:0 , texto:'Nenhum'},
			{id:1 , texto:'Taxi'},
			{id:3 , texto:'Produtor Agropecuário'},
			{id:4 , texto:'Frotista/Locadora'},
			{id:5 , texto:'Diplomático/Consular'},
			{id:6 , texto:'Utilitários e Motocicletas da Amazônia Ocidental e Áreas de Livre Comércio (Resolução 714/88 e 790/94 – CONTRAN e suas alterações)'},
			{id:7 , texto:'SUFRAMA'},
			{id:8 , texto:'Venda a Órgão Público'},
			{id:9 , texto:'Outros'},
			{id:10, texto:'Deficiente Condutor'},
			{id:11, texto:'Deficiente Não Condutor'},
			{id:90, texto:'Solicitado pelo Fisco'},
			],
			stribModalidadeBC:[
			{id:0, texto:'Preço tabelado ou máximo sugerido'},
			{id:1, texto:'Lista Negativa (valor)'},
			{id:2, texto:'Lista Positiva (valor)'},
			{id:3, texto:'Lista Neutra (valor)'},
			{id:4, texto:'Margem Valor Agregado (%)'},
			{id:5, texto:'Pauta (valor)'},
			{id:6, texto:'Valor da Operação'},
			],
			paTipoTributacao:[
			{id:'N', texto: 'Normal'},
			{id:'I', texto: 'Isento'},
			],
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
			this.form.produtos.splice(index, 1);
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