<template>
  <div class="modal-content">
    <!-- BODY -->

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
    <div class="row modal-body" ref="formCadastro" id="formRegra">
      <!-- BODY -->
      <div class="col-12 row">
        <div class="form-group col-md-4">
          <label for="">Descrição </label>
          <input
            type="text"
            class="form-control"
            maxlength="255"
            v-model="item.descricao"
          />
        </div>

        <div class="form-group col-md-4">
          <label for="">Codigo </label>
          <input
            type="text"
            class="form-control"
            maxlength="255"
            v-model="item.codigo"
          />
        </div>

        <div class="form-group col-md-4">
          <label for="">Tipo </label>
          <select
            class="form-control"
            v-model="item.tipo"
            placeholder="Selecione..."
          >
            <option value="">Selecione...</option>
            <option :value="itemS.id" :key="key" v-for="(itemS, key) in tipo">
              {{ itemS.texto }}
            </option>
          </select>
        </div>
      </div>

      <ul class="nav nav-tabs col-12" id="myTab" role="tablist">
        <li class="nav-item">
          <a
            class="nav-link active"
            id="tabDadosItem-tab"
            data-toggle="tab"
            href="#tabDadosItem"
            >Dados do Item</a
          >
        </li>
        <li class="nav-item">
          <a class="nav-link" id="tabICMS-tab" data-toggle="tab" href="#tabICMS"
            >ICMS</a
          >
        </li>

        <li class="nav-item">
          <a class="nav-link" id="tabIPI-tab" data-toggle="tab" href="#tabIPI"
            >IPI</a
          >
        </li>
        <li class="nav-item">
          <a
            class="nav-link"
            id="tabISSQN-tab"
            data-toggle="tab"
            href="#tabISSQN"
            >ISSQN</a
          >
        </li>
        <li class="nav-item">
          <a class="nav-link" id="tabPIS-tab" data-toggle="tab" href="#tabPIS"
            >PIS/CONFIS</a
          >
        </li>
        <li class="nav-item">
          <a
            class="nav-link"
            id="tabOutro-tab"
            data-toggle="tab"
            href="#tabOutro"
            >Outros</a
          >
        </li>
        <li class="nav-item">
          <a
            class="nav-link"
            id="tabEstoque-tab"
            data-toggle="tab"
            href="#tabEstoque"
            >Estoque</a
          >
        </li>
        <li class="nav-item">
          <a
            class="nav-link"
            id="tabRetencoes-tab"
            data-toggle="tab"
            href="#tabRetencoes"
            >Retenções</a
          >
        </li>
      </ul>

      <div class="tab-content col-12" id="myTabContent">
        <div
          class="tab-pane fade show active"
          id="tabDadosItem"
          role="tabpanel"
          aria-labelledby="home-tab"
        >
          <DadosItem :item="item" :money="money" />
        </div>

        <div
          class="tab-pane fade"
          id="tabEstoque"
          role="tabpanel"
          aria-labelledby="home-tab"
        >
          <Estoque :item="item" :money="money" />
        </div>

        <div
          class="tab-pane fade"
          id="tabICMS"
          role="tabpanel"
          aria-labelledby="home-tab"
        >
          <ICMS :item="item" :money="money" />
        </div>

        <div
          class="tab-pane fade"
          id="tabIPI"
          role="tabpanel"
          aria-labelledby="home-tab"
        >
          <IPI :item="item" :money="money" />
        </div>

        <div
          class="tab-pane fade"
          id="tabISSQN"
          role="tabpanel"
          aria-labelledby="home-tab"
        >
          <ISSQN :item="item" :money="money" />
        </div>

        <div
          class="tab-pane fade"
          id="tabOutro"
          role="tabpanel"
          aria-labelledby="home-tab"
        >
          <Outros :item="item" :money="money" />
        </div>

        <div
          class="tab-pane fade"
          id="tabPIS"
          role="tabpanel"
          aria-labelledby="home-tab"
        >
          <PISCONFINS :item="item" :money="money" />
        </div>

        <div class="tab-pane fade" id="tabRetencoes" aria-labelledby="home-tab">
          <Retencoes :item="item" :money="money" />
        </div>
      </div>
    </div>
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
    </div>
    <!-- FIM FOOTER -->
  </div>
  <!-- FIM CONTENT -->
</template>

<script>
import { VMoney } from "v-money";
import DadosItem from "./tabs/DadosItem.vue";
import Estoque from "./tabs/Estoque.vue";
import ICMS from "./tabs/ICMS.vue";
import IPI from "./tabs/IPI.vue";
import ISSQN from "./tabs/ISSQN.vue";
import Outros from "./tabs/Outros.vue";
import PISCONFINS from "./tabs/PISCONFINS.vue";
import Retencoes from "./tabs/Retencoes.vue";

export default {
  props: ["form", "titulo", "estados", "form", "item", "money"],
  data() {
    return {
      tipo: [
        { id: "produto", texto: "Produto" },
        { id: "servico", texto: "Serviço" },
      ],
    };
  },
  mounted() {
    Vue.set(this.item, "ipi", {});
    Vue.set(this.item, "pis", {});
    Vue.set(this.item, "confis", {});

    Vue.set(this.item, "tipo", "");
    Vue.set(this.item, "descricao", "");
    Vue.set(this.item, "codigo", "");
  },
  methods: {},
  components: {
    DadosItem,
    Estoque,
    ICMS,
    IPI,
    ISSQN,
    Outros,
    PISCONFINS,
    Retencoes,
  },
};
</script>