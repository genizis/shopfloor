<template>
  <div class="row">
    <div class="form-group col-md-4">
      <label for=""> Situação tributária do IPI </label>
      <select
        class="form-control"
        v-model="item.ipi.situacaoTributaria"
        placeholder="Selecione..."
      >
        <option value="">Selecione...</option>
        <option
          :value="itemS.id"
          :key="key"
          v-for="(itemS, key) in situacaoTributaria"
        >
          {{ (itemS.id!=''?itemS.id+' - ':'')+itemS.texto }}
        </option>
      </select>
    </div>

    <div class="form-group col-md-4">
      <label for="">Alíq. IPI </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.ipi.aliqIPI"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">% Base IPI </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.ipi.baseIPI"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">Valor Base IPI </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.ipi.valorBaseIPI"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">Valor IPI </label>
      <input
        type="text"
        class="form-control"
        v-money="money"
        v-model="item.ipi.valorIPI"
      />
    </div>

    <div class="form-group col-md-4">
      <label for="">Cód Enquad. IPI </label>
      <select
        class="form-control"
        v-model="item.ipi.codEnquad"
        placeholder="Selecione..."
      >
        <option value="">Selecione...</option>
        <option :value="itemS.id" :key="key" v-for="(itemS, key) in codEnquad">
          {{ itemS.id }}
        </option>
      </select>
    </div>

    <div class="form-group col-md-4">
      <label for="">Código exceção da TIPI </label>
      <input type="text" class="form-control" v-model="item.ipi.codExcecaoTIPI" />
    </div>

    <div class="form-group col-md-12">
      <label for="">Informações complementares do IPI </label>
      <input type="text" class="form-control" v-model="item.ipi.informacoesComp" />
    </div>

    <div class="form-group col-md-12">
      <label for="">Informações adicionais de interesse do fisco do IPI </label>
      <input
        type="text"
        class="form-control"
        v-model="item.ipi.informacoesCompIF"
      />
    </div>
  </div>
</template>
<script>
import { VMoney } from "v-money";

export default {
  props: ["item", "money"],
  data() {
    return {
      situacaoTributaria: [
        { id: "", texto: "sem IPI" },
        { id: "50", texto: "Saída tributada" },
        { id: "51", texto: "Saída tributada com alíquota zero" },
        { id: "52", texto: "Saída isenta" },
        { id: "53", texto: "Saída não-tributada" },
        { id: "54", texto: "Saída imune" },
        { id: "55", texto: "Saída com suspensão" },
        { id: "99", texto: "Outras saídas" },
      ],
      codEnquad: [
        { id: "999" },
        { id: "1" },
        { id: "2" },
        { id: "3" },
        { id: "4" },
        { id: "5" },
        { id: "6" },
        { id: "7" },
        { id: "101" },
        { id: "102" },
        { id: "103" },
        { id: "104" },
        { id: "105" },
        { id: "106" },
        { id: "107" },
        { id: "108" },
        { id: "109" },
        { id: "110" },
        { id: "111" },
        { id: "112" },
        { id: "113" },
        { id: "114" },
        { id: "115" },
        { id: "116" },
        { id: "117" },
        { id: "118" },
        { id: "119" },
        { id: "120" },
        { id: "121" },
        { id: "122" },
        { id: "123" },
        { id: "124" },
        { id: "125" },
        { id: "126" },
        { id: "127" },
        { id: "128" },
        { id: "129" },
        { id: "130" },
        { id: "131" },
        { id: "132" },
        { id: "133" },
        { id: "134" },
        { id: "135" },
        { id: "136" },
        { id: "137" },
        { id: "138" },
        { id: "139" },
        { id: "140" },
        { id: "141" },
        { id: "142" },
        { id: "143" },
        { id: "144" },
        { id: "145" },
        { id: "146" },
        { id: "147" },
        { id: "148" },
        { id: "149" },
        { id: "150" },
        { id: "151" },
        { id: "152" },
        { id: "153" },
        { id: "154" },
        { id: "155" },
        { id: "156" },
        { id: "157" },
        { id: "158" },
        { id: "159" },
        { id: "160" },
        { id: "161" },
        { id: "162" },
        { id: "163" },
        { id: "164" },
        { id: "165" },
        { id: "301" },
        { id: "302" },
        { id: "303" },
        { id: "304" },
        { id: "305" },
        { id: "306" },
        { id: "307" },
        { id: "308" },
        { id: "309" },
        { id: "310" },
        { id: "311" },
        { id: "312" },
        { id: "313" },
        { id: "314" },
        { id: "315" },
        { id: "316" },
        { id: "317" },
        { id: "318" },
        { id: "319" },
        { id: "320" },
        { id: "321" },
        { id: "322" },
        { id: "323" },
        { id: "324" },
        { id: "325" },
        { id: "326" },
        { id: "327" },
        { id: "328" },
        { id: "329" },
        { id: "330" },
        { id: "331" },
        { id: "332" },
        { id: "333" },
        { id: "334" },
        { id: "335" },
        { id: "336" },
        { id: "337" },
        { id: "338" },
        { id: "339" },
        { id: "340" },
        { id: "341" },
        { id: "342" },
        { id: "343" },
        { id: "344" },
        { id: "345" },
        { id: "346" },
        { id: "347" },
        { id: "348" },
        { id: "349" },
        { id: "350" },
        { id: "351" },
        { id: "601" },
        { id: "602" },
        { id: "603" },
        { id: "604" },
        { id: "605" },
        { id: "606" },
        { id: "607" },
        { id: "608" },
      ],
    };
  },
  mounted() {
    Vue.set(this.item, "ipi", {
      situacaoTributaria: "",
    });
 
    Vue.set(this.item.ipi, "situacaoTributaria", "");
    Vue.set(this.item.ipi, "baseIPI", "");
    Vue.set(this.item.ipi, "valorBaseIPI", "");
    Vue.set(this.item.ipi, "valorIPI", "");
    Vue.set(this.item.ipi, "codEnquad", "");
    Vue.set(this.item.ipi, "codExcecaoTIPI", "");
    Vue.set(this.item.ipi, "informacoesComp", "");
    Vue.set(this.item.ipi, "informacoesCompIF", "");
  },
  methods: {}, //,    components: {}
  directives: { money: VMoney },
};
</script>