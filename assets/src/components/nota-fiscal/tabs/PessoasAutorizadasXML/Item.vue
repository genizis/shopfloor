<template>
  <div class="col-12 row">
    <div class="form-group col-md-3">
      <label for="">Contato FKIDContato</label>
      <input
        type="integer"
        class="form-control"
        name="item.FKIDContato"
        v-model="item.FKIDContato"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">CPF/CNPJ </label>
      <input
        type="text"
        class="form-control"
        maxlength="20"
        name="item.CPFCNPJ"
        v-model="item.CPFCNPJ"
      />
    </div>
  </div>
</template>

<script>
export default {
  props: ["item"],
  data() {
    return {
      mostrar: false,
    };
  },
  mounted() {},
  methods: {},
};
</script>