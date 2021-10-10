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
        name="destinatario_nomeContato"
        v-model="form.destinatario_nomeContato"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Tipo da pessoa </label>
      <select
        class="form-control"
        name="destinatario_tipoPessoa"
        v-model="form.destinatario_tipoPessoa"
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
      v-show="form.destinatario_tipoPessoa == 'f'"
    >
      <label for="">CPF</label>
      <input
        type="text"
        class="form-control"
        maxlength="20"
        name="destinatario_cpf"
        v-model="form.destinatario_cpf"
      />
    </div>

    <div
      class="form-group col-md-3"
      v-show="form.destinatario_tipoPessoa == 'j'"
    >
      <label for="">CNPJ </label>
      <input
        type="text"
        class="form-control"
        maxlength="18"
        name="destinatario_cnpj"
        v-model="form.destinatario_cnpj"
      />
    </div>

    <div
      class="form-group col-md-3"
      v-show="form.destinatario_tipoPessoa == 'e'"
    >
      <label for="">País </label>
      <input
        type="text"
        class="form-control"
        maxlength="100"
        name="destinatario_pais"
        v-model="form.destinatario_pais"
      />
    </div>

    <div
      class="form-group col-md-3"
      v-show="form.destinatario_tipoPessoa == 'e'"
    >
      <label for="">Contribuinte </label>

      <select
        class="form-control"
        name="destinatario_contribuinte"
        v-model="form.destinatario_contribuinte"
        placeholder="Selecione..."
      >
        <option value="">Selecione...</option>
        <option :value="item.id" :key="key" v-for="(item, key) in contribuinte">
          {{ item.texto }}
        </option>
      </select>
    </div>

    <div class="form-group col-md-3">
   
      <label for="">Inscrição Estadual </label>
      <input
        type="text"
        class="form-control"
        maxlength="100"
        name="destinatario_inscricaoEstadual"
        v-model="form.destinatario_inscricaoEstadual"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="destinatario_consumidorFinal">Consumidor final </label>
      <input
        type="checkbox"
        class=""
        value="1"
        name="destinatario_consumidorFinal"
        id="destinatario_consumidorFinal"
        v-model="form.destinatario_consumidorFinal"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">CEP </label>
      <input
        type="text"
        class="form-control"
        maxlength="10"
        name="destinatario_cep"
        v-model="form.destinatario_cep"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">UF </label>

      <select
        class="form-control"
        name="destinatario_UF"
        v-model="form.destinatario_UF"
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
        name="destinatario_municipio"
        v-model="form.destinatario_municipio"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Bairro </label>
      <input
        type="text"
        class="form-control"
        maxlength="255"
        name="destinatario_bairro"
        v-model="form.destinatario_bairro"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Endereço </label>
      <input
        type="text"
        class="form-control"
        maxlength="255"
        name="destinatario_endereco"
        v-model="form.destinatario_endereco"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Número </label>
      <input
        type="text"
        class="form-control"
        maxlength="20"
        name="destinatario_numero"
        v-model="form.destinatario_numero"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Complemento </label>
      <input
        type="text"
        class="form-control"
        maxlength="255"
        name="destinatario_complemento"
        v-model="form.destinatario_complemento"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Fone/FAX </label>
      <input
        type="text"
        class="form-control"
        maxlength="15"
        name="destinatario_foneFax"
        v-model="form.destinatario_foneFax"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">E-mail </label>
      <input
        type="email"
        class="form-control"
        maxlength="255"
        name="destinatario_email"
        v-model="form.destinatario_email"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Vendedor </label>
      <input
        type="text"
        class="form-control"
        maxlength="255"
        name="destinatario_vendedor"
        v-model="form.destinatario_vendedor"
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
    /*
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
*/
  },
  methods: {}, //,    components: { Cabecalho,ListaContato,Conversa}
};
</script>