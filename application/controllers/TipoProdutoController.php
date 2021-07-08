<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TipoProdutoController extends CI_Controller {

    function __construct(){
        parent::__construct();

        if(usuarioLogado() == false){

            redirect(base_url("login"), "home", "refresh");

        }
    }

    public function formTipoProduto(){

        $dados = array(
            'menu' => 'Cadastro'
        );

        $this->load->view('cadastros/novo-tipo-produto', $dados);
    }

    public function editarTipoProduto($CodTipoProduto){

        $tipoproduto = $this->tipoproduto->getTipoProdutoPorCodigo($CodTipoProduto);

        if($tipoproduto == null){
            redirect(base_url('tipo-produto'));
            
        }else{            
            $dados = array(
                'tipoproduto' => $tipoproduto,
                'menu' => 'Cadastro'
            );
        }

        $this->load->view('cadastros/editar-tipo-produto', $dados);

    }

    public function inserirTipoProduto(){  

        //Validações dos campo e array das mensagens apresentadas
        $this->form_validation->set_rules('NomeTipoProduto', 'Nome do Tipo de Produto', 'required|max_length[45]',
            array('required' => 'Você deve preencher o campo %s',
                  'max_length' => 'O campo %s não deve ter mais que 45 caracteres'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            $this->formTipoProduto();
            
        }else {

            $data = [
                'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                'nome_tipo_produto'  => $this->input->post('NomeTipoProduto'),
                'origem_produto' => $this->input->post('OrigemProduto')
            ];

            $this->tipoproduto->insertTipoProduto($data);

            //Se optar por salvar e continuar, mantém na página de cadastro
            if ($this->input->post('Opcao') == 'salvarContinuar'){

                $this->session->set_flashdata('sucesso', 'Tipo de produto cadastrado com sucesso');
                redirect(base_url('tipo-produto/novo-tipo-produto'));


            }else {

                $this->session->set_flashdata('sucesso', 'Tipo de produto cadastrado com sucesso');
                redirect(base_url('tipo-produto'));
            }            
        }        
    }

    public function salvarTipoProduto($CodTipoProduto){

        //Validações dos campos
        $this->form_validation->set_rules('NomeTipoProduto', 'Nome do Tipo de Produto', 'required|max_length[45]',
            array('required' => 'Você deve preencher o campo %s',
                  'max_length' => 'O campo %s não deve ter mais que 45 caracteres'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            $this->editarTipoProduto($CodTipoProduto);
            
        }else {

            $dados = [
                'nome_tipo_produto'  => $this->input->post('NomeTipoProduto'),
                'origem_produto' => $this->input->post('OrigemProduto')
            ];

            $Cod = $this->tipoproduto->updateTipoProduto($CodTipoProduto, $dados);

            if(is_null($Cod)){
                $this->session->set_flashdata('erro', 'Erro ao alterar tipo de produto');
                $this->editarTipoProduto($CodTipoProduto);
            }else{
                $this->session->set_flashdata('sucesso', 'Tipo de produto alterado com sucesso');
                redirect(base_url('tipo-produto'));
            }            
        }
    }

    public function excluirTipoProduto()
    {

        $CodTipoProduto = $this->input->post("excluir_todos");
        $numRegs = count($CodTipoProduto);
        

        if($numRegs > 0){            
            $erro = $this->tipoproduto->deleteTipoProduto($CodTipoProduto);

            //Code 1451 - Não é permitido exluir registro sendo usado por outro registro
            if ($erro['code'] == 1451){
                $this->session->set_flashdata('erro', 'Exclusão não permitida. Registro em uso por outro cadastro');
            }else{
                $this->session->set_flashdata('sucesso', 'Registro(s) selecionado(s) excluído(s)');
            } 

        }else {
            $this->session->set_flashdata('erro', 'Nenhum registro foi selecionado');
        }

        redirect(base_url('tipo-produto'));
    } 

    public function listarTipoProduto(){      

        $config = array(
            'base_url' => base_url('tipo-produto'),
            'per_page' => 10,
            'num_links' => 10,
            'uri_segment' => 2,
            'total_rows' => $this->tipoproduto->countAll(),
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
        $listaTipoProduto = $this->tipoproduto->getTipoProduto($filter, $config["per_page"], $offset);


        $dados = array(
            'pagination' => $this->pagination->create_links(),
            'lista_tipo_produto' => $listaTipoProduto,
            'menu' => 'Cadastro'
        );

        $this->load->view('cadastros/tipo-produto', $dados);
    }
    
}