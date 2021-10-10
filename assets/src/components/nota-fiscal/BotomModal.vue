<template>
  <a href="#" @click="abrirModal()">{{ texto }}</a>
</template>

<script>
import NotaFiscal from "./Form.vue";

export default {
  props: ["texto", "tipo","titulo","idfaturamento"],
  data() {
    return {
      mostrar: false,
    };
  },
  mounted() {},
  methods: {
    abrirModal() {
      var $this = this;
      this.$modal.show(
        NotaFiscal,
        {
          titulo: $this.titulo,
          tipo:$this.tipo,
          idfaturamento:$this.idfaturamento
        },
        {
          height: "auto",
          width: "80%",
          classes: "modalDinamico modalDinamico-open",
        }
      );
    },
  }, //,    components: { Cabecalho,ListaContato,Conversa}
};
</script>