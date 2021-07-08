<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class IntegracoesController extends CI_Controller { 

    public function callbackContaAzul(){

        $code = $this->input->get('code');
        $state = $this->input->get('state');  

        redirect(base_url("conecta-conta-azul/{$code}/{$state}"), 'home', 'refresh');

    }
      
}