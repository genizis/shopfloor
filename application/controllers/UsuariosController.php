<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UsuariosController extends CI_Controller {

    function __construct(){
        parent::__construct();

        if(usuarioLogado() == false){

            redirect(base_url("login"), "home", "refresh");

        }

        if(getDadosUsuarioLogado()['tipo_acesso'] != 1){

            redirect(base_url("visao-geral"), "home", "refresh");

        }
    }

    public function formUsuario(){ 

        $empresa = $this->empresa->getParametrosEmpresa(getDadosUsuarioLogado()['id_empresa']);
        if($empresa->num_usuario >= $empresa->quant_usuarios){
            redirect(base_url("usuario"), "home", "refresh");
        }

        $dados = array(
            'menu' => 'Admin'
        );

        $this->load->view('cadastros/novo-usuario', $dados);

    } 

    public function editarUsuario($email){

        $listaUsuario = $this->usuario->getUsuarioPorCodigo($email); 
        
        if($listaUsuario == null){
            redirect(base_url('usuario'));
            
        }else{ 
            $dados = array(
                'usuario' => $listaUsuario,
                'menu' => 'Admin'
            );
        }

        $this->load->view('cadastros/editar-usuario', $dados);

    }

    public function inserirUsuario(){  

        $this->form_validation->set_rules('Email', 'Usuário', 'required|max_length[60]|valid_email|is_unique[usuario.email]',
            array('required' => 'Você deve preencher o campo %s',
                'max_length' => 'O campo %s não deve ter mais que 60 caracteres',
                'valid_email' => 'Você deve informar um e-mail válido',
                'is_unique' => 'Já existe outro usuário com o %s informado'));
        $this->form_validation->set_rules('NomeUsuario', 'Nome do Usuário', 'required|max_length[100]',
            array('required' => 'Você deve preencher o campo %s',
                  'max_length' => 'O campo %s não deve ter mais que 100 caracteres'));  
        $this->form_validation->set_rules('Senha1', 'Senha', 'required',
            array('required' => 'Você deve preencher o campo >%s'));
        $this->form_validation->set_rules('Senha2', 'Confirma a Senha', 'required|callback_valida_senha',
            array('required' => 'Você deve preencher o campo %s'));

        //Valida se as senhas informadas estão iguais
        if($this->input->post('Senha') <> $this->input->post('RepeteSenha')){
            $this->session->set_flashdata('erro', 'Senhas digitadas não coincidem');
            redirect(base_url('usuarios/novo-usuario'));

        } 


        if($this->form_validation->run() == false){

            $this->session->set_flashdata('erro', validation_errors());            
            $this->formUsuario();
            
        }else {

            $data = [
                'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                'email'  => $this->input->post('Email'),
                'nome_usuario' => $this->input->post('NomeUsuario'),
                'tipo_acesso' => $this->input->post('TipoAcesso'),
                'ativo' => $this->input->post('Ativo'),  
                'senha' => sha1($this->input->post('Senha1')),
                'producao' => $this->input->post('Producao'),
                'vendas' => $this->input->post('Vendas'),
                'compras' => $this->input->post('Compras'),
                'estoque' => $this->input->post('Estoque'),
                'financeiro' => $this->input->post('Financeiro'),
            ];

            $this->usuario->insertUsuario($data);

            //Se optar por salvar e continuar, mantém na página de cadastro
            if ($this->input->post('Opcao') == 'salvarContinuar'){

                $this->session->set_flashdata('sucesso', 'Usuário cadastrado com sucesso');
                redirect(base_url('usuario/novo-usuario'));


            }else {

                $this->session->set_flashdata('sucesso', 'Usuário cadastrado com sucesso');
                redirect(base_url('usuario'));
            }            
        }        
    }

    public function salvarUsuario($Email){

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
            $this->editarUsuario($Email);
            
        }else {

            if($this->input->post('Senha1') <> ''){

                $data = [
                    'nome_usuario' => $this->input->post('NomeUsuario'),
                    'senha' => sha1($this->input->post('Senha1')),
                    'tipo_acesso' => $this->input->post('TipoAcesso'),
                    'ativo' => $this->input->post('Ativo'),  
                    'producao' => $this->input->post('Producao'),
                    'vendas' => $this->input->post('Vendas'),
                    'compras' => $this->input->post('Compras'),
                    'estoque' => $this->input->post('Estoque'),
                    'financeiro' => $this->input->post('Financeiro'),              
                ];

            }else{

                $data = [
                    'nome_usuario' => $this->input->post('NomeUsuario'),
                    'tipo_acesso' => $this->input->post('TipoAcesso'),
                    'ativo' => $this->input->post('Ativo'),   
                    'producao' => $this->input->post('Producao'),
                    'vendas' => $this->input->post('Vendas'),
                    'compras' => $this->input->post('Compras'),
                    'estoque' => $this->input->post('Estoque'),
                    'financeiro' => $this->input->post('Financeiro'),                
                ];

            }            

            $this->usuario->updateUsuario($Email, $data);

            $this->session->set_flashdata('sucesso', 'Usuário atualizado com sucesso');
            redirect(base_url('usuario'));          
        } 
    }

    public function listarUsuario(){     

        $config = array(
            'base_url' => base_url('usuario'),
            'per_page' => 10,
            'num_links' => 10,
            'uri_segment' => 2,
            'total_rows' => $this->usuario->countAll(),
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
        $listaUsuario = $this->usuario->getUsuarios($filter, $config["per_page"], $offset);
        $empresa = $this->empresa->getParametrosEmpresa(getDadosUsuarioLogado()['id_empresa']);

        $dados = array(
            'pagination' => $this->pagination->create_links(),
            'lista_usuario' => $listaUsuario,
            'empresa' => $empresa,
            'menu' => 'Admin'
        );

        $this->load->view('cadastros/usuario', $dados);
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