<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EngenhariaController extends CI_Controller {

    function __construct(){
        parent::__construct();

        if(usuarioLogado() == false){

            redirect(base_url("login"), "home", "refresh");

        }
    }

    public function formEstruturaProduto(){

        $listaProdutoProd = $this->produto->getProdutoProduzido();
        $listaProdutoCons = $this->produto->getProdutoEstruturaComponente();

        $dados = array(
            'lista_produto_prod' => $listaProdutoProd,
            'lista_produto_cons' => $listaProdutoCons,
            'menu' => 'Cadastro'
        );

        $this->load->view('engenharia/nova-estrutura-produto', $dados);

    }

    public function editarEstruturaProduto($CodProduto){

        $listaEstrutura = $this->engenharia->getEstruturaProdutoPorCodigo($CodProduto);
        $listaComponente = $this->engenharia->getComponentesPorEstrutura($CodProduto);
        $listaProdutoCons = $this->produto->getProdutoEstruturaComponente($CodProduto, $listaComponente);

        if($listaEstrutura == null){
            redirect(base_url('estrutura-produto'));
            
        }else{  

            $dados = array(
                'estrutura' => $listaEstrutura,
                'lista_componente' => $listaComponente,
                'lista_produto_cons' => $listaProdutoCons,
                'menu' => 'Cadastro'
            );        

            $this->load->view('engenharia/editar-estrutura-produto', $dados);
        }

    } 

    public function inserirEstruturaProduto(){  

        //Validações dos campo e array das mensagens apresentadas
        $this->form_validation->set_rules('CodProduto', 'Código do Produto', 'required|callback_unique_reg',
            array('required' => 'Você deve preencher o campo %s',
                  'is_unique' => 'Já uma estrutura cadastrada para este produto'));
        $this->form_validation->set_rules('QuantProducao', 'Quantidade de Producao', 'required|callback_more_zero',
            array('required' => 'Você deve preencher o campo %s'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            $this->formEstruturaProduto();
            
        }else {

            $CodProduto = $this->input->post('CodProduto');

            $dados = [
                'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                'cod_produto'  => $CodProduto,
                'quant_producao' => str_replace(",",".",(str_replace(".","",$this->input->post('QuantProducao'))))
            ];

            $erro = $this->engenharia->insertEstruturaProduto($dados);    
            
            if ($erro['code'] == null){
                $this->session->set_flashdata('sucesso', 'Produto cadastrado com sucesso');
                
            }else{
                $this->session->set_flashdata('erro', $erro['message']);

            }
            
            redirect(base_url("estrutura-produto/editar-estrutura-produto/{$CodProduto}"), "home", "refresh");
                       
        }        
    } 
    
    public function inserirEstruturaComponente(){

        $this->form_validation->set_rules('CodProdutoCons', 'Componente de Produção', 'required',
                    array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('QuantConsumo', 'Quantidade de Consumo', 'required|callback_more_zero',
                    array('required' => 'Você deve preencher o campo %s'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            $CodProduto = $this->input->post('CodProdudoProd');
            $this->editarEstruturaProduto($CodProduto);
            redirect(base_url("estrutura-produto/editar-estrutura-produto/{$CodProduto}"), "home", "refresh");

        }else{

            $CodProduto = $this->input->post('CodProdudoProd');

            $dados = [
                'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                'cod_produto'  => $CodProduto,
                'cod_produto_componente' => $this->input->post('CodProdutoCons'),
                'quant_consumo' => str_replace(",",".",(str_replace(".","",$this->input->post('QuantConsumo'))))
            ];

            $erro = $this->engenharia->insertEstruturaComponente($dados);

            if ($erro['code'] == null){
                $this->session->set_flashdata('sucesso', 'Componente cadastrado com sucesso'); 

            }else{
                $this->session->set_flashdata('erro', $erro['message']);

            }
                      
            redirect(base_url("estrutura-produto/editar-estrutura-produto/{$CodProduto}"), "home", "refresh");

        }
    }
    
    public function salvarEstruturaProduto($CodProduto){

        //Validações dos campo e array das mensagens apresentadas
        $this->form_validation->set_rules('CodProduto', 'Código do Produto', 'required|is_unique[estrutura_produto.cod_produto]',
            array('required' => 'Você deve preencher o campo %s',
                  'is_unique' => 'Já uma estrutura cadastrada para este produto'));
        $this->form_validation->set_rules('QuantProducao', 'Quantidade de Producao', 'required|callback_more_zero',
            array('required' => 'Você deve preencher o campo %s'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            redirect(base_url("estrutura-produto/editar-estrutura-produto/{$CodProduto}"), "home", "refresh");
            
        }else {

            $dados = [
                'quant_producao' => str_replace(",",".",(str_replace(".","",$this->input->post('QuantProducao'))))
            ];

            $erro = $this->engenharia->updateEstruturaProduto($CodProduto, $dados);

            if ($erro['code'] == null){
                $this->session->set_flashdata('sucesso', 'Estrutura de produto alterada com sucesso'); 

            }else{
                $this->session->set_flashdata('erro', $erro['message']);

            }
            
            redirect(base_url('estrutura-produto'));
                       
        }  
    }    

    public function salvarEstruturaComponente(){

        $CodProduto = $this->uri->segment(3);
        $SeqComponente = $this->uri->segment(4);

        //Validações dos campo e array das mensagens apresentadas
        $this->form_validation->set_rules('QuantConsumoEdit', 'Quantidade de Consumo', 'required|callback_more_zero',
            array('required' => 'Você deve preencher o campo %s'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            redirect(base_url("estrutura-produto/editar-estrutura-produto/{$CodProduto}"), "home", "refresh");
            
        }else {

            $dataComp = [
                'quant_consumo' => str_replace(",",".",(str_replace(".","",$this->input->post('QuantConsumoEdit'))))
            ];

            $erro = $this->engenharia->updateEstruturaComponente($SeqComponente, $dataComp);

            if ($erro['code'] == null){
                $this->session->set_flashdata('sucesso', 'Componente alterado com sucesso');

            }else{
                $this->session->set_flashdata('erro', $erro['message']);

            }
            
            redirect(base_url("estrutura-produto/editar-estrutura-produto/{$CodProduto}"), "home", "refresh");
                       
        }  
    }

    public function excluirEstruturaProduto()
    {

        $CodProduto = $this->input->post("excluir_todos");
        $numRegs = count($CodProduto);

        if($numRegs > 0){

            $erro = $this->engenharia->deleteEstruturaProduto($CodProduto);

            //Code 1451 - Não é permitido exluir registro sendo usado por outro registro
            if ($erro['code'] == 1451){
                $this->session->set_flashdata('erro', 'Exclusão não permitida. Registro em uso por outro cadastro');

            }elseif($erro['code'] != null && $erro['code'] != 1451){
                $this->session->set_flashdata('erro', $erro['message']);

            }else{
                $this->session->set_flashdata('sucesso', 'Registro(s) selecionado(s) excluído(s)');

            }

        }else {
            $this->session->set_flashdata('erro', 'Nenhum registro foi selecionado');

        }

        redirect(base_url('estrutura-produto'));
    }

    public function excluirEstruturaComponente()
    {

        $SeqEstruturaComponente = $this->input->post("excluir_todos");
        $numRegs = count($SeqEstruturaComponente);

        if($numRegs > 0){
            
            $erro = $this->engenharia->deleteEstruturaComponente($SeqEstruturaComponente);

            //Code 1451 - Não é permitido exluir registro sendo usado por outro registro
            if ($erro['code'] == 1451){
                $this->session->set_flashdata('erro', 'Exclusão não permitida. Registro em uso por outro cadastro');

            }elseif($erro['code'] != null && $erro['code'] != 1451){
                $this->session->set_flashdata('erro', $erro['message']);

            }else{
                $this->session->set_flashdata('sucesso', 'Registro(s) selecionado(s) excluído(s)');

            }

        }else{ 
            $this->session->set_flashdata('erro', 'Nenhum registro foi selecionado');

        }

        $CodProdutoProd = $this->input->post('CodProdudoProd');
        redirect(base_url("estrutura-produto/editar-estrutura-produto/{$CodProdutoProd}"), "home", "refresh");
    } 

    public function listarEstruturaProduto(){      

        $config = array(
            'base_url' => base_url('estrutura-produto'),
            'per_page' => 10,
            'num_links' => 10,
            'uri_segment' => 2,
            'total_rows' => $this->engenharia->countAll(),
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
        $listaEstrutura = $this->engenharia->getEstruturaProduto($filter, $config["per_page"], $offset);


        $dados = array(
            'pagination' => $this->pagination->create_links(),
            'lista_estrutura' => $listaEstrutura,
            'menu' => 'Cadastro'
        );

        $this->load->view('engenharia/estrutura-produto', $dados);
    }  

    //Form Validation customizados
    public function unique_reg($str)
    {

        if($this->engenharia->countPorcodigo($str) > 0){
            $this->form_validation->set_message('unique_reg', 'Já existe outro registro com o mesmo %s no sistema');
            return false;
        }else{
            return true;
        }

    }

    public function more_zero($str)
    {
        if(floatval(str_replace(",",".",(str_replace(".","",$str)))) <= 0.000){
            $this->form_validation->set_message('more_zero', 'Valor de %s deve ser maior que 0');
            return false;
        }else{
            return true;
        }
    }
}