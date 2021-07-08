<?php

class Empresa extends CI_Model{

    public function insertEmpresa($empresa){
        $this->db->insert('empresa', $empresa);

        return $this->db->insert_id();
    }

    public function updateEmpresa($idEmpresa, $empresa){
        
        $this->db->where('id_empresa', $idEmpresa);
        $this->db->update('empresa', $empresa);

        if($this->db->affected_rows() > 0){
            return $idEmpresa;
        }

        return NULL;
    }

    public function getEmpresaPorCodigo($idEmpresa){
        $this->db->select('empresa.*, cidade.nome as nome_cidade, estado.uf');
        $this->db->join('cidade', 'cidade.id = empresa.cod_cidade', 'left');
        $this->db->join('estado', 'estado.id = cidade.estado', 'left');
        return $this->db->get_where('empresa', array('id_empresa' => $idEmpresa))->row();
    }

    public function getParametrosEmpresa($idEmpresa){
        $this->db->select('empresa.*');
        $this->db->select('(select count(*)
                              from usuario
                             where usuario.ativo = 1
                               and usuario.id_empresa = empresa.id_empresa) num_usuario');
        return $this->db->get_where('empresa', array('id_empresa' => $idEmpresa))->row();
    }
}