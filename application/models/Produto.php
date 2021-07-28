<?php

class Produto extends CI_Model{

    public function insertProduto($produto){
        $this->db->insert('produto', $produto);
    }

    public function updateProduto($CodProduto, $produto){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->where('cod_produto', $CodProduto);
        $this->db->update('produto', $produto);

        if($this->db->affected_rows() > 0){
            return $CodProduto;
        }

        return NULL;
    }

    public function limpaRegistroContaAzul(){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->set('id_conta_azul', null);
        $this->db->update('produto');
    }

    public function deleteProduto($CodProduto) {
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->where_in('cod_produto',$CodProduto)->delete('produto');

        if($this->db->error() <> null){
            return $this->db->error();
        }

        return null;
    }

    public function getProduto($filter = "", $limit = null, $offset = null){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        if($limit){
            $this->db->limit($limit, $offset);
        }

        //Join para pegar o tipo de produto
        $this->db->select('produto.*, tipo_produto.nome_tipo_produto');
        $this->db->from('produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto'); 
        $this->db->order_by('produto.cod_produto', 'asc');         

        if($filter <> ""){
            $this->db->group_start();
            $this->db->or_like('cod_produto' ,$filter);
            $this->db->or_like('nome_produto' ,$filter);
            $this->db->or_like('cod_unidade_medida' ,$filter);
            $this->db->or_like('nome_tipo_produto' ,$filter);
            $this->db->group_end();
            
        }


        return $query = $this->db->get()->result();
        
    }    

    public function getProdutoPorCodigo($CodProduto){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('produto.*, tipo_produto.origem_produto, tipo_produto.nome_tipo_produto');
        $this->db->from('produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->where('produto.cod_produto', $CodProduto);

        return $query = $this->db->get()->row();
    } 

    public function getProdutoPorCodigoVendasExternas($codVendasExternas){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->from('produto');
        $this->db->where('produto.cod_vendas_externas', $codVendasExternas);

        return $query = $this->db->get()->row();
    } 

    public function getProdutoContaAzulPorCodigo($idContaAzul){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->from('produto');
        $this->db->where('produto.id_conta_azul', $idContaAzul);

        return $query = $this->db->get()->row();
    } 

    public function countAll($filter = ""){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto'); 

        if($filter <> ""){
            $this->db->group_start();
            $this->db->or_like('cod_produto' ,$filter);
            $this->db->or_like('nome_produto' ,$filter);
            $this->db->or_like('cod_unidade_medida' ,$filter);
            $this->db->or_like('nome_tipo_produto' ,$filter);
            $this->db->group_end();
            
        }

        return $this->db->count_all_results('produto');
    }

    public function getProdutoProduzido(){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('produto.*, tipo_produto.origem_produto');
        $this->db->from('produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->where('tipo_produto.origem_produto', '1');

        return $query = $this->db->get()->result();

    }

    public function getNCM(){

        $this->db->select('ncm.*');
        $this->db->from('ncm');

        return $query = $this->db->get()->result();

    }

    public function getNCMFiltro($filtro){

        $this->db->select('ncm.*');
        $this->db->from('ncm');
        $this->db->or_like('ncm.desc_ncm',$filtro);

        return $query = $this->db->get()->result();

    }

    public function getCest(){

        $this->db->select('cest.*');
        $this->db->from('cest');

        return $query = $this->db->get()->result();

    }

    public function getProdutoComprado(){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('produto.*, tipo_produto.origem_produto');
        $this->db->from('produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->where('tipo_produto.origem_produto', '2');

        return $query = $this->db->get()->result();

    }

    public function getProdutoEstruturaComponente($codProduto = null, $listaComponente = null){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('produto.*, tipo_produto.origem_produto');
        $this->db->from('produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->where('produto.cod_produto !=', $codProduto);

        // Não permitir selecionar o item que já está na lista de componentes
        if($listaComponente != null){
            foreach ($listaComponente as $key => $componente){
                $this->db->where('produto.cod_produto !=', $componente->cod_produto_componente);
            }
        }

        return $query = $this->db->get()->result();

    }

    public function getProdutoInventario($listaProduto = null){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('produto.*');
        $this->db->from('produto');

        // Não permitir selecionar o item que já está na lista de componentes
        if($listaProduto != null){
            foreach ($listaProduto as $key => $produto){
                $this->db->where('produto.cod_produto !=', $produto->cod_produto);
            }
        }

        return $query = $this->db->get()->result();

    }

    public function getProdutoRequisicaoMaterial($listaProduto = null){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('produto.*');
        $this->db->from('produto');

        // Não permitir selecionar o item que já está na lista de componentes
        if($listaProduto != null){
            foreach ($listaProduto as $key => $produto){
                $this->db->where('produto.cod_produto !=', $produto->cod_produto);
            }
        }

        return $query = $this->db->get()->result();

    }

    public function getProdutoOrdem($codProduto = null, $listaComponente = null){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('produto.*, tipo_produto.origem_produto');
        $this->db->from('produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->where('produto.cod_produto !=', $codProduto);

        // Não permitir selecionar o item que já está na lista de componentes
        if($listaComponente != null){
            foreach ($listaComponente as $key => $componente){
                $this->db->where('produto.cod_produto !=', $componente->cod_produto);
            }
        }

        return $query = $this->db->get()->result();

    }

    public function getProdutoVenda($listaVenda = null){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        //Join para pegar a origem do produto
        $this->db->select('produto.*, tipo_produto.origem_produto');
        $this->db->from('produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');

        // Não permitir selecionar o item que já está na lista de componentes
        if($listaVenda != null){
            foreach ($listaVenda as $key => $venda){
                $this->db->where('produto.cod_produto !=', $venda->cod_produto);
            }
        }

        return $query = $this->db->get()->result();

    }

    public function buscaProduto($codProduto = null){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('produto.cod_produto, produto.nome_produto, produto.cod_unidade_medida, produto.custo_medio, produto.preco_venda, tipo_produto.nome_tipo_produto');
        $this->db->from('produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->where('produto.cod_produto', $codProduto);
        
        return $query = $this->db->get()->row();
    }

    public function selectProduto($codProduto = null){

        $produto = $this->buscaProduto($codProduto);

        $custoMedio = number_format($produto->custo_medio, 2, ',', '.');
        $precoVenda = number_format($produto->preco_venda, 2, ',', '.');

        $input = "{$produto->cod_unidade_medida}|{$produto->nome_tipo_produto}|{$custoMedio}|{$precoVenda}";

        return $input;

    }    

    public function buscaComponenteProd($seqComponente = null){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('componente_ordem_producao.*, produto.cod_produto, produto.nome_produto, produto.cod_unidade_medida, tipo_produto.nome_tipo_produto');
        $this->db->from('componente_ordem_producao');
        $this->db->join('produto', 'produto.cod_produto = componente_ordem_producao.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->where('componente_ordem_producao.seq_componente_producao', $seqComponente);
        
        return $query = $this->db->get()->row();
    }  

    public function selectComponenteProd($seqComponente = null){
        $this->load->model('Engenharia', 'engenharia', true);

        $componente = $this->buscaComponenteProd($seqComponente);
        $quantConsumo = number_format($componente->quant_consumo, 3, ',', '.');

        $input = "{$componente->seq_componente_producao}|{$componente->cod_produto} - {$componente->nome_produto}|{$componente->cod_unidade_medida}|{$componente->nome_tipo_produto}|{$quantConsumo}";

        return $input;

    }
    
    public function buscaProdutoFiltro($filtro){
       $this->db->from('produto');
       $this->db->select('produto.*');
       
       $this->db->or_like('produto.nome_produto', $filtro);
       $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
       return $query = $this->db->get()->result();
   } 


   public function buscaProdutoVenda($seqProdutoVenda = null){
    $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

    $this->db->select('produto_venda.*, produto.cod_produto, produto.nome_produto, produto.cod_unidade_medida, tipo_produto.nome_tipo_produto');
    $this->db->from('produto_venda');
    $this->db->join('produto', 'produto.cod_produto = produto_venda.cod_produto');
    $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
    $this->db->where('produto_venda.seq_produto_venda', $seqProdutoVenda);

    return $query = $this->db->get()->row();
} 

public function selectProdutoVenda($seqProdutoVenda = null){
    $this->load->model('Vendas', 'venda', true);

    $produto = $this->buscaProdutoVenda($seqProdutoVenda);
    $quantPedida = number_format($produto->quant_pedida, 3, ',', '.');
    $quantAtendida = number_format($produto->quant_atendida, 3, ',', '.');

    $input = "{$produto->seq_produto_venda}|{$produto->cod_produto} - {$produto->nome_produto}|{$produto->cod_unidade_medida}|{$produto->nome_tipo_produto}|{$quantPedida}|{$quantAtendida}";

    return $input;

}

public function countPorCodigo($codProduto){   
    $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

    $this->db->where('cod_produto', $codProduto);      
    return $this->db->count_all_results('produto');
}        

}