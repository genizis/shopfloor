<?php

class Fornecedor extends CI_Model{    

    public function insertFornecedor($fornecedor){
        $this->db->insert('fornecedor', $fornecedor);

        return $this->db->insert_id();
    }

    public function updateFornecedor($CodFornecedor, $fornecedor){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        
        $this->db->where('cod_fornecedor', $CodFornecedor);
        $this->db->update('fornecedor', $fornecedor);

        if($this->db->affected_rows() > 0){
            return $CodFornecedor;
        }

        return null;
    }

    public function deleteFornecedor($CodFornecedor) {
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->where_in('cod_fornecedor',$CodFornecedor)->delete('fornecedor');

        if($this->db->error() <> null){
            return $this->db->error();
        }

        return null;
    }

    public function getFornecedor($filter = "", $limit = null, $offset = null){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        if($limit){
            $this->db->limit($limit, $offset);
        }

        //Join para pegar o segmento
        $this->db->select('fornecedor.*, segmento.nome_segmento');
        $this->db->select('(select count(*)
                              from pedido_compra
                             where pedido_compra.cod_fornecedor = fornecedor.cod_fornecedor) count_pedido');
        $this->db->from('fornecedor');
        $this->db->join('segmento', 'segmento.cod_segmento = fornecedor.cod_segmento');        

        if($filter <> ""){
            $this->db->group_start();
            $this->db->or_like('cod_fornecedor' ,$filter);
            $this->db->or_like('nome_fornecedor' ,$filter);
            $this->db->or_like('cnpj_cpf' ,$filter);
            $this->db->group_end();
            
        }
        
        return $query = $this->db->get()->result();
        
    }

    public function getFornecedorPorDocumento($CnpjCpf){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('fornecedor.*, cidade.nome as nome_cidade, estado.uf');
        $this->db->join('cidade', 'cidade.id = fornecedor.cod_cidade', 'left');
        $this->db->join('estado', 'estado.id = fornecedor.cod_estado', 'left');

        return $this->db->get_where('fornecedor', array('cnpj_cpf' => $CnpjCpf))->row();
    }

    public function getFornecedorPorNome($nomeFornecedor){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('fornecedor.*, cidade.nome as nome_cidade, estado.uf');
        $this->db->join('cidade', 'cidade.id = fornecedor.cod_cidade', 'left');
        $this->db->join('estado', 'estado.id = fornecedor.cod_estado', 'left');
        $this->db->where('cnpj_cpf', ''); 
        $this->db->limit(1);

        return $this->db->get_where('fornecedor', array('nome_fornecedor' => $nomeFornecedor))->row();
    }

    public function getFornecedorPorCodigo($codFornecdor){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']);

        return $this->db->get_where('fornecedor', array('cod_fornecedor' => $codFornecdor))->row();
    }

    public function countAll(){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        return $this->db->count_all_results('fornecedor');
    }    

    public function buscarPorCodigo($CodFornecedor){
        $this->db->where('fornecedor.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('fornecedor.*, cidade.nome as nome_cidade, estado.uf');
        $this->db->join('cidade', 'cidade.id = fornecedor.cod_cidade', 'left');
        $this->db->join('estado', 'estado.id = fornecedor.cod_estado', 'left');

        return $this->db->get_where('fornecedor', array('cod_fornecedor' => $CodFornecedor))->row();
    }    

}