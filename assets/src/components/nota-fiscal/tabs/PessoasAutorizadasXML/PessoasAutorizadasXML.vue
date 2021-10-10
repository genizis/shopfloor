<template>
  <div class="row col-12">
    <div class="col-12">
      <h5>Pessoas autorizadas a acessar o XML da nota</h5>
    </div>

    <Item
      v-for="item in form.pessoasAutorizadas"
      :key="item.keyCont"
      :item="item"
      @remover="remover"
    />

    <div class="col-12 text-right">
      <a @click="novo" href="#" class="pointer"
        >Adicionar Nova Pessoa <i class="fas fa-plus"></i
      ></a>
    </div>
  </div>
</template>

<script>
import Item from "./Item.vue";

export default {
  props: ["form"],
  data() {
    return {
      keyCont: 999,
    };
  },
  mounted() {

    if ( typeof this.form.pessoasAutorizadas.length =='undefined' )
      this.form.pessoasAutorizadas = [
      ];
  },
  methods: {
    remover(item) {
      var $this = this;
      if (item.cad) {
        let index = this.buscarIndexArray(
          this.form.pessoasAutorizadas,
          "keyCont",
          item.keyCont
        );
        $this.form.pessoasAutorizadas.splice(index, 1);
      } else {
        var index = this.buscarIndexArray(
          this.form.pessoasAutorizadas,
          "id",
          item.id
        );
        var $this = this;
        alertify
          .confirm(
            "alerta",
            "Tem certeza que deseja excluir essa regra?",
            function () {
              axios
                .get(
                  "/ajax/excluir-nota-fiscal-pessoa-autorizada?id=" + item.id
                )
                .then((response) => {
                  if (response.data.resultado) {
                    alertify.success(response.data.msg);
                    $this.form.pessoasAutorizadas.splice(index, 1);
                  } else {
                    alertify.error(response.data.msg);
                  }
                });
            },
            function () {}
          )
          .set("labels", { ok: "Sim", cancel: "Cancelar" })
          .set("closable", true)
          .set("basic", false)
          .closeOthers();
      }
    },
    novo() {
      this.form.pessoasAutorizadas.push({
        cad: true,
        FKIDContato: "",
        CPFCNPJ: "",
        keyCont: this.keyCont++,
      });
    },
  },
  components: { Item },
};
</script>