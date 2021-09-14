<template>
  <div class="row col-12">
    <div class="col-12">
      <h5>Pagamento</h5>
    </div>

    <div class="form-group col-md-3">
      <label for="">Condição de pagamento </label>
      <input
        type="integer"
        class="form-control"
        name="pagamento.condicaoPagamento"
        v-model="form.pagamento.condicaoPagamento"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Categoria </label>
      <input
        type="integer"
        class="form-control"
        name="pagamento.FKIDCategoria"
        v-model="form.pagamento.FKIDCategoria"
      />
    </div>

    <div class="col-12">
      <hr />
      <h6>Itens</h6>
      <hr />
    </div>

    <Item v-for="item in form.pagamento.itens" :key="item.id" :money="money" :item="item" />
  
  </div>
</template>

<script>
import Item from "./Item.vue";

export default {
  props: ["form","money"],
  data() {
    return {};
  },
  mounted() {
    this.form.pagamento = {
      condicaoPagamento: "",
      FKIDCategoria:"",
      itens: [
        {
          dias: "",
          data: "",
          valor: "",
          pagamento: "",
          FKIDFormaPagamento: "",
          observacao: "",
          id: "",
          cad: false,
        },
      ],
    };
  },
  methods: {},
  components: { Item },
};
</script>