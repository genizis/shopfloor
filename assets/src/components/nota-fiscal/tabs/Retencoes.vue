<template>
  <div class="row col-12">
    <div class="col-12">
      <h5>Retenções</h5>
    </div>

    <div class="form-group col-md-3">
      <label for="">Mínimo p/ retenção </label>

      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto.calculoAutomatico"
        name="retencoes.minimoRetencao"
        v-model="form.retencoes.minimoRetencao"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Base p/ retenções </label>

      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto.calculoAutomatico"
        name="retencoes.baseRetencao"
        v-model="form.retencoes.baseRetencao"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Valor IR </label>

      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto.calculoAutomatico"
        name="retencoes.valorIR"
        v-model="form.retencoes.valorIR"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Valor CSLL </label>

      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto.calculoAutomatico"
        name="retencoes.valorCSLL"
        v-model="form.retencoes.valorCSLL"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Valor PIS retido </label>

      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto.calculoAutomatico"
        name="retencoes.valorPISretido"
        v-model="form.retencoes.valorPISretido"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Valor COFINS retido </label>

      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto.calculoAutomatico"
        name="retencoes.valorCOFINSRetido"
        v-model="form.retencoes.valorCOFINSRetido"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Valor ISS retido </label>
      automático
      <input
        type="text"
        class="form-control"
        v-money="money"
        name="retencoes.valorISSRetido"
        v-model="form.retencoes.valorISSRetido"
      />
    </div>
  </div>
</template>

<script>
import { VMoney } from "v-money";

export default {
  props: ["form", "money"],
  data() {
    return {};
  },
  mounted() {
    this.form.retencoes = {
      minimoRetencao: "",
      baseRetencao: "",
      valorIR: "",
      valorCSLL: "",
      valorPISretido: "",
      valorCOFINSRetido: "",
      valorISSRetido: "",
    };
  },
  methods: {},
  directives: { money: VMoney }, //,    components: {}
};
</script>