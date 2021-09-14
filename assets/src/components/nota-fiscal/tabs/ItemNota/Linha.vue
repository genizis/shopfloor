<template>
  <tr @click="abrirModal()">
    <td><input type="text" readonly class="form-control"></td>
    <td><input type="text" readonly class="form-control"></td>
    <td><input type="text" readonly class="form-control"></td>
    <td><input type="text" readonly class="form-control"></td>
    <td><input type="text" readonly class="form-control"></td>
    <td><input type="text" readonly class="form-control"></td>
    <td><input type="text" readonly class="form-control"></td>
    <td></td>
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
					titulo: "Produto ou serviço",
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