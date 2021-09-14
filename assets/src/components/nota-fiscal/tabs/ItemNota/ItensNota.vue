<template>
  <div class="row col-12">
    <div class="col-12">
      <h5>Itens da nota fiscal</h5>
    </div>
    <div class="col-12">
      <table class="table table-sm">
        <thead>
          <tr>
            <td>Produto ou serviço</td>
            <td>Código</td>
            <td>Un</td>
            <td>Qtde</td>
            <td>Preço un</td>
            <td>NCM</td>
            <td></td>
            <td></td>
          </tr>
        </thead>

        <tbody>
          <Item
            v-for="item in form.itensNota"
            :key="item.id"
            :money="money"
            :item="item"
            :form="form"
          />
        </tbody>
      </table>
      
      <hr />
    </div>
  </div>
</template>

<script>
import Item from "./Linha.vue";

export default {
  props: ["form", "money"],
  data() {
    return {};
  },
  mounted() {
    this.form.itensNota = [
      {
        id: "",
        cad: "",
        FKIDContato: "",
        CPFCNPJ: "",
      },
    ];
  },
  methods: {},
  components: { Item },
};
</script>