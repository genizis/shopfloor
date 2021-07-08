<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ClienteController extends CI_Controller {

    function __construct(){
        parent::__construct();

        if(usuarioLogado() == false){

            redirect(base_url("login"), "home", "refresh");

        }
    }

    public function formCliente(){

        $listaSegmento = $this->tabelasauxiliares->getSegmento();
        $listaCidade = $this->tabelasauxiliares->getCidade();
        $listaEstado = $this->tabelasauxiliares->getEstado();       

        $dados = array(
            'lista_segmento' => $listaSegmento,
            'lista_cidade' => $listaCidade,
            'lista_estado' => $listaEstado,
            'menu' => 'Cadastro'
        );

        $this->load->view('cadastros/novo-cliente', $dados);

    }   
    
    public function editarCliente($CodCliente){

        $listaCliente = $this->cliente->getClientePorCodigo($CodCliente);
        $listaSegmento = $this->tabelasauxiliares->getSegmento();
        $listaCidade = $this->tabelasauxiliares->getCidade();  
        
        if($listaCliente == null){
            redirect(base_url('cliente'));
            
        }else{ 
            $dados = array(
                'cliente' => $listaCliente,
                'lista_segmento' => $listaSegmento,
                'lista_cidade' => $listaCidade,
                'menu' => 'Cadastro'
            );
        }

        $this->load->view('cadastros/editar-cliente', $dados);

    }

    public function listaImportaCliente(){ 
        
        if(1 == null){
            redirect(base_url('cliente'));
            
        }else{ 
            $dados = array(
                'lista_cliente' => null,
                'menu' => 'Cadastro'
            );
        }

        $this->load->view('cadastros/importar-cliente', $dados);

    }

    public function importarCliente(){

        if(pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION) == "csv"){

            $this->importaCSV();

        }elseif(pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION) == "xlsx"){

            $this->importaXLS();

        }else{

            $this->session->set_flashdata('erro', 'Formato de arquivo desconhecido');

            $listaCliente = null;
            $dados = array(
                'lista_cliente' => $listaCliente,
                'menu' => 'Cadastro'
            );

            $this->load->view('cadastros/importar-cliente', $dados);

        }        
    }

    public function importaCSV(){

        $listaCliente = null;
        $numrow = 0;
        if (($handle = fopen($_FILES['arquivo']['tmp_name'], "r")) != false) {
            while (($row = fgetcsv($handle, 1000, ";")) != false) {
                //$row = iconv('UTF-8', 'ISO-8859-1', $row);
                //$row = array_map("utf8_encode", $row); //added

                $numrow++;
                if($this->input->post('cabecalho') == '1' && $numrow == 1){
                    continue;
                }
                
                
                $codCliente = null;

                if(strlen($row[0]) == 14 || strlen($row[0]) == 18 || strlen($row[0]) == 0){                    

                    if($row[0] != 0){                            
                        $cliente = $this->cliente->getClientePorDocumento($row[0]);
                    }else{
                        $cliente = $this->cliente->getClientePorNome($row[1]);
                    }

                    if($cliente != null){
                        $codCliente = $cliente->cod_cliente;
                        $resultado = 3;
                        $descResultado = "<strong>Não possível importar</strong><br>
                                        Cliente já cadastrado na base dados";
                    }elseif($row[1] == ""){
                        $resultado = 3;
                        $descResultado = "<strong>Não possível importar</strong><br>
                                        Cliente sem nome definido";
                    }else{

                        $resultado = 1;
                        $descResultado = "<strong>Importado com sucesso</strong>";

                        if(strlen($row[0]) == 14){
                            $tipoPessoa = 2;
                        }else{
                            $tipoPessoa = 1;
                        }

                        //Busca código segmento
                        $codSegmento = 0;
                        if(@$row[2] != ""){
                            $segmento = $this->tabelasauxiliares->getSegmentoPorNome($row[2]);
                            if($segmento != null){
                                $codSegmento = $segmento->cod_segmento;
                            }else{
                                $row[2] = "";
                                $resultado = 2;
                                $descResultado = "<strong>Importação realizada, porém, incompleta</strong>";
                            }
                        }

                        //Valida CEP
                        if($row[7] != "" && strlen($row[7]) != 9){
                            $row[7] = "";
                            $resultado = 2;
                            $descResultado = "<strong>Importação realizada, porém, incompleta</strong>";
                        }

                        //Busca código cidade
                        $codCidade = null;
                        if(@$row[12] != "" || @$row[13] != ""){
                            $cidade = $this->tabelasauxiliares->getCidadePorNome($row[12], $row[13]);
                            if($cidade != null){
                                $codCidade = $cidade->id;
                            }else{
                                $row[12] = "";
                                $row[13] = "";
                                $resultado = 2;
                                $descResultado = "<strong>Importação realizada, porém, incompleta</strong>";
                            }
                        }

                        $data = [
                            'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                            'nome_cliente'  => $row[1],
                            'raao_social' => $row[2],
                            'tipo_pessoa' => $tipoPessoa,
                            'cnpj_cpf' => $row[0],
                            'cod_segmento' => $codSegmento,
                            'tel_fixo' => @$row[4],
                            'tel_cel' => @$row[5],
                            'email' => @$row[6],
                            'cep' => @$row[7],
                            'endereco' => @$row[8],
                            'numero' => @$row[9],
                            'complemento' => @$row[10],
                            'bairro' => @$row[11],
                            'cod_cidade' => $codCidade
                        ];
            
                        $codCliente = $this->cliente->insertCliente($data);                        
                    }                       

                }else{
                    $resultado = 3;
                    $descResultado = "<strong>Não possível importar</strong><br>
                                      CNPJ ou CPF fora do padrão esperado";
                }

                $listaCliente[] = (object)[
                    'cod_cliente' => $codCliente,
                    'cnpj_cpf' => $row[0],
                    'nome_cliente' => $row[1],
                    'razao_social' => $row[2],
                    'nome_segmento' => @$row[3],
                    'tel_fixo' => @$row[4],
                    'tel_cel' => @$row[5],
                    'email' => @$row[6],
                    'cep' => @$row[7],
                    'endereco' => @$row[8],
                    'numero' => @$row[9],
                    'complemento' => @$row[10],
                    'bairro' => @$row[11],                        
                    'cidade' => @$row[12],
                    'estado' => @$row[13],
                    'resultado' => $resultado,
                    'desc_resultado' => $descResultado
                ];
            }

            fclose($handle);

            $this->session->set_flashdata('sucesso', 'Importação finalizada');
        }

        $dados = array(
            'lista_cliente' => $listaCliente,
            'menu' => 'Cadastro'
        );

        $this->load->view('cadastros/importar-cliente', $dados);

    }

    public function importaXLS(){

        $this->load->library('SimpleXLSX');

        $listaCliente = null;
        if(!empty($_FILES['arquivo']['tmp_name'])){

            if ( $xlsx = SimpleXLSX::parse($_FILES['arquivo']['tmp_name']) ) {
                foreach ($xlsx->rows() as $r => $row) {
                    
                    if($this->input->post('cabecalho') == '1' && $r == 0){
                        continue;
                    } 
                    
                    $codCliente = null;

                    if(strlen($row[0]) == 14 || strlen($row[0]) == 18 || strlen($row[0]) == 0){

                        if($row[0] != 0){                            
                            $cliente = $this->cliente->getClientePorDocumento($row[0]);
                        }else{
                            $cliente = $this->cliente->getClientePorNome($row[1]);
                        }
                        
                        if($cliente != null){
                            $codCliente = $cliente->cod_cliente;
                            $resultado = 3;
                            $descResultado = "<strong>Não possível importar</strong><br>
                                            Cliente já cadastrado na base dados";
                        }elseif($row[1] == ""){
                            $resultado = 3;
                            $descResultado = "<strong>Não possível importar</strong><br>
                                            Cliente sem nome definido";
                        }else{

                            $resultado = 1;
                            $descResultado = "<strong>Importado com sucesso</strong>";

                            //Tipo pessoa (Física ou Jurídica)
                            if(strlen($row[0]) == 14){
                                $tipoPessoa = 2;
                            }else{
                                $tipoPessoa = 1;
                            }

                            //Busca código segmento
                            $codSegmento = 0;
                            if(@$row[3] != ""){
                                $segmento = $this->tabelasauxiliares->getSegmentoPorNome($row[2]);
                                if($segmento != null){
                                    $codSegmento = $segmento->cod_segmento;
                                }else{
                                    $row[3] = "";
                                    $resultado = 2;
                                    $descResultado = "<strong>Importação realizada, porém, incompleta</strong>";
                                }
                            }

                            //Valida CEP
                            if($row[7] != "" && strlen($row[7]) != 9){
                                $row[7] = "";
                                $resultado = 2;
                                $descResultado = "<strong>Importação realizada, porém, incompleta</strong>";
                            }

                            //Busca código cidade
                            $codCidade = null;
                            if(@$row[12] != "" || @$row[13] != ""){
                                $cidade = $this->tabelasauxiliares->getCidadePorNome($row[12], $row[13]);
                                if($cidade != null){
                                    $codCidade = $cidade->id;
                                }else{
                                    $row[12] = "";
                                    $row[13] = "";
                                    $resultado = 2;
                                    $descResultado = "<strong>Importação realizada, porém, incompleta</strong>";
                                }
                            }

                            $data = [
                                'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                                'nome_cliente'  => $row[1],
                                'razao_social' => $row[2],
                                'tipo_pessoa' => $tipoPessoa,
                                'cnpj_cpf' => $row[0],
                                'cod_segmento' => $codSegmento,
                                'tel_fixo' => @$row[4],
                                'tel_cel' => @$row[5],
                                'email' => @$row[6],
                                'cep' => @$row[7],
                                'endereco' => @$row[8],
                                'numero' => @$row[9],
                                'complemento' => @$row[10],
                                'bairro' => @$row[11],
                                'cod_cidade' => $codCidade
                            ];
                
                            $codCliente = $this->cliente->insertCliente($data);                        
                        }                       

                    }else{
                        $resultado = 3;
                        $descResultado = "<strong>Não possível importar</strong><br>
                                          CNPJ ou CPF fora do padrão esperado";
                    }

                    $listaCliente[] = (object)[
                        'cod_cliente' => $codCliente,
                        'cnpj_cpf' => $row[0],
                        'nome_cliente' => $row[1],
                        'razao_social' => $row[2],
                        'nome_segmento' => @$row[3],
                        'tel_fixo' => @$row[4],
                        'tel_cel' => @$row[5],
                        'email' => @$row[6],
                        'cep' => @$row[7],
                        'endereco' => @$row[8],
                        'numero' => @$row[9],
                        'complemento' => @$row[10],
                        'bairro' => @$row[11],                        
                        'cidade' => @$row[12],
                        'estado' => @$row[13],
                        'resultado' => $resultado,
                        'desc_resultado' => $descResultado
                    ];

                }

                $this->session->set_flashdata('sucesso', 'Importação finalizada');

            } else {

                $this->session->set_flashdata('erro', SimpleXLSX::parseError());
            }            
        }

        $dados = array(
            'lista_cliente' => $listaCliente,
            'menu' => 'Cadastro'
        );

        $this->load->view('cadastros/importar-cliente', $dados);
    }

    public function inserirCliente(){  

        //Validações dos campo e array das mensagens apresentadas
        $this->form_validation->set_rules('NomeCliente', 'Nome do Cliente', 'required|max_length[60]',
            array('required' => 'Você deve preencher o campo %s',
                  'max_length' => 'O campo %s não deve ter mais que 60 caracteres'));
        $this->form_validation->set_rules('Email', 'E-mail', 'valid_email|max_length[60]', 
            array('max_length' => 'O campo %s não deve ter mais que 60 caracteres',
                  'valid_email' => 'É necessário informar um e-mail válido'));
        $this->form_validation->set_rules('Endereco', 'Rua e Número', 'max_length[60]', 
            array('max_length' => 'O campo %s não deve ter mais que 60 caracteres'));
        $this->form_validation->set_rules('Bairro', 'Bairro', 'max_length[45]', 
            array('max_length' => 'O campo %s não deve ter mais que 45 caracteres'));

        if($this->input->post('TipoPessoa') == "1" && $this->input->post('CnpjCpf') != ""){
            $this->form_validation->set_rules('CnpjCpf', 'CNPJ', 'min_length[18]', 
                array('min_length' => 'O campo %s não está completo'));
        }elseif($this->input->post('TipoPessoa') == "2" && $this->input->post('CnpjCpf') != ""){
            $this->form_validation->set_rules('CnpjCpf', 'CPF', 'min_length[14]', 
                array('min_length' => 'O campo %s não está completo'));
        }

        if($this->input->post('CEP') != ""){
            $this->form_validation->set_rules('CEP', 'CEP', 'min_length[9]', 
                array('min_length' => 'O campo %s não está completo'));            
        }

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            $this->formCliente();
            
        }else {

            $data = [
                'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                'nome_cliente'  => $this->input->post('NomeCliente'),
                'razao_social'  => $this->input->post('RazaoSocial'),
                'tipo_pessoa' => $this->input->post('TipoPessoa'),
                'cnpj_cpf' => $this->input->post('CnpjCpf'),
                'cod_segmento' => $this->input->post('Segmento'),
                'tipo_contrib_icms' => $this->input->post('ContribuinteICMS'),
                'insc_estadual' => $this->input->post('IE'),
                'insc_municipal' => $this->input->post('IM'),
                'tel_fixo' => $this->input->post('TelFixo'),
                'tel_cel' => $this->input->post('TelCel'),
                'email' => $this->input->post('Email'),
                'cep' => $this->input->post('CEP'),
                'endereco' => $this->input->post('Endereco'),
                'numero' => $this->input->post('Numero'),
                'complemento' => $this->input->post('Complemento'),
                'bairro' => $this->input->post('Bairro'),
                'cod_cidade' => $this->input->post('Cidade')
            ];
            $codCliente = $this->cliente->insertCliente($data);

            //Se optar por salvar e continuar, mantém na página de cadastro
            if ($this->input->post('Opcao') == 'salvarContinuar'){

                $this->session->set_flashdata('sucesso', 'Cliente cadastrado com sucesso');
                redirect(base_url('cliente/novo-cliente'));


            }else {

                $this->session->set_flashdata('sucesso', 'Cliente cadastrado com sucesso');
                redirect(base_url('cliente'));
            }            
        }        
    }   

    public function salvarCliente($codCliente){

        //Validações dos campo e array das mensagens apresentadas
        $this->form_validation->set_rules('NomeCliente', 'Nome do Cliente', 'required|max_length[60]',
            array('required' => 'Você deve preencher o campo %s',
                  'max_length' => 'O campo %s não deve ter mais que 60 caracteres'));
        $this->form_validation->set_rules('Email', 'E-mail', 'valid_email|max_length[60]', 
            array('max_length' => 'O campo %s não deve ter mais que 60 caracteres',
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

        if($this->input->post('CEP') != ""){
            $this->form_validation->set_rules('CEP', 'CEP', 'min_length[9]', 
                array('min_length' => 'O campo %s não está completo'));            
        }

        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());
            $this->editarCliente($codCliente);
            
        }else {

            $dados = [
                'nome_cliente'  => $this->input->post('NomeCliente'),
                'razao_social'  => $this->input->post('RazaoSocial'),
                'tipo_pessoa' => $this->input->post('TipoPessoa'),
                'cnpj_cpf' => $this->input->post('CnpjCpf'),
                'cod_segmento' => $this->input->post('Segmento'),
                'tipo_contrib_icms' => $this->input->post('ContribuinteICMS'),
                'insc_estadual' => $this->input->post('IE'),
                'insc_municipal' => $this->input->post('IM'),
                'tel_fixo' => $this->input->post('TelFixo'),
                'tel_cel' => $this->input->post('TelCel'),
                'email' => $this->input->post('Email'),
                'cep' => $this->input->post('CEP'),
                'endereco' => $this->input->post('Endereco'),
                'numero' => $this->input->post('Numero'),
                'complemento' => $this->input->post('Complemento'),
                'bairro' => $this->input->post('Bairro'),
                'cod_cidade' => $this->input->post('Cidade')
            ];            

            $this->cliente->updateCliente($codCliente, $dados); 
            $this->session->set_flashdata('sucesso', 'Cliente alterado com sucesso');
            
            redirect(base_url('cliente'));           
        }
    }

    public function excluirCliente(){

        $CodCliente = $this->input->post("excluir_todos");
        $numRegs = count($CodCliente);

        if($numRegs > 0){

            $erro = $this->cliente->deleteCliente($CodCliente);

            //Code 1451 - Não é permitido exluir registro sendo usado por outro registro
            if ($erro['code'] == 1451){
                $this->session->set_flashdata('erro', 'Exclusão não permitida. Registro em uso por outro cadastro');
            }else{
                $this->session->set_flashdata('sucesso', 'Registro(s) selecionado(s) excluído(s)');
            } 

        }else {
            $this->session->set_flashdata('erro', 'Nenhum registro foi selecionado');
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
        $empresa = $this->empresa->getEmpresaPorCodigo(getDadosUsuarioLogado()['id_empresa']);

        $dados = array(
            'pagination' => $this->pagination->create_links(),
            'empresa' => $empresa,
            'lista_cliente' => $listaCliente,
            'menu' => 'Cadastro'
        );

        $this->load->view('cadastros/cliente', $dados);
    }           
}