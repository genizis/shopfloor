<template>
  <div class="">

    <div v-if="status.erro && status.erro != null" class="alert alert-danger alert-dismissible fade show" id="alert" role="alert">
        <button type="button" class="close" @click="excluirMsg('erro')">&times;</button>
        <strong>Atenção!</strong> <span v-html="status.erro"></span>
    </div>

    <div v-if="status.sucesso && status.sucesso != null" class="alert alert-success alert-dismissible fade show" id="alert" role="alert">
        <button type="button" class="close" @click="excluirMsg('sucesso')">&times;</button>
        <strong >Muito bem!</strong> <span v-html="status.sucesso"></span>

    </div>
</div>
</template>

<script>

export default {
    props: ['status'],
    data() {
        return {
        };
    },
    mounted() {
    },
    methods: {
        excluirMsg(msg){
           Vue.set(this.status,msg, null);
       }
}//,    components: { Cabecalho,ListaContato,Conversa}
}
</script>