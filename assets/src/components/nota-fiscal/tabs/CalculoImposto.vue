<template>
  <div class="row col-12">
    <div class="col-12">
      <h5>Cálculo de imposto</h5>
    </div>

    <div class="form-group col-md-3">
      <label for="calculoimposto_calculoAutomatico"
        >Cálculo automático ligado
      </label>
      <input
        type="checkbox"
        class=""
        value="1"
        id="calculoimposto_calculoAutomatico"
        name="calculoimposto_calculoAutomatico"
        v-model="form.calculoimposto_calculoAutomatico"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Base ICMS</label> 
      <input
        type="text"
        class="form-control"
        name="calculoimposto_baseICMS"
        v-money="money"
        :readonly="form.calculoimposto_calculoAutomatico"
        v-model="form.calculoimposto_baseICMS"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Valor ICMS</label> 
      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto_calculoAutomatico"
        name="calculoimposto_valorICMS"
        v-model="form.calculoimposto_valorICMS"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Base ICMS ST</label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto_calculoAutomatico"
        name="calculoimposto_baseICMSST"
        v-model="form.calculoimposto_baseICMSST"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Valor ICMS ST</label> 
      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto_calculoAutomatico"
        name="calculoimposto_valorICMSST"
        v-model="form.calculoimposto_valorICMSST"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Total dos Serviços</label>

      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto_calculoAutomatico"
        name="calculoimposto_totalServicos"
        v-model="form.calculoimposto_totalServicos"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Total dos Produtos</label>

      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto_calculoAutomatico"
        name="calculoimposto_totalProdutos"
        v-model="form.calculoimposto_totalProdutos"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Valor do Frete</label>

      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto_calculoAutomatico"
        name="calculoimposto_valorFrete"
        v-model="form.calculoimposto_valorFrete"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Valor do Seguro</label>

      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto_calculoAutomatico"
        name="calculoimposto_valorSeguro"
        v-model="form.calculoimposto_valorSeguro"
      />
    </div>
    <div class="form-group col-md-3">
      <label for="">Outras Despesas</label>

      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto_calculoAutomatico"
        name="calculoimposto_outrasDespesas"
        v-model="form.calculoimposto_outrasDespesas"
      />
    </div>
    <div class="form-group col-md-3">
      <label for="">Valor IPI</label>

      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto_calculoAutomatico"
        name="calculoimposto_valorIPI"
        v-model="form.calculoimposto_valorIPI"
      />
    </div>
    <div class="form-group col-md-3">
      <label for="">Valor ISSQN</label>

      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto_calculoAutomatico"
        name="calculoimposto_valorISSQN"
        v-model="form.calculoimposto_valorISSQN"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Total da Nota</label>

      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto_calculoAutomatico"
        name="calculoimposto_totalNota"
        v-model="form.calculoimposto_totalNota"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Desconto</label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        name="calculoimposto_desconto"
        v-model="form.calculoimposto_desconto"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Valor Funrural</label>

      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto_calculoAutomatico"
        name="calculoimposto_valorFunrural"
        v-model="form.calculoimposto_valorFunrural"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Total Faturado</label>

      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto_calculoAutomatico"
        name="calculoimposto_totalFaturado"
        v-model="form.calculoimposto_totalFaturado"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Nº Itens</label>
      AUTO
      <input
        type="number"
        class="form-control"
        name="calculoimposto_nItens"
        v-model="form.calculoimposto_nItens"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Total A. Tributos </label>

      <input
        type="text"
        class="form-control"
        v-money="money"
        :readonly="form.calculoimposto_calculoAutomatico"
        name="calculoimposto_totalAtributos"
        v-model="form.calculoimposto_totalAtributos"
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