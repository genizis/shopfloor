<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProducaoController extends CI_Controller {

    function __construct(){
        parent::__construct();

        if(usuarioLogado() == false){

            redirect(base_url("login"), "home", "refresh");

        }

        if(getDadosUsuarioLogado()['producao'] != 1){

            redirect(base_url("visao-geral"), "home", "refresh");

        }
    }

    public function imprimirOrdem($numOrdemProducao)   
    {

        $empresa = $this->empresa->getEmpresaPorCodigo(getDadosUsuarioLogado()['id_empresa']);
        $listaOrdem = $this->producao->getOrdemProducaoPorCodigo($numOrdemProducao);
        $listaProduto = $this->producao->getComponentesProducaoPorOrdemProducao($numOrdemProducao);

        $dados = array(
            'empresa' => $empresa,
            'ordem' => $listaOrdem,
            'lista_produto' => $listaProduto,
            'menu' => 'Producao'
        );        

        $this->load->view('producao/imprime-ordem-producao', $dados);       

    }

    public function visaoProducao(){
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

        $listaPrudutoProd = $this->produto->getProdutoProduzido();

        $listaProducaoDia = $this->producao->getProducaoDiaria($dataInicio, $dataFim, $codProdutos);
        $listaCustoConsumo = $this->producao->getCustoProdutoConsumo($dataInicio, $dataFim, $codProdutos);
        $totalCusto = $this->producao->getCustoTotalConsumo($dataInicio, $dataFim, $codProdutos);
        $listaProducaoProduto = $this->producao->getProduçãoPorduto($dataInicio, $dataFim, $codProdutos);
        $listaQuantConsumo = $this->producao->getQuantConsumo($dataInicio, $dataFim, $codProdutos);
        

        // Produção Por Dia
        $labelProdDia = array();
        $dadosProducaoDia = array();
        $dadosPerdaDia = array();
        $labelDia = array();
        $labelNomMes = array();
        $labelAno = array();
        $totalProduzido = 0;
        $totalPerdido = 0;
        foreach($listaProducaoDia as $producaodia){

            $labelProdDia[] = str_replace('-', '/', date("d-m", strtotime($producaodia->data)));
            $labelDia[] = date("d", strtotime($producaodia->data));
            $labelNomMes[] = $producaodia->nome_mes;
            $labelAno[] = date("Y", strtotime($producaodia->data));
            $dadosProducaoDia[] = $producaodia->producao_dia;
            $totalProduzido = $totalProduzido + $producaodia->producao_dia;
            $dadosPerdaDia[] = $producaodia->perda_dia;
            $totalPerdido = $totalPerdido + $producaodia->perda_dia;

        }

        // Custo Consumo de Materiais
        $corConsumo = array();
        $dadosConsumo = array();
        $dadoProduto = array();
        $totalConsumo = 0;
        foreach($listaCustoConsumo as $key_CustoConsumo => $custoConsumo){

            if($key_CustoConsumo == 0){
                $corConsumo[] = $this->random_color("");
            }else{
                $corConsumo[] = $this->random_color($corConsumo[$key_CustoConsumo - 1]);
            }
                        
            $dadosConsumo[] = ($custoConsumo->custo_consumo / $totalCusto->custo_total) * 100;
            $dadoProduto[] = $custoConsumo->cod_produto . " - " . $custoConsumo->nome_produto;

        }

        // Quant Consumo de Materiais
        $corQuantConsumo = array();
        $dadosQuantConsumo = array();
        $dadoQuantProduto = array();
        $nomeProduto = array();
        $unidMedConsumo = array();
        foreach($listaQuantConsumo as $key_QuantConsumo => $quantConsumo){

            if($key_QuantConsumo >= 10) continue;

            $corQuantConsumo[] = "#325D88";         
            $dadosQuantConsumo[] = $quantConsumo->quant_movimentada;
            $dadoQuantProduto[] = $quantConsumo->cod_produto;
            $nomeProduto[] = $quantConsumo->nome_produto;
            $unidMedConsumo[] = $quantConsumo->cod_unidade_medida;

        }

        // Produção e Custo
        $labelProdutoProducao = array();
        $NomProdutoProd = array();
        $codUnidMedida = array();
        $dadosProdutoProducao = array();
        $dadosCustoProducao = array();
        foreach($listaProducaoProduto as $key_ProducaoProduto => $producaoProduto){

            if($key_ProducaoProduto >= 10) continue;

            $labelProdutoProducao[] = $producaoProduto->cod_produto;
            $NomProdutoProd[] = $producaoProduto->nome_produto;
            $codUnidMedida[] = $producaoProduto->cod_unidade_medida;
            $dadosProdutoProducao[] = $producaoProduto->quant_reportada;
            $dadosCustoProducao[] = $producaoProduto->custo_producao;

        }

        $dados = array(
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
            'cod_produto' => $codProdutos,
            'lista_produto_prod' => $listaPrudutoProd,

            'dia' => $labelProdDia,
            'producao_dia' => $dadosProducaoDia,
            'total_produzido' => $totalProduzido,
            'perda_dia' => $dadosPerdaDia,  
            'total_perdido' =>$totalPerdido,  
            'dia_nome' => $labelDia, 
            'nome_mes' => $labelNomMes,
            'ano' => $labelAno,         
            
            'consumo_produto' => $listaCustoConsumo,            
            'cor_consumo' => $corConsumo,
            'custo_produto' => $dadosConsumo,
            'nome_produto' => $dadoProduto,
            'total_custo' => $totalCusto,

            'cor_quant_consumo' => $corQuantConsumo,
            'quant_produto' => $dadosQuantConsumo,
            'cod_quant_produto' => $dadoQuantProduto,
            'nome_quant_produto' => $nomeProduto,
            'unid_med_consumo' => $unidMedConsumo,

            'produto_producao' => $labelProdutoProducao,
            'nome_produto_prod' => $NomProdutoProd,
            'cod_unidade_med' => $codUnidMedida,
            'quant_producao' => $dadosProdutoProducao,
            'custo_producao' => $dadosCustoProducao,
            
            'menu' => 'Producao'
        );

        $this->load->view('producao/indicadores-producao', $dados);

    }

    public function formOrdemProducao(){

        $listaPrudutoProd = $this->produto->getProdutoProduzido();
        $listaPedido = $this->venda->getPedidoVenda();

        $dados = array(
            'lista_produto_prod' => $listaPrudutoProd,
            'lista_pedido' => $listaPedido,
            'menu' => 'Producao'
        );
        

        $this->load->view('producao/nova-ordem-producao', $dados);

    }         

    public function editarOrdemProducao($numOrdemProducao){

        $listaOrdem = $this->producao->getOrdemProducaoPorCodigo($numOrdemProducao);
        $listaComponente = $this->producao->getComponentesProducaoPorOrdemProducao($numOrdemProducao);
        $listaProdutoCons = $this->produto->getProdutoOrdem($listaOrdem->cod_produto, $listaComponente);   
        
        if($listaOrdem == null){
            redirect(base_url('producao/ordem-producao'));
            
        }else{ 

            $dados = array(
                'ordem' => $listaOrdem,
                'lista_componente' => $listaComponente,
                'lista_produto_cons' => $listaProdutoCons,            
                'menu' => 'Producao'
            );        

            $this->load->view('producao/editar-ordem-producao', $dados);
        }

    }    

    public function editReporteOrdemPoducao($numOrdemProducao){

        $listaEmpresa = $this->empresa->getEmpresaPorCodigo(getDadosUsuarioLogado()['id_empresa']);
        $listaOrdemProducao = $this->producao->getOrdemProducaoPorCodigo($numOrdemProducao);
        $listaReportesProducao = $this->producao->getReportesPorducao($numOrdemProducao);
        $listaMovimentoOrdem = $this->producao->getMovimentosPorOrdemProducao($numOrdemProducao);
        $listaComponente = $this->producao->getComponentesProducaoPorOrdemProducao($numOrdemProducao);

        if($listaOrdemProducao == null){
            redirect(base_url('producao/reporte-producao'));
            
        }else{ 

            $dados = array(
                'empresa' => $listaEmpresa,
                'ordem' => $listaOrdemProducao,
                'lista_reporte' => $listaReportesProducao,
                'lista_movimento_ordem' => $listaMovimentoOrdem,
                'lista_componente' => $listaComponente,
                'menu' => 'Producao'
                
            );

            $this->load->view('producao/novo-reporte-producao', $dados);
        }

    }

    public function inserirOrdemProducao(){  

        //Validações dos campo e array das mensagens apresentadas
        $this->form_validation->set_rules('CodProduto', 'Código do Produto', 'required',
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('DataEmissao', 'Data de Emissão', 'required', 
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'required', 
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('QuantPlanejada', 'Quantidade Planejada', 'required|callback_more_zero',
            array('required' => 'Você deve preencher o campo %s'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            $this->formOrdemProducao();
            
        }else {

            $dados = [
                'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                'cod_produto'  => $this->input->post('CodProduto'),
                'num_pedido_venda'  => $this->input->post('PedidoVenda'),
                'data_emissao' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataEmissao')))),
                'data_fim' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataFim')))),
                'quant_planejada' => str_replace(",",".",(str_replace(".","",$this->input->post('QuantPlanejada')))),
                'observacoes' => $this->input->post('ObsOrdemProducao')
            ];

            $numOrdemProducao = $this->producao->insertOrdemProducao($dados);
            if($numOrdemProducao == null){

                $this->session->set_flashdata('erro', 'Erro ao criar ordem de produção');
                $this->formOrdemProducao();

            }else{

                $quantPlan = floatval(str_replace(",",".",(str_replace(".","",$this->input->post('QuantPlanejada')))));

                //Cria componentes da ordem de produção com base na engenharia do item
                $listaComponentes = $this->engenharia->getComponentesPorEstrutura($this->input->post('CodProduto'));
                foreach($listaComponentes as $key_componentes => $componente){ 
                    
                    $dadosConsumo = null;
                    $dadosConsumo = [
                        'num_ordem_producao' => $numOrdemProducao,
                        'cod_produto'  => $componente->cod_produto_componente,
                        'quant_consumo' => $componente->quant_consumo * ($quantPlan / $componente->quant_producao)
                    ];

                    $erro = $this->producao->insertConsumo($dadosConsumo);

                    // Planeja ordens de produção e compra dos produtos da estrutura de engenharia
                    if($this->input->post('PlanejaOrdens') == '1'){ 
                        $this->planejaOrdensEstrutura($componente->cod_produto_componente,
                                                      $componente->quant_consumo * $quantPlan,
                                                      $this->input->post('PedidoVenda'),
                                                      date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataEmissao')))),
                                                      date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataFim')))),
                                                      $this->input->post('ObsOrdemProducao'));

                    }
                    
                }
                
                redirect(base_url("producao/ordem-producao/editar-ordem-producao/{$numOrdemProducao}"), "home", "refresh");

            }                       
        }        
    }

    public function planejaOrdensEstrutura($codproduto, $quantidade, $pedidoVenda, $dataEmissao, $dataFim, $observacoes){

        $produto = $this->produto->getProdutoPorCodigo($codproduto);

        //Aplica cálculo da quantidade de dia para abastecimento
        $dataFim = date('Y-m-d', strtotime('-' . $produto->tempo_abastecimento . ' days', strtotime($dataFim)));

        // Se origem 1 (produzido) cria ordem de produção, se não, cria ordem de compra
        if($produto->origem_produto == 1){

            $dados = [
                'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                'cod_produto'  => $codproduto,
                'num_pedido_venda'  => $pedidoVenda,
                'data_emissao' => $dataEmissao,
                'data_fim' => $dataFim,
                'quant_planejada' => $quantidade,
                'observacoes' => $observacoes
            ];
    
            $numOrdemProducao = $this->producao->insertOrdemProducao($dados);

            $listaComponentes = $this->engenharia->getComponentesPorEstrutura($codproduto);
            foreach($listaComponentes as $key_componentes => $componente){ 
                    
                $dadosConsumo = null;
                $dadosConsumo = [
                    'num_ordem_producao' => $numOrdemProducao,
                    'cod_produto'  => $componente->cod_produto_componente,
                    'quant_consumo' => $componente->quant_consumo * $quantidade
                ];

                $erro = $this->producao->insertConsumo($dadosConsumo);

                // Recursividade para chegar ao ponto mais baixo da estrutura
                $this->planejaOrdensEstrutura($componente->cod_produto_componente,
                                              $componente->quant_consumo * $quantidade,
                                              $pedidoVenda,
                                              $dataEmissao,
                                              $dataFim,
                                              $observacoes);
            }            

        }else{

            $dados = [
                'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                'cod_produto'  => $codproduto,
                'data_entrega' => $dataFim,
                'quant_pedida' => $quantidade,
                'observacoes' => $observacoes
            ];

            $this->compra->insertOrdemCompra($dados);

        }  
    }

    public function iniciarComponentesProducao($dadosConsumo){

        $erro = $this->producao->insertComponentesProducao($dadosConsumo);

        if($erro != null){
            return $erro;
        }

        return $erro;

    }

    public function inserirComponenteProducao($NumOrdemProducao){

        $this->form_validation->set_rules('CodProdutoCons', 'Componente de Produção', 'required',
                    array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('QuantConsumo', 'Quantidade de Consumo', 'required|callback_more_zero',
                    array('required' => 'Você deve preencher o campo %s'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            redirect(base_url("producao/ordem-producao/editar-ordem-producao/{$NumOrdemProducao}"), "home", "refresh");

        }else{

            $dataComp = [
                'num_ordem_producao'  => $NumOrdemProducao,
                'cod_produto' => $this->input->post('CodProdutoCons'),
                'quant_consumo' => str_replace(",",".",(str_replace(".","",$this->input->post('QuantConsumo'))))
            ];

            $this->producao->insertConsumo($dataComp);
            $this->session->set_flashdata('sucesso', 'Componente cadastrado com sucesso');
            redirect(base_url("producao/ordem-producao/editar-ordem-producao/{$NumOrdemProducao}"), "home", "refresh");

        }
    }    

    public function salvarOrdemProducao($numOrdemProd){

        //Validações dos campos
        $this->form_validation->set_rules('DataFim', 'Data Fim', 'required', 
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('QuantPlanejada', 'Quantidade Planejada', 'required|callback_more_zero',
            array('required' => 'Você deve preencher o campo %s'));


        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            redirect(base_url("producao/ordem-producao/editar-ordem-producao/{$numOrdemProd}"), "home", "refresh");
            
        }else {

            $quantPlanejada = str_replace(",",".",(str_replace(".","",$this->input->post('QuantPlanejada'))));
            $quantProduzida = str_replace(",",".",(str_replace(".","",$this->input->post('QuantProduzida'))));

            // Ajusta Status da ordem
            if($quantProduzida != 0){
                if($quantPlanejada <= $quantProduzida){
                    $status = 3;
                }elseif($quantPlanejada > $quantProduzida){
                    $status = 2;
                }
            }
            else{
                $status = 1;
            }

            $dados = [
                'data_fim' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataFim')))),
                'quant_planejada' => str_replace(",",".",(str_replace(".","",$this->input->post('QuantPlanejada')))),
                'observacoes' => $this->input->post('ObsOrdemProducao'),
                'status' => $status
            ];

            $erro = $this->producao->updateOrdemProducao($numOrdemProd, $dados);

            //Atualiza quantidade de consumo dos componenetes
            /*$listaComponentes = $this->producao->getComponentesProducaoPorOrdemProducao($numOrdemProd);
            foreach($listaComponentes as $key_componentes => $componente){ 

                $componenteEstrutura = $this->engenharia->getEstruturaComponentePorCodigo($componente->seq_componente_producao);
                
                $dadosConsumo = null;
                $dadosConsumo = [
                    'seq_componente_producao' => $componente->seq_componente_producao,
                    'quant_consumo' => $componenteEstrutura->quant_consumo * ($quantPlanejada / $componenteEstrutura->quant_producao)
                ];

                $this->producao->updateComponenteProducao($componente->seq_componente_producao, $dadosConsumo);
                
            }*/

            if ($erro['code'] == null){
                $this->session->set_flashdata('sucesso', 'Ordem de produção alterada com sucesso');
                redirect(base_url('producao/ordem-producao'));
                
            }else{
                $this->session->set_flashdata('erro', $erro['message']);
                redirect(base_url("producao/ordem-producao/editar-ordem-producao/{$numOrdemProd}"), "home", "refresh");

            }                          
        }  
    }

    public function salvarComponenteProducao(){
        $numOrdemProd = $this->uri->segment(4);
        $SeqComponente = $this->uri->segment(5);

        //Validações dos campos
        $this->form_validation->set_rules('QuantConsumoEdit', 'Quantidade de Consumo', 'required|callback_more_zero',
            array('required' => 'Você deve preencher o campo %s'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            redirect(base_url("producao/ordem-producao/editar-ordem-producao/{$numOrdemProd}"), "home", "refresh");
            
        }else {

            $dados = [
                'quant_consumo' => str_replace(",",".",(str_replace(".","",$this->input->post('QuantConsumoEdit'))))
            ];

            $erro = $this->producao->updateComponenteProducao($SeqComponente, $dados);

            if ($erro['code'] == null){
                $this->session->set_flashdata('sucesso', 'Componente alterado com sucesso');
                
            }else{
                $this->session->set_flashdata('erro', $erro['message']);

            }
            
            redirect(base_url("producao/ordem-producao/editar-ordem-producao/{$numOrdemProd}"), "home", "refresh");
                       
        }  
    }

    public function excluirOrdemProducao(){

        $OrdemProducao = $this->input->post("excluir_todos");
        $numRegs = count($OrdemProducao);

        if($numRegs > 0){
            $this->producao->deleteComponenteProducaoPorOrdem($OrdemProducao);

            $this->session->set_flashdata('sucesso', 'Registro(s) selecionado(s) excluído(s)');
            $erro = $this->producao->deleteOrdemProducao($OrdemProducao);

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

        redirect(base_url('producao/ordem-producao'));
    }

       
    

    public function excluirComponenteProducao($numOrdemProducao){

        $SeqComponenteProd = $this->input->post("excluir_todos");
        $numRegs = count($SeqComponenteProd);

        if($numRegs > 0){
            
            $erro = $this->producao->deleteComponenteProducao($SeqComponenteProd);

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

        redirect(base_url("producao/ordem-producao/editar-ordem-producao/{$numOrdemProducao}"), "home", "refresh");
    }

    public function repotarProducao(){  
        $numOrdemProducao = $this->uri->segment(4);
        $codProduto = $this->uri->segment(5);
        $quantPlanejada = $this->uri->segment(6);

        //Validações dos campos
        $this->form_validation->set_rules('DataReporte', 'Data de Reporte', 'required|callback_date_check', 
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('QuantProducao', 'Quantidade Produzida', 'required|callback_more_zero', 
            array('required' => 'Você deve preencher o campo %s'));
        
        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            redirect(base_url("producao/reporte-producao/novo-reporte-producao/{$numOrdemProducao}"), "home", "refresh");
            
        }else {              

            $consumo = $this->input->post('consumo');

            $quantProduzida = floatval(str_replace(",",".",(str_replace(".","",$this->input->post('QuantProducao')))));
            $quantPerdida = floatval(str_replace(",",".",(str_replace(".","",$this->input->post('QuantPerda')))));

            //Valida estoque dos componentes e calcula custo dos itens consumidos
            $listaComponentes = $this->producao->getComponentesProducaoPorOrdemProducao($numOrdemProducao);
            $custoProducao = 0;
            $custoTotalProducao = 0;
            foreach($listaComponentes as $key_componentes => $componente){ 

                $quantConsumo = floatval(str_replace(",",".",(str_replace(".","",$consumo[$componente->seq_componente_producao])))); 
                $custoProducao = $custoProducao + ($quantConsumo * $componente->custo_medio);
            }

            // Cria reporte de produção
            $dados = [
                'num_ordem_producao'  => $numOrdemProducao,
                'data_reporte' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataReporte')))),
                'quant_reportada' => $quantProduzida,
                'quant_perdida' => $quantPerdida,
                'custo_producao' => $custoProducao,
                'observacoes' => $this->input->post("ObsReporte")
            ];

            $codReporteProducao = $this->producao->insertReporteProducao($dados);   

            //Baixa estoque dos produtos consumidos            
            foreach($listaComponentes as $key_componentes => $componente){  
                
                $quantConsumo = floatval(str_replace(",",".",(str_replace(".","",$consumo[$componente->seq_componente_producao])))); 

                if($quantConsumo != 0){
                    $custoProducao = $quantConsumo * $componente->custo_medio;
                    $custoTotalProducao = $custoTotalProducao + $custoProducao;
                    
                    // Movimenta Estoque
                    $dadosEstoque = null;
                    $dadosEstoque = [
                        'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                        'data_movimento' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataReporte')))),
                        'cod_produto' => $componente->cod_produto,
                        'origem_movimento' => 1,
                        'id_origem' => $codReporteProducao,
                        'tipo_movimento' => 2,
                        'especie_movimento' => 3,
                        'quant_movimentada' => $quantConsumo,
                        'valor_movimento' => $custoProducao,
                    ];

                    $this->estoque->insertMovimentoEstoque($dadosEstoque);
                }
            }

            //Sobe estoque do produto produzido
            $dadosEstoque = [
                'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                'data_movimento' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataReporte')))),
                'cod_produto' => $codProduto,
                'origem_movimento' => 1,
                'id_origem' => $codReporteProducao,
                'tipo_movimento' => 1,
                'especie_movimento' => 2,
                'quant_movimentada' => $quantProduzida,
                'valor_movimento' => $custoTotalProducao
            ];

            $this->estoque->insertMovimentoEstoque($dadosEstoque);            
             
            
            //Atualiza Custo Médio produto
            $custoMedio = $this->estoque->getCustoMedio($codProduto);
            if($custoMedio != null && $custoMedio->custo_medio != 0){

                $dadosProd = null;
                $dadosProd = [
                    'custo_medio' => $custoMedio->custo_medio
                ];
        
                $this->produto->updateProduto($codProduto, $dadosProd);
            }
            
            $this->session->set_flashdata('sucesso', 'Reporte realizado com sucesso');            
            redirect(base_url("producao/reporte-producao/novo-reporte-producao/{$numOrdemProducao}"), "home", "refresh");

        }        
    } 

    public function estornarReporteProducao($numOrdemProducao = null){

        $codReporteProd = $this->input->post("estornar_todos");
        $numRegs = count($codReporteProd);
        

        if($numRegs > 0){

            // Atualiza ordem de produção                
            $ordemProducao = $this->producao->getOrdemProducaoPorCodigo($numOrdemProducao); 
            
            foreach($codReporteProd as $reporte){ 

                // Valida saldo do produto produzido para estorno                
                $listaMovimentos = $this->estoque->getMovimentosEstoquePorReporte($reporte);

                $reporteProducao = $this->producao->getReportesPorducaoPorCodigo($reporte);

                if(($ordemProducao->quant_produzida - $reporteProducao->quant_reportada) >= $ordemProducao->quant_planejada) {
                    $status = 3;
                }elseif(($ordemProducao->quant_produzida - $reporteProducao->quant_reportada) == 0){
                    $status = 4;
                }else{
                    $status = 2;
                }  

                $dados = [
                    'quant_produzida' => $ordemProducao->quant_produzida - $reporteProducao->quant_reportada,
                    'status' => $status
                ];

                $this->producao->updateOrdemProducao($numOrdemProducao, $dados);

                $dados = null;

                // Atualiza reporte de produção                
                $dados = [
                    'estornado' => '1'
                ];
    
                $this->producao->updateReporteProducao($reporte, $dados); 

                foreach($listaMovimentos as $movimentos){
                    
                    if($movimentos->especie_movimento == 2){
                        $especieMovimento = 6;
                    }elseif($movimentos->especie_movimento == 3){
                        $especieMovimento = 7;
                    }

                    if($movimentos->tipo_movimento == 1){

                        $tipoMovimento = 2;

                    }elseif($movimentos->tipo_movimento == 2){

                        $tipoMovimento = 1;

                    }

                    $dadosEstoque = null;
                    $dadosEstoque = [
                        'considera_calc_custo' => 1
                    ];

                    $this->estoque->updateMovimentoEstoque($movimentos->cod_movimento_estoque, $dadosEstoque);

                    $dadosEstoque = null;
                    $dadosEstoque = [
                        'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                        'data_movimento' => $movimentos->data_movimento,
                        'cod_produto' => $movimentos->cod_produto,
                        'origem_movimento' => 1,
                        'id_origem' => $reporte,
                        'tipo_movimento' => $tipoMovimento,
                        'especie_movimento' => $especieMovimento,
                        'quant_movimentada' => $movimentos->quant_movimentada,
                        'valor_movimento' => $movimentos->valor_movimento,
                        'considera_calc_custo' => 1
                    ];
        
                    $this->estoque->insertMovimentoEstoque($dadosEstoque);
                }
            }
            
            $this->session->set_flashdata('sucesso', 'Registro(s) selecionado(s) estornado(s) com sucesso');

        }else{ 
            $this->session->set_flashdata('erro', 'Nenhum registro foi selecionado');
        }

        redirect(base_url("producao/reporte-producao/novo-reporte-producao/{$numOrdemProducao}"), "home", "refresh");       

    }

    public function listarOrdemProducao(){     
        
        // Busca dos dados para apresentação
        $filter = ($this->input->get('buscar')) ? $this->input->get('buscar') : "";
        $offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        

        $config = array(
            'base_url' => base_url("producao/ordem-producao"),
            'per_page' => 10,
            'num_links' => 10,
            'uri_segment' => 3,
            'total_rows' => $this->producao->countAll($filter),
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

        $listaOrdem = $this->producao->getOrdemProducao($filter, $config["per_page"], $offset);

        $this->pagination->initialize($config);      


        $dados = array(
            'filter' => $filter,
            'filter' => $filter,
            'pagination' => $this->pagination->create_links(),
            'lista_ordem' => $listaOrdem,
            'menu' => 'Producao'
        );

        $this->load->view('producao/ordem-producao', $dados);
    }

    public function listarOrdemReporte(){      

        // Busca dos dados para apresentação
        $filter = ($this->input->get('buscar')) ? $this->input->get('buscar') : "";
        $offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $config = array(
            'base_url' => base_url('producao/reporte-producao'),
            'per_page' => 10,
            'num_links' => 10,
            'uri_segment' => 3,
            'total_rows' => $this->producao->countAll($filter),
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
        
        $listaOrdem = $this->producao->getOrdemProducao($filter, $config["per_page"], $offset);


        $dados = array(
            'filter' => $filter,
            'pagination' => $this->pagination->create_links(),
            'lista_ordem' => $listaOrdem,
            'menu' => 'Producao'
        );

        $this->load->view('producao/reporte-producao', $dados);
    }   
    

    //Relatório
    public function producaoProduto(){
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

        $codProdutos = $this->input->get('produto'); 

        $listaPrudutoProd = $this->produto->getProdutoProduzido();
        $totalProducao = $this->producao->totalProducao($dataInicio, $dataFim, $codProdutos);
        $listaProducaoResumida = $this->producao->producaoResumida($dataInicio, $dataFim, $codProdutos);
        $listaProducaoDetalhada = $this->producao->producaoDetalhada($dataInicio, $dataFim, $codProdutos);

        $dados = array(
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
            'cod_produto' => $codProdutos,
            'lista_produto_prod' => $listaPrudutoProd,
            'total_producao' => $totalProducao,
            'lista_producao_resumida' => $listaProducaoResumida,
            'lista_producao_detalhada' => $listaProducaoDetalhada,
            'menu' => 'Producao'
            
        );

        $this->load->view('producao/producao-produto', $dados);

    }

    public function consumoProduto(){
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

        $codProdutosProduzido = $this->input->get('produtoProduzido'); 
        $codProdutosConsumido = $this->input->get('produtoConsumido'); 

        $listaPrudutoProd = $this->produto->getProdutoProduzido();
        $listaPrudutoCons = $this->produto->getProduto();
        $totalProducao = $this->producao->totalCustoConsumo($dataInicio, $dataFim, $codProdutosProduzido, $codProdutosConsumido);
        $listaConsumoResumido = $this->producao->consumoResumido($dataInicio, $dataFim, $codProdutosProduzido, $codProdutosConsumido);
        $listaConsumoDetalhado = $this->producao->consumoDetalhado($dataInicio, $dataFim, $codProdutosProduzido, $codProdutosConsumido);

        $dados = array(
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
            'cod_produto_produzido' => $codProdutosProduzido,
            'cod_produto_consumido' => $codProdutosConsumido,
            'lista_produto_prod' => $listaPrudutoProd,
            'lista_produto_cons' => $listaPrudutoCons,
            'total_producao' => $totalProducao,
            'lista_consumo_resumida' => $listaConsumoResumido,
            'lista_consumo_detalhado' => $listaConsumoDetalhado,
            'menu' => 'Producao'
            
        );

        $this->load->view('producao/consumo-produto', $dados);

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
        if(floatval(str_replace(",",".",(str_replace(".","",$str)))) <= 0.000){
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