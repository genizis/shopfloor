<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VisaoGeralController extends CI_Controller {

    function __construct(){
        parent::__construct();

        if(usuarioLogado() == false){

            redirect(base_url("login"), "home", "refresh");

        }

        if(getDadosUsuarioLogado()['tipo_acesso'] == 3){

            redirect(base_url("vendas/pedido-venda-vendedor"), "home", "refresh");

        }
    }
    
    public function logoutUsuario(){

        $this->session->sess_destroy('usuario');

        redirect(base_url(), "home", "refresh");
    }

    function dateDifference($date_1 , $date_2)
    {
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);
    
        $interval = date_diff($datetime1, $datetime2);
    
        return $interval->format('%a');
    
    }
        

    public function visaoGeral(){  

        $empresa = $this->empresa->getEmpresaPorCodigo(getDadosUsuarioLogado()['id_empresa']);

        $lista_producoes = $this->producao->getProximasProducoes(); 
        $custo_total = $this->producao->getCustoTotalProduto(); 
        $lista_custo_produto = $this->producao->getCustoProduto();  

        $labelCodProd = array();
        $labelNomeProd = array();
        $valorCusto = array();
        foreach($lista_custo_produto as $custo){

            $labelCodProd[] = $custo->cod_produto;
            $labelNomeProd[] = $custo->nome_produto;
            $valorCusto[] = $custo->custo_total;

        }

        $lista_pedido_venda = $this->venda->getPedidoVendaPendente();
        $venda_total = $this->venda->getVendaTotal();

        #TODO descomentar
        //$lista_venda_cliente = $this->venda->getVendaClienteVisaoGeral(); 
         $lista_venda_cliente = [];

        $labelCodCli = array();
        $labelNomeCli = array();
        $valorVenda = array();
        foreach($lista_venda_cliente as $venda){

            $labelCodCli[] = $venda->cod_cliente;
            if($venda->cod_cliente == 0){
                $labelNomeCli[] = "Consumidor Final";
            }else{
                $labelNomeCli[] = $venda->nome_cliente;
            }
            
            $valorVenda[] = $venda->total_venda;

        }

        $lista_pedido_compra = $this->compra->getPedidoCompraPendente();
        $compra_total = $this->compra->getCompraTotal();
        $lista_compra_fornecedor = $this->compra->getCompraFornecedorVisaoGeral(); 

        $labelCodFor = array();
        $labelNomeFor = array();
        $valorCompra = array();
        foreach($lista_compra_fornecedor as $compra){

            $labelCodFor[] = $compra->cod_fornecedor;
            $labelNomeFor[] = $compra->nome_fornecedor;
            $valorCompra[] = $compra->total_compra;

        }

        $lista_estoque = $this->estoque->getAvisoEstoque();
        $total_estoque = $this->estoque->getTotalEstoque();
        $lista_estoque_produto = $this->estoque->getTotalEstoqueProduto();

        $labelCodEst = array();
        $labelNomeEst = array();
        $valorEstoque = array();
        foreach($lista_estoque_produto as $estoque){

            $labelCodEst[] = $estoque->cod_produto;
            $labelNomeEst[] = $estoque->nome_produto;
            $valorEstoque[] = $estoque->total_estoq;

        }

        $lista_titulos = $this->financeiro->getTitulospendentes();
        $total_conta = $this->financeiro->getTotalConta();
        $lista_titulos_confirmados = $this->financeiro->getEntradasSaidas();
        
        //-------
        $lista_prod_per = $this->producao->getProducaoPeriodo();
        $lista_status_op = $this->producao->getQuantPorStatus();

        $lista_vendas_per = $this->venda->getVendasPeriodo();
        $listaPedidoVenda = $this->venda->getPedidoVendaPendente();
        $lista_result_venda = $this->venda->getResultadoVenda();

        $lista_status_pv = $this->venda->getQuantPorStatus();
        
        $listaStatus = $this->venda->defineStatusPedido($listaPedidoVenda);
        $listaProdutoCompra = $this->compra->getOrdemPorQuantPedida();
        $listaOCPendentes = $this->compra->getOrdemCompraPendente();
        $numProduto = $this->produto->countAll();
        $numEngenharia = $this->engenharia->countAll();

        $labelProduto = array();
        $labelNome = array();
        $quantPedida = array();
        $quantRecebida = array();

        $fimPeriodo = $this->dateDifference($empresa->data_validade, date('Y-m-d'));

        $dados = array(
            'dias_periodo' => $fimPeriodo,
            'empresa' => $empresa,
            'num_produto' => $numProduto,
            'num_engenharia' => $numEngenharia,

            'lista_producoes' => $lista_producoes,
            'custo_total' => $custo_total,
            'label_cod_prod' => $labelCodProd,
            'label_nome_prod' => $labelNomeProd,
            'valor_custo_prod' => $valorCusto,

            'lista_pedido_venda' => $lista_pedido_venda,
            'venda_total' => $venda_total,
            'label_cod_cli' => $labelCodCli,
            'label_nome_cli' => $labelNomeCli,
            'valor_custo_cli' => $valorVenda,

            'lista_pedido_compra' => $lista_pedido_compra,
            'compra_total' => $compra_total,
            'label_cod_for' => $labelCodFor,
            'label_nome_for' => $labelNomeFor,
            'valor_custo_for' => $valorCompra,

            'lista_estoque' => $lista_estoque,
            'total_estoque' => $total_estoque,
            'label_cod_est' => $labelCodEst,
            'label_nome_est' => $labelNomeEst,
            'valor_custo_est' => $valorEstoque,

            'lista_titulos' => $lista_titulos,
            'total_conta' => $total_conta,
            'lista_titulos_confirmados' => $lista_titulos_confirmados,

            //-----

            
            'lista_prod_per' => $lista_prod_per,
            'lista_status_op' => $lista_status_op,

            'lista_vendas_per' => $lista_vendas_per,
            'lista_pedido' => $listaPedidoVenda,
            'lista_result_venda' => $lista_result_venda,
            
            'lista_compra' => $listaOCPendentes,
            'ped_status' => $listaStatus,

            'label_produto' => $labelProduto,
            'label_nome' => $labelNome,
            'quant_pedida' => $quantPedida,
            'quant_recebida' => $quantRecebida,
            'menu' => 'Visao Geral'
        );        

        $this->load->view('visao-geral', $dados);

        

    }  
}