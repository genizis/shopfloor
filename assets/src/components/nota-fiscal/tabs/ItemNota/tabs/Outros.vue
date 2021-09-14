<template>
  <div class="row">
    <div class="form-group col-md-4">
      <label for=""> Presumido no cálculo do PIS/COFINS </label>
     <select
        class="form-control"
        v-model="item.outros.presumidoCalculo"
        placeholder="Selecione..."
      >
        <option :value="itemS.id" :key="key" v-for="(itemS, key) in simNao">
          {{ itemS.texto }}
        </option>
      </select>

    </div>

    <div class="form-group col-md-4">
      <label for="">Alíq. Funrural </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.outros.aliqFunrural"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">Tipo do item </label>

      <select
        class="form-control"
        v-model="item.outros.tipoItem"
        placeholder="Selecione..."
      >
        <option value="">Selecione...</option>
        <option :value="itemS.id" :key="key" v-for="(itemS, key) in tipoItem">
          {{ itemS.texto }}
        </option>
      </select>
      
    </div>

    <div class="form-group col-md-4">
      <label for="">Base Comissão </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.outros.baseComissao"
      />
    </div>
    <div class="form-group col-md-4">
      <label for="">Alíquota Comissão </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.outros.aliquotaComissao"
      />
    </div>
    <div class="form-group col-md-4">
      <label for="">Valor Comissão </label>
      <input
        type="text"
        readonly
        class="form-control"
        v-money="money"
        v-model="item.outros.valorComissao"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">Número do Pedido de Compra</label>
      <input
        type="number"
        class="form-control"
        v-model="item.outros.numeroPedido"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">Nr. Item Pedido de Compra</label>
      <input
        type="number"
        class="form-control"
        v-model="item.outros.nrItemPedido"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">% Aprox. Trib. IBPT </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.outros.aproxTrib"
      />
    </div>
    <div class="form-group col-md-4">
      <label for="">Valor Aprox. Trib </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.outros.valorAproxTrib"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">Unidade tributária</label>
      <input
        type="number"
        class="form-control"
        v-model="item.outros.unidadeTributaria"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">Quantidade tributária </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.outros.quantidadeTributaria"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">Valor unitário tributário</label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        readonly
        v-model="item.outros.valorUnitario"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">Valor outras despesas </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        readonly
        v-model="item.outros.valorOutrasDespesas"
      />
    </div>
  </div>
</template>

<script>
import { VMoney } from "v-money";

export default {
  props: ["item", "money"],
  data() {
    return {
      simNao:[
        {id:1,texto:'Sim'},
        {id:0,texto:'Não'}
      ],
      tipoItem: [
        { id: 1, texto: "Outros insumos" },
        { id: 2, texto: "Outras" },
        { id: 3, texto: "Mercadoria para Revenda" },
        { id: 4, texto: "Matéria-Prima" },
        { id: 5, texto: "Embalagem" },
        { id: 6, texto: "Produto em Processo" },
        { id: 7, texto: "Produto Acabado" },
        { id: 8, texto: "Subproduto" },
        { id: 9, texto: "Produto Intermediário" },
        { id: 10, texto: "Material de Uso e Consumo" },
        { id: 11, texto: "Ativo Imobilizado" },
        { id: 12, texto: "Serviços" },
      ],
    };
  },
  mounted() {
    Vue.set(this.item, "outros", {
      presumidoCalculo: 1,
    });
  },
  methods: {}, //,    components: {}
  directives: { money: VMoney },
};
</script>