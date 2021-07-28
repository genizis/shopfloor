<template>
	<div>
		teste
	</div>
</template>

<script>
// <ContactsList />
// import ContactsList from './ContactsList';
export default {
	props: ['input_name'],
	data() {
		return {
			mostrar:false,
		};
	},
	mounted() {
		axios.get()
		.then((response) => {

		});
	},
	methods: {
}//,    components: { Cabecalho,ListaContato,Conversa}
}
</script>