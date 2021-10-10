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
      <div class="form-row col-12" v-if="mostrar">
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

      <!-- FIM BODY -->
      <div class="modal-footer col-12 text-right">
        <!-- FOOTER -->
        <button
          type="submit"
          class="btn btn-primary"
          name="Opcao"
          value="salvar"
        >
          <i class="fas fa-save"></i> Salvar
        </button>
        <a href="#" v-on:click="$emit('close')" class="btn btn-secondary"
          >Cancelar</a
        >
      </div>
    </form>
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
  props: ["titulo", "idfaturamento"],
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
      status: "",
      mostrar: false,
      estados: [],
      form: {
        destinatario: {},
        calculoimposto: {},
        retencoes: {},
        enderecoEntrega: {},
        transportador: {},
        pagamentoItens: {},
        pessoasAutorizadas: {},
        intermediador: {},
        informacoesAdicionais: {},
        itensNota: {},
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
    this.form.itensNota = [];

    axios
      .get("/nota-fiscal/api/lista-faturamento?id=" + this.idfaturamento) //Buscar nota fiscal pelo idfaturamento
      .then((response) => {
        var data = response.data;
        for (var chave in data) {
          Vue.set(this.form, chave, data[chave]);
        }
        if(data==null){
          this.buscarProdutosFaturamento()
        }
        this.mostrar = true;
      });

    /*
   
      */
  },
  methods: {
    buscarProdutosFaturamento() {
      axios
        .get("/nota-fiscal/api/produtos-faturamento?id=" + this.idfaturamento) //Buscar estados
        .then((response) => {
          let objetos = response.data;
          for (let index = 0; index < objetos.length; index++) {
            const element = objetos[index];
            this.form.itensNota.push({
              codigo: element["cod_produto"],
              descricao: element["nome_produto"],
            });
          }
        });
    },
    cadastrarEditar(e) {
      e.preventDefault();

      var $this = this;
      var alerta = alertify
        .alert(
          '<div class="text-center">Enviando informações... <br>' +
            '<i class="fa fa-refresh fa-spin fa-3x fa-fw"></i><br> Aguarde... </div>'
        )
        .set("closable", false)
        .set("basic", true);
      var $this = this;
      let formData = new FormData(this.$refs.formVinculo);
      if ($this.form.id) formData.append("id", $this.form.id);

      formData.append("FKIDfaturamentoPedido", $this.idfaturamento);
      //Id para editar
      $.each(this.form, function (index, valorCampo) {
        if (!(valorCampo instanceof Object)) {
          formData.append(index, $this.valorInput(valorCampo));
        }
      });

      if (this.form.pagamentoItens != null)
        $.each(this.form.pagamentoItens, function (index, regra) {
          var nome = "pagamento_itens[" + index + "]";
          $this.getFormData(formData, regra, nome);
        });

      if (this.form.pessoasAutorizadas != null)
        $.each(this.form.pessoasAutorizadas, function (index, regra) {
          var nome = "pessoas_autorizadas[" + index + "]";
          $this.getFormData(formData, regra, nome);
        });

      if (this.form.itensNota != null)
        $.each(this.form.itensNota, function (index, regra) {
          var nome = "itens_nota[" + index + "]";
          $this.getFormData(formData, regra, nome);
        });

      var url = "/nota-fiscal/nova";

      axios
        .post(url, formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          //console.log(response.data);
          if (response.data.resultado) {
            $this.$emit("close");
            alertify.success("Salvo com sucesso");
            alertify.closeAll();
            //Vue.set(this.status, "sucesso", response.data.msg);
            //$this.funcaocallback();
            // window.location = "/natureza-operacao/editar/" + response.data.id;
          } else {
            alertify.error("Erro ao salvar");
            //Vue.set(this.status, "erro", response.data.msg);
          }
          alertify.closeAll();
        })
        .catch((error) => this.catchErro(error, this.status));
    },
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
