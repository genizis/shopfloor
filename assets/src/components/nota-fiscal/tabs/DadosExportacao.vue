<template>
  <div class="row col-12" v-show="form.tipoSaida == 'exp'">
    <div class="col-12">
      <h5>Dados de Exportação</h5>
    </div>

    <div class="form-group col-md-9">
      <label for="">Local de Embarque </label>
      <input
        type="text"
        class="form-control"
        maxlength="255"
        name="exportacaoLocal"
        v-model="form.exportacaoLocal"
      />
    </div>

    <div class="form-group col-md-3">
      <label for="">UF de Embarque </label>
      <select
        class="form-control"
        name="exportacaoLocalUF"
        v-model="form.exportacaoLocalUF"
        placeholder="Selecione..."
      >
        <option value="">Selecione...</option>
        <option :value="item.uf" :key="key" v-for="(item, key) in estados">
          {{ item.nome }}
        </option>
      </select>
    </div>
  </div>
</template>

<script>
export default {
  props: ["form", "estados"],
  data() {
    return {};
  },
  mounted() {},
  methods: {}, //,    components: {}
};
</script>
