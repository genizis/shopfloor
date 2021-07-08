<?php

class Vendas extends CI_Model{   

    public function insertPedidoVenda($pedidoVenda){
        $this->db->insert('pedido_venda', $pedidoVenda);

        return $this->db->insert_id();
    }

    public function insertProdutoVenda($produtoVenda){
        $this->db->insert('produto_venda', $produtoVenda);

        if($this->db->error() <> null){
            return $this->db->error();
        }

        return null;
    }

    public function insertFaturamento($faturamentoPedido){
        $this->db->insert('faturamento_pedido', $faturamentoPedido);        

        return $this->db->insert_id();
    }

    public function inserirControleCaixa($controleCaixa){
        $this->db->insert('controle_caixa', $controleCaixa);  
    }

    public function inserirMovimentoCaixa($movimentoCaixa){
        $this->db->insert('movimentos_frente_caixa', $movimentoCaixa);  
    }

    public function inserirVendaCaixa($vendaCaixa){
        $this->db->insert('venda_caixa', $vendaCaixa);        

        return $this->db->insert_id();
    }

    public function inserirProdutosCaixa($produtoVenda){
        $this->db->insert_batch('produto_venda_caixa', $produtoVenda);        

        return $this->db->insert_id();
    }

    public function inserirFormaPagamentoCaixa($formaPagamento){
        $this->db->insert_batch('metodo_pagamento_venda_caixa', $formaPagamento);        

        return $this->db->insert_id();
    }    
    
    /*public function insertMovimentos($movimentosProduto){
        $this->db->insert('movimentos_produto_venda', $movimentosProduto);
        $codMovimentoPV = $this->db->insert_id();

        $produtoVenda = $this->getProdutoVendaPorCodigo($movimentosProduto['seq_produto_venda']);

        if($produtoVenda->quant_atendida > 0){
            if(($produtoVenda->quant_atendida + $movimentosProduto['quant_saida']) >= $produtoVenda->quant_pedida) {
                $status = 3;
            }else{
                $status = 2;
            }            
        }else{
            if($movimentosProduto['quant_saida'] >= $produtoVenda->quant_pedida) {
                $status = 3;
            }else{
                $status = 2;
            } 
        }

        $dados = [
            'quant_atendida' => $produtoVenda->quant_atendida + $movimentosProduto['quant_saida'],
            'status' => $status
        ];

        $this->venda->updateProdutoVenda($movimentosProduto['seq_produto_venda'], $dados);

        return $codMovimentoPV;

    }*/

    public function updatePedidoVenda($numPedidoVenda, $pedidovenda){
        $this->db->where('num_pedido_venda', $numPedidoVenda);
        $this->db->update('pedido_venda', $pedidovenda);
    }

    public function updateControleCaixa($datacaixa, $controleCaixa){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('data_caixa', $datacaixa);
        $this->db->update('controle_caixa', $controleCaixa);
    }

    public function updateVendaCaixa($numVendaCaixa, $vendaCaixa){
        $this->db->where('num_venda_caixa', $numVendaCaixa);
        $this->db->update('venda_caixa', $vendaCaixa);
    }

    public function updateProdutoVenda($seqProdutoVenda, $produtovenda){
        $this->db->where('seq_produto_venda', $seqProdutoVenda);
        $this->db->update('produto_venda', $produtovenda);
    }

    public function updateFaturamento($codFaturamento, $faturamento){
        $this->db->where('cod_faturamento_pedido', $codFaturamento);
        $this->db->update('faturamento_pedido', $faturamento);
    }

    public function updateMovimento($codMovimento, $movimento){
        $this->db->where('cod_movimento_pv', $codMovimento);
        $this->db->update('movimentos_produto_venda', $movimento);
    }

    public function deleteProdutoVenda($SeqProdutoVenda) {
        $this->db->where_in('seq_produto_venda',$SeqProdutoVenda)->delete('produto_venda');
    }

    public function deleteProdutoVendaPorPedido($NumPedidoVenda) {
        $this->db->where_in('num_pedido_venda',$NumPedidoVenda)->delete('produto_venda');
    }    

    public function deletePedido($NumPedidoVenda) {
        $this->db->where_in('num_pedido_venda',$NumPedidoVenda)->delete('pedido_venda');
    }

    public function deleteProdutoVendaCaixa($numVendaCaixa) {
        $this->db->where_in('num_venda_caixa',$numVendaCaixa)->delete('produto_venda_caixa');
    }

    public function deleteFormaPagamento($numVendaCaixa) {
        $this->db->where_in('num_venda_caixa',$numVendaCaixa)->delete('metodo_pagamento_venda_caixa');
    }

    public function deleteVendaCaixa($numVendaCaixa) {
        $this->db->where_in('num_venda_caixa',$numVendaCaixa)->delete('venda_caixa');
    }

    public function deleteMovimentoCaixa($numVendaCaixa) {
        $this->db->where_in('cod_movimento_frente_caixa',$numVendaCaixa)->delete('movimentos_frente_caixa');
    }

    public function getPedidoVendaPorCodigo($numPedidoVenda){
        $this->db->where('pedido_venda.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('pedido_venda.*, cliente.nome_cliente');
        $this->db->select('(select sum(produto_venda.quant_atendida)
                              from produto_venda
                             where produto_venda.num_pedido_venda = pedido_venda.num_pedido_venda) quant_atendida');
        $this->db->select('(select sum(produto_venda.quant_pedida * produto_venda.valor_unitario) 
                             from produto_venda
                            where produto_venda.num_pedido_venda = pedido_venda.num_pedido_venda) valor_total_pedido');
        $this->db->from('pedido_venda');
        $this->db->join('cliente', 'cliente.cod_cliente = pedido_venda.cod_cliente');
        $this->db->where('pedido_venda.num_pedido_venda', $numPedidoVenda);
        
        return $query = $this->db->get()->row();

    }

    public function getPedidoPorDataEntrega($dataInicio, $dataFim){
        $this->db->where('pedido_venda.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('pedido_venda.*');
        $this->db->select('(select sum(produto_venda.quant_atendida)
                              from produto_venda
                             where produto_venda.num_pedido_venda = pedido_venda.num_pedido_venda) quant_atendida');
        $this->db->from('pedido_venda');
        $this->db->where('pedido_venda.data_entrega >=', $dataInicio);
        $this->db->where('pedido_venda.data_entrega <=', $dataFim);
        $this->db->where('pedido_venda.situacao', 3);
        
        return $this->db->get()->result();

    }

    public function getControleCaixaPorCodigo($dataVenda){
        $this->db->where('controle_caixa.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('controle_caixa.*');
        $this->db->select('(select sum(movimentos_frente_caixa.valor_movimento)
                              from movimentos_frente_caixa
                             where movimentos_frente_caixa.data_caixa = controle_caixa.data_caixa
                               and movimentos_frente_caixa.id_empresa = empresa.id_empresa
                               and movimentos_frente_caixa.tipo_movimento = 2) total_recolhimento');
        $this->db->select('(select sum(movimentos_frente_caixa.valor_movimento)
                              from movimentos_frente_caixa
                             where movimentos_frente_caixa.data_caixa = controle_caixa.data_caixa
                               and movimentos_frente_caixa.id_empresa = empresa.id_empresa
                               and movimentos_frente_caixa.tipo_movimento = 1) total_incremento');
        $this->db->select('(select sum(metodo_pagamento_venda_caixa.valor_pagamento) 
                             from venda_caixa
                             join metodo_pagamento_venda_caixa on metodo_pagamento_venda_caixa.num_venda_caixa = venda_caixa.num_venda_caixa
                            where venda_caixa.data_caixa = controle_caixa.data_caixa
                              and venda_caixa.id_empresa = empresa.id_empresa
                              and venda_caixa.status = 2
                              and metodo_pagamento_venda_caixa.cod_metodo_pagamento = empresa.metodo_pagamento_frente_caixa) total_venda');
        $this->db->select('(select sum(movimentos_estoque.valor_movimento)
                              from movimentos_estoque 
                              join venda_caixa on venda_caixa.num_venda_caixa = movimentos_estoque.id_origem
                             where movimentos_estoque.id_empresa = ' . getDadosUsuarioLogado()['id_empresa'] . '
                               and movimentos_estoque.origem_movimento = 6
                               and movimentos_estoque.tipo_movimento = 2
                               and venda_caixa.status = 2
                               and venda_caixa.data_caixa = controle_caixa.data_caixa) total_venda_geral');
        $this->db->select('(select sum(metodo_pagamento_venda_caixa.valor_pagamento) 
                             from venda_caixa
                             join metodo_pagamento_venda_caixa on metodo_pagamento_venda_caixa.num_venda_caixa = venda_caixa.num_venda_caixa
                            where venda_caixa.data_caixa = controle_caixa.data_caixa
                              and venda_caixa.id_empresa = controle_caixa.id_empresa
                              and venda_caixa.status = 2) total_venda_liquido');
        $this->db->from('controle_caixa');
        $this->db->join('empresa', 'empresa.id_empresa = controle_caixa.id_empresa');
        $this->db->where('controle_caixa.data_caixa', $dataVenda);
        
        return $this->db->get()->row();

    }

    public function getCaixaAberto(){
        $this->db->where('controle_caixa.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('controle_caixa.*');
        $this->db->from('controle_caixa');
        $this->db->where('controle_caixa.data_hora_fechamento is null');
        $this->db->where('controle_caixa.data_hora_abertura is not null');
        $this->db->limit(1);
        
        return $this->db->get()->row();

    }

    public function getVendaPorCodigoVendasExternas($codVendasExternas){
        $this->db->where('pedido_venda.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('pedido_venda.*');
        $this->db->from('pedido_venda');
        $this->db->where('pedido_venda.cod_vendas_externas', $codVendasExternas);
        
        return $query = $this->db->get()->row();

    }

    public function getPedidoVendaAprovPorCodigo($numPedidoVenda){
        $this->db->where('pedido_venda.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('pedido_venda.*, cliente.nome_cliente');
        $this->db->select('(select sum(produto_venda.valor_unitario * produto_venda.quant_pedida)
                              from produto_venda
                             where produto_venda.num_pedido_venda = pedido_venda.num_pedido_venda) valor_pedido');
        $this->db->select('(select sum(produto_venda.valor_unitario * (produto_venda.quant_pedida - produto_venda.quant_atendida))
                              from produto_venda
                             where produto_venda.num_pedido_venda = pedido_venda.num_pedido_venda) valor_pendente');
        $this->db->from('pedido_venda');
        $this->db->join('cliente', 'cliente.cod_cliente = pedido_venda.cod_cliente');
        $this->db->where('pedido_venda.num_pedido_venda', $numPedidoVenda);
        
        return $query = $this->db->get()->row();

    }

    public function getProdutoPorPedido($numPedidoVenda){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('produto_venda.*, produto.nome_produto, produto.cod_unidade_medida, 
                           produto.saldo_negativo, produto.quant_estoq, tipo_produto.nome_tipo_produto');
        $this->db->from('produto_venda');
        $this->db->join('produto', 'produto.cod_produto = produto_venda.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->where('produto_venda.num_pedido_venda', $numPedidoVenda);
        
        return $query = $this->db->get()->result();

    }

    public function getProdutoPorVendaCaixa($numVendaCaixa){
        $this->db->where('venda_caixa.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('produto_venda_caixa.*, produto.nome_produto, produto.cod_unidade_medida');
        $this->db->from('produto_venda_caixa');
        $this->db->join('venda_caixa', 'venda_caixa.num_venda_caixa = produto_venda_caixa.num_venda_caixa');
        $this->db->join('produto', 'produto.cod_produto = produto_venda_caixa.cod_produto');
        $this->db->where('produto_venda_caixa.num_venda_caixa', $numVendaCaixa);
        
        return $query = $this->db->get()->result();

    }

    public function getMetodoPagamentoPorVendaCaixa($numVendaCaixa){
        $this->db->where('venda_caixa.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('metodo_pagamento_venda_caixa.*, metodo_pagamento.nome_metodo_pagamento');
        $this->db->from('metodo_pagamento_venda_caixa');
        $this->db->join('venda_caixa', 'venda_caixa.num_venda_caixa = metodo_pagamento_venda_caixa.num_venda_caixa');
        $this->db->join('metodo_pagamento', 'metodo_pagamento.cod_metodo_pagamento = metodo_pagamento_venda_caixa.cod_metodo_pagamento');
        $this->db->where('metodo_pagamento_venda_caixa.num_venda_caixa', $numVendaCaixa);
        
        return $this->db->get()->result();

    }

    public function getMetodoPagamentoPorDataCaixa($dataCaixa){
        $this->db->where('venda_caixa.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('venda_caixa.data_caixa, metodo_pagamento_venda_caixa.cod_metodo_pagamento'); 
        $this->db->select('metodo_pagamento.nome_metodo_pagamento, metodo_pagamento.dias_recebimento, metodo_pagamento.taxa_operacao, metodo_pagamento.cod_conta');
        $this->db->select('sum(metodo_pagamento_venda_caixa.valor_pagamento) total_venda');
        $this->db->from('metodo_pagamento_venda_caixa');
        $this->db->join('metodo_pagamento', 'metodo_pagamento.cod_metodo_pagamento = metodo_pagamento_venda_caixa.cod_metodo_pagamento');
        $this->db->join('venda_caixa', 'venda_caixa.num_venda_caixa = metodo_pagamento_venda_caixa.num_venda_caixa');
        $this->db->where('venda_caixa.status', '2');
        $this->db->where('venda_caixa.data_caixa', $dataCaixa);
        $this->db->group_by('metodo_pagamento_venda_caixa.cod_metodo_pagamento');
        
        return $query = $this->db->get()->result();

    }

    public function getProdutoPorDataCaixa($dataCaixa){
        $this->db->where('venda_caixa.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('produto_venda_caixa.cod_produto'); 
        $this->db->select('produto.nome_produto, tipo_produto.nome_tipo_produto, sum(produto_venda_caixa.quant_venda) quant_venda');
        $this->db->select('sum(produto_venda_caixa.quant_venda * produto_venda_caixa.valor_unit) total_venda');
        $this->db->from('produto_venda_caixa');
        $this->db->join('produto', 'produto.cod_produto = produto_venda_caixa.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->join('venda_caixa', 'venda_caixa.num_venda_caixa = produto_venda_caixa.num_venda_caixa');
        $this->db->where('venda_caixa.status', '2');
        $this->db->where('venda_caixa.data_caixa', $dataCaixa);
        $this->db->group_by('produto_venda_caixa.cod_produto');
        $this->db->order_by('total_venda', 'desc');
        
        return $query = $this->db->get()->result();

    }

    public function getVendaCaixa($dataCaixa){
        $this->db->where('venda_caixa.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('venda_caixa.*, cliente.nome_cliente');
        $this->db->select('(select sum(metodo_pagamento_venda_caixa.valor_pagamento) 
                             from metodo_pagamento_venda_caixa
                            where metodo_pagamento_venda_caixa.num_venda_caixa = venda_caixa.num_venda_caixa) valor_total_pedido');
        $this->db->select('(select sum(metodo_pagamento_venda_caixa.valor_pagamento) 
                             from metodo_pagamento_venda_caixa
                            where metodo_pagamento_venda_caixa.num_venda_caixa = venda_caixa.num_venda_caixa
                              and metodo_pagamento_venda_caixa.cod_metodo_pagamento = empresa.metodo_pagamento_frente_caixa)  valor_dinheiro_pedido');
        $this->db->from('venda_caixa');
        $this->db->join('cliente', 'cliente.cod_cliente = venda_caixa.cod_cliente', 'left');
        $this->db->join('empresa', 'empresa.id_empresa = venda_caixa.id_empresa');
        $this->db->where('venda_caixa.data_caixa', $dataCaixa);
        
        return $query = $this->db->get()->result();

    }

    public function getVendasSalvas($dataCaixa){
        $this->db->where('venda_caixa.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('venda_caixa.*');
        $this->db->from('venda_caixa');
        $this->db->where('venda_caixa.data_caixa', $dataCaixa);
        $this->db->where('venda_caixa.status', '1');
        
        return $this->db->get()->result();

    }

    public function getMovimentoCaixa($dataCaixa){
        $this->db->where('movimentos_frente_caixa.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('movimentos_frente_caixa.*');
        $this->db->from('movimentos_frente_caixa');
        $this->db->where('movimentos_frente_caixa.data_caixa', $dataCaixa);
        
        return $query = $this->db->get()->result();

    }

    public function getPedidoVenda($filter = "", $limit = null, $offset = null){
        $this->db->where('pedido_venda.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        if($limit){
            $this->db->limit($limit, $offset);
        }

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
        $this->db->order_by('pedido_venda.data_entrega', 'desc');

        if($filter <> ""){
            $this->db->group_start();
            $this->db->or_like('num_pedido_venda' ,$filter);
            $this->db->or_like('pedido_venda.cod_cliente' ,$filter);
            $this->db->or_like('nome_cliente' ,$filter);
            $this->db->group_end();
            
        }
        
        return $query = $this->db->get()->result();
        
    }

    public function getPedidoVendaPorVendedor($filter = "", $limit = null, $offset = null){
        $this->db->where('pedido_venda.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('vendedor.nome_usuario', getDadosUsuarioLogado()['usuario']); 

        if($limit){
            $this->db->limit($limit, $offset);
        }

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
        $this->db->join('vendedor', 'vendedor.cod_vendedor = pedido_venda.cod_vendedor');
        $this->db->order_by('pedido_venda.data_entrega', 'desc');

        if($filter <> ""){
            $this->db->group_start();
            $this->db->or_like('num_pedido_venda' ,$filter);
            $this->db->or_like('pedido_venda.cod_cliente' ,$filter);
            $this->db->or_like('nome_cliente' ,$filter);
            $this->db->group_end();
            
        }
        
        return $query = $this->db->get()->result();
        
    }

    public function getPedidoVendaPendente(){
        $this->db->where('pedido_venda.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        //Join para pegar todas informações relativas à estrutura
        $this->db->select('pedido_venda.*, cliente.nome_cliente');
        $this->db->select('(select sum(produto_venda.valor_unitario * produto_venda.quant_pedida) 
                             from produto_venda
                            where produto_venda.num_pedido_venda = pedido_venda.num_pedido_venda) valor_total_pedido');
        $this->db->from('pedido_venda');
        $this->db->join('cliente', 'cliente.cod_cliente = pedido_venda.cod_cliente');
        $this->db->where('exists(select * from produto_venda
                                  where produto_venda.num_pedido_venda = pedido_venda.num_pedido_venda
                                    and produto_venda.status = 1)');
        $this->db->order_by('pedido_venda.data_entrega', 'asc');
        
        return $query = $this->db->get()->result();
        
    }

    public function getVendaTotal(){
        $this->db->where('pedido_venda.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('sum((select sum(movimentos_estoque.valor_movimento)
                              from movimentos_estoque
                             where movimentos_estoque.origem_movimento = 3
                               and movimentos_estoque.tipo_movimento = 2
                               and movimentos_estoque.id_origem = faturamento_pedido.cod_faturamento_pedido)) valor_total');
        $this->db->from('faturamento_pedido');
        $this->db->join('pedido_venda', 'pedido_venda.num_pedido_venda = faturamento_pedido.num_pedido_venda');
        $this->db->where('faturamento_pedido.estornado', '0');     
        $this->db->where('faturamento_pedido.data_faturamento >=', date('Y-m-01'));
        $this->db->where('faturamento_pedido.data_faturamento <=', date('Y-m-d')); 
        
        $pedidoVenda = $this->db->get_compiled_select();

        $this->db->where('controle_caixa.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('venda_caixa.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('sum((select sum(movimentos_estoque.valor_movimento)
                              from movimentos_estoque
                             where movimentos_estoque.origem_movimento = 6
                               and movimentos_estoque.tipo_movimento = 2
                               and movimentos_estoque.id_origem = venda_caixa.num_venda_caixa)) valor_total');
        $this->db->from('venda_caixa');
        $this->db->join('controle_caixa', 'controle_caixa.data_caixa = venda_caixa.data_caixa');
        $this->db->where('venda_caixa.status', '2');     
        $this->db->where('venda_caixa.data_caixa >=', date('Y-m-01'));
        $this->db->where('venda_caixa.data_caixa <=', date('Y-m-d')); 

        $frenteCaixa = $this->db->get_compiled_select();

        $this->db->select('sum(vendas.valor_total) valor_total');
        $this->db->from("($pedidoVenda UNION $frenteCaixa) vendas");

        return $this->db->get()->row();  
        
    }

    public function getPedidoVendaAprovado($filter = "", $limit = null, $offset = null){
        $this->db->where('pedido_venda.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        if($limit){
            $this->db->limit($limit, $offset);
        }

        //Join para pegar todas informações relativas à estrutura
        $this->db->select('pedido_venda.*, cliente.nome_cliente');
        $this->db->select('(select sum(produto_venda.quant_pedida * produto_venda.valor_unitario) 
                             from produto_venda
                            where produto_venda.num_pedido_venda = pedido_venda.num_pedido_venda) valor_total_pedido');
        $this->db->select('(select sum(produto_venda.quant_atendida * produto_venda.valor_unitario) 
                             from produto_venda
                            where produto_venda.num_pedido_venda = pedido_venda.num_pedido_venda) valor_total_faturado');
        $this->db->select('(select sum(faturamento_pedido.valor_desconto) 
                             from faturamento_pedido
                            where faturamento_pedido.num_pedido_venda = pedido_venda.num_pedido_venda
                              and faturamento_pedido.estornado = 0) total_desconto');
        $this->db->select('(select count(*)
                            from produto_venda
                           where produto_venda.num_pedido_venda = pedido_venda.num_pedido_venda) cont_produto');
        $this->db->from('pedido_venda');
        $this->db->join('cliente', 'cliente.cod_cliente = pedido_venda.cod_cliente');
        $this->db->where('pedido_venda.situacao', 3);
        $this->db->order_by('pedido_venda.num_pedido_venda', 'desc');

        if($filter <> ""){
            $this->db->group_start();
            $this->db->or_like('num_pedido_venda' ,$filter);
            $this->db->or_like('pedido_venda.cod_cliente' ,$filter);
            $this->db->or_like('nome_cliente' ,$filter);
            $this->db->group_end();
            
        }
        
        return $query = $this->db->get()->result();
        
    }

    public function getProdutoFaturadoPorPedido($numPedidoVenda){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('movimentos_estoque.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('movimentos_estoque.*, faturamento_pedido.cod_faturamento_pedido, produto.nome_produto, 
                           produto.cod_unidade_medida, tipo_produto.nome_tipo_produto, produto.cod_ncm, produto.cod_origem,
                           produto.cod_cest');
        $this->db->from('movimentos_estoque');
        $this->db->join('produto', 'produto.cod_produto = movimentos_estoque.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->join('faturamento_pedido', 'faturamento_pedido.cod_faturamento_pedido = movimentos_estoque.id_origem');
        $this->db->where('movimentos_estoque.origem_movimento', '3');
        $this->db->where('faturamento_pedido.num_pedido_venda', $numPedidoVenda);
        $this->db->where('faturamento_pedido.estornado', 0);
        $this->db->order_by('movimentos_estoque.cod_movimento_estoque', 'desc');  
        
        return $query = $this->db->get()->result();

    }

    public function getMovimentos($SeqProdutoVenda = null){  
        
        $this->db->where('movimentos_produto_venda.seq_produto_venda', $SeqProdutoVenda); 
        $this->db->where('movimentos_produto_venda.estornado', '0'); 
        return $query = $this->db->get('movimentos_produto_venda')->result();
        
    }

    public function getFaturamentosPorPedido($NumPedidoVenda){  

        $this->db->select('faturamento_pedido.*');
        $this->db->select('(select sum(movimentos_estoque.valor_movimento)
                              from movimentos_estoque
                             where movimentos_estoque.origem_movimento = 3
                               and movimentos_estoque.tipo_movimento = 2
                               and movimentos_estoque.id_origem = faturamento_pedido.cod_faturamento_pedido) valor_total');
        $this->db->from('faturamento_pedido');        
        $this->db->where('faturamento_pedido.num_pedido_venda', $NumPedidoVenda);
        $this->db->where('faturamento_pedido.estornado ', 0);

        return $query = $this->db->get()->result();
        
    }

    public function getFaturamentoPorCodigo($codFaturamentoPedido){

        $this->db->where('faturamento_pedido.cod_faturamento_pedido', $codFaturamentoPedido); 
        return $query = $this->db->get('faturamento_pedido')->row();

    }

    public function getMovimentoPorFaturamento($codFaturamentoPedido){
        $this->db->where('movimentos_estoque.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('movimentos_estoque.*');
        $this->db->from('movimentos_estoque');
        $this->db->where('movimentos_estoque.id_origem', $codFaturamentoPedido);
        $this->db->where('movimentos_estoque.origem_movimento', '3'); 
        
        return $query = $this->db->get()->result();

    }

    public function getMovimentosPorCodigo($codMovimentoPV = null){  
        
        $this->db->where('movimentos_produto_venda.cod_movimento_pv', $codMovimentoPV); 
        return $query = $this->db->get('movimentos_produto_venda')->row();
        
    }

    public function getVendaCaixaPorCodigo($numVendaCaixa){  


        $this->db->select('venda_caixa.*');
        $this->db->select('(select sum(produto_venda_caixa.quant_venda * produto_venda_caixa.valor_unit)
                              from produto_venda_caixa
                             where produto_venda_caixa.num_venda_caixa = venda_caixa.num_venda_caixa) sub_total');
        $this->db->from('venda_caixa');
        $this->db->where('venda_caixa.num_venda_caixa', $numVendaCaixa);  

        return $this->db->get()->row();
        
    }

    public function getProdutoVendaPorCodigo($numPedidoVenda, $codProduto){  
        
        $this->db->where('produto_venda.num_pedido_venda', $numPedidoVenda);
        $this->db->where('produto_venda.cod_produto', $codProduto); 
        return $query = $this->db->get('produto_venda')->row();
        
    }

    public function getCountProduto($numPedidoVenda){
        $this->db->select('count(*) as total_registro');
        $this->db->where('num_pedido_venda', $numPedidoVenda);
        $query = $this->db->get('produto_venda')->row();

        return $query->total_registro;
    }

    public function getVendasPeriodo(){
        $this->db->select("(select sum(movimentos_produto_venda.valor_venda)
                            from movimentos_produto_venda
                    inner join produto_venda on produto_venda.seq_produto_venda = movimentos_produto_venda.seq_produto_venda
                    inner join pedido_venda  on pedido_venda.num_pedido_venda = produto_venda.num_pedido_venda
                        where movimentos_produto_venda.estornado    = 0
                            and movimentos_produto_venda.data_saida   = CURRENT_DATE()
                            and pedido_venda.id_empresa         = " . getDadosUsuarioLogado()['id_empresa'] . ") vendas_hoje,
                        (select sum(movimentos_produto_venda.valor_venda)
                            from movimentos_produto_venda
                    inner join produto_venda on produto_venda.seq_produto_venda = movimentos_produto_venda.seq_produto_venda
                    inner join pedido_venda  on pedido_venda.num_pedido_venda = produto_venda.num_pedido_venda
                        where movimentos_produto_venda.estornado    = 0
                            and movimentos_produto_venda.data_saida   >= CAST(DATE_FORMAT(NOW() ,'%Y-%m-01') as DATE)
                            and pedido_venda.id_empresa         = " . getDadosUsuarioLogado()['id_empresa'] . ") vendas_mes,
                        (select sum(produto_venda.valor_unitario - movimentos_produto_venda.valor_venda)
                            from movimentos_produto_venda
                    inner join produto_venda on produto_venda.seq_produto_venda = movimentos_produto_venda.seq_produto_venda
                    inner join pedido_venda  on pedido_venda.num_pedido_venda = produto_venda.num_pedido_venda
                        where movimentos_produto_venda.estornado    = 0
                            and movimentos_produto_venda.data_saida   >= CAST(DATE_FORMAT(NOW() ,'%Y-%m-01') as DATE)
                            and pedido_venda.id_empresa         = " . getDadosUsuarioLogado()['id_empresa'] . ") previsao_faturamento
                    from dual");

        return $query = $this->db->get()->row();
    }

    public function getResultadoVenda(){

        $this->db->select("(select sum(reporte_producao.custo_producao)
                                from reporte_producao
                        inner join ordem_producao on ordem_producao.num_ordem_producao = reporte_producao.num_ordem_producao
                            where reporte_producao.estornado     = 0
                                and reporte_producao.data_reporte >= CAST(DATE_FORMAT(NOW() ,'%Y-%m-01') as DATE)
                                and ordem_producao.id_empresa      = " . getDadosUsuarioLogado()['id_empresa'] . ") producao,
                            (select sum(movimentos_produto_venda.valor_venda)
                                from movimentos_produto_venda
                        inner join produto_venda on produto_venda.seq_produto_venda = movimentos_produto_venda.seq_produto_venda
                        inner join pedido_venda  on pedido_venda.num_pedido_venda = produto_venda.num_pedido_venda
                            where movimentos_produto_venda.estornado    = 0
                                and movimentos_produto_venda.data_saida   >= CAST(DATE_FORMAT(NOW() ,'%Y-%m-01') as DATE)
                                and pedido_venda.id_empresa         = " . getDadosUsuarioLogado()['id_empresa'] . ") vendas
                        from dual");

        return $query = $this->db->get()->row();
    }

    public function getQuantPorStatus(){
        $this->db->where('pedido_venda.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('if(pedido_venda.data_entrega < curdate(), 4, 
        produto_venda.status) AS status_cont, count(produto_venda.seq_produto_venda) as num_produtos');
        $this->db->from('produto_venda');
        $this->db->join('pedido_venda', 'pedido_venda.num_pedido_venda = produto_venda.num_pedido_venda');
        $this->db->where('produto_venda.status !=', '3');
        $this->db->group_by('status_cont');

        return $query = $this->db->get()->result();

    }

    public function countAll(){
        $this->db->where('pedido_venda.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        return $this->db->count_all_results('pedido_venda');
    }  

    public function countAllVendasVendedor(){
        $this->db->where('pedido_venda.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('vendedor.nome_usuario', getDadosUsuarioLogado()['usuario']); 

        $this->db->join('vendedor', 'vendedor.cod_vendedor = pedido_venda.cod_vendedor');
        return $this->db->count_all_results('pedido_venda');
    } 
    
    public function countAllProduto(){
        $this->db->where('pedido_venda.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->where('pedido_venda.situacao', 3); 
        return $this->db->count_all_results('pedido_venda');
    }

    public function defineStatusPedido($listaPedidoVenda){

        $listaStatus = null;

        foreach($listaPedidoVenda as $key_pedido => $pedido){

            $somaStatus = $this->somaStatus($pedido->num_pedido_venda);
            $numsProduto = $this->getCountProduto($pedido->num_pedido_venda);

            if($numsProduto == 0){
                $status = 1;
            }elseif(($somaStatus / $numsProduto) == 1){
                $status = 1;
            }elseif(($somaStatus / $numsProduto) == 3){
                $status = 3;
            }elseif(($somaStatus / $numsProduto) == 4){
                $status = 4;
            }else{
                $status = 2;
            }

            $listaStatus[$pedido->num_pedido_venda] = $status;

        }

        if($listaStatus == null){

            return null;
            
        }
        
        return $listaStatus;

    }

    public function somaStatus($numPedidoVenda){
        $this->db->select_sum('status');
        $this->db->where('num_pedido_venda', $numPedidoVenda);
        $query = $this->db->get('produto_venda')->row();

        return $query->status;
    }

    //Relatórios
    public function totalVendaProduto($dataInicio, $dataFim, $codProdutos){        
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('movimentos_estoque.id_empresa', getDadosUsuarioLogado()['id_empresa']);         

        $this->db->select('sum(movimentos_estoque.valor_movimento) valor_total');
        $this->db->from('movimentos_estoque');
        $this->db->join('produto', 'produto.cod_produto = movimentos_estoque.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->join('faturamento_pedido', 'faturamento_pedido.cod_faturamento_pedido = movimentos_estoque.id_origem');
        $this->db->where('movimentos_estoque.origem_movimento', '3');
        $this->db->where('movimentos_estoque.tipo_movimento', '2');
        $this->db->where('faturamento_pedido.estornado', '0');

        $this->db->where("movimentos_estoque.data_movimento >= ", $dataInicio);
        $this->db->where("movimentos_estoque.data_movimento <= ", $dataFim);

        if($codProdutos != ""){
            $this->db->where_in('produto.cod_produto', $codProdutos);
        }

        $pedidoVenda = $this->db->get_compiled_select();

        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('movimentos_estoque.id_empresa', getDadosUsuarioLogado()['id_empresa']);         

        $this->db->select('sum(movimentos_estoque.valor_movimento) valor_total');
        $this->db->from('movimentos_estoque');
        $this->db->join('produto', 'produto.cod_produto = movimentos_estoque.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->join('venda_caixa', 'venda_caixa.num_venda_caixa = movimentos_estoque.id_origem');
        $this->db->where('movimentos_estoque.origem_movimento', '6');
        $this->db->where('movimentos_estoque.tipo_movimento', '2');
        $this->db->where('venda_caixa.status', '2');

        $this->db->where("movimentos_estoque.data_movimento >= ", $dataInicio);
        $this->db->where("movimentos_estoque.data_movimento <= ", $dataFim);

        if($codProdutos != ""){
            $this->db->where_in('produto.cod_produto', $codProdutos);
        }

        $frenteCaixa = $this->db->get_compiled_select();

        $this->db->select('sum(vendas.valor_total) valor_total');
        $this->db->from("($pedidoVenda UNION $frenteCaixa) vendas");

        return $this->db->get()->row();          

    }

    public function vendaResumida($dataInicio, $dataFim, $codProdutos){
        $this->db->where('pedido_venda.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('tipo_produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('movimentos_estoque.cod_produto, produto.nome_produto, tipo_produto.nome_tipo_produto, produto.cod_unidade_medida, 
                           sum(movimentos_estoque.quant_movimentada) quant_vendido, sum(movimentos_estoque.valor_movimento) total_vendido');
        $this->db->from('movimentos_estoque');
        $this->db->join('produto', 'produto.cod_produto = movimentos_estoque.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->join('faturamento_pedido', 'faturamento_pedido.cod_faturamento_pedido = movimentos_estoque.id_origem');
        $this->db->join('pedido_venda', 'pedido_venda.num_pedido_venda = faturamento_pedido.num_pedido_venda');
        $this->db->where('movimentos_estoque.origem_movimento', '3');
        $this->db->where('faturamento_pedido.estornado', '0');
        $this->db->group_by('movimentos_estoque.cod_produto');

        $this->db->where("movimentos_estoque.data_movimento >= ", $dataInicio);
        $this->db->where("movimentos_estoque.data_movimento <= ", $dataFim);

        if($codProdutos != ""){
            $this->db->where_in('produto.cod_produto', $codProdutos);
        }

        $pedidoVenda = $this->db->get_compiled_select();

        $this->db->where('controle_caixa.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('tipo_produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('movimentos_estoque.cod_produto, produto.nome_produto, tipo_produto.nome_tipo_produto, produto.cod_unidade_medida, 
                           sum(movimentos_estoque.quant_movimentada) quant_vendido, sum(movimentos_estoque.valor_movimento) total_vendido');
        $this->db->from('movimentos_estoque');
        $this->db->join('produto', 'produto.cod_produto = movimentos_estoque.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->join('venda_caixa', 'venda_caixa.num_venda_caixa = movimentos_estoque.id_origem');
        $this->db->join('controle_caixa', 'controle_caixa.data_caixa = venda_caixa.data_caixa');
        $this->db->where('movimentos_estoque.origem_movimento', '6');
        $this->db->where('venda_caixa.status', '2');
        $this->db->group_by('movimentos_estoque.cod_produto');

        $this->db->where("movimentos_estoque.data_movimento >= ", $dataInicio);
        $this->db->where("movimentos_estoque.data_movimento <= ", $dataFim);

        if($codProdutos != ""){
            $this->db->where_in('produto.cod_produto', $codProdutos);
        }

        $frenteCaixa = $this->db->get_compiled_select();

        $this->db->select('vendas.cod_produto, vendas.nome_produto, vendas.nome_tipo_produto, vendas.cod_unidade_medida, 
                           sum(vendas.quant_vendido) quant_vendido, sum(vendas.total_vendido) total_vendido');     
        //$this->db->query($pedidoVenda . ' UNION ' . $frenteCaixa);
        $this->db->from("($pedidoVenda UNION $frenteCaixa) vendas");
        $this->db->order_by('total_vendido', 'desc');
        $this->db->group_by('cod_produto');

        return $this->db->get()->result();

    }

    public function vendaDetalhada($dataInicio, $dataFim, $codProdutos){
        $this->db->where('pedido_venda.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('tipo_produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('"Pedido Venda" as tipo_venda, movimentos_estoque.data_movimento, pedido_venda.num_pedido_venda as pedido, faturamento_pedido.cod_faturamento_pedido as venda,
                           movimentos_estoque.cod_produto, produto.nome_produto, tipo_produto.nome_tipo_produto, produto.cod_unidade_medida, 
                           movimentos_estoque.quant_movimentada, movimentos_estoque.valor_movimento');
        $this->db->from('movimentos_estoque');
        $this->db->join('produto', 'produto.cod_produto = movimentos_estoque.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->join('faturamento_pedido', 'faturamento_pedido.cod_faturamento_pedido = movimentos_estoque.id_origem');
        $this->db->join('pedido_venda', 'pedido_venda.num_pedido_venda = faturamento_pedido.num_pedido_venda');
        $this->db->where('movimentos_estoque.origem_movimento', '3');
        $this->db->where('faturamento_pedido.estornado', '0');

        $this->db->where("movimentos_estoque.data_movimento >= ", $dataInicio);
        $this->db->where("movimentos_estoque.data_movimento <= ", $dataFim);

        if($codProdutos != ""){
            $this->db->where_in('produto.cod_produto', $codProdutos);
        }

        $pedidoVenda = $this->db->get_compiled_select();

        $this->db->where('controle_caixa.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('tipo_produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('"Frente de Caixa" as tipo_venda, movimentos_estoque.data_movimento, DATE_FORMAT(controle_caixa.data_caixa, "%d/%m/%Y") as pedido, venda_caixa.num_venda_caixa as venda,
                           movimentos_estoque.cod_produto, produto.nome_produto, tipo_produto.nome_tipo_produto, produto.cod_unidade_medida, 
                           movimentos_estoque.quant_movimentada, movimentos_estoque.valor_movimento');
        $this->db->from('movimentos_estoque');
        $this->db->join('produto', 'produto.cod_produto = movimentos_estoque.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->join('venda_caixa', 'venda_caixa.num_venda_caixa = movimentos_estoque.id_origem');
        $this->db->join('controle_caixa', 'controle_caixa.data_caixa = venda_caixa.data_caixa');
        $this->db->where('movimentos_estoque.origem_movimento', '6');
        $this->db->where('venda_caixa.status', '2');
        

        $this->db->where("movimentos_estoque.data_movimento >= ", $dataInicio);
        $this->db->where("movimentos_estoque.data_movimento <= ", $dataFim);

        if($codProdutos != ""){
            $this->db->where_in('produto.cod_produto', $codProdutos);
        }

        $frenteCaixa = $this->db->get_compiled_select();

        $this->db->select('vendas.tipo_venda, vendas.data_movimento, vendas.pedido, vendas.venda,
                           vendas.cod_produto, vendas.nome_produto, vendas.nome_tipo_produto, vendas.cod_unidade_medida, 
                           vendas.quant_movimentada, vendas.valor_movimento');  
        $this->db->from("($pedidoVenda UNION $frenteCaixa) vendas");
        $this->db->order_by('vendas.data_movimento', 'desc');

        return $this->db->get()->result();

    }

    public function totalVendaCliente($dataInicio, $dataFim, $codClientes){        
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('movimentos_estoque.id_empresa', getDadosUsuarioLogado()['id_empresa']);         

        $this->db->select('sum(movimentos_estoque.valor_movimento) valor_total, sum(faturamento_pedido.valor_desconto) total_desconto');
        $this->db->from('movimentos_estoque');
        $this->db->join('produto', 'produto.cod_produto = movimentos_estoque.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->join('faturamento_pedido', 'faturamento_pedido.cod_faturamento_pedido = movimentos_estoque.id_origem');
        $this->db->join('pedido_venda', 'pedido_venda.num_pedido_venda = faturamento_pedido.num_pedido_venda');
        $this->db->where('movimentos_estoque.origem_movimento', '3');
        $this->db->where('movimentos_estoque.tipo_movimento', '2');
        $this->db->where('faturamento_pedido.estornado', '0');

        $this->db->where("movimentos_estoque.data_movimento >= ", $dataInicio);
        $this->db->where("movimentos_estoque.data_movimento <= ", $dataFim);

        if($codClientes != ""){
            $this->db->where_in('pedido_venda.cod_cliente', $codClientes);
        }

        $pedidoVenda = $this->db->get_compiled_select();

        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('movimentos_estoque.id_empresa', getDadosUsuarioLogado()['id_empresa']);   
        $this->db->where('venda_caixa.id_empresa', getDadosUsuarioLogado()['id_empresa']);   
        $this->db->where('controle_caixa.id_empresa', getDadosUsuarioLogado()['id_empresa']);         

        $this->db->select('sum(movimentos_estoque.valor_movimento) valor_total, 
                           if(venda_caixa.tipo_desconto = 1, venda_caixa.valor_desconto, movimentos_estoque.valor_movimento * (venda_caixa.valor_desconto / 100)) total_desconto');
        $this->db->from('movimentos_estoque');
        $this->db->join('produto', 'produto.cod_produto = movimentos_estoque.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->join('venda_caixa', 'venda_caixa.num_venda_caixa = movimentos_estoque.id_origem');
        $this->db->join('controle_caixa', 'controle_caixa.data_caixa = venda_caixa.data_caixa');
        $this->db->where('movimentos_estoque.origem_movimento', '6');
        $this->db->where('movimentos_estoque.tipo_movimento', '2');
        $this->db->where('venda_caixa.status', '2');

        $this->db->where("movimentos_estoque.data_movimento >= ", $dataInicio);
        $this->db->where("movimentos_estoque.data_movimento <= ", $dataFim);

        if($codClientes != ""){
            $this->db->where_in('venda_caixa.cod_cliente', $codClientes);
        }

        $frenteCaixa = $this->db->get_compiled_select();

        $this->db->select('sum(vendas.valor_total) valor_total, sum(vendas.total_desconto) total_desconto');
        $this->db->from("($pedidoVenda UNION $frenteCaixa) vendas");

        return $this->db->get()->row();     

    }    

    public function clienteResumida($dataInicio, $dataFim, $codClientes){
        $this->db->where('pedido_venda.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('cliente.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('pedido_venda.cod_cliente, cliente.nome_cliente, cliente.cnpj_cpf, segmento.nome_segmento,
                           sum(faturamento_pedido.valor_desconto) total_desconto, sum(movimentos_estoque.valor_movimento) total_venda');
        $this->db->from('movimentos_estoque');
        $this->db->join('faturamento_pedido', 'faturamento_pedido.cod_faturamento_pedido = movimentos_estoque.id_origem');
        $this->db->join('pedido_venda', 'pedido_venda.num_pedido_venda = faturamento_pedido.num_pedido_venda');
        $this->db->join('cliente', 'cliente.cod_cliente = pedido_venda.cod_cliente');
        $this->db->join('segmento', 'segmento.cod_segmento = cliente.cod_segmento');
        $this->db->where('movimentos_estoque.origem_movimento', '3');
        $this->db->where('faturamento_pedido.estornado', '0');
        $this->db->group_by('pedido_venda.cod_cliente');

        $this->db->where("movimentos_estoque.data_movimento >= ", $dataInicio);
        $this->db->where("movimentos_estoque.data_movimento <= ", $dataFim);

        if($codClientes != ""){
            $this->db->where_in('pedido_venda.cod_cliente', $codClientes);
        }

        $pedidoVenda = $this->db->get_compiled_select();

        $this->db->where('venda_caixa.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('controle_caixa.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('venda_caixa.cod_cliente, cliente.nome_cliente, cliente.cnpj_cpf, segmento.nome_segmento,
                           if(venda_caixa.tipo_desconto = 1, venda_caixa.valor_desconto, movimentos_estoque.valor_movimento * (venda_caixa.valor_desconto / 100)) total_desconto, 
                           sum(movimentos_estoque.valor_movimento) total_venda');
        $this->db->from('movimentos_estoque');
        $this->db->join('venda_caixa', 'venda_caixa.num_venda_caixa = movimentos_estoque.id_origem');
        $this->db->join('controle_caixa', 'controle_caixa.data_caixa = venda_caixa.data_caixa');
        $this->db->join('cliente', 'cliente.cod_cliente = venda_caixa.cod_cliente and cliente.id_empresa = ' . getDadosUsuarioLogado()['id_empresa'], 'left');
        $this->db->join('segmento', 'segmento.cod_segmento = cliente.cod_segmento', 'left');
        $this->db->where('movimentos_estoque.origem_movimento', '6');
        $this->db->where('venda_caixa.status', '2');
        $this->db->group_by('venda_caixa.cod_cliente');

        $this->db->where("movimentos_estoque.data_movimento >= ", $dataInicio);
        $this->db->where("movimentos_estoque.data_movimento <= ", $dataFim);

        if($codClientes != ""){
            $this->db->where_in('venda_caixa.cod_cliente', $codClientes);
        }

        $frenteCaixa = $this->db->get_compiled_select();

        $this->db->select('vendas.cod_cliente, vendas.nome_cliente, vendas.cnpj_cpf, vendas.nome_segmento,
                           sum(vendas.total_desconto) total_desconto, sum(vendas.total_venda) total_venda'); 
        $this->db->from("($pedidoVenda UNION $frenteCaixa) vendas");
        $this->db->order_by('vendas.total_venda', 'desc');
        $this->db->group_by('vendas.cod_cliente');

        return $this->db->get()->result();

    }   

    public function clienteDetalhada($dataInicio, $dataFim, $codClientes){
        $this->db->where('pedido_venda.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('cliente.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('tipo_produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('cliente.cod_cliente, cliente.nome_cliente, movimentos_estoque.data_movimento, pedido_venda.num_pedido_venda as pedido, 
                           faturamento_pedido.cod_faturamento_pedido as venda, movimentos_estoque.cod_produto, produto.nome_produto, 
                           tipo_produto.nome_tipo_produto, produto.cod_unidade_medida, 
                           faturamento_pedido.valor_desconto, movimentos_estoque.quant_movimentada, movimentos_estoque.valor_movimento');
        $this->db->from('movimentos_estoque');
        $this->db->join('produto', 'produto.cod_produto = movimentos_estoque.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->join('faturamento_pedido', 'faturamento_pedido.cod_faturamento_pedido = movimentos_estoque.id_origem');
        $this->db->join('pedido_venda', 'pedido_venda.num_pedido_venda = faturamento_pedido.num_pedido_venda');
        $this->db->join('cliente', 'cliente.cod_cliente = pedido_venda.cod_cliente');
        $this->db->where('movimentos_estoque.origem_movimento', '3');
        $this->db->where('faturamento_pedido.estornado', '0');

        $this->db->where("movimentos_estoque.data_movimento >= ", $dataInicio);
        $this->db->where("movimentos_estoque.data_movimento <= ", $dataFim);

        if($codClientes != ""){
            $this->db->where_in('pedido_venda.cod_cliente', $codClientes);
        }

        $pedidoVenda = $this->db->get_compiled_select();

        $this->db->where('venda_caixa.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('controle_caixa.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('tipo_produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('cliente.cod_cliente, cliente.nome_cliente, movimentos_estoque.data_movimento, DATE_FORMAT(controle_caixa.data_caixa, "%d/%m/%Y") as pedido, venda_caixa.num_venda_caixa as venda,
                           movimentos_estoque.cod_produto, produto.nome_produto, tipo_produto.nome_tipo_produto, produto.cod_unidade_medida, 
                           if(venda_caixa.tipo_desconto = 1, venda_caixa.valor_desconto, movimentos_estoque.valor_movimento * (venda_caixa.valor_desconto / 100)) valor_desconto, 
                           movimentos_estoque.quant_movimentada, movimentos_estoque.valor_movimento');
        $this->db->from('movimentos_estoque');
        $this->db->join('produto', 'produto.cod_produto = movimentos_estoque.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->join('venda_caixa', 'venda_caixa.num_venda_caixa = movimentos_estoque.id_origem');
        $this->db->join('controle_caixa', 'controle_caixa.data_caixa = venda_caixa.data_caixa');
        $this->db->join('cliente', 'cliente.cod_cliente = venda_caixa.cod_cliente and cliente.id_empresa = ' . getDadosUsuarioLogado()['id_empresa'], 'left');
        $this->db->where('movimentos_estoque.origem_movimento', '6');
        $this->db->where('venda_caixa.status', '2');

        $this->db->where("movimentos_estoque.data_movimento >= ", $dataInicio);
        $this->db->where("movimentos_estoque.data_movimento <= ", $dataFim);

        if($codClientes != ""){
            $this->db->where_in('venda_caixa.cod_cliente', $codClientes);
        }

        $frenteCaixa = $this->db->get_compiled_select();

        $this->db->select('vendas.cod_cliente, vendas.nome_cliente, vendas.data_movimento, vendas.pedido as pedido, 
                           vendas.venda as venda, vendas.cod_produto, vendas.nome_produto, 
                           vendas.nome_tipo_produto, vendas.cod_unidade_medida, 
                           vendas.quant_movimentada, vendas.valor_desconto, vendas.valor_movimento');
        $this->db->from("($pedidoVenda UNION $frenteCaixa) vendas");
        $this->db->order_by('vendas.data_movimento', 'desc');
        $this->db->order_by('vendas.pedido', 'desc');

        return $this->db->get()->result();

    }

    public function totalVendaVendedor($dataInicio, $dataFim, $codVendedor){        
        $this->db->where('pedido_venda.id_empresa', getDadosUsuarioLogado()['id_empresa']);         

        $this->db->select('sum(faturamento_pedido.valor_bruto + faturamento_pedido.valor_frete - faturamento_pedido.valor_desconto) total_venda, 
                           sum(if(vendedor.cons_frete = 1, (faturamento_pedido.valor_bruto + faturamento_pedido.valor_frete - faturamento_pedido.valor_desconto),
                           (faturamento_pedido.valor_bruto - faturamento_pedido.valor_desconto)) * (pedido_venda.perc_comissao / 100)) total_comissao');
        $this->db->from('faturamento_pedido');  
        $this->db->join('pedido_venda', 'pedido_venda.num_pedido_venda = faturamento_pedido.num_pedido_venda');
        $this->db->join('vendedor', 'vendedor.cod_vendedor = pedido_venda.cod_vendedor');
        $this->db->where('faturamento_pedido.estornado', '0');

        $this->db->where("faturamento_pedido.data_faturamento >= ", $dataInicio);
        $this->db->where("faturamento_pedido.data_faturamento <= ", $dataFim);

        if($codVendedor != ""){
            $this->db->where_in('pedido_venda.cod_vendedor', $codVendedor);
        }

        return $query = $this->db->get()->row();        

    }

    public function vendedorResumida($dataInicio, $dataFim, $codVendedor){
        $this->db->where('pedido_venda.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('vendedor.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('pedido_venda.cod_vendedor, vendedor.nome_vendedor,
                           sum(faturamento_pedido.valor_bruto + faturamento_pedido.valor_frete - faturamento_pedido.valor_desconto) total_venda, 
                           sum(if(vendedor.cons_frete = 1, (faturamento_pedido.valor_bruto + faturamento_pedido.valor_frete - faturamento_pedido.valor_desconto),
                           (faturamento_pedido.valor_bruto - faturamento_pedido.valor_desconto)) * (pedido_venda.perc_comissao / 100)) total_comissao');
        $this->db->from('faturamento_pedido');
        $this->db->join('pedido_venda', 'pedido_venda.num_pedido_venda = faturamento_pedido.num_pedido_venda');
        $this->db->join('vendedor', 'vendedor.cod_vendedor = pedido_venda.cod_vendedor');
        $this->db->where('faturamento_pedido.estornado', '0');
        $this->db->group_by('pedido_venda.cod_vendedor');

        $this->db->where("faturamento_pedido.data_faturamento >= ", $dataInicio);
        $this->db->where("faturamento_pedido.data_faturamento <= ", $dataFim);

        if($codVendedor != ""){
            $this->db->where_in('pedido_venda.cod_vendedor', $codVendedor);
        }

        return $query = $this->db->get()->result();

    }

    public function vendedorDetalhada($dataInicio, $dataFim, $codVendedor){
        $this->db->where('pedido_venda.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('vendedor.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('pedido_venda.cod_vendedor, vendedor.nome_vendedor, cliente.cod_cliente, cliente.nome_cliente, pedido_venda.num_pedido_venda, 
                           faturamento_pedido.data_faturamento, faturamento_pedido.cod_faturamento_pedido, pedido_venda.perc_comissao,
                           sum(faturamento_pedido.valor_bruto + faturamento_pedido.valor_frete - faturamento_pedido.valor_desconto) total_venda, 
                           sum(if(vendedor.cons_frete = 1, (faturamento_pedido.valor_bruto + faturamento_pedido.valor_frete - faturamento_pedido.valor_desconto),
                           (faturamento_pedido.valor_bruto - faturamento_pedido.valor_desconto)) * (pedido_venda.perc_comissao / 100)) total_comissao');
        $this->db->from('faturamento_pedido');
        $this->db->join('pedido_venda', 'pedido_venda.num_pedido_venda = faturamento_pedido.num_pedido_venda');
        $this->db->join('vendedor', 'vendedor.cod_vendedor = pedido_venda.cod_vendedor');
        $this->db->join('cliente', 'cliente.cod_cliente = pedido_venda.cod_cliente');
        $this->db->where('faturamento_pedido.estornado', '0');
        $this->db->where('pedido_venda.cod_vendedor !=', null);
        $this->db->order_by('faturamento_pedido.data_faturamento', 'desc');
        $this->db->group_by('faturamento_pedido.cod_faturamento_pedido');

        $this->db->where("faturamento_pedido.data_faturamento >= ", $dataInicio);
        $this->db->where("faturamento_pedido.data_faturamento <= ", $dataFim);

        if($codVendedor != ""){
            $this->db->where_in('pedido_venda.cod_vendedor', $codVendedor);
        }

        return $query = $this->db->get()->result();

    }

    //Indicadores
    public function getVendasDiaria($dataInicio, $dataFim){

        $this->db->select('tim.db_date as data,
                            tim.month_name as nome_mes,
                        IFNULL(venda.quant_venda, 0) as venda_dia,
                        IFNULL(venda.quant_desconto, 0) as desconto_dia                          
                        from time_dimension tim');
        $this->db->join('(
                            SELECT movimentos_estoque.data_movimento, sum(movimentos_estoque.valor_movimento) as quant_venda,
                                   sum(faturamento_pedido.valor_desconto) as quant_desconto
                            FROM movimentos_estoque 
                            JOIN faturamento_pedido ON faturamento_pedido.cod_faturamento_pedido = movimentos_estoque.id_origem
                            where movimentos_estoque.id_empresa = ' . getDadosUsuarioLogado()['id_empresa'] . '
                              and movimentos_estoque.origem_movimento = 3
                              and faturamento_pedido.estornado = 0
                            GROUP BY movimentos_estoque.data_movimento
                            UNION
                            SELECT movimentos_estoque.data_movimento, sum(movimentos_estoque.valor_movimento) as quant_venda,
                            if(venda_caixa.tipo_desconto = 1, venda_caixa.valor_desconto, movimentos_estoque.valor_movimento * (venda_caixa.valor_desconto / 100)) as quant_desconto
                            FROM movimentos_estoque 
                            JOIN venda_caixa ON venda_caixa.num_venda_caixa = movimentos_estoque.id_origem
                            where movimentos_estoque.id_empresa = ' . getDadosUsuarioLogado()['id_empresa'] . '
                              and movimentos_estoque.origem_movimento = 6
                              and movimentos_estoque.tipo_movimento = 2
                              and venda_caixa.status = 2
                            GROUP BY movimentos_estoque.data_movimento
                        ) as venda', 'venda on venda.data_movimento = tim.db_date ', 'left');
        $this->db->where('tim.db_date <= CURRENT_DATE()');
        $this->db->order_by('tim.db_date', 'asc');

        $this->db->where("tim.db_date >= ", $dataInicio);
        $this->db->where("tim.db_date <= ", $dataFim);

        return $query = $this->db->get()->result();   
    }

    public function getVendaProduto($dataInicio, $dataFim){
        $this->db->where('pedido_venda.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('movimentos_estoque.cod_produto, produto.nome_produto, produto.cod_unidade_medida,
                           sum(movimentos_estoque.quant_movimentada) as quant_vendido, 
                           sum(movimentos_estoque.valor_movimento) as valor_vendido');
        $this->db->from('movimentos_estoque');
        $this->db->join('produto', 'produto.cod_produto = movimentos_estoque.cod_produto');
        $this->db->join('faturamento_pedido', 'faturamento_pedido.cod_faturamento_pedido = movimentos_estoque.id_origem');
        $this->db->join('pedido_venda', 'pedido_venda.num_pedido_venda = faturamento_pedido.num_pedido_venda');
        $this->db->where('movimentos_estoque.origem_movimento', '3');
        $this->db->where('faturamento_pedido.estornado', '0');
        $this->db->group_by('movimentos_estoque.cod_produto');        

        $this->db->where("movimentos_estoque.data_movimento >= ", $dataInicio);
        $this->db->where("movimentos_estoque.data_movimento <= ", $dataFim);

        $pedidoVenda = $this->db->get_compiled_select();

        $this->db->where('controle_caixa.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('movimentos_estoque.cod_produto, produto.nome_produto, produto.cod_unidade_medida,
                           sum(movimentos_estoque.quant_movimentada) as quant_vendido, 
                           sum(movimentos_estoque.valor_movimento) as valor_vendido');
        $this->db->from('movimentos_estoque');
        $this->db->join('produto', 'produto.cod_produto = movimentos_estoque.cod_produto');
        $this->db->join('venda_caixa', 'venda_caixa.num_venda_caixa = movimentos_estoque.id_origem');
        $this->db->join('controle_caixa', 'controle_caixa.data_caixa = venda_caixa.data_caixa');
        $this->db->where('movimentos_estoque.origem_movimento', '6');
        $this->db->where('venda_caixa.status', '2');
        $this->db->group_by('movimentos_estoque.cod_produto');

        $this->db->where("movimentos_estoque.data_movimento >= ", $dataInicio);
        $this->db->where("movimentos_estoque.data_movimento <= ", $dataFim);
         

        $frenteCaixa = $this->db->get_compiled_select();

        $this->db->select('vendas.cod_produto, vendas.nome_produto, vendas.cod_unidade_medida,
                           sum(vendas.quant_vendido) as quant_vendido, 
                           sum(vendas.valor_vendido) as valor_vendido');
        $this->db->from("($pedidoVenda UNION $frenteCaixa) vendas");
        $this->db->group_by('vendas.cod_produto');
        $this->db->order_by('sum(vendas.valor_vendido)', 'desc');

        return $this->db->get()->result();

    }

    public function getVendaCliente($dataInicio, $dataFim){
        $this->db->where('pedido_venda.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('cliente.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('pedido_venda.cod_cliente, cliente.nome_cliente,
                           sum(movimentos_estoque.quant_movimentada) quant_venda, sum(movimentos_estoque.valor_movimento) total_venda,
                           sum(faturamento_pedido.valor_desconto) total_desconto');
        $this->db->from('movimentos_estoque');
        $this->db->join('faturamento_pedido', 'faturamento_pedido.cod_faturamento_pedido = movimentos_estoque.id_origem');
        $this->db->join('pedido_venda', 'pedido_venda.num_pedido_venda = faturamento_pedido.num_pedido_venda');
        $this->db->join('cliente', 'cliente.cod_cliente = pedido_venda.cod_cliente');
        $this->db->where('movimentos_estoque.origem_movimento', '3');
        $this->db->where('faturamento_pedido.estornado', '0');
        $this->db->group_by('pedido_venda.cod_cliente');

        $this->db->where("movimentos_estoque.data_movimento >= ", $dataInicio);
        $this->db->where("movimentos_estoque.data_movimento <= ", $dataFim);

        $pedidoVenda = $this->db->get_compiled_select();

        $this->db->where('controle_caixa.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('venda_caixa.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('venda_caixa.cod_cliente, cliente.nome_cliente,
                           sum(movimentos_estoque.quant_movimentada) quant_venda, sum(movimentos_estoque.valor_movimento) total_venda,
                           if(venda_caixa.tipo_desconto = 1, venda_caixa.valor_desconto, movimentos_estoque.valor_movimento * (venda_caixa.valor_desconto / 100)) total_desconto');
        $this->db->from('movimentos_estoque');
        $this->db->join('venda_caixa', 'venda_caixa.num_venda_caixa = movimentos_estoque.id_origem');
        $this->db->join('controle_caixa', 'controle_caixa.data_caixa = venda_caixa.data_caixa');
        $this->db->join('cliente', 'cliente.cod_cliente = venda_caixa.cod_cliente and cliente.id_empresa = ' . getDadosUsuarioLogado()['id_empresa'], 'left');
        $this->db->where('movimentos_estoque.origem_movimento', '6');
        $this->db->where('venda_caixa.status', '2');
        $this->db->group_by('venda_caixa.cod_cliente');

        $this->db->where("movimentos_estoque.data_movimento >= ", $dataInicio);
        $this->db->where("movimentos_estoque.data_movimento <= ", $dataFim);
         

        $frenteCaixa = $this->db->get_compiled_select();

        $this->db->select('vendas.cod_cliente, vendas.nome_cliente,
                           sum(vendas.quant_venda) quant_venda, sum(vendas.total_venda) total_venda,
                           sum(vendas.total_desconto) total_desconto');
        $this->db->from("($pedidoVenda UNION $frenteCaixa) vendas");
        $this->db->group_by('vendas.cod_cliente');
        $this->db->order_by('sum(vendas.total_venda)', 'desc');

        return $this->db->get()->result();

    }

    public function getVendaVendedor($dataInicio, $dataFim){
        $this->db->where('pedido_venda.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('vendedor.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('pedido_venda.cod_vendedor, vendedor.nome_vendedor,
                           sum(movimentos_estoque.valor_movimento) total_venda,
                           sum(movimentos_estoque.valor_movimento * (pedido_venda.perc_comissao / 100)) total_comissao');
        $this->db->from('movimentos_estoque');
        $this->db->join('faturamento_pedido', 'faturamento_pedido.cod_faturamento_pedido = movimentos_estoque.id_origem');
        $this->db->join('pedido_venda', 'pedido_venda.num_pedido_venda = faturamento_pedido.num_pedido_venda');
        $this->db->join('vendedor', 'vendedor.cod_vendedor = pedido_venda.cod_vendedor');
        $this->db->where('movimentos_estoque.origem_movimento', '3');
        $this->db->where('faturamento_pedido.estornado', '0');
        $this->db->group_by('pedido_venda.cod_vendedor');
        $this->db->order_by('sum(movimentos_estoque.valor_movimento)', 'desc');

        $this->db->where("movimentos_estoque.data_movimento >= ", $dataInicio);
        $this->db->where("movimentos_estoque.data_movimento <= ", $dataFim);

        return $query = $this->db->get()->result();

    }

    public function getVendaClienteVisaoGeral(){
        $this->db->where('pedido_venda.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('cliente.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('pedido_venda.cod_cliente, cliente.nome_cliente,
                           sum(movimentos_estoque.valor_movimento) total_venda');
        $this->db->from('movimentos_estoque');
        $this->db->join('faturamento_pedido', 'faturamento_pedido.cod_faturamento_pedido = movimentos_estoque.id_origem');
        $this->db->join('pedido_venda', 'pedido_venda.num_pedido_venda = faturamento_pedido.num_pedido_venda');
        $this->db->join('cliente', 'cliente.cod_cliente = pedido_venda.cod_cliente');
        $this->db->where('movimentos_estoque.origem_movimento', '3');
        $this->db->where('movimentos_estoque.valor_movimento !=', 0);
        $this->db->where('faturamento_pedido.estornado', '0');
        $this->db->where('faturamento_pedido.data_faturamento >=', date('Y-m-01'));
        $this->db->where('faturamento_pedido.data_faturamento <=', date('Y-m-d')); 
        $this->db->group_by('pedido_venda.cod_cliente'); 
        
        $pedidoVenda = $this->db->get_compiled_select();

        $this->db->where('controle_caixa.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('venda_caixa.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('venda_caixa.cod_cliente, cliente.nome_cliente,
                           sum(movimentos_estoque.valor_movimento) total_venda');
        $this->db->from('movimentos_estoque');
        $this->db->join('venda_caixa', 'venda_caixa.num_venda_caixa = movimentos_estoque.id_origem');
        $this->db->join('controle_caixa', 'controle_caixa.data_caixa = venda_caixa.data_caixa');
        $this->db->join('cliente', 'cliente.cod_cliente = venda_caixa.cod_cliente and cliente.id_empresa = ' . getDadosUsuarioLogado()['id_empresa'], 'left');
        $this->db->where('movimentos_estoque.origem_movimento', '6');
        $this->db->where('movimentos_estoque.valor_movimento !=', 0);
        $this->db->where('venda_caixa.status', '2');
        $this->db->where('controle_caixa.data_caixa >=', date('Y-m-01'));
        $this->db->where('controle_caixa.data_caixa <=', date('Y-m-d')); 
        $this->db->group_by('venda_caixa.cod_cliente');
         

        $frenteCaixa = $this->db->get_compiled_select();

        $this->db->select('vendas.cod_cliente, vendas.nome_cliente,
                           sum(vendas.total_venda) total_venda');
        $this->db->from("($pedidoVenda UNION $frenteCaixa) vendas");
        $this->db->group_by('vendas.cod_cliente');
        $this->db->order_by('sum(vendas.total_venda)', 'desc');
        $this->db->limit(3); 

        return $this->db->get()->result();        

    }

}