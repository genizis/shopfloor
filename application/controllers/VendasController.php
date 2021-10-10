<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VendasController extends CI_Controller {

    function __construct(){
        parent::__construct();

        if(usuarioLogado() == false){

            redirect(base_url("login"), "home", "refresh");

        }

        if(getDadosUsuarioLogado()['vendas'] != 1){

            redirect(base_url("visao-geral"), "home", "refresh");

        }
    }

    public function imprimirPedido($numPedidoVenda)   
    {

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

    public function formPedidoVenda(){

        $listaCliente = $this->cliente->getCliente();
        $listaVendedor = $this->vendedor->getVendedor();

        $dados = array(
            'lista_cliente' => $listaCliente,
            'lista_vendedor' => $listaVendedor,
            'menu' => 'Vendas'
        );
        

        $this->load->view('vendas/novo-pedido-venda', $dados);

    } 

    public function redirecionaFrenteCaixa(){

        $data = date("Y-m-d");

        redirect(base_url("vendas/frente-caixa/{$data}"), "home", "refresh");

    }

    public function frenteCaixa(){

        $data = $this->uri->segment(3);

        $diaAnterior = date('Y-m-d', strtotime('-1 day', strtotime($data)));
        $diaSeguinte = date('Y-m-d', strtotime('+1 day', strtotime($data)));

        $frenteCaixa = $this->venda->getControleCaixaPorCodigo($data);
        $vendaCaixa = $this->venda->getVendaCaixa($data);
        $movimentoCaixa = $this->venda->getMovimentoCaixa($data);

        $recebimentoMetodo = $this->venda->getMetodoPagamentoPorDataCaixa($data);

        $dados = array(
            'dia' => $data,
            'diaAnterior' => $diaAnterior,
            'diaSeguinte' => $diaSeguinte,
            'frente_caixa' => $frenteCaixa,
            'venda_caixa' => $vendaCaixa,
            'movimento_caixa' => $movimentoCaixa,
            'recebeimento_metodo' => $recebimentoMetodo,
            'menu' => 'Vendas'
        );        

        $this->load->view('vendas/frente-caixa', $dados);

    } 
    
    public function imprimirFechamentoCaixa($data)   
    {

        $empresa = $this->empresa->getEmpresaPorCodigo(getDadosUsuarioLogado()['id_empresa']);
        $frenteCaixa = $this->venda->getControleCaixaPorCodigo($data);
        $vendaCaixa = $this->venda->getVendaCaixa($data);
        $movimentoCaixa = $this->venda->getMovimentoCaixa($data);

        $recebimentoMetodo = $this->venda->getMetodoPagamentoPorDataCaixa($data);
        $produtoVenda = $this->venda->getProdutoPorDataCaixa($data);

        $dados = array(
            'empresa' => $empresa,
            'frente_caixa' => $frenteCaixa,
            'venda_caixa' => $vendaCaixa,
            'movimento_caixa' => $movimentoCaixa,
            'recebeimento_metodo' => $recebimentoMetodo,
            'produto_venda' => $produtoVenda,
            'menu' => ''
        );        

        $this->load->view('vendas/imprime-fechamento-caixa', $dados);       

    }
    
    public function abrirCaixa(){

        $data = $this->uri->segment(3);

        $caixaAberto = $this->venda->getCaixaAberto($data);

        if($caixaAberto <> null){

            $this->session->set_flashdata('erro', 'O caixa do dia ' . str_replace('-', '/', date("d-m-Y", strtotime($caixaAberto->data_caixa))) . ' ainda está em aberto');
            redirect(base_url("vendas/frente-caixa/{$data}"), "home", "refresh");

        }

        if($data > date('Y-m-d')){

            $this->session->set_flashdata('erro', 'Não é possível abrir caixa para datas futuras');
            redirect(base_url("vendas/frente-caixa/{$data}"), "home", "refresh");

        }

        // Cria registro de venda
        $dados = [
            'id_empresa'  => getDadosUsuarioLogado()['id_empresa'],
            'data_caixa' => $data,
            'saldo_inicial' => str_replace(",",".",(str_replace(".","",$this->input->post('SaldoInicial')))),
            'data_hora_abertura' => date('Y-m-d H:i:s'),
        ];
        $this->venda->inserirControleCaixa($dados);

        $this->session->set_flashdata('sucesso', 'Caixa aberto com sucesso');
        redirect(base_url("vendas/frente-caixa/{$data}"), "home", "refresh");



    }

    public function reabrirCaixa(){

        $data = $this->uri->segment(3);

        $caixaAberto = $this->venda->getCaixaAberto();

        if($caixaAberto <> null){

            $this->session->set_flashdata('erro', 'Não é possível reabrir, o caixa do dia ' . str_replace('-', '/', date("d-m-Y", strtotime($caixaAberto->data_caixa))) . ' ainda está em aberto');
            redirect(base_url("vendas/frente-caixa/{$data}"), "home", "refresh");

        }

        // Atualiza registro de venda
        $dados = [
            'data_hora_fechamento' => null,
        ];
        $this->venda->updateControleCaixa($data, $dados);

        //Exclui títulos não confirmados
        $this->financeiro->excluirTituloOrigem(4, intval(str_replace('-', '', date("d-m-Y", strtotime($data)))));

        $this->session->set_flashdata('sucesso', 'Caixa aberto com sucesso');
        redirect(base_url("vendas/frente-caixa/{$data}"), "home", "refresh");


    }

    public function fecharCaixa(){

        $data = $this->uri->segment(3);

        $vendasSalvas = $this->venda->getVendasSalvas($data);

        if($vendasSalvas <> null){

            $this->session->set_flashdata('erro', 'Não é possível fechar caixa, ainda há vendas em aberto');
            redirect(base_url("vendas/frente-caixa/{$data}"), "home", "refresh");

        }   
        
        $empresa = $this->empresa->getEmpresaPorCodigo(getDadosUsuarioLogado()['id_empresa']);

        $recebimentoMetodo = $this->venda->getMetodoPagamentoPorDataCaixa($data);
        foreach($recebimentoMetodo as $key_recebimentoMetodo => $recebimento) {

            if($recebimento->dias_recebimento <> 0)
                $vencimento = date("Y-m-d", strtotime('+' . $recebimento->dias_recebimento . ' day', strtotime($recebimento->data_caixa)));
            else
                $vencimento = $recebimento->data_caixa;

            $valorTaxa = 0;
            if($recebimento->taxa_operacao != null && $recebimento->taxa_operacao != 0){
                $valorTaxa = $recebimento->total_venda * ($recebimento->taxa_operacao / 100);
            }
            

            $dadosMovimento = null;
            $dadosMovimento = [
                'cod_conta' => $recebimento->cod_conta,
                'cod_metodo_pagamento' => $recebimento->cod_metodo_pagamento,
                'cod_centro_custo' => $empresa->centro_custo_frente_caixa,
                'cod_conta_contabil' => $empresa->conta_contabil_frente_caixa,
                'tipo_movimento' => 1,
                'data_competencia' => $recebimento->data_caixa,
                'data_vencimento' => $vencimento,
                'parcela' => '1/1',
                'desc_movimento' => 'Frente de Caixa' . " - Data Caixa: " .  str_replace('-', '/', date("d-m-Y", strtotime($recebimento->data_caixa))),
                'valor_titulo' => $recebimento->total_venda,
                'origem_movimento' => 4,
                'id_origem' => intval(str_replace('-', '', date("d-m-Y", strtotime($recebimento->data_caixa)))),
                'confirmado' => 0,
                'valor_desc_taxa' => $valorTaxa,
            ];
            $this->financeiro->insertMovimentoConta($dadosMovimento);
        }

        // Atualiza registro de venda
        $dados = [
            'data_hora_fechamento' => date('Y-m-d H:i:s'),
        ];
        $this->venda->updateControleCaixa($data, $dados);

        $this->session->set_flashdata('sucesso', 'Caixa fechado com sucesso');
        redirect(base_url("vendas/frente-caixa/{$data}"), "home", "refresh");
    }

    public function inserirMovimento(){

        $data = $this->uri->segment(3);

        // Cria registro de venda
        $dados = [
            'id_empresa'  => getDadosUsuarioLogado()['id_empresa'],
            'data_caixa' => $data,
            'data_hora_movimento' => date('Y-m-d H:i:s'),
            'tipo_movimento' => $this->input->post('TipoMovimento'),
            'valor_movimento' => str_replace(",",".",(str_replace(".","",$this->input->post('ValorMovimento')))),
            'observacao' => $this->input->post('ObsMovimento'),
            
        ];
        $this->venda->inserirMovimentoCaixa($dados);

        $this->session->set_flashdata('sucesso', 'Movimento realizado com sucesso');
        redirect(base_url("vendas/frente-caixa/{$data}"), "home", "refresh");



    }

    public function novaVendaCaixa(){

        $data = $this->uri->segment(3);

        $empresa = $this->empresa->getEmpresaPorCodigo(getDadosUsuarioLogado()['id_empresa']);
        $listaCliente = $this->cliente->getCliente();
        $listaProduto = $this->produto->getProdutoVenda(); 
        $listaMetodoPagamento = $this->financeiro->getMetodoPagamento();  
        $listaSegmento = $this->tabelasauxiliares->getSegmento();
        $listaCidade = $this->tabelasauxiliares->getCidade();      

        $dados = array(
            'empresa' => $empresa,
            'dia' => $data,
            'lista_cliente' => $listaCliente,
            'lista_produto' => $listaProduto, 
            'lista_metodo_pagamento' => $listaMetodoPagamento,
            'lista_segmento' => $listaSegmento,
            'lista_cidade' => $listaCidade,
            'menu' => 'Vendas'
        );
        

        $this->load->view('vendas/nova-venda-caixa', $dados);

    } 

    public function editarVendaCaixa(){

        $numVendaCaixa = $this->uri->segment(4);

        $vendaCaixa = $this->venda->getVendaCaixaPorCodigo($numVendaCaixa);

        $empresa = $this->empresa->getEmpresaPorCodigo(getDadosUsuarioLogado()['id_empresa']);
        $listaProdutoVendaCaixa = $this->venda->getProdutoPorVendaCaixa($numVendaCaixa);
        $listaMetodoVendaCaixa = $this->venda->getMetodoPagamentoPorVendaCaixa($numVendaCaixa);

        
        $listaCliente = $this->cliente->getCliente();
        $listaProduto = $this->produto->getProdutoVenda(); 
        $listaMetodoPagamento = $this->financeiro->getMetodoPagamento();  

        $dados = array(            
            'venda_caixa' => $vendaCaixa,
            'empresa' => $empresa,
            'produto_venda_caixa' => $listaProdutoVendaCaixa,
            'metodo_venda_caixa' => $listaMetodoVendaCaixa,
            'lista_cliente' => $listaCliente,
            'lista_produto' => $listaProduto, 
            'lista_metodo_pagamento' => $listaMetodoPagamento,
            'menu' => 'Vendas'
        );
        

        $this->load->view('vendas/editar-venda-caixa', $dados);

    } 

    public function imprimirVendaCaixa($numVendaCaixa)   
    {

        $empresa = $this->empresa->getEmpresaPorCodigo(getDadosUsuarioLogado()['id_empresa']);
        $vendaCaixa = $this->venda->getVendaCaixaPorCodigo($numVendaCaixa);
        $listaCliente = $this->cliente->getClientePorCodigo($vendaCaixa->cod_cliente); 
        $listaProdutoVendaCaixa = $this->venda->getProdutoPorVendaCaixa($numVendaCaixa);
        $listaMetodoVendaCaixa = $this->venda->getMetodoPagamentoPorVendaCaixa($numVendaCaixa);

        $dados = array(
            'empresa' => $empresa,
            'cliente' => $listaCliente,
            'venda' => $vendaCaixa,
            'lista_produto' => $listaProdutoVendaCaixa, 
            'lista_metodo' => $listaMetodoVendaCaixa, 
            'menu' => ''
        );        

        $this->load->view('vendas/imprime-venda-frente-caixa', $dados);       

    }    

    public function inserirVendaCaixa(){
        $dataVenda = $this->uri->segment(3);

        $controleCaixa = $this->venda->getControleCaixaPorCodigo($dataVenda);

        if($controleCaixa == null){

            $this->session->set_flashdata('erro', 'Caixa do dia ' . str_replace('-', '/', date("d-m-Y", strtotime($dataVenda))) . ' não está aberto');
            redirect(base_url("vendas/frente-caixa/{$dataVenda}"), "home", "refresh");

        }

        $status = $this->input->post('Opcao');

        $codProduto = $this->input->post('codProduto[]');
        $quantProduto = $this->input->post('quantProduto[]');
        $valorUnitProdutos = $this->input->post('valorUnitProduto[]');

        $codMetodoPagamento = $this->input->post('codMetodoPagamento[]');
        $valorFormaPagamento = $this->input->post('valorFormaPagamento[]');

        // Cria registro de venda
        $dados = [
            'id_empresa'  => getDadosUsuarioLogado()['id_empresa'],
            'data_caixa' => $dataVenda,
            'data_hora_venda' => date('Y-m-d H:i:s'),
            'cod_cliente' => $this->input->post('CodCliente'),
            'tipo_pessoa' => $this->input->post('TipoPessoa'),
            'cnpj_cpf' => $this->input->post('CnpjCpf'),
            'tipo_desconto' => $this->input->post('TipoDesconto'),
            'valor_bruto' => str_replace(",",".",(str_replace(".","",$this->input->post('SubTotal')))),
            'valor_desconto' => str_replace(",",".",(str_replace(".","",$this->input->post('ValorDesconto')))),
            'status' => $status,
        ];
        $numVendaCaixa = $this->venda->inserirVendaCaixa($dados);
        

        //Grava itens do pedido
        for ($i = 0; $i < count($codProduto); $i++) {

            $dadosProd[] = (object)[
                'num_venda_caixa' => $numVendaCaixa,
                'cod_produto' => $codProduto[$i],
                'quant_venda' => $quantProduto[$i],
                'valor_unit' => str_replace(",",".",(str_replace(".","",$valorUnitProdutos[$i]))),             
            ]; 
            
            if($status == 2){

                $quantPro = str_replace(",",".",(str_replace(".","",$quantProduto[$i])));
                $valUnit = str_replace(",",".",(str_replace(".","",$valorUnitProdutos[$i])));

                // Movimenta estoque
                $dadosEstoque = null;
                $dadosEstoque = [
                    'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                    'data_movimento' => $dataVenda,
                    'cod_produto' => $codProduto[$i],
                    'origem_movimento' => 6,
                    'id_origem' => $numVendaCaixa,
                    'tipo_movimento' => 2,
                    'especie_movimento' => 5,
                    'quant_movimentada' => $quantPro,
                    'valor_movimento' => $quantPro * $valUnit, 
                ];
                $this->estoque->insertMovimentoEstoque($dadosEstoque);

            }
            
        }
        $this->venda->inserirProdutosCaixa($dadosProd);

        // Gravar formas de pagamento
        for ($i = 0; $i < count($codMetodoPagamento); $i++) {

            $dadosForma[] = (object)[
                'num_venda_caixa' => $numVendaCaixa,
                'cod_metodo_pagamento' => $codMetodoPagamento[$i],
                'valor_pagamento' => str_replace(",",".",(str_replace(".","",$valorFormaPagamento[$i]))),          
            ];           
            
        }
        $this->venda->inserirFormaPagamentoCaixa($dadosForma);        

        $this->session->set_flashdata('sucesso', 'Venda realizada com sucesso');

        if($status == 1)
            redirect(base_url("vendas/frente-caixa/editar-venda-caixa/{$numVendaCaixa}"), "home", "refresh");
        else
            redirect(base_url("vendas/frente-caixa/{$dataVenda}"), "home", "refresh");
    }

    public function salvarVendaCaixa(){
        $numVendaCaixa = $this->uri->segment(4);

        $vendaCaixa = $this->venda->getVendaCaixaPorCodigo($numVendaCaixa);

        $status = $this->input->post('Opcao');

        $codProduto = $this->input->post('codProduto[]');
        $quantProduto = $this->input->post('quantProduto[]');
        $valorUnitProdutos = $this->input->post('valorUnitProduto[]');

        $codMetodoPagamento = $this->input->post('codMetodoPagamento[]');
        $valorFormaPagamento = $this->input->post('valorFormaPagamento[]');

        // Salvar registro de venda
        $dados = [
            'id_empresa'  => getDadosUsuarioLogado()['id_empresa'],
            'cod_cliente' => $this->input->post('CodCliente'),
            'tipo_pessoa' => $this->input->post('TipoPessoa'),
            'cnpj_cpf' => $this->input->post('CnpjCpf'),
            'valor_bruto' => str_replace(",",".",(str_replace(".","",$this->input->post('SubTotal')))),
            'tipo_desconto' => $this->input->post('TipoDesconto'),
            'valor_desconto' => str_replace(",",".",(str_replace(".","",$this->input->post('ValorDesconto')))),
            'status' => $status,
        ];
        $this->venda->updateVendaCaixa($numVendaCaixa, $dados);

        $this->venda->deleteProdutoVendaCaixa($numVendaCaixa);        
        $this->venda->deleteFormaPagamento($numVendaCaixa);        

        //Grava itens do pedido
        for ($i = 0; $i < count($codProduto); $i++) {

            $dadosProd[] = (object)[
                'num_venda_caixa' => $vendaCaixa->num_venda_caixa,
                'cod_produto' => $codProduto[$i],
                'quant_venda' => $quantProduto[$i],
                'valor_unit' => str_replace(",",".",(str_replace(".","",$valorUnitProdutos[$i]))),             
            ];              
            
            if($status == 2){

                $quantPro = str_replace(",",".",(str_replace(".","",$quantProduto[$i])));
                $valUnit = str_replace(",",".",(str_replace(".","",$valorUnitProdutos[$i])));

                // Movimenta estoque
                $dadosEstoque = null;
                $dadosEstoque = [
                    'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                    'data_movimento' => $vendaCaixa->data_caixa,
                    'cod_produto' => $codProduto[$i],
                    'origem_movimento' => 6,
                    'id_origem' => $numVendaCaixa,
                    'tipo_movimento' => 2,
                    'especie_movimento' => 5,
                    'quant_movimentada' => $quantPro,
                    'valor_movimento' => $quantPro * $valUnit, 
                ];
                $this->estoque->insertMovimentoEstoque($dadosEstoque);

            }
            
        }
        $this->venda->inserirProdutosCaixa($dadosProd);

        // Gravar formas de pagamento
        for ($i = 0; $i < count($codMetodoPagamento); $i++) {

            $dadosForma[] = (object)[
                'num_venda_caixa' => $vendaCaixa->num_venda_caixa,
                'cod_metodo_pagamento' => $codMetodoPagamento[$i],
                'valor_pagamento' => str_replace(",",".",(str_replace(".","",$valorFormaPagamento[$i]))),          
            ];           
            
        }
        $this->venda->inserirFormaPagamentoCaixa($dadosForma);

        $this->session->set_flashdata('sucesso', 'Venda realizada com sucesso');
        if($status == 1)
            redirect(base_url("vendas/frente-caixa/editar-venda-caixa/{$vendaCaixa->num_venda_caixa}"), "home", "refresh");
        else
            redirect(base_url("vendas/frente-caixa/{$vendaCaixa->data_caixa}"), "home", "refresh");
        
    }

    public function estornoVendaCaixa(){

        $data = $this->uri->segment(4);

        $numVendaCaixa = $this->input->post("selecionar_vendas");

        foreach($numVendaCaixa as $venda){     

            $vendaCaixa = $this->venda->getVendaCaixaPorCodigo($venda);
            if($vendaCaixa->status == 2){

                $listaProdutoVendaCaixa = $this->venda->getProdutoPorVendaCaixa($vendaCaixa->num_venda_caixa);
                foreach($listaProdutoVendaCaixa as $key_venda_caixa => $vendaProduto) {

                    

                    // Estorna estoque do produto vendido
                    $dados = null; 
                    $dados = [
                        'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                        'data_movimento' => $vendaCaixa->data_caixa,
                        'cod_produto' => $vendaProduto->cod_produto,
                        'origem_movimento' => 6,
                        'id_origem' => $vendaCaixa->num_venda_caixa,
                        'tipo_movimento' => 1,
                        'especie_movimento' => 9,
                        'quant_movimentada' => $vendaProduto->quant_venda,
                        'valor_movimento' => $vendaProduto->quant_venda * $vendaProduto->valor_unit
                    ];
                    $this->estoque->insertMovimentoEstoque($dados);
                }
            }
            
            // Salvar registro de venda
            $dados = null;
            $dados = [
                'status' => 3,
            ];
            $this->venda->updateVendaCaixa($vendaCaixa->num_venda_caixa, $dados);
        }  
        
        

        $this->session->set_flashdata('sucesso', 'Estorno realizado com sucesso');
        redirect(base_url("vendas/frente-caixa/{$data}"), "home", "refresh");
    }

    public function editarPedidoVenda($numPedidoVenda){

        $listaPedidoVenda = $this->venda->getPedidoVendaPorCodigo($numPedidoVenda);
        $listaVendedor = $this->vendedor->getVendedor();
        $listaProdVenda = $this->venda->getProdutoPorPedido($numPedidoVenda);
        $listaProduto = $this->produto->getProdutoVenda($listaProdVenda);        

        if($listaPedidoVenda == null){
            redirect(base_url('vendas/pedido-venda'));
            
        }else{ 

            $dados = array(
                'pedido' => $listaPedidoVenda,
                'lista_vendedor' => $listaVendedor,
                'lista_produto_venda' => $listaProdVenda,
                'lista_produto' => $listaProduto,                
                'menu' => 'Vendas'
            );       

            $this->load->view('vendas/editar-pedido-venda', $dados);
        }
    }

 

    public function editFaturamentoPedido($numPedidoVenda){

        $listaEmpresa = $this->empresa->getEmpresaPorCodigo(getDadosUsuarioLogado()['id_empresa']);
        $listaPedido = $this->venda->getPedidoVendaAprovPorCodigo($numPedidoVenda);
        $listaCliente = $this->cliente->getClientePorCodigo($listaPedido->cod_cliente);
        $listaFaturamento = $this->venda->getFaturamentosPorPedido($numPedidoVenda);
     
        $listaProdutosPedido = $this->venda->getProdutoPorPedido($numPedidoVenda);
        $listaProdutoFaturado = $this->venda->getProdutoFaturadoPorPedido($numPedidoVenda);
        $listaConta = $this->financeiro->getContaAtivaRel();
        $listaMetodoPagamento = $this->financeiro->getMetodoPagamento();
        $listaContaContabil = $this->financeiro->getContaContabilAtivo();
        $listaCentroCusto = $this->financeiro->getCentroCustoAtivo();
        $listaCidade = $this->tabelasauxiliares->getCidade();
        $listaNCM = $this->produto->getNCM(); 

        if($listaPedido == null){
            redirect(base_url('vendas/atendimento-pedido'));
        }else{ 

            $dados = array(
                'empresa' => $listaEmpresa,
                'pedido' => $listaPedido,
                'cliente' => $listaCliente,
                'lista_faturamento' => $listaFaturamento,
                'lista_produto' => $listaProdutosPedido,  
                'lista_faturamento_produto' => $listaProdutoFaturado,
                'lista_centro_custo' => $listaCentroCusto, 
                'lista_conta' => $listaConta,
                'lista_metodo_pagamento' => $listaMetodoPagamento,
                'lista_conta_contabil' => $listaContaContabil,
                'lista_centro_custo' => $listaCentroCusto, 
                'lista_cidade' => $listaCidade,     
                'lista_ncm' => $listaNCM,       
                'menu' => 'Vendas'
                
            );
            //var_dump($listaProdutoFaturado);
            
            $this->load->view('vendas/novo-faturamento-pedido', $dados);
        }

    } 

    public function inserirFaturamento(){

        $numPedidoVenda = $this->uri->segment(4);
        $codCliente = $this->uri->segment(5);

        $this->form_validation->set_rules('DataFaturamento', 'Data de Faturamento', 'required|max_length[60]|callback_date_check', 
            array('required' => 'Você deve preencher o campo %s'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            redirect(base_url("vendas/faturamento-pedido/novo-faturamento-pedido/{$numPedidoVenda}"), "home", "refresh");
            
        }else { 

            $quantVendida = $this->input->post('quantVendida');
            $ValorVenda = $this->input->post('ValorVenda');

            $empresa = $this->empresa->getEmpresaPorCodigo(getDadosUsuarioLogado()['id_empresa']);
            $cliente = $this->cliente->getClientePorCodigo($codCliente);

            $pedido = $this->venda->getPedidoVendaPorCodigo($numPedidoVenda);

            $lista_produto_venda = $this->venda->getProdutoPorPedido($numPedidoVenda);
            foreach($lista_produto_venda as $key_produto_venda => $produto) {

                $quan_vendida = floatval(str_replace(",",".",(str_replace(".","",$quantVendida[$produto->cod_produto]))));

                if($produto->saldo_negativo != 1 && $produto->quant_estoq < $quan_vendida){
                    $this->session->set_flashdata('erro', 'Produto (' . $produto->cod_produto . ' - ' . $produto->nome_produto . ') sem saldo suficiente para venda');
                    redirect(base_url("vendas/faturamento-pedido/novo-faturamento-pedido/{$numPedidoVenda}"), "home", "refresh");  
                }
            }

            $valor_desconto = floatval(str_replace(",",".",(str_replace(".","",$this->input->post('ValorDesconto')))));

            // Cria registro de faturamento
            $data = [
                'num_pedido_venda'  => $numPedidoVenda,
                'data_faturamento' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataFaturamento')))),
                'serie' => $this->input->post('Serie'),
                'nota_fiscal' => $this->input->post('NotaFiscal'),
                'valor_bruto' => str_replace(",",".",(str_replace(".","",$this->input->post('ValorBruto')))),
                'valor_desconto' => str_replace(",",".",(str_replace(".","",$this->input->post('ValorDesconto')))),
                'valor_frete' => str_replace(",",".",(str_replace(".","",$this->input->post('ValorFrete')))),
                'observacoes' => $this->input->post('ObservFatur')
            ];
            $codFaturamentoPedido = $this->venda->insertFaturamento($data);
            
            $total_venda = 0;            
            foreach($lista_produto_venda as $key_produto_venda => $produto) {

                $quan_vendida = floatval(str_replace(",",".",(str_replace(".","",$quantVendida[$produto->cod_produto]))));
                $valor_venda = $quan_vendida * $produto->valor_unitario;
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
                    'quant_movimentada' => $quan_vendida,
                    'valor_movimento' => $valor_venda
                ];
                $this->estoque->insertMovimentoEstoque($dadosEstoque);

                $produtoVenda = $this->venda->getProdutoVendaPorCodigo($numPedidoVenda, $produto->cod_produto);

                if($produtoVenda->quant_atendida > 0){
                    if(($produtoVenda->quant_atendida + $quan_vendida) >= $produtoVenda->quant_pedida) {
                        $status = 3;
                    }else{
                        $status = 2;
                    }            
                }else{
                    if($quan_vendida >= $produtoVenda->quant_pedida) {
                        $status = 3;
                    }else{
                        $status = 2;
                    } 
                }

                $dados = [
                    'quant_atendida' => $produtoVenda->quant_atendida + $quan_vendida,
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
                    'cod_conta' => $this->input->post('CodConta'),
                    'cod_metodo_pagamento' => $this->input->post('CodMetodoPagamento'),
                    'cod_centro_custo' => $this->input->post('CodCentroCusto'),
                    'cod_conta_contabil' => $this->input->post('CodContaContabil'),
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
        redirect(base_url("vendas/faturamento-pedido/novo-faturamento-pedido/{$numPedidoVenda}"), "home", "refresh");

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
                'cod_vendedor'  => $this->input->post('CodVendedor'),
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
            redirect(base_url("vendas/pedido-venda/editar-pedido-venda/{$codPedidoVenda}"), "home", "refresh");
                       
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
            redirect(base_url("vendas/pedido-venda/editar-pedido-venda/{$numPedidoVenda}"), "home", "refresh");

        }else{

            $dados = [
                'num_pedido_venda' => $numPedidoVenda,
                'cod_produto'  => $this->input->post('CodProduto'),
                'quant_pedida' => str_replace(",",".",(str_replace(".","",$this->input->post('QuantPedida')))),
                'valor_unitario' => str_replace(",",".",(str_replace(".","",$this->input->post('ValorUnitario'))))
            ];

            $this->venda->insertProdutoVenda($dados);
            $this->session->set_flashdata('sucesso', 'Produto de venda inserido com sucesso');
            redirect(base_url("vendas/pedido-venda/editar-pedido-venda/{$numPedidoVenda}"), "home", "refresh");

        }
    }  
    
    public function inserirSaida(){  
        $SeqProdutoVenda = $this->uri->segment(4);
        $codProduto = $this->uri->segment(5);

        //Validações dos campos
        $this->form_validation->set_rules('DataSaida', 'Data de Saída', 'required|callback_date_check', 
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('QuantSaida', 'Quantidade de Saída', 'required|callback_more_zero', 
            array('required' => 'Você deve preencher o campo %s'));
        
        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            redirect(base_url("vendas/atendimento-pedido/novo-atendimento-pedido/{$SeqProdutoVenda}"), "home", "refresh");
            
        }else {  
            
            $quantSaida = str_replace(",",".",(str_replace(".","",$this->input->post('QuantSaida'))));
            
            $produto = $this->produto->getProdutoPorCodigo($codProduto);
            if($produto->saldo_negativo != 1 && $produto->quant_estoq < $quantSaida){
                $this->session->set_flashdata('erro', 'Produto sem saldo suficiente para saída');
                redirect(base_url("vendas/atendimento-pedido/novo-atendimento-pedido/{$SeqProdutoVenda}"), "home", "refresh");
            }

            $dados = [
                'seq_produto_venda'  => $SeqProdutoVenda,
                'data_saida' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataSaida')))),
                'quant_saida' => str_replace(",",".",(str_replace(".","",$this->input->post('QuantSaida')))),
                'serie' => $this->input->post('Serie'),
                'nota_fiscal' => $this->input->post('NotaFiscal'),
                'valor_venda' => str_replace(",",".",(str_replace(".","",$this->input->post('ValorVenda')))),
                'observacoes' => $this->input->post('Observacoes')
            ];

            $codMovimentoPV = $this->venda->insertMovimentos($dados); 
            
            // Baixa estoque do produto vendido
            $dadosEstoque = [
                'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                'data_movimento' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataSaida')))),
                'cod_produto' => $codProduto,
                'origem_movimento' => 3,
                'id_origem' => $codMovimentoPV,
                'tipo_movimento' => 2,
                'especie_movimento' => 5,
                'quant_movimentada' => str_replace(",",".",(str_replace(".","",$this->input->post('QuantSaida'))))
            ];

            $this->estoque->insertMovimentoEstoque($dadosEstoque);

            $this->session->set_flashdata('sucesso', 'Saída de material inserida com sucesso');
            redirect(base_url("vendas/atendimento-pedido/novo-atendimento-pedido/{$SeqProdutoVenda}"), "home", "refresh");

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
            redirect(base_url("vendas/pedido-venda/editar-pedido-venda/{$numPedidoVenda}"));
                       
        }  
    }

    public function excluirPedido(){

        $NumPedidoVenda = $this->input->post("excluir_todos");
        $numRegs = count($NumPedidoVenda);

        if($numRegs > 0){    
            $this->venda->deleteProdutoVendaPorPedido($NumPedidoVenda);        
            $this->venda->deletePedido($NumPedidoVenda);
            $this->session->set_flashdata('sucesso', 'Registro(s) selecionado(s) excluído(s)');
        }else {
            $this->session->set_flashdata('erro', 'Nenhum registro foi selecionado');
        }

        redirect(base_url('vendas/pedido-venda'));
    }    

    public function excluirMovimentoCaixa(){

        $data = $this->uri->segment(4);

        $codMovimento = $this->input->post("selecionar_movimentos");

        $this->venda->deleteMovimentoCaixa($codMovimento); 
        $this->session->set_flashdata('sucesso', 'Registro(s) selecionado(s) excluído(s)');

        redirect(base_url("vendas/frente-caixa/{$data}"), "home", "refresh");
    }

    public function excluirProdutoVenda(){

        $SeqProdutoVenda = $this->input->post("excluir_todos");
        $numRegs = count($SeqProdutoVenda);

        if($numRegs > 0){            
            $this->venda->deleteProdutoVenda($SeqProdutoVenda);
            $this->session->set_flashdata('sucesso', 'Registro(s) selecionado(s) excluído(s)');
        }else{ 
            $this->session->set_flashdata('erro', 'Nenhum registro foi selecionado');
        }

        $NmPedidoVenda = $this->input->post('NumPedidoVenda');
        redirect(base_url("vendas/pedido-venda/editar-pedido-venda/{$NmPedidoVenda}"), "home", "refresh");
    }

    public function estornarFaturamentoPedido($numPedidoVenda){

        $codFaturamento = $this->input->post("estornar_todos");

        foreach($codFaturamento as $faturamento){ 

            $faturamentoPedido = $this->venda->getFaturamentoPorCodigo($faturamento);
            $movimentosFaturamento = $this->venda->getMovimentoPorFaturamento($faturamento);

            foreach($movimentosFaturamento as $key_movimentos => $movimentos_estoque){

                // Estorna estoque do produto vendido
                $dados = null; 
                $dados = [
                    'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                    'data_movimento' => $movimentos_estoque->data_movimento,
                    'cod_produto' => $movimentos_estoque->cod_produto,
                    'origem_movimento' => 3,
                    'id_origem' => $faturamento,
                    'tipo_movimento' => 1,
                    'especie_movimento' => 9,
                    'quant_movimentada' => $movimentos_estoque->quant_movimentada,
                    'valor_movimento' => $movimentos_estoque->valor_movimento
                ];

                $this->estoque->insertMovimentoEstoque($dados);

                // Atualiza movimento de estoque
                $dados = null;                
                $dados = [
                    'considera_calc_custo' => '1'
                ];        
                $this->estoque->updateMovimentoEstoque($movimentos_estoque->cod_movimento_estoque, $dados);

                $produtoVenda = $this->venda->getProdutoVendaPorCodigo($numPedidoVenda, $movimentos_estoque->cod_produto);
                
                if(($produtoVenda->quant_atendida - $movimentos_estoque->quant_movimentada) >= $produtoVenda->quant_pedida) {
                    $status = 3;
                }elseif(($produtoVenda->quant_atendida - $movimentos_estoque->quant_movimentada) == 0){
                    $status = 4;
                }else{
                    $status = 2;
                }  

                $dados = [
                    'quant_atendida' => $produtoVenda->quant_atendida - $movimentos_estoque->quant_movimentada,
                    'status' => $status
                ];
                $this->venda->updateProdutoVenda($produtoVenda->seq_produto_venda, $dados);
            }

            // Atualiza faturamento
            $dados = null;                
            $dados = [
                'estornado' => '1'
            ];

            $this->venda->updateFaturamento($faturamento, $dados);

            //Exclui títulos não confirmados
            $this->financeiro->excluirTituloOrigem(3, $faturamento);
        }    
        
        $this->session->set_flashdata('sucesso', 'Registro(s) selecionado(s) estornado(s) com sucesso');
        redirect(base_url("vendas/faturamento-pedido/novo-faturamento-pedido/{$numPedidoVenda}"), "home", "refresh");

    }

    public function estornarSaidaMaterial($seqProdutoVenda = null){

        $codMovimentoPV = $this->input->post("estornar_todos");
        $numRegs = count($codMovimentoPV);

        if($numRegs > 0){
            
            foreach($codMovimentoPV as $movimento){  

                // Atualiza sequencia do item
                $movimentoSaida = $this->venda->getMovimentosPorCodigo($movimento);
                $produtoVenda = $this->venda->getProdutoVendaPorCodigo($movimentoSaida->seq_produto_venda);

                if(($produtoVenda->quant_atendida - $movimentoSaida->quant_saida) >= $produtoVenda->quant_pedida) {
                    $status = 3;
                }elseif(($produtoVenda->quant_atendida - $movimentoSaida->quant_saida) == 0){
                    $status = 1;
                }else{
                    $status = 2;
                }  

                $dados = [
                    'quant_atendida' => $produtoVenda->quant_atendida - $movimentoSaida->quant_saida,
                    'status' => $status
                ];

                $this->venda->updateProdutoVenda($produtoVenda->seq_produto_venda, $dados);

                $dados = null;

                // Atualiza reporte de produção                
                $dados = [
                    'estornado' => '1'
                ];
    
                $this->venda->updateMovimento($movimento, $dados); 

                // Baixa estoque do produto vendido
                $dadosEstoque = [
                    'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                    'data_movimento' => $movimentoSaida->data_saida,
                    'cod_produto' => $produtoVenda->cod_produto,
                    'origem_movimento' => 3,
                    'id_origem' => $movimentoSaida->cod_movimento_pv,
                    'tipo_movimento' => 1,
                    'especie_movimento' => 9,
                    'quant_movimentada' => $movimentoSaida->quant_saida
                ];

                $this->estoque->insertMovimentoEstoque($dadosEstoque); 
                
            }
            
            $this->session->set_flashdata('sucesso', 'Registro(s) selecionado(s) estornado(s) com sucesso');

        }else{ 
            $this->session->set_flashdata('erro', 'Nenhum registro foi selecionado');
        }

        redirect(base_url("vendas/atendimento-pedido/novo-atendimento-pedido/{$seqProdutoVenda}"), "home", "refresh");     

    }

    public function listarPedidoVenda(){ 

        $config = array(
            'base_url' => base_url('vendas/pedido-venda'),
            'per_page' => 10,
            'num_links' => 10,
            'uri_segment' => 3,
            'total_rows' => $this->venda->countAll(),
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
        $listaPedidoVenda = $this->venda->getPedidoVenda($filter, $config["per_page"], $offset);
        $listaStatus = $this->venda->defineStatusPedido($listaPedidoVenda);
        $empresa = $this->empresa->getEmpresaPorCodigo(getDadosUsuarioLogado()['id_empresa']);


        $dados = array(
            'pagination' => $this->pagination->create_links(),
            'empresa' => $empresa,
            'lista_pedido' => $listaPedidoVenda,
            'ped_status' => $listaStatus,
            'menu' => 'Vendas'
        );

        $this->load->view('vendas/pedido-venda', $dados);
    }

    public function listarFaturamentoVenda(){   

        $config = array(
            'base_url' => base_url('vendas/faturamento-pedido'),
            'per_page' => 10,
            'num_links' => 10,
            'uri_segment' => 3,
            'total_rows' => $this->venda->countAllProduto(),
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
        $listaPedidoVenda = $this->venda->getPedidoVendaAprovado($filter, $config["per_page"], $offset);
        $listaStatus = $this->venda->defineStatusPedido($listaPedidoVenda);


        $dados = array(
            'pagination' => $this->pagination->create_links(),
            'lista_pedido' => $listaPedidoVenda,
            'ped_status' => $listaStatus,
            'menu' => 'Vendas'
        );

        $this->load->view('vendas/faturamento-pedido', $dados);
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
                    'cod_vendedor'  => $this->input->post('CodVendedor'),
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
                    'cod_vendedor'  => $this->input->post('CodVendedor'),
                    'perc_comissao' => str_replace(",",".",(str_replace(".","",$this->input->post('PerComissao')))), 
                    'data_entrega' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataEntrega')))),
                    'observacoes' => $this->input->post('ObsPedidoVenda'),
                    'tipo_desconto' => $this->input->post('TipoDesconto'),
                    'tipo_frete' => $this->input->post('TipoFrete'),
                    'valor_frete' => str_replace(",",".",(str_replace(".","",$this->input->post('Frete')))), 
                    'valor_desconto' => str_replace(",",".",(str_replace(".","",$this->input->post('Desconto')))), 
                ];
            }            

            $this->venda->updatePedidoVenda($numPedidoVenda, $data);

            $this->session->set_flashdata('sucesso', 'Pedido de venda alterado com sucesso');
            redirect(base_url("vendas/pedido-venda/editar-pedido-venda/{$numPedidoVenda}"), "home", "refresh");    
                       
        }  
    }  

    public function importaAtendimentosVendasExternas(){

        $dataAtendimentos =  date("Y-m-d", strtotime(str_replace('/', '-', $this->input->get('DataAtendimento'))));

        $empresa = $this->empresa->getEmpresaPorCodigo(getDadosUsuarioLogado()['id_empresa']);

        // Valida token existente e válido
        if($empresa->token_acesso_vendas_externas == null){
            // Cria novo token
            $token = $this->vendasexternas->conectaVendasExternas($empresa->integ_usuario_vendas_externas, $empresa->integ_senha_vendas_externas);

        }elseif($empresa->token_acesso_vendas_externas != null && $empresa->validade_token_vendas_externas < date('Y-m-d H:i:s')){
            // Renova Token
            $token = $this->vendasexternas->getRenovacaoToken($empresa->token_renovacao_vendas_externas);

        }else{
            // Token válido
            $token = $empresa->token_acesso_vendas_externas;
        }

        // Se token inválido, processo não continua
        if($token == false){
           redirect(base_url("vendas/pedido-venda"), "home", "refresh");
        }

        // Importa os atendimentos
        $this->vendasexternas->getAtendimentos($token, $dataAtendimentos);
        redirect(base_url("vendas/pedido-venda"), "home", "refresh");  

    }
    
    //Relatórios
    public function vendaProduto(){
        
        $dataInicio = "";
        $dataFim = "";

        if($this->input->get('DataInicio') != "" && $this->input->get('DataFim') != ""){
            $dataInicio = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->get('DataInicio'))));
            $dataFim = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->get('DataFim'))));
        }

        $codProdutos = $this->input->get('produto'); 
        
        if($dataInicio == ""){
            $dataInicio = date('Y-m-01');
        }

        if($dataFim == ""){
            $dataFim = date('Y-m-d');
        }

        $listaProdutoVend = $this->produto->getProduto();        
        $totalVenda = $this->venda->totalVendaProduto($dataInicio, $dataFim, $codProdutos);
        $listaVendaResumida = $this->venda->vendaResumida($dataInicio, $dataFim, $codProdutos);
        $listaVendaDetalhada = $this->venda->vendaDetalhada($dataInicio, $dataFim, $codProdutos);

        $dados = array(
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
            'cod_produto' => $codProdutos,
            'lista_produto_vend' => $listaProdutoVend,
            'total_venda' => $totalVenda,
            'lista_venda_resumida' => $listaVendaResumida,
            'lista_venda_detalhada' => $listaVendaDetalhada,
            'menu' => 'Vendas'
            
        );

        $this->load->view('vendas/venda-produto', $dados);

    }

    public function vendaCliente(){

        $dataInicio = "";
        $dataFim = "";

        if($this->input->get('DataInicio') != "" && $this->input->get('DataFim') != ""){
            $dataInicio = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->get('DataInicio'))));
            $dataFim = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->get('DataFim'))));
        }
        $codClientes = $this->input->get('cliente');
        
        if($dataInicio == ""){
            $dataInicio = date('Y-m-01');
        }

        if($dataFim == ""){
            $dataFim = date('Y-m-d');
        }        

        $listaCliente = $this->cliente->getCliente();        
        $totalVenda = $this->venda->totalVendaCliente($dataInicio, $dataFim, $codClientes);
        $listaClienteResumida = $this->venda->clienteResumida($dataInicio, $dataFim, $codClientes);
        $listaClienteDetalhada = $this->venda->clienteDetalhada($dataInicio, $dataFim, $codClientes);

        $dados = array(
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
            'cod_cliente' => $codClientes,
            'lista_cliente' => $listaCliente,
            'total_venda' => $totalVenda,
            'lista_cliente_resumida' => $listaClienteResumida,
            'lista_cliente_detalhada' => $listaClienteDetalhada,
            'menu' => 'Vendas'
            
        );

        $this->load->view('vendas/venda-cliente', $dados);

    }

    public function vendaVendedor(){

        $dataInicio = "";
        $dataFim = "";

        if($this->input->get('DataInicio') != "" && $this->input->get('DataFim') != ""){
            $dataInicio = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->get('DataInicio'))));
            $dataFim = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->get('DataFim'))));
        }
        $codVendedores = $this->input->get('vendedor');
        
        if($dataInicio == ""){
            $dataInicio = date('Y-m-01');
        }

        if($dataFim == ""){
            $dataFim = date('Y-m-d');
        }        

        $listaVendedor = $this->vendedor->getVendedor();        
        $totalVenda = $this->venda->totalVendaVendedor($dataInicio, $dataFim, $codVendedores);
        $listaVendedorResumida = $this->venda->vendedorResumida($dataInicio, $dataFim, $codVendedores);
        $listaVendedorDetalhada = $this->venda->vendedorDetalhada($dataInicio, $dataFim, $codVendedores);

        $dados = array(
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
            'cod_vendedor' => $codVendedores,
            'lista_vendedor' => $listaVendedor,
            'total_venda' => $totalVenda,
            'lista_vendedor_resumida' => $listaVendedorResumida,
            'lista_vendedor_detalhada' => $listaVendedorDetalhada,
            'menu' => 'Vendas'
            
        );

        $this->load->view('vendas/venda-vendedor', $dados);

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

    public function visaoVendas(){
        $dataInicio = "";
        $dataFim = "";

        if($this->input->get('DataInicio') != "" && $this->input->get('DataFim') != ""){
            $dataInicio = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->get('DataInicio'))));
            $dataFim = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->get('DataFim'))));
        }
        
        if($dataInicio == ""){
            $dataInicio = date('Y-m-01');
        }

        if($dataFim == ""){
            $dataFim = date('Y-m-d');
        }

        $listaVendasDia = $this->venda->getVendasDiaria($dataInicio, $dataFim);
        $listaVendaProduto = $this->venda->getVendaProduto($dataInicio, $dataFim);
        $listaVendaCliente = $this->venda->getVendaCliente($dataInicio, $dataFim);
        $listaVendaVendedor = $this->venda->getVendaVendedor($dataInicio, $dataFim);       

        // Venda Por Dia
        $labelVendaDia = array();
        $dadosVendaDia = array();
        $dadosDescontoDia = array();
        $labelDia = array();
        $labelNomMes = array();
        $labelAno = array();
        $totalVenda = 0;
        $totalDesconto = 0;
        foreach($listaVendasDia as $vendasdia){

            $labelVendaDia[] = str_replace('-', '/', date("d-m", strtotime($vendasdia->data)));
            $labelDia[] = date("d", strtotime($vendasdia->data));
            $labelNomMes[] = $vendasdia->nome_mes;
            $labelAno[] = date("Y", strtotime($vendasdia->data));
            $dadosVendaDia[] = $vendasdia->venda_dia;
            $dadosDescontoDia[] = $vendasdia->desconto_dia;
            $totalVenda = $totalVenda + $vendasdia->venda_dia;
            $totalDesconto = $totalDesconto + $vendasdia->desconto_dia;

        }

        // Venda por Produto
        $corVenda = array();
        $dadosVenda = array();
        $dadosProduto = array();
        $codProduto = array();
        $codUnidMedida = array();
        $descProduto = array();
        $quantVenda = array(); 
        $valorVenda = array();      
        foreach($listaVendaProduto as $key_VendaProduto => $vendaProduto){

            if($key_VendaProduto == 0){
                $corVenda[] = $this->random_color("");
            }else{
                $corVenda[] = $this->random_color($corVenda[$key_VendaProduto - 1]);
            }
                        
            $dadosVenda[] = ($vendaProduto->valor_vendido / $totalVenda) * 100;
            $dadosProduto[] = $vendaProduto->cod_produto . " - " . $vendaProduto->nome_produto;
            $codProduto[] = $vendaProduto->cod_produto;
            $codUnidMedida[] = $vendaProduto->cod_unidade_medida;
            $descProduto[] = $vendaProduto->nome_produto;
            $quantVenda[] = $vendaProduto->quant_vendido;
            $valorVenda[] = $vendaProduto->valor_vendido;

        }

        // Venda por Cliente
        $corCliente = array();
        $dadosCliente = array();
        $codCliente = array();
        $nomeCliente = array();
        $valorDesconto = array();
        foreach($listaVendaCliente as $key_VendaCliente => $vendaCliente){

            if($key_VendaCliente == 0){
                $corCliente[] = $this->random_color("#F47C3C");
            }else{
                $corCliente[] = $this->random_color($corCliente[$key_VendaCliente - 1]);
            }

            $dadosCliente[] = ($vendaCliente->total_venda / $totalVenda) * 100;

            if($vendaCliente->total_desconto > 0){
                $codCliente[] = $vendaCliente->cod_cliente;
                $nomeCliente[] = $vendaCliente->nome_cliente;
                $valorDesconto[] = $vendaCliente->total_desconto;
            }
        }

        // Venda por Vendedor
        $codVendedor = array();
        $nomeVendedor = array();
        $vendasVendedor = array();
        $valorComissao = array();
        foreach($listaVendaVendedor as $key_VendaVendedor => $vendaVendedor){

            $codVendedor[] = $vendaVendedor->cod_vendedor;
            $nomeVendedor[] = $vendaVendedor->nome_vendedor;
            $vendasVendedor[] = $vendaVendedor->total_venda;
            $valorComissao[] = $vendaVendedor->total_comissao;

        }

        $dados = array(
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,

            'dia' => $labelVendaDia,
            'venda_dia' => $dadosVendaDia,
            'desconto_dia' => $dadosDescontoDia,
            'total_venda' => $totalVenda,
            'total_desconto' => $totalDesconto,   
            'dia_nome' => $labelDia, 
            'nome_mes' => $labelNomMes,
            'ano' => $labelAno,     
            
            'venda_produto' => $listaVendaProduto,            
            'cor_venda' => $corVenda,
            'dados_venda' => $dadosVenda,
            'nome_produto' => $dadosProduto,

            'cod_produto' => $codProduto,
            'cod_unid_medida' => $codUnidMedida,
            'desc_produto' => $descProduto,
            'quant_venda' => $quantVenda,
            'valor_venda' => $valorVenda,

            'cor_cliente' => $corCliente,
            'dados_cliente' => $dadosCliente,
            'venda_cliente' => $listaVendaCliente,

            'cod_cliente' => $codCliente,
            'nome_cliente' => $nomeCliente,
            'valor_desconto' => $valorDesconto,

            'cod_vendedor' => $codVendedor,
            'nome_vendedor' => $nomeVendedor,
            'total_venda_vendedor' => $vendasVendedor,
            'total_comissao_vendedor' => $valorComissao,
            
            'menu' => 'Vendas'
        );

        $this->load->view('vendas/indicadores-vendas', $dados);

    }

    function random_color($cor_atual) {

        if($cor_atual == ""){
            $color = "#3e95cd";
        }elseif($cor_atual == "#3e95cd"){
            $color = "#8e5ea2";
        }elseif($cor_atual == "#8e5ea2"){
            $color = "#3cba9f";
        }elseif($cor_atual == "#3cba9f"){
            $color = "#e8c3b9";
        }elseif($cor_atual == "#e8c3b9"){
            $color = "#c45850";
        }elseif($cor_atual == "#c45850"){
            $color = "#F47C3C";
        }elseif($cor_atual == "#F47C3C"){
            $color = "#d9534f";
        }elseif($cor_atual == "#d9534f"){
            $color = "#93C54B";
        }elseif($cor_atual == "#93C54B"){
            $color = "#3e95cd";
        }

        return $color;
    }
}