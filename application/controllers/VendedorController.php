<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VendedorController extends CI_Controller {

    function __construct(){
        parent::__construct();

        if(usuarioLogado() == false){

            redirect(base_url("login"), "home", "refresh");

        }
    }

    public function formVendedor(){

        $listaCidade = $this->tabelasauxiliares->getCidade();
        $listaEstado = $this->tabelasauxiliares->getEstado();       

        $dados = array(
            'lista_cidade' => $listaCidade,
            'lista_estado' => $listaEstado,
            'menu' => 'Cadastro'
        );

        $this->load->view('cadastros/novo-vendedor', $dados);

    }   

    public function inserirVendedor(){  

        //Validações dos campo e array das mensagens apresentadas
        $this->form_validation->set_rules('NomeVendedor', 'Nome do Vendedor', 'required|max_length[60]',
            array('required' => 'Você deve preencher o campo %s',
                  'max_length' => 'O campo %s não deve ter mais que 60 caracteres'));
        $this->form_validation->set_rules('Email', 'E-mail', 'valid_email|max_length[60]', 
            array('max_length' => 'O campo %s não deve ter mais que 60 caracteres',
                  'valid_email' => 'É necessário informar um e-mail válido'));
        $this->form_validation->set_rules('Endereco', 'Rua e Número', 'max_length[60]', 
            array('max_length' => 'O campo %s não deve ter mais que 60 caracteres'));
        $this->form_validation->set_rules('Bairro', 'Bairro', 'max_length[45]', 
            array('max_length' => 'O campo %s não deve ter mais que 45 caracteres'));

        if($this->input->post('CEP') != ""){
            $this->form_validation->set_rules('CEP', 'CEP', 'min_length[9]', 
                array('min_length' => 'O campo %s não está completo'));            
        }

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            $this->formVendedor();
            
        }else {

            $data = [
                'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                'nome_vendedor'  => $this->input->post('NomeVendedor'),
                'perc_comissao' => str_replace(",",".",(str_replace(".","",$this->input->post('PerComissao')))),
                'tel_fixo' => $this->input->post('TelFixo'),
                'tel_cel' => $this->input->post('TelCel'),
                'email' => $this->input->post('Email'),
                'cep' => $this->input->post('CEP'),
                'endereco' => $this->input->post('Endereco'),
                'numero' => $this->input->post('Numero'),
                'complemento' => $this->input->post('Complemento'),
                'bairro' => $this->input->post('Bairro'),
                'cod_cidade' => $this->input->post('Cidade'),
                'cons_frete' => $this->input->post('Frete'),
                'cons_icms' => $this->input->post('ICMS'),
                'cons_icms_st' => $this->input->post('ICMS_ST'),
                'cons_ipi' => $this->input->post('IPI'),
                'cons_pis' => $this->input->post('PIS'),
                'cons_cofins' => $this->input->post('COFINS'),
                'nome_usuario'  => $this->input->post('Usuario'),                
                'senha' => sha1($this->input->post('Senha')),
                'ativo' => $this->input->post('Ativo'),  
            ];

            $this->vendedor->insertVendedor($data);

            //Se optar por salvar e continuar, mantém na página de cadastro
            if ($this->input->post('Opcao') == 'salvarContinuar'){

                $this->session->set_flashdata('sucesso', 'Vendedor cadastrado com sucesso');
                redirect(base_url('vendedor/novo-vendedor'));


            }else {

                $this->session->set_flashdata('sucesso', 'Vendedor cadastrado com sucesso');
                redirect(base_url('vendedor'));
            }            
        }        
    }
    
    public function editarVendedor($CodVendedor){

        $listaVendedor = $this->vendedor->getVendedorPorCodigo($CodVendedor);
        $listaCidade = $this->tabelasauxiliares->getCidade();  
        
        if($listaVendedor == null){
            redirect(base_url('vendedor'));
            
        }else{ 
            $dados = array(
                'vendedor' => $listaVendedor,
                'lista_cidade' => $listaCidade,
                'menu' => 'Cadastro'
            );
        }

        $this->load->view('cadastros/editar-vendedor', $dados);

    }
       

    public function salvarVendedor($codVendedor){

        //Validações dos campo e array das mensagens apresentadas
        $this->form_validation->set_rules('NomeVendedor', 'Nome do Vendedor', 'required|max_length[60]',
            array('required' => 'Você deve preencher o campo %s',
                  'max_length' => 'O campo %s não deve ter mais que 60 caracteres'));
        $this->form_validation->set_rules('Email', 'E-mail', 'valid_email|max_length[60]', 
            array('max_length' => 'O campo %s não deve ter mais que 60 caracteres',
                  'valid_email' => 'É necessário informar um e-mail válido'));
        $this->form_validation->set_rules('Endereco', 'Rua e Número', 'max_length[60]', 
            array('max_length' => 'O campo %s não deve ter mais que 60 caracteres'));
        $this->form_validation->set_rules('Bairro', 'Bairro', 'max_length[45]', 
            array('max_length' => 'O campo %s não deve ter mais que 45 caracteres'));

        if($this->input->post('CEP') != ""){
            $this->form_validation->set_rules('CEP', 'CEP', 'min_length[9]', 
                array('min_length' => 'O campo %s não está completo'));            
        }

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            $this->editarVendedor($codVendedor);
            
        }else {

            if($this->input->post('Senha') <> ''){

                $dados = [
                    'nome_vendedor'  => $this->input->post('NomeVendedor'),
                    'perc_comissao' => str_replace(",",".",(str_replace(".","",$this->input->post('PerComissao')))),
                    'tel_fixo' => $this->input->post('TelFixo'),
                    'tel_cel' => $this->input->post('TelCel'),
                    'email' => $this->input->post('Email'),
                    'cep' => $this->input->post('CEP'),
                    'endereco' => $this->input->post('Endereco'),
                    'numero' => $this->input->post('Numero'),
                    'complemento' => $this->input->post('Complemento'),
                    'bairro' => $this->input->post('Bairro'),
                    'cod_cidade' => $this->input->post('Cidade'),
                    'cons_frete' => $this->input->post('Frete'),
                    'cons_icms' => $this->input->post('ICMS'),
                    'cons_icms_st' => $this->input->post('ICMS_ST'),
                    'cons_ipi' => $this->input->post('IPI'),
                    'cons_pis' => $this->input->post('PIS'),
                    'cons_cofins' => $this->input->post('COFINS'),
                    'nome_usuario'  => $this->input->post('Usuario'),                
                    'senha' => sha1($this->input->post('Senha')),
                    'ativo' => $this->input->post('Ativo'),  
                ];  

            }else{

                $dados = [
                    'nome_vendedor'  => $this->input->post('NomeVendedor'),
                    'perc_comissao' => str_replace(",",".",(str_replace(".","",$this->input->post('PerComissao')))),
                    'tel_fixo' => $this->input->post('TelFixo'),
                    'tel_cel' => $this->input->post('TelCel'),
                    'email' => $this->input->post('Email'),
                    'cep' => $this->input->post('CEP'),
                    'endereco' => $this->input->post('Endereco'),
                    'numero' => $this->input->post('Numero'),
                    'complemento' => $this->input->post('Complemento'),
                    'bairro' => $this->input->post('Bairro'),
                    'cod_cidade' => $this->input->post('Cidade'),
                    'cons_frete' => $this->input->post('Frete'),
                    'cons_icms' => $this->input->post('ICMS'),
                    'cons_icms_st' => $this->input->post('ICMS_ST'),
                    'cons_ipi' => $this->input->post('IPI'),
                    'cons_pis' => $this->input->post('PIS'),
                    'cons_cofins' => $this->input->post('COFINS'),
                    'nome_usuario'  => $this->input->post('Usuario'),   
                    'ativo' => $this->input->post('Ativo'),  
                ];  

            }                    

            $this->vendedor->updateVendedor($codVendedor, $dados); 
            $this->session->set_flashdata('sucesso', 'Vendedor alterado com sucesso');
            
            redirect(base_url('vendedor'));           
        }
    }

    public function excluirVendedor(){

        $CodVendedor = $this->input->post("excluir_todos");
        $numRegs = count($CodVendedor);

        if($numRegs > 0){

            $erro = $this->vendedor->deleteVendedor($CodVendedor);

            //Code 1451 - Não é permitido exluir registro sendo usado por outro registro
            if ($erro['code'] == 1451){
                $this->session->set_flashdata('erro', 'Exclusão não permitida. Registro em uso por outro cadastro');
            }else{
                $this->session->set_flashdata('sucesso', 'Registro(s) selecionado(s) excluído(s)');
            } 

        }else {
            $this->session->set_flashdata('erro', 'Nenhum registro foi selecionado');
        }

        redirect(base_url('vendedor'));
    } 

    public function listarVendedor(){     

        $config = array(
            'base_url' => base_url('vendedor'),
            'per_page' => 10,
            'num_links' => 10,
            'uri_segment' => 2,
            'total_rows' => $this->vendedor->countAll(),
            'full_tag_open' => '<ul class="pagination justify-content-center">',
			'full_tag_close' => '</ul>',
			'first_link' => FALSE,
			'last_link' => FALSE,
			'first_tag_open' => '<li class="page-item">',
			'first_tag_close' => '<li class="page-item">',
			'prev_link' => '&laquo;',
			'prev_tag_open' => '<li class="page-item prev">',
			'prev_tag_close' => '</li>',
			'next_link' => '&raquo;',
			'next_tag_open' => '<li class="page-item next">',
			'next_tag_close' => '</li>',
			'last_tag_open' => '<li class="page-item">',
			'last_tag_close' => "</li>",
			'cur_tag_open' => '<li class="page-item active"><span class="page-link">',
			'cur_tag_close' => '</span></li>',
			'num_tag_open' => '<li class="page-item">',
			'num_tag_close' => '</li>'
        );

        $this->pagination->initialize($config);

        // Busca dos dados para apresentação
        $filter = ($this->input->get('buscar')) ? $this->input->get('buscar') : "";
        $offset = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $listaVendedor = $this->vendedor->getVendedor($filter, $config["per_page"], $offset);
        $empresa = $this->empresa->getEmpresaPorCodigo(getDadosUsuarioLogado()['id_empresa']);

        $dados = array(
            'pagination' => $this->pagination->create_links(),
            'empresa' => $empresa,
            'lista_vendedor' => $listaVendedor,
            'menu' => 'Cadastro'
        );

        $this->load->view('cadastros/vendedor', $dados);
    }           
}