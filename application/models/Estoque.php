<?php

class Estoque extends CI_Model{

    public function insertMovimentoEstoque($movimentoEstoque){
        $this->db->insert('movimentos_estoque', $movimentoEstoque);

        // Atualiza saldo do Produto
        $produto = $this->produto->getProdutoPorCodigo($movimentoEstoque['cod_produto']);

        if($movimentoEstoque['tipo_movimento'] == 1) {

            $quantEstoque = $produto->quant_estoq + $movimentoEstoque['quant_movimentada'];

        }elseif($movimentoEstoque['tipo_movimento']  == 2){

            $quantEstoque = $produto->quant_estoq - $movimentoEstoque['quant_movimentada'];

        }

        $dados = [
            'quant_estoq' => $quantEstoque
        ];

        $this->produto->updateProduto($movimentoEstoque['cod_produto'], $dados);

    } 

    public function insertInventario($inventario){
        $this->db->insert('inventario', $inventario);

        return $this->db->insert_id();    
    }

    public function insertRequisicaoMaterial($requisicao){
        $this->db->insert('requisicao_material', $requisicao);

        return $this->db->insert_id();    
    }

    public function insertProdutoInventario($prodInventario){
        $this->db->insert('produto_inventario', $prodInventario);   
    }

    public function insertProdutoRequisicaoMaterial($prodRequisicao){
        $this->db->insert('produto_requisicao_material', $prodRequisicao);   
    }
    
    public function updateMovimentoEstoque($codMovimento, $movimento){
        $this->db->where('cod_movimento_estoque', $codMovimento);
        $this->db->update('movimentos_estoque', $movimento);
    }

    public function updateProdutoInventario($seqProdutoInv, $prodInventario){
        $this->db->where('seq_produto_inventario', $seqProdutoInv);
        $this->db->update('produto_inventario', $prodInventario);
    }

    public function updateProdutoRequisicaoMaterial($seqProdutoRequisicao, $prodRequisicao){
        $this->db->where('seq_produto_requisicao_material', $seqProdutoRequisicao);
        $this->db->update('produto_requisicao_material', $prodRequisicao);
    }

    public function updateInventario($numInventario, $inventario){
        $this->db->where('num_inventario', $numInventario);
        $this->db->update('inventario', $inventario);
    }

    public function updateRequisicaoMaterial($codRequisicaoMaterial, $requisicao){
        $this->db->where('cod_requisicao_material', $codRequisicaoMaterial);
        $this->db->update('requisicao_material', $requisicao);
    }

    public function deleteProdutoInventario($seqProdutoInv) {
        $this->db->where_in('seq_produto_inventario',$seqProdutoInv)->delete('produto_inventario');
    }

    public function deleteProdutoRequisicao($seqProdutoReq) {
        $this->db->where_in('seq_produto_requisicao_material',$seqProdutoReq)->delete('produto_requisicao_material');
    }

    public function deleteInventario($numInventario) {
        $this->db->where_in('num_inventario',$numInventario)->delete('inventario');
    }

    public function getInventarioPorCodigo($numInventario){
        $this->db->where('inventario.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('inventario.*');
        $this->db->from('inventario');  
        $this->db->where('inventario.num_inventario', $numInventario);

        return $query = $this->db->get()->row();

    }

    public function getRequisicaoMaterialPorCodigo($codRequisicao){
        $this->db->where('requisicao_material.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('requisicao_material.*');
        $this->db->from('requisicao_material');  
        $this->db->where('requisicao_material.cod_requisicao_material', $codRequisicao);

        return $query = $this->db->get()->row();

    }

    public function getProdutoInventario($numInventario){
        $this->db->where('produto_inventario.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('produto_inventario.*, produto.nome_produto, produto.cod_unidade_medida, 
                           produto.quant_estoq, tipo_produto.nome_tipo_produto');
        $this->db->from('produto_inventario');
        $this->db->join('produto', 'produto.cod_produto = produto_inventario.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->where('produto_inventario.num_inventario', $numInventario); 

        return $query = $this->db->get()->result();
    }

    public function getProdutoRequisicaoMaterial($codRequisicaoMaterial){
        $this->db->where('produto_requisicao_material.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('produto_requisicao_material.*, produto.nome_produto, produto.cod_unidade_medida, 
                           produto.custo_medio, produto.quant_estoq, tipo_produto.nome_tipo_produto');
        $this->db->from('produto_requisicao_material');
        $this->db->join('produto', 'produto.cod_produto = produto_requisicao_material.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->where('produto_requisicao_material.cod_requisicao_material', $codRequisicaoMaterial); 

        return $query = $this->db->get()->result();
    }

    public function getMovimentosEstoquePorReporte($codReporteProducao){
        $this->db->where('movimentos_estoque.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('movimentos_estoque.*, produto.nome_produto, produto.saldo_negativo, produto.quant_estoq, produto.id_conta_azul');
        $this->db->from('movimentos_estoque');
        $this->db->join('produto', 'movimentos_estoque.cod_produto = produto.cod_produto');    
        $this->db->where('origem_movimento', '1');
        $this->db->where('id_origem', $codReporteProducao);

        return $query = $this->db->get()->result();

    }

    public function getPosicaoProduto($filter = "", $data, $limit = null, $offset = null){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        if($limit){
            $this->db->limit($limit, $offset);
        }

        //Join para pegar o tipo de produto
        $this->db->select('produto.*, tipo_produto.nome_tipo_produto');
        $this->db->select("(select sum(movimentos_estoque.quant_movimentada)
                              from movimentos_estoque
                             where movimentos_estoque.id_empresa = " . getDadosUsuarioLogado()['id_empresa'] . "
                               and movimentos_estoque.cod_produto = produto.cod_produto
                               and movimentos_estoque.tipo_movimento = 1
                               and movimentos_estoque.data_movimento >= '" . $data . "') quant_entrada");
        $this->db->select("(select sum(movimentos_estoque.quant_movimentada)
                              from movimentos_estoque
                             where movimentos_estoque.id_empresa = " . getDadosUsuarioLogado()['id_empresa'] . "
                               and movimentos_estoque.cod_produto = produto.cod_produto
                               and movimentos_estoque.tipo_movimento = 2
                               and movimentos_estoque.data_movimento >= '" . $data . "') quant_saida");
        $this->db->from('produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto'); 
        $this->db->order_by('produto.nome_produto', 'asc');         

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

    public function getInventario($filter = "", $data, $limit = null, $offset = null){
        $this->db->where('inventario.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        if($limit){
            $this->db->limit($limit, $offset);
        }

        //Join para pegar o tipo de produto
        $this->db->select('inventario.*');
        $this->db->select("(select count(*)
                              from produto_inventario
                             where produto_inventario.id_empresa = " . getDadosUsuarioLogado()['id_empresa'] . "
                               and produto_inventario.num_inventario = inventario.num_inventario) quant_produto");
        $this->db->from('inventario');
        $this->db->order_by('inventario.num_inventario', 'desc');         

        if($filter <> ""){
            $this->db->group_start();
            $this->db->or_like('inventario.num_inventario' ,$filter);
            $this->db->group_end();            
        }

                
        return $query = $this->db->get()->result();
        
    }

    public function getRequisicaoMaterial($filter = "", $data, $limit = null, $offset = null){
        $this->db->where('requisicao_material.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        if($limit){
            $this->db->limit($limit, $offset);
        }

        //Join para pegar o tipo de produto
        $this->db->select('requisicao_material.*');
        $this->db->select("(select count(*)
                              from produto_requisicao_material
                             where produto_requisicao_material.id_empresa = " . getDadosUsuarioLogado()['id_empresa'] . "
                               and produto_requisicao_material.cod_requisicao_material = requisicao_material.cod_requisicao_material) quant_produto");
        $this->db->from('requisicao_material');
        $this->db->order_by('requisicao_material.cod_requisicao_material', 'desc');         

        if($filter <> ""){
            $this->db->group_start();
            $this->db->or_like('requisicao_material.cod_requisicao_material' ,$filter);
            $this->db->group_end();            
        }

                
        return $query = $this->db->get()->result();
        
    }

    public function getMovimentosEstoquePorProduto($codProduto, $limit = null, $offset = null){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        if($limit){
            $this->db->limit($limit, $offset);
        }

        $this->db->where('cod_produto', $codProduto);
        $this->db->order_by('cod_movimento_estoque', 'desc');
        return $query = $this->db->get('movimentos_estoque')->result();
    }

    public function getCustoMedio($codProduto){
        $this->db->where('movimentos_estoque.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('AVG(movimentos_estoque.valor_movimento / movimentos_estoque.quant_movimentada) custo_medio');
        $this->db->from('movimentos_estoque');
        $this->db->where('movimentos_estoque.cod_produto', $codProduto);
        $this->db->where('movimentos_estoque.tipo_movimento', 1);
        $this->db->where('movimentos_estoque.considera_calc_custo', 0);
        $this->db->where('movimentos_estoque.valor_movimento >', 0);
        $this->db->where('movimentos_estoque.data_movimento >= DATE_ADD(CURRENT_DATE(), INTERVAL -30 DAY)');

        return $query = $this->db->get()->row();

    }

    public function countAllProduto($codProduto){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        
        $this->db->where('cod_produto', $codProduto);
        return $this->db->count_all_results('movimentos_estoque');
    } 
    
    public function countAllMovimentos($codProduto){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        
        $this->db->where('cod_produto', $codProduto);
        return $this->db->count_all_results('movimentos_estoque');
    }
    
    public function countAllInventario(){
        $this->db->where('inventario.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        
        return $this->db->count_all_results('inventario');
    }

    public function countAllRequisicaoMaterial(){
        $this->db->where('requisicao_material.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        
        return $this->db->count_all_results('requisicao_material');
    }

    //Relatórios
    public function getMovimentoResumido($dataInicio, $dataFim, $codProdutos){
        $this->db->where('movimentos_estoque.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('tipo_produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('movimentos_estoque.cod_produto, produto.nome_produto, tipo_produto.nome_tipo_produto, produto.cod_unidade_medida,
                           sum(if(movimentos_estoque.tipo_movimento = 1, movimentos_estoque.quant_movimentada, 0)) quant_entrada,
                           sum(if(movimentos_estoque.tipo_movimento = 2, movimentos_estoque.quant_movimentada, 0)) quant_saida,
                           sum(if(movimentos_estoque.tipo_movimento = 1, movimentos_estoque.valor_movimento, 0)) total_entrada,
                           sum(if(movimentos_estoque.tipo_movimento = 2, movimentos_estoque.valor_movimento, 0)) total_saida');
        $this->db->from('movimentos_estoque');
        $this->db->join('produto', 'produto.cod_produto = movimentos_estoque.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->group_by('movimentos_estoque.cod_produto');

        $this->db->where("movimentos_estoque.data_movimento >= ", $dataInicio);
        $this->db->where("movimentos_estoque.data_movimento <= ", $dataFim);

        if($codProdutos != ""){
            $this->db->where_in('movimentos_estoque.cod_produto', $codProdutos);
        }

        return $query = $this->db->get()->result();

    }

    public function getMovimentoDetalhado($dataInicio, $dataFim, $codProdutos){
        $this->db->where('movimentos_estoque.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('tipo_produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('movimentos_estoque.*, produto.nome_produto, tipo_produto.nome_tipo_produto, produto.cod_unidade_medida, produto.custo_medio');
        $this->db->from('movimentos_estoque');
        $this->db->join('produto', 'produto.cod_produto = movimentos_estoque.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->order_by('movimentos_estoque.data_movimento', 'desc');

        $this->db->where("movimentos_estoque.data_movimento >= ", $dataInicio);
        $this->db->where("movimentos_estoque.data_movimento <= ", $dataFim);

        if($codProdutos != ""){
            $this->db->where_in('movimentos_estoque.cod_produto', $codProdutos);
        }

        return $query = $this->db->get()->result();
    }

    public function getTotalMovimento($dataInicio, $dataFim, $codProdutos){
        $this->db->where('movimentos_estoque.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('sum(if(movimentos_estoque.tipo_movimento = 1, movimentos_estoque.valor_movimento, 0)) total_entrada,
                           sum(if(movimentos_estoque.tipo_movimento = 2, movimentos_estoque.valor_movimento, 0)) total_saida');
        $this->db->from('movimentos_estoque');
        

        $this->db->where("movimentos_estoque.data_movimento >= ", $dataInicio);
        $this->db->where("movimentos_estoque.data_movimento <= ", $dataFim);

        if($codProdutos != ""){
            $this->db->where_in('movimentos_estoque.cod_produto', $codProdutos);
        }

        return $query = $this->db->get()->row();

    }

    public function getTotalEstoque(){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('sum(produto.quant_estoq * produto.custo_medio) as total_estoq');
        $this->db->from('produto');
        $this->db->where('produto.quant_estoq > 0');

        return $query = $this->db->get()->row();        
    }

    public function getTotalEstoqueProduto(){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('sum(produto.quant_estoq * produto.custo_medio) as total_estoq, produto.cod_produto, produto.nome_produto');
        $this->db->from('produto');
        $this->db->where('produto.quant_estoq > 0');
        $this->db->order_by('sum(produto.quant_estoq * produto.custo_medio)', 'desc');
        $this->db->group_by('produto.cod_produto');
        $this->db->limit(3);

        return $query = $this->db->get()->result();        
    }

    public function countAllCalculoNecessidade(){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        return $this->db->count_all_results('calculo_necessidade');
    }

    public function getCalculoMRP($filter = "", $limit = null, $offset = null){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        if($limit){
            $this->db->limit($limit, $offset);
        }

        //Join para pegar o tipo de produto
        $this->db->select('calculo_necessidade.*');
        $this->db->from('calculo_necessidade');
        $this->db->order_by('data_fim', 'desc');       

        if($filter <> ""){
            $this->db->group_start();
            $this->db->or_like('calculo_necessidade.cod_calculo_necessidade' ,$filter);
            $this->db->or_like('calculo_necessidade.data_inicio' ,$filter);
            $this->db->or_like('calculo_necessidade.data_fim' ,$filter);
            $this->db->group_end();
            
        }
        
        return $this->db->get()->result();
        
    }

    public function insertCalculoNecessidade($calculoMrp){
        $this->db->insert('calculo_necessidade', $calculoMrp);

        return $this->db->insert_id();

    }

    public function insertCalculoNecessidadePedido($NecessidadePedido){
        $this->db->insert('calculo_necessidade_pedido', $NecessidadePedido);

        return $this->db->insert_id();

    }

    public function insertCalculoNecessidadeProduto($NecessidadeProduto){
        $this->db->insert('calculo_necessidade_produto', $NecessidadeProduto);

        return $this->db->insert_id();

    }

    public function getNecessidadePorCodigo($codNecessidade){
        $this->db->where('calculo_necessidade.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('calculo_necessidade.*');
        $this->db->from('calculo_necessidade');
        $this->db->where('calculo_necessidade.cod_calculo_necessidade', $codNecessidade);
        
        return $query = $this->db->get()->row();

    }

    public function validaDataCalculo($data){
        $this->db->where('calculo_necessidade.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('calculo_necessidade.*');
        $this->db->from('calculo_necessidade');
        $this->db->where('calculo_necessidade.data_inicio <= ', $data);
        $this->db->where('calculo_necessidade.data_fim >= ', $data);
        
        return $this->db->get()->result();

    }

    public function getNecessidadePorCodigoData($codNecessidade, $codProduto, $dataNecessidade){
        $this->db->where('calculo_necessidade.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('calculo_necessidade_produto.*');
        $this->db->from('calculo_necessidade_produto');
        $this->db->join('calculo_necessidade', 'calculo_necessidade.cod_calculo_necessidade = calculo_necessidade_produto.cod_calculo_necessidade');
        $this->db->where('calculo_necessidade_produto.cod_produto', $codProduto);
        $this->db->where('calculo_necessidade_produto.data_necessidade', $dataNecessidade);
        $this->db->where('calculo_necessidade.cod_calculo_necessidade', $codNecessidade);
        
        return $this->db->get()->row();

    }

    public function getPedidoPorCalculoNecessidade($codNecessidade){
        $this->db->where('pedido_venda.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        //Join para pegar todas informações relativas à estrutura
        $this->db->select('pedido_venda.*, cliente.nome_cliente');
        $this->db->select('(select sum(produto_venda.quant_pedida * produto_venda.valor_unitario) 
                             from produto_venda
                            where produto_venda.num_pedido_venda = pedido_venda.num_pedido_venda) valor_total_pedido');
        $this->db->select('(select count(*)
                            from faturamento_pedido
                           where faturamento_pedido.num_pedido_venda = pedido_venda.num_pedido_venda) count_faturamento');
        $this->db->from('pedido_venda');
        $this->db->join('cliente', 'cliente.cod_cliente = pedido_venda.cod_cliente');
        $this->db->join('calculo_necessidade_pedido', 'calculo_necessidade_pedido.num_pedido_venda = pedido_venda.num_pedido_venda');
        $this->db->where('calculo_necessidade_pedido.cod_calculo_necessidade', $codNecessidade);
        $this->db->order_by('pedido_venda.data_entrega', 'asc');
        
        return $this->db->get()->result();
        
    }

    public function getProdutoOrdemProducao($codNecessidade){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('calculo_necessidade.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        //Join para pegar todas informações relativas à estrutura
        $this->db->select('calculo_necessidade_produto.*, produto.nome_produto, produto.cod_unidade_medida, tipo_produto.nome_tipo_produto');
        $this->db->from('calculo_necessidade_produto');
        $this->db->join('produto', 'produto.cod_produto = calculo_necessidade_produto.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->join('calculo_necessidade', 'calculo_necessidade.cod_calculo_necessidade = calculo_necessidade_produto.cod_calculo_necessidade');
        $this->db->where('calculo_necessidade.cod_calculo_necessidade', $codNecessidade);
        $this->db->where('calculo_necessidade_produto.tipo_necessidade', 1);
        $this->db->order_by('calculo_necessidade_produto.data_necessidade', 'asc');
        $this->db->order_by('calculo_necessidade_produto.cod_calculo_necessidade_produto', 'desc');
        
        return $this->db->get()->result();
        
    }

    public function getProdutoOrdemCompra($codNecessidade){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('calculo_necessidade.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        //Join para pegar todas informações relativas à estrutura
        $this->db->select('calculo_necessidade_produto.*, produto.nome_produto, produto.cod_unidade_medida, tipo_produto.nome_tipo_produto');
        $this->db->from('calculo_necessidade_produto');
        $this->db->join('produto', 'produto.cod_produto = calculo_necessidade_produto.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->join('calculo_necessidade', 'calculo_necessidade.cod_calculo_necessidade = calculo_necessidade_produto.cod_calculo_necessidade');
        $this->db->where('calculo_necessidade.cod_calculo_necessidade', $codNecessidade);
        $this->db->where('calculo_necessidade_produto.tipo_necessidade', 2);
        $this->db->order_by('calculo_necessidade_produto.data_necessidade', 'asc');
        $this->db->order_by('calculo_necessidade_produto.cod_calculo_necessidade_produto', 'desc');
        
        return $this->db->get()->result();
        
    }

    public function getProdutoNecessidade($codNecessidade){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('calculo_necessidade.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        //Join para pegar todas informações relativas à estrutura
        $this->db->select('calculo_necessidade_produto.*, produto.nome_produto, produto.cod_unidade_medida, tipo_produto.nome_tipo_produto');
        $this->db->from('calculo_necessidade_produto');
        $this->db->join('produto', 'produto.cod_produto = calculo_necessidade_produto.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->join('calculo_necessidade', 'calculo_necessidade.cod_calculo_necessidade = calculo_necessidade_produto.cod_calculo_necessidade');
        $this->db->where('calculo_necessidade.cod_calculo_necessidade', $codNecessidade);
        $this->db->order_by('calculo_necessidade_produto.data_necessidade', 'asc');
        $this->db->order_by('calculo_necessidade_produto.cod_calculo_necessidade_produto', 'desc');
        
        return $this->db->get()->result();
        
    }

    public function getProdutoCalculoNecessidade($codNecessidade){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('calculo_necessidade.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        //Join para pegar todas informações relativas à estrutura
        $this->db->select('calculo_necessidade_produto.*, produto.nome_produto, produto.cod_unidade_medida, tipo_produto.nome_tipo_produto');
        $this->db->from('calculo_necessidade_produto');
        $this->db->join('produto', 'produto.cod_produto = calculo_necessidade_produto.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->join('calculo_necessidade', 'calculo_necessidade.cod_calculo_necessidade = calculo_necessidade_produto.cod_calculo_necessidade');
        $this->db->where('calculo_necessidade.cod_calculo_necessidade', $codNecessidade);
        $this->db->order_by('calculo_necessidade_produto.data_necessidade', 'desc');
        
        return $this->db->get()->result();
        
    }

    public function getProdutosPedidosPorCalculoNecessidade($codNecessidade){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('produto_venda.*, produto.nome_produto, produto.cod_unidade_medida, 
                           produto.saldo_negativo, produto.quant_estoq, tipo_produto.nome_tipo_produto');
        $this->db->from('produto_venda');
        $this->db->join('produto', 'produto.cod_produto = produto_venda.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->join('calculo_necessidade_pedido', 'calculo_necessidade_pedido.num_pedido_venda = produto_venda.num_pedido_venda');
        $this->db->where('calculo_necessidade_pedido.cod_calculo_necessidade', $codNecessidade);
        
        return $this->db->get()->result();

    }

    public function getNecessidadeProdutoPedido($codNecessidade){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('produto.cod_produto, sum(produto_venda.quant_pedida) quant_pedida, produto.quant_estoq, 
                           produto.tempo_abastecimento, pedido_venda.data_entrega, tipo_produto.origem_produto');        
        $this->db->from('produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->join('produto_venda', 'produto_venda.cod_produto = produto.cod_produto');
        $this->db->join('pedido_venda', 'pedido_venda.num_pedido_venda = produto_venda.num_pedido_venda');
        $this->db->join('calculo_necessidade_pedido', 'calculo_necessidade_pedido.num_pedido_venda = pedido_venda.num_pedido_venda');
        $this->db->where('calculo_necessidade_pedido.cod_calculo_necessidade', $codNecessidade);
        $this->db->group_by('produto_venda.cod_produto');
        $this->db->group_by('pedido_venda.data_entrega');
        $this->db->order_by('pedido_venda.data_entrega');

        return $this->db->get()->result();   

    }

    public function getCalcEstoqueProduto($codProduto, $dataNecessidade, $estoqueInicial){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('produto.cod_produto, IF(produto.quant_estoq > 0, produto.quant_estoq, 0) quant_estoq');
        $this->db->from('produto');
        $this->db->where('produto.cod_produto', $codProduto);   

        // Quantidade planejada de produção
        if($estoqueInicial == 1){            

            $this->db->select('(select IFNULL(sum(ordem_producao.quant_planejada), 0)
                                  from ordem_producao
                                 where ordem_producao.cod_produto = produto.cod_produto
                                   and ordem_producao.quant_produzida = 0
                                   and ordem_producao.id_empresa = ' . getDadosUsuarioLogado()['id_empresa'] . '
                                   and ordem_producao.data_fim < "' . $dataNecessidade . '") quant_ordem_producao');

        }else{

            $this->db->select('(select IFNULL(sum(ordem_producao.quant_planejada), 0)
                                  from ordem_producao
                                 where ordem_producao.cod_produto = produto.cod_produto
                                   and ordem_producao.quant_produzida = 0
                                   and ordem_producao.id_empresa = ' . getDadosUsuarioLogado()['id_empresa'] . '
                                   and ordem_producao.data_fim = "' . $dataNecessidade . '") quant_ordem_producao');

        }

        // Quantidade planejada de componente
        if($estoqueInicial == 1){

            $this->db->select('(select IFNULL(sum(componente_ordem_producao.quant_consumo), 0) 
                                  from componente_ordem_producao
                                  join ordem_producao on ordem_producao.num_ordem_producao = componente_ordem_producao.num_ordem_producao
                                 where componente_ordem_producao.cod_produto = produto.cod_produto
                                   and ordem_producao.quant_produzida = 0
                                   and ordem_producao.id_empresa = ' . getDadosUsuarioLogado()['id_empresa'] . '
                                   and ordem_producao.data_fim < "' . $dataNecessidade . '") quant_consumo_producao');

        }else{

            $this->db->select('(select IFNULL(sum(componente_ordem_producao.quant_consumo), 0)  
                                  from componente_ordem_producao
                                  join ordem_producao on ordem_producao.num_ordem_producao = componente_ordem_producao.num_ordem_producao
                                 where componente_ordem_producao.cod_produto = produto.cod_produto
                                   and ordem_producao.quant_produzida = 0
                                   and ordem_producao.id_empresa = ' . getDadosUsuarioLogado()['id_empresa'] . '
                                   and ordem_producao.data_fim = "' . $dataNecessidade . '") quant_consumo_producao');

        }

        // Quantidade planejada de compra
        if($estoqueInicial == 1){

            $this->db->select('(select IFNULL(sum(ordem_compra.quant_pedida), 0) 
                                  from ordem_compra
                                 where ordem_compra.cod_produto = produto.cod_produto
                                   and ordem_compra.quant_atendida = 0
                                   and ordem_compra.id_empresa = ' . getDadosUsuarioLogado()['id_empresa'] . '
                                   and ordem_compra.data_necessidade < "' . $dataNecessidade . '") quant_ordem_compra');

        }else{

            $this->db->select('(select IFNULL(sum(ordem_compra.quant_pedida), 0) 
                                  from ordem_compra
                                 where ordem_compra.cod_produto = produto.cod_produto
                                   and ordem_compra.quant_atendida = 0
                                   and ordem_compra.id_empresa = ' . getDadosUsuarioLogado()['id_empresa'] . '
                                   and ordem_compra.data_necessidade = "' . $dataNecessidade . '") quant_ordem_compra');

        } 
        
        // Quantidade planejada de venda
        if($estoqueInicial == 1){

            $this->db->select('(select IFNULL(sum(produto_venda.quant_pedida), 0) 
                                  from produto_venda
                                  join pedido_venda on pedido_venda.num_pedido_venda = produto_venda.num_pedido_venda 
                                 where produto_venda.cod_produto = produto.cod_produto                                  
                                   and produto_venda.quant_atendida = 0
                                   and produto_venda.status = 3
                                   and pedido_venda.id_empresa = ' . getDadosUsuarioLogado()['id_empresa'] . '
                                   and pedido_venda.data_entrega < "' . $dataNecessidade . '") quant_pedido_venda');

        }else{

            $this->db->select('(select IFNULL(sum(produto_venda.quant_pedida), 0) 
                                  from produto_venda
                                  join pedido_venda on pedido_venda.num_pedido_venda = produto_venda.num_pedido_venda 
                                 where produto_venda.cod_produto = produto.cod_produto                                  
                                   and produto_venda.quant_atendida = 0
                                   and produto_venda.status = 3
                                   and pedido_venda.id_empresa = ' . getDadosUsuarioLogado()['id_empresa'] . '
                                   and pedido_venda.data_entrega = "' . $dataNecessidade . '") quant_pedido_venda');

        }  

        return $this->db->get()->row(); 

    }

    public function getNecessidadeProdutoEstrutura($codProduto){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('estrutura_produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('estrutura_componente.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('estrutura_componente.*, produto.nome_produto, produto.cod_unidade_medida, 
                           produto.quant_estoq, tipo_produto.nome_tipo_produto, estrutura_produto.quant_producao, 
                           tipo_produto.origem_produto, produto.tempo_abastecimento');
        $this->db->from('estrutura_componente');
        $this->db->join('estrutura_produto', 'estrutura_produto.cod_produto = estrutura_componente.cod_produto');
        $this->db->join('produto', 'produto.cod_produto = estrutura_componente.cod_produto_componente');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->where('estrutura_componente.cod_produto', $codProduto);
        
        return $query = $this->db->get()->result();

    }

    public function deleteTotosPedidoCalculo($codCalculo) {
        $this->db->where_in('cod_calculo_necessidade',$codCalculo)->delete('calculo_necessidade_pedido');

        if($this->db->error() <> null){
            return $this->db->error();
        }

        return null;
    }

    public function updateCalculoNecessidade($cdoCalculo, $calculoNecessidade){
        $this->db->where('cod_calculo_necessidade', $cdoCalculo);
        $this->db->update('calculo_necessidade', $calculoNecessidade);

        if($this->db->error() <> null){
            return $this->db->error();
        }

        return null;
    }

    public function updateCalculoNecessidadeProduto($codCalculoProduto, $calculoNecessidadeProduto){
        $this->db->where('cod_calculo_necessidade_produto', $codCalculoProduto);
        $this->db->update('calculo_necessidade_produto', $calculoNecessidadeProduto);

        return null;
    }

    public function deletePedidoCalculo($pedidoVenda) {
        $this->db->where_in('num_pedido_venda',$pedidoVenda)->delete('calculo_necessidade_pedido');

        if($this->db->error() <> null){
            return $this->db->error();
        }

        return null;
    }

    public function deleteProdutoCalculo($codCalculoProduto) {
        $this->db->where_in('cod_calculo_necessidade_produto',$codCalculoProduto)->delete('calculo_necessidade_produto');

        if($this->db->error() <> null){
            return $this->db->error();
        }

        return null;
    }

    public function deleteCalculoNecessidadeProduto($cdoCalculo) {
        $this->db->where_in('cod_calculo_necessidade',$cdoCalculo)->delete('calculo_necessidade_produto');
    }

    //Indicadores
    public function getProdutoEstoque(){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('produto.*');
        $this->db->from('produto');
        $this->db->where('produto.quant_estoq > 0');
        $this->db->order_by('produto.quant_estoq', 'desc');

        return $query = $this->db->get()->result();        
    }    

    public function getMovimentoEstoque($dataInicio, $dataFim){
        $this->db->where('movimentos_estoque.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('tipo_produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('movimentos_estoque.*, produto.nome_produto, tipo_produto.nome_tipo_produto, produto.cod_unidade_medida,
                           sum(if(movimentos_estoque.tipo_movimento = 1, movimentos_estoque.quant_movimentada, 0)) total_entrada,
                           sum(if(movimentos_estoque.tipo_movimento = 2, movimentos_estoque.quant_movimentada, 0)) total_saida,
                           sum(if(movimentos_estoque.tipo_movimento = 1, movimentos_estoque.valor_movimento, 0)) valor_entrada,
                           sum(if(movimentos_estoque.tipo_movimento = 2, movimentos_estoque.valor_movimento, 0)) valor_saida');
        $this->db->from('movimentos_estoque');
        $this->db->join('produto', 'produto.cod_produto = movimentos_estoque.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->group_by('movimentos_estoque.cod_produto');

        $this->db->where("movimentos_estoque.data_movimento >= ", $dataInicio);
        $this->db->where("movimentos_estoque.data_movimento <= ", $dataFim);

        return $query = $this->db->get()->result();
    }

    //Avisos
    public function getAvisoEstoque(){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('tipo_produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('produto.*, tipo_produto.origem_produto');
        $this->db->from('produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->where('produto.quant_estoq < produto.estoq_min');

        return $query = $this->db->get()->result();
        
    }
    

}