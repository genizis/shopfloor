<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProdutoController extends CI_Controller {

    function __construct(){
        parent::__construct();

        if(usuarioLogado() == false){

            redirect(base_url("login"), "home", "refresh");

        }
    }

    public function formProduto(){

        $listaContaContabil = $this->financeiro->getContaContabilAtivo();
        $listaNCM = $this->produto->getNCM(); 
        $listaCest = $this->produto->getCest(); 
        $listaUnidadeMedida = $this->unidademedida->getUnidadeMedida();
        $listaTipoProduto = $this->tipoproduto->getTipoProduto();

        $dados = array(
            'lista_conta_contabil' => $listaContaContabil,
            'lista_ncm' => $listaNCM,
            'lista_cest' => $listaCest,
            'lista_tipo_produto' => $listaTipoProduto,
            'lista_unidade_medida' => $listaUnidadeMedida,
            'menu' => 'Cadastro'
        );

        $this->load->view('cadastros/novo-produto', $dados);

    }

    public function editarProduto($CodProduto){

        $listaProduto = $this->produto->getProdutoPorCodigo($CodProduto); 
        $listaContaContabil = $this->financeiro->getContaContabilAtivo();
        $listaNCM = $this->produto->getNCM(); 
        $listaCest = $this->produto->getCest(); 
        $listaUnidadeMedida = $this->unidademedida->getUnidadeMedida();
        $listaTipoProduto = $this->tipoproduto->getTipoProduto();              

        if($listaProduto == null){
            redirect(base_url('produto'));
            
        }else{  

            $dados = array(
                'produto' => $listaProduto,
                'lista_conta_contabil' => $listaContaContabil,
                'lista_ncm' => $listaNCM,
                'lista_cest' => $listaCest,
                'lista_unidade_medida' => $listaUnidadeMedida,
                'lista_tipo_produto' => $listaTipoProduto,                
                'menu' => 'Cadastro'
            );

            $this->load->view('cadastros/editar-produto', $dados);
        }

    }

    public function inserirProduto(){  

        //Validações dos campos
        $this->form_validation->set_rules('CodProduto', 'Código do Produto', 'required|regex_match[/[\p{L}0-9 ]+$/i]|max_length[15]|callback_unique_reg',
            array('required' => 'Você deve preencher o campo %s',
                  'max_length' => 'O campo %s não deve ter mais que 15 caracteres',
                  'regex_match' => 'Não é permitido espaço e caracteres especiais para o campo %s'));
        $this->form_validation->set_rules('NomeProduto', 'Nome do Produto', 'required|max_length[100]', 
            array('required' => 'Você deve preencher o campo %s',
                  'max_length' => 'O campo %s não deve ter mais que 100 caracteres'));
        $this->form_validation->set_rules('DescProduto', 'Descrição do Prduto', 'max_length[300]', 
            array('max_length' => 'O campo %s não deve ter mais que 300 caracteres'));
        $this->form_validation->set_rules('TipoProduto', 'Tipo de Produto', 'required', 
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('UnidadeMedida', 'Unidade de Medida', 'required', 
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('QuantEstoque', 'Quantidade em Estoque', 'required', 
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('CustoMedio', 'Custo Médio', 'required|callback_more_zero', 
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('EstoqMinimo', 'Estoque Mínimo', 'required', 
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('TempoAbastecimento', 'Tempo de Abastecimento', 'required|callback_more_zero', 
            array('required' => 'Você deve preencher o campo %s'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            $this->formProduto();
            
        }else {            

            //Conversão quantidade estoque
            $estoqueInicial = floatval(str_replace(",",".",(str_replace(".","",$this->input->post('QuantEstoque')))));
            $custoMedio = floatval(str_replace(",",".",(str_replace(".","",$this->input->post('CustoMedio')))));
            $precoVenda = floatval(str_replace(",",".",(str_replace(".","",$this->input->post('PrecoVenda')))));

            $dados = [
                'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                'cod_produto'  => $this->input->post('CodProduto'),
                'nome_produto' => $this->input->post('NomeProduto'),
                'desc_produto' => $this->input->post('DescProduto'),                
                'cod_tipo_produto' => $this->input->post('TipoProduto'),
                'cod_unidade_medida' => $this->input->post('UnidadeMedida'),
                'quant_estoq' => 0,
                'custo_medio' => $custoMedio,
                'preco_venda' => $precoVenda,
                'estoq_min' => str_replace(",",".",(str_replace(".","",$this->input->post('EstoqMinimo')))),
                'saldo_negativo' => ($this->input->post('SaldoNegativo')) ? $this->input->post('SaldoNegativo') : 0,
                'tempo_abastecimento' => str_replace(",",".",(str_replace(".","",$this->input->post('TempoAbastecimento')))),
                'cod_ncm' => $this->input->post('NCM'),
                'cod_origem' => $this->input->post('OrigemProduto'),
                'cod_cest' => $this->input->post('CEST'),
                'peso_liq' => str_replace(",",".",(str_replace(".","",$this->input->post('PesoLiq')))),
                'peso_bruto' => str_replace(",",".",(str_replace(".","",$this->input->post('PesoBruto'))))
            ];

            $this->produto->insertProduto($dados);

            //Movimenta estoque inicial
            if($estoqueInicial > 0){

                $dadosEstoque = [
                    'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                    'data_movimento' => date("Y-m-d"),
                    'cod_produto' => $this->input->post('CodProduto'),
                    'tipo_movimento' => 1,
                    'especie_movimento' => 1,
                    'quant_movimentada' => $estoqueInicial,
                    'valor_movimento' => $estoqueInicial * $custoMedio,
                ];

                $this->estoque->insertMovimentoEstoque($dadosEstoque);

            }           

            //Se optar por salvar e continuar, mantém na página de cadastro
            if ($this->input->post('Opcao') == 'salvarContinuar'){

                $this->session->set_flashdata('sucesso', 'Produto cadastrado com sucesso');
                redirect(base_url('produto/novo-produto'));

            }else {

                $this->session->set_flashdata('sucesso', 'Produto cadastrado com sucesso');
                redirect(base_url('produto'));

            }            
        }        
    }
  
    public function salvarProduto($codProduto){

        //Validações dos campo e array das mensagens apresentadas
        $this->form_validation->set_rules('NomeProduto', 'Nome do Produto', 'required|max_length[100]', 
            array('required' => 'Você deve preencher o campo %s',
                  'max_length' => 'O campo %s não deve ter mais que 100 caracteres'));
        $this->form_validation->set_rules('DescProduto', 'Descrição do Prduto', 'max_length[300]', 
            array('max_length' => 'O campo %s não deve ter mais que 300 caracteres'));
        $this->form_validation->set_rules('TipoProduto', 'Tipo de Produto', 'required', 
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('UnidadeMedida', 'Unidade de Medida', 'required', 
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('EstoqMinimo', 'Estoque Mínimo', 'required', 
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('CustoMedio', 'Custo Médio', 'required|callback_more_zero', 
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('TempoAbastecimento', 'Tempo de Abastecimento', 'required|callback_more_zero', 
            array('required' => 'Você deve preencher o campo %s'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            $this->editarProduto($codProduto);
            
        }else {

            $dados = [
                'nome_produto' => $this->input->post('NomeProduto'),
                'desc_produto' => $this->input->post('DescProduto'),
                'cod_tipo_produto' => $this->input->post('TipoProduto'),
                'cod_unidade_medida' => $this->input->post('UnidadeMedida'),
                'estoq_min' => str_replace(",",".",(str_replace(".","",$this->input->post('EstoqMinimo')))),
                'custo_medio' => str_replace(",",".",(str_replace(".","",$this->input->post('CustoMedio')))),
                'preco_venda' => str_replace(",",".",(str_replace(".","",$this->input->post('PrecoVenda')))),
                'saldo_negativo' => ($this->input->post('SaldoNegativo')) ? $this->input->post('SaldoNegativo') : 0,
                'tempo_abastecimento' => str_replace(",",".",(str_replace(".","",$this->input->post('TempoAbastecimento')))),
                'cod_ncm' => $this->input->post('NCM'),
                'cod_origem' => $this->input->post('OrigemProduto'),
                'cod_cest' => $this->input->post('CEST'),
                'peso_liq' => str_replace(",",".",(str_replace(".","",$this->input->post('PesoLiq')))),
                'peso_bruto' => str_replace(",",".",(str_replace(".","",$this->input->post('PesoBruto'))))
            ];

            $this->produto->updateProduto($codProduto, $dados);

            $this->session->set_flashdata('sucesso', 'Produto alterado com sucesso');
            redirect(base_url('produto'));                       
        }
    }

    public function importaProdutoContaAzul(){ 
        
        $this->contaazul->importaProduto();
        
        $this->session->set_flashdata('sucesso', 'Produtos importados com sucesso');
        redirect(base_url('produto'));

    }

    public function exportaProdutoContaAzul(){ 

        $listaProdutos = $this->produto->getProduto();     
        $this->contaazul->exportaListaProduto($listaProdutos);
        
        $this->session->set_flashdata('sucesso', 'Produtos exportados com sucesso');
        redirect(base_url('produto'));

    }

    public function excluirProduto(){

        $CodProduto = $this->input->post("excluir_todos");
        $numRegs = count($CodProduto);

        if($numRegs > 0){
            
            $erro = $this->produto->deleteProduto($CodProduto);

            //Code 1451 - Não é permitido exluir registro sendo usado por outro registro
            if ($erro['code'] == 1451){
                $this->session->set_flashdata('erro', 'Exclusão não permitida. Registro em uso por outro cadastro');
            }else{
                $this->session->set_flashdata('sucesso', 'Registro(s) selecionado(s) excluído(s)');
            } 

        }else {
            $this->session->set_flashdata('erro', 'Nenhum registro foi selecionado');
        }

        redirect(base_url('produto'));
    }
    
    public function listarProduto(){ 
        
        // Busca dos dados para apresentação
        $filter = ($this->input->get('buscar')) ? $this->input->get('buscar') : "";
        $offset = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

        $config = array(
            'base_url' => base_url('produto'),
            'per_page' => 10,
            'num_links' => 10,
            'uri_segment' => 2,
            'total_rows' => $this->produto->countAll($filter),
            'reuse_query_string' => true,
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
        
        $listaProduto = $this->produto->getProduto($filter, $config["per_page"], $offset);

        $dados = array(
            'filter' => $filter,
            'pagination' => $this->pagination->create_links(),
            'lista_produto' => $listaProduto,
            'menu' => 'Cadastro'
        );

        $this->load->view('cadastros/produto', $dados);
    }    

    //Form Validation customizadas
    public function unique_reg($str){

        if($this->produto->countPorcodigo($str) > 0){
            $this->form_validation->set_message('unique_reg', 'Já existe outro registro com o mesmo %s no sistema');
            return false;
        }else{
            return true;
        }
    }

    public function more_zero($str){
        if(floatval(str_replace(",",".",$str)) <= 0.000){
            $this->form_validation->set_message('more_zero', 'Valor de %s deve ser maior que 0');
            return false;
        }else{
            return true;
        }
    }

}