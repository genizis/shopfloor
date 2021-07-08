<?php

class Financeiro extends CI_Model{

    public function insertMovimentoConta($movimentoFinanceiro){
        $this->db->insert('movimentos_conta', $movimentoFinanceiro);
        $titulo = $this->db->insert_id();

        // Atualiza saldo da conta
        $conta = $this->getContaPorCodigo($movimentoFinanceiro['cod_conta']);

        if($movimentoFinanceiro['confirmado'] == 1) {

            if($movimentoFinanceiro['tipo_movimento'] == 1) {

                $saldoConta = $conta->saldo_conta + $movimentoFinanceiro['valor_confirmado'];

            }elseif($movimentoFinanceiro['tipo_movimento'] == 2) {

                $saldoConta = $conta->saldo_conta - $movimentoFinanceiro['valor_confirmado'];

            }

            $dados = [
                'saldo_conta' => $saldoConta
            ];
    
            $this->updateConta($conta->cod_conta, $dados);
        }  
        
        return $titulo;
    }

    public function insertConta($conta){
        $this->db->insert('conta', $conta);

        return $this->db->insert_id();
    }

    public function insertMetodoPagamento($metodo){
        $this->db->insert('metodo_pagamento', $metodo);

        return $this->db->insert_id();
    }

    public function insertCentroCusto($centroCusto){
        $this->db->insert('centro_custo', $centroCusto);

        return $this->db->insert_id();
    }

    public function insertContaContabil($ContaContabil){
        $this->db->insert('conta_contabil', $ContaContabil);

        return $this->db->insert_id();
    } 

    public function updateConta($codConta, $conta){
        $this->db->where('cod_conta', $codConta);
        $this->db->update('conta', $conta);
    } 
    
    public function updateMetodoPagamento($codMetodoPagamento, $metodo){
        $this->db->where('cod_metodo_pagamento', $codMetodoPagamento);
        $this->db->update('metodo_pagamento', $metodo);
    } 

    public function updateCentroCusto($codCentroCusto, $centroCusto){
        $this->db->where('cod_centro_custo', $codCentroCusto);
        $this->db->update('centro_custo', $centroCusto);
    }

    public function updateContaContabil($codContaContabil, $ContaContabil){
        $this->db->where('cod_conta_contabil', $codContaContabil);
        $this->db->update('conta_contabil', $ContaContabil);
    }

    public function updateMovimentoConta($codMovimento, $movimentoFinanceiro, $original = true){

        $movimento = $this->getMovimentoPorCodigo($codMovimento);
        
        $codConta = $movimentoFinanceiro['cod_conta'];

        // Atualiza saldo da conta
        $conta = $this->getContaPorCodigo($codConta);

        if($movimento->confirmado == 0 && $movimentoFinanceiro['confirmado'] == 1) {

            if($movimento->tipo_movimento == 1) {

                $saldoConta = $conta->saldo_conta + $movimentoFinanceiro['valor_confirmado'];

            }elseif($movimento->tipo_movimento == 2) {

                $saldoConta = $conta->saldo_conta - $movimentoFinanceiro['valor_confirmado'];

            }

            $dados = [
                'saldo_conta' => $saldoConta
            ];    
            $this->updateConta($codConta, $dados);

        }elseif($movimento->confirmado == 1 && $movimentoFinanceiro['confirmado'] == 0) {

            if($movimento->tipo_movimento == 1) {

                $saldoConta = $conta->saldo_conta - $movimento->valor_confirmado;

            }elseif($movimento->tipo_movimento == 2) {

                $saldoConta = $conta->saldo_conta + $movimento->valor_confirmado;

            }

            $dados = [
                'saldo_conta' => $saldoConta
            ];
            $this->updateConta($codConta, $dados);

        }

        $this->db->where('cod_movimento_conta', $codMovimento);
        $this->db->update('movimentos_conta', $movimentoFinanceiro);

        //Atualiza título relacionado
        if($movimento->cod_titulo_rel != null){

            if($original == true){

                $movimentoRel = $this->financeiro->getMovimentoPorCodigo($movimento->cod_titulo_rel);

                if($movimentoRel->confirmado != 1){

                    $dadosMovimento = [
                        'cod_conta' => $movimentoRel->cod_conta,
                        'cod_centro_custo' => $movimentoFinanceiro['cod_centro_custo'],
                        'cod_conta_contabil' => $movimentoFinanceiro['cod_conta_contabil'],
                        'data_vencimento' => $movimentoFinanceiro['data_vencimento'],
                        'data_confirmacao' => $movimentoFinanceiro['data_confirmacao'],
                        'desc_movimento' => $movimentoFinanceiro['desc_movimento'],
                        'valor_titulo' => $movimentoFinanceiro['valor_titulo'],
                        'valor_desc_taxa' => $movimentoFinanceiro['valor_desc_taxa'],
                        'valor_juros_multa' => $movimentoFinanceiro['valor_juros_multa'],
                        'valor_confirmado' => $movimentoFinanceiro['valor_confirmado'],
                        'confirmado' => $movimentoFinanceiro['confirmado']
                    ];

                }else{

                    if($movimentoRel->confirmado == 1 && $movimentoFinanceiro['confirmado'] != 1){

                        $dadosMovimento = [
                            'cod_conta' => $movimentoRel->cod_conta,
                            'data_confirmacao' => $movimentoFinanceiro['data_confirmacao'], 
                            'valor_desc_taxa' => $movimentoFinanceiro['valor_desc_taxa'],
                            'valor_juros_multa' => $movimentoFinanceiro['valor_juros_multa'],
                            'valor_confirmado' => $movimentoFinanceiro['valor_confirmado'],
                            'confirmado' => $movimentoFinanceiro['confirmado'],
                        ];

                    }else{

                        $dadosMovimento = [
                            'cod_conta' => $movimentoRel->cod_conta,
                            'data_confirmacao' => $movimentoFinanceiro['data_confirmacao'], 
                            'valor_desc_taxa' => $movimentoFinanceiro['valor_desc_taxa'],
                            'valor_juros_multa' => $movimentoFinanceiro['valor_juros_multa'],
                            'valor_confirmado' => $movimentoFinanceiro['valor_confirmado'],
                            'confirmado' => $movimentoFinanceiro['confirmado'],
                        ];

                    }              

                }
                $this->updateMovimentoConta($movimento->cod_titulo_rel, $dadosMovimento, false);
            }
        }
    }

    public function deleteConta($codConta) {
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->where_in('cod_conta',$codConta)->delete('conta');

        return null;
    }

    public function deleteMetodoPagamento($codMetodoPagamento) {
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->where_in('cod_metodo_pagamento',$codMetodoPagamento)->delete('metodo_pagamento');

        return null;
    }

    public function deleteCentroCusto($codCentroCusto) {
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->where_in('cod_centro_custo',$codCentroCusto)->delete('centro_custo');

        return null;
    }

    public function deleteContaContabil($codContaContabil) {
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->where_in('cod_conta_contabil',$codContaContabil)->delete('conta_contabil');

        return null;
    }

    public function excluirTituloContasPagar($codMovimento) {

        $this->db->where_in('cod_movimento_conta',$codMovimento, 'cod_titulo_rel', $codMovimento)->delete('movimentos_conta');

        return null;
    }

    public function excluirTituloContasReceber($codMovimento) {

        $this->db->where_in('cod_movimento_conta',$codMovimento, 'cod_titulo_rel', $codMovimento)->delete('movimentos_conta');

        return null;
    }

    public function excluirTitulo($codMovimento) {

        $this->db->where_in('cod_movimento_conta',$codMovimento, 'cod_titulo_rel', $codMovimento)->delete('movimentos_conta');

        return null;
    }

    public function excluirTituloOrigem($origem, $codOrigem){
        $this->db->where('origem_movimento', $origem);
        $this->db->where('id_origem', $codOrigem);
        $this->db->where('confirmado', '0');
        $this->db->delete('movimentos_conta');
    }

    public function getConta($filter = "", $limit = null, $offset = null){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']);  

        if($limit){
            $this->db->limit($limit, $offset);
        }

        if($filter <> ""){
            $this->db->group_start();
            $this->db->or_like('cod_conta' ,$filter);
            $this->db->or_like('nome_conta' ,$filter);
            $this->db->group_end();
            
        }

        $this->db->select('conta.*');
        $this->db->select('(select count(*)
                              from movimentos_conta
                             where movimentos_conta.cod_conta = conta.cod_conta) count_mov');
               
        return $this->db->where('conta.cod_conta > 0')->get('conta')->result();
        
    }

    public function getMetodoPagamento($filter = "", $limit = null, $offset = null){
        $this->db->where('metodo_pagamento.id_empresa', getDadosUsuarioLogado()['id_empresa']);  

        if($limit){
            $this->db->limit($limit, $offset);
        }

        if($filter <> ""){
            $this->db->group_start();
            $this->db->or_like('cod_metodo_pagamento' ,$filter);
            $this->db->or_like('nome_metodo_pagamento' ,$filter);
            $this->db->or_like('nome_conta' ,$filter);
            $this->db->group_end();
            
        }

        $this->db->select('metodo_pagamento.*, conta.nome_conta');
        $this->db->join('conta', 'conta.cod_conta = metodo_pagamento.cod_conta', 'left');
        $this->db->select('(select count(*)
                              from movimentos_conta
                             where movimentos_conta.cod_metodo_pagamento = metodo_pagamento.cod_metodo_pagamento) count_mov');
               
        return $this->db->get('metodo_pagamento')->result();
        
    }

    public function getCentroCusto($filter = "", $limit = null, $offset = null){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']);  

        if($limit){
            $this->db->limit($limit, $offset);
        }

        if($filter <> ""){
            $this->db->group_start();
            $this->db->or_like('cod_centro_custo' ,$filter);
            $this->db->or_like('nome_centro_custo' ,$filter);
            $this->db->group_end();
            
        }

        $this->db->select('centro_custo.*');
        $this->db->select('(select count(*)
                              from movimentos_conta
                             where movimentos_conta.cod_centro_custo = centro_custo.cod_centro_custo) count_mov');
               
        return $this->db->get('centro_custo')->result();
        
    }

    public function getContaContabil($filter = "", $limit = null, $offset = null){
        $this->db->where('conta_contabil.id_empresa', getDadosUsuarioLogado()['id_empresa']);  

        if($limit){
            $this->db->limit($limit, $offset);
        }

        if($filter <> ""){
            $this->db->group_start();
            $this->db->or_like('conta_contabil.cod_conta_contabil' ,$filter);
            $this->db->or_like('conta_contabil.nome_conta_contabil' ,$filter);
            $this->db->group_end();
            
        }

        $this->db->select('conta_contabil.*');
        $this->db->select('(select count(*)
                              from movimentos_conta
                             where movimentos_conta.cod_conta_contabil = conta_contabil.cod_conta_contabil) count_mov');
        $this->db->select('(select count(*)
                              from conta_contabil b
                             where b.cod_conta_contabil_pai = conta_contabil.cod_conta_contabil) count_filho');
            $this->db->from('conta_contabil');
                
        return $this->db->get()->result();
        
    }

    public function getContaContabilAtivo(){
        $this->db->where('conta_contabil.id_empresa', getDadosUsuarioLogado()['id_empresa']);  

        $this->db->select('conta_contabil.*');
        $this->db->from('conta_contabil');
        $this->db->where('conta_contabil.ativo', '1');
        $this->db->where('not exists (select * from conta_contabil b 
                                               where b.cod_conta_contabil_pai = conta_contabil.cod_conta_contabil
                                                 and b.id_empresa = ' . getDadosUsuarioLogado()['id_empresa'] . ')', '', false);
               
        return $this->db->get()->result();
        
    }

    public function getCentroCustoAtivo(){
        $this->db->where('centro_custo.id_empresa', getDadosUsuarioLogado()['id_empresa']);  

        $this->db->select('centro_custo.*');
        $this->db->from('centro_custo');
        $this->db->where('centro_custo.ativo', '1');
               
        return $this->db->get()->result();
        
    }

    public function getCentroCustoAll(){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']);  

               
        return $this->db->get('centro_custo')->result();
        
    }    

    public function getContaContabilAll(){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']);  

               
        return $this->db->get('conta_contabil')->result();
        
    }

    public function getContaAtiva($data, $filter = "", $limit = null, $offset = null){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']);  

        if($limit){
            $this->db->limit($limit, $offset);
        }

        if($filter <> ""){
            $this->db->group_start();
            $this->db->or_like('cod_conta' ,$filter);
            $this->db->or_like('nome_conta' ,$filter);
            $this->db->group_end();
            
        }

        $this->db->select('conta.*');
        $this->db->select("(select sum(movimentos_conta.valor_confirmado)
                              from movimentos_conta
                             where movimentos_conta.cod_conta = conta.cod_conta
                               and movimentos_conta.tipo_movimento = 1
                               and movimentos_conta.confirmado = 1
                               and movimentos_conta.data_confirmacao >= '" . $data . "') valor_entrada");
        $this->db->select("(select sum(movimentos_conta.valor_confirmado)
                              from movimentos_conta
                             where movimentos_conta.cod_conta = conta.cod_conta
                               and movimentos_conta.tipo_movimento = 2
                               and movimentos_conta.confirmado = 1
                               and movimentos_conta.data_confirmacao >= '" . $data . "') valor_saida");
        $this->db->select("(select sum(movimentos_conta.valor_titulo)
                              from movimentos_conta
                             where movimentos_conta.cod_conta = conta.cod_conta
                               and movimentos_conta.tipo_movimento = 1
                               and movimentos_conta.confirmado = 0
                               and movimentos_conta.data_vencimento < '" . $data . "') proj_entrada");
        $this->db->select("(select sum(movimentos_conta.valor_titulo)
                              from movimentos_conta
                             where movimentos_conta.cod_conta = conta.cod_conta
                               and movimentos_conta.tipo_movimento = 2
                               and movimentos_conta.confirmado = 0
                               and movimentos_conta.data_vencimento < '" . $data . "') proj_saida");

        return $this->db->where('conta.ativo = 1')->get('conta')->result();
        
    }

    public function getContaAtivaRel(){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']);  

        $this->db->select('conta.*');

        return $this->db->where('conta.ativo = 1')->get('conta')->result();
        
    }

    public function getContaAtivaDestino($idConta){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']);  

        $this->db->select('conta.*');
        $this->db->where('conta.cod_conta != ', $idConta);  

        return $this->db->where('conta.ativo = 1')->get('conta')->result();
        
    }

    public function getSaldoConta($data, $filter = "", $limit = null, $offset = null){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']);  

        if($limit){
            $this->db->limit($limit, $offset);
        }

        if($filter <> ""){
            $this->db->group_start();
            $this->db->or_like('conta.cod_conta' ,$filter);
            $this->db->or_like('conta.nome_conta' ,$filter);
            $this->db->group_end();
            
        }

        $this->db->select('conta.*');
        $this->db->select("(select sum(movimentos_conta.valor_confirmado)
                              from movimentos_conta
                             where movimentos_conta.cod_conta = conta.cod_conta
                               and movimentos_conta.tipo_movimento = 1
                               and movimentos_conta.confirmado = 1
                               and movimentos_conta.data_confirmacao >= '" . $data . "') valor_entrada");
        $this->db->select("(select sum(movimentos_conta.valor_confirmado)
                              from movimentos_conta
                             where movimentos_conta.cod_conta = conta.cod_conta
                               and movimentos_conta.tipo_movimento = 2
                               and movimentos_conta.confirmado = 1
                               and movimentos_conta.data_confirmacao >= '" . $data . "') valor_saida");
        $this->db->select("(select sum(movimentos_conta.valor_titulo)
                              from movimentos_conta
                             where movimentos_conta.cod_conta = conta.cod_conta
                               and movimentos_conta.tipo_movimento = 1
                               and movimentos_conta.confirmado = 0
                               and movimentos_conta.data_vencimento < '" . $data . "') proj_entrada");
        $this->db->select("(select sum(movimentos_conta.valor_titulo)
                              from movimentos_conta
                             where movimentos_conta.cod_conta = conta.cod_conta
                               and movimentos_conta.tipo_movimento = 2
                               and movimentos_conta.confirmado = 0
                               and movimentos_conta.data_vencimento < '" . $data . "') proj_saida");

        return $this->db->get('conta')->result();
        
    }
    

    public function getContaPagarPendente($data, $fornecedorFiltro = "", $metodoPagamentoFiltro = "", $contaFinanceiraFiltro = "", $centroCustoFiltro = "", $contaContabilFiltro = ""){
        $this->db->where('conta.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        
        $this->db->select("movimentos_conta.*, fornecedor.nome_fornecedor");
        $this->db->from('movimentos_conta');
        $this->db->join('conta', 'conta.cod_conta = movimentos_conta.cod_conta');
        $this->db->join('fornecedor', 'fornecedor.cod_fornecedor = movimentos_conta.cod_emitente', 'left');
        $this->db->where('conta.ativo', 1);
        $this->db->where('movimentos_conta.confirmado = 0');
        $this->db->where('movimentos_conta.tipo_movimento = 2');
        $this->db->where('movimentos_conta.data_vencimento < ', $data);
        $this->db->order_by('movimentos_conta.data_vencimento');

        if($fornecedorFiltro != ""){
            $this->db->where_in('movimentos_conta.cod_emitente', $fornecedorFiltro);
        }

        if($metodoPagamentoFiltro != ""){
            $this->db->where_in('movimentos_conta.cod_metodo_pagamento', $metodoPagamentoFiltro);
        }        

        if($contaFinanceiraFiltro != ""){
            $this->db->where_in('movimentos_conta.cod_conta', $contaFinanceiraFiltro);
        }

        if($centroCustoFiltro != ""){
            $this->db->where_in('movimentos_conta.cod_centro_custo', $centroCustoFiltro);
        }

        if($contaContabilFiltro != ""){
            $this->db->where_in('movimentos_conta.cod_conta_contabil', $contaContabilFiltro);
        }
    
        return $this->db->get()->result();
    }

    public function getContaReceberPendente($data, $clienteFiltro = "", $metodoPagamentoFiltro = "", $contaFinanceiraFiltro = "", $centroCustoFiltro = "", $contaContabilFiltro = "", $vendedorFiltro = ""){
        $this->db->where('conta.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        
        $this->db->select("movimentos_conta.*, cliente.nome_cliente");
        $this->db->from('movimentos_conta');
        $this->db->join('conta', 'conta.cod_conta = movimentos_conta.cod_conta');
        $this->db->join('cliente', 'cliente.cod_cliente = movimentos_conta.cod_emitente', 'left');
        $this->db->where('conta.ativo', 1);
        $this->db->where('movimentos_conta.confirmado = 0');
        $this->db->where('movimentos_conta.tipo_movimento = 1');
        $this->db->where('movimentos_conta.data_vencimento < ', $data);
        $this->db->order_by('movimentos_conta.data_vencimento');

        if($clienteFiltro != ""){
            $this->db->where_in('movimentos_conta.cod_emitente', $clienteFiltro);
        }

        if($metodoPagamentoFiltro != ""){
            $this->db->where_in('movimentos_conta.cod_metodo_pagamento', $metodoPagamentoFiltro);
        }        

        if($contaFinanceiraFiltro != ""){
            $this->db->where_in('movimentos_conta.cod_conta', $contaFinanceiraFiltro);
        }

        if($centroCustoFiltro != ""){
            $this->db->where_in('movimentos_conta.cod_centro_custo', $centroCustoFiltro);
        }

        if($contaContabilFiltro != ""){
            $this->db->where_in('movimentos_conta.cod_conta_contabil', $contaContabilFiltro);
        }

        if($vendedorFiltro != ""){
            $this->db->where_in('movimentos_conta.cod_vendedor', $vendedorFiltro);
        }
    
        return $this->db->get()->result();
    }

    public function getContaPorCodigo($codConta){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']);
        

        return $this->db->get_where('conta', array('cod_conta' => $codConta))->row();
    }

    public function getMetodoPagamentoPorCodigo($codMetodoPagamento){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']);
        

        return $this->db->get_where('metodo_pagamento', array('cod_metodo_pagamento' => $codMetodoPagamento))->row();
    }

    public function getMetodoPagamentoPorCodigoVendasExternas($codVendasExternas){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']);
        

        return $this->db->get_where('metodo_pagamento', array('cod_vendas_externas' => $codVendasExternas))->row();
    }

    public function getMetodoPagamentoPorNome($nome){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('metodo_pagamento.*');
        $this->db->where('cod_vendas_externas', null); 
        $this->db->limit(1);

        return $this->db->get_where('metodo_pagamento', array('nome_metodo_pagamento' => $nome))->row();
    }

    public function getCentroCustoPorCodigo($codCentroCusto){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']);
        

        return $this->db->get_where('centro_custo', array('cod_centro_custo' => $codCentroCusto))->row();
    }

    public function getContaContabilPorCodigo($codContaContabil){
        $this->db->where('conta_contabil.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('conta_contabil.*, b.nome_conta_contabil as nome_conta_contabil_pai');
        $this->db->from('conta_contabil');
        $this->db->join('conta_contabil b', 'b.cod_conta_contabil = conta_contabil.cod_conta_contabil_pai', 'left');
        $this->db->where('conta_contabil.cod_conta_contabil', $codContaContabil);
        

        return $this->db->get()->row();
    }

    public function getMovimentoPorCodigo($codMovimento){
        

        return $this->db->get_where('movimentos_conta', array('cod_movimento_conta' => $codMovimento))->row();
    }

    public function getTitulospendentes(){
        $this->db->where('conta.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('movimentos_conta.*');
        $this->db->from('movimentos_conta');
        $this->db->join('conta', 'conta.cod_conta = movimentos_conta.cod_conta');
        $this->db->where('movimentos_conta.confirmado', '0');
        $this->db->where('movimentos_conta.data_vencimento <=', date('Y-m-d'));
        $this->db->order_by('movimentos_conta.data_vencimento');

        return $query = $this->db->get()->result();


    }

    public function getTotalConta(){
        $this->db->where('conta.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('sum(conta.saldo_conta) total_conta');
        $this->db->from('conta');

        return $this->db->get()->row();

    }

    public function getEntradasSaidas(){
        $this->db->where('conta.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('sum(if(movimentos_conta.tipo_movimento = 1, movimentos_conta.valor_titulo, 0)) total_entrada,
                           sum(if(movimentos_conta.tipo_movimento = 2, movimentos_conta.valor_titulo, 0)) total_saida');
        $this->db->from('movimentos_conta');
        $this->db->join('conta', 'conta.cod_conta = movimentos_conta.cod_conta'); 
        $this->db->where('movimentos_conta.confirmado', '1');
        $this->db->where('movimentos_conta.data_confirmacao >=', date('Y-m-01'));
        $this->db->where('movimentos_conta.data_confirmacao <=', date('Y-m-d')); 

        return $this->db->get()->row();
    }

    public function getTituloPorCodigoVendasExternas($codVendasExternas){
        $this->db->where('conta.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->select('movimentos_conta.*');
        $this->db->join('conta', 'conta.cod_conta = movimentos_conta.cod_conta');        

        return $this->db->get_where('movimentos_conta', array('cod_vendas_externas' => $codVendasExternas))->row();
    }

    public function getTituloPorCodigo($codMovimento){
        $this->db->where('conta.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->select('movimentos_conta.*');
        $this->db->join('conta', 'conta.cod_conta = movimentos_conta.cod_conta');        

        return $this->db->get_where('movimentos_conta', array('cod_movimento_conta' => $codMovimento))->row();
    }

    public function getSaldoContaPorCodigo($codConta, $dataFim){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('conta.*'); 
        $this->db->select("(select sum(movimentos_conta.valor_titulo)
                              from movimentos_conta
                             where movimentos_conta.cod_conta = conta.cod_conta
                               and movimentos_conta.tipo_movimento = 1
                               and movimentos_conta.confirmado = 0
                               and movimentos_conta.data_vencimento <= '" . $dataFim . "') proj_entrada");
        $this->db->select("(select sum(movimentos_conta.valor_titulo)
                              from movimentos_conta
                             where movimentos_conta.cod_conta = conta.cod_conta
                               and movimentos_conta.tipo_movimento = 2
                               and movimentos_conta.confirmado = 0
                               and movimentos_conta.data_vencimento <= '" . $dataFim . "') proj_saida");

        return $this->db->get_where('conta', array('cod_conta' => $codConta))->row();
    }

    public function getMovimentosPorConta($codConta, $dataInicio, $dataFim){ 

        $this->db->select('movimentos_conta.*, centro_custo.nome_centro_custo, conta_contabil.nome_conta_contabil');
        $this->db->select('if(movimentos_conta.confirmado = 1, movimentos_conta.data_confirmacao, movimentos_conta.data_vencimento) data_movimento');
        $this->db->from('movimentos_conta');
        $this->db->join('centro_custo', 'centro_custo.cod_centro_custo = movimentos_conta.cod_centro_custo and centro_custo.id_empresa = ' . getDadosUsuarioLogado()['id_empresa'], 'left');
        $this->db->join('conta_contabil', 'conta_contabil.cod_conta_contabil = movimentos_conta.cod_conta_contabil and conta_contabil.id_empresa = ' . getDadosUsuarioLogado()['id_empresa'], 'left');
        $this->db->where('movimentos_conta.cod_conta', $codConta);
        $this->db->where('if(movimentos_conta.confirmado = 1, movimentos_conta.data_confirmacao, movimentos_conta.data_vencimento) >= ', $dataInicio);
        $this->db->where('if(movimentos_conta.confirmado = 1, movimentos_conta.data_confirmacao, movimentos_conta.data_vencimento) <= ', $dataFim);
        $this->db->order_by('data_movimento', 'desc');
        $this->db->order_by('cod_movimento_conta', 'desc');

        return $this->db->get()->result();
    }

    public function countAllConta(){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        return $this->db->count_all_results('conta');
    }

    public function countAllCentroCusto(){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        return $this->db->count_all_results('centro_custo');
    }

    public function countAllContaContabil(){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        return $this->db->count_all_results('conta_contabil');
    }

    public function countAllMetodoPagamento(){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']);  

               
        return $this->db->count_all_results('metodo_pagamento');
        
    }

    public function countAllMovimentos($codConta){
        
        $this->db->where('cod_conta', $codConta);
        return $this->db->count_all_results('movimentos_conta');
    }

    //Indicadores
    public function getTotaisConta($dataInicio, $dataFim){
        $this->db->where('conta.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        
        $this->db->select('sum(conta.saldo_conta) saldo_total');
        $this->db->select("sum((select sum(movimentos_conta.valor_titulo)
                              from movimentos_conta
                             where movimentos_conta.cod_conta  = conta.cod_conta
                               and movimentos_conta.tipo_movimento = 1
                               and movimentos_conta.confirmado = 0
                               and movimentos_conta.data_vencimento >= '". $dataInicio ."'
                               and movimentos_conta.data_vencimento <= '". $dataFim ."')) entrada");
        $this->db->select("sum((select sum(movimentos_conta.valor_titulo)
                              from movimentos_conta
                             where movimentos_conta.cod_conta  = conta.cod_conta
                               and movimentos_conta.tipo_movimento = 2
                               and movimentos_conta.confirmado = 0
                               and movimentos_conta.data_vencimento >= '". $dataInicio ."'
                               and movimentos_conta.data_vencimento <= '". $dataFim ."')) saida");
        $this->db->from('conta');
        $this->db->where('conta.ativo', 1);

        return $query = $this->db->get()->row();

    }

    public function getTotais($dataInicio, $dataFim, $codConta){
        $this->db->where('conta.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('sum(conta.saldo_conta) saldo_total');        
        $this->db->select("sum((select sum(movimentos_conta.valor_confirmado)
                              from movimentos_conta
                             where movimentos_conta.cod_conta  = conta.cod_conta 
                               and movimentos_conta.tipo_movimento = 1
                               and movimentos_conta.confirmado = 1
                               and movimentos_conta.data_confirmacao >= '". $dataInicio ."'
                               and movimentos_conta.data_confirmacao <= '". $dataFim ."')) entrada_confirm");
        $this->db->select("sum((select sum(movimentos_conta.valor_confirmado)
                              from movimentos_conta
                             where movimentos_conta.cod_conta  = conta.cod_conta 
                               and movimentos_conta.tipo_movimento = 2
                               and movimentos_conta.confirmado = 1
                               and movimentos_conta.data_confirmacao >= '". $dataInicio ."'
                               and movimentos_conta.data_confirmacao <= '". $dataFim ."')) saida_confirm");
        $this->db->select("sum((select sum(movimentos_conta.valor_titulo)
                              from movimentos_conta
                             where movimentos_conta.cod_conta  = conta.cod_conta 
                               and movimentos_conta.tipo_movimento = 1
                               and movimentos_conta.confirmado = 0
                               and movimentos_conta.data_vencimento >= '". $dataInicio ."'
                               and movimentos_conta.data_vencimento <= '". $dataFim ."')) entrada_proj");
        $this->db->select("sum((select sum(movimentos_conta.valor_titulo)
                              from movimentos_conta
                             where movimentos_conta.cod_conta  = conta.cod_conta 
                               and movimentos_conta.tipo_movimento = 2
                               and movimentos_conta.confirmado = 0
                               and movimentos_conta.data_vencimento >= '". $dataInicio ."'
                               and movimentos_conta.data_vencimento <= '". $dataFim ."')) saida_proj");
        $this->db->from('conta');
        $this->db->where('conta.ativo', 1);

        if($codConta != ""){
            $this->db->where_in('conta.cod_conta', $codConta);
        }

        return $query = $this->db->get()->row();

    }

    public function getTotaisContaContabil($dataInicio, $dataFim, $codContaContabil){
        $this->db->where('conta_contabil.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('conta_contabil.*');        
        $this->db->select("sum((select sum(movimentos_conta.valor_confirmado)
                              from movimentos_conta
                              join conta on conta.cod_conta = movimentos_conta.cod_conta
                             where conta.id_empresa = ". getDadosUsuarioLogado()['id_empresa'] ."
                               and movimentos_conta.cod_conta_contabil  = conta_contabil.cod_conta_contabil 
                               and movimentos_conta.tipo_movimento = 1
                               and movimentos_conta.confirmado = 1
                               and movimentos_conta.data_confirmacao >= '". $dataInicio ."'
                               and movimentos_conta.data_confirmacao <= '". $dataFim ."')) receita");
        $this->db->select("sum((select sum(movimentos_conta.valor_confirmado)
                              from movimentos_conta
                              join conta on conta.cod_conta = movimentos_conta.cod_conta
                             where conta.id_empresa = ". getDadosUsuarioLogado()['id_empresa'] ."
                               and movimentos_conta.cod_conta_contabil  = conta_contabil.cod_conta_contabil 
                               and movimentos_conta.tipo_movimento = 2
                               and movimentos_conta.confirmado = 1
                               and movimentos_conta.data_confirmacao >= '". $dataInicio ."'
                               and movimentos_conta.data_confirmacao <= '". $dataFim ."')) despesa");
        $this->db->from('conta_contabil');
        $this->db->where('conta_contabil.ativo', 1);

        if($codContaContabil != ""){
            $this->db->where_in('conta_contabil.cod_conta_contabil', $codContaContabil);
        }

        return $query = $this->db->get()->row();

    }

    public function getContaResumida($dataInicio, $dataFim, $codConta){
        $this->db->where('conta.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        
        $this->db->select('conta.*');
        $this->db->select("sum((select sum(movimentos_conta.valor_confirmado)
                              from movimentos_conta
                             where movimentos_conta.cod_conta  = conta.cod_conta 
                               and movimentos_conta.tipo_movimento = 1
                               and movimentos_conta.confirmado = 1
                               and movimentos_conta.data_confirmacao >= '". $dataInicio ."'
                               and movimentos_conta.data_confirmacao <= '". $dataFim ."')) entrada_confirm");
        $this->db->select("sum((select sum(movimentos_conta.valor_confirmado)
                              from movimentos_conta
                             where movimentos_conta.cod_conta  = conta.cod_conta 
                               and movimentos_conta.tipo_movimento = 2
                               and movimentos_conta.confirmado = 1
                               and movimentos_conta.data_confirmacao >= '". $dataInicio ."'
                               and movimentos_conta.data_confirmacao <= '". $dataFim ."')) saida_confirm");
        $this->db->select("sum((select sum(movimentos_conta.valor_titulo)
                              from movimentos_conta
                             where movimentos_conta.cod_conta  = conta.cod_conta 
                               and movimentos_conta.tipo_movimento = 1
                               and movimentos_conta.confirmado = 0
                               and movimentos_conta.data_vencimento >= '". $dataInicio ."'
                               and movimentos_conta.data_vencimento <= '". $dataFim ."')) entrada_proj");
        $this->db->select("sum((select sum(movimentos_conta.valor_titulo)
                              from movimentos_conta
                             where movimentos_conta.cod_conta  = conta.cod_conta 
                               and movimentos_conta.tipo_movimento = 2
                               and movimentos_conta.confirmado = 0
                               and movimentos_conta.data_vencimento >= '". $dataInicio ."'
                               and movimentos_conta.data_vencimento <= '". $dataFim ."')) saida_proj");
        $this->db->from('conta');
        $this->db->group_by('conta.cod_conta');
        $this->db->where('conta.ativo', 1);

        if($codConta != ""){
            $this->db->where_in('conta.cod_conta', $codConta);
        }

        return $query = $this->db->get()->result();

    }

    public function getContaContabilResumida($dataInicio, $dataFim, $codContaContabil){
        $this->db->where('conta_contabil.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        
        $this->db->select('conta_contabil.*');
        $this->db->select("sum((select sum(movimentos_conta.valor_confirmado)
                              from movimentos_conta
                              join conta on conta.cod_conta = movimentos_conta.cod_conta
                             where conta.id_empresa = ". getDadosUsuarioLogado()['id_empresa'] ."
                               and movimentos_conta.cod_conta_contabil  = conta_contabil.cod_conta_contabil 
                               and movimentos_conta.tipo_movimento = 1
                               and movimentos_conta.confirmado = 1
                               and movimentos_conta.data_confirmacao >= '". $dataInicio ."'
                               and movimentos_conta.data_confirmacao <= '". $dataFim ."')) receita");
        $this->db->select("sum((select sum(movimentos_conta.valor_confirmado)
                              from movimentos_conta
                              join conta on conta.cod_conta = movimentos_conta.cod_conta
                             where conta.id_empresa = ". getDadosUsuarioLogado()['id_empresa'] ."
                               and movimentos_conta.cod_conta_contabil  = conta_contabil.cod_conta_contabil
                               and movimentos_conta.tipo_movimento = 2
                               and movimentos_conta.confirmado = 1
                               and movimentos_conta.data_confirmacao >= '". $dataInicio ."'
                               and movimentos_conta.data_confirmacao <= '". $dataFim ."')) despesa");
        $this->db->select('(select count(*)
                              from conta_contabil b
                             where b.cod_conta_contabil_pai = conta_contabil.cod_conta_contabil) count_filho');
        $this->db->from('conta_contabil');
        $this->db->group_by('conta_contabil.cod_conta_contabil');
        $this->db->where('conta_contabil.ativo', 1);

        if($codContaContabil != ""){
            $this->db->where_in('conta_contabil.cod_conta_contabil', $codContaContabil);
        }

        return $query = $this->db->get()->result();

    }

    public function getContaContabilResumidaDesc($dataInicio, $dataFim, $codContaContabil){
        $this->db->where('conta_contabil.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        
        $this->db->select('conta_contabil.*');
        $this->db->select("sum((select sum(movimentos_conta.valor_confirmado)
                              from movimentos_conta
                              join conta on conta.cod_conta = movimentos_conta.cod_conta
                             where conta.id_empresa = ". getDadosUsuarioLogado()['id_empresa'] ."
                               and movimentos_conta.cod_conta_contabil  = conta_contabil.cod_conta_contabil 
                               and movimentos_conta.tipo_movimento = 1
                               and movimentos_conta.confirmado = 1
                               and movimentos_conta.data_confirmacao >= '". $dataInicio ."'
                               and movimentos_conta.data_confirmacao <= '". $dataFim ."')) receita");
        $this->db->select("sum((select sum(movimentos_conta.valor_confirmado)
                              from movimentos_conta
                              join conta on conta.cod_conta = movimentos_conta.cod_conta
                             where conta.id_empresa = ". getDadosUsuarioLogado()['id_empresa'] ."
                               and movimentos_conta.cod_conta_contabil  = conta_contabil.cod_conta_contabil
                               and movimentos_conta.tipo_movimento = 2
                               and movimentos_conta.confirmado = 1
                               and movimentos_conta.data_confirmacao >= '". $dataInicio ."'
                               and movimentos_conta.data_confirmacao <= '". $dataFim ."')) despesa");
        $this->db->select('(select count(*)
                              from conta_contabil b
                             where b.cod_conta_contabil_pai = conta_contabil.cod_conta_contabil) count_filho');
        $this->db->from('conta_contabil');
        $this->db->group_by('conta_contabil.cod_conta_contabil');
        $this->db->order_by('length(conta_contabil.cod_conta_contabil)', 'desc');
        $this->db->order_by('conta_contabil.cod_conta_contabil', 'desc');
        $this->db->where('conta_contabil.ativo', 1);

        if($codContaContabil != ""){
            $this->db->where_in('conta_contabil.cod_conta_contabil', $codContaContabil);
        }

        return $query = $this->db->get()->result();

    }

    public function getMovimentosDetalhados($dataInicio, $dataFim, $codConta, $tipoData){ 
        $this->db->where('conta.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('movimentos_conta.*, conta.nome_conta, centro_custo.nome_centro_custo, cliente.nome_cliente, fornecedor.nome_fornecedor, vendedor.nome_vendedor, conta_contabil.nome_conta_contabil');        
        $this->db->from('movimentos_conta');
        $this->db->join('conta', 'conta.cod_conta = movimentos_conta.cod_conta');
        $this->db->join('centro_custo', 'centro_custo.cod_centro_custo = movimentos_conta.cod_centro_custo and centro_custo.id_empresa = ' . getDadosUsuarioLogado()['id_empresa'], 'left');
        $this->db->join('conta_contabil', 'conta_contabil.cod_conta_contabil = movimentos_conta.cod_conta_contabil and conta_contabil.id_empresa = ' . getDadosUsuarioLogado()['id_empresa'], 'left');
        $this->db->join('cliente', 'cliente.cod_cliente = movimentos_conta.cod_emitente', 'left');
        $this->db->join('fornecedor', 'fornecedor.cod_fornecedor = movimentos_conta.cod_emitente', 'left');
        $this->db->join('vendedor', 'vendedor.cod_vendedor = movimentos_conta.cod_vendedor', 'left');

        if($tipoData == "1"){
            $this->db->where('movimentos_conta.data_vencimento >= ', $dataInicio);
            $this->db->where('movimentos_conta.data_vencimento <= ', $dataFim);
            $this->db->order_by('data_vencimento', 'desc');
            $this->db->order_by('cod_movimento_conta', 'desc');
        }elseif($tipoData == "2"){
            $this->db->where('movimentos_conta.data_confirmacao >= ', $dataInicio);
            $this->db->where('movimentos_conta.data_confirmacao <= ', $dataFim);
            $this->db->order_by('data_confirmacao', 'desc');
            $this->db->order_by('cod_movimento_conta', 'desc');
        }elseif($tipoData == "3"){
            $this->db->where('movimentos_conta.data_competencia >= ', $dataInicio);
            $this->db->where('movimentos_conta.data_competencia <= ', $dataFim);
            $this->db->order_by('data_competencia', 'desc');
            $this->db->order_by('cod_movimento_conta', 'desc');
        }

        if($codConta != ""){
            $this->db->where_in('conta.cod_conta', $codConta);
        }

        return $query = $this->db->get()->result();
        
    }

    public function getContaContabilDetalhados($dataInicio, $dataFim, $codContaContabil){ 
        $this->db->where('conta.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('conta_contabil.id_empresa', getDadosUsuarioLogado()['id_empresa']);  

        $this->db->select('movimentos_conta.*, conta.nome_conta, conta_contabil.nome_conta_contabil');        
        $this->db->from('movimentos_conta');
        $this->db->join('conta', 'conta.cod_conta = movimentos_conta.cod_conta');
        $this->db->join('conta_contabil', 'conta_contabil.cod_conta_contabil = movimentos_conta.cod_conta_contabil');
        $this->db->where('movimentos_conta.confirmado', '1');
        $this->db->where('movimentos_conta.data_confirmacao >= ', $dataInicio);
        $this->db->where('movimentos_conta.data_confirmacao <= ', $dataFim);
        $this->db->order_by('data_confirmacao', 'desc');
        $this->db->order_by('cod_movimento_conta', 'desc');

        if($codContaContabil != ""){
            $this->db->where_in('conta_contabil.cod_conta_contabil', $codContaContabil);
        }

        return $query = $this->db->get()->result();
        
    }

    public function getLancamentoDiario($dataInicio, $dataFim){

        $this->db->select('tim.db_date as data,
                            tim.month_name as nome_mes,
                            IFNULL(movimento.entradas, 0) as entradas,
                            IFNULL(movimento.saidas, 0) as saidas                           
                        from time_dimension tim');
        $this->db->join('(
                            SELECT movimentos_conta.data_confirmacao, 
                                sum(if(movimentos_conta.tipo_movimento = 1, movimentos_conta.valor_confirmado, 0)) entradas,
                                sum(if(movimentos_conta.tipo_movimento = 2, movimentos_conta.valor_confirmado, 0)) saidas
                            FROM movimentos_conta 
                            JOIN conta ON conta.cod_conta = movimentos_conta.cod_conta
                            where conta.id_empresa = ' . getDadosUsuarioLogado()['id_empresa'] . '
                              and conta.ativo = 1
                              and movimentos_conta.confirmado = 1
                            GROUP BY movimentos_conta.data_confirmacao 
                        ) as movimento', 'movimento on movimento.data_confirmacao = tim.db_date ', 'left');
        $this->db->where('tim.db_date <= CURRENT_DATE()');
        $this->db->order_by('tim.db_date', 'asc');

        $this->db->where("tim.db_date >= ", $dataInicio);
        $this->db->where("tim.db_date <= ", $dataFim);

        return $query = $this->db->get()->result();   
    }

    public function getDespesasContaContabil($dataInicio, $dataFim){
        $this->db->where('conta.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('conta_contabil.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('conta_contabil.cod_conta_contabil, conta_contabil.nome_conta_contabil');
        $this->db->select('sum(movimentos_conta.valor_confirmado) valor_total');
        $this->db->from('movimentos_conta');
        $this->db->join('conta_contabil', 'conta_contabil.cod_conta_contabil = movimentos_conta.cod_conta_contabil', 'left');
        $this->db->join('conta', 'conta.cod_conta = movimentos_conta.cod_conta');
        $this->db->where('movimentos_conta.confirmado', 1);
        $this->db->where('movimentos_conta.tipo_movimento', 2);
        $this->db->where('movimentos_conta.data_confirmacao >= ', $dataInicio);
        $this->db->where('movimentos_conta.data_confirmacao <= ', $dataFim);
        $this->db->group_by('conta_contabil.cod_conta_contabil');
        $this->db->order_by('valor_total', 'desc');

        return $query = $this->db->get()->result();  

    }
    public function getDespesasCentroCusto($dataInicio, $dataFim){
        $this->db->where('conta.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('centro_custo.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('centro_custo.cod_centro_custo, centro_custo.nome_centro_custo');
        $this->db->select('sum(movimentos_conta.valor_confirmado) valor_total');
        $this->db->from('movimentos_conta');
        $this->db->join('centro_custo', 'centro_custo.cod_centro_custo = movimentos_conta.cod_centro_custo', 'left');
        $this->db->join('conta', 'conta.cod_conta = movimentos_conta.cod_conta');
        $this->db->where('movimentos_conta.confirmado', 1);
        $this->db->where('movimentos_conta.tipo_movimento', 2);
        $this->db->where('movimentos_conta.data_confirmacao >= ', $dataInicio);
        $this->db->where('movimentos_conta.data_confirmacao <= ', $dataFim);
        $this->db->group_by('centro_custo.cod_centro_custo');
        $this->db->order_by('valor_total', 'desc');

        return $query = $this->db->get()->result();  

    }

    public function getReceitasContaContabil($dataInicio, $dataFim){
        $this->db->where('conta.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('conta_contabil.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('conta_contabil.cod_conta_contabil, conta_contabil.nome_conta_contabil');
        $this->db->select('sum(movimentos_conta.valor_confirmado) valor_total');
        $this->db->from('movimentos_conta');
        $this->db->join('conta_contabil', 'conta_contabil.cod_conta_contabil = movimentos_conta.cod_conta_contabil', 'left');
        $this->db->join('conta', 'conta.cod_conta = movimentos_conta.cod_conta');
        $this->db->where('movimentos_conta.confirmado', 1);
        $this->db->where('movimentos_conta.tipo_movimento', 1);
        $this->db->where('movimentos_conta.data_confirmacao >= ', $dataInicio);
        $this->db->where('movimentos_conta.data_confirmacao <= ', $dataFim);
        $this->db->group_by('conta_contabil.cod_conta_contabil');
        $this->db->order_by('valor_total', 'desc');

        return $query = $this->db->get()->result();  

    }

    public function getReceitasCentroCusto($dataInicio, $dataFim){
        $this->db->where('conta.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('centro_custo.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('centro_custo.cod_centro_custo, centro_custo.nome_centro_custo');
        $this->db->select('sum(movimentos_conta.valor_confirmado) valor_total');
        $this->db->from('movimentos_conta');
        $this->db->join('centro_custo', 'centro_custo.cod_centro_custo = movimentos_conta.cod_centro_custo', 'left');
        $this->db->join('conta', 'conta.cod_conta = movimentos_conta.cod_conta');
        $this->db->where('movimentos_conta.confirmado', 1);
        $this->db->where('movimentos_conta.tipo_movimento', 1);
        $this->db->where('movimentos_conta.data_confirmacao >= ', $dataInicio);
        $this->db->where('movimentos_conta.data_confirmacao <= ', $dataFim);
        $this->db->group_by('centro_custo.cod_centro_custo');
        $this->db->order_by('valor_total', 'desc');

        return $query = $this->db->get()->result();  

    }

    public function getSaldosConta($dataInicio, $dataFim){
        $this->db->where('conta.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('conta.*');
        $this->db->from('conta');
        $this->db->where('conta.saldo_conta != ', 0);

        return $query = $this->db->get()->result();  

    }

    public function getMovimentosConta($dataInicio, $dataFim){
        $this->db->where('conta.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('conta.*');
        $this->db->select("sum((select sum(movimentos_conta.valor_confirmado)
                              from movimentos_conta
                             where movimentos_conta.cod_conta  = conta.cod_conta
                               and movimentos_conta.tipo_movimento = 1
                               and movimentos_conta.confirmado = 1
                               and movimentos_conta.data_confirmacao >= '". $dataInicio ."'
                               and movimentos_conta.data_confirmacao <= '". $dataFim ."')) entrada_confirm");
        $this->db->select("sum((select sum(movimentos_conta.valor_confirmado)
                              from movimentos_conta
                             where movimentos_conta.cod_conta  = conta.cod_conta
                               and movimentos_conta.tipo_movimento = 2
                               and movimentos_conta.confirmado = 1
                               and movimentos_conta.data_confirmacao >= '". $dataInicio ."'
                               and movimentos_conta.data_confirmacao <= '". $dataFim ."')) saida_confirm");
        $this->db->from('conta');
        $this->db->group_by('conta.cod_conta');

        return $query = $this->db->get()->result();  

    }

}