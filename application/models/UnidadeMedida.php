<?php

class UnidadeMedida extends CI_Model{

    public function insertUnidadeMedida($unidadeMedida){
        $this->db->insert('unidade_medida', $unidadeMedida);
    }

    public function insertMultUnidadeMedida($unidadeMedida){
        $this->db->insert_batch('unidade_medida', $unidadeMedida);
    }

    public function updateUnidadeMedida($CodUnidadeMedida, $unidadeMedida){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->where('cod_unidade_medida', $CodUnidadeMedida);                
        $this->db->update('unidade_medida', $unidadeMedida);

        if($this->db->affected_rows() > 0){
            return $CodUnidadeMedida;
        }

        return NULL;
    } 

    public function deleteUnidadeMedida($CodUnidadeMedida) {
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']);  
        
        $this->db->where_in('cod_unidade_medida',$CodUnidadeMedida)->delete('unidade_medida');
        
        if($this->db->error() <> null){
            return $this->db->error();
        }

        return null;
    }

    public function getUnidadeMedida($filter = "", $limit = null, $offset = null){ 
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']);          

        if($limit){
            $this->db->limit($limit, $offset);
        }

        if($filter <> ""){
            $this->db->group_start();
            $this->db->or_like('cod_unidade_medida' ,$filter);
            $this->db->or_like('nome_unidade_medida' ,$filter);
            $this->db->group_end();
            
        }
                        
        return $this->db->get('unidade_medida')->result();        
    } 

    public function getUnidadeMedidaPorCodigo($CodUnidadeMedida){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']);  

        return $this->db->get_where('unidade_medida', array('cod_unidade_medida' => $CodUnidadeMedida))->row();
    }

    public function countAll(){   
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']);  

        return $this->db->count_all_results('unidade_medida');
    } 

    public function countPorCodigo($CodUnidadeMedida){   
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        
        $this->db->where('cod_unidade_medida', $CodUnidadeMedida);      
        return $this->db->count_all_results('unidade_medida');
    } 

}