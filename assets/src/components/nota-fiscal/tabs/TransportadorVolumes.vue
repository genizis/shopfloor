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
        name="transportador.nome"
        v-model="form.transportador.nome"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Frete por conta </label>
      <select
        class="form-control"
        name="transportador.freteConta"
        v-model="form.transportador.freteConta"
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
        name="transportador.placaVeiculo"
        v-model="form.transportador.placaVeiculo"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">UF veículo </label>

      <select
        class="form-control"
        name="transportador.UFveiculo"
        v-model="form.transportador.UFveiculo"
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
        name="transportador.RNTC"
        v-model="form.transportador.RNTC"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">CNPJ/CPF </label>
      <input
        type="text"
        class="form-control"
        maxlength="15"
        name="transportador.CNPJCPF"
        v-model="form.transportador.CNPJCPF"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Inscrição Estadual </label>
      <input
        type="text"
        class="form-control"
        maxlength="100"
        name="transportador.inscricaoEstadual"
        v-model="form.transportador.inscricaoEstadual"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">UF </label>

      <select
        class="form-control"
        name="transportador.UF"
        v-model="form.transportador.UF"
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
        name="transportador.municipio"
        v-model="form.transportador.municipio"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Endereço </label>
      <input
        type="text"
        class="form-control"
        maxlength="255"
        name="transportador.endereco"
        v-model="form.transportador.endereco"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Quantidade </label>
      <input
        type="number"
        class="form-control"
        name="transportador.quantidade"
        v-model="form.transportador.quantidade"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Espécie </label>
      <input
        type="text"
        class="form-control"
        maxlength="100"
        name="transportador.especie"
        v-model="form.transportador.especie"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Marca </label>
      <input
        type="text"
        class="form-control"
        maxlength="100"
        name="transportador.marca"
        v-model="form.transportador.marca"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Número </label>
      <input
        type="text"
        class="form-control"
        name="transportador.numero"
        v-model="form.transportador.numero"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Peso Bruto </label>
      <input
        type="text"
        class="form-control"
         maxlength="10"
        name="transportador.presoBruto"
        v-model="form.transportador.presoBruto"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Peso Líquido </label>
      <input
        type="text"
        class="form-control"
        maxlength="10"
        name="transportador.pesoLiquido"
        v-model="form.transportador.pesoLiquido"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Logística </label>
      <input
        type="text"
        class="form-control"
         maxlength="100"
        name="transportador.logistica"
        v-model="form.transportador.logistica"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="transportador.enderecoEntregaDiferente">Endereço de entrega diferente da cobrança </label>
      <input
        type="checkbox"
        class=""
        value="1"
        id="transportador.enderecoEntregaDiferente"
        name="transportador.enderecoEntregaDiferente"
        v-model="form.transportador.enderecoEntregaDiferente"
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
  },
  methods: {}, //,    components: {}
};
</script>