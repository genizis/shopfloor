<template>
  <div class="row mt-2">
    <div class="form-group col-md-4">
      <label for=""> Situação tributária do ISSQN </label>
      <select
        class="form-control"
        v-model="item.issqn_situacaoTributaria"
        placeholder="Selecione..."
      >
        <option value="">Selecione...</option>
        <option
          :value="itemS.id"
          :key="key"
          v-for="(itemS, key) in situacaoTributaria"
        >
          {{ itemS.texto }}
        </option>
      </select>
    </div>

    <div class="form-group col-md-4">
      <label for=""> Descontar ISS do total faturado </label>
      <select
        class="form-control"
        v-model="item.issqn_descontarISS"
        placeholder="Selecione..."
      >
        <option :value="itemS.id" :key="key" v-for="(itemS, key) in simNao">
          {{ itemS.texto }}
        </option>
      </select>
    </div>

    <div class="form-group col-md-4">
      <label for=""> Reter ISS </label>
      <select
        class="form-control"
        v-model="item.issqn_reterISS"
        placeholder="Selecione..."
      >
        <option :value="itemS.id" :key="key" v-for="(itemS, key) in simNao">
          {{ itemS.texto }}
        </option>
      </select>
    </div>

    <div class="form-group col-md-4">
      <label for="">% Base ISSQN </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.issqn_baseISSQN"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">Valor Base ISSQN </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.issqn_valorBaseISSQN"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">Alíq. ISSQN </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.issqn_aliqISSQN"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">Valor ISSQN</label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.issqn_valorISSQN"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">Cod. Lista Serviços</label>
      <input
        type="number"
        class="form-control"
        v-model="item.issqn_codListaServico"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">Valor retido</label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.issqn_valorRetido"
      />
    </div>

    <div class="form-group col-md-12">
      <label for="">Informações complementares do ISSQN</label>
      <input
        type="text"
        class="form-control"
        v-model="item.issqn_informacoesComp"
      />
    </div>

    <div class="form-group col-md-12">
      <label for=""
        >Informações adicionais de interesse do fisco do ISSQN</label
      >
      <input
        type="text"
        class="form-control"
        v-model="item.issqn_informacoesCompIF"
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
      simNao: [
        { id: 1, texto: "Sim" },
        { id: 0, texto: "Não" },
      ],
      situacaoTributaria: [
        { id: 0, texto: "Tributado" },
        { id: 1, texto: "Isento" },
        { id: 2, texto: "Outra Situação" },
      ],
    };
  },
  mounted() {
    
  },
  methods: {}, //,    components: {}
  directives: { money: VMoney },
};
</script>