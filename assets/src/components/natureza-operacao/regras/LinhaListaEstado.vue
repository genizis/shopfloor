<template>
	<div class="row">
		<div v-for="estado in estados" class="col-2">
			<label><input type="checkbox" name="estados[]" :value="estado.uf" v-model="form.estados"> {{estado.uf}}</label>
		</div>
	</div>
</template>

<script>
// <ContactsList />
// import ContactsList from './ContactsList';
export default {
	props: ['estados','form'],
	data() {
		return {
			mostrar:false
		};
	},
	mounted() {
		var $this = this;
	},
	methods: {
	},
	watch:{

	}
}
</script>