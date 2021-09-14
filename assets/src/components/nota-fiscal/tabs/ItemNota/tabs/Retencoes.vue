<template>
  <div class="row">
    <div class="form-group col-md-4">
      <label for="">Imposto retido </label>
      <select
        class="form-control"
        v-model="item.retencoes.impostoRetido"
        placeholder="Selecione..."
      >
        <option :value="itemS.id" :key="key" v-for="(itemS, key) in simNao">
          {{ itemS.texto }}
        </option>
      </select>
    </div>

    <div class="form-group col-md-4">
      <label for="">Alíq. IR </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.retencoes.aliqIR"
      />
    </div>
    <div class="form-group col-md-4">
      <label for="">Base IR </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        readonly
        v-model="item.retencoes.baseIR"
      />
    </div>
    <div class="form-group col-md-4">
      <label for="">Valor IR </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        readonly
        v-model="item.retencoes.valorIR"
      />
    </div>
    <div class="form-group col-md-4">
      <label for="">Alíq. CSLL</label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.retencoes.aliqCSLL"
      />
    </div>
    <div class="form-group col-md-4">
      <label for="">Valor CSLL </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        readonly
        v-model="item.retencoes.valorCSLL"
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
    };
  },
  mounted() {
    Vue.set(this.item, "retencoes", {
      impostoRetido: 0,
    });
  },
  methods: {}, //,    components: {}
  directives: { money: VMoney },
};
</script>