<?php

class Compras extends CI_Model{

    public function insertOrdemCompra($ordemCompra){
        $this->db->insert('ordem_compra', $ordemCompra);
    }

    public function insertPedidoCompra($pedidoCompra){
        $this->db->insert('pedido_compra', $pedidoCompra);

        return $this->db->insert_id();
    }

    public function insertRecebimentoMaterial($recebimentoMaterial){
        $this->db->insert('recebimento_material', $recebimentoMaterial);

        return $this->db->insert_id();        

    }

    public function deleteOrdemCompra($NumOrdem) {
        $this->db->where_in('num_ordem_compra',$NumOrdem)->delete('ordem_compra');
    }  
    
    public function deletePedidoCompra($NumPedido) {
        $this->db->where_in('num_pedido_compra',$NumPedido)->delete('pedido_compra');
    }
    
    public function updateOrdemCompra($NumOrdem, $ordem){
        $this->db->where('num_ordem_compra', $NumOrdem);
        $this->db->update('ordem_compra', $ordem);
    }

    public function updateOrdemCompraArray($NumOrdem, $ordem) {
        $this->db->where_in('num_ordem_compra',$NumOrdem)->update('ordem_compra', $ordem);
    }

    public function updateMovimento($codMovimento, $movimento){       

        $this->db->where('cod_movimento_oc', $codMovimento);
        $this->db->update('movimentos_ordem_compra', $movimento);
    }

    public function updateRecebimento($codRecebimento, $recebimento){       

        $this->db->where('cod_recebimento_material', $codRecebimento);
        $this->db->update('recebimento_material', $recebimento);
    }

    public function updatePedidoCompra($numPedidoCompraa, $pedidocompra){
        $this->db->where('num_pedido_compra', $numPedidoCompraa);
        $this->db->update('pedido_compra', $pedidocompra);
    }

    public function getOrdem($filter = "", $select = "OrdensSemPedido", $limit = null, $offset = null){
        $this->db->where('ordem_compra.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        if($limit){
            $this->db->limit($limit, $offset);
        }

        //Join para pegar o tipo de produto
        $this->db->select('ordem_compra.*, produto.nome_produto, produto.cod_unidade_medida');
        $this->db->from('ordem_compra');
        $this->db->join('produto', 'produto.cod_produto = ordem_compra.cod_produto'); 
        $this->db->order_by('ordem_compra.num_ordem_compra', 'desc');       

        if($filter <> ""){
            $this->db->group_start();
            $this->db->or_like('ordem_compra.num_ordem_compra' ,$filter);
            $this->db->or_like('ordem_compra.cod_produto' ,$filter);
            $this->db->or_like('nome_produto' ,$filter);
            $this->db->or_like('cod_unidade_medida' ,$filter);
            $this->db->group_end();
            
        }

        if($select == "OrdensSemPedido"){
            $this->db->where('ordem_compra.num_pedido_compra is null');
        }elseif($select == "OrdensComPedido"){
            $this->db->where('ordem_compra.num_pedido_compra is not null');
        }
        
        return $query = $this->db->get()->result();
        
    }

    public function getOrdemCompraoPorCalculoNecessidade($codCalculo){
        $this->db->where('ordem_compra.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        //Join para pegar o tipo de produto
        $this->db->select('ordem_compra.*');
        $this->db->from('ordem_compra');
        $this->db->where('cod_calculo_necessidade', $codCalculo);
        
        return $this->db->get()->result();
        
    }

    public function getPedido($filter = "", $limit = null, $offset = null){
        $this->db->where('pedido_compra.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('fornecedor.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        if($limit){
            $this->db->limit($limit, $offset);
        }

        //Join para pegar o tipo de produto
        $this->db->select('pedido_compra.*, fornecedor.nome_fornecedor');
        $this->db->select('(select sum(ordem_compra.valor_unitario * ordem_compra.quant_pedida)
                              from ordem_compra
                             where ordem_compra.num_pedido_compra = pedido_compra.num_pedido_compra) valor_total');        
        $this->db->select('(select sum(ordem_compra.quant_pedida - ordem_compra.quant_atendida)
                              from ordem_compra
                             where ordem_compra.num_pedido_compra = pedido_compra.num_pedido_compra
                               and ordem_compra.status != 3) quant_pendente');
        $this->db->select('(select count(*)
                              from recebimento_material
                             where recebimento_material.num_pedido_compra = pedido_compra.num_pedido_compra
                               and recebimento_material.estornado = 1) estornado');
        $this->db->from('pedido_compra');
        $this->db->join('fornecedor', 'fornecedor.cod_fornecedor = pedido_compra.cod_fornecedor'); 
        $this->db->order_by('pedido_compra.num_pedido_compra', 'desc');       

        if($filter <> ""){
            $this->db->group_start();
            $this->db->or_like('pedido_compra.num_pedido_compra' ,$filter);
            $this->db->or_like('pedido_compra.cod_fornecedor' ,$filter);
            $this->db->or_like('fornecedor.nome_fornecedor' ,$filter);
            $this->db->group_end();
            
        }
        
        return $query = $this->db->get()->result();
        
    }

    public function getPedidoRecebimento($filter = "", $limit = null, $offset = null){
        $this->db->where('pedido_compra.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('fornecedor.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        if($limit){
            $this->db->limit($limit, $offset);
        }

        //Join para pegar o tipo de produto
        $this->db->select('pedido_compra.*, fornecedor.nome_fornecedor');
        $this->db->select('(select sum(ordem_compra.valor_unitario * ordem_compra.quant_pedida)
                              from ordem_compra
                             where ordem_compra.num_pedido_compra = pedido_compra.num_pedido_compra) valor_total');        
        $this->db->select('(select sum(ordem_compra.quant_pedida - ordem_compra.quant_atendida)
                              from ordem_compra
                             where ordem_compra.num_pedido_compra = pedido_compra.num_pedido_compra
                               and ordem_compra.status != 3) quant_pendente');
        $this->db->select('(select count(*)
                              from recebimento_material
                             where recebimento_material.num_pedido_compra = pedido_compra.num_pedido_compra
                               and recebimento_material.estornado = 1) estornado');
        $this->db->from('pedido_compra');
        $this->db->join('fornecedor', 'fornecedor.cod_fornecedor = pedido_compra.cod_fornecedor'); 
        $this->db->where("exists (select * from ordem_compra where ordem_compra.num_pedido_compra = pedido_compra.num_pedido_compra)");
        $this->db->order_by('pedido_compra.num_pedido_compra', 'desc');       

        if($filter <> ""){
            $this->db->group_start();
            $this->db->or_like('pedido_compra.num_pedido_compra' ,$filter);
            $this->db->or_like('pedido_compra.cod_fornecedor' ,$filter);
            $this->db->or_like('fornecedor.nome_fornecedor' ,$filter);
            $this->db->group_end();
            
        }
        
        return $query = $this->db->get()->result();
        
    }

    public function getPedidoCompraPorCodigo($numPedidoCompra){
        $this->db->where('pedido_compra.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('pedido_compra.*, fornecedor.nome_fornecedor');
        $this->db->select('(select sum(ordem_compra.valor_unitario * ordem_compra.quant_pedida)
                              from ordem_compra
                             where ordem_compra.num_pedido_compra = pedido_compra.num_pedido_compra) valor_pedido');
        $this->db->select('(select sum(ordem_compra.valor_unitario * (ordem_compra.quant_pedida - ordem_compra.quant_atendida))
                              from ordem_compra
                             where ordem_compra.num_pedido_compra = pedido_compra.num_pedido_compra) valor_pendente');
        $this->db->from('pedido_compra');
        $this->db->join('fornecedor', 'fornecedor.cod_fornecedor = pedido_compra.cod_fornecedor');
        $this->db->where('pedido_compra.num_pedido_compra', $numPedidoCompra);
        
        return $query = $this->db->get()->row();

    }

    public function getOrdemPorPedido($numPedidoCompra){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('ordem_compra.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('pedido_compra.*, ordem_compra.num_ordem_compra, ordem_compra.quant_pedida, ordem_compra.quant_atendida, ordem_compra.valor_unitario, 
                           ordem_compra.cod_produto, ordem_compra.data_necessidade, ordem_compra.status, ordem_compra.observacoes,
                        produto.nome_produto, produto.cod_unidade_medida, tipo_produto.nome_tipo_produto');
        $this->db->from('pedido_compra');
        $this->db->join('ordem_compra', 'ordem_compra.num_pedido_compra = pedido_compra.num_pedido_compra');
        $this->db->join('produto', 'produto.cod_produto = ordem_compra.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->where('pedido_compra.num_pedido_compra', $numPedidoCompra);
        $this->db->order_by('ordem_compra.data_necessidade', 'asc');
        
        return $query = $this->db->get()->result();

    }

    public function getOrdemPorProdutoPedido($codProduto, $numPedidoCompra, $ordem){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('ordem_compra.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('pedido_compra.*, ordem_compra.num_ordem_compra, ordem_compra.quant_pedida, ordem_compra.quant_atendida, ordem_compra.valor_unitario, 
                           ordem_compra.cod_produto, ordem_compra.data_necessidade, ordem_compra.status, ordem_compra.observacoes,
                        produto.nome_produto, produto.cod_unidade_medida, tipo_produto.nome_tipo_produto');
        $this->db->from('pedido_compra');
        $this->db->join('ordem_compra', 'ordem_compra.num_pedido_compra = pedido_compra.num_pedido_compra');
        $this->db->join('produto', 'produto.cod_produto = ordem_compra.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->where('pedido_compra.num_pedido_compra', $numPedidoCompra);
        $this->db->where('ordem_compra.cod_produto', $codProduto);
        $this->db->order_by('ordem_compra.data_necessidade', $ordem);
        
        return $query = $this->db->get()->result();

    }

    public function getProdutoPedido($numPedidoCompra){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('ordem_compra.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('ordem_compra.cod_produto, produto.nome_produto, tipo_produto.nome_tipo_produto,
                           produto.cod_unidade_medida, sum(ordem_compra.quant_pedida) quant_pedida, sum(ordem_compra.quant_atendida) quant_recebida, sum(ordem_compra.valor_unitario * ordem_compra.quant_pedida) total_compra');
        $this->db->from('pedido_compra');
        $this->db->join('ordem_compra', 'ordem_compra.num_pedido_compra = pedido_compra.num_pedido_compra');
        $this->db->join('produto', 'produto.cod_produto = ordem_compra.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->where('pedido_compra.num_pedido_compra', $numPedidoCompra);
        $this->db->group_by('ordem_compra.cod_produto');
        
        return $query = $this->db->get()->result();

    }

    public function getOrdemSemPedido(){
        $this->db->where('ordem_compra.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        //Join para pegar o tipo de produto
        $this->db->select('ordem_compra.*, produto.nome_produto');
        $this->db->from('ordem_compra');
        $this->db->join('produto', 'produto.cod_produto = ordem_compra.cod_produto');
        $this->db->where('ordem_compra.num_pedido_compra is null');        
        
        return $query = $this->db->get()->result();
        
    }

    public function getOrdemAberta($filter = "", $limit = null, $offset = null){
        $this->db->where('ordem_compra.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        if($limit){
            $this->db->limit($limit, $offset);
        }

        //Join para pegar o tipo de produto
        $this->db->select('ordem_compra.*, produto.nome_produto, produto.cod_unidade_medida');
        $this->db->from('ordem_compra');
        $this->db->join('produto', 'produto.cod_produto = ordem_compra.cod_produto');
        $this->db->where('ordem_compra.status !=', '3');        

        if($filter <> ""){
            $this->db->group_start();
            $this->db->or_like('ordem_compra.num_ordem_compra' ,$filter);
            $this->db->or_like('ordem_compra.cod_produto' ,$filter);
            $this->db->or_like('nome_produto' ,$filter);
            $this->db->or_like('cod_unidade_medida' ,$filter);
            $this->db->group_end();
            
        }
        
        return $query = $this->db->get()->result();
        
    }

    public function getRecebimentos($numPedidoCompra){       

        //Join para pegar o tipo de produto
        $this->db->select('recebimento_material.*');
        $this->db->select('(select sum(movimentos_estoque.valor_movimento)
                              from movimentos_estoque
                             where movimentos_estoque.origem_movimento = 2
                               and movimentos_estoque.id_origem = recebimento_material.cod_recebimento_material) valor_total');
        $this->db->from('recebimento_material');
        $this->db->where('recebimento_material.estornado', '0'); 
        $this->db->where('recebimento_material.num_pedido_compra', $numPedidoCompra);  
        $this->db->order_by('recebimento_material.cod_recebimento_material', 'desc');
        
        return $query = $this->db->get()->result();
        
    }

    public function getRecebimentoPorPedido($numPedidoCompra){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('movimentos_estoque.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('movimentos_estoque.*, recebimento_material.cod_recebimento_material, produto.nome_produto, produto.cod_unidade_medida, tipo_produto.nome_tipo_produto');
        $this->db->from('movimentos_estoque');
        $this->db->join('produto', 'produto.cod_produto = movimentos_estoque.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->join('recebimento_material', 'recebimento_material.cod_recebimento_material = movimentos_estoque.id_origem');
        $this->db->where('movimentos_estoque.origem_movimento', '2');
        $this->db->where('recebimento_material.num_pedido_compra', $numPedidoCompra);
        $this->db->order_by('movimentos_estoque.cod_movimento_estoque', 'desc');  
        
        return $query = $this->db->get()->result();

    }

    public function getMovimentoPorRecebimento($codRecebimento){
        $this->db->where('movimentos_estoque.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('movimentos_estoque.*');
        $this->db->from('movimentos_estoque');
        $this->db->where('movimentos_estoque.id_origem', $codRecebimento);
        $this->db->where('movimentos_estoque.origem_movimento', '2'); 
        
        return $query = $this->db->get()->result();

    }

    public function getOrdemPorQuantPedida(){
        $this->db->where('ordem_compra.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('ordem_compra.cod_produto, produto.nome_produto, sum(ordem_compra.quant_pedida) as pedida, sum(ordem_compra.quant_atendida) recebida');
        $this->db->from('ordem_compra');
        $this->db->join('produto', 'produto.cod_produto = ordem_compra.cod_produto');
        $this->db->where('ordem_compra.status !=', '3');
        $this->db->group_by('ordem_compra.cod_produto');
        $this->db->order_by('pedida', 'desc');
        $this->db->limit(5);

        return $query = $this->db->get()->result();

    }    

    public function selectOrdem($NumOrdem){

        $ordem_compra = $this->getOrdemCompraPorCodigo($NumOrdem);

        $dataNecessidade = str_replace('-', '/', date("d-m-Y", strtotime($ordem_compra->data_necessidade)));
        $quantPedida = number_format($ordem_compra->quant_pedida, 3, ',', '.');
        $valorUnitario = number_format($ordem_compra->custo_medio, 2, ',', '.');
        $valorTotal = number_format($ordem_compra->quant_pedida * $ordem_compra->custo_medio, 2, ',', '.');

        $input = "{$ordem_compra->nome_tipo_produto}|{$ordem_compra->cod_unidade_medida}|{$dataNecessidade}|{$quantPedida}|{$valorUnitario}|{$valorTotal}|{$ordem_compra->observacoes}";

        return $input;

    } 

    public function countAllOrdem($select = "OrdensSemPedido"){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        if($select == "OrdensSemPedido"){
            $this->db->where('ordem_compra.num_pedido_compra is null');
        }elseif($select == "OrdensComPedido"){
            $this->db->where('ordem_compra.num_pedido_compra is not null');
        }

        return $this->db->count_all_results('ordem_compra');
    }

    public function countAllPedido(){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        return $this->db->count_all_results('pedido_compra');
    }

    public function countAllPedidoRecebimento(){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where("exists (select * from ordem_compra where ordem_compra.num_pedido_compra = pedido_compra.num_pedido_compra)");

        return $this->db->count_all_results('pedido_compra');
    }

    public function countAllOrdemAberta(){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $query = $this->db->where('status !=', '3')->get('ordem_compra');
        return $query->num_rows();

    }   

    public function getOrdemCompraPorCodigo($NumOrdem){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('ordem_compra.*, produto.nome_produto, produto.cod_unidade_medida, produto.custo_medio, tipo_produto.nome_tipo_produto');
        $this->db->join('produto', 'produto.cod_produto = ordem_compra.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        return $this->db->get_where('ordem_compra', array('num_ordem_compra' => $NumOrdem))->row();
        
        return $query = $this->db->get()->row();

    }  
    
    public function getRecebimentoPorCodigo($codRecebimento){  
        
        $this->db->where('recebimento_material.cod_recebimento_material', $codRecebimento); 
        return $query = $this->db->get('recebimento_material')->row();
        
    }

    public function getOrdemCompraPendente(){
        $this->db->where('ordem_compra.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        //Join para pegar o tipo de produto
        $this->db->select('ordem_compra.*, produto.nome_produto, produto.cod_unidade_medida');
        $this->db->from('ordem_compra');
        $this->db->join('produto', 'produto.cod_produto = ordem_compra.cod_produto');  
        $this->db->where('status !=', '3'); 
        $this->db->order_by('data_necessidade', 'asc'); 
        $this->db->limit(5);
        
        return $query = $this->db->get()->result();

    }

    public function getPedidoCompraPendente(){
        $this->db->where('pedido_compra.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        //Join para pegar o tipo de produto
        $this->db->select('pedido_compra.*, fornecedor.nome_fornecedor');
        $this->db->select('(select sum(ordem_compra.valor_unitario * ordem_compra.quant_pedida) 
                             from ordem_compra
                            where ordem_compra.num_pedido_compra = pedido_compra.num_pedido_compra) valor_total_pedido');
        $this->db->from('pedido_compra');
        $this->db->join('fornecedor', 'fornecedor.cod_fornecedor = pedido_compra.cod_fornecedor');
        $this->db->where('exists(select * from ordem_compra
                                  where ordem_compra.num_pedido_compra = pedido_compra.num_pedido_compra
                                    and ordem_compra.status = 1)');
        $this->db->order_by('pedido_compra.data_entrega', 'asc');
        
        return $query = $this->db->get()->result();

    }

    public function getCompraTotal(){
        $this->db->where('pedido_compra.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('sum((select sum(movimentos_estoque.valor_movimento)
                              from movimentos_estoque
                             where movimentos_estoque.origem_movimento = 2
                               and movimentos_estoque.id_origem = recebimento_material.cod_recebimento_material)) valor_total');
        $this->db->from('recebimento_material');
        $this->db->join('pedido_compra', 'pedido_compra.num_pedido_compra = recebimento_material.num_pedido_compra');
        $this->db->where('recebimento_material.estornado', '0');     
        $this->db->where('recebimento_material.data_recebimento >=', date('Y-m-01'));
        $this->db->where('recebimento_material.data_recebimento <=', date('Y-m-d')); 
        
        return $query = $this->db->get()->row();
        
    }

    public function getCompraFornecedorVisaoGeral(){
        $this->db->where('pedido_compra.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('fornecedor.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('pedido_compra.cod_fornecedor, fornecedor.nome_fornecedor,
                           sum(movimentos_estoque.valor_movimento) total_compra');
        $this->db->from('movimentos_estoque');
        $this->db->join('recebimento_material', 'recebimento_material.cod_recebimento_material = movimentos_estoque.id_origem');
        $this->db->join('pedido_compra', 'pedido_compra.num_pedido_compra = recebimento_material.num_pedido_compra');
        $this->db->join('fornecedor', 'fornecedor.cod_fornecedor = pedido_compra.cod_fornecedor');
        $this->db->where('movimentos_estoque.origem_movimento', '2');
        $this->db->where('movimentos_estoque.valor_movimento !=', '0');
        $this->db->where('recebimento_material.estornado', '0');
        $this->db->where('recebimento_material.data_recebimento >=', date('Y-m-01'));
        $this->db->where('recebimento_material.data_recebimento <=', date('Y-m-d')); 
        $this->db->group_by('pedido_compra.cod_fornecedor');
        $this->db->order_by('sum(movimentos_estoque.valor_movimento)', 'desc');
        $this->db->limit(3);        

        return $query = $this->db->get()->result();

    }

    //Relatórios
    public function getTotalCompra($dataInicio, $dataFim, $codProdutos){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('movimentos_estoque.id_empresa', getDadosUsuarioLogado()['id_empresa']);         

        $this->db->select('sum(movimentos_estoque.valor_movimento) valor_total, sum(recebimento_material.valor_desconto) valor_desconto');
        $this->db->from('movimentos_estoque');
        $this->db->join('produto', 'produto.cod_produto = movimentos_estoque.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->join('recebimento_material', 'recebimento_material.cod_recebimento_material = movimentos_estoque.id_origem');
        $this->db->where('movimentos_estoque.origem_movimento', '2');
        $this->db->where('recebimento_material.estornado', '0');

        $this->db->where("movimentos_estoque.data_movimento >= ", $dataInicio);
        $this->db->where("movimentos_estoque.data_movimento <= ", $dataFim);

        if($codProdutos != ""){
            $this->db->where_in('produto.cod_produto', $codProdutos);
        }

        return $query = $this->db->get()->row();

    }

    public function compraResumida($dataInicio, $dataFim, $codProdutos){
        $this->db->where('pedido_compra.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('tipo_produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('movimentos_estoque.cod_produto, produto.nome_produto, tipo_produto.nome_tipo_produto, produto.cod_unidade_medida, 
                           sum(movimentos_estoque.quant_movimentada) quant_comprada, sum(movimentos_estoque.valor_movimento) total_compra');
        $this->db->from('movimentos_estoque');
        $this->db->join('produto', 'produto.cod_produto = movimentos_estoque.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->join('recebimento_material', 'recebimento_material.cod_recebimento_material = movimentos_estoque.id_origem');
        $this->db->join('pedido_compra', 'pedido_compra.num_pedido_compra = recebimento_material.num_pedido_compra');
        $this->db->where('movimentos_estoque.origem_movimento', '2');
        $this->db->where('recebimento_material.estornado', '0');
        $this->db->group_by('movimentos_estoque.cod_produto');

        $this->db->where("movimentos_estoque.data_movimento >= ", $dataInicio);
        $this->db->where("movimentos_estoque.data_movimento <= ", $dataFim);

        if($codProdutos != ""){
            $this->db->where_in('produto.cod_produto', $codProdutos);
        }

        return $query = $this->db->get()->result();

    }

    public function compraDetalhada($dataInicio, $dataFim, $codProdutos){
        $this->db->where('pedido_compra.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('tipo_produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('movimentos_estoque.data_movimento, pedido_compra.num_pedido_compra, recebimento_material.cod_recebimento_material,
                           movimentos_estoque.cod_produto, produto.nome_produto, tipo_produto.nome_tipo_produto, produto.cod_unidade_medida, 
                           movimentos_estoque.quant_movimentada, movimentos_estoque.valor_movimento');
        $this->db->from('movimentos_estoque');
        $this->db->join('produto', 'produto.cod_produto = movimentos_estoque.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->join('recebimento_material', 'recebimento_material.cod_recebimento_material = movimentos_estoque.id_origem');
        $this->db->join('pedido_compra', 'pedido_compra.num_pedido_compra = recebimento_material.num_pedido_compra');
        $this->db->where('movimentos_estoque.origem_movimento', '2');
        $this->db->where('recebimento_material.estornado', '0');
        $this->db->order_by('movimentos_estoque.data_movimento', 'desc');

        $this->db->where("movimentos_estoque.data_movimento >= ", $dataInicio);
        $this->db->where("movimentos_estoque.data_movimento <= ", $dataFim);

        if($codProdutos != ""){
            $this->db->where_in('produto.cod_produto', $codProdutos);
        }

        return $query = $this->db->get()->result();

    }

    public function getTotalCompraFornecedor($dataInicio, $dataFim, $codFornecedores){
        $this->db->where('pedido_compra.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('movimentos_estoque.id_empresa', getDadosUsuarioLogado()['id_empresa']);         

        $this->db->select('sum(movimentos_estoque.valor_movimento) valor_total, sum(recebimento_material.valor_desconto) valor_desconto');
        $this->db->from('movimentos_estoque');
        $this->db->join('recebimento_material', 'recebimento_material.cod_recebimento_material = movimentos_estoque.id_origem');
        $this->db->join('pedido_compra', 'pedido_compra.num_pedido_compra = recebimento_material.num_pedido_compra');
        $this->db->where('movimentos_estoque.origem_movimento', '2');
        $this->db->where('recebimento_material.estornado', '0');

        $this->db->where("movimentos_estoque.data_movimento >= ", $dataInicio);
        $this->db->where("movimentos_estoque.data_movimento <= ", $dataFim);

        if($codFornecedores != ""){
            $this->db->where_in('pedido_compra.cod_fornecedor', $codFornecedores);
        }

        return $query = $this->db->get()->row();

    }

    public function fornecedorResumida($dataInicio, $dataFim, $codFornecedores){
        $this->db->where('pedido_compra.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('fornecedor.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('pedido_compra.cod_fornecedor, fornecedor.nome_fornecedor, fornecedor.cnpj_cpf, segmento.nome_segmento,
                           sum(movimentos_estoque.quant_movimentada) quant_comprada, sum(movimentos_estoque.valor_movimento) total_compra');
        $this->db->from('movimentos_estoque');
        $this->db->join('recebimento_material', 'recebimento_material.cod_recebimento_material = movimentos_estoque.id_origem');
        $this->db->join('pedido_compra', 'pedido_compra.num_pedido_compra = recebimento_material.num_pedido_compra');
        $this->db->join('fornecedor', 'fornecedor.cod_fornecedor = pedido_compra.cod_fornecedor');
        $this->db->join('segmento', 'segmento.cod_segmento = fornecedor.cod_segmento');
        $this->db->where('movimentos_estoque.origem_movimento', '2');
        $this->db->where('recebimento_material.estornado', '0');
        $this->db->group_by('pedido_compra.cod_fornecedor');

        $this->db->where("movimentos_estoque.data_movimento >= ", $dataInicio);
        $this->db->where("movimentos_estoque.data_movimento <= ", $dataFim);

        if($codFornecedores != ""){
            $this->db->where_in('pedido_compra.cod_fornecedor', $codFornecedores);
        }

        return $query = $this->db->get()->result();

    }

    public function fornecedorDetalhada($dataInicio, $dataFim, $codFornecedores){
        $this->db->where('pedido_compra.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('fornecedor.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('tipo_produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('fornecedor.cod_fornecedor, fornecedor.nome_fornecedor, movimentos_estoque.data_movimento, pedido_compra.num_pedido_compra, 
                           recebimento_material.cod_recebimento_material, movimentos_estoque.cod_produto, produto.nome_produto, 
                           tipo_produto.nome_tipo_produto, produto.cod_unidade_medida, 
                           movimentos_estoque.quant_movimentada, movimentos_estoque.valor_movimento');
        $this->db->from('movimentos_estoque');
        $this->db->join('produto', 'produto.cod_produto = movimentos_estoque.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->join('recebimento_material', 'recebimento_material.cod_recebimento_material = movimentos_estoque.id_origem');
        $this->db->join('pedido_compra', 'pedido_compra.num_pedido_compra = recebimento_material.num_pedido_compra');
        $this->db->join('fornecedor', 'fornecedor.cod_fornecedor = pedido_compra.cod_fornecedor');
        $this->db->where('movimentos_estoque.origem_movimento', '2');
        $this->db->where('recebimento_material.estornado', '0');
        $this->db->order_by('movimentos_estoque.data_movimento', 'desc');

        $this->db->where("movimentos_estoque.data_movimento >= ", $dataInicio);
        $this->db->where("movimentos_estoque.data_movimento <= ", $dataFim);

        if($codFornecedores != ""){
            $this->db->where_in('pedido_compra.cod_fornecedor', $codFornecedores);
        }

        return $query = $this->db->get()->result();

    }

    //Indicadores
    // Para o gráfico
    public function getComprasDiaria($dataInicio, $dataFim){

        $this->db->select('tim.db_date as data,
                            tim.month_name as nome_mes,
                        IFNULL(compra.quant_comprada, 0) as compra_dia                        
                        from time_dimension tim');
        $this->db->join('(
                            SELECT movimentos_estoque.data_movimento, sum(movimentos_estoque.valor_movimento) as quant_comprada
                            FROM movimentos_estoque 
                            JOIN recebimento_material ON recebimento_material.cod_recebimento_material = movimentos_estoque.id_origem
                            where movimentos_estoque.id_empresa = ' . getDadosUsuarioLogado()['id_empresa'] . '
                              and movimentos_estoque.origem_movimento = 2
                              and recebimento_material.estornado = 0
                            GROUP BY movimentos_estoque.data_movimento 
                        ) as compra', 'compra on compra.data_movimento = tim.db_date ', 'left');
        $this->db->where('tim.db_date <= CURRENT_DATE()');
        $this->db->order_by('tim.db_date', 'asc');

        $this->db->where("tim.db_date >= ", $dataInicio);
        $this->db->where("tim.db_date <= ", $dataFim);

        return $query = $this->db->get()->result();   
    }

    public function getCompraPendente($dataInicio, $dataFim){
        $this->db->where('ordem_compra.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('sum((ordem_compra.quant_pedida - ordem_compra.quant_atendida) * ordem_compra.valor_unitario) valor_pendente');
        $this->db->from('ordem_compra');
        $this->db->where('ordem_compra.num_pedido_compra is not null');
        $this->db->where('ordem_compra.status != 3');

        return $query = $this->db->get()->row();
    }

    public function getCompraProduto($dataInicio, $dataFim){
        $this->db->where('pedido_compra.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('movimentos_estoque.cod_produto, produto.nome_produto, produto.cod_unidade_medida,
                           sum(movimentos_estoque.quant_movimentada) as quant_comprada, 
                           sum(movimentos_estoque.valor_movimento) as valor_comprado');
        $this->db->from('movimentos_estoque');
        $this->db->join('produto', 'produto.cod_produto = movimentos_estoque.cod_produto');
        $this->db->join('recebimento_material', 'recebimento_material.cod_recebimento_material = movimentos_estoque.id_origem');
        $this->db->join('pedido_compra', 'pedido_compra.num_pedido_compra = recebimento_material.num_pedido_compra');
        $this->db->where('movimentos_estoque.origem_movimento', '2');
        $this->db->where('recebimento_material.estornado', '0');
        $this->db->group_by('movimentos_estoque.cod_produto');
        $this->db->order_by('sum(movimentos_estoque.valor_movimento)', 'desc');

        $this->db->where("movimentos_estoque.data_movimento >= ", $dataInicio);
        $this->db->where("movimentos_estoque.data_movimento <= ", $dataFim);

        return $query = $this->db->get()->result();

    }

    public function getCompraFornecedor($dataInicio, $dataFim){
        $this->db->where('pedido_compra.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('fornecedor.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('pedido_compra.cod_fornecedor, fornecedor.nome_fornecedor,
                           sum(movimentos_estoque.quant_movimentada) quant_comprada, sum(movimentos_estoque.valor_movimento) total_compra');
        $this->db->from('movimentos_estoque');
        $this->db->join('recebimento_material', 'recebimento_material.cod_recebimento_material = movimentos_estoque.id_origem');
        $this->db->join('pedido_compra', 'pedido_compra.num_pedido_compra = recebimento_material.num_pedido_compra');
        $this->db->join('fornecedor', 'fornecedor.cod_fornecedor = pedido_compra.cod_fornecedor');
        $this->db->join('segmento', 'segmento.cod_segmento = fornecedor.cod_segmento');
        $this->db->where('movimentos_estoque.origem_movimento', '2');
        $this->db->where('recebimento_material.estornado', '0');
        $this->db->group_by('pedido_compra.cod_fornecedor');
        $this->db->order_by('sum(movimentos_estoque.valor_movimento)', 'desc');

        $this->db->where("movimentos_estoque.data_movimento >= ", $dataInicio);
        $this->db->where("movimentos_estoque.data_movimento <= ", $dataFim);

        return $query = $this->db->get()->result();

    }

}