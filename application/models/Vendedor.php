<?php

class Vendedor extends CI_Model{ 
    
    public function autenticarVendedor($empresa, $usuario, $senha){
        return $this->db->get_where('vendedor', array('id_empresa' => $empresa, 'nome_usuario' => $usuario, 'senha' => $senha))->row();
    }

    public function insertVendedor($vendedor){
        $this->db->insert('vendedor', $vendedor);

        return $this->db->insert_id();
    }

    public function updateVendedor($codVendedor, $vendedor){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        
        $this->db->where('cod_vendedor', $codVendedor);
        $this->db->update('vendedor', $vendedor);

        if($this->db->affected_rows() > 0){
            return $codVendedor;
        }

        return NULL;
    }

    public function deleteVendedor($codVendedor) {
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->where_in('cod_vendedor',$codVendedor)->delete('vendedor');

        if($this->db->error() <> null){
            return $this->db->error();
        }

        return null;
    }

    public function getVendedor($filter = "", $limit = null, $offset = null){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        if($limit){
            $this->db->limit($limit, $offset);
        }

        //Join para pegar o segmento
        $this->db->select('vendedor.*');
        $this->db->select('(select count(*)
                              from pedido_venda
                             where pedido_venda.cod_vendedor = vendedor.cod_vendedor) count_pedido');
        $this->db->from('vendedor');      

        if($filter <> ""){
            $this->db->group_start();
            $this->db->or_like('cod_vendedor' ,$filter);
            $this->db->or_like('nome_vendedor' ,$filter);
            $this->db->group_end();
            
        }
        
        return $query = $this->db->get()->result();
        
    }

    public function getVendedorPorCodigo($CodVendedor){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('vendedor.*, cidade.nome as nome_cidade, estado.uf');
        $this->db->join('cidade', 'cidade.id = vendedor.cod_cidade', 'left');
        $this->db->join('estado', 'estado.id = cidade.estado', 'left');

        return $this->db->get_where('vendedor', array('cod_vendedor' => $CodVendedor))->row();
    }
    
    public function getVendedorPorCodigoVendasExternas($CodVendasExternas){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('vendedor.*, cidade.nome as nome_cidade, estado.uf');
        $this->db->join('cidade', 'cidade.id = vendedor.cod_cidade', 'left');
        $this->db->join('estado', 'estado.id = cidade.estado', 'left');

        return $this->db->get_where('vendedor', array('cod_vendas_externas' => $CodVendasExternas))->row();
    } 

    public function getVendedorPorNome($nomeVendedor){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('vendedor.*, cidade.nome as nome_cidade, estado.uf');
        $this->db->join('cidade', 'cidade.id = vendedor.cod_cidade', 'left');
        $this->db->join('estado', 'estado.id = cidade.estado', 'left');
        $this->db->limit(1);

        return $this->db->get_where('vendedor', array('nome_vendedor' => $nomeVendedor))->row();
    } 

    public function countAll(){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        return $this->db->count_all_results('vendedor');
    }

    public function selectVendedor($codVendedor = null){

        $vendedor = $this->getVendedorPorCodigo($codVendedor);

        $input = number_format($vendedor->perc_comissao, 2, ',', '.');

        return $input;

    }

}