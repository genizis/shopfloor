<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ComprasController extends CI_Controller {

    function __construct(){
        parent::__construct();

        if(usuarioLogado() == false){

            redirect(base_url("login"), "home", "refresh");

        }

        if(getDadosUsuarioLogado()['compras'] != 1){

            redirect(base_url("visao-geral"), "home", "refresh");

        }
    }

    public function imprimirPedido($numPedidoCompra)   
    {

        $empresa = $this->empresa->getEmpresaPorCodigo(getDadosUsuarioLogado()['id_empresa']);
        $listaPedidoCompra = $this->compra->getPedidoCompraPorCodigo($numPedidoCompra);
        $listaFornecedor = $this->fornecedor->buscarPorCodigo($listaPedidoCompra->cod_fornecedor); 
        $listaProdutosPedido = $this->compra->getProdutoPedido($numPedidoCompra);

        $dados = array(
            'empresa' => $empresa,
            'fornecedor' => $listaFornecedor,
            'pedido' => $listaPedidoCompra,
            'lista_produto' => $listaProdutosPedido, 
            'menu' => ''
        );        

        $this->load->view('compras/imprime-pedido-compra', $dados);       

    }

    public function formOrdemCompra(){

        $listaProdutoComp = $this->produto->getProdutoComprado();

        $dados = array(
            'lista_produto_comp' => $listaProdutoComp,
            'menu' => 'Compras'
        );        

        $this->load->view('compras/nova-ordem-compra', $dados);

    }   

    public function formPedidoCompra(){

        $listaFornecedor = $this->fornecedor->getFornecedor();

        $dados = array(
            'lista_fornecedor' => $listaFornecedor,
            'menu' => 'Compras'
        );        

        $this->load->view('compras/novo-pedido-compra', $dados);

    } 
    
    public function editarPedidoCompra($numPedidoCompra){

        $listaPedidoCompra = $this->compra->getPedidoCompraPorCodigo($numPedidoCompra);        
        $listaOrdemCompra = $this->compra->getOrdemPorPedido($numPedidoCompra);
        $listaProdutosPedido = $this->compra->getProdutoPedido($numPedidoCompra);
        $listaOrdemSemPedido = $this->compra->getOrdemSemPedido();
        $listaProdutoComp = $this->produto->getProdutoComprado();

        if($listaPedidoCompra == null){
            redirect(base_url('compras/pedido-compra'));
            
        }else{ 

            $dados = array(
                'pedido' => $listaPedidoCompra,
                'lista_ordem_compra' => $listaOrdemCompra,
                'lista_produto' => $listaProdutosPedido,                
                'lista_ordem_sem_pedido' => $listaOrdemSemPedido,
                'lista_produto_comp' => $listaProdutoComp,
                'menu' => 'Compras'
            );       

            $this->load->view('compras/editar-pedido-compra', $dados);
        }
    }

    public function editarOrdemCompra($numOrdemCompra){

        $listaOrdem = $this->compra->getOrdemCompraPorCodigo($numOrdemCompra);

        if($listaOrdem == null){
            redirect(base_url('compras/ordem-compra'));
            
        }else{ 

            $dados = array(
                'ordem' => $listaOrdem,
                'menu' => 'Compras'
            );

            $this->load->view('compras/editar-ordem-compra', $dados);
        }

    }
    
    public function edtarRecebimentoMaterial($numPedidoCompra){

        $listaEmpresa = $this->empresa->getEmpresaPorCodigo(getDadosUsuarioLogado()['id_empresa']);
        $listaPedidoCompra = $this->compra->getPedidoCompraPorCodigo($numPedidoCompra);
        $listaRecebimentos = $this->compra->getRecebimentos($numPedidoCompra);
        $listaOrdemCompra = $this->compra->getOrdemPorPedido($numPedidoCompra);
        $listaProdutosPedido = $this->compra->getProdutoPedido($numPedidoCompra);
        $listaRecebimentoPedido = $this->compra->getRecebimentoPorPedido($numPedidoCompra);
        $listaConta = $this->financeiro->getContaAtivaRel();
        $listaMetodoPagamento = $this->financeiro->getMetodoPagamento();
        $listaContaContabil = $this->financeiro->getContaContabilAtivo();
        $listaCentroCusto = $this->financeiro->getCentroCustoAtivo();

        $listaFornecedor = $this->fornecedor->getFornecedor();

        if($listaPedidoCompra == null){
            redirect(base_url('compras/recebimento-material'));
            
        }else{ 

            $dados = array(
                'empresa' => $listaEmpresa,
                'pedido' => $listaPedidoCompra,
                'lista_recebimento' => $listaRecebimentos,
                'lista_ordem_compra' => $listaOrdemCompra,
                'lista_produto' => $listaProdutosPedido,
                'lista_recebimento_pedido' => $listaRecebimentoPedido,
                'lista_conta' => $listaConta,
                'lista_metodo_pagamento' => $listaMetodoPagamento,
                'lista_conta_contabil' => $listaContaContabil,
                'lista_centro_custo' => $listaCentroCusto, 
                'lista_fornecedor' => $listaFornecedor,
                'menu' => 'Compras'
                
            );

            $this->load->view('compras/novo-recebimento-material', $dados);
        }

    }    

    public function inserirOrdemCompra(){  

        //Validações dos campo e array das mensagens apresentadas
        $this->form_validation->set_rules('CodProduto', 'Produto de Compra', 'required',
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('DataNecessidade', 'Data de Necessidade', 'required', 
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('QuantPedida', 'Quantidade Pedida', 'required|max_length[60]|callback_more_zero', 
            array('required' => 'Você deve preencher o campo %s'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            $this->formOrdemCompra();
            
        }else {

            $dados = [
                'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                'cod_produto'  => $this->input->post('CodProduto'),
                'data_necessidade' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataNecessidade')))),
                'quant_pedida' => str_replace(",",".",(str_replace(".","",$this->input->post('QuantPedida')))),
                'observacoes' => $this->input->post('ObsOrdemCompra'),
            ];

            $this->compra->insertOrdemCompra($dados);

            //Se optar por salvar e continuar, mantém na página de cadastro
            if ($this->input->post('Opcao') == 'salvarContinuar'){

                $this->session->set_flashdata('sucesso', 'Ordem de compra cadastrada com sucesso');
                redirect(base_url('compras/ordem-compra/nova-ordem-compra'));

            }else {

                $this->session->set_flashdata('sucesso', 'Ordem de compra cadastrada com sucesso');
                redirect(base_url('compras/ordem-compra'));
            }            
        }        
    }
    
    public function novaOrdemPedido($numPedidoCompra){  

        //Validações dos campo e array das mensagens apresentadas
        $this->form_validation->set_rules('CodProduto', 'Produto de Compra', 'required',
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('DataNecessidade', 'Data de Necessidade', 'required', 
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('QuantPedida', 'Quantidade Pedida', 'required|max_length[60]|callback_more_zero', 
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('ValorUnitario', 'Valor Unitário', 'required',
            array('required' => 'Você deve preencher o campo %s'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            redirect(base_url("compras/pedido-compra/editar-pedido-compra/{$numPedidoCompra}"), "home", "refresh");  
            
        }else {

            $dados = [
                'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                'num_pedido_compra' => $numPedidoCompra,
                'cod_produto'  => $this->input->post('CodProduto'),
                'data_necessidade' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataNecessidade')))),
                'quant_pedida' => str_replace(",",".",(str_replace(".","",$this->input->post('QuantPedida')))),
                'observacoes' => $this->input->post('ObsOrdemCompra'),
                'valor_unitario' => str_replace(",",".",(str_replace(".","",$this->input->post('ValorUnitario'))))
            ];

            $this->compra->insertOrdemCompra($dados);

            $this->session->set_flashdata('sucesso', 'Ordem de compra cadastrada com sucesso');
            redirect(base_url("compras/pedido-compra/editar-pedido-compra/{$numPedidoCompra}"), "home", "refresh");           
        }        
    }

    public function inserirPedidoCompra(){  

        //Validações dos campos
        $this->form_validation->set_rules('CodFornecedor', 'Fornecedor', 'required',
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('DataEmissao', 'Data de Emissão', 'required|callback_date_check',
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('DataEntrega', 'Data de Entrega', 'required',
            array('required' => 'Você deve preencher o campo %s'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            $this->formPedidoCompra();
            
        }else {

            $dados = [
                'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                'cod_fornecedor'  => $this->input->post('CodFornecedor'),
                'data_emissao' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataEmissao')))),
                'data_entrega' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataEntrega')))),
                'observacoes' => $this->input->post('ObsPedidoCompra'),
                'tipo_desconto' => $this->input->post('TipoDesconto'),
                'valor_desconto' => str_replace(",",".",(str_replace(".","",$this->input->post('Desconto')))), 
            ];

            $numPedidoCompra = $this->compra->insertPedidoCompra($dados);

            $this->session->set_flashdata('sucesso', 'Pedido de compra cadastrado com sucesso');
            redirect(base_url("compras/pedido-compra/editar-pedido-compra/{$numPedidoCompra}"), "home", "refresh");
                       
        }        
    }

    public function gerarPedidoCompra(){  

        //Validações dos campos
        $this->form_validation->set_rules('CodFornecedor', 'Fornecedor', 'required',
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('DataEmissao', 'Data de Emissão', 'required|callback_date_check',
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('DataEntrega', 'Data de Entrega', 'required',
            array('required' => 'Você deve preencher o campo %s'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            redirect(base_url('compras/ordem-compra'));
            
        }else {

            $dados = [
                'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                'cod_fornecedor'  => $this->input->post('CodFornecedor'),
                'data_emissao' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataEmissao')))),
                'data_entrega' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataEntrega')))),
                'observacoes' => $this->input->post('ObsPedidoCompra')
            ];            

            $numPedidoCompra = $this->compra->insertPedidoCompra($dados);
            $numOrdemCompra = explode(",", $this->input->post("selecionado"));
            
            foreach($numOrdemCompra as $ordem){

                $ordem_compra = $this->compra->getOrdemCompraPorCodigo($ordem);
                $produto = $this->produto->getProdutoPorCodigo($ordem_compra->cod_produto);

                $dados = null;
                $dados = [
                    'num_pedido_compra' => $numPedidoCompra,
                    'valor_unitario' => $produto->custo_medio
                ];
    
                $this->compra->updateOrdemCompra($ordem, $dados);

            } 

            $this->session->set_flashdata('sucesso', 'Pedido de compra gerado com sucesso');
            redirect(base_url("compras/pedido-compra/editar-pedido-compra/{$numPedidoCompra}"), "home", "refresh");
                       
        }        
    }

    public function salvarPedidoCompra($numPedidoCompra){

        //Validações dos campo e array das mensagens apresentadas
        $this->form_validation->set_rules('DataEntrega', 'Data de Entrega', 'required',
            array('required' => 'Você deve preencher o campo %s'));        

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            $this->editarPedidoCompra($numPedidoCompra);
            
        }else {         

            $data = [
                'data_entrega' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataEntrega')))),
                'observacoes' => $this->input->post('ObsPedidoCompra'),
                'tipo_desconto' => $this->input->post('TipoDesconto'),
                'valor_desconto' => str_replace(",",".",(str_replace(".","",$this->input->post('Desconto')))), 
            ];

            $this->compra->updatePedidoCompra($numPedidoCompra, $data);

            $this->session->set_flashdata('sucesso', 'Pedido de compra alterado com sucesso');
            redirect(base_url("compras/pedido-compra/editar-pedido-compra/{$numPedidoCompra}"), "home", "refresh");
                       
        }  
    }

    public function inserirOrdemPedido($numPedidoCompra){

        $this->form_validation->set_rules('NumOrdemCompraAdic', 'Ordem de Compra', 'required',
                    array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('QuantPedidaAdic', 'Quantidade Pedida', 'required|callback_more_zero',
                    array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('ValorUnitarioAdic', 'Valor Unitário', 'required',
                    array('required' => 'Você deve preencher o campo %s'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            redirect(base_url("compras/pedido-compra/editar-pedido-compra/{$numPedidoCompra}"), "home", "refresh");

        }else{

            $numOrdemCompra = $this->input->post('NumOrdemCompraAdic');

            $dados = [
                'num_pedido_compra' => $numPedidoCompra,
                'quant_pedida' => str_replace(",",".",(str_replace(".","",$this->input->post('QuantPedidaAdic')))),
                'valor_unitario' => str_replace(",",".",(str_replace(".","",$this->input->post('ValorUnitarioAdic'))))
            ];

            $this->compra->updateOrdemCompra($numOrdemCompra, $dados);

            $this->session->set_flashdata('sucesso', 'Ordem de compra inserida com sucesso');
            redirect(base_url("compras/pedido-compra/editar-pedido-compra/{$numPedidoCompra}"), "home", "refresh");

        }
    } 

    public function inserirRecebimentoMaterial(){ 

        $numPedidoCompra = $this->uri->segment(4);
        $codFornecedor = $this->uri->segment(5);

        //Validações dos campo e array das mensagens apresentadas
        $this->form_validation->set_rules('DataRecebimento', 'Data de Recebimento', 'required|callback_date_check', 
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('CodConta', 'Conta Financeira', 'required', 
            array('required' => 'Você deve preencher o campo %s'));
        
        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            redirect(base_url("compras/recebimento-material/novo-recebimento-material/{$numPedidoCompra}"), "home", "refresh");
            
        }else {   
            
            $empresa = $this->empresa->getEmpresaPorCodigo(getDadosUsuarioLogado()['id_empresa']);
            $pedido = $this->compra->getPedidoCompraPorCodigo($numPedidoCompra);
            $fornecedor = $this->fornecedor->getFornecedorPorCodigo($codFornecedor);

            // Carrega arrays
            $quantRecebida = $this->input->post('quantRecebida');
            $ValorCompra = $this->input->post('ValorCompra'); 

            // Validação da quantidade e valor
            $lista_produto_compra = $this->compra->getProdutoPedido($numPedidoCompra);
            /*foreach($lista_produto_compra as $key_produto_compra => $produto) {

                $quan_recebida = floatval(str_replace(",",".",(str_replace(".","",$quantRecebida[$produto->cod_produto]))));
                $valor_compra = floatval(str_replace(",",".",(str_replace(".","",$ValorCompra[$produto->cod_produto]))));

                if($quan_recebida == 0 || $valor_compra == 0){

                    $this->session->set_flashdata('erro', '<br>Quant Recebida e o Valor de Compra devem ser maior que 0<br>');
                    redirect(base_url("compras/recebimento-material/novo-recebimento-material/{$numPedidoCompra}"), "home", "refresh");

                }
            }*/

            $valor_desconto = floatval(str_replace(",",".",(str_replace(".","",$this->input->post('ValorDesconto')))));

            // Cria registro de recebimento
            $data = [
                'num_pedido_compra'  => $numPedidoCompra,
                'data_recebimento' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataRecebimento')))),
                'serie' => $this->input->post('Serie'),
                'nota_fiscal' => $this->input->post('NotaFiscal'),
                'observacoes' => $this->input->post('ObservReceb'),
                'valor_desconto' => str_replace(",",".",(str_replace(".","",$this->input->post('ValorDesconto')))),
            ];
            $codRecebimentoMaterial = $this->compra->insertRecebimentoMaterial($data);  

            foreach($lista_produto_compra as $key_produto_compra => $produto) { 
                
                $quan_recebida = floatval(str_replace(",",".",(str_replace(".","",$quantRecebida[$produto->cod_produto]))));
                $valor_compra = floatval(str_replace(",",".",(str_replace(".","",$ValorCompra[$produto->cod_produto]))));                

                if($quan_recebida == 0){
                    continue;
                }

                // Movimenta estoque
                $dadosEstoque = null;
                $dadosEstoque = [
                    'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                    'data_movimento' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataRecebimento')))),
                    'cod_produto' => $produto->cod_produto,
                    'origem_movimento' => 2,
                    'id_origem' => $codRecebimentoMaterial,
                    'tipo_movimento' => 1,
                    'especie_movimento' => 4,
                    'quant_movimentada' => $quan_recebida,
                    'valor_movimento' => $valor_compra
                ];
                $this->estoque->insertMovimentoEstoque($dadosEstoque);            

                //Atualiza saldo da ordem de compra
                $saldoProduto = $quan_recebida;
                $lista_ordem_produto = $this->compra->getOrdemPorProdutoPedido($produto->cod_produto, $numPedidoCompra, "asc");
                $last_key = @end(array_keys($lista_ordem_produto));                
                foreach($lista_ordem_produto as $key_ordem_produto => $ordem) {

                    if($saldoProduto > 0){

                        if(($ordem->quant_pedida - $ordem->quant_atendida) > 0 && $last_key != $key_ordem_produto){

                            $saldoOrdem = $ordem->quant_pedida - $ordem->quant_atendida;

                            if($saldoOrdem >= $saldoProduto){
                                $quantMov = $saldoProduto;
                            }else{
                                $quantMov = $saldoOrdem;
                            }

                            if($ordem->quant_atendida > 0){
                                if(($quantMov + $ordem->quant_atendida) >= $ordem->quant_pedida) {
                                    $status = 3;
                                }else{
                                    $status = 2;
                                }            
                            }else{
                                if($quantMov >= $ordem->quant_pedida) {
                                    $status = 3;
                                }else{
                                    $status = 2;
                                } 
                            }

                            $dados = null;             
                            $dados = [
                                'quant_atendida' => $ordem->quant_atendida + $quantMov,
                                'status' => $status
                            ];
            
                            $this->compra->updateOrdemCompra($ordem->num_ordem_compra, $dados);

                            $saldoProduto = $saldoProduto - $quantMov;

                        }elseif($last_key == $key_ordem_produto){

                            $quantMov = $saldoProduto;

                            if($ordem->quant_atendida > 0){
                                if(($quantMov + $ordem->quant_atendida) >= $ordem->quant_pedida) {
                                    $status = 3;
                                }else{
                                    $status = 2;
                                }            
                            }else{
                                if($quantMov >= $ordem->quant_pedida) {
                                    $status = 3;
                                }else{
                                    $status = 2;
                                } 
                            }

                            $dados = null;            
                            $dados = [
                                'quant_atendida' => $ordem->quant_atendida + $quantMov,
                                'status' => $status
                            ];
            
                            $this->compra->updateOrdemCompra($ordem->num_ordem_compra, $dados);

                        }
                    }
                }                

                //Atualiza Custo Médio produto
                $custoMedio = $this->estoque->getCustoMedio($produto->cod_produto);
                if($custoMedio != null && $custoMedio->custo_medio != 0){

                    $dadosProd = null;
                    $dadosProd = [
                        'custo_medio' => $custoMedio->custo_medio
                    ];
        
                    $this->produto->updateProduto($produto->cod_produto, $dadosProd);
                }
            }

            // Criação de título
            $numParcela = $this->input->post('Parcelas');
            $dataVencimento = $this->input->post('DataVencimento');
            $valorParcela = $this->input->post('ValorParcela');                       

            for ($i = 1; $i <= $numParcela; $i++) {    
                
                if($valorParcela[$i] == 0){
                    continue;
                } 
                
                $dadosMovimento = null;
                $dadosMovimento = [
                    'cod_conta' => $this->input->post('CodConta'),
                    'cod_metodo_pagamento' => $this->input->post('CodMetodoPagamento'),
                    'cod_centro_custo' => $this->input->post('CodCentroCusto'),
                    'cod_conta_contabil' => $this->input->post('CodContaContabil'),
                    'cod_emitente' => $codFornecedor,
                    'tipo_movimento' => 2,
                    'data_competencia' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataRecebimento')))),
                    'data_vencimento' => date("Y-m-d", strtotime(str_replace('/', '-', $dataVencimento[$i]))),
                    'parcela' => $i . '/' . $numParcela,
                    'desc_movimento' => $fornecedor->nome_fornecedor . " - Pedido de Compra: " . $numPedidoCompra . ", " . "Recebimento: " . $codRecebimentoMaterial,
                    'valor_titulo' => floatval(str_replace(",",".",(str_replace(".","",$valorParcela[$i])))),
                    'origem_movimento' => 2,
                    'id_origem' => $codRecebimentoMaterial,
                    'confirmado' => 0
                ];

                $this->financeiro->insertMovimentoConta($dadosMovimento);
            }

            $this->session->set_flashdata('sucesso', 'Movimento inserido com sucesso');
            redirect(base_url("compras/recebimento-material/novo-recebimento-material/{$numPedidoCompra}"), "home", "refresh");
        }        
    }  

    public function salvarOrdemCompra($numOrdemCompra){

        $this->form_validation->set_rules('DataNecessidade', 'Data de Necessidade', 'required|max_length[60]', 
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('QuantPedida', 'Quantidade Pedida', 'required|max_length[60]|callback_more_zero', 
            array('required' => 'Você deve preencher o campo %s'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            $this->editarOrdemCompra($numOrdemCompra);
            
        }else {

            $quantPedida = str_replace(",",".",$this->input->post('QuantPedida'));
            $quantAtendida = str_replace(",",".",$this->input->post('QuantAtendida'));

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

            $dados = [
                'data_necessidade' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataNecessidade')))),
                'quant_pedida' => $quantPedida,
                'observacoes' => $this->input->post('ObsOrdemCompra'),
                'status' => $status
            ];

            $this->compra->updateOrdemCompra($numOrdemCompra, $dados);

            $this->session->set_flashdata('sucesso', 'Ordem de compra alterada com sucesso');
            redirect(base_url('compras/ordem-compra'));           
        }
    }

    public function salvarOrdemPedido(){
        $numOrdemCompra = $this->uri->segment(4);

        //Validações dos campo e array das mensagens apresentadas
        $this->form_validation->set_rules('QuantPedidaEdit', 'Quantidade Pedida', 'required|callback_more_zero',
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('ValorUnitarioEdit', 'Valor Unitário', 'required',
            array('required' => 'Você deve preencher o campo %s'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            $this->editarPedidoCompra($numOrdemCompra);
            
        }else {

            $ordem = $this->compra->getOrdemCompraPorCodigo($numOrdemCompra);
            $quantPedida = str_replace(",",".",(str_replace(".","",$this->input->post('QuantPedidaEdit'))));

            // Ajusta Status da ordem
            if($ordem->quant_atendida > 0){
                if($quantPedida <= $ordem->quant_atendida){
                    $status = 3;
                }elseif($quantPedida > $ordem->quant_atendida){
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

            $this->compra->updateOrdemCompra($numOrdemCompra, $data);

            $this->session->set_flashdata('sucesso', 'Ordem de compra alterada com sucesso');
            redirect(base_url("compras/pedido-compra/editar-pedido-compra/{$ordem->num_pedido_compra}"));
                       
        }  
    }
    
    public function excluirOrdemCompra(){

        $numOrdemCompra = $this->input->post("selecionar_todos");

        $this->compra->deleteOrdemCompra($numOrdemCompra);
        $this->session->set_flashdata('sucesso', 'Registro(s) selecionado(s) excluído(s)');
        redirect(base_url('compras/ordem-compra'));
        
    }

    public function excluirPedidoCompra(){

        $numPedidoCompra = $this->input->post("excluir_todos");

        $this->compra->deletePedidoCompra($numPedidoCompra);
        $this->session->set_flashdata('sucesso', 'Registro(s) selecionado(s) excluído(s)');
        redirect(base_url('compras/pedido-compra'));
        
    }

    public function excluirOrdemPedido($numPedidoCompra){

        $numOrdemCompra = $this->input->post("excluir_todos");

        $data = [
            'num_pedido_compra' => null,
            'valor_unitario' => 0
        ];

        $this->compra->updateOrdemCompraArray($numOrdemCompra, $data);

        $this->session->set_flashdata('sucesso', 'Registro(s) selecionado(s) excluído(s)');
        redirect(base_url("compras/pedido-compra/editar-pedido-compra/{$numPedidoCompra}"));
    }

    public function estornarRecebimentoMaterial($numPedidoCompra){     

        $codRecebimento = $this->input->post("estornar_todos");
            
        foreach($codRecebimento as $recebimento){  
                
            $recebimentoMaterial = $this->compra->getRecebimentoPorCodigo($recebimento);
            $movimentosRecebimento = $this->compra->getMovimentoPorRecebimento($recebimento);

            // Valida saldo dos produtos para saída de estoque
            foreach($movimentosRecebimento as $key_movimentos => $movimentos_estoque){

                $produto = $this->produto->getProdutoPorCodigo($movimentos_estoque->cod_produto);
                if($produto->saldo_negativo != 1 && $produto->quant_estoq < $movimentos_estoque->quant_movimentada){
                    $this->session->set_flashdata('erro', 'Produto (' . $produto->cod_produto . ' - ' . $produto->nome_produto . ') sem saldo suficiente para estorno');
                    redirect(base_url("compras/recebimento-material/novo-recebimento-material/{$numPedidoCompra}"), "home", "refresh");  
                }

            }

            foreach($movimentosRecebimento as $key_movimentos => $movimentos_estoque){

                // Estorna estoque do produto comprado
                $dados = null; 
                $dados = [
                    'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                    'data_movimento' => $movimentos_estoque->data_movimento,
                    'cod_produto' => $movimentos_estoque->cod_produto,
                    'origem_movimento' => 2,
                    'id_origem' => $recebimento,
                    'tipo_movimento' => 2,
                    'especie_movimento' => 8,
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

                $saldoProduto = $movimentos_estoque->quant_movimentada;                

                //Atualiza saldo da ordem de compra                
                $lista_ordem_produto = $this->compra->getOrdemPorProdutoPedido($movimentos_estoque->cod_produto, $numPedidoCompra, "desc");
                $last_key = @end(array_keys($lista_ordem_produto)); 
                foreach($lista_ordem_produto as $key_ordem_produto => $ordem) {

                    if($saldoProduto > 0){

                        if($ordem->quant_atendida > 0 && $last_key != $key_ordem_produto){

                            $saldoOrdem = $ordem->quant_atendida;

                            if($saldoOrdem >= $saldoProduto){
                                $quantMov = $saldoProduto;
                            }else{
                                $quantMov = $saldoOrdem;
                            }

                            if(($ordem->quant_atendida - $quantMov) >= $ordem->quant_pedida) {
                                $status = 3;
                            }elseif(($ordem->quant_atendida - $quantMov) == 0){
                                $status = 1;
                            }else{
                                $status = 2;
                            }

                            $dados = null;             
                            $dados = [
                                'quant_atendida' => $ordem->quant_atendida - $quantMov,
                                'status' => $status
                            ];
            
                            $this->compra->updateOrdemCompra($ordem->num_ordem_compra, $dados);

                            $saldoProduto = $saldoProduto - $quantMov;

                        }elseif($last_key == $key_ordem_produto){

                            $quantMov = $saldoProduto;

                            if(($ordem->quant_atendida - $quantMov) >= $ordem->quant_pedida) {
                                $status = 3;
                            }elseif(($ordem->quant_atendida - $quantMov) == 0){
                                $status = 1;
                            }else{
                                $status = 2;
                            }

                            $dados = null;            
                            $dados = [
                                'quant_atendida' => $ordem->quant_atendida - $quantMov,
                                'status' => $status
                            ];
            
                            $this->compra->updateOrdemCompra($ordem->num_ordem_compra, $dados);

                        }
                    }
                }                

                //Atualiza Custo Médio produto
                $custoMedio = $this->estoque->getCustoMedio($movimentos_estoque->cod_produto);
                if($custoMedio != null && $custoMedio->custo_medio != 0){

                    $dadosProd = null;
                    $dadosProd = [
                        'custo_medio' => $custoMedio->custo_medio
                    ];
        
                    $this->produto->updateProduto($movimentos_estoque->cod_produto, $dadosProd);
                }

                // Atualiza recebimento
                $dados = null;                
                $dados = [
                    'estornado' => '1'
                ];
        
                $this->compra->updateRecebimento($recebimento, $dados);

            } 

            //Exclui títulos não confirmados
            $this->financeiro->excluirTituloOrigem(2, $recebimento);
                
        }        
            
        $this->session->set_flashdata('sucesso', 'Registro(s) selecionado(s) estornado(s) com sucesso');

        redirect(base_url("compras/recebimento-material/novo-recebimento-material/{$numPedidoCompra}"), "home", "refresh");    

    }

    public function listarOrdem(){      

        $select = ($this->input->get('selecao')) ? $this->input->get('selecao') : "OrdensSemPedido";

        $config = array(
            'base_url' => base_url('compras/ordem-compra'),
            'per_page' => 10,
            'num_links' => 10,
            'uri_segment' => 3,
            'total_rows' => $this->compra->countAllOrdem($select),
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
        $listaOrdem = $this->compra->getOrdem($filter, $select, $config["per_page"], $offset);

        $listaFornecedor = $this->fornecedor->getFornecedor();

        if($select == "OrdensSemPedido"){
            $opcao = "Ordems Sem Pedido";
        }elseif($select == "OrdensComPedido"){
            $opcao = "Ordems Com Pedido";
        }elseif($select == "TodasOrdens"){
            $opcao = "Todas as Ordens";
        }


        $dados = array(
            'pagination' => $this->pagination->create_links(),
            'lista_ordem' => $listaOrdem,
            'opcao' => $opcao,
            'select' => $select,
            'lista_fornecedor' => $listaFornecedor,
            'menu' => 'Compras'
        );

        $this->load->view('compras/ordem-compra', $dados);
    }

    public function listarPedido(){      

        $config = array(
            'base_url' => base_url('compras/pedido-compra'),
            'per_page' => 10,
            'num_links' => 10,
            'uri_segment' => 3,
            'total_rows' => $this->compra->countAllPedido(),
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
        $listaPedido = $this->compra->getPedido($filter, $config["per_page"], $offset);


        $dados = array(
            'pagination' => $this->pagination->create_links(),
            'lista_pedido' => $listaPedido,
            'menu' => 'Compras'
        );

        $this->load->view('compras/pedido-compra', $dados);
    }

    public function listarRecebimentoMaterial(){      

        $config = array(
            'base_url' => base_url('compras/recebimento-material'),
            'per_page' => 10,
            'num_links' => 10,
            'uri_segment' => 3,
            'total_rows' => $this->compra->countAllPedidoRecebimento(),
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
        $listaPedido = $this->compra->getPedidoRecebimento($filter, $config["per_page"], $offset);


        $dados = array(
            'pagination' => $this->pagination->create_links(),
            'lista_pedido' => $listaPedido,
            'menu' => 'Compras'
        );

        $this->load->view('compras/recebimento-material', $dados);
    }

    //Relatórios
    public function compraProduto(){
        
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

        $listaPrudutoComp = $this->produto->getProdutoComprado();        
        $totalCompra = $this->compra->getTotalCompra($dataInicio, $dataFim, $codProdutos);
        $listaCompraResumida = $this->compra->compraResumida($dataInicio, $dataFim, $codProdutos);
        $listaCompraDetalhada = $this->compra->compraDetalhada($dataInicio, $dataFim, $codProdutos);

        $dados = array(
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
            'cod_produto' => $codProdutos,
            'lista_produto_comp' => $listaPrudutoComp,
            'total_compra' => $totalCompra,
            'lista_compra_resumida' => $listaCompraResumida,
            'lista_compra_detalhada' => $listaCompraDetalhada,
            'menu' => 'Compras'
            
        );

        $this->load->view('compras/compra-produto', $dados);

    }

    public function compraFornecedor(){

        $dataInicio = "";
        $dataFim = "";

        if($this->input->get('DataInicio') != "" && $this->input->get('DataFim') != ""){
            $dataInicio = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->get('DataInicio'))));
            $dataFim = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->get('DataFim'))));
        }
        $codFornecedores = $this->input->get('fornecedor');
        
        if($dataInicio == ""){
            $dataInicio = date('Y-m-01');
        }

        if($dataFim == ""){
            $dataFim = date('Y-m-d');
        }        

        $listaFornecedor = $this->fornecedor->getFornecedor();        
        $totalCompra = $this->compra->getTotalCompraFornecedor($dataInicio, $dataFim, $codFornecedores);
        $listaFornecedorResumida = $this->compra->fornecedorResumida($dataInicio, $dataFim, $codFornecedores);
        $listaFornecedorDetalhada = $this->compra->fornecedorDetalhada($dataInicio, $dataFim, $codFornecedores);

        $dados = array(
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
            'cod_fornecedor' => $codFornecedores,
            'lista_fornecedor' => $listaFornecedor,
            'total_compra' => $totalCompra,
            'lista_fornecedor_resumida' => $listaFornecedorResumida,
            'lista_fornecedor_detalhada' => $listaFornecedorDetalhada,
            'menu' => 'Compras'
            
        );

        $this->load->view('compras/compra-fornecedor', $dados);

    }

    public function visaoCompras(){
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

        $listaComprasDia = $this->compra->getComprasDiaria($dataInicio, $dataFim);
        $valorPendente = $this->compra->getCompraPendente($dataInicio, $dataFim);
        $listaCompraProduto = $this->compra->getCompraProduto($dataInicio, $dataFim);
        $listaCompraFornecedor = $this->compra->getCompraFornecedor($dataInicio, $dataFim);

        $codProdutos = "";
        $periodo = "";        

        // Compra Por Dia
        $labelCrompDia = array();
        $dadosCrompDia = array();
        $labelDia = array();
        $labelNomMes = array();
        $labelAno = array();
        $totalCompra = 0;
        foreach($listaComprasDia as $comprasdia){

            $labelCrompDia[] = str_replace('-', '/', date("d-m", strtotime($comprasdia->data)));
            $labelDia[] = date("d", strtotime($comprasdia->data));
            $labelNomMes[] = $comprasdia->nome_mes;
            $labelAno[] = date("Y", strtotime($comprasdia->data));
            $dadosCrompDia[] = $comprasdia->compra_dia;
            $totalCompra = $totalCompra + $comprasdia->compra_dia;

        }

        // Compra por Produto
        $corCompra = array();
        $dadosCompra = array();
        $dadosProduto = array();
        $codProduto = array();
        $codUnidMedida = array();
        $descProduto = array();
        $quantCompra = array(); 
        $valorCompra = array();        
        foreach($listaCompraProduto as $key_CompraProduto => $comraProduto){

            if($key_CompraProduto == 0){
                $corCompra[] = $this->random_color("");
            }else{
                $corCompra[] = $this->random_color($corCompra[$key_CompraProduto - 1]);
            }
                        
            $dadosCompra[] = ($comraProduto->valor_comprado / $totalCompra) * 100;
            $dadosProduto[] = $comraProduto->cod_produto . " - " . $comraProduto->nome_produto;
            $codProduto[] = $comraProduto->cod_produto;
            $codUnidMedida[] = $comraProduto->cod_unidade_medida;
            $descProduto[] = $comraProduto->nome_produto;
            $quantCompra[] = $comraProduto->quant_comprada;
            $valorCompra[] = $comraProduto->valor_comprado;

        }

        // Compra por Fornecedor
        $corFornecedor = array();
        $dadosFornecedor = array();
        foreach($listaCompraFornecedor as $key_CompraFornecedor => $compraFornecedor){

            if($key_CompraFornecedor == 0){
                $corFornecedor[] = $this->random_color("#F47C3C");
            }else{
                $corFornecedor[] = $this->random_color($corFornecedor[$key_CompraFornecedor - 1]);
            }

            $dadosFornecedor[] = ($compraFornecedor->total_compra / $totalCompra) * 100;
        }

        $dados = array(
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,

            'dia' => $labelCrompDia,
            'compra_dia' => $dadosCrompDia,
            'total_comprado' => $totalCompra,   
            'compra_pendente' => $valorPendente, 
            'dia_nome' => $labelDia, 
            'nome_mes' => $labelNomMes,
            'ano' => $labelAno,     
            
            'compra_produto' => $listaCompraProduto,            
            'cor_compra' => $corCompra,
            'dados_compra' => $dadosCompra,
            'nome_produto' => $dadosProduto,

            'cod_produto' => $codProduto,
            'cod_unid_medida' => $codUnidMedida,
            'desc_produto' => $descProduto,
            'quant_comprada' => $quantCompra,
            'valor_compra' => $valorCompra,

            'cor_fornecedor' => $corFornecedor,
            'dados_fornecedor' => $dadosFornecedor,
            'compra_fornecedor' => $listaCompraFornecedor,
            
            'menu' => 'Compras'
        );

        $this->load->view('compras/indicadores-compras', $dados);

    }

    

    //Form Validation customizados
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
        if(floatval(str_replace(",",".",$str)) <= 0.000){
            $this->form_validation->set_message('more_zero', 'Valor de %s deve ser maior que 0');
            return false;
        }else{
            return true;
        }
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