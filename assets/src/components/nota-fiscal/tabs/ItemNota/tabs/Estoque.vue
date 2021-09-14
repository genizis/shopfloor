<template>
  <div class="row">
    <div class="form-group col-md-12">
      <label for="">O que fazer com este produto? </label>
      <select
        class="form-control"
        v-model="item.estoque.oquefazer"
        placeholder="Selecione..."
      >
        <option value="">Selecione...</option>
        <option :value="itemS.id" :key="key" v-for="(itemS, key) in oquefazer">
          {{ itemS.texto }}
        </option>
      </select>
    </div>

    <div class="form-group col-md-12" v-if="item.estoque.oquefazer == '1'">
      <label for=""> Produto no cadastro </label>
      <input
        type="number"
        class="form-control"
        v-model="item.estoque.FKIDProduto"
      />
    </div>

    <div class="form-group col-md-4" v-if="item.estoque.oquefazer != '2'">
      <label for=""> Unidade de medida para estoque </label>
      <input
        type="number"
        class="form-control"
        v-model="item.estoque.unidadeMedida"
      />
    </div>

    <div class="form-group col-md-4" v-if="(item.estoque.oquefazer != '2')">
      <label for=""> Quantidade para estoque </label>
      <input
        type="number"
        class="form-control"
        v-model="item.estoque.quantidadeEstoque"
      />
    </div>

    <div class="form-group col-md-4" v-if="(item.estoque.oquefazer != '2')">
      <label for=""> Código no fornecedor </label>
      <input
        type="number"
        class="form-control"
        v-model="item.estoque.codigoFornecedor"
      />
    </div>
    <div class="col-12">
      <hr />
      <h4>Escala relevante</h4>
      <hr />
    </div>

    <div class="form-group col-md-4">
      <label for=""> Indicador de escala relevante </label>
      <select
        class="form-control"
        v-model="item.estoque.indicadorEscalaRelevante"
        placeholder="Selecione..."
      >
        <option value="">Selecione...</option>
        <option
          :value="itemS.id"
          :key="key"
          v-for="(itemS, key) in indicadorEscalaRelevante"
        >
          {{ itemS.texto }}
        </option>
      </select>
    </div>

    <div
      class="form-group col-md-4"
      v-if="item.estoque.indicadorEscalaRelevante == '0'"
    >
      <label for=""> CNPJ do fabricante </label>
      <input
        type="text"
        maxlength="20"
        class="form-control"
        v-model="item.estoque.CNPJ"
      />
    </div>

    <div class="col-12">
      <hr />
      <h5>Controle de lote</h5>
      <hr />
    </div>

    <div class="form-group col-md-3">
      <label for=""> Número do lote </label>
      <input
        type="number"
        class="form-control"
        v-model="item.estoque.numeroLote"
      />
    </div>

    <div class="form-group col-md-3">
      <label for=""> Data de fabricação </label>
      <input
        type="date"
        class="form-control"
        v-model="item.estoque.dataFabricacao"
      />
    </div>

    <div class="form-group col-md-3">
      <label for=""> Data de validade </label>
      <input
        type="date"
        class="form-control"
        v-model="item.estoque.dataValidade"
      />
    </div>

    <div class="form-group col-md-3">
      <label for=""> Código de agregação </label>
      <input
        type="number"
        class="form-control"
        v-model="item.estoque.codigoAgregacao"
      />
    </div>

  </div>
</template>

<script>
export default {
  props: ["item", "money"],
  data() {
    return {
      indicadorEscalaRelevante: [
        { id: 1, texto: "S - Produzido em Escala Relevante" },
        { id: 0, texto: "N - Produzido em Escala NÃO Relevante" },
      ],
      oquefazer: [
        { id: 0, texto: "Incluir novo produto" },
        { id: 1, texto: "Vincular a produto existente " },
        { id: 2, texto: "Não cadastrar produto" },
      ],
    };
  },
  mounted() {
    Vue.set(this.item, "estoque", {
      indicadorEscalaRelevante: 1,
      oquefazer: "",
    });
  },
  methods: {}, //,    components: {}
};
</script>