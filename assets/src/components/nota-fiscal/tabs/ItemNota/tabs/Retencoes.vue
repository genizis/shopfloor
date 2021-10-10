<template>
  <div class="row mt-2">
    <div class="form-group col-md-4">
      <label for="">Imposto retido </label>
      <select
        class="form-control"
        v-model="item.retencoes_impostoRetido"
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
        v-model="item.retencoes_aliqIR"
      />
    </div>
    <div class="form-group col-md-4">
      <label for="">Base IR </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        readonly
        v-model="item.retencoes_baseIR"
      />
    </div>
    <div class="form-group col-md-4">
      <label for="">Valor IR </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        readonly
        v-model="item.retencoes_valorIR"
      />
    </div>
    <div class="form-group col-md-4">
      <label for="">Alíq. CSLL</label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.retencoes_aliqCSLL"
      />
    </div>
    <div class="form-group col-md-4">
      <label for="">Valor CSLL </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        readonly
        v-model="item.retencoes_valorCSLL"
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
   
  },
  methods: {}, //,    components: {}
  directives: { money: VMoney },
};
</script>