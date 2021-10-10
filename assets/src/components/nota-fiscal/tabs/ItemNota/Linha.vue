<template>
  <tr @click="abrirModal()" class="pointer">
    <th><input type="text" readonly class="form-control" :value="item.descricao"></th>
    <th><input type="text" readonly class="form-control" :value="item.codigo"></th>
    <th><input type="text" readonly class="form-control" :value="item.unidade"></th>
    <th><input type="text" readonly class="form-control" :value="item.quantidade"></th>
    <th><input type="text" readonly class="form-control" :value="item.valorTotal"></th>
    <th><input type="text" readonly class="form-control" :value="item.NCM"></th>
   <th> <i class="fas fa-edit"></i></th>
  </tr>
</template>

<script>
import { VMoney } from "v-money";
import CriarEditar from './CriarEditar';

export default {
  props: ["item", "money","form","estados"],
  data() {
    return {
      mostrar: false,
    };
  },
  mounted() {},
  methods: {
    abrirModal() {
			var $this = this;
			this.$modal.show(
				CriarEditar,
				{
					titulo: "Produto",
					estados:$this.estados,
					form: $this.form,
          item:$this.item,
          money:$this.money
				},
				{
					height: "auto",
					width: "50%",
					classes: "modalDinamico modalDinamico-open",
				}
				);
		},
  },
  directives: { money: VMoney },
};
</script>