<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FinanceiroController extends CI_Controller {

    function __construct(){
        parent::__construct();

        if(usuarioLogado() == false){

            redirect(base_url("login"), "home", "refresh");

        }

        if(getDadosUsuarioLogado()['financeiro'] != 1){

            redirect(base_url("visao-geral"), "home", "refresh");

        }
    }

    public function formConta(){

        $dados = array(
            'menu' => 'Cadastro'
        );

        $this->load->view('cadastros/nova-conta', $dados);
    }

    public function formMetodoPagamento(){

        $listaConta = $this->financeiro->getConta();

        $dados = array(
            'lista_conta' => $listaConta,
            'menu' => 'Cadastro'
        );

        $this->load->view('cadastros/novo-metodo-pagamento', $dados);
    }

    public function formCentroCusto(){

        $dados = array(
            'menu' => 'Cadastro'
        );

        $this->load->view('cadastros/novo-centro-custo', $dados);
    }

    public function formContaContabil(){

        $listaContaContabil = $this->financeiro->getContaContabil();

        $dados = array(
            'lista_conta_contabil' => $listaContaContabil,
            'menu' => 'Cadastro'
        );

        $this->load->view('cadastros/nova-conta-contabil', $dados);
    }

    public function editarConta($codConta){

        $conta = $this->financeiro->getContaPorCodigo($codConta);

        if($conta == null){
            redirect(base_url('conta'));
            
        }else{            
            $dados = array(
                'conta' => $conta,
                'menu' => 'Cadastro'
            );
        }

        $this->load->view('cadastros/editar-conta', $dados);

    }

    public function editarMetodoPagamento($codMetodoPagamento){

        $metodo_pagamento = $this->financeiro->getMetodoPagamentoPorCodigo($codMetodoPagamento);

        if($metodo_pagamento == null){
            redirect(base_url('metodo-pagamento'));
            
        }else{      
            $listaConta = $this->financeiro->getConta();

            $dados = array(
                'metodo_pagamento' => $metodo_pagamento,
                'lista_conta' => $listaConta,
                'menu' => 'Cadastro'
            );
        }

        $this->load->view('cadastros/editar-metodo-pagamento', $dados);

    }

    public function editarCentroCusto($codCentroCusto){

        $centroCusto = $this->financeiro->getCentroCustoPorCodigo($codCentroCusto);

        if($centroCusto == null){
            redirect(base_url('centro-custo'));
            
        }else{            
            $dados = array(
                'centro_custo' => $centroCusto,
                'menu' => 'Cadastro'
            );
        }

        $this->load->view('cadastros/editar-centro-custo', $dados);

    }

    public function editarContaContabil($codContaContabil){

        $conta_contabil = $this->financeiro->getContaContabilPorCodigo($codContaContabil);

        if($conta_contabil == null){
            redirect(base_url('conta-contabil'));
            
        }else{            
            $dados = array(
                'conta_contabil' => $conta_contabil,
                'menu' => 'Cadastro'
            );
        }

        $this->load->view('cadastros/editar-conta-contabil', $dados);

    }

    public function inserirConta(){  

        //Validações dos campo e array das mensagens apresentadas
        $this->form_validation->set_rules('NomeConta', 'Nome da Conta', 'required|max_length[100]',
            array('required' => 'Você deve preencher o campo %s',
                  'max_length' => 'O campo %s não deve ter mais que 45 caracteres'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            $this->formConta();
            
        }else {

            //Conversão quantidade estoque
            $saldoInicial = floatval(str_replace(",",".",(str_replace(".","",$this->input->post('SaldoInicial')))));

            $data = [
                'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                'nome_conta'  => $this->input->post('NomeConta'),
                'ativo' => $this->input->post('Ativo')
            ];

            $codConta = $this->financeiro->insertConta($data);

            //Movimenta conta inicial
            if($saldoInicial > 0){

                if($this->input->post('TipoSaldo') == 1){

                    $dadosMovimento = [
                        'cod_conta' => $codConta,
                        'tipo_movimento' => 1,
                        'data_competencia' => date("Y-m-d"),
                        'data_vencimento' => date("Y-m-d"),
                        'data_confirmacao' => date("Y-m-d"),
                        'parcela' => '1/1',
                        'valor_titulo' => $saldoInicial,
                        'valor_confirmado' => $saldoInicial,
                        'desc_movimento' => "Saldo inicial da conta",
                        'confirmado' => 1
                    ];

                    $this->financeiro->insertMovimentoConta($dadosMovimento);

                }elseif($this->input->post('TipoSaldo') == 2){

                    $dadosMovimento = [
                        'cod_conta' => $codConta,
                        'tipo_movimento' => 2,
                        'data_vencimento' => date("Y-m-d"),
                        'parcela' => '1/1',
                        'valor_titulo' => $saldoInicial,
                        'valor_confirmado' => $saldoInicial,
                        'desc_movimento' => "Saldo inicial da conta",
                        'confirmado' => 1
                    ];
    
                    $this->financeiro->insertMovimentoConta($dadosMovimento);

                }
            }

            //Se optar por salvar e continuar, mantém na página de cadastro
            if ($this->input->post('Opcao') == 'salvarContinuar'){

                $this->session->set_flashdata('sucesso', 'Conta cadastrada com sucesso');
                redirect(base_url('conta/nova-conta'));


            }else {

                $this->session->set_flashdata('sucesso', 'Conta cadastrada com sucesso');
                redirect(base_url('conta'));
            }            
        }        
    }

    public function inserirCentroCusto(){  

        //Validações dos campo e array das mensagens apresentadas
        $this->form_validation->set_rules('CodCentroCusto', 'Código Centro de Custo', 'required|max_length[60]',
            array('required' => 'Você deve preencher o campo %s',
                  'max_length' => 'O campo %s não deve ter mais que 60 caracteres'));
        $this->form_validation->set_rules('NomeCentroCusto', 'Nome do Centro de Custo', 'required|max_length[100]',
            array('required' => 'Você deve preencher o campo %s',
                  'max_length' => 'O campo %s não deve ter mais que 100 caracteres'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            $this->formCentroCusto();
            
        }else {

            $data = [
                'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                'cod_centro_custo'  => $this->input->post('CodCentroCusto'),
                'nome_centro_custo'  => $this->input->post('NomeCentroCusto'),
                'ativo' => $this->input->post('Ativo')
            ];

            $this->financeiro->insertCentroCusto($data);

            //Se optar por salvar e continuar, mantém na página de cadastro
            if ($this->input->post('Opcao') == 'salvarContinuar'){

                $this->session->set_flashdata('sucesso', 'Centro de custo cadastrado com sucesso');
                redirect(base_url('centro-custo/novo-centro-custo'));


            }else {

                $this->session->set_flashdata('sucesso', 'Centro de custo cadastrado com sucesso');
                redirect(base_url('centro-custo'));
            }            
        }        
    }

    public function inserirMetodoPagamento(){  

        //Validações dos campo e array das mensagens apresentadas
        $this->form_validation->set_rules('NomeMetodoPagamento', 'Nome do Método de Pagamento', 'required|max_length[60]',
            array('required' => 'Você deve preencher o campo %s',
                  'max_length' => 'O campo %s não deve ter mais que 60 caracteres'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            $this->formMetodoPagamento();
            
        }else {

            $data = [
                'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                'nome_metodo_pagamento'  => $this->input->post('NomeMetodoPagamento'),
                'cod_conta' => ($this->input->post('CodConta')) ?$this->input->post('CodConta') : null,
                'taxa_operacao' => floatval(str_replace(",",".",(str_replace(".","",$this->input->post('TaxaOperacao'))))),
                'dias_recebimento'  => $this->input->post('DiasRecebimento'),
                
            ];

            $this->financeiro->insertMetodoPagamento($data);

            //Se optar por salvar e continuar, mantém na página de cadastro
            if ($this->input->post('Opcao') == 'salvarContinuar'){

                $this->session->set_flashdata('sucesso', 'Método de pagamento cadastrado com sucesso');
                redirect(base_url('metodo-pagamento/novo-metodo-pagamento'));


            }else {

                $this->session->set_flashdata('sucesso', 'Método de pagamento cadastrado com sucesso');
                redirect(base_url('metodo-pagamento'));
            }            
        }        
    }

    public function inserirContaContabil(){  

        //Validações dos campo e array das mensagens apresentadas
        $this->form_validation->set_rules('CodContaContabil', 'Código Centro de Custo', 'required|max_length[60]|is_unique[usuario.email]',
            array('required' => 'Você deve preencher o campo %s',
                  'max_length' => 'O campo %s não deve ter mais que 60 caracteres'));
        $this->form_validation->set_rules('NomeContaContabil', 'Nome do Centro de Custo', 'required|max_length[60]',
            array('required' => 'Você deve preencher o campo %s',
                  'max_length' => 'O campo %s não deve ter mais que 60 caracteres'));        

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            $this->formContaContabil();
            
        }else {

            if($this->input->post('CodContaContabilPai') != ""){
                $codContaContabil = $this->input->post('CodContaContabilPai') . "." . $this->input->post('CodContaContabil');
            }else{
                $codContaContabil = $this->input->post('CodContaContabil');
            }

            $data = [
                'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                'cod_conta_contabil'  => $codContaContabil,
                'cod_conta_contabil_pai' => $this->input->post('CodContaContabilPai'),
                'nome_conta_contabil'  => $this->input->post('NomeContaContabil'),
                'ativo' => $this->input->post('Ativo')
            ];

            $this->financeiro->insertContaContabil($data);

            //Se optar por salvar e continuar, mantém na página de cadastro
            if ($this->input->post('Opcao') == 'salvarContinuar'){

                $this->session->set_flashdata('sucesso', 'Conta contábil cadastrada com sucesso');
                redirect(base_url('conta-contabil/nova-conta-contabil'));


            }else {

                $this->session->set_flashdata('sucesso', 'Conta contábil cadastrada com sucesso');
                redirect(base_url('conta-contabil'));
            }            
        }        
    }

    public function salvarConta($codConta){

        //Validações dos campos
        $this->form_validation->set_rules('NomeConta', 'Nome da Conta', 'required|max_length[100]',
            array('required' => 'Você deve preencher o campo %s',
                  'max_length' => 'O campo %s não deve ter mais que 100 caracteres'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            $this->editarConta($codConta);
            
        }else {

            $dados = [
                'nome_conta'  => $this->input->post('NomeConta'),
                'ativo' => $this->input->post('Ativo')
            ];

            $this->financeiro->updateConta($codConta, $dados);

            $this->session->set_flashdata('sucesso', 'Conta alterada com sucesso');
            redirect(base_url('conta'));          
        }
    }

    public function salvarCentroCusto($codCentroCusto){

        //Validações dos campos
        $this->form_validation->set_rules('NomeCentroCusto', 'Nome do CentroCusto', 'required|max_length[100]',
            array('required' => 'Você deve preencher o campo %s',
                  'max_length' => 'O campo %s não deve ter mais que 100 caracteres'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            $this->editarCentroCusto($codCentroCusto);
            
        }else {

            $dados = [
                'nome_centro_custo'  => $this->input->post('NomeCentroCusto'),
                'ativo' => $this->input->post('Ativo')
            ];

            $this->financeiro->updateCentroCusto($codCentroCusto, $dados);

            $this->session->set_flashdata('sucesso', 'Centro de custo alterado com sucesso');
            redirect(base_url('centro-custo'));          
        }
    }

    public function salvarContaContabil($codContaContabil){

        //Validações dos campos
        $this->form_validation->set_rules('NomeContaContabil', 'Nome do Centro de Custo', 'required|max_length[60]',
            array('required' => 'Você deve preencher o campo %s',
                  'max_length' => 'O campo %s não deve ter mais que 60 caracteres'));  

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            $this->editarContaContabil($codContaContabil);
            
        }else {

            $dados = [
                'nome_conta_contabil'  => $this->input->post('NomeContaContabil'),
                'ativo' => $this->input->post('Ativo')
            ];

            $this->financeiro->updateContaContabil($codContaContabil, $dados);

            $this->session->set_flashdata('sucesso', 'Centro de custo alterado com sucesso');
            redirect(base_url('conta-contabil'));          
        }
    }

    public function salvarMetodoPagamento($codMetodoPagamento){

        //Validações dos campos
        $this->form_validation->set_rules('NomeMetodoPagamento', 'Nome do Método de Pagamento', 'required|max_length[60]',
            array('required' => 'Você deve preencher o campo %s',
                  'max_length' => 'O campo %s não deve ter mais que 60 caracteres'));  

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            $this->editarMetodoPagamento($codMetodoPagamento);
            
        }else {

            $dados = [
                'nome_metodo_pagamento'  => $this->input->post('NomeMetodoPagamento'),
                'cod_conta' => ($this->input->post('CodConta')) ?$this->input->post('CodConta') : null,
                'taxa_operacao' => floatval(str_replace(",",".",(str_replace(".","",$this->input->post('TaxaOperacao'))))),
                'dias_recebimento'  => $this->input->post('DiasRecebimento'),
            ];

            $this->financeiro->updateMetodoPagamento($codMetodoPagamento, $dados);

            $this->session->set_flashdata('sucesso', 'Método de pagamento alterado com sucesso');
            redirect(base_url('metodo-pagamento'));          
        }
    }

    public function inserirTituloContasPagar(){
        $mes = $this->uri->segment(4);
        $ano = $this->uri->segment(5);

        //Validações dos campo e array das mensagens apresentadas
        $this->form_validation->set_rules('DataCompetencia', 'Data de Competência', 'required|callback_date_check', 
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('ValorTitulo', 'Valor a Pagar', 'required|callback_more_zero',
            array('required' => 'Você deve preencher o campo %s'));        
        $this->form_validation->set_rules('DataVencimento[]', 'Data de Vencimento', 'required', 
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('CodConta', 'Conta', 'required',
            array('required' => 'Você deve preencher o campo %s'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            redirect(base_url("financeiro/contas-pagar/{$mes}/{$ano}"));;
            
        }else {

            $numParcela = $this->input->post('Parcelas');
            $dataVencimento = $this->input->post('DataVencimento');
            $valorParcela = $this->input->post('ValorParcela');

            $valorTotal = floatval(str_replace(",",".",(str_replace(".","",$this->input->post('ValorTitulo')))));

            for ($i = 1; $i <= $numParcela; $i++) {   
                
                //Cria título                
                $dadosMovimento = null;
                $dadosMovimento = [
                    'cod_conta' => $this->input->post('CodConta'),
                    'cod_metodo_pagamento' => $this->input->post('CodMetodoPagamento'),
                    'cod_centro_custo' => $this->input->post('CodCentroCusto'),
                    'cod_conta_contabil' => $this->input->post('CodContaContabil'),
                    'cod_emitente' => $this->input->post('CodFornecedor'),
                    'data_competencia' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataCompetencia')))),  
                    'data_confirmacao' => ($this->input->post('DataConfirmacao')) ? date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataConfirmacao')))) : null,                  
                    'tipo_movimento' => 2,
                    'data_vencimento' => date("Y-m-d", strtotime(str_replace('/', '-', $dataVencimento[$i]))),
                    'parcela' => $i . '/' . $numParcela,
                    'desc_movimento' => $this->input->post('Descricao'),
                    'valor_titulo' => floatval(str_replace(",",".",(str_replace(".","",$valorParcela[$i])))),
                    'valor_desc_taxa' => floatval(str_replace(",",".",(str_replace(".","",$this->input->post('ValorDescontoTaxas'))))),
                    'valor_juros_multa' => floatval(str_replace(",",".",(str_replace(".","",$this->input->post('ValorMultasJustos'))))),
                    'valor_confirmado' => floatval(str_replace(",",".",(str_replace(".","",$this->input->post('ValorPagar'))))),
                    'confirmado' => ($this->input->post('Confirmar')) ? $this->input->post('Confirmar') : 0
                ];
                $titulo = $this->financeiro->insertMovimentoConta($dadosMovimento);

            }            
        }

        $this->session->set_flashdata('sucesso', 'Título criado com sucesso');
        redirect(base_url("financeiro/contas-pagar/{$mes}/{$ano}"));

    }

    public function inserirTitulo($codConta){

        //Validações dos campo e array das mensagens apresentadas
        $this->form_validation->set_rules('DataCompetencia', 'Data de Competência', 'required|callback_date_check', 
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('ValorTitulo', 'Valor do Título', 'required|callback_more_zero',
            array('required' => 'Você deve preencher o campo %s'));        
        $this->form_validation->set_rules('DataVencimento', 'Data de Vencimento', 'required', 
            array('required' => 'Você deve preencher o campo %s'));        

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            redirect(base_url("financeiro/saldo-conta/movimento-conta/{$codConta}"));;
            
        }else {

            $dadosMovimento = [
                'cod_conta' => $codConta,
                'cod_centro_custo' => $this->input->post('CodCentroCusto'),
                'cod_conta_contabil' => $this->input->post('CodContaContabil'),
                'tipo_movimento' => $this->input->post('TipoMovimento'),
                'data_competencia' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataCompetencia')))),
                'data_confirmacao' => ($this->input->post('DataConfirmacao')) ? date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataConfirmacao')))) : null,  
                'data_vencimento' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataVencimento')))),
                'parcela' => '1/1',
                'desc_movimento' => $this->input->post('Descricao'),
                'valor_titulo' => str_replace(",",".",(str_replace(".","",$this->input->post('ValorTitulo')))),
                'valor_desc_taxa' => floatval(str_replace(",",".",(str_replace(".","",$this->input->post('ValorDescontoTaxas'))))),
                'valor_juros_multa' => floatval(str_replace(",",".",(str_replace(".","",$this->input->post('ValorMultasJustos'))))),
                'valor_confirmado' => floatval(str_replace(",",".",(str_replace(".","",$this->input->post('ValorConfirmado'))))),
                'confirmado' => ($this->input->post('Confirmar')) ? $this->input->post('Confirmar') : 0
            ];

            $titulo = $this->financeiro->insertMovimentoConta($dadosMovimento);

        }

        $this->session->set_flashdata('sucesso', 'Título criado com sucesso');
        redirect(base_url("financeiro/saldo-conta/movimento-conta/{$codConta}"));

    }

    public function inserirTituloContasReceber(){
        $mes = $this->uri->segment(4);
        $ano = $this->uri->segment(5);

        //Validações dos campo e array das mensagens apresentadas
        $this->form_validation->set_rules('DataCompetencia', 'Data de Competência', 'required|callback_date_check', 
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('ValorTitulo', 'Valor a Receber', 'required|callback_more_zero',
            array('required' => 'Você deve preencher o campo %s'));        
        $this->form_validation->set_rules('DataVencimento[]', 'Data de Vencimento', 'required', 
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('CodConta', 'Conta', 'required',
            array('required' => 'Você deve preencher o campo %s'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            redirect(base_url("financeiro/contas-receber/{$mes}/{$ano}"));;
            
        }else {

            $numParcela = $this->input->post('Parcelas');
            $dataVencimento = $this->input->post('DataVencimento');
            $valorParcela = $this->input->post('ValorParcela');

            $valorTotal = floatval(str_replace(",",".",(str_replace(".","",$this->input->post('ValorTitulo')))));

            for ($i = 1; $i <= $numParcela; $i++) {
                
                //Criação do título                
                $dadosMovimento = null;
                $dadosMovimento = [
                    'cod_conta' => $this->input->post('CodConta'),
                    'cod_metodo_pagamento' => $this->input->post('CodMetodoPagamento'),
                    'cod_emitente' => $this->input->post('CodCliente'),
                    'cod_centro_custo' => $this->input->post('CodCentroCusto'),
                    'cod_conta_contabil' => $this->input->post('CodContaContabil'),
                    'tipo_movimento' => 1,
                    'data_competencia' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataCompetencia')))),
                    'data_confirmacao' => ($this->input->post('DataConfirmacao')) ? date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataConfirmacao')))) : null, 
                    'data_vencimento' => date("Y-m-d", strtotime(str_replace('/', '-', $dataVencimento[$i]))),
                    'parcela' => $i . '/' . $numParcela,
                    'desc_movimento' => $this->input->post('Descricao'),
                    'valor_titulo' => floatval(str_replace(",",".",(str_replace(".","",$valorParcela[$i])))),
                    'valor_desc_taxa' => floatval(str_replace(",",".",(str_replace(".","",$this->input->post('ValorDescontoTaxas'))))),
                    'valor_juros_multa' => floatval(str_replace(",",".",(str_replace(".","",$this->input->post('ValorMultasJustos'))))),
                    'valor_confirmado' => floatval(str_replace(",",".",(str_replace(".","",$this->input->post('ValorReceber'))))),
                    'confirmado' => ($this->input->post('Confirmar')) ? $this->input->post('Confirmar') : 0
                ];

                $titulo = $this->financeiro->insertMovimentoConta($dadosMovimento);
            }

        }

        $this->session->set_flashdata('sucesso', 'Título criado com sucesso');
        redirect(base_url("financeiro/contas-receber/{$mes}/{$ano}"));

    }

    public function inserirTransferencia($codConta){

        //Validações dos campo e array das mensagens apresentadas
        $this->form_validation->set_rules('DataCompetencia', 'Data de Competência', 'required|callback_date_check', 
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('ValorTitulo', 'Valor do Título', 'required|callback_more_zero',
            array('required' => 'Você deve preencher o campo %s'));        
        $this->form_validation->set_rules('DataVencimento', 'Data de Vencimento', 'required', 
            array('required' => 'Você deve preencher o campo %s'));     
        $this->form_validation->set_rules('CodConta', 'Conta', 'required',
            array('required' => 'Você deve preencher o campo %s'));   

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            redirect(base_url("financeiro/saldo-conta/movimento-conta/{$codConta}"));;
            
        }else {

            $dadosMovimento = [
                'cod_conta' => $codConta,
                'cod_centro_custo' => $this->input->post('CodCentroCusto'),
                'cod_conta_contabil' => $this->input->post('CodContaContabil'),
                'tipo_movimento' => 2,
                'data_competencia' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataCompetencia')))),
                'data_confirmacao' => ($this->input->post('DataConfirmacao')) ? date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataConfirmacao')))) : null,  
                'data_vencimento' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataVencimento')))),
                'parcela' => '1/1',
                'desc_movimento' => $this->input->post('Descricao'),
                'valor_titulo' => str_replace(",",".",(str_replace(".","",$this->input->post('ValorTitulo')))),
                'valor_desc_taxa' => floatval(str_replace(",",".",(str_replace(".","",$this->input->post('ValorDescontoTaxas'))))),
                'valor_juros_multa' => floatval(str_replace(",",".",(str_replace(".","",$this->input->post('ValorMultasJustos'))))),
                'valor_confirmado' => floatval(str_replace(",",".",(str_replace(".","",$this->input->post('ValorConfirmado'))))),
                'confirmado' => ($this->input->post('Confirmar')) ? $this->input->post('Confirmar') : 0
            ];
            $tituloOrigem = $this->financeiro->insertMovimentoConta($dadosMovimento);

            $dadosMovimento = null;
            $dadosMovimento = [
                'cod_titulo_rel' => $tituloOrigem,
                'cod_conta' => $this->input->post('CodConta'),
                'cod_centro_custo' => $this->input->post('CodCentroCusto'),
                'cod_conta_contabil' => $this->input->post('CodContaContabil'),
                'tipo_movimento' => 1,
                'data_competencia' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataCompetencia')))),
                'data_confirmacao' => ($this->input->post('DataConfirmacao')) ? date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataConfirmacao')))) : null,  
                'data_vencimento' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataVencimento')))),
                'parcela' => '1/1',
                'desc_movimento' => $this->input->post('Descricao'),
                'valor_titulo' => str_replace(",",".",(str_replace(".","",$this->input->post('ValorTitulo')))),
                'valor_desc_taxa' => floatval(str_replace(",",".",(str_replace(".","",$this->input->post('ValorDescontoTaxas'))))),
                'valor_juros_multa' => floatval(str_replace(",",".",(str_replace(".","",$this->input->post('ValorMultasJustos'))))),
                'valor_confirmado' => floatval(str_replace(",",".",(str_replace(".","",$this->input->post('ValorConfirmado'))))),
                'confirmado' => ($this->input->post('Confirmar')) ? $this->input->post('Confirmar') : 0
            ];
            $tituloDestino = $this->financeiro->insertMovimentoConta($dadosMovimento);

            $dadosMovimento = null;
            $dadosMovimento = [
                'cod_conta' => $codConta,
                'confirmado' => ($this->input->post('Confirmar')) ? $this->input->post('Confirmar') : 0,
                'cod_titulo_rel' => $tituloDestino
            ];
            $this->financeiro->updateMovimentoConta($tituloOrigem, $dadosMovimento);

        }

        $this->session->set_flashdata('sucesso', 'Transferência criada com sucesso');
        redirect(base_url("financeiro/saldo-conta/movimento-conta/{$codConta}"));

    }

    public function salvarTitulo(){

        $codMovimento = $this->uri->segment(4);
        $codConta = $this->uri->segment(5);

        //Validações dos campo e array das mensagens apresentadas
        $this->form_validation->set_rules('ValorTitulo', 'Valor do Título', 'required|callback_more_zero',
            array('required' => 'Você deve preencher o campo %s'));        
        $this->form_validation->set_rules('DataVencimento', 'Data de Vencimento', 'required', 
            array('required' => 'Você deve preencher o campo %s'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            redirect(base_url("financeiro/saldo-conta/movimento-conta/{$codConta}"));
            
        }else {

            $movimento = $this->financeiro->getMovimentoPorCodigo($codMovimento);

            if($movimento->confirmado != 1){

                $dadosMovimento = [
                    'cod_conta' => $codConta,
                    'cod_centro_custo' => $this->input->post('CodCentroCusto'),
                    'cod_conta_contabil' => $this->input->post('CodContaContabil'),
                    'data_vencimento' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataVencimento')))),
                    'data_confirmacao' => ($this->input->post('DataConfirmacao')) ? date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataConfirmacao')))) : null, 
                    'desc_movimento' => $this->input->post('Descricao'),
                    'valor_titulo' => str_replace(",",".",(str_replace(".","",$this->input->post('ValorTitulo')))),
                    'valor_desc_taxa' => floatval(str_replace(",",".",(str_replace(".","",$this->input->post('ValorDescontoTaxas'))))),
                    'valor_juros_multa' => floatval(str_replace(",",".",(str_replace(".","",$this->input->post('ValorMultasJustos'))))),
                    'valor_confirmado' => floatval(str_replace(",",".",(str_replace(".","",$this->input->post('ValorConfirmado'))))),
                    'confirmado' => ($this->input->post('Confirmar')) ? $this->input->post('Confirmar') : 0
                ];

            }else{

                if($movimento->confirmado == 1 && $this->input->post('Confirmar') != 1){

                    $dadosMovimento = [
                        'cod_conta' => $codConta,
                        'data_confirmacao' => null,  
                        'valor_desc_taxa' => null,
                        'valor_juros_multa' => null,
                        'valor_confirmado' => null,
                        'confirmado' => ($this->input->post('Confirmar')) ? $this->input->post('Confirmar') : 0
                    ];

                }else{

                    $dadosMovimento = [
                        'cod_conta' => $codConta,
                        'data_confirmacao' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataConfirmacao')))),  
                        'valor_desc_taxa' => floatval(str_replace(",",".",(str_replace(".","",$this->input->post('ValorDescontoTaxas'))))),
                        'valor_juros_multa' => floatval(str_replace(",",".",(str_replace(".","",$this->input->post('ValorMultasJustos'))))),
                        'valor_confirmado' => floatval(str_replace(",",".",(str_replace(".","",$this->input->post('ValorConfirmado'))))),
                        'confirmado' => ($this->input->post('Confirmar')) ? $this->input->post('Confirmar') : 0
                    ];

                }              

            }

            $this->financeiro->updateMovimentoConta($codMovimento, $dadosMovimento);

        }

        $this->session->set_flashdata('sucesso', 'Título alterado com sucesso');
        redirect(base_url("financeiro/saldo-conta/movimento-conta/{$codConta}"));

    }

    public function salvarTituloContasPagar($codMovimento){

        $mes = $this->uri->segment(5);
        $ano = $this->uri->segment(6);

        //Validações dos campo e array das mensagens apresentadas
        $this->form_validation->set_rules('ValorTitulo', 'Valor a Pagar', 'required|callback_more_zero',
            array('required' => 'Você deve preencher o campo %s'));        
        $this->form_validation->set_rules('DataVencimento', 'Data de Vencimento', 'required', 
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('CodConta', 'Conta', 'required',
            array('required' => 'Você deve preencher o campo %s'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            redirect(base_url("financeiro/contas-pagar/{$mes}/{$ano}"));
            
        }else {

            $dadosMovimento = [
                'cod_conta' => $this->input->post('CodConta'),
                'cod_metodo_pagamento' => $this->input->post('CodMetodoPagamento'),
                'cod_emitente' => $this->input->post('CodFornecedor'),
                'cod_centro_custo' => $this->input->post('CodCentroCusto'),
                'cod_conta_contabil' => $this->input->post('CodContaContabil'),
                'tipo_movimento' => 2,
                'data_vencimento' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataVencimento')))),
                'data_confirmacao' => ($this->input->post('DataConfirmacao')) ? date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataConfirmacao')))) : null,
                'desc_movimento' => $this->input->post('Descricao'),
                'valor_titulo' => str_replace(",",".",(str_replace(".","",$this->input->post('ValorTitulo')))),
                'valor_desc_taxa' => floatval(str_replace(",",".",(str_replace(".","",$this->input->post('ValorDescontoTaxas'))))),
                'valor_juros_multa' => floatval(str_replace(",",".",(str_replace(".","",$this->input->post('ValorMultasJustos'))))),
                'valor_confirmado' => floatval(str_replace(",",".",(str_replace(".","",$this->input->post('ValorPagar'))))),
                'confirmado' => ($this->input->post('Confirmar')) ? $this->input->post('Confirmar') : 0
            ];

            $this->financeiro->updateMovimentoConta($codMovimento, $dadosMovimento);

        }

        $this->session->set_flashdata('sucesso', 'Título alterado com sucesso');
        redirect(base_url("financeiro/contas-pagar/{$mes}/{$ano}?". $_SERVER['REQUEST_URI']));

    }

    public function salvarTituloContasReceber($codMovimento){

        $mes = $this->uri->segment(5);
        $ano = $this->uri->segment(6);

        //Validações dos campo e array das mensagens apresentadas
        $this->form_validation->set_rules('ValorTitulo', 'Valor a Receber', 'required|callback_more_zero',
            array('required' => 'Você deve preencher o campo %s'));        
        $this->form_validation->set_rules('DataVencimento', 'Data de Vencimento', 'required', 
            array('required' => 'Você deve preencher o campo %s'));
        $this->form_validation->set_rules('CodConta', 'Conta', 'required',
            array('required' => 'Você deve preencher o campo %s'));

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            redirect(base_url("financeiro/contas-receber/{$mes}/{$ano}"));
            
        }else {

            $dadosMovimento = [
                'cod_conta' => $this->input->post('CodConta'),
                'cod_metodo_pagamento' => $this->input->post('CodMetodoPagamento'),
                'cod_emitente' => $this->input->post('CodCliente'),
                'cod_centro_custo' => $this->input->post('CodCentroCusto'),
                'cod_conta_contabil' => $this->input->post('CodContaContabil'),
                'tipo_movimento' => 1,
                'data_vencimento' => date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataVencimento')))),
                'data_confirmacao' => ($this->input->post('DataConfirmacao')) ? date("Y-m-d", strtotime(str_replace('/', '-', $this->input->post('DataConfirmacao')))) : null, 
                'desc_movimento' => $this->input->post('Descricao'),
                'cod_conta_contabil' => $this->input->post("CodContaContabil"),
                'valor_titulo' => str_replace(",",".",(str_replace(".","",$this->input->post('ValorTitulo')))),
                'valor_desc_taxa' => floatval(str_replace(",",".",(str_replace(".","",$this->input->post('ValorDescontoTaxas'))))),
                'valor_juros_multa' => floatval(str_replace(",",".",(str_replace(".","",$this->input->post('ValorMultasJustos'))))),
                'valor_confirmado' => floatval(str_replace(",",".",(str_replace(".","",$this->input->post('ValorReceber'))))),
                'confirmado' => ($this->input->post('Confirmar')) ? $this->input->post('Confirmar') : 0
            ];

            $this->financeiro->updateMovimentoConta($codMovimento, $dadosMovimento);

        }

        $this->session->set_flashdata('sucesso', 'Título alterado com sucesso');
        redirect(base_url("financeiro/contas-receber/{$mes}/{$ano}"));

    }

    public function excluirConta()
    {

        $codConta = $this->input->post("excluir_todos");
        

        $this->financeiro->deleteConta($codConta);

        $this->session->set_flashdata('sucesso', 'Registro(s) selecionado(s) excluído(s)');
        redirect(base_url('conta'));
    } 

    public function excluirMetodoPagamento()
    {

        $codMetodoPagamento = $this->input->post("excluir_todos");
        

        $this->financeiro->deleteMetodoPagamento($codMetodoPagamento);

        $this->session->set_flashdata('sucesso', 'Registro(s) selecionado(s) excluído(s)');
        redirect(base_url('metodo-pagamento'));
    } 

    public function excluirCentroCusto()
    {

        $codCentroCusto = $this->input->post("excluir_todos");
        

        $this->financeiro->deleteCentroCusto($codCentroCusto);

        $this->session->set_flashdata('sucesso', 'Registro(s) selecionado(s) excluído(s)');
        redirect(base_url('centro-custo'));
    }

    public function excluirContaContabil()
    {

        $codContaContabil = $this->input->post("excluir_todos");
        

        $this->financeiro->deleteContaContabil($codContaContabil);

        $this->session->set_flashdata('sucesso', 'Registro(s) selecionado(s) excluído(s)');
        redirect(base_url('conta-contabil'));
    }

    public function acaoTitulo($codConta)
    {

        $codMovimento = $this->input->post("selecionar_todos");

        if($this->input->post("Acao") == "Eliminar"){

            $this->financeiro->excluirTitulo($codMovimento);
            $this->session->set_flashdata('sucesso', 'Registro(s) selecionado(s) excluído(s)');

        }elseif($this->input->post("Acao") == "Confirmar"){

            foreach($codMovimento as $titulo){

                $movimento = $this->financeiro->getMovimentoPorCodigo($titulo);

                $dadosMovimento = null;
                $dadosMovimento = [
                    'cod_conta' => $movimento->cod_conta,
                    'data_confirmacao' => date("Y-m-d"),
                    'cod_centro_custo' => $movimento->cod_centro_custo,
                    'cod_conta_contabil' => $movimento->cod_conta_contabil,
                    'data_vencimento' => $movimento->data_vencimento,
                    'desc_movimento' => $movimento->desc_movimento,
                    'valor_titulo' => $movimento->valor_titulo,
                    'valor_desc_taxa' => 0,
                    'valor_juros_multa' => 0,
                    'valor_confirmado' => $movimento->valor_titulo,
                    'confirmado' => 1
                ];
    
                $this->financeiro->updateMovimentoConta($titulo, $dadosMovimento);
            }
            $this->session->set_flashdata('sucesso', 'Registro(s) selecionado(s) confirmado(s)');

        }

        redirect(base_url("financeiro/saldo-conta/movimento-conta/{$codConta}"));
    }

    public function acaoTituloContasPagar()
    {
        $mes = $this->uri->segment(4);
        $ano = $this->uri->segment(5);

        $codMovimento = $this->input->post("selecionar_todos");

        if($this->input->post("Acao") == "Eliminar"){

            $this->financeiro->excluirTituloContasPagar($codMovimento);
            $this->session->set_flashdata('sucesso', 'Registro(s) selecionado(s) excluído(s)');

        }elseif($this->input->post("Acao") == "Confirmar"){

            foreach($codMovimento as $titulo){

                $movimento = $this->financeiro->getMovimentoPorCodigo($titulo);

                $dadosMovimento = null;
                $dadosMovimento = [
                    'cod_conta' => $movimento->cod_conta,
                    'data_confirmacao' => date("Y-m-d"),
                    'cod_centro_custo' => $movimento->cod_centro_custo,
                    'cod_conta_contabil' => $movimento->cod_conta_contabil,
                    'data_vencimento' => $movimento->data_vencimento,
                    'desc_movimento' => $movimento->desc_movimento,
                    'valor_titulo' => $movimento->valor_titulo,
                    'valor_desc_taxa' => 0,
                    'valor_juros_multa' => 0,
                    'valor_confirmado' => $movimento->valor_titulo,
                    'confirmado' => 1
                ];
    
                $this->financeiro->updateMovimentoConta($titulo, $dadosMovimento);
            }
            $this->session->set_flashdata('sucesso', 'Registro(s) selecionado(s) confirmado(s)');

        }  
        
        redirect(base_url("financeiro/contas-pagar/{$mes}/{$ano}"));
    }

    public function acaoTituloContasReceber()
    {
        $mes = $this->uri->segment(4);
        $ano = $this->uri->segment(5);

        $codMovimento = $this->input->post("selecionar_todos");

        if($this->input->post("Acao") == "Eliminar"){

            $this->financeiro->excluirTituloContasReceber($codMovimento);
            $this->session->set_flashdata('sucesso', 'Registro(s) selecionado(s) excluído(s)');

        }elseif($this->input->post("Acao") == "Confirmar"){

            foreach($codMovimento as $titulo){

                $movimento = $this->financeiro->getMovimentoPorCodigo($titulo);

                $dadosMovimento = null;
                $dadosMovimento = [
                    'cod_conta' => $movimento->cod_conta,
                    'data_confirmacao' => date("Y-m-d"),
                    'cod_centro_custo' => $movimento->cod_centro_custo,
                    'cod_conta_contabil' => $movimento->cod_conta_contabil,
                    'data_vencimento' => $movimento->data_vencimento,
                    'desc_movimento' => $movimento->desc_movimento,
                    'valor_titulo' => $movimento->valor_titulo,
                    'valor_desc_taxa' => 0,
                    'valor_juros_multa' => 0,
                    'valor_confirmado' => $movimento->valor_titulo,
                    'confirmado' => 1
                ];
    
                $this->financeiro->updateMovimentoConta($titulo, $dadosMovimento);
            }
            $this->session->set_flashdata('sucesso', 'Registro(s) selecionado(s) confirmado(s)');

        }  
        
        redirect(base_url("financeiro/contas-receber/{$mes}/{$ano}"));
    }

    public function listarConta(){      

        $config = array(
            'base_url' => base_url('conta'),
            'per_page' => 10,
            'num_links' => 10,
            'uri_segment' => 2,
            'total_rows' => $this->financeiro->countAllConta(),
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

        // Busca dos dados para apresentação
        $filter = ($this->input->get('buscar')) ? $this->input->get('buscar') : "";
        $offset = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $listaConta = $this->financeiro->getConta($filter, $config["per_page"], $offset);


        $dados = array(
            'filter' => $filter,
            'pagination' => $this->pagination->create_links(),
            'lista_conta' => $listaConta,
            'menu' => 'Cadastro'
        );

        $this->load->view('cadastros/conta', $dados);
    } 

    public function listarMetodoPagamento(){      

        $config = array(
            'base_url' => base_url('metodo-pagamento'),
            'per_page' => 10,
            'num_links' => 10,
            'uri_segment' => 2,
            'total_rows' => $this->financeiro->countAllMetodoPagamento(),
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

        // Busca dos dados para apresentação
        $filter = ($this->input->get('buscar')) ? $this->input->get('buscar') : "";
        $offset = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $listaMetodoPagamento = $this->financeiro->getMetodoPagamento($filter, $config["per_page"], $offset);


        $dados = array(
            'filter' => $filter,
            'pagination' => $this->pagination->create_links(),
            'lista_metodo_pagamento' => $listaMetodoPagamento,
            'menu' => 'Cadastro'
        );

        $this->load->view('cadastros/metodo-pagamento', $dados);
    }
    
    public function listarCentroCusto(){      

        $config = array(
            'base_url' => base_url('centro-custo'),
            'per_page' => 10,
            'num_links' => 10,
            'uri_segment' => 2,
            'total_rows' => $this->financeiro->countAllCentroCusto(),
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

        // Busca dos dados para apresentação
        $filter = ($this->input->get('buscar')) ? $this->input->get('buscar') : "";
        $offset = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $listaCentroCusto = $this->financeiro->getCentroCusto($filter, $config["per_page"], $offset);


        $dados = array(
            'filter' => $filter,
            'pagination' => $this->pagination->create_links(),
            'lista_centro_custo' => $listaCentroCusto,
            'menu' => 'Cadastro'
        );

        $this->load->view('cadastros/centro-custo', $dados);
    }

    public function listarContaContabil(){      

        $config = array(
            'base_url' => base_url('conta-contabil'),
            'per_page' => 10,
            'num_links' => 10,
            'uri_segment' => 2,
            'total_rows' => $this->financeiro->countAllContaContabil(),
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

        // Busca dos dados para apresentação
        $filter = ($this->input->get('buscar')) ? $this->input->get('buscar') : "";
        $offset = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $listaContaContabil = $this->financeiro->getContaContabil($filter, $config["per_page"], $offset);


        $dados = array(
            'filter' => $filter,
            'pagination' => $this->pagination->create_links(),
            'lista_conta_contabil' => $listaContaContabil,
            'menu' => 'Cadastro'
        );

        $this->load->view('cadastros/conta-contabil', $dados);
    }

    public function redirecionaContasPagar(){

        $mes = date('m');
        $ano = date('Y');

        redirect(base_url("financeiro/contas-pagar/{$mes}/{$ano}"), "home", "refresh");

    }

    public function redirecionaContasReceber(){

        $mes = date('m');
        $ano = date('Y');

        redirect(base_url("financeiro/contas-receber/{$mes}/{$ano}"), "home", "refresh");

    }

    public function contasPagar(){

        $mes = $this->uri->segment(3);
        $ano = $this->uri->segment(4);

        $data = date('Y-m-01', strtotime('+1 months', strtotime(date(''.$ano.'-'.$mes.'-01'))));

        $mesAnterior = date('m', strtotime('-1 months', strtotime(date(''.$ano.'-'.$mes.'-01'))));
        $anoAnterior = date('Y', strtotime('-1 months', strtotime(date(''.$ano.'-'.$mes.'-01'))));
        $mesSeguinte = date('m', strtotime('+1 months', strtotime(date(''.$ano.'-'.$mes.'-01'))));
        $anoSeguinte = date('Y', strtotime('+1 months', strtotime(date(''.$ano.'-'.$mes.'-01'))));

        $fornecedorFiltro = $this->input->get('fornecedorFiltro'); 
        $metodoPagamentoFiltro = $this->input->get('MetodoPagamentoFiltro');
        $contaFinanceiraFiltro = $this->input->get('ContaFinanceiraFiltro');
        $centroCustoFiltro = $this->input->get('CentroCustoFiltro');
        $contaContabilFiltro = $this->input->get('ContaContabilFiltro');

        $listaContaAtiva = $this->financeiro->getContaAtiva($data);
        $listaMetodoPagamento = $this->financeiro->getMetodoPagamento();
        $listaTitulos = $this->financeiro->getContaPagarPendente($data, $fornecedorFiltro, $metodoPagamentoFiltro, $contaFinanceiraFiltro, $centroCustoFiltro, $contaContabilFiltro);
        $listaFornecedor = $this->fornecedor->getFornecedor();
        $listaCentroCusto = $this->financeiro->getCentroCusto();
        $listaContaContabil = $this->financeiro->getContaContabilAtivo();

        $dados = array(
            'pagination' => "",
            'fornecedorFiltro' => $fornecedorFiltro,
            'metodoPagamentoFiltro' => $metodoPagamentoFiltro,
            'contaFinanceiraFiltro' => $contaFinanceiraFiltro,
            'centroCustoFiltro' => $centroCustoFiltro,
            'contaContabilFiltro' => $contaContabilFiltro,
            'lista_conta' => $listaContaAtiva,
            'lista_metodo_pagamento' => $listaMetodoPagamento,
            'lista_contas_pagar' => $listaTitulos,
            'lista_fornecedor' => $listaFornecedor,
            'lista_centro_custo' => $listaCentroCusto,
            'lista_conta_contabil' => $listaContaContabil,
            'mes' => $mes,
            'ano' => $ano,
            'mes_anterior' => $mesAnterior,
            'ano_anterior' => $anoAnterior,
            'mes_seguinte' => $mesSeguinte,
            'ano_seguinte' => $anoSeguinte,
            'menu' => 'Financeiro'
        );

        $this->load->view('financeiro/contas-pagar', $dados);


    }

    public function contasReceber(){

        $mes = $this->uri->segment(3);
        $ano = $this->uri->segment(4);

        $data = date('Y-m-01', strtotime('+1 months', strtotime(date(''.$ano.'-'.$mes.'-01'))));

        $mesAnterior = date('m', strtotime('-1 months', strtotime(date(''.$ano.'-'.$mes.'-01'))));
        $anoAnterior = date('Y', strtotime('-1 months', strtotime(date(''.$ano.'-'.$mes.'-01'))));
        $mesSeguinte = date('m', strtotime('+1 months', strtotime(date(''.$ano.'-'.$mes.'-01'))));
        $anoSeguinte = date('Y', strtotime('+1 months', strtotime(date(''.$ano.'-'.$mes.'-01'))));

        $clienteFiltro = $this->input->get('ClienteFiltro'); 
        $metodoPagamentoFiltro = $this->input->get('MetodoPagamentoFiltro');
        $contaFinanceiraFiltro = $this->input->get('ContaFinanceiraFiltro');
        $centroCustoFiltro = $this->input->get('CentroCustoFiltro');
        $contaContabilFiltro = $this->input->get('ContaContabilFiltro');
        $vendedorFiltro = $this->input->get('VendedorFiltro');

        $listaContaAtiva = $this->financeiro->getContaAtiva($data);
        $listaMetodoPagamento = $this->financeiro->getMetodoPagamento();
        $listaTitulos = $this->financeiro->getContaReceberPendente($data, $clienteFiltro, $metodoPagamentoFiltro, $contaFinanceiraFiltro, $centroCustoFiltro, $contaContabilFiltro, $vendedorFiltro);
        $listaCliente = $this->cliente->getCliente();
        $listaCentroCusto = $this->financeiro->getCentroCusto();
        $listaContaContabil = $this->financeiro->getContaContabilAtivo();
        $listaVendedor = $this->vendedor->getVendedor();

        $dados = array(
            'pagination' => "",
            'clienteFiltro' => $clienteFiltro,
            'metodoPagamentoFiltro' => $metodoPagamentoFiltro,
            'contaFinanceiraFiltro' => $contaFinanceiraFiltro,
            'centroCustoFiltro' => $centroCustoFiltro,
            'contaContabilFiltro' => $contaContabilFiltro,
            'vendedorFiltro' => $vendedorFiltro,
            'lista_conta' => $listaContaAtiva,
            'lista_metodo_pagamento' => $listaMetodoPagamento,
            'lista_contas_receber' => $listaTitulos,
            'lista_cliente' => $listaCliente,
            'lista_centro_custo' => $listaCentroCusto,
            'lista_conta_contabil' => $listaContaContabil,
            'lista_vendedor' => $listaVendedor,
            'mes' => $mes,
            'ano' => $ano,
            'mes_anterior' => $mesAnterior,
            'ano_anterior' => $anoAnterior,
            'mes_seguinte' => $mesSeguinte,
            'ano_seguinte' => $anoSeguinte,
            'menu' => 'Financeiro'
        );

        $this->load->view('financeiro/contas-receber', $dados);


    }

    public function redirecionaSaldoConta(){

        $mes = date('m');
        $ano = date('Y');

        redirect(base_url("financeiro/saldo-conta/{$mes}/{$ano}"), "home", "refresh");

    }

    public function listarSaldoConta(){        
        
        $mes = $this->uri->segment(3);
        $ano = $this->uri->segment(4);
        
        $data = date('Y-m-01', strtotime('+1 months', strtotime(date(''.$ano.'-'.$mes.'-01'))));

        $mesAnterior = date('m', strtotime('-1 months', strtotime(date(''.$ano.'-'.$mes.'-01'))));
        $anoAnterior = date('Y', strtotime('-1 months', strtotime(date(''.$ano.'-'.$mes.'-01'))));
        $mesSeguinte = date('m', strtotime('+1 months', strtotime(date(''.$ano.'-'.$mes.'-01'))));
        $anoSeguinte = date('Y', strtotime('+1 months', strtotime(date(''.$ano.'-'.$mes.'-01'))));

        $config = array(
            'base_url' => base_url("financeiro/saldo-conta/{$mes}/{$ano}"),
            'per_page' => 10,
            'num_links' => 10,
            'uri_segment' => 5,
            'total_rows' => $this->financeiro->countAllConta(),
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

        // Busca dos dados para apresentação
        $filter = ($this->input->get('buscar')) ? $this->input->get('buscar') : "";
        $offset = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        $listaConta = $this->financeiro->getSaldoConta($data, $filter, $config["per_page"], $offset);


        $dados = array(
            'filter' => $filter,
            'pagination' => $this->pagination->create_links(),
            'lista_conta' => $listaConta,
            'mes' => $mes,
            'ano' => $ano,
            'data' => $data,
            'mes_anterior' => $mesAnterior,
            'ano_anterior' => $anoAnterior,
            'mes_seguinte' => $mesSeguinte,
            'ano_seguinte' => $anoSeguinte,
            'menu' => 'Financeiro'
        );

        $this->load->view('financeiro/saldo-conta', $dados);
    }

    public function movimentoConta($codConta){

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

        $listaMovimentos = $this->financeiro->getMovimentosPorConta($codConta, $dataInicio, $dataFim);
        $listaConta = $this->financeiro->getSaldoContaPorCodigo($codConta, $dataFim); 
        $listaCentroCusto = $this->financeiro->getCentroCustoAll();  
        $listaContaContabil = $this->financeiro->getContaContabilAtivo(); 
        $listaContaAtiva = $this->financeiro->getContaAtivaDestino($listaConta->cod_conta);    

        $dados = array(
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
            'conta' => $listaConta,
            'lista_titulos' => $listaMovimentos,
            'lista_centro_custo' => $listaCentroCusto,
            'lista_conta_contabil' => $listaContaContabil,
            'lista_conta' => $listaContaAtiva,
            'menu' => 'Financeiro'
        );

        $this->load->view('financeiro/movimento-conta', $dados);

    }

    //Form Validation customizadas
    public function more_zero($str)
    {
        if(floatval(str_replace(",",".",$str)) <= 0.000){
            $this->form_validation->set_message('more_zero', 'Valor de %s deve ser maior que 0');
            return false;
        }else{
            return true;
        }
    }

    public function date_check($str)
    {
        if(date("Y-m-d", strtotime(str_replace('/', '-', $str))) > date("Y-m-d")){
            $this->form_validation->set_message('date_check', '%s não pode ser superior a data de hoje');
            return false;
        }else{
            return true;
        }
    }

    //Relatórios
    public function movimentacaoConta(){
        
        $dataInicio = "";
        $dataFim = "";

        $tipoData = "";

        if($this->input->get('DataInicio') != "" && $this->input->get('DataFim') != ""){
            $dataInicio = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->get('DataInicio'))));
            $dataFim = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->get('DataFim'))));
        }

        if($this->input->get('tipoData') != ""){
            $tipoData = $this->input->get('tipoData');
        }

        if($tipoData == ""){
            $tipoData = "1";
        }

        $codContas = $this->input->get('conta'); 
        
        if($dataInicio == ""){
            $dataInicio = date('Y-m-01');
        }

        if($dataFim == ""){
            $dataFim = date('Y-m-d');
        }

        $listaConta = $this->financeiro->getContaAtivaRel();        
        $totalConta = $this->financeiro->getTotais($dataInicio, $dataFim, $codContas);
        $listaContaResumida = $this->financeiro->getContaResumida($dataInicio, $dataFim, $codContas);
        $listaMovimentoDetalhada = $this->financeiro->getMovimentosDetalhados($dataInicio, $dataFim, $codContas, $tipoData);

        $dados = array(
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
            'tipoData' => $tipoData,
            'cod_conta' => $codContas,
            'lista_conta' => $listaConta,
            'total_conta' => $totalConta,
            'lista_conta_resumida' => $listaContaResumida,
            'lista_movimento_detalhada' => $listaMovimentoDetalhada,
            'menu' => 'Financeiro'
            
        );

        $this->load->view('financeiro/movimentacao-conta', $dados);

    }

    public function resultadoContaContabil(){
        
        $dataInicio = "";
        $dataFim = "";

        if($this->input->get('DataInicio') != "" && $this->input->get('DataFim') != ""){
            $dataInicio = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->get('DataInicio'))));
            $dataFim = date("Y-m-d", strtotime(str_replace('/', '-', $this->input->get('DataFim'))));
        }

        $codContaContabil = $this->input->get('contaContabil'); 
        
        if($dataInicio == ""){
            $dataInicio = date('Y-m-01');
        }

        if($dataFim == ""){
            $dataFim = date('Y-m-d');
        }

        $listaContaContabil = $this->financeiro->getContaContabil();        
        $totalContaContabil = $this->financeiro->getTotaisContaContabil($dataInicio, $dataFim, $codContaContabil);
        $listaContaContabilResumida = $this->financeiro->getContaContabilResumida($dataInicio, $dataFim, $codContaContabil);
        $listaContaContabilResumidaDesc = $this->financeiro->getContaContabilResumidaDesc($dataInicio, $dataFim, $codContaContabil);
        $listaContaContabilDetalhada = $this->financeiro->getContaContabilDetalhados($dataInicio, $dataFim, $codContaContabil);

        $entrada = array();
        $saida = array();
        foreach($listaContaContabilResumidaDesc as $key_centro_resumida => $centro) {

            @$entrada[$centro->cod_conta_contabil] = $entrada[$centro->cod_conta_contabil] + $centro->receita;
            @$saida[$centro->cod_conta_contabil] = $saida[$centro->cod_conta_contabil] + $centro->despesa;

            if($centro->cod_conta_contabil_pai != ""){

                @$entrada[$centro->cod_conta_contabil_pai] = $entrada[$centro->cod_conta_contabil_pai] + $entrada[$centro->cod_conta_contabil];
                @$saida[$centro->cod_conta_contabil_pai] = $saida[$centro->cod_conta_contabil_pai] + $saida[$centro->cod_conta_contabil];

            }
        }

        $dados = array(
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
            'cod_conta_contabil' => $codContaContabil,
            'lista_conta_contabil' => $listaContaContabil,
            'total_conta_contabil' => $totalContaContabil,
            'lista_conta_resumida' => $listaContaContabilResumida,
            'lista_conta_detalhada' => $listaContaContabilDetalhada,
            'entrada' => $entrada,
            'saida' => $saida,
            'menu' => 'Financeiro'
            
        );

        $this->load->view('financeiro/resultado-conta-contabil', $dados);

    }

    public function visaoFinanceiro(){
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

        $listaFluxo = $this->financeiro->getLancamentoDiario($dataInicio, $dataFim);
        $listaTotais = $this->financeiro->getTotaisConta($dataInicio, $dataFim);       
        
        $listaSaldoConta = $this->financeiro->getSaldosConta($dataInicio, $dataFim);
        $listaMovimentoConta = $this->financeiro->getMovimentosConta($dataInicio, $dataFim);

        $labelContaDia = array();
        $labelDia = array();
        $labelNomMes = array();
        $labelAno = array();
        $dadosEntradaDia = array();
        $dadosSaidaDia = array();
        $totalDespesas = 0;
        $totalReceitas = 0;
        foreach($listaFluxo as $key_fluxo => $fluxo){

            $labelContaDia[] = str_replace('-', '/', date("d-m", strtotime($fluxo->data)));
            $labelDia[] = date("d", strtotime($fluxo->data));
            $labelNomMes[] = $fluxo->nome_mes;
            $labelAno[] = date("Y", strtotime($fluxo->data));            

            $dadosEntradaDia[] = $fluxo->entradas;
            $dadosSaidaDia[] = $fluxo->saidas * -1;

            $totalDespesas = $totalDespesas + $fluxo->saidas;
            $totalReceitas = $totalReceitas + $fluxo->entradas;

        }

        // Despesas e Receitas Conta Contábil
        $listaDespesasContaContabil = $this->financeiro->getDespesasContaContabil($dataInicio, $dataFim);
        $listaReceitasContaContabil = $this->financeiro->getReceitasContaContabil($dataInicio, $dataFim);

        $corDespesaContaContabil = array();
        $dadosDespesaContaContabil = array();      
        foreach($listaDespesasContaContabil as $key_despesas => $despesa){

            if($key_despesas == 0){
                $corDespesaContaContabil[] = $this->random_color("");
            }else{
                $corDespesaContaContabil[] = $this->random_color($corDespesaContaContabil[$key_despesas - 1]);
            }
                        
            $dadosDespesaContaContabil[] = ($despesa->valor_total / $totalDespesas) * 100;
        }

        $corReceitaContaContabil = array();
        $dadosReceitaContaContabil = array();      
        foreach($listaReceitasContaContabil as $key_receitas => $receita){

            if($key_receitas == 0){
                $corReceitaContaContabil[] = $this->random_color("#F47C3C");
            }else{
                $corReceitaContaContabil[] = $this->random_color($corReceitaContaContabil[$key_receitas - 1]);
            }
                        
            $dadosReceitaContaContabil[] = ($receita->valor_total / $totalReceitas) * 100;
        }

        // Saldos conta
        $labelConta = array();
        $corSaldo = array();
        $dadosSaldo = array();
        foreach($listaSaldoConta as $key_conta => $conta){

            $labelConta[] = $conta->cod_conta . " - " . $conta->nome_conta;
            $dadosSaldo[] = $conta->saldo_conta;
            
            if($conta->saldo_conta > 0){
                $corSaldo[] = "#20c997";
            }else{
                $corSaldo[] = "#d9534f";
            }
        }

        $labelContaMov = array();
        $dadosEntradaDiaMov = array();
        $dadosSaidaDiaMov = array();
        foreach($listaMovimentoConta as $key_mov_conta => $mov_conta){

            if($mov_conta->entrada_confirm > 0 || $mov_conta->saida_confirm > 0){

                $labelContaMov[] = $mov_conta->cod_conta . " - " . $mov_conta->nome_conta;          

                $dadosEntradaDiaMov[] = $mov_conta->entrada_confirm;
                $dadosSaidaDiaMov[] = $mov_conta->saida_confirm * -1;

            }

        }

        // Despesas e Receitas por Centro de Custo
        $listaDespesasCentroCusto = $this->financeiro->getDespesasCentroCusto($dataInicio, $dataFim);
        $listaReceitasCentroCusto = $this->financeiro->getReceitasCentroCusto($dataInicio, $dataFim);

        $corDespesaCentroCusto = array();
        $dadosDespesaCentroCusto = array();      
        foreach($listaDespesasCentroCusto as $key_despesas => $despesa){

            if($key_despesas == 0){
                $corDespesaCentroCusto[] = $this->random_color("");
            }else{
                $corDespesaCentroCusto[] = $this->random_color($corDespesaCentroCusto[$key_despesas - 1]);
            }
                        
            $dadosDespesaCentroCusto[] = ($despesa->valor_total / $totalDespesas) * 100;
        }

        $corReceitaCentroCusto = array();
        $dadosReceitaCentroCusto = array();      
        foreach($listaReceitasCentroCusto as $key_receitas => $receita){

            if($key_receitas == 0){
                $corReceitaCentroCusto[] = $this->random_color("#F47C3C");
            }else{
                $corReceitaCentroCusto[] = $this->random_color($corReceitaCentroCusto[$key_receitas - 1]);
            }
                        
            $dadosReceitaCentroCusto[] = ($receita->valor_total / $totalReceitas) * 100;
        }

        $dados = array(
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,

            'totais' => $listaTotais,

            'dia' => $labelContaDia,
            'entradas' => $dadosEntradaDia,
            'saidas' => $dadosSaidaDia,  
            'dia_nome' => $labelDia, 
            'nome_mes' => $labelNomMes,
            'ano' => $labelAno, 
            
            'total_despesa' => $totalDespesas,
            'total_receita' => $totalReceitas,
            
            'despesa_conta_contabil' => $listaDespesasContaContabil,            
            'cor_despesa_conta_contabil' => $corDespesaContaContabil,
            'dados_despesa_conta_contabil' => $dadosDespesaContaContabil,

            'receita_conta_contabil' => $listaReceitasContaContabil,            
            'cor_receita_conta_contabil' => $corReceitaContaContabil,
            'dados_receita_conta_contabil' => $dadosReceitaContaContabil,

            'despesa_centro_custo' => $listaDespesasCentroCusto,            
            'cor_despesa_centro_custo' => $corDespesaCentroCusto,
            'dados_despesa_centro_custo' => $dadosDespesaCentroCusto,

            'receita_centro_custo' => $listaReceitasCentroCusto,            
            'cor_receita_centro_custo' => $corReceitaCentroCusto,
            'dados_receita_centro_custo' => $dadosReceitaCentroCusto,

            'cor_saldo' => $corSaldo,
            'label_conta' => $labelConta,
            'dados_saldo' => $dadosSaldo,

            'label_conta_mov' => $labelContaMov,
            'dados_entrada_mov' => $dadosEntradaDiaMov,
            'dados_saida_mov' => $dadosSaidaDiaMov,
            
            'menu' => 'Financeiro'
        );

        $this->load->view('financeiro/indicadores-financeiro', $dados);

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