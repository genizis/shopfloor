<template>
  <div class="row mt-2">
    <div class="form-group col-md-4">
      <label for="">Quantidade </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.quantidade"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">Unidade </label>
      <input type="number" class="form-control" v-model="item.unidade" />
    </div>
    <!--
    <div class="form-group col-md-4">
      <label for="">Valor Unitário </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.valorUnitario"
      />
    </div>
-->
    <div class="form-group col-md-4">
      <label for="">Valor Total </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        readonly
        v-model="item.valorTotal"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">Valor Frete </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.valorFrete"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">Valor Desconto </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.valorDesconto"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">Tipo desconto</label>
      <select
        class="form-control"
        v-model="item.tipoDesconto"
        placeholder="Selecione..."
      >
        <option value="">Selecione...</option>
        <option
          :value="itemS.id"
          :key="key"
          v-for="(itemS, key) in tipoDesconto"
        >
          {{ itemS.texto }}
        </option>
      </select>
    </div>

    <div class="form-group col-md-4">
      <label for="">Natureza da Operacao </label>

        <select
        ref="buscaNatureza"
        name="FKIDNaturezaOperacao"
        v-model="item.FKIDNaturezaOperacao"
      >
        <option
          v-if="item.FKIDNaturezaOperacaoText != ''"
          :value="item.FKIDNaturezaOperacao"
        >
          {{ item.FKIDNaturezaOperacaoText }}
        </option>
      </select>

    </div>

    <div class="form-group col-md-4">
      <label for="">CFOP </label>
      <input type="number" class="form-control" v-model="item.CFOP" />
    </div>

    <div class="form-group col-md-4">
      <label for="">NCM </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.NCM"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">CEST </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.CEST"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">GTIN/EAN </label>
      <input type="number" class="form-control" v-model="item.GTINEAN" />
    </div>

    <div class="form-group col-md-4">
      <label for="">GTIN/EAN tributário </label>
      <input type="number" class="form-control" v-model="item.GTINEANTrib" />
    </div>

    <div class="form-group col-md-4">
      <label for="item.faturado">Faturado </label>
      <input type="checkbox" id="item.faturado" v-model="item.faturado" />
    </div>

    <div class="form-group col-md-12">
      <label for="">Informações adicionais </label>
      <input
        type="text"
        class="form-control"
        maxlength="255"
        v-model="item.informacoesComplementares"
      />
    </div>

    <div class="form-group col-md-12">
      <label for="">Informações complementares do item </label>
      <input
        type="text"
        class="form-control"
        maxlength="255"
        v-model="item.informacoesCompItem"
      />
    </div>

    <div class="form-group col-md-12">
      <label for=""
        >Informações adicionais de interesse do fisco do item
      </label>
      <input
        type="text"
        class="form-control"
        maxlength="255"
        v-model="item.informacoesCompIFItem"
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
      listaNatureza:[],
      tipoDesconto: [
        { id: "condicional", texto: "Condicional" },
        { id: "incondicional", texto: "Incondicional" },
      ],
    };
  },
  mounted() {
    var $this = this;
    $(function () {
      $($this.$refs.buscaNatureza).change(function (event) {
        $this.item.FKIDNaturezaOperacaoText = $this.textoSelect(this);
        $this.item.FKIDNaturezaOperacao = $(this).val();

      });

      $this.selectAjaxDinamico(
        $($this.$refs.buscaNatureza),
        "Buscar natureza da operacao...",
        "/ajax/busca-natureza-operacao-filtro",
        (item) => {
          $this.listaNatureza[item.id] = item;
          return {
            text: item.descricao,
            id: item.id,
          };
        }
      );

    });

    /*
    Vue.set(this.item, "quantidade", "");
    Vue.set(this.item, "unidade", "");
    Vue.set(this.item, "valorUnitario", "");
    Vue.set(this.item, "valorTotal", "");
    Vue.set(this.item, "valorFrete", "");
    Vue.set(this.item, "valorDesconto", "");
    Vue.set(this.item, "tipoDesconto", "");
    Vue.set(this.item, "FKIDNaturezaOperacao", "");
    Vue.set(this.item, "CFOP", "");
    Vue.set(this.item, "NCM", "");
    Vue.set(this.item, "CEST", "");
    Vue.set(this.item, "GTINEAN", "");
    Vue.set(this.item, "GTINEANTrib", "");
    Vue.set(this.item, "faturado", "");
    Vue.set(this.item, "informacoesComplementares", "");
    Vue.set(this.item, "informacoesCompItem", "");
    Vue.set(this.item, "informacoesCompIFItem", "");
    */
  },
  methods: {}, //,    components: {}
  directives: { money: VMoney },
};
</script>