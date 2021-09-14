<template>
  <div class="row">
    <div class="form-group col-md-4">
      <label for=""> Situação tributária do ISSQN </label>
      <select
        class="form-control"
        v-model="item.issqn.situacaoTributaria"
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
        v-model="item.issqn.descontarISS"
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
        v-model="item.issqn.reterISS"
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
        v-model="item.issqn.baseISSQN"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">Valor Base ISSQN </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.issqn.valorBaseISSQN"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">Alíq. ISSQN </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.issqn.aliqISSQN"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">Valor ISSQN</label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.issqn.valorISSQN"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">Cod. Lista Serviços</label>
      <input
        type="number"
        class="form-control"
        v-model="item.issqn.codListaServico"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">Valor retido</label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.issqn.valorRetido"
      />
    </div>

    <div class="form-group col-md-12">
      <label for="">Informações complementares do ISSQN</label>
      <input
        type="text"
        class="form-control"
        v-model="item.issqn.informacoesComp"
      />
    </div>

    <div class="form-group col-md-12">
      <label for=""
        >Informações adicionais de interesse do fisco do ISSQN</label
      >
      <input
        type="text"
        class="form-control"
        v-model="item.issqn.informacoesCompIF"
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
    Vue.set(this.item, "issqn", {
      situacaoTributaria: 0,
      reterISS: 0,
      descontarISS: 0,
    });
  },
  methods: {}, //,    components: {}
  directives: { money: VMoney },
};
</script>