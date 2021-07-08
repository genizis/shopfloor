<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VendasVendedorController extends CI_Controller {

    function __construct(){
        parent::__construct();

        if(usuarioLogado() == false){

            redirect(base_url("login-vendedor"), "home", "refresh");

        }

        if(getDadosUsuarioLogado()['tipo_acesso'] != 3){

            redirect(base_url("login-vendedor"), "home", "refresh");

        }
    } 
    
    public function logoutUsuario(){

        $this->session->sess_destroy('usuario');

        redirect(base_url(), "login-vendedor", "refresh");
    }

    public function formPedidoVenda(){

        $listaCliente = $this->cliente->getCliente();

        $dados = array(
            'lista_cliente' => $listaCliente,
            'menu' => 'Pedidos Vendedor'
        );
        

        $this->load->view('vendas/novo-pedido-venda-vendedor', $dados);

    } 

    public function inserirPedidoVenda(){  

        //Validações dos campos
        $this->form_validation->set_rules('CodCliente', 'Código do Cliente', 'required',
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('DataEmissao', 'Data de Emissão', 'required|callback_date_check',
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('DataEntrega', 'Data de Entrega', 'required',
            array('required' => 'Você deve preencher o campo %s'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            $this->formPedidoVenda();
            
        }else {

            $dados = [
                'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                'cod_cliente'  => $this->input->post('CodCliente'),
                'cod_vendedor' => getDadosUsuarioLogado()['cod_vendedor'],
                'perc_comissao' => str_replace(",",".",(str_replace(".","",$this->input->post('PerComissao')))), 
                'data_emissao' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataEmissao')))),
                'data_entrega' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataEntrega')))),
                'situacao' => $this->input->post('Situacao'),
                'observacoes' => $this->input->post('ObsPedidoVenda'),
                'tipo_desconto' => $this->input->post('TipoDesconto'),
                'valor_desconto' => str_replace(",",".",(str_replace(".","",$this->input->post('Desconto')))), 
                'tipo_frete' => $this->input->post('TipoFrete'),
                'valor_frete' => str_replace(",",".",(str_replace(".","",$this->input->post('Frete')))), 
            ];
            $codPedidoVenda = $this->venda->insertPedidoVenda($dados);

            $this->session->set_flashdata('sucesso', 'Pedido de venda cadastrado com sucesso');
            redirect(base_url("vendas/pedido-venda-vendedor/editar-pedido-venda-vendedor/{$codPedidoVenda}"), "home", "refresh");
                       
        }        
    }

    public function editarPedidoVenda($numPedidoVenda){

        $listaPedidoVenda = $this->venda->getPedidoVendaPorCodigo($numPedidoVenda);
        $listaProdVenda = $this->venda->getProdutoPorPedido($numPedidoVenda);
        $listaProduto = $this->produto->getProdutoVenda($listaProdVenda); 
        $listaMetodoPagamento = $this->financeiro->getMetodoPagamento();       

        if($listaPedidoVenda == null){
            redirect(base_url('vendas/pedido-venda'));
            
        }else{ 

            $dados = array(
                'pedido' => $listaPedidoVenda,
                'lista_produto_venda' => $listaProdVenda,
                'lista_produto' => $listaProduto,  
                'lista_metodo_pagamento' => $listaMetodoPagamento,              
                'menu' => 'Vendas'
            );       

            $this->load->view('vendas/editar-pedido-venda-vendedor', $dados);
        }
    }

    public function salvarPedidoVenda($numPedidoVenda){

        //Validações dos campo e array das mensagens apresentadas
        $this->form_validation->set_rules('DataEntrega', 'Data de Entrega', 'required',
            array('required' => 'Você deve preencher o campo %s'));       

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            $this->editarPedidoVenda($numPedidoVenda);
            
        }else {  


            if($this->input->post('Situacao') != ""){
                $data = [
                    'perc_comissao' => str_replace(",",".",(str_replace(".","",$this->input->post('PerComissao')))), 
                    'data_entrega' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataEntrega')))),
                    'observacoes' => $this->input->post('ObsPedidoVenda'),
                    'tipo_desconto' => $this->input->post('TipoDesconto'),
                    'valor_desconto' => str_replace(",",".",(str_replace(".","",$this->input->post('Desconto')))), 
                    'tipo_frete' => $this->input->post('TipoFrete'),
                    'valor_frete' => str_replace(",",".",(str_replace(".","",$this->input->post('Frete')))), 
                    'situacao' => $this->input->post('Situacao')
                ];

            }else{
                $data = [
                    'perc_comissao' => str_replace(",",".",(str_replace(".","",$this->input->post('PerComissao')))), 
                    'data_entrega' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataEntrega')))),
                    'observacoes' => $this->input->post('ObsPedidoVenda'),
                    'tipo_desconto' => $this->input->post('TipoDesconto'),
                    'valor_desconto' => str_replace(",",".",(str_replace(".","",$this->input->post('Desconto')))), 
                    'tipo_frete' => $this->input->post('TipoFrete'),
                    'valor_frete' => str_replace(",",".",(str_replace(".","",$this->input->post('Frete')))), 
                ];
            }            

            $this->venda->updatePedidoVenda($numPedidoVenda, $data);

            $this->session->set_flashdata('sucesso', 'Pedido de venda alterado com sucesso');
            redirect(base_url("vendas/pedido-venda-vendedor/editar-pedido-venda-vendedor/{$numPedidoVenda}"), "home", "refresh");    
                       
        }  
    } 

    public function inserirProdutoVenda($numPedidoVenda){

        $this->form_validation->set_rules('CodProduto', 'Código do Produto', 'required',
                    array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('QuantPedida', 'Quantidade Pedida', 'required|callback_more_zero',
                    array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('ValorUnitario', 'Valor Unitário', 'required|callback_more_zero',
                    array('required' => 'Você deve preencher o campo %s'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            redirect(base_url("vendas/pedido-venda-vendedor/editar-pedido-venda-vendedor/{$numPedidoVenda}"), "home", "refresh");

        }else{

            $dados = [
                'num_pedido_venda' => $numPedidoVenda,
                'cod_produto'  => $this->input->post('CodProduto'),
                'quant_pedida' => str_replace(",",".",(str_replace(".","",$this->input->post('QuantPedida')))),
                'valor_unitario' => str_replace(",",".",(str_replace(".","",$this->input->post('ValorUnitario'))))
            ];

            $this->venda->insertProdutoVenda($dados);
            $this->session->set_flashdata('sucesso', 'Produto de venda inserido com sucesso');
            redirect(base_url("vendas/pedido-venda-vendedor/editar-pedido-venda-vendedor/{$numPedidoVenda}"), "home", "refresh");

        }
    } 
    
    public function salvarProdutoVenda(){
        $numPedidoVenda = $this->uri->segment(4);
        $seqProdutoVenda = $this->uri->segment(5);

        //Validações dos campo e array das mensagens apresentadas
        $this->form_validation->set_rules('QuantPedidaEdit', 'Quantidade Pedida', 'required|callback_more_zero',
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('ValorUnitarioEdit', 'Valor Unitário', 'required|callback_more_zero',
            array('required' => 'Você deve preencher o campo %s'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            $this->editarPedidoVenda($numPedidoVenda);
            
        }else {

            $quantPedida = str_replace(",",".",(str_replace(".","",$this->input->post('QuantPedidaEdit'))));
            $quantAtendida = str_replace(",",".",(str_replace(".","",$this->input->post('QuantAtendidaEdit'))));

            // Ajusta Status da ordem
            if($quantAtendida != 0){
                if($quantPedida <= $quantAtendida){
                    $status = 3;
                }elseif($quantPedida > $quantAtendida){
                    $status = 2;
                }
            }
            else{
                $status = 1;
            }

            $data = [
                'quant_pedida' => str_replace(",",".",(str_replace(".","",$this->input->post('QuantPedidaEdit')))), 
                'valor_unitario' => str_replace(",",".",(str_replace(".","",$this->input->post('ValorUnitarioEdit')))),               
                'status' => $status
            ];

            $this->venda->updateProdutoVenda($seqProdutoVenda, $data);

            $this->session->set_flashdata('sucesso', 'Produto de venda alterado com sucesso');
            redirect(base_url("vendas/pedido-venda-vendedor/editar-pedido-venda-vendedor/{$numPedidoVenda}"));
                       
        }  
    }

    public function listarPedidoVenda(){ 

        $config = array(
            'base_url' => base_url('vendas/pedido-venda-vendedor'),
            'per_page' => 5,
            'num_links' => 3,
            'uri_segment' => 3,
            'total_rows' => $this->venda->countAllVendasVendedor(),
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
        $offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $listaPedidoVenda = $this->venda->getPedidoVendaPorVendedor($filter, $config["per_page"], $offset);
        $listaStatus = $this->venda->defineStatusPedido($listaPedidoVenda);
        $empresa = $this->empresa->getEmpresaPorCodigo(getDadosUsuarioLogado()['id_empresa']);


        $dados = array(
            'pagination' => $this->pagination->create_links(),
            'empresa' => $empresa,
            'lista_pedido' => $listaPedidoVenda,
            'ped_status' => $listaStatus,
            'menu' => 'Pedidos Vendedor'
        );

        $this->load->view('vendas/pedido-venda-vendedor', $dados);
    }

    public function imprimirPedido($numPedidoVenda){

        $empresa = $this->empresa->getEmpresaPorCodigo(getDadosUsuarioLogado()['id_empresa']);
        $listaPedidoVenda = $this->venda->getPedidoVendaPorCodigo($numPedidoVenda);
        $listaCliente = $this->cliente->getClientePorCodigo($listaPedidoVenda->cod_cliente); 
        $listaProdVenda = $this->venda->getProdutoPorPedido($numPedidoVenda);

        $dados = array(
            'empresa' => $empresa,
            'cliente' => $listaCliente,
            'pedido' => $listaPedidoVenda,
            'lista_produto' => $listaProdVenda, 
            'menu' => ''
        );        

        $this->load->view('vendas/imprime-pedido-venda', $dados);       

    }  

    public function inserirFaturamento(){

        $numPedidoVenda = $this->uri->segment(4);
        $codCliente = $this->uri->segment(5);

        $this->form_validation->set_rules('DataFaturamento', 'Data de Faturamento', 'required|max_length[60]|callback_date_check', 
            array('required' => 'Você deve preencher o campo %s'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            redirect(base_url("vendas/pedido-venda-vendedor/editar-pedido-venda-vendedor/{$numPedidoVenda}"), "home", "refresh");
            
        }else { 

            $empresa = $this->empresa->getEmpresaPorCodigo(getDadosUsuarioLogado()['id_empresa']);
            $cliente = $this->cliente->getClientePorCodigo($codCliente);
            $pedido = $this->venda->getPedidoVendaPorCodigo($numPedidoVenda);
            $metodo = $this->financeiro->getMetodoPagamentoPorCodigo($this->input->post('CodMetodoPagamento'));

            if($metodo->cod_conta == 0 || $metodo->cod_conta == null){
                $this->session->set_flashdata('erro', 'Método de pagamento sem conta definida');
                redirect(base_url("vendas/pedido-venda-vendedor/editar-pedido-venda-vendedor/{$numPedidoVenda}"), "home", "refresh");  
            }

            $lista_produto_venda = $this->venda->getProdutoPorPedido($numPedidoVenda);
            foreach($lista_produto_venda as $key_produto_venda => $produto) {

                if($produto->saldo_negativo != 1 && $produto->quant_estoq < $produto->quant_pedida){
                    $this->session->set_flashdata('erro', 'Produto (' . $produto->cod_produto . ' - ' . $produto->nome_produto . ') sem saldo suficiente para venda');
                    redirect(base_url("vendas/pedido-venda-vendedor/editar-pedido-venda-vendedor/{$numPedidoVenda}"), "home", "refresh");  
                }
            }

            if($pedido->tipo_frete == 1){
                $valor_frete = $pedido->valor_frete;
            }else{
                $valor_frete = 0;
            }

            if($pedido->tipo_desconto == 1){
                $valor_desconto = $pedido->valor_desconto;
            }elseif($pedido->tipo_desconto == 2){
                $valor_desconto = ($pedido->valor_total_pedido + $valor_frete) * ($pedido->valor_desconto / 100);
            }            

            // Cria registro de faturamento
            $data = [
                'num_pedido_venda'  => $numPedidoVenda,
                'data_faturamento' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataFaturamento')))),
                'serie' => $this->input->post('Serie'),
                'nota_fiscal' => $this->input->post('NotaFiscal'),
                'valor_frete' => $valor_frete,
                'valor_desconto' => $valor_desconto,
                'valor_bruto' => $pedido->valor_total_pedido,
                'observacoes' => $this->input->post('ObservFatur')
            ];
            $codFaturamentoPedido = $this->venda->insertFaturamento($data);
            
            $total_venda = 0;            
            foreach($lista_produto_venda as $key_produto_venda => $produto) {

                $valor_venda = $produto->quant_pedida * $produto->valor_unitario;
                $total_venda = $total_venda + $valor_venda;

                // Movimenta estoque
                $dadosEstoque = null;
                $dadosEstoque = [
                    'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                    'data_movimento' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataFaturamento')))),
                    'cod_produto' => $produto->cod_produto,
                    'origem_movimento' => 3,
                    'id_origem' => $codFaturamentoPedido,
                    'tipo_movimento' => 2,
                    'especie_movimento' => 5,
                    'quant_movimentada' => $produto->quant_pedida,
                    'valor_movimento' => $valor_venda
                ];
                $this->estoque->insertMovimentoEstoque($dadosEstoque);

                $produtoVenda = $this->venda->getProdutoVendaPorCodigo($numPedidoVenda, $produto->cod_produto);

                if($produtoVenda->quant_atendida > 0){
                    if(($produtoVenda->quant_atendida + $produto->quant_pedida) >= $produtoVenda->quant_pedida) {
                        $status = 3;
                    }else{
                        $status = 2;
                    }            
                }else{
                    if($produto->quant_pedida >= $produtoVenda->quant_pedida) {
                        $status = 3;
                    }else{
                        $status = 2;
                    } 
                }

                $dados = [
                    'quant_atendida' => $produtoVenda->quant_atendida + $produto->quant_pedida,
                    'status' => $status
                ];
                $this->venda->updateProdutoVenda($produto->seq_produto_venda, $dados);

            }

            // Criação de título
            $numParcela = $this->input->post('Parcelas');
            $dataVencimento = $this->input->post('DataVencimento');
            $valorParcela = $this->input->post('ValorParcela');

            $valorTotal = $total_venda - $valor_desconto;

            for ($i = 1; $i <= $numParcela; $i++) {              
                
                $dadosMovimento = null;
                $dadosMovimento = [
                    'cod_conta' => $metodo->cod_conta,
                    'cod_metodo_pagamento' => $this->input->post('CodMetodoPagamento'),
                    'cod_centro_custo' => $empresa->conta_contabil_vendas,
                    'cod_conta_contabil' => $empresa->conta_contabil_vendas,
                    'cod_emitente' => $codCliente,
                    'cod_vendedor' => $pedido->cod_vendedor,
                    'tipo_movimento' => 1,
                    'data_competencia' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataFaturamento')))),
                    'data_vencimento' => date("Y-m-d", strtotime(str_replace('/', '-', $dataVencimento[$i]))),
                    'parcela' => $i . '/' . $numParcela,
                    'desc_movimento' => $cliente->nome_cliente . " - Pedido de Venda: " . $numPedidoVenda . ", " . "Faturamento: " . $codFaturamentoPedido,
                    'valor_titulo' => floatval(str_replace(",",".",(str_replace(".","",$valorParcela[$i])))),
                    'origem_movimento' => 3,
                    'id_origem' => $codFaturamentoPedido,
                    'confirmado' => 0
                ];
                $this->financeiro->insertMovimentoConta($dadosMovimento);
            }
        }

        $this->session->set_flashdata('sucesso', 'Faturamento realizado com sucesso');
        redirect(base_url("vendas/pedido-venda-vendedor"), "home", "refresh");

    }

    //Validações do Form
    public function date_check($str)
    {
        if(date("Y-m-d", strtotime(str_replace('/', '-', $str))) > date("Y-m-d")){
            $this->form_validation->set_message('date_check', '%s não pode ser superior a data de hoje');
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