<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UnidadeMedidaController extends CI_Controller {

    function __construct(){
        parent::__construct();

        if(usuarioLogado() == false){

            redirect(base_url("login"), "home", "refresh");

        }
    }

    public function formCadastroUnidadeMedida(){   
        
        $dados = array(
            'menu' => 'Cadastro'
        );

        $this->load->view('cadastros/nova-unidade-medida', $dados);

    }

    public function editarUnidadeMedida($CodUnidadeMedida){

        $unidademedida = $this->unidademedida->getUnidadeMedidaPorCodigo($CodUnidadeMedida);

        if($unidademedida == null){
            redirect(base_url('unidade-medida'));
            
        }else{
            $dados = array(
                'unidademedida' => $unidademedida,
                'menu' => 'Cadastro'
            );
    
            $this->load->view('cadastros/editar-unidade-medida', $dados);

        }
    }

    public function inserirUnidadeMedida(){  

        //Validações dos campos
        $this->form_validation->set_rules('CodUnidadeMedida', 'Código da Unidade de Medida', 'required|min_length[2]|max_length[2]|callback_unique_reg',
            array('required' => 'Você deve preencher o campo %s',
                  'max_length' => 'O campo %s não deve ter mais que 2 caracteres',
                  'min_length' => 'O campo %s não deve ter menos que 2 caracteres'));
        $this->form_validation->set_rules('NomeUnidadeMedida', 'Nome da Unidade de Medida', 'required|max_length[45]', 
            array('required' => 'Você deve preencher o campo %s',
                  'max_length' => 'O campo %s não deve ter mais que 45 caracteres'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            $this->formCadastroUnidadeMedida();
            
        }else {

            $data = [
                'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                'cod_unidade_medida'  => $this->input->post('CodUnidadeMedida'),
                'nome_unidade_medida' => $this->input->post('NomeUnidadeMedida')
            ];

            $this->unidademedida->insertUnidadeMedida($data);

            //Se optar por salvar e continuar, mantém na página de cadastro
            if ($this->input->post('Opcao') == 'salvarContinuar'){

                $this->session->set_flashdata('sucesso', 'Unidade de medida cadastrada com sucesso');
                redirect(base_url('unidade-medida/nova-unidade-medida'));


            }else {

                $this->session->set_flashdata('sucesso', 'Unidade de medida cadastrada com sucesso');
                redirect(base_url('unidade-medida'));
            }            
        }        
    }

    public function salvarUnidadeMedida($CodUnidadeMedida){

        //Validações dos campos
        $this->form_validation->set_rules('NomeUnidadeMedida', 'Nome da Unidade de Medida', 'required|max_length[45]', 
            array('required' => 'Você deve preencher o campo %s',
                  'max_length' => 'O campo %s não deve ter mais que 45 caracteres'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            $this->editarUnidadeMedida($CodUnidadeMedida);
            
        }else {

            $dados = [
                'nome_unidade_medida' => $this->input->post('NomeUnidadeMedida')
            ];

            $this->unidademedida->updateUnidadeMedida($CodUnidadeMedida, $dados);

            $this->session->set_flashdata('sucesso', 'Unidade de medida alterada com sucesso');
            redirect(base_url('unidade-medida'));           
        }
    }

    public function excluirUnidadeMedida(){

        $CodUnidadeMedida = $this->input->post("excluir_todos");
        $numRegs = count($CodUnidadeMedida);

        if($numRegs > 0){
            $erro = $this->unidademedida->deleteUnidadeMedida($CodUnidadeMedida);

            //Code 1451 - Não é permitido exluir registro sendo usado por outro registro
            if ($erro['code'] == 1451){
                $this->session->set_flashdata('erro', 'Exclusão não permitida. Registro em uso por outro cadastro');
            }else{
                $this->session->set_flashdata('sucesso', 'Registro(s) selecionado(s) excluído(s)');
            }            
            
        }else {
            $this->session->set_flashdata('erro', 'Nenhum registro foi selecionado');
        }

        redirect(base_url('unidade-medida'));
    }

    public function listarUnidadeMedida(){

        $config = array(
            'base_url' => base_url('unidade-medida'),
            'per_page' => 10,
            'num_links' => 10,
            'uri_segment' => 2,
            'total_rows' => $this->unidademedida->countAll(),
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
        $listaUnidadeMedida = $this->unidademedida->getUnidadeMedida($filter, $config["per_page"], $offset);


        $dados = array(
            'pagination' => $this->pagination->create_links(),
            'lista_unidade_medida' => $listaUnidadeMedida,
            'menu' => 'Cadastro'
        );

        $this->load->view('cadastros/unidade-medida', $dados);
    } 


    //Form Validation customizados
    public function unique_reg($str){

        if($this->unidademedida->countPorcodigo($str) > 0){
            $this->form_validation->set_message('unique_reg', 'Já existe outro registro com a mesma %s no sistema');
            return false;
        }else{
            return true;
        }
    }
    
}