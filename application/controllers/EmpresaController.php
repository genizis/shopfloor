<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmpresaController extends CI_Controller {

    function __construct(){
        parent::__construct();

        if(usuarioLogado() == false){

            redirect(base_url("login"), "home", "refresh");

        }
    }  

    public function formNaturezaOperacao(){

        $dados = array(
            'menu' => 'Admin'
        );

        $this->load->view('cadastros/nova-natureza-operacao', $dados);

    }

    public function editarMeusDados(){

        $listaUsuario = $this->usuario->getUsuarioPorCodigo(getDadosUsuarioLogado()['email']); 
        
        if($listaUsuario == null){
            redirect(base_url('visao-geral'));
            
        }else{ 
            $dados = array(
                'usuario' => $listaUsuario,
                'menu' => 'Admin'
            );
        }

        $this->load->view('cadastros/meus-dados', $dados);

    }

    public function salvarMeusDados(){

        $this->form_validation->set_rules('NomeUsuario', 'Nome do Usuário', 'required|max_length[100]',
            array('required' => 'Você deve preencher o campo %s',
                  'max_length' => 'O campo %s não deve ter mais que 100 caracteres')); 

        if($this->input->post('Senha1') <> '' || $this->input->post('Senha1') <> ''){
            $this->form_validation->set_rules('Senha1', 'Senha', 'required',
                array('required' => 'Você deve preencher o campo %s'));
            $this->form_validation->set_rules('Senha2', 'Confirma a Senha', 'required|callback_valida_senha',
                array('required' => 'Você deve preencher o campo %s'));
        }

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            $this->editarMeusDados($this->input->post('Email'));
            
        }else {

            if($this->input->post('Senha1') <> ''){

                $data = [
                    'nome_usuario' => $this->input->post('NomeUsuario'),
                    'senha' => sha1($this->input->post('Senha1')),            
                ];

            }else{

                $data = [
                    'nome_usuario' => $this->input->post('NomeUsuario'),              
                ];

            }            

            $this->usuario->updateUsuario($this->input->post('Email'), $data);

            $this->session->set_flashdata('sucesso', 'Usuário atualizado com sucesso');
            redirect(base_url('meus-dados'));          
        } 
    }

    public function solicitaConexaoContaAzul(){        

        $redirectURI = "https://www.shopfloor.com.br/conta-azul-integration";
        $clientID = "rbOhYqzxUWhe7uXT58ZastCUeEDwPWbs";
        $state = "FSdsfa3435afsfasg33";

        redirect("https://api.contaazul.com/auth/authorize?redirect_uri={$redirectURI}&client_id={$clientID}&scope=sales&state={$state}");

    }

    public function callbackContaAzul(){

        $code = $this->input->get('code');
        $state = $this->input->get('state');  

        redirect(base_url("conecta-conta-azul/{$code}/{$state}"), 'home', 'refresh');

    }

    public function conectaContaAzul(){
        $code = $this->uri->segment(2);
        $state = $this->uri->segment(3); 

        $Cod = $this->contaazul->conectaContaAzul($code, $state);

        if(is_null($Cod)){

            $this->session->set_flashdata('erro', 'Erro ao conectar Conta Azul');
            redirect(base_url('dados-empresa'), 'home', 'refresh');

        }else{

            $this->session->set_flashdata('sucesso', 'Conta Azul conectada com sucesso');
            redirect(base_url('dados-empresa'), "home", "refresh");

        } 
        
    }

    public function retiraNotificacaoContaAzul(){

        $dados = [
            'aviso_ca' => 1
        ];        

        $this->empresa->updateEmpresa(getDadosUsuarioLogado()['id_empresa'], $dados);
        redirect(base_url(), 'home', 'refresh');

    }
    
    public function editarEmpresa(){

        $listaEmpresa = $this->empresa->getEmpresaPorCodigo(getDadosUsuarioLogado()['id_empresa']);
        $listaCidade = $this->tabelasauxiliares->getCidade();
        $listaConta = $this->financeiro->getConta(); 
        $listaCentroCusto = $this->financeiro->getCentroCustoAtivo(); 
        $listaContaContabil = $this->financeiro->getContaContabilAtivo();
        $listaMetodoPagamento = $this->financeiro->getMetodoPagamento();
        
        if($listaEmpresa == null){
            redirect(base_url('visao-geral'));
            
        }else{ 
            $dados = array(
                'empresa' => $listaEmpresa,
                'lista_cidade' => $listaCidade,
                'lista_conta' => $listaConta,
                'lista_centro_custo' => $listaCentroCusto, 
                'lista_conta_contabil' => $listaContaContabil,
                'lista_metodo_pagamento' => $listaMetodoPagamento,
                'menu' => ''
            );
        }

        $this->load->view('cadastros/dados-empresa', $dados);

    }

    public function salvarEmpresa(){

        //Validações dos campo e array das mensagens apresentadas
        $this->form_validation->set_rules('NomeEmpresa', 'Nome da Empresa', 'required|max_length[60]',
            array('required' => 'Você deve preencher o campo %s',
                  'max_length' => 'O campo %s não deve ter mais que 60 caracteres'));
        $this->form_validation->set_rules('EmailContato', 'E-mail de Contato', 'required|valid_email|max_length[60]', 
            array('required' => 'Você deve preencher o campo %s',
                  'max_length' => 'O campo %s não deve ter mais que 60 caracteres',
                  'valid_email' => 'É necessário informar um e-mail válido'));
        $this->form_validation->set_rules('Endereco', 'Rua e Número', 'max_length[60]', 
            array('max_length' => 'O campo %s não deve ter mais que 60 caracteres'));
        $this->form_validation->set_rules('Bairro', 'Bairro', 'max_length[45]', 
            array('max_length' => 'O campo %s não deve ter mais que 45 caracteres'));        
        
        //Valida número de caracteres conforme tipo de pessoa
        if($this->input->post('TipoPessoa') == "1" && $this->input->post('CnpjCpf') != ""){
            $this->form_validation->set_rules('CnpjCpf', 'CNPJ', 'min_length[18]', 
                array('min_length' => 'O campo %s não está completo'));
        }elseif($this->input->post('TipoPessoa') == "2" && $this->input->post('CnpjCpf') != ""){
            $this->form_validation->set_rules('CnpjCpf', 'CPF', 'min_length[14]', 
                array('min_length' => 'O campo %s não está completo'));
        }

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            redirect(base_url('dados-empresa'), 'home', 'refresh');
            
        }else {

            $dados = [
                'razao_social'  => $this->input->post('RazaoSocial'),
                'nome_empresa'  => $this->input->post('NomeEmpresa'),
                'tipo_empresa' => $this->input->post('TipoPessoa'),
                'cnpj_cpf' => $this->input->post('CnpjCpf'),
                'tel_fixo' => $this->input->post('TelFixo'),
                'tel_cel' => $this->input->post('TelCel'),
                'email_contato' => $this->input->post('EmailContato'),
                'cep' => $this->input->post('CEP'),
                'endereco' => $this->input->post('Endereco'),
                'numero' => $this->input->post('Numero'),
                'complemento' => $this->input->post('Complemento'),
                'bairro' => $this->input->post('Bairro'),
                'cod_cidade' => $this->input->post('Cidade'),
                'conta_padrao' => $this->input->post('CodConta'),
                'metodo_pagamento_frente_caixa' => $this->input->post('MetodoPagamentoFrenteCaixa'),
                'centro_custo_frente_caixa' => $this->input->post('CentroCustoFrenteCaixa'),
                'conta_contabil_frente_caixa' => $this->input->post('ContaContabilFrenteCaixa'),
                'centro_custo_vendas' => $this->input->post('CentroCustoVendas'),
                'conta_contabil_vendas' => $this->input->post('ContaContabilVendas'),
                'centro_custo_compras' => $this->input->post('CentroCustoCompras'),    
                'conta_contabil_compras' => $this->input->post('ContaContabilCompras'),            
                'insc_estadual' => $this->input->post('InscEstadual'),
                'isenta_ie' => ($this->input->post('Isenta')) ? $this->input->post('Isenta') : 0,
                'versao_nfe' => $this->input->post('Versao'),
                'ambiente_nfe' => $this->input->post('AmbienteNFe'),
                'serie' => $this->input->post('Serie'),
                'num_ultima_nf' => $this->input->post('NumUltNF'),
                'integ_vendas_externas' => ($this->input->post('VendasExternas')) ? $this->input->post('VendasExternas') : 0,
                'integ_usuario_vendas_externas' => $this->input->post('UsuarioVendasExternas'),
                'integ_senha_vendas_externas' => $this->input->post('SenhaVendasExternas'),
                'cred_devol_vendas_externas' => $this->input->post('CreditoDevolucao'),
            ];

            if($_FILES['certificado']['name'] != ""){
                $dados = $dados + [
                    'caminho_certificado' => ($_FILES['certificado']['name']) ? $_FILES['certificado']['name'] : null,
                ];
            }

            if($this->input->post('SenhaCertificado') != ""){
                $dados = $dados + [
                    'senha_certificado' => $this->input->post('SenhaCertificado') ? sha1($this->input->post('SenhaCertificado')) : null,
                ];
            }

            $this->empresa->updateEmpresa(getDadosUsuarioLogado()['id_empresa'], $dados);

            if(!is_dir("clientes/" . getDadosUsuarioLogado()['id_empresa'])){

                mkdir("clientes/" . getDadosUsuarioLogado()['id_empresa'], 0755);                
            }
            if(!is_dir("clientes/" . getDadosUsuarioLogado()['id_empresa'] . "/xmls")){

                mkdir("clientes/" . getDadosUsuarioLogado()['id_empresa'] . "/xmls", 0755);                
            }
            
            if(!is_dir("clientes/" . getDadosUsuarioLogado()['id_empresa'] . "/certificado")){

                mkdir("clientes/" . getDadosUsuarioLogado()['id_empresa'] . "/certificado", 0755);                
            }

            if($_FILES['certificado']['name'] != ""){

                $uploaddir = "clientes/" . getDadosUsuarioLogado()['id_empresa'] . "/certificado/";
                $uploadfile = $uploaddir . basename($_FILES['certificado']['name']);

                move_uploaded_file($_FILES['certificado']['tmp_name'], $uploadfile);

            }

            $this->session->set_flashdata('sucesso', 'Dados da empresa alterados com sucesso');
            redirect(base_url('dados-empresa'), 'home', 'refresh');           
        }
    }

    public function excluirCliente()
    {

        $CodCliente = $this->input->post("excluir_todos");
        $numRegs = count($CodCliente);

        if($numRegs > 0){

            $erro = $this->cliente->deleteCliente($CodCliente);

            //Code 1451 - Não é permitido exluir registro sendo usado por outro registro
            if ($erro['code'] == 1451){
                $this->session->set_flashdata('cliente_erro', 'Exclusão não permitida. Registro em uso por outro cadastro');
            }else{
                $this->session->set_flashdata('cliente_sucesso', 'Registro(s) selecionado(s) excluído(s)');
            } 

        }else {
            $this->session->set_flashdata('cliente_erro', 'Nenhum registro foi selecionado');
        }

        redirect(base_url('cliente'));
    } 

    public function listarCliente(){    

        $config = array(
            'base_url' => base_url('cliente'),
            'per_page' => 10,
            'num_links' => 10,
            'uri_segment' => 2,
            'total_rows' => $this->cliente->countAll(),
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
        $listaCliente = $this->cliente->getCliente($filter, $config["per_page"], $offset);


        $dados = array(
            'pagination' => $this->pagination->create_links(),
            'lista_cliente' => $listaCliente,
            'menu' => ''
        );

        $this->load->view('cadastros/cliente', $dados);
    }
    
    //Form Validation customizadas
    public function valida_senha($str)
    {
        if($this->input->post('Senha1') != $str){
            $this->form_validation->set_message('valida_senha', 'Senhas informadas são diferentes');
            return false;
        }else{
            return true;
        }
    }
}