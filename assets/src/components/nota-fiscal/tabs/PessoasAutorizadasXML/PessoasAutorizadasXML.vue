<template>
  <div class="row col-12">
    <div class="col-12">
      <h5>Pessoas autorizadas a acessar o XML da nota</h5>
    </div>

    <Item
      v-for="item in form.pessoasAutorizadas"
      :key="item.id"
      :item="item"
    />

  </div>
</template>

<script>
import Item from "./Item.vue";

export default {
  props: ["form"],
  data() {
    return {};
  },
  mounted() {
    this.form.pessoasAutorizadas = [
      {
        id: "",
        cad: "",
        FKIDContato: "",
        CPFCNPJ: "",
      },
    ]
  },
  methods: {},
  components: { Item },
};
</script>