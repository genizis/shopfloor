<template>
  <div class="row col-12">
    <div class="col-12">
      <h5>Cálculo de imposto</h5>
    </div>

    <div class="form-group col-md-3">
      <label for="calculoimposto.calculoAutomatico"
        >Cálculo automático ligado
      </label>
      <input
        type="checkbox"
        class=""
        id="calculoimposto.calculoAutomatico"
        name="calculoimposto.calculoAutomatico"
        v-model="form.calculoimposto.calculoAutomatico"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Base ICMS</label> 
      <input
        type="text"
        class="form-control"
        name="calculoimposto.baseICMS"
        v-money="money"
        :readonly="form.calculoimposto.calculoAutomatico"
        v-model="form.calculoimposto.baseICMS"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Valor ICMS</label> 
      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto.calculoAutomatico"
        name="calculoimposto.valorICMS"
        v-model="form.calculoimposto.valorICMS"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Base ICMS ST</label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto.calculoAutomatico"
        name="calculoimposto.baseICMSST"
        v-model="form.calculoimposto.baseICMSST"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Valor ICMS ST</label> 
      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto.calculoAutomatico"
        name="calculoimposto.valorICMSST"
        v-model="form.calculoimposto.valorICMSST"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Total dos Serviços</label>

      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto.calculoAutomatico"
        name="calculoimposto.totalServicos"
        v-model="form.calculoimposto.totalServicos"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Total dos Produtos</label>

      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto.calculoAutomatico"
        name="calculoimposto.totalProdutos"
        v-model="form.calculoimposto.totalProdutos"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Valor do Frete</label>

      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto.calculoAutomatico"
        name="calculoimposto.valorFrete"
        v-model="form.calculoimposto.valorFrete"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Valor do Seguro</label>

      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto.calculoAutomatico"
        name="calculoimposto.valorSeguro"
        v-model="form.calculoimposto.valorSeguro"
      />
    </div>
    <div class="form-group col-md-3">
      <label for="">Outras Despesas</label>

      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto.calculoAutomatico"
        name="calculoimposto.outrasDespesas"
        v-model="form.calculoimposto.outrasDespesas"
      />
    </div>
    <div class="form-group col-md-3">
      <label for="">Valor IPI</label>

      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto.calculoAutomatico"
        name="calculoimposto.valorIPI"
        v-model="form.calculoimposto.valorIPI"
      />
    </div>
    <div class="form-group col-md-3">
      <label for="">Valor ISSQN</label>

      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto.calculoAutomatico"
        name="calculoimposto.valorISSQN"
        v-model="form.calculoimposto.valorISSQN"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Total da Nota</label>

      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto.calculoAutomatico"
        name="calculoimposto.totalNota"
        v-model="form.calculoimposto.totalNota"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Desconto</label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        name="calculoimposto.desconto"
        v-model="form.calculoimposto.desconto"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Valor Funrural</label>

      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto.calculoAutomatico"
        name="calculoimposto.valorFunrural"
        v-model="form.calculoimposto.valorFunrural"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Total Faturado</label>

      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto.calculoAutomatico"
        name="calculoimposto.totalFaturado"
        v-model="form.calculoimposto.totalFaturado"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Nº Itens</label>
      AUTO
      <input
        type="number"
        class="form-control"
        name="calculoimposto.nItens"
        v-model="form.calculoimposto.nItens"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Total A. Tributos </label>

      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto.calculoAutomatico"
        name="calculoimposto.totalAtributos"
        v-model="form.calculoimposto.totalAtributos"
      />
    </div>
  </div>
</template>

<script>
import { VMoney } from "v-money";

export default {
  props: ["form", "money"],
  data() {
    return {};
  },
  mounted() {
    this.form.calculoimposto = {
      calculoAutomatico: false,
      baseICMS: "",
      valorICMS: "",
      baseICMSST: "",
      valorICMSST: "",
      totalServicos: "",
      totalProdutos: "",
      valorFrete: "",
      valorSeguro: "",
      outrasDespesas: "",
      valorIPI: "",
      valorISSQN: "",
      totalNota: "",
      desconto: "",
      valorFunrural: "",
      totalFaturado: "",
      nItens: "",
      totalAtributos: "",
    };
  },
  methods: {},
  directives: { money: VMoney }, //,    components: {}
};
</script>