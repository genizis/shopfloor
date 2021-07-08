<?php

class Usuario extends CI_Model{    

    public function insertUsuario($usuario){
        $this->db->insert('usuario', $usuario);
    }

    public function updateUsuario($Email, $usuario){
        
        $this->db->where('email', $Email);
        $this->db->update('usuario', $usuario);

        return NULL;
    }

    public function autenticar($email, $senha){
        return $this->db->get_where('usuario', array('email' => $email, 'senha' => $senha))->row();
    }    

    public function getUsuarios($filter = "", $limit = null, $offset = null){
        $this->db->where('usuario.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        if($limit){
            $this->db->limit($limit, $offset);
        }

        //Join para pegar o segmento
        $this->db->select('usuario.*');
        $this->db->from('usuario');       

        if($filter <> ""){
            $this->db->group_start();
            $this->db->or_like('email' ,$filter);
            $this->db->or_like('nome_usuario' ,$filter);
            $this->db->group_end();
            
        }
        
        return $query = $this->db->get()->result();
        
    }

    public function getUsuarioPorCodigo($email){
        return $this->db->get_where('usuario', array('email' => $email))->row();
    }

    public function countAll(){
        $this->db->where('usuario.id_empresa', getDadosUsuarioLogado()['id_empresa']);        

        return $this->db->count_all_results('usuario');
    }

}