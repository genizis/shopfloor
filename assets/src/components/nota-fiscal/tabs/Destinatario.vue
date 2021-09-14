<template>
  <div class="row col-12">
    <div class="col-12">
      <h5>Destinatário</h5>
    </div>

    <div class="form-group col-md-3">
      <label for="">Nome do contato </label>
      <input
        type="text"
        class="form-control"
        maxlength="255"
        name="destinatario.nomeContato"
        v-model="form.destinatario.nomeContato"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Tipo da pessoa </label>
      <select
        class="form-control"
        name="destinatario.tipoPessoa"
        v-model="form.destinatario.tipoPessoa"
        placeholder="Selecione..."
      >
        <option value="">Selecione...</option>
        <option :value="item.id" :key="key" v-for="(item, key) in tipoPessoa">
          {{ item.texto }}
        </option>
      </select>
    </div>

    <div
      class="form-group col-md-3"
      v-show="form.destinatario.tipoPessoa == 'f'"
    >
      <label for="">CPF MASKCPF</label>
      <input
        type="text"
        class="form-control"
        maxlength="20"
        name="destinatario.cpf"
        v-model="form.destinatario.cpf"
      />
    </div>

    <div
      class="form-group col-md-3"
      v-show="form.destinatario.tipoPessoa == 'j'"
    >
      <label for="">CNPJ </label>
      <input
        type="text"
        class="form-control"
        maxlength="18"
        name="destinatario.cnpj"
        v-model="form.destinatario.cnpj"
      />
    </div>

    <div
      class="form-group col-md-3"
      v-show="form.destinatario.tipoPessoa == 'e'"
    >
      <label for="">País </label>
      <input
        type="text"
        class="form-control"
        maxlength="100"
        name="destinatario.pais"
        v-model="form.destinatario.pais"
      />
    </div>

    <div
      class="form-group col-md-3"
      v-show="form.destinatario.tipoPessoa == 'e'"
    >
      <label for="">Contribuinte </label>

      <select
        class="form-control"
        name="destinatario.contribuinte"
        v-model="form.destinatario.contribuinte"
        placeholder="Selecione..."
      >
        <option value="">Selecione...</option>
        <option :value="item.id" :key="key" v-for="(item, key) in contribuinte">
          {{ item.texto }}
        </option>
      </select>
    </div>

    <div class="form-group col-md-3">
      Contribuinte = 2 valor “ISENTO”
      <label for="">Inscrição Estadual </label>
      <input
        type="text"
        class="form-control"
        maxlength="100"
        name="destinatario.inscricaoEstadual"
        v-model="form.destinatario.inscricaoEstadual"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="destinatario.consumidorFinal">Consumidor final </label>
      <input
        type="checkbox"
        class=""
        value="1"
        name="destinatario.consumidorFinal"
        id="destinatario.consumidorFinal"
        v-model="form.destinatario.consumidorFinal"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">CEP </label> Buscar endereço pelo CEP
      <input
        type="text"
        class="form-control"
        maxlength="10"
        name="destinatario.cep"
        v-model="form.destinatario.cep"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">UF </label>

      <select
        class="form-control"
        name="destinatario.UF"
        v-model="form.destinatario.UF"
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
        name="destinatario.municipio"
        v-model="form.destinatario.municipio"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Bairro </label>
      <input
        type="text"
        class="form-control"
        maxlength="255"
        name="destinatario.bairro"
        v-model="form.destinatario.bairro"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Endereço </label>
      <input
        type="text"
        class="form-control"
        maxlength="255"
        name="destinatario.endereco"
        v-model="form.destinatario.endereco"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Número </label>
      <input
        type="text"
        class="form-control"
        maxlength="20"
        name="destinatario.numero"
        v-model="form.destinatario.numero"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Complemento </label>
      <input
        type="text"
        class="form-control"
        maxlength="255"
        name="destinatario.complemento"
        v-model="form.destinatario.complemento"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Fone/FAX </label>
      <input
        type="text"
        class="form-control"
        maxlength="15"
        name="destinatario.foneFax"
        v-model="form.destinatario.foneFax"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">E-mail </label>
      <input
        type="email"
        class="form-control"
        maxlength="255"
        name="destinatario.email"
        v-model="form.destinatario.email"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Vendedor </label> FKIDVendedor
      <input
        type="text"
        class="form-control"
        maxlength="255"
        name="destinatario.vendedor"
        v-model="form.destinatario.vendedor"
      />
    </div>
  </div>
</template>

<script>
export default {
  props: ["form", "estados"],
  data() {
    return {
      tipoPessoa: [
        { id: "j", texto: "Jurídica" },
        { id: "f", texto: "Física" },
        { id: "e", texto: "Estrangeiro" },
      ],
      contribuinte: [
        { id: 1, texto: "Contribuinte ICMS" },
        {
          id: 2,
          texto:
            "Contribuinte isento de Inscrição no Cadastro de Contribuintes",
        },
        {
          id: 9,
          texto:
            "Não contribuinte, que pode ou não possuir Inscrição Estadual no Cadastro de Contribuintes",
        },
      ],
    };
  },
  mounted() {
    this.form.destinatario = {
      nomeContato: "",
      tipoPessoa: "",
      cpf: "",
      cnpj: "",
      pais: "",
      contribuinte: "",
      inscricaoEstadual: "",
      consumidorFinal: "",
      cep: "",
      UF: "",
      municipio: "",
      bairro: "",
      endereco: "",
      numero: "",
      complemento: "",
      foneFax: "",
      email: "",
      vendedor: "",
    };
  },
  methods: {}, //,    components: { Cabecalho,ListaContato,Conversa}
};
</script>