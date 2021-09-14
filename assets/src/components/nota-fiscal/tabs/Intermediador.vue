<template>
  <div class="row col-12">
    <div class="col-12">
      <h5>Intermediador</h5>
    </div>

    <div class="form-group col-md-3">
      <label for="intermediador.intermediador">Intermediador </label>
      <input
        type="checkbox"
        class=""
        value="1"
        name="intermediador.intermediador"
        id="intermediador.intermediador"
        v-model="form.intermediador.intermediador"
      />
    </div>

    <div class="form-group col-md-3" v-if="form.intermediador.intermediador==1">
      <label for="">CNPJ </label>
      <input
        type="text"
        maxlength="15"
        class="form-control"
        name="intermediador.CNPJ"
        v-model="form.intermediador.CNPJ"
      />
    </div>

    <div class="form-group col-md-3" v-if="form.intermediador.intermediador==1">
      <label for="">Identificação no intermediador </label>
      <input
        type="text"
        maxlength="255"
        class="form-control"
        name="intermediador.identificacao"
        v-model="form.intermediador.identificacao"
      />
    </div>
  </div>
</template>

<script>
export default {
  props: ["form"],
  data() {
    return {};
  },
  mounted() {
    this.form.intermediador = {
      intermediador: false,
      CNPJ: "",
      identificacao: "",
    };
  },
  methods: {}, //,    components: {}
};
</script>