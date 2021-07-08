<?php

class Engenharia extends CI_Model{    

    public function insertEstruturaProduto($estrutura){
        $this->db->insert('estrutura_produto', $estrutura);

        if($this->db->error() <> null){
            return $this->db->error();
        }

        return null;
    }

    public function insertEstruturaComponente($componente){
        $this->db->insert('estrutura_componente', $componente);

        if($this->db->error() <> null){
            return $this->db->error();
        }

        return null;
    }

    public function updateEstruturaProduto($codProduto, $estrutura){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->where('cod_produto', $codProduto);
        $this->db->update('estrutura_produto', $estrutura);
        
        if($this->db->error() <> null){
            return $this->db->error();
        }

        return null;
    }    

    public function updateEstruturaComponente($seqEstruturaComponente, $componente){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->where('seq_estrutura_componente', $seqEstruturaComponente);
        $this->db->update('estrutura_componente', $componente);

        if($this->db->error() <> null){
            return $this->db->error();
        }

        return null;
    }

    public function deleteEstruturaProduto($codProduto) {
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->where_in('cod_produto',$codProduto)->delete('estrutura_produto');

        if($this->db->error() <> null){
            return $this->db->error();
        }

        return null;
    }

    public function deleteEstruturaComponente($seqEstruturaComponente) {
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->where_in('seq_estrutura_componente',$seqEstruturaComponente)->delete('estrutura_componente');

        if($this->db->error() <> null){
            return $this->db->error();
        }

        return null;
    }   

    public function getEstruturaProduto($filter = "", $limit = null, $offset = null){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('estrutura_produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        if($limit){
            $this->db->limit($limit, $offset);
        }

        //Join para pegar todas informações relativas à estrutura
        $this->db->select('estrutura_produto.*, produto.nome_produto, produto.cod_unidade_medida, tipo_produto.nome_tipo_produto');
        $this->db->select('(select count(*)
                              from estrutura_componente
                             where estrutura_componente.id_empresa  = estrutura_produto.id_empresa
                               and estrutura_componente.cod_produto = estrutura_produto.cod_produto) cont_componente');
        $this->db->from('estrutura_produto');
        $this->db->join('produto', 'produto.cod_produto = estrutura_produto.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto'); 

        if($filter <> ""){
            $this->db->group_start();
            $this->db->or_like('estrutura_produto.cod_produto' ,$filter);
            $this->db->or_like('nome_produto' ,$filter);
            $this->db->or_like('cod_unidade_medida' ,$filter);
            $this->db->or_like('nome_tipo_produto' ,$filter);
            $this->db->group_end();
            
        }
        
        return $query = $this->db->get()->result();
        
    }    

    public function getEstruturaProdutoPorCodigo($codProduto){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('estrutura_produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('estrutura_produto.*, produto.nome_produto, produto.cod_unidade_medida, tipo_produto.nome_tipo_produto');
        $this->db->from('estrutura_produto');
        $this->db->join('produto', 'produto.cod_produto = estrutura_produto.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->where('estrutura_produto.cod_produto', $codProduto);
        
        return $query = $this->db->get()->row();

    }

    public function getComponentesPorEstrutura($codProduto){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('estrutura_produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('estrutura_componente.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('estrutura_componente.*, produto.nome_produto, produto.cod_unidade_medida, tipo_produto.nome_tipo_produto, estrutura_produto.quant_producao');
        $this->db->from('estrutura_componente');
        $this->db->join('estrutura_produto', 'estrutura_produto.cod_produto = estrutura_componente.cod_produto');
        $this->db->join('produto', 'produto.cod_produto = estrutura_componente.cod_produto_componente');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->where('estrutura_componente.cod_produto', $codProduto);
        
        return $query = $this->db->get()->result();

    }  
    
    public function getEstruturaComponentePorCodigo($seqEstruturaComponente = null){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('estrutura_componente.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('estrutura_componente.*, produto.cod_produto, produto.nome_produto, produto.cod_unidade_medida, tipo_produto.nome_tipo_produto');
        $this->db->from('estrutura_componente');
        $this->db->join('produto', 'produto.cod_produto = estrutura_componente.cod_produto_componente');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->where('estrutura_componente.seq_estrutura_componente', $seqEstruturaComponente);
        
        return $query = $this->db->get()->row();
    }    

    public function selectEstruturaComponente($seqEstruturaComponente = null){

        $componente = $this->getEstruturaComponentePorCodigo($seqEstruturaComponente);
        $quantConsumo = number_format($componente->quant_consumo, 3, ',', '');

        $input = "{$componente->seq_estrutura_componente}|{$componente->cod_produto} - {$componente->nome_produto}|{$componente->cod_unidade_medida}|{$componente->nome_tipo_produto}|{$quantConsumo}";

        return $input;

    }

    public function countAll(){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']);

        return $this->db->count_all_results('estrutura_produto');
    }  
    
    public function countPorCodigo($codProduto){   
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        
        $this->db->where('cod_produto', $codProduto);      
        return $this->db->count_all_results('estrutura_produto');
    } 

}