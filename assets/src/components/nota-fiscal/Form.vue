<template>
  <div class="modal-content">
    <!-- content -->

    <div class="modal-header">
      <!-- HEADER -->
      <h5 class="modal-title">{{ titulo }}</h5>
      <button
        type="button"
        class="close"
        aria-label="Close"
        v-on:click="$emit('close')"
      >
        <span aria-hidden="true">×</span>
      </button>
    </div>
    <!-- FIM HEADER -->

    <form
      method="POST"
      ref="formVinculo"
      @submit="cadastrarEditar"
      class="row modal-body"
      enctype="multipart/form-data"
    >
      <!-- BODY -->
      <div class="form-row col-12">
        <Geral :form="form" />
        <Destinatario :estados="estados" :form="form" />
        <ItensNota :money="money" :form="form" />
        <DadosExportacao :estados="estados" :form="form" />
        <CalculoImposto :money="money" :form="form" />
        <Retencoes :money="money" :form="form" />
        <TransportadorVolumes :estados="estados" :form="form" />
        <EnderecoEntrega :estados="estados" :form="form" />
        <Pagamento :money="money" :form="form" />
        <PessoasAutorizadasXML :form="form" />
        <Intermediador :form="form" />
        <InformacoesAdicionais :form="form" />
        <DocumentoReferenciado :form="form" />
      </div>
    </form>
    <!-- FIM BODY -->
    <div class="modal-footer col-12 text-right">
      <!-- FOOTER -->
      <button
        type="button"
        class="btn btn-primary"
        name="Opcao"
        value="salvar"
        @click="validarForm()"
      >
        <i class="fas fa-save"></i> Salvar
      </button>
      <a href="#" v-on:click="$emit('close')" class="btn btn-secondary"
        >Cancelar</a
      >
    </div>
    <!-- FIM FOOTER -->
  </div>
  <!-- FIM CONTENT -->
</template>

<script>
import Geral from "./tabs/Geral.vue";
import Destinatario from "./tabs/Destinatario.vue";
import DadosExportacao from "./tabs/DadosExportacao.vue";
import CalculoImposto from "./tabs/CalculoImposto.vue";
import Retencoes from "./tabs/Retencoes.vue";
import TransportadorVolumes from "./tabs/TransportadorVolumes.vue";
import EnderecoEntrega from "./tabs/EnderecoEntrega.vue";
import Pagamento from "./tabs/Pagamento/Pagamento.vue";
import PessoasAutorizadasXML from "./tabs/PessoasAutorizadasXML/PessoasAutorizadasXML.vue";
import Intermediador from "./tabs/Intermediador.vue";
import InformacoesAdicionais from "./tabs/InformacoesAdicionais.vue";
import DocumentoReferenciado from "./tabs/DocumentoReferenciado.vue";
import ItensNota from "./tabs/ItemNota/ItensNota.vue";

import { VMoney } from "v-money";

export default {
  props: ["titulo"],
  data() {
    return {
      money: {
        decimal: ".",
        thousands: "",
        prefix: "",
        suffix: "",
        precision: 2,
        masked: false /* doesn't work with directive */,
      },
      mostrar: false,
      estados: [],
      form: {
        destinatario: {},
        calculoimposto: {},
        retencoes: {},
        enderecoEntrega: {},
        transportador: {},
        pagamento: {},
        pessoasAutorizadas: {},
        intermediador: {},
        informacoesAdicionais: {},
        itensNota:{},
        documento: {},
        tipoSaida: "",
        serie: "",
        numero: "",
        loja: "",
        FKIDunidade: "",
        FKIDnaturezaOperacao: "",
        dataEmissao: "",
        horaEmissao: "",
        dataSaida: "",
        horaSaida: "",
        codigoRegimeTributario: "",
        finalidade: "",
        indicadorPresenca: "",
        exportacaoLocalUF: "",
        exportacaoLocal: "",
      },
    };
  },
  mounted() {
    axios
      .get("/ajax/busca-estado") //Buscar estados
      .then((response) => {
        this.estados = response.data;
      });
  },
  methods: {
    cadastrarEditar() {},
  },
  components: {
    Geral,
    Destinatario,
    DadosExportacao,
    CalculoImposto,
    Retencoes,
    TransportadorVolumes,
    EnderecoEntrega,
    Pagamento,
    PessoasAutorizadasXML,
    Intermediador,
    InformacoesAdicionais,
    DocumentoReferenciado,
    ItensNota,
  },
  directives: { money: VMoney },
};
</script>
