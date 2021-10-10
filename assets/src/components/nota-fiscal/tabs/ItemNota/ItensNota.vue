<template>
  <div class="row col-12">
    <div class="col-12">
      <h5>Itens da nota fiscal</h5>
    </div>
    <div class="col-12">
      <table class="table">
        <thead class="thead-light text-center">
          <tr>
            <th>Produto ou serviço</th>
            <th>Código</th>
            <th>Un</th>
            <th>Qte</th>
            <th>Preço un</th>
            <th>NCM</th>
            <th></th>
            <th></th>
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
   //this.form.itensNota = [];
  },
  methods: {},
  components: { Item },
};
</script>