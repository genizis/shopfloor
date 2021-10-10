<template>
  <div class="row col-12">
    <div class="col-12">
      <h5>Informações adicionais</h5>
    </div>

    <div class="form-group col-md-3">
      <label for="">Número loja virtual</label>
      <input
        type="text"
        maxlength="255"
        class="form-control"
        name="informacoesAdicionais_numeroLojaVirtual"
        v-model="form.informacoesAdicionais_numeroLojaVirtual"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Origem loja virtual </label>
      <input
        type="text"
        maxlength="255"
        class="form-control"
        name="informacoesAdicionais_origemLojaVirtual"
        v-model="form.informacoesAdicionais_origemLojaVirtual"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Origem Canal Venda </label>
      <input
        type="text"
        maxlength="255"
        class="form-control"
        name="informacoesAdicionais_origemCanalVenda"
        v-model="form.informacoesAdicionais_origemCanalVenda"
      />
    </div>

    <div class="form-group col-md-12">
      <label for="">Informações complementares </label>
      <textarea
        type="text"
        class="form-control"
        name="informacoesAdicionais_informacoesComplementares"
        v-model="form.informacoesAdicionais_informacoesComplementares"
      >
      </textarea>
    </div>

    <div class="form-group col-md-12">
      <label for="">Informações complementares (natureza) </label>
      <textarea
        type="text"
        class="form-control"
        readonly
        name="informacoesAdicionais_informacoesComplementaresNatureza"
        v-model="form.informacoesAdicionais_informacoesComplementaresNatureza"
      >
      </textarea>
    </div>

    <div class="form-group col-md-12">
      <label for=""
        >Informações adicionais de interesse do fisco (natureza)</label
      >
      <textarea
        type="text"
        class="form-control"
        readonly
        name="informacoesAdicionais_informacoesComplementaresFiscoNatureza"
        v-model="
          form.informacoesAdicionais_informacoesComplementaresFiscoNatureza
        "
      >
      </textarea>
    </div>
  </div>
</template>

<script>
export default {
  props: ["form"],
  data() {
    return {};
  },
  mounted() {
    this.form.informacoesAdicionais = {
      numeroLojaVirtual: "",
      origemLojaVirtual: "",
      origemCanalVenda: "",
      informacoesComplementares: "",
      informacoesComplementaresNatureza: "",
      informacoesComplementaresFiscoNatureza: "",
    };
  },
  methods: {}, //,    components: {}
};
</script>