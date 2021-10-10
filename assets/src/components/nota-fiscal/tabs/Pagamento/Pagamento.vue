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
        name="pagamento_condicaoPagamento"
        v-model="form.pagamento_condicaoPagamento"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Categoria </label>
      <input
        type="integer"
        class="form-control"
        name="pagamento_FKIDCategoria"
        v-model="form.pagamento_FKIDCategoria"
      />
    </div>

    <Item
      v-for="item in form.pagamentoItens"
      :key="item.keyCont"
      :money="money"
      :item="item"
      @remover="remover"
    />

    <div class="col-12 text-right">
      <a @click="novo()" href="#" class="pointer"
        >Adicionar Novo Pagamento <i class="fas fa-plus"></i
      ></a>
    </div>
  </div>
</template>

<script>
import Item from "./Item.vue";

export default {
  props: ["form", "money"],
  data() {
    return {
      keyCont: 999,
    };
  },
  mounted() {
     if ( typeof this.form.pagamentoItens.length =='undefined' )
      this.form.pagamentoItens = [
      ];

    /*this.form.pagamento_condicaoPagamento = "";
    this.form.pagamento_FKIDCategoria = "";
    this.form.pagamentoItens = [
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
    ];
*/
  },
  methods: {
    remover(item) {
      var $this = this;
      if (item.cad) {
        let index = this.buscarIndexArray(
          this.form.pagamentoItens,
          "keyCont",
          item.keyCont
        );
        $this.form.pagamentoItens.splice(index, 1);
      } else {
        var index = this.buscarIndexArray(
          this.form.pagamentoItens,
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
                .get("/ajax/excluir-nota-fiscal-parcela?id=" + item.id)
                .then((response) => {
                  if (response.data.resultado) {
                    alertify.success(response.data.msg);
                    $this.form.pagamentoItens.splice(index, 1);
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
      this.form.pagamentoItens.push({
        dias: "",
        data: "",
        valor: "",
        pagamento: "",
        FKIDFormaPagamento: "",
        keyCont: this.keyCont++,
        cad: true,
      });
    },
  },
  components: { Item },
};
</script>