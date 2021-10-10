<template>
  <div class="row mt-2">
    <div class="form-group col-md-12">
      <label for="">Situação tributária do PIS </label>
      <select
        class="form-control"
        v-model="item.pis_situacaoTributaria"
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

    <div class="form-group col-md-4">
      <label for="">% Base PIS </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.pis_basePIS"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">Valor Base PIS </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.pis_valorBase"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">Alíq. PIS </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.pis_aliqPIS"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">Valor PIS </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.pis_valorPIS"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">Valor fixo PIS</label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.pis_valorFixoPIS"
      />
    </div>

    <div class="form-group col-md-12">
      <label for="">Informações complementares do PIS</label>
      <input
        type="text"
        class="form-control"
        maxlength="500"
        v-model="item.pis_informacoesComp"
      />
    </div>

    <div class="form-group col-md-12">
      <label for="">Informações adicionais de interesse do fisco do PIS</label>
      <input
        type="text"
        maxlength="500"
        class="form-control"
        v-model="item.pis_informacoesCompIF"
      />
    </div>

    <div class="form-group col-md-12">
      <label for="">Situação tributária do COFINS </label>
      <select
        class="form-control"
        v-model="item.confis_situacaoTributaria"
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
      class="form-group col-md-4"
      v-if="
        mulSeText(item.confis_situacaoTributaria, [
          '3',
          '4',
          '5',
          '6',
          '7',
          '8',
          '9',
        ])
      "
    >
      <label for="">% Base COFINS</label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.confis_baseCONFIS"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">Valor COFINS</label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.confis_valorCONFIS"
      />
    </div>

    <div
      class="form-group col-md-4"
      v-if="
        mulSeText(item.confis_situacaoTributaria, [
          '4',
          '5',
          '6',
          '7',
          '8',
          '9',
        ])
      "
    >
      <label for="">Valor Base COFINS</label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.confis_valorBaseCONFIS"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">Alíq. COFINS</label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.confis_aliqCONFIS"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">Valor fixo COFINS</label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.confis_valorFixoCONFIS"
      />
    </div>

    <div class="form-group col-md-12">
      <label for="">Informações complementares do COFINS</label>
      <input
        type="text"
        class="form-control"
        maxlength="500"
        v-model="item.confis_informacoesComp"
      />
    </div>

    <div class="form-group col-md-12">
      <label for=""
        >Informações adicionais de interesse do fisco do COFINS</label
      >
      <input
        type="text"
        maxlength="500"
        class="form-control"
        v-model="item.confis_informacoesCompIF"
      />
    </div>
  </div>
</template>

<script>
import { VMoney } from "v-money";

export default {
  props: ["item", "money"],
  data() {
    return {
      situacaoTributaria: [
        { id: "49", texto: "Outras Operações de Saída" },
        {
          id: "50",
          texto:
            "Operação com Direito a Crédito - Vinculada Exclusivamente a Receita Tributada no Mercado Interno",
        },
        {
          id: "51",
          texto:
            "Operação com Direito a Crédito – Vinculada Exclusivamente a Receita Não Tributada no Mercado Interno",
        },
        {
          id: "52",
          texto:
            "Operação com Direito a Crédito - Vinculada Exclusivamente a Receita de Exportação",
        },
        {
          id: "53",
          texto:
            "Operação com Direito a Crédito - Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno",
        },
        {
          id: "54",
          texto:
            "Operação com Direito a Crédito - Vinculada a Receitas Tributadas no Mercado Interno e de Exportação",
        },
        {
          id: "55",
          texto:
            "Operação com Direito a Crédito - Vinculada a Receitas Não-Tributadas no Mercado Interno e de Exportação",
        },
        {
          id: "56",
          texto:
            "Operação com Direito a Crédito - Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno, e de Exportação",
        },
        {
          id: "60",
          texto:
            "Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita Tributada no Mercado Interno",
        },
        {
          id: "61",
          texto:
            "Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita Não-Tributada no Mercado Interno",
        },
        {
          id: "62",
          texto:
            "Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a Receita de Exportação",
        },
        {
          id: "63",
          texto:
            "Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno",
        },
        {
          id: "64",
          texto:
            "Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas no Mercado Interno e de Exportação",
        },
        {
          id: "65",
          texto:
            "Crédito Presumido - Operação de Aquisição Vinculada a Receitas Não-Tributadas no Mercado Interno e de Exportação",
        },
        {
          id: "66",
          texto:
            "Crédito Presumido - Operação de Aquisição Vinculada a Receitas Tributadas e Não-Tributadas no Mercado Interno, e de Exportação",
        },
        { id: "67", texto: "Crédito Presumido - Outras Operações" },
        { id: "70", texto: "Operação de Aquisição sem Direito a Crédito" },
        { id: "71", texto: "Operação de Aquisição com Isenção" },
        { id: "72", texto: "Operação de Aquisição com Suspensão" },
        { id: "73", texto: "Operação de Aquisição a Alíquota Zero" },
        {
          id: "74",
          texto: "Operação de Aquisição sem Incidência da Contribuição",
        },
        {
          id: "75",
          texto: "Operação de Aquisição por Substituição Tributária",
        },
        { id: "98", texto: "Outras Operações de Entrada" },
        { id: "99", texto: "Outras operações" },
        {
          id: "1",
          texto: "Operação tributável (alíquota normal, cumulativo ou não)",
        },
        { id: "2", texto: "Operação tributável (alíquota diferenciada)" },
        {
          id: "3",
          texto: "Operação tributável (alíquota por unidade de produto)",
        },
        {
          id: "4",
          texto: "Operação tributável (tributação monofásica, alíquota zero)",
        },
        { id: "5", texto: "Operação tributável (Substituição Tributária)" },
        { id: "6", texto: "Operação tributável (alíquota zero)" },
        { id: "7", texto: "Operação isenta da contribuição" },
        { id: "8", texto: "Operação sem incidência da contribuição" },
        { id: "9", texto: "Operação com suspensão da contribuição" },
      ],
    };
  },
  mounted() {    
   
  },
  methods: {}, //,    components: {}
  directives: { money: VMoney },
};
</script>