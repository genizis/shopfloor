
window.Vue = require('vue');

import VModal from 'vue-js-modal';//Modal vue js
Vue.use(VModal);

import VueTheMask from 'vue-the-mask'
Vue.use(VueTheMask)

window.moment = require('moment');

import axios from 'axios';
 //Vue.use(VueAxios, axios);

 window.axios = require('axios');


 import money from 'v-money'

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

 var selectCount = 1;

 Vue.mixin({
   methods: {
      mulSe(valor, lista){
         return lista.indexOf(valor) > -1;
      },
      textoSelect($this){
         return $this.options[$this.selectedIndex].innerText;
      },
      abrirAba(id){
         $('#'+id).tab('show');
      },
      idAleatorio($this) {
         selectCount++; 
         var id = 'undefined';
         var modal = $this.closest(".container");
         if (modal != null && modal != "undefined") {
           if (typeof $(modal).attr('id') == "undefined") {
             $(modal).attr('id', 'selectmodalid' + selectCount);
          }
          id = $(modal).attr('id');
       }

       return id;
    },
    selectAjaxDinamico($this, placeholder, url, callbackLista ) {
      if (typeof $($this).attr('data-select2-id') != "undefined") return false;
      var parente = this.idAleatorio($this);

      if (typeof $($this).attr('title') == "undefined") $($this).attr('title', placeholder);

      if (typeof parente == "undefined") {
       parente = "";
    } else {
       parente = $("#" + parente);
    }

    $this.select2({
       placeholder: $($this).attr('title'),
       allowClear: true,
       language: {
        "noResults": function() {
         return 'Buscar...';
      }
   },
   ajax: {
     dataType: 'json',
     url: function(params) {
      return url+'?filtro=' + params.term;
   },
   processResults: function(data) {
      return {
       results: jQuery.map(data, function(item) {
        return callbackLista(item)
     })
    };
 }

},
dropdownParent: parente,
});
 },
 data(data) {
   return window.moment(data).format('DD/MM/YYYY')
},
selecionarRadio(classe, valor){
   var $radios = $(classe);

   $radios.filter('[value='+valor+']').prop('checked', true);
},
catchErro(error){
   alertify.closeAll();

   if (error.response) {
      alertify.error(error.response.data.message);
      console.log(error.response.status);
      console.log(error.response.headers);
   } else if (error.request) {
      console.log(error.request);
   } else {
      console.log('Error', error.message);
   }

},
paginacaoPagina(url){

   if(url==null) return url;

   let valor = url.split("page=");
   valor = valor[1].split('&&');
   return valor[0];
},
hora(hora) {
   return hora.replace(':00','')
},
somarHora(hora,minutos) {
   return moment(hora, 'HH:mm:ss').add(minutos, 'minutes').format('HH:mm');
},
dataAnoAtual(data) {
   return window.moment(data).format('DD/MM')+"/"+window.moment().format('YYYY');
},
nome(str) {
   var arr = str.split(' ');
   if(arr[1].toLowerCase() == 'de' || arr[1].toLowerCase() == 'da' || arr[1].toLowerCase() == 'do') {
      return arr[0] + " " + arr[1] + " " + arr[2]
   } else {
      return arr[0] + " " + arr[1]
   }
},
diaSemana(data) {
   switch (window.moment(data).day()) {
      case 0:  return 'Domingo';
      case 1: return 'Segunda Feira';
      case 2: return 'Terça Feira';
      case 3: return 'Quarta Feira';
      case 4: return 'Quinta Feira';
      case 5: return 'Sexta Feira';
      case 6: return 'Sabado';
      default:
      console.log(window.moment(data).day());
      break;
   }
   return '';
},
diaSemanaValor(valor) {
   switch (valor) {
      case 1:  return 'Domingo';
      case 2: return 'Segunda Feira';
      case 3: return 'Terça Feira';
      case 4: return 'Quarta Feira';
      case 5: return 'Quinta Feira';
      case 6: return 'Sexta Feira';
      case 7: return 'Sabado';
   }
   return '';
},
formatarDinheiro(valor){
   return  parseInt(valor.toFixed(2).replaceAll('.',''));
},
codBase64(valor){
   return btoa(valor);
},
imagem(img){
   if(img==null || img=="") return '/images/semImagem.png';

   return '/'+img.replace('public','storage');
},
dataHora(data) {
   return window.moment(data).format('DD/MM/YYYY hh:mm')
},
atualizaPag(){
   window.location.href=window.location.href;
},
validarFormErros(id){
   if($('.'+id).length > 0){
      var html = '';
      $('.'+id).each(function(index, el) {
         html+= $(el).html()+'<br>';
      });
      alertify.alert(' ',html);
      return false;
   }
   return true;
},
validarFormulario(form){
   var campos = '';
   $(form + " input[required] ," + form + " select[required], " + form + " textarea[required]").each(function(index, el) {
      if ($(this).val() == null || $(this).val() == '') {
         var element = $(this).parent().prev();
         var idTask = $(element).text();

         $(this).addClass('inputRequire');
         $(this).change(function(event) {
            if ($(this).val() == null || $(this).val() == '') {
               $(this).focus();
            } else {
               $(this).removeClass('inputRequire');
               $(this).off('change');
            }

         });
        // console.log($(this));
         var data = $(this).attr('data-required');
         var label = $("label[for='" + $(this).attr('id') + "']").html();
         var title = $(this).attr('title');
         var placeholder = $(this).attr('placeholder');
         var id = $(this).attr('id');

         var nomeCampo = '';

         if (typeof data != "undefined") {
            nomeCampo = data;
         } else if (typeof label != "undefined") {
            nomeCampo = label;
         } else if (typeof title != "undefined") {
            nomeCampo = title;
         } else if (typeof placeholder != "undefined") {
            nomeCampo = placeholder;
         } else {
            nomeCampo = idTask;
         }

         campos += '<br> <b>' + nomeCampo + '</b>';
      }
   });
   if (campos != '') {
      alertify.confirm('Atenção!', 'Os seguinte campos precisam ser preenchidos corretamentes: ' + campos + '</b> ', function() {

      }, function() {

      }).set('labels', { ok: 'cancelar', cancel: 'Entendi' });
      return false;
   }
   return true;

},
setSessao(key,value){
   this.$session.set(key, value);
},
getSessao(key){
   if (this.$session.exists(key)) {
      return this.$session.get(key);
   }
   return null;
},
buscarIndexArray(array,col,val){
   var cnt =-1;
   for (var i=0, n=array.length;i<n;i++) {
      cnt++;
      if (array[i][col]==val) return cnt;
   }
   return -1;
}
}
});



Vue.component('natureza-operacao-form', require('./components/natureza-operacao/Form.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 const app = new Vue({
  el: '#app',
});
