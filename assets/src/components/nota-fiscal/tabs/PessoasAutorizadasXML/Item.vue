<template>
  <div class="col-12 row">
    <div class="form-group col-md-4">
      <label for="">Contato</label>
      <input
        type="integer"
        class="form-control"
        sname="item.FKIDContato"
        v-model="item.FKIDContato"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">CPF/CNPJ </label>
      <input
        type="text"
        class="form-control"
        maxlength="20"
        sname="item.CPFCNPJ"
        v-model="item.CPFCNPJ"
      />
    </div>

    <div class=" div-excluir text-right">
      <i @click="remover" class="fas fa-trash pointer red"></i>
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
  methods: {
     remover(){
      this.$emit('remover',this.item);
    }
  },
};
</script>