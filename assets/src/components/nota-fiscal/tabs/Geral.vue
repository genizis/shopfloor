<template>
  <div class="row col-12">
    <div class="form-group col-md-4">
      <label for="">Tipo de Saída <span class="text-danger">*</span></label>

      <select
        class="form-control"
        name="tipoSaida"
        v-model="form.tipoSaida"
        placeholder="Selecione..."
      >
        <option value="">Selecione...</option>
        <option :value="item.id" :key="key" v-for="(item, key) in tipoSaida">
          {{ item.texto }}
        </option>
      </select>
    </div>

    <div class="form-group col-md-3">
      <label for="">Serie </label>
      <input
        type="text"
        class="form-control"
        maxlength="200"
        name="serie"
        v-model="form.serie"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Numero </label>
      <input
        type="text"
        class="form-control"
        maxlength="200"
        name="numero"
        v-model="form.numero"
      />
    </div>

    <div class="form-group col-md-2">
      <label for="">Loja </label>
      <input
        type="text"
        class="form-control"
        maxlength="200"
        name="loja"
        v-model="form.loja"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Unidade de negócio </label>
      <input
        type="text"
        class="form-control"
        maxlength="200"
        name="FKIDunidade"
        v-model="form.FKIDunidade"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">Natureza de operação</label>

      <select
        ref="buscaNatureza"
        name="FKIDnaturezaOperacao"
        v-model="form.FKIDnaturezaOperacao"
      >
        <option
          v-if="form.FKIDnaturezaOperacaoText != ''"
          :value="form.FKIDnaturezaOperacao"
        >
          {{ form.FKIDnaturezaOperacaoText }}
        </option>
      </select>
    </div>

    <div class="form-group col-md-2">
      <label for="">Data de emissão </label>
      <input
        type="date"
        class="form-control"
        maxlength="200"
        name="dataEmissao"
        v-model="form.dataEmissao"
      />
    </div>

    <div class="form-group col-md-2">
      <label for="">Hora de emissão </label>
      <input
        type="time"
        class="form-control"
        name="horaEmissao"
        v-model="form.horaEmissao"
      />
    </div>

    <div class="form-group col-md-2">
      <label for="">Data saída </label>
      <input
        type="date"
        class="form-control"
        name="dataSaida"
        v-model="form.dataSaida"
      />
    </div>

    <div class="form-group col-md-2">
      <label for="">Hora saída </label>
      <input
        type="time"
        class="form-control"
        maxlength="200"
        name="horaSaida"
        v-model="form.horaSaida"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Código do regime tributário </label>

      <select
        class="form-control"
        name="codigoRegimeTributario"
        required=""
        v-model="form.codigoRegimeTributario"
        placeholder="Selecione..."
      >
        <option value="">Selecione...</option>
        <option
          :value="item.id"
          :key="key"
          v-for="(item, key) in codigoRegimeTributario"
        >
          {{ item.texto }}
        </option>
      </select>
    </div>

    <div class="form-group col-md-3">
      <label for="">Finalidade </label>

      <select
        class="form-control"
        name="finalidade"
        required=""
        v-model="form.finalidade"
        placeholder="Selecione..."
      >
        <option value="">Selecione...</option>
        <option :value="item.id" :key="key" v-for="(item, key) in finalidade">
          {{ item.texto }}
        </option>
      </select>
    </div>

    <div class="form-group col-md-3">
      <label for="">Indicador de presença </label>
      <select
        class="form-control"
        name="indicadorPresenca"
        required=""
        v-model="form.indicadorPresenca"
        placeholder="Selecione..."
      >
        <option value="">Selecione...</option>
        <option
          :value="item.id"
          :key="key"
          v-for="(item, key) in indicadorPresenca"
        >
          {{ item.texto }}
        </option>
      </select>
    </div>
  </div>
</template>

<script>
export default {
  props: ["form"],
  data() {
    return {
      listaNatureza: [],
      tipoSaida: [
        { id: "exp", texto: "Exportação" },
        { id: "imp", texto: "Importação de XML" },
        { id: "nfce", texto: "NFCe" },
      ],
      codigoRegimeTributario: [
        { id: 1, texto: "Simples nacional" },
        {
          id: 2,
          texto: "Simples nacional - Excesso de sublimite de receita bruta",
        },
        { id: 3, texto: "Regime normal" },
      ],
      finalidade: [
        { id: 1, texto: "NF-e normal" },
        { id: 2, texto: "NF-e complementar" },
        { id: 3, texto: "NF-e de ajuste" },
        { id: 4, texto: "Devolução de mercadoria" },
      ],
      indicadorPresenca: [
        { id: 0, texto: "Não se aplica" },
        { id: 1, texto: "Operação presencial" },
        { id: 2, texto: "Operação não presencial, pela Internet " },
        { id: 3, texto: "Operação não presencial, Teleatendimento" },
        { id: 4, texto: "NFC-e em operação com entrega em domicílio" },
        { id: 5, texto: "Operação presencial, fora do estabelecimento" },
        { id: 9, texto: "Operação não presencial, outros" },
      ],
    };
  },
  mounted() {
    var $this = this;
    $(function () {
      $($this.$refs.buscaNatureza).change(function (event) {
        $this.form.FKIDnaturezaOperacaoText = $this.textoSelect(this);
        $this.form.FKIDnaturezaOperacao = $(this).val();

        $this.buscarNaturezaOperacao();
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
  },
  methods: {
    buscarNaturezaOperacao() {
      const item = this.listaNatureza[this.form.FKIDnaturezaOperacao];

      Vue.set(
        this.form,
        "informacoesAdicionais_informacoesComplementaresFiscoNatureza",
        item.InformacoesAdicionais
      );
      Vue.set(
        this.form,
        "informacoesAdicionais_informacoesComplementaresNatureza",
        item.InformacoesComplementares
      );
    },
  }, //,    components: {}
};
</script>