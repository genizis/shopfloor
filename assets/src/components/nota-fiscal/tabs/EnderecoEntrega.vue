<template>
  <div class="row col-12" v-show="form.transportador_enderecoEntregaDiferente==1">
    <div class="col-12">
      <h5>Endereço de entrega</h5>
    </div>

    <div class="form-group col-md-3">
      <label for="">Nome </label>
      <input
        type="text"
        class="form-control"
        name="enderecoEntrega_nome"
        v-model="form.enderecoEntrega_nome"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">CEP </label>
      <input
        type="text"
        maxlength="10"
        class="form-control"
        name="enderecoEntrega_cep"
        v-model="form.enderecoEntrega_cep"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">UF </label>

      <select
        class="form-control"
        name="enderecoEntrega_UF"
        v-model="form.enderecoEntrega_UF"
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
        maxlength="255"
        class="form-control"
        name="enderecoEntrega_municipio"
        v-model="form.enderecoEntrega_municipio"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Endereço </label>
      <input
        type="text"
        maxlength="255"
        class="form-control"
        name="enderecoEntrega_endereco"
        v-model="form.enderecoEntrega_endereco"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Número </label>
      <input
        type="text"
        maxlength="50"
        class="form-control"
        name="enderecoEntrega_numero"
        v-model="form.enderecoEntrega_numero"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Bairro </label>
      <input
        type="text"
        maxlength="255"
        class="form-control"
        name="enderecoEntrega_bairro"
        v-model="form.enderecoEntrega_bairro"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">Complemento </label>
      <input
        type="text"
        maxlength="255"
        class="form-control"
        name="enderecoEntrega_complemento"
        v-model="form.enderecoEntrega_complemento"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">País </label>
      <input
        type="text"
        maxlength="255"
        class="form-control"
        name="enderecoEntrega_pais"
        v-model="form.enderecoEntrega_pais"
      />
    </div>
  </div>
</template>

<script>
export default {
  props: ["form", "estados"],
  data() {
    return {};
  },
  mounted() {
    this.form.enderecoEntrega = {
      nome: "",
      cep: "",
      UF: "",
      municipio: "",
      endereco: "",
      numero: "",
      bairro: "",
      complemento: "",
      pais: "",
    };
  },
  methods: {}, //components: {}
};
</script>