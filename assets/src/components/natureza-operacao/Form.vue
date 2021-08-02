<template>
	<form method="POST" ref="formVinculo" @submit="cadastrarEditar" enctype="multipart/form-data">

		<Validacao :status="status"></Validacao>

		<div class="form-row">   
			<div class="form-group col-md-12">
				<label for="">Descrição <span class="text-danger">*</span></label>
				<input type="text" class="form-control" required="" name="descricao" maxlength="200" v-model="form.descricao">

			</div>

			<div class="form-group col-md-3">
				<label for="">Serie </label>
				<input type="text" class="form-control" maxlength="200" name="serie" v-model="form.serie">
			</div>


			<div class="form-group col-md-3">
				<label for="">Tipo </label>

				<select class="form-control " name="tipo" required="" v-model="form.tipo">
					<option value="" >Selecione...</option>
					<option :value="item.id" v-for="item in tipo">{{item.texto}}</option>
				</select>
			</div>

			<div class="form-group col-md-3">
				<label for="">Código de regime tributário </label>

				<select class="form-control " name="codigoRegimeTrib" required="" v-model="form.codigoRegimeTrib">
					<option value="" >Selecione...</option>
					<option :value="item.id" v-for="item in codigoRegimeTrib">{{item.texto}}</option>
				</select>

			</div>

			<div class="form-group col-md-3">
				<label for="">Indicador de presença </label>
				<select class="form-control " name="indicadorPresenca" required="" v-model="form.indicadorPresenca">
					<option value="" >Selecione...</option>
					<option :value="item.id" v-for="item in indicadorPresenca">{{item.texto}}</option>
				</select>

			</div>

			<div class="form-group col-md-3">
				<label for="faturada">Faturada</label>
				<input type="checkbox" id="faturada" value="1" v-model="form.faturada" name="faturada">

			</div>

			<div class="form-group col-md-3">
				<label for="consumidorFinal">
					Consumidor final
				</label>
				<input type="checkbox" id="consumidorFinal" value="1" v-model="form.consumidorFinal"  name="consumidorFinal">

			</div>


			<div class="form-group col-md-3">
				<label for="operacaoDevolucao">
					Operação de devolução
				</label>
				<input type="checkbox" id="operacaoDevolucao" value="1" v-model="form.operacaoDevolucao" name="operacaoDevolucao">

			</div>

			<div class="form-group col-md-3" v-if="form.tipo == 1">
				<label for="atualizarPrecoUltimaCompra">
					Atualizar preço de última compra do produto
				</label>
				<input type="checkbox" id="atualizarPrecoUltimaCompra" value="1" v-model="form.atualizarPrecoUltimaCompra" name="atualizarPrecoUltimaCompra">

			</div>


			<div class="col-12" >
				<h5>Regras de Tributação</h5>
			</div>

			<ul class="nav nav-tabs col-12" id="myTab" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="tabICMS-tab" data-toggle="tab" href="#tabICMS" role="tab" aria-controls="tabICMS" aria-selected="true">ICMS</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="tabIPI-tab" data-toggle="tab" href="#tabIPI" role="tab" aria-controls="tabIPI" aria-selected="false">IPI</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="tabPIS-tab" data-toggle="tab" href="#tabPIS" role="tab" aria-controls="tabPIS" aria-selected="false">PIS</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="tabCOFINS-tab" data-toggle="tab" href="#tabCOFINS" role="tab" aria-controls="tabCOFINS" aria-selected="false">COFINS</a>
				</li>
				<li class="nav-item" v-if="form.tipo == 1">
					<a class="nav-link" id="tabII-tab" data-toggle="tab" href="#tabII" role="tab" aria-controls="tabII" aria-selected="false">II</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="tabISSQN-tab" data-toggle="tab" href="#tabISSQN" role="tab" aria-controls="tabISSQN" aria-selected="false">ISSQN</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="outro-tab" data-toggle="tab" href="#outros" role="tab" aria-controls="outro" aria-selected="false">Outros</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="retencao-tab" data-toggle="tab" href="#retencao" role="tab" aria-controls="retencao" aria-selected="false">Retenções</a>
				</li>
			</ul>
			<div class="tab-content  col-12" id="myTabContent">

				<div class="tab-pane fade show active" id="tabICMS" role="tabpanel" aria-labelledby="home-tab">
					<ICMS :estados="estados" :formularios="regras.ICMS" :formulariopai="form"></ICMS>
				</div>
				<div class="tab-pane fade" id="tabIPI" role="tabpanel" aria-labelledby="home-tab">
					<IPI :estados="estados" :formularios="regras.IPI" :formulariopai="form"></IPI>
				</div>

				<div class="tab-pane fade" id="tabPIS" role="tabpanel" aria-labelledby="home-tab">
					<PIS :estados="estados" :formularios="regras.PIS" :formulariopai="form"></PIS>
				</div>

				<div class="tab-pane fade" id="tabCOFINS" role="tabpanel" aria-labelledby="home-tab">
					<COFINS :estados="estados" :formularios="regras.COFINS" :formulariopai="form"></COFINS>
				</div>

				<div class="tab-pane fade" id="tabII" role="tabpanel" aria-labelledby="home-tab">
					<II :estados="estados" :formularios="regras.II" :formulariopai="form"></II>
				</div>

				<div class="tab-pane fade" id="tabISSQN" role="tabpanel" aria-labelledby="home-tab">
					<ISSQN :estados="estados" :formularios="regras.ISSQN" :formulariopai="form"></ISSQN>
				</div>

				<div class="tab-pane fade " id="outros" role="tabpanel" aria-labelledby="profile-tab">
					<div class="row">

						<div class="form-group col-md-3">
							<label for="">Presumido no cálculo do PIS/COFINS </label>

							<select class="form-control " name="presumidoCalculoPisCofins" required="" v-model="form.presumidoCalculoPisCofins">
								<option :value="item.id" v-for="item in simnao">{{item.texto}}</option>
							</select>


						</div>


						<div class="form-group col-md-3">
							<label for="">Somar outras despesas </label>

							<select class="form-control " name="somarOutrasDespesas" required="" v-model="form.somarOutrasDespesas">
								<option :value="item.id" v-for="item in simnao">{{item.texto}}</option>
							</select>

						</div>

						<div class="col-12"> </div>
						<div class="form-group col-md-3">
							<label for=""> Alíquota funrural (%) </label>
							<input type="text" class="form-control" v-money="money" name="aliquotaFunrural" v-model="form.aliquotaFunrural">

						</div>

						<div class="form-group col-md-3">
							<label for=""> Compra de produtor rural</label>

							<select class="form-control " name="compraProdutorRural" required="" v-model="form.compraProdutorRural">
								<option :value="item.id" v-for="item in simnao">{{item.texto}}</option>
							</select>


						</div>
						<div class="col-12"> </div>

						<div class="form-group col-md-3">
							<label for=""> Descontar funrural do total faturado</label>
							
							<select class="form-control " name="descontarFunRuralTotal" required="" v-model="form.descontarFunRuralTotal">
								<option :value="item.id" v-for="item in simnao">{{item.texto}}</option>
							</select>

						</div>

						<div class="form-group col-md-3">
							<label for=""> Tipo % Aprox. Trib.</label>
							<select class="form-control " name="tipoAproxTrib" required="" v-model="form.tipoAproxTrib">
								<option :value="item.id" v-for="item in tipoAproxTrib">{{item.texto}}</option>
							</select>
						</div>

						<div class="form-group col-md-2" v-if="form.tipoAproxTrib == 'F'">
							<label for=""> Tributos (%) </label>
							<input type="text" class="form-control" v-money="money" name="tributos" v-model="form.tributos">

						</div>

						<div class="form-group col-md-3">
							<label for=""> Tipo desconto </label>

							<select class="form-control " name="tipoDesconto" required="" v-model="form.tipoDesconto">
								<option :value="item.id" v-for="item in tipoDesconto">{{item.texto}}</option>
							</select>
						</div>

					</div>

				</div>
				<div class="tab-pane fade" id="retencao" role="tabpanel" aria-labelledby="retencao-tab">
					<div class="row">
						<div class="form-group col-md-3">
							<label for=""> Possui retenção de impostos</label>

							<select class="form-control " name="RetencaoImpostos" required="" v-model="form.RetencaoImpostos">
								<option :value="item.id" v-for="item in simnao">{{item.texto}}</option>
							</select>


						</div>

						<div class="form-group col-md-2">
							<label for=""> Alíquota CSLL retido %</label>
							<input type="text" class="form-control" v-money="money" name="AliquotaCSLL" v-model="form.AliquotaCSLL">

						</div>

						<div class="form-group col-md-2">
							<label for=""> Alíquota IR retido %</label>
							<input type="text" class="form-control" v-money="money" name="AliquotaIRRetido" v-model="form.AliquotaIRRetido">

						</div>

					</div>
				</div>

			</div>

			
			<div class="col-12" >
				<h5>Informações adicionais</h5>
			</div>


			<div class="form-group col-md-12">
				<label for="">
					Informações complementares
				</label>
				<textarea class="form-control" v-model="form.InformacoesComplementares" name="InformacoesComplementares" cols="5" maxlength="2000"></textarea>

			</div>
			<div class="col-12 text-right">
				<a href="#" class="pointer" @click="abrirModalVariaveis">Ver variáveis que podem ser utilizadas nas informações complementares</a>
			</div>

			<div class="form-group col-md-12">
				<label for="">
					Informações adicionais de interesse do fisco
				</label>
				<textarea class="form-control" v-model="form.InformacoesAdicionais" name="InformacoesAdicionais" cols="5" maxlength="2000"></textarea>

			</div>



		</div>

		<div class="row">
			<div class="col-md-6">
			</div>
			<div class="col-md-6">
				<div class="row float-right">
					<div class="col-md-12">
						<button type="submit" class="btn btn-primary"
						name="Opcao" value="salvar"><i class="fas fa-save"></i> Salvar</button>
						<a href="/natureza-operacao"
						class="btn btn-secondary">Cancelar</a>
					</div>
				</div>
			</div>
		</div>

	</form>
</template>
<script>

import ICMS from './regras/ICMS/ICMS';
import IPI from './regras/IPI/IPI';
import PIS from './regras/PIS/PIS';
import COFINS from './regras/COFINS/COFINS';
import II from './regras/II/II';
import ISSQN from './regras/ISSQN/ISSQN';
import ListaVariaveis from './ListaVariaveis';

import Validacao from '../util/Validacao';

import {VMoney} from 'v-money';

export default {
	props: ['id'],
	data() {
		return {
			mostrar:false,
			estados:[],
			status:[],
			money: {
				decimal: '.',
				thousands: '',
				prefix: '',
				suffix: '',
				precision: 2,
				masked: false /* doesn't work with directive */
			},
			form:{
				serie:1,
				tipo:0,
				codigoRegimeTrib:0,
				indicadorPresenca:0,
				presumidoCalculoPisCofins:1,
				somarOutrasDespesas:0,
				aliquotaFunrural:0,
				compraProdutorRural:0,
				descontarFunRuralTotal:1,
				tipoAproxTrib:'T',
				tipoDesconto:1,
				RetencaoImpostos:0,
				AliquotaCSLL:0,
				AliquotaIRRetido:0,
				tributos:0,
				cadastro:!this.id
			},
			tipo:[
			{id:0, texto:"Saída"},
			{id:1, texto:"Entrada"}
			],
			codigoRegimeTrib:[
			{id:0, texto:'Simples nacional'},
			{id:1, texto:'Simples nacional - Excesso de sublimite de #receita bruta'},
			{id:2, texto:'Regime normal '}
			],
			indicadorPresenca:[
			{id:0, texto:'Não se aplica'}, 
			{id:1, texto:'Operação presencial'},
			{id:2, texto:'Operação não presencial, pela Internet'},
			{id:3, texto:'Operação não presencial, Teleatendimento'},
			{id:4, texto:'NFC-e em operação com entrega em domicílio'},
			{id:5, texto:'Operação presencial, fora do estabelecimento'},
			{id:9, texto:'Operação não presencial, Outros'}
			],
			simnao:[
			{id:1,texto:'Sim'},
			{id:0,texto:'Não'}
			],
			tipoAproxTrib:[
			{id:'T',texto:'Alíquota Tabela'},
			{id:'F',texto:'Alíquota fixa'},
			{id:'P',texto:'Alíquota no produto'},
			],
			tipoDesconto:[
			{id:1,texto:'Condicional'},
			{id:0,texto:'Incondicional'},
			],
			regras:{
				ICMS:[],
				IPI:[],
				PIS:[],
				COFINS:[],
				II:[],
				ISSQN:[]
			},
			objeto:[],
			regraCont:2
		};
	},
	mounted() {
		var $this = this;

		if (this.id) {
			axios.get('/natureza-operacao/ajax/'+this.id) //Buscar natureza
			.then((response) => {
				this.objeto = response.data;
				$.each(response.data, function( index, element) {
					if (element instanceof Object) {
						$this.addRegra(index,element)
					}else{
						$this.form[index] = element;
					}
					
				});

				//console.log($this.regras);
			});
		}

		axios.get('/ajax/busca-estado') //Buscar estados
		.then((response) => {
			this.estados = response.data;
		});
	},
	methods: {
		addRegra(index,listaCadastrada){
			var $this = this;
			$.each(listaCadastrada, function( indexli, lista) {
				//lista['estados'] = [];
				//lista['produtos'] = [];
				$this.regraCont++;
				$this.regras[index].push({
					cad:false, 
					id:'cad'+$this.regraCont,
					idcont:$this.regraCont,
					form:lista
				});
			});

		},
		abrirModalVariaveis(){
			var $this = this;
			this.$modal.show(
				ListaVariaveis,
				{
					titulo: "Variáveis"
				},
				{
					height: "auto",
					width: "50%",
					classes: "modalDinamico modalDinamico-open",
				}
				);
		},
		cadastrarEditar(e){
			e.preventDefault();
			var $this = this;
			var alerta = alertify.alert('<div class="text-center">Enviando informações... <br>'
				+'<i class="fa fa-refresh fa-spin fa-3x fa-fw"></i><br> Aguarde... </div>').set('closable', false).set('basic', true);
			var $this = this;
			let formData = new FormData(this.$refs.formVinculo);
			if($this.id) formData.append('id', $this.id);

			//Regras
				$.each(this.regras, function( indexList, listaregras) {//Lista regras ICMS

					$.each(listaregras, function( index, regra) {
						var nome = indexList+'['+index+']';
						//console.log(nome);
						$this.getFormData(formData, regra.form,nome);
					});
				});

				var url = '/natureza-operacao/nova';

				axios.post(url
					,formData
					,{
						headers: {
							'Content-Type': 'multipart/form-data'
						}
					}
					)
				.then((response) => {
					//console.log(response.data);
					if (response.data.resultado) {
						Vue.set(this.status,'sucesso', response.data.msg);	
					//$this.funcaocallback();
					window.location = '/natureza-operacao/editar/'+response.data.id;
				}else{
					Vue.set(this.status,'erro', response.data.msg);
				}
				alertify.closeAll();
			}).catch((error)=>this.catchErro(error,this.status));

			}
		},    components: { ICMS, IPI, PIS, COFINS, II, ISSQN, Validacao }
		, directives: {money: VMoney}
	}
	</script>