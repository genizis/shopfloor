<template>
  <div class="row col-12">
    <div class="col-12">
      <h5>Documento referenciado</h5>
    </div>

    <div class="form-group col-md-3">
      <label for="">Tipo </label>
      <select
        class="form-control"
        name="documento_tipo"
        v-model="form.documento_tipo"
        placeholder="Selecione..."
      >
        <option value="">Selecione...</option>
        <option :value="item.id" :key="key" v-for="(item, key) in tipo">
          {{ item.id + " - " + item.texto }}
        </option>
      </select>
    </div>

    <div class="form-group col-md-3" v-if="mulSeText(form.documento_tipo,['55','57'])">
      <label for="">Chave de acesso</label>
      <input
        type="text"
        maxlength="255"
        class="form-control"
        name="documento_chaveAcesso"
        v-model="form.documento_chaveAcesso"
      />
    
    </div>

    <div class="form-group col-md-3" v-if="mulSeText(form.documento_tipo,['2D'])">
      <label for="">Número do Contador de Ordem de Operação - COO</label>
      <input
        type="text"
        maxlength="255"
        class="form-control"
        name="documento_numeroContador"
        v-model="form.documento_numeroContador"
      />

    </div>

    <div class="form-group col-md-3" v-if="mulSeText(form.documento_tipo,['1', '2', 'R1', '4'])">
      <label for="">Ano e mês de emissão</label>
      <input
        type="text"
        maxlength="255"
        class="form-control"
        name="documento_anoMesEmissao"
        v-model="form.documento_anoMesEmissao"
      />
    </div>

    <div class="form-group col-md-3" v-if="mulSeText(form.documento_tipo,['1', '2', 'R1', '4'])">
      <label for="">Número</label>
      <input
        type="text"
        maxlength="255"
        class="form-control"
        name="documento_numero"
        v-model="form.documento_numero"
      />

    </div>

    <div class="form-group col-md-3" v-if="mulSeText(form.documento_tipo,['1', '2', 'R1', '4'])">
      <label for="">Série</label>
      <input
        type="text"
        maxlength="255"
        class="form-control"
        name="documento_serie"
        v-model="form.documento_serie"
      />

    </div>
  </div>
</template>

<script>
export default {
  props: ["form"],
  data() {
    return {
      tipo: [
        { id: "", texto: "Nenhum" },
        { id: "55", texto: "NF-e ou NFC-e (modelos 55 e 65)" },
        { id: "2D", texto: "Cupom fiscal (ECF - modelo 2D)" },
        { id: "1", texto: "Nota fiscal (talão - modelo 01)" },
        { id: "2", texto: "Nota fiscal de consumidor (talão - modelo 02)" },
        { id: "R1", texto: "Nota fiscal de produtor (talão - modelo 01)" },
        { id: "4", texto: "Nota fiscal de produtor (talão - modelo 04)" },
        { id: "57", texto: "CT-e (modelo 57)" },
      ],
    };
  },
  mounted() {
    this.form.documento = {
      tipo: "",
      chaveAcesso: "",
      numeroContador: "",
      anoMesEmissao: "",
      numero: "",
      serie: "",
    }
  },
  methods: {}, //,    components: {}
};
</script>