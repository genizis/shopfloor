<template>
  <div class="row mt-2">
    <div
      class="form-group col-md-12"
      v-if="mulSe(form.codigoRegimeTributario, [2, 3])"
    >
      <label for=""> Situação tributária do ICMS </label>
      <select
        class="form-control"
        v-model="item.icms_situacaoTributaria"
        placeholder="Selecione..."
      >
        <option value="">Selecione...</option>
        <option
          :value="itemS.id"
          :key="key"
          v-for="(itemS, key) in situacaoTributaria"
        >
          {{ (itemS.id != "" ? itemS.id + " - " : "") + itemS.texto }}
        </option>
      </select>
    </div>

    <div
      class="form-group col-md-12"
      v-if="mulSe(form.codigoRegimeTributario, [1])"
    >
      <label for="">
        Código de Situação da Operação – Simples Nacional (CSOSN)
      </label>
      <select
        class="form-control"
        v-model="item.icms_codigoSituacao"
        placeholder="Selecione..."
      >
        <option value="">Selecione...</option>
        <option
          :value="itemS.id"
          :key="key"
          v-for="(itemS, key) in codigoSituacao"
        >
          {{ (itemS.id != "" ? itemS.id + " - " : "") + itemS.texto }}
        </option>
      </select>
    </div>

    <!--INICIO TABS -->
    <ul class="nav nav-tabs col-12" role="tablist" id="myTabICMS">
      <li class="nav-item">
        <a
          class="nav-link active"
          id="tabItemGeral-tab"
          data-toggle="tab"
          href="#tabItemGeral"
          >Geral</a
        >
      </li>

      <li class="nav-item" v-show="mulSe(item.icms_situacaoTributaria, [10, 30,60,70, 90]) || mulSe(item.icms_codigoSituacao, [201, 203, 500, 900])">
        <a
          class="nav-link"
          id="tabItemST-tab"
          data-toggle="tab"
          href="#tabItemST"
          >Substituição tributaria</a
        >
      </li>
      <li class="nav-item" v-show="mulSe(item.icms_situacaoTributaria, [60]) || mulSe(item.icms_codigoSituacao, [500])">
        <a
          class="nav-link"
          id="tabItemSTR-tab"
          data-toggle="tab"
          href="#tabItemSTR"
          >Substituição tributaria - Retenção</a
        >
      </li>
    </ul>
    <div class="tab-content col-12" id="myTabICMSContent">
      <div class="tab-pane fade show active" id="tabItemGeral">
        <div class="row">
          <div class="form-group col-md-4">
            <label for=""> Origem </label>
            <select
              class="form-control"
              v-model="item.icms_origem"
              placeholder="Selecione..."
            >
              <option
                :value="itemS.id"
                :key="key"
                v-for="(itemS, key) in origem"
              >
                {{ itemS.id }} - {{ itemS.texto }}
              </option>
            </select>
          </div>

          <div class="form-group col-md-5" v-if="mulSe(item.icms_situacaoTributaria, [10,20,30]) || mulSe(item.icms_codigoSituacao, [201, 202, 203, 900])">
            <label for=""> Modalidade BC ICMS </label>
            <select
              class="form-control"
              v-model="item.icms_modalidadeBC"
              placeholder="Selecione..."
            >
              <option
                :value="itemS.id"
                :key="key"
                v-for="(itemS, key) in modalidadeBC"
              >
                {{ itemS.id }} - {{ itemS.texto }}
              </option>
            </select>
 
          </div>

          <div class="form-group col-md-4" v-if=" mulSe(item.icms_codigoSituacao, [101, 201, 900])" >
            <label for="">% Aplic. Créd </label>
            <input
              type="number"
              class="form-control"
              v-model="item.icms_aplicCred"
            />

          </div>

          <div class="form-group col-md-4"  v-if="mulSe(item.icms_codigoSituacao, [101, 201, 900])">
            <label for="">Val. Aplic. Créd.</label>
            <input
              type="number"
              class="form-control"
              v-model="item.icms_valorAplicCred"
            />
       
          </div>

          <div class="form-group col-md-4" v-if="item.icms_modalidadeBC == 1 ">
            <label for="">Valor da pauta por un </label>
            <input
              type="text"
              class="form-control"
              v-money="money"
              v-model="item.icms_valorPauta"
            />
          
          </div>

          <div class="form-group col-md-4" v-if="mulSe(item.icms_situacaoTributaria, [20, 41, 50, 51,60,70, 90]) || mulSe(item.icms_codigoSituacao, [201, 202, 900])">
            <label for="">Base ICMS </label>
            <input
              type="text"
              class="form-control"
              v-money="money"
              v-model="item.icms_baseICMS"
            />
            
          </div>

          <div class="form-group col-md-4" v-if="mulSe(item.icms_situacaoTributaria, [20, 41, 50, 51,60,70, 90]) || mulSe(item.icms_codigoSituacao, [201, 202, 900])">
            <label for="">Valor Base ICMS </label>
            <input
              type="text"
              class="form-control"
              v-money="money"
              v-model="item.icms_valorBaseICMS"
            />
         
          </div>
          <div class="form-group col-md-4"  v-if="mulSe(item.icms_situacaoTributaria, [51, 90]) || mulSe(item.icms_codigoSituacao, [900])">
            <label for="">% Dif ICMS </label>
            <input
              type="text"
              class="form-control"
              v-money="money"
              v-model="item.icms_difICMS"
            />

          </div>

          <div class="form-group col-md-4" v-if="item.icms_situacaoTributaria!=40 && !mulSe(form.codigoRegimeTributario, [1])">
            <label for="">Presumido </label>
            <input
              type="text"
              class="form-control"
              v-money="money"
              v-model="item.icms_presumido"
            />
           
          </div>

          <div class="form-group col-md-4" v-if="mulSe(item.icms_situacaoTributaria, [10,20,30]) || mulSe(item.icms_codigoSituacao, [201, 202, 203, 900])">
            <label for="">ICMS</label>
            <input
              type="text"
              class="form-control"
              v-money="money"
              v-model="item.icms_ICMS"
            />
         
          </div>

          <div class="form-group col-md-4" v-if="mulSe(item.icms_situacaoTributaria, [10,20,30]) || mulSe(item.icms_codigoSituacao, [201, 202, 203, 900])">
            <label for="">Valor ICMS </label>
            <input
              type="text"
              class="form-control"
              v-money="money"
              readonly
              v-model="item.icms_valorICMS"
            />
       
          </div>

          <div class="form-group col-md-4" v-if="mulSe(item.icms_situacaoTributaria, [10,20,30])">
            <label for="">Posição de Alíquota </label>
            <input
              type="number"
              class="form-control"
              v-model="item.icms_posicaoAliquota"
            />
  
          </div>

          <div class="form-group col-md-4" v-if="item.icms_situacaoTributaria!=40">
            <label for="">FCP </label>
            <input
              type="text"
              class="form-control"
              v-money="money"
              v-model="item.icms_FCP"
            />
       
          </div>

          <div class="form-group col-md-4" v-if="item.icms_situacaoTributaria!=40">
            <label for="">Valor FCP </label>
            <input
              type="text"
              class="form-control"
              v-money="money"
              readonly
              v-model="item.icms_valorFCP"
            />
          
          </div>

          <div class="form-group col-md-4" v-if="mulSe(item.icms_situacaoTributaria, [20, 30, 40, 41, 50,60,70, 90])">
            <label for="">ICMS desonerado </label>
            <input
              type="text"
              class="form-control"
              v-money="money"
              v-model="item.icms_ICMSdesonerado"
            />

          </div>

          <div class="form-group col-md-4" v-if="mulSe(item.icms_situacaoTributaria, [20, 30, 40, 41, 50,60,70, 90])">
            <label for="">Motivo desoneração </label>

            <select
              class="form-control"
              v-model="item.icms_motivoDesonerado"
              placeholder="Selecione..."
            >
              <option value="">Selecione...</option>
              <option
                :value="itemS.id"
                :key="key"
                v-for="(itemS, key) in motivoDesonerado"
              >
                {{ (itemS.id != "" ? itemS.id + " - " : "") + itemS.texto }}
              </option>
            </select>


          </div>

          <div class="form-group col-md-4">
            <label for="">Código do benefício fiscal na UF </label>
            <input
              type="text"
              class="form-control"
              v-model="item.icms_codigoBeneficio"
            />
          </div>

          <div class="form-group col-md-12">
            <label for="">Informações complementares do ICMS </label>
            <input
              type="text"
              class="form-control"
              v-model="item.icms_informacoesComplementares"
            />
          </div>

          <div class="form-group col-md-12">
            <label for=""
              >Informações adicionais de interesse do fisco do ICMS
            </label>
            <input
              type="text"
              class="form-control"
              v-model="item.icms_informacoesCompIFICMS"
            />
          </div>
        </div>
      </div>

      <div class="tab-pane fade" id="tabItemST">
       
        <div class="row">
          <div class="form-group col-md-5">
            <label for=""> Modalidade BC ICMS ST </label>
            <select
              class="form-control"
              v-model="item.icms_STmodalidadeBC"
              placeholder="Selecione..."
            >
              <option
                :value="itemS.id"
                :key="key"
                v-for="(itemS, key) in modalidadeBC"
              >
                {{ itemS.id }} - {{ itemS.texto }}
              </option>
            </select>
          </div>

          <div class="form-group col-md-4" v-if="item.icms_STmodalidadeBC==1">
            <label for="">Valor da pauta por un </label>
            <input
              type="text"
              class="form-control"
              v-money="money"
              v-model="item.icms_STvalorPauta"
            />
            
          </div>

          <div class="form-group col-md-4">
            <label for=""
              >Percentual da margem de valor adicionado do ICMS ST
            </label>
            <input
              type="text"
              class="form-control"
              v-money="money"
              v-model="item.icms_STpercentualMargem"
            />
          </div>

          <div class="form-group col-md-4">
            <label for="">% Base ICMS ST </label>
            <input
              type="text"
              class="form-control"
              v-money="money"
              v-model="item.icms_STbaseICMS"
            />
          </div>

          <div class="form-group col-md-4">
            <label for="">Valor Base ICMS ST </label>
            <input
              type="text"
              class="form-control"
              v-money="money"
              readonly
              v-model="item.icms_STvalorBaseICMS"
            />
            BANCO
          </div>

          <div class="form-group col-md-4">
            <label for="">Alíq. ICMS ST </label>
            <input
              type="text"
              class="form-control"
              v-money="money"
              v-model="item.icms_STaliqICMS"
            />
          </div>
          <div class="form-group col-md-4">
            <label for="">Valor ICMS ST </label>
            <input
              type="text"
              class="form-control"
              v-money="money"
              readonly
              v-model="item.icms_STvalorICMS"
            />
          </div>
          <div class="form-group col-md-4" v-if="!mulSe(form.codigoRegimeTributario, [1])">
            <label for="">Valor Base PIS ST </label>
            <input
              type="text"
              class="form-control"
              v-money="money"
              readonly
              v-model="item.icms_STvalorBasePIS"
            />
        
          </div>
          <div class="form-group col-md-4" v-if="!mulSe(form.codigoRegimeTributario, [1])">
            <label for="">Alíq. PIS ST </label>
            <input
              type="text"
              class="form-control"
              v-money="money"
              v-model="item.icms_STaliqPIS"
            />
           
          </div>
          <div class="form-group col-md-4" v-if="!mulSe(form.codigoRegimeTributario, [1])">
            <label for="">Valor PIS ST </label>
            <input
              type="text"
              class="form-control"
              v-money="money"
              v-model="item.icms_STvalorPIS"
              readonly
            />
        
          </div>
          <div class="form-group col-md-4" v-if="!mulSe(form.codigoRegimeTributario, [1])">
            <label for="">Valor Base COFINS ST </label>
            <input
              type="text"
              class="form-control"
              v-money="money"
              readonly
              v-model="item.icms_STvalorBaseCOFINS"
            />
          
          </div>
          <div class="form-group col-md-4" v-if="!mulSe(form.codigoRegimeTributario, [1])">
            <label for="">Alíq. COFINS ST </label>
            <input
              type="text"
              class="form-control"
              v-money="money"
              v-model="item.icms_STaliqCOFINS"
            />
           
          </div>

          <div class="form-group col-md-4" v-if="!mulSe(form.codigoRegimeTributario, [1])">
            <label for="">Valor COFINS ST </label>
            <input
              type="text"
              class="form-control"
              v-money="money"
              readonly
              v-model="item.icms_STvalorCONFIS"
            />
            
          </div>
        </div>
      </div>

      <div class="tab-pane fade" id="tabItemSTR">

        <div class="row">
          <div class="form-group col-md-4">
            <label for="">Valor ICMS substituto</label>
            <input
              type="text"
              class="form-control"
              v-money="money"
              readonly
              v-model="item.icms_STRvalorICMSsub"
            />
          </div>

          <div class="form-group col-md-4">
            <label for="">Valor Base ICMS ST Retido</label>
            <input
              type="text"
              class="form-control"
              v-money="money"
              readonly
              v-model="item.icms_STRvalorBaseICMS"
            />
          </div>

          <div class="form-group col-md-4" v-if="mulSe(form.codigoRegimeTributario, [500])">
            <label for="">% Base ICMS ST Retido</label>
            <input
              type="text"
              class="form-control"
              v-money="money"
              v-model="item.icms_STRbaseICMS"
            />
            
          </div>

          <div class="form-group col-md-4">
            <label for="">Alíq. ICMS ST Retido (%</label>
            <input
              type="text"
              class="form-control"
              v-money="money"
              v-model="item.icms_STRaliqICMS"
            />
          </div>

          <div class="form-group col-md-4">
            <label for="">Valor ICMS ST Retido</label>
            <input
              type="text"
              class="form-control"
              v-money="money"
              readonly
              v-model="item.icms_STRvalorICMS"
            />
          </div>
        </div>
      </div>
    </div>
    <!--FIM TABS -->
  </div>
</template>

<script>
import { VMoney } from "v-money";

export default {
  props: ["item", "form", "money"],
  data() {
    return {
      STmodalidadeBC: [
        { id: "0", texto: "Preço tabelado ou máximo sugerido" },
        { id: "1", texto: "Lista Negativa (valor)" },
        { id: "2", texto: "Lista Positiva (valor)" },
        { id: "3", texto: "Lista Neutra (valor)" },
        { id: "4", texto: "Margem Valor Agregado (%)" },
        { id: "5", texto: "Pauta (valor)" },
        { id: "6", texto: "Valor da Operação" },
      ],
      motivoDesonerado: [
        { id: "0", texto: "Nenhum" },
        { id: "1", texto: "Taxi" },
        { id: "3", texto: "Produtor Agropecuário" },
        { id: "4", texto: "Frotista/Locadora" },
        { id: "5", texto: "Diplomático/Consular" },
        {
          id: "6",
          texto:
            "Utilitários e Motocicletas da Amazônia Ocidental e Áreas de Livre Comércio (Resolução 714/88 e 790/94 – CONTRAN e suas alterações)",
        },
        { id: "7", texto: "SUFRAMA" },
        { id: "8", texto: "Venda a Órgão Público" },
        { id: "9", texto: " Outros" },
        { id: "10", texto: "Deficiente Condutor" },
        { id: "11", texto: "Deficiente Não Condutor" },
        { id: "90", texto: " Solicitado pelo Fisco" },
      ],
      modalidadeBC: [
        { id: "0", texto: "Margem Valor Agregado (%)" },
        { id: "1", texto: "Pauta (valor)" },
        { id: "2", texto: "Preço Tabelado Máx. (valor)" },
        { id: "3", texto: "Valor da operação" },
      ],
      origem: [
        {
          id: "0",
          texto: "Nacional, exceto as indicadas nos códigos 3, 4, 5 e 8",
        },
        {
          id: "1",
          texto:
            "Estrangeira - Importação direta, exceto a indicada no código 6",
        },
        {
          id: "2",
          texto:
            "Estrangeira - Adquirida no mercado interno, exceto a indicada no código 7",
        },
        {
          id: "3",
          texto:
            "Nacional, mercadoria ou bem com Conteúdo de Importação superior a 40% e inferior ou igual a 70%",
        },
        {
          id: "4",
          texto:
            "Nacional, cuja produção tenha sido feita em conformidade com os processos produtivos básicos de que tratam as legislações citadas nos Ajustes",
        },
        {
          id: "5",
          texto:
            "Nacional, mercadoria ou bem com Conteúdo de Importação inferior ou igual a 40%",
        },
        {
          id: "6",
          texto:
            "Estrangeira - Importação direta, sem similar nacional, constante em lista da CAMEX",
        },
        {
          id: "7",
          texto:
            "Estrangeira - Adquirida no mercado interno, sem similar nacional, constante em lista da CAMEX",
        },
        {
          id: "8",
          texto:
            "Nacional, mercadoria ou bem com Conteúdo de Importação superior a 70%",
        },
      ],
      codigoSituacao: [
        { id: "101", texto: "Tributada com permissão de crédito" },
        { id: "102", texto: "Tributada sem permissão de crédito" },
        { id: "103", texto: "Isenção do ICMS para faixa de receita bruta" },
        {
          id: "201",
          texto:
            "Tributada com permissão de crédito e com cobrança do ICMS por ST",
        },
        {
          id: "202",
          texto:
            "Tributada sem permissão de crédito e com cobrança do ICMS por ST",
        },
        {
          id: "203",
          texto:
            "Isenção do ICMS para faixa de receita bruta e com cobrança do ICMS por ST",
        },
        { id: "300", texto: "Imune" },
        { id: "400", texto: "Não tributada" },
        {
          id: "500",
          texto: "ICMS cobrado anteriormente por ST ou por antecipação",
        },
        { id: "900", texto: "Outros" },
      ],
      situacaoTributaria: [
        {
          id: "10",
          texto: "Tributada e com cobrança do ICMS por substituição tributária",
        },
        { id: "20", texto: "Com redução de base de cálculo" },
        {
          id: "30",
          texto:
            "Isenta ou não tributada e com cobrança do ICMS por substituição tributária",
        },
        { id: "40", texto: "Isenta" },
        { id: "41", texto: "Não tributada" },
        { id: "50", texto: "Suspensão" },
        { id: "51", texto: "Diferimento" },
        {
          id: "60",
          texto: "ICMS cobrado anteriormente por substituição tributária",
        },
        {
          id: "70",
          texto:
            "Com redução de base de cálculo e cobrança do ICMS por substituição tributária",
        },
        { id: "90", texto: "Outras" },
        { id: "00", texto: "Tributada integralmente" },
      ],
    };
  },
  mounted() {
  
  },
  methods: {}, //,    components: {}
  directives: { money: VMoney },
};
</script>