<template>
  <div class="row col-12">
    <div class="col-12">
      <h5>Transportador/Volumes</h5>
    </div>

    <div class="form-group col-md-3">
      <label for="">Nome </label>
      <input
        type="text"
        class="form-control"
        maxlength="255"
        name="transportador_nome"
        v-model="form.transportador_nome"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Frete por conta </label>
      <select
        class="form-control"
        name="transportador_freteConta"
        v-model="form.transportador_freteConta"
        placeholder="Selecione..."
      >
        <option value="">Selecione...</option>
        <option :value="item.id" :key="key" v-for="(item, key) in freteConta">
          {{ item.id + " - " + item.texto }}
        </option>
      </select>
    </div>

    <div class="form-group col-md-3">
      <label for="">Placa veículo </label>
      <input
        type="text"
        class="form-control"
        maxlength="10"
        name="transportador_placaVeiculo"
        v-model="form.transportador_placaVeiculo"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">UF veículo </label>

      <select
        class="form-control"
        name="transportador_UFveiculo"
        v-model="form.transportador_UFveiculo"
        placeholder="Selecione..."
      >
        <option value="">Selecione...</option>
        <option :value="item.uf" :key="key" v-for="(item, key) in estados">
          {{ item.nome }}
        </option>
      </select>
    </div>

    <div class="form-group col-md-3">
      <label for="">RNTC </label>
      <input
        type="text"
        class="form-control"
        maxlength="50"
        name="transportador_RNTC"
        v-model="form.transportador_RNTC"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">CNPJ/CPF </label>
      <input
        type="text"
        class="form-control"
        maxlength="15"
        name="transportador_CNPJCPF"
        v-model="form.transportador_CNPJCPF"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Inscrição Estadual </label>
      <input
        type="text"
        class="form-control"
        maxlength="100"
        name="transportador_inscricaoEstadual"
        v-model="form.transportador_inscricaoEstadual"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">UF </label>

      <select
        class="form-control"
        name="transportador_UF"
        v-model="form.transportador_UF"
        placeholder="Selecione..."
      >
        <option value="">Selecione...</option>
        <option :value="item.uf" :key="key" v-for="(item, key) in estados">
          {{ item.nome }}
        </option>
      </select>
    </div>

    <div class="form-group col-md-3">
      <label for="">Município </label>
      <input
        type="text"
        class="form-control"
        maxlength="255"
        name="transportador_municipio"
        v-model="form.transportador_municipio"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Endereço </label>
      <input
        type="text"
        class="form-control"
        maxlength="255"
        name="transportador_endereco"
        v-model="form.transportador_endereco"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Quantidade </label>
      <input
        type="number"
        class="form-control"
        name="transportador_quantidade"
        v-model="form.transportador_quantidade"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Espécie </label>
      <input
        type="text"
        class="form-control"
        maxlength="100"
        name="transportador_especie"
        v-model="form.transportador_especie"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Marca </label>
      <input
        type="text"
        class="form-control"
        maxlength="100"
        name="transportador_marca"
        v-model="form.transportador_marca"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Número </label>
      <input
        type="text"
        class="form-control"
        name="transportador_numero"
        v-model="form.transportador_numero"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Peso Bruto </label>
      <input
        type="text"
        class="form-control"
         maxlength="10"
        name="transportador_presoBruto"
        v-model="form.transportador_presoBruto"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Peso Líquido </label>
      <input
        type="text"
        class="form-control"
        maxlength="10"
        name="transportador_pesoLiquido"
        v-model="form.transportador_pesoLiquido"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Logística </label>
      <input
        type="text"
        class="form-control"
         maxlength="100"
        name="transportador_logistica"
        v-model="form.transportador_logistica"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="transportador_enderecoEntregaDiferente">Endereço de entrega diferente da cobrança </label>
      <input
        type="checkbox"
        class=""
        value="1"
        id="transportador_enderecoEntregaDiferente"
        name="transportador_enderecoEntregaDiferente"
        v-model="form.transportador_enderecoEntregaDiferente"
      />
    </div>
  </div>
</template>

<script>
export default {
  props: ["form", "estados"],
  data() {
    return {
      freteConta: [
        { id: 0, texto: "Contratação do Frete por conta do Remetente (CIF)" },
        {
          id: 1,
          texto: "Contratação do Frete por conta do Destinatário (FOB)",
        },
        { id: 2, texto: "Contratação do Frete por conta de Terceiros" },
        { id: 3, texto: "Transporte Próprio por conta do Remetente" },
        { id: 4, texto: "Transporte Próprio por conta do Destinatário" },
        { id: 9, texto: "Sem Ocorrência de Transporte" },
      ],
    };
  },
  mounted() {
    /*
    this.form.transportador = {
      nome: "",
      freteConta: "",
      placaVeiculo: "",
      UFveiculo: "",
      RNTC: "",
      CNPJCPF: "",
      inscricaoEstadual: "",
      UF: "",
      municipio: "",
      endereco: "",
      quantidade: "",
      especie: "",
      marca: "",
      numero: "",
      presoBruto: "",
      pesoLiquido: "",
      logistica: "",
      enderecoEntregaDiferente: false,
    };
    */
  },
  methods: {}, //,    components: {}
};
</script>