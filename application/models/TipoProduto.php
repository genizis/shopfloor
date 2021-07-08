<?php

class TipoProduto extends CI_Model{

    public function insertTipoProduto($tipoProduto){
        $this->db->insert('tipo_produto', $tipoProduto);

        return $this->db->insert_id();
    }

    public function insertMultTipoProduto($tipoProduto){
        $this->db->insert_batch('tipo_produto', $tipoProduto);
    }

    public function updateTipoProduto($CodTipoProduto, $tipoProduto){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->where('cod_tipo_produto', $CodTipoProduto);
        $this->db->update('tipo_produto', $tipoProduto);

        if($this->db->affected_rows() > 0){
            return $CodTipoProduto;
        }

        return NULL;
    }

    public function deleteTipoProduto($CodTipoProduto) {
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->where_in('cod_tipo_produto',$CodTipoProduto)->delete('tipo_produto');

        if($this->db->error() <> null){
            return $this->db->error();
        }

        return null;
    }

    public function getTipoProduto($filter = "", $limit = null, $offset = null){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']);  

        if($limit){
            $this->db->limit($limit, $offset);
        }

        if($filter <> ""){
            $this->db->group_start();
            $this->db->or_like('cod_tipo_produto' ,$filter);
            $this->db->or_like('nome_tipo_produto' ,$filter);
            $this->db->group_end();
            
        }
               
        return $this->db->get('tipo_produto')->result();
        
    }

    public function getPrimeiroTipoProduto(){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->limit(1);
               
        return $this->db->get('tipo_produto')->row();
        
    }

    public function getTipoProdutoPorCodigo($CodTipoProduto){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        return $this->db->get_where('tipo_produto', array('cod_tipo_produto' => $CodTipoProduto))->row();
    }

    public function getTipoProdutoPorIdCA($idContaAzul){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']);

        return $this->db->get_where('tipo_produto', array('id_conta_azul' => $idContaAzul))->row();
    }

    public function countAll(){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        return $this->db->count_all_results('tipo_produto');
    }

    public function countPorCodigo($CodUnidadeMedida){   
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        
        $this->db->where('cod_unidade_medida', $CodUnidadeMedida);      
        return $this->db->count_all_results('unidade_medida');
    } 

}