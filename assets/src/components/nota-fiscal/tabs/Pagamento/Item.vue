<template>
  <div class="col-12 row">
    <div class="form-group col-md-2">
      <label for="">Dias </label>
      <input
        type="number"
        class="form-control"
        sname="pagamento.dias"
        v-model="item.dias"
      />
    </div>

    <div class="form-group col-md-2">
      <label for="">Data </label>
      <input
        type="date"
        class="form-control"
        sname="pagamento.data"
        v-model="item.data"
      />
    </div>

    <div class="form-group col-md-2">
      <label for="">Valor </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        sname="pagamento.valor"
        v-model="item.valor"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Forma</label>
      <input
        type="text"
        class="form-control"
        sname="pagamento.FKIDFormaPagamento"
        v-model="item.FKIDFormaPagamento"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Observação </label>
      <input
        type="text"
        class="form-control"
        sname="pagamento.observacao"
        v-model="item.observacao"
      />
    </div>

    <div class=" div-excluir text-right">
      <i @click="remover()" class="fas fa-trash pointer red" ></i>
    </div>

  </div>
</template>

<script>
import { VMoney } from "v-money";

export default {
  props: ["item", "money"],
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
  directives: { money: VMoney },
};
</script>