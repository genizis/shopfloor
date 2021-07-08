<?php

class Producao extends CI_Model{

    public function insertOrdemProducao($ordemProducao){
        $this->db->insert('ordem_producao', $ordemProducao);

        return $this->db->insert_id();

    }

    public function insertComponentesProducao($componente){
        $this->db->insert_batch('componente_ordem_producao', $componente); 

        if($this->db->error() <> null){
            return $this->db->error();
        }

        return null;
    }

    public function insertConsumo($consumo){
        $this->db->insert('componente_ordem_producao', $consumo);

        if($this->db->error() <> null){
            return $this->db->error();
        }

        return null;
    } 

    public function insertReporteProducao($reporteProducao){
        $this->db->insert('reporte_producao', $reporteProducao);
        $codReporteProducao = $this->db->insert_id();

        $ordemProducao = $this->getOrdemProducaoPorCodigo($reporteProducao['num_ordem_producao']);

        if($ordemProducao->quant_produzida > 0){
            if(($reporteProducao['quant_reportada'] + $ordemProducao->quant_produzida) >= $ordemProducao->quant_planejada) {
                $status = 3;
            }else{
                $status = 2;
            }            
        }else{
            if($reporteProducao['quant_reportada'] >= $ordemProducao->quant_planejada) {
                $status = 3;
            }else{
                $status = 2;
            } 
        }

        $dados = [
            'quant_produzida' => $ordemProducao->quant_produzida + $reporteProducao['quant_reportada'],
            'status' => $status
        ];

        $this->updateOrdemProducao($reporteProducao['num_ordem_producao'], $dados);

        return $codReporteProducao;

    } 

    public function updateOrdemProducao($NumOrdemProd, $ordem){
        $this->db->where('num_ordem_producao', $NumOrdemProd);
        $this->db->update('ordem_producao', $ordem);

        if($this->db->error() <> null){
            return $this->db->error();
        }

        return null;
    }    

    public function updateComponenteProducao($seqComponente, $componente){
        $this->db->where('seq_componente_producao', $seqComponente);
        $this->db->update('componente_ordem_producao', $componente);

        if($this->db->error() <> null){
            return $this->db->error();
        }

        return null;
    }

    public function updateReporteProducao($codReporteProducao, $reporte){
        $this->db->where('cod_reporte_producao', $codReporteProducao);
        $this->db->update('reporte_producao', $reporte);

        if($this->db->error() <> null){
            return $this->db->error();
        }

        return null;
    }

    public function deleteOrdemProducao($ordemProducao) {
        $this->db->where_in('num_ordem_producao',$ordemProducao)->delete('ordem_producao');

        if($this->db->error() <> null){
            return $this->db->error();
        }

        return null;
    } 

    public function deleteComponenteProducao($seqComponenteProd) {
        $this->db->where_in('seq_componente_producao',$seqComponenteProd)->delete('componente_ordem_producao');

        if($this->db->error() <> null){
            return $this->db->error();
        }

        return null;
    } 
    
    public function deleteComponenteProducaoPorOrdem($numOrdemProducao) {
        $this->db->where_in('num_ordem_producao',$numOrdemProducao)->delete('componente_ordem_producao');

        if($this->db->error() <> null){
            return $this->db->error();
        }

        return null;
    }  

    public function getOrdemProducao($filter = "", $limit = null, $offset = null){
        $this->db->where('ordem_producao.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        if($limit){
            $this->db->limit($limit, $offset);
        }

        //Join para pegar o tipo de produto
        $this->db->select('ordem_producao.*, produto.nome_produto, produto.cod_unidade_medida');
        $this->db->select('(select count(*)
                              from reporte_producao
                             where reporte_producao.num_ordem_producao = ordem_producao.num_ordem_producao) count_mov');
        $this->db->from('ordem_producao');
        $this->db->join('produto', 'produto.cod_produto = ordem_producao.cod_produto'); 
        $this->db->order_by('num_ordem_producao', 'desc');       

        if($filter <> ""){
            $this->db->group_start();
            $this->db->or_like('num_ordem_producao' ,$filter);
            $this->db->or_like('ordem_producao.cod_produto' ,$filter);
            $this->db->or_like('nome_produto' ,$filter);
            $this->db->or_like('cod_unidade_medida' ,$filter);
            $this->db->group_end();
            
        }
        
        return $query = $this->db->get()->result();
        
    } 
    
    public function getOrdemProducaoPorCalculoNecessidade($codCalculo){
        $this->db->where('ordem_producao.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        //Join para pegar o tipo de produto
        $this->db->select('ordem_producao.*');
        $this->db->select('(select count(*)
                              from reporte_producao
                             where reporte_producao.num_ordem_producao = ordem_producao.num_ordem_producao) count_mov');
        $this->db->from('ordem_producao');  
        $this->db->where('cod_calculo_necessidade', $codCalculo);
        
        return $this->db->get()->result();
        
    } 

    public function getReportesPorducao($NumOrdem = null){        

        //Join para pegar o tipo de produto
        $this->db->where('num_ordem_producao', $NumOrdem);  
        $this->db->order_by('cod_reporte_producao', 'desc');
        $this->db->where('estornado', '0');          
        return $query = $this->db->get('reporte_producao')->result();
        
    }

    public function getReportesPorducaoPorCodigo($codReporteProducao){        

        $this->db->where('cod_reporte_producao', $codReporteProducao);          
        return $query = $this->db->get('reporte_producao')->row();
        
    }


    public function getOrdemProducaoPorCodigo($numOrdemProd){
        $this->db->where('ordem_producao.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('ordem_producao.*, produto.nome_produto, produto.saldo_negativo, produto.cod_unidade_medida, tipo_produto.nome_tipo_produto, cliente.nome_cliente');
        $this->db->from('ordem_producao');
        $this->db->join('produto', 'produto.cod_produto = ordem_producao.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->join('pedido_venda', 'pedido_venda.num_pedido_venda = ordem_producao.num_pedido_venda', 'left');
        $this->db->join('cliente', 'cliente.cod_cliente = pedido_venda.cod_cliente', 'left');
        $this->db->where('ordem_producao.num_ordem_producao', $numOrdemProd);
        
        return $query = $this->db->get()->row();

    }

    public function getComponentesProducaoPorOrdemProducao($numOrdemProd){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('componente_ordem_producao.*, produto.nome_produto, produto.saldo_negativo, produto.custo_medio, produto.id_conta_azul, produto.cod_unidade_medida, produto.quant_estoq, tipo_produto.nome_tipo_produto');
        $this->db->from('componente_ordem_producao');
        $this->db->join('produto', 'produto.cod_produto = componente_ordem_producao.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->where('componente_ordem_producao.num_ordem_producao', $numOrdemProd);
        
        return $query = $this->db->get()->result();

    }

    public function getMovimentosPorOrdemProducao($numOrdemProd){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('movimentos_estoque.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('movimentos_estoque.*, reporte_producao.cod_reporte_producao, produto.nome_produto, produto.cod_unidade_medida, tipo_produto.nome_tipo_produto');
        $this->db->from('movimentos_estoque');
        $this->db->join('produto', 'produto.cod_produto = movimentos_estoque.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->join('reporte_producao', 'reporte_producao.cod_reporte_producao = movimentos_estoque.id_origem');
        $this->db->where('movimentos_estoque.origem_movimento', '1');
        $this->db->where('reporte_producao.num_ordem_producao', $numOrdemProd);
        $this->db->order_by('movimentos_estoque.cod_movimento_estoque', 'desc');  
        
        return $query = $this->db->get()->result();

    }

    public function getMovimentosPorReporteProducao($codReporteProducao){
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('movimentos_estoque.*, produto.nome_produto, produto.cod_unidade_medida, tipo_produto.nome_tipo_produto');
        $this->db->from('movimentos_estoque');
        $this->db->join('produto', 'produto.cod_produto = movimentos_estoque.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->join('reporte_producao', 'reporte_producao.cod_reporte_producao = movimentos_estoque.id_origem');
        $this->db->where('movimentos_estoque.origem_movimento', '1');
        $this->db->where('reporte_producao.cod_reporte_producao', $codReporteProducao);
        $this->db->order_by('movimentos_estoque.cod_movimento_estoque', 'desc');  
        
        return $query = $this->db->get()->result();

    }

    public function getProximasProducoes(){
        $this->db->where('ordem_producao.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        //Join para pegar o tipo de produto
        $this->db->select('ordem_producao.*, produto.nome_produto, produto.cod_unidade_medida');
        $this->db->from('ordem_producao');
        $this->db->join('produto', 'produto.cod_produto = ordem_producao.cod_produto'); 
        $this->db->where('status', '1'); 
        $this->db->order_by('data_fim', 'asc'); 
        
        return $query = $this->db->get()->result();

    }

    public function getCustoTotalProduto(){
        $this->db->where('ordem_producao.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('sum(reporte_producao.custo_producao) as custo_total');
        $this->db->from('reporte_producao');
        $this->db->join('ordem_producao', 'ordem_producao.num_ordem_producao = reporte_producao.num_ordem_producao');
        $this->db->where('reporte_producao.estornado', '0');  
        $this->db->where('reporte_producao.custo_producao !=', '0');    
        $this->db->where('reporte_producao.data_reporte >=', date('Y-m-01'));
        $this->db->where('reporte_producao.data_reporte <=', date('Y-m-d')); 
               
        return $this->db->get()->row();

    }

    public function getCustoProduto(){
        $this->db->where('ordem_producao.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('sum(reporte_producao.custo_producao) as custo_total, produto.cod_produto, produto.nome_produto');
        $this->db->from('reporte_producao');
        $this->db->join('ordem_producao', 'ordem_producao.num_ordem_producao = reporte_producao.num_ordem_producao');
        $this->db->join('produto', 'produto.cod_produto = ordem_producao.cod_produto');
        $this->db->where('reporte_producao.estornado', '0');  
        $this->db->where('reporte_producao.custo_producao !=', '0');    
        $this->db->where('reporte_producao.data_reporte >=', date('Y-m-01'));
        $this->db->where('reporte_producao.data_reporte <=', date('Y-m-d'));     
        $this->db->group_by('produto.cod_produto');
        $this->db->order_by('sum(reporte_producao.custo_producao)', 'desc');
        $this->db->limit(3);
               
        return $this->db->get()->result();

    }

    public function getProducaoPeriodo(){

        $this->db->select("(select sum(reporte_producao.quant_reportada)
                            from reporte_producao
                    inner join ordem_producao on ordem_producao.num_ordem_producao = reporte_producao.num_ordem_producao
                        where reporte_producao.estornado    = 0
                            and reporte_producao.data_reporte = CURRENT_DATE()
                            and ordem_producao.id_empresa     = " . getDadosUsuarioLogado()['id_empresa'] . ") prod_hoje,
                        (select sum(reporte_producao.quant_reportada)
                            from reporte_producao
                    inner join ordem_producao on ordem_producao.num_ordem_producao = reporte_producao.num_ordem_producao
                        where reporte_producao.estornado     = 0
                            and reporte_producao.data_reporte >= CAST(DATE_FORMAT(NOW() ,'%Y-%m-01') as DATE)
                            and ordem_producao.id_empresa      = " . getDadosUsuarioLogado()['id_empresa'] . ") prod_mes,
                        (select sum(ordem_producao.quant_planejada - ordem_producao.quant_produzida)
                            from ordem_producao
                        where ordem_producao.id_empresa     = " . getDadosUsuarioLogado()['id_empresa'] . ") prod_planejada from dual");

        return $query = $this->db->get()->row();

    }

    public function getQuantPorStatus(){
        
        $this->db->select("(select count(*)
                            from ordem_producao
                        where ordem_producao.data_fim < curdate()
                            and ordem_producao.status != 3
                            and ordem_producao.id_empresa = " . getDadosUsuarioLogado()['id_empresa'] . ") atrasadas,
                        (select count(*)
                            from ordem_producao
                        where ordem_producao.data_fim >= curdate()
                            and ordem_producao.status    = 1
                            and ordem_producao.id_empresa = " . getDadosUsuarioLogado()['id_empresa'] . ") pendentes,
                        (select count(*)
                            from ordem_producao
                        where ordem_producao.data_fim >= curdate()
                            and ordem_producao.status    = 2
                            and ordem_producao.id_empresa = " . getDadosUsuarioLogado()['id_empresa'] . ") prod_parcial,
                        (select count(*)
                            from ordem_producao
                        where ordem_producao.status    = 3
                            and ordem_producao.id_empresa = " . getDadosUsuarioLogado()['id_empresa'] . ") prod_total
                    from dual");

        return $query = $this->db->get()->row();

    }   

    public function selectMovimentosReporteProducao($codReporteProducao = null){

        $movimentosReporteProducao = $this->getMovimentosPorReporteProducao($codReporteProducao);

        $table = "";

        foreach($movimentosReporteProducao as $movimentos){
            $dataMovimento = str_replace('-', '/', date('d-m-Y', strtotime($movimentos->data_movimento)));
            
            switch ($movimentos->especie_movimento) {
                case 1:
                    $especieMovimento = "Estoque Inicial";
                    break;
                case 2:
                    $especieMovimento = "Reporte de Produção";
                    break;
                case 3:
                    $especieMovimento = "Consumo de Material";
                    break;
                case 4:
                    $especieMovimento = "Compra de Material";
                    break;
                case 5:
                    $especieMovimento = "Venda de Material";
                    break;
                case 6:
                    $especieMovimento = "Estorno de Produção";
                    break;
                case 7:
                    $especieMovimento = "Estorno de Cosumo";
                    break;
                case 8:
                    $especieMovimento = "Devolução de Compra";
                    break;
                case 9:
                    $especieMovimento = "Devolução de Venda";
                    break;
                case 10:
                    $especieMovimento = "Movimentos Diversos de Entrada";
                    break;
                case 11:
                    $especieMovimento = "Movimentos Diversos de Saída";
                    break;
            } 

            switch ($movimentos->tipo_movimento) {
                case 1:
                    $tipoMovimento = "Entrada em Estoque";
                    break;
                case 2:
                    $tipoMovimento = "Saída de Estoque";
                    break;
            } 

            $quantMovimentada = number_format($movimentos->quant_movimentada, 3, ',', '.');
            $valorMovimento = number_format($movimentos->valor_movimento, 2, ',', '.');

            if($movimentos->tipo_movimento == 2){
                $classeNegativo = "text-danger";
            }else{
                $classeNegativo = "";
            }


            $table .= "<tr>
                            <td class='text-center'>{$dataMovimento}</td>
                            <td>{$especieMovimento}</td>
                            <td>{$movimentos->cod_produto} - {$movimentos->nome_produto}</td>
                            <td class='text-center'>{$movimentos->cod_unidade_medida}</td>
                            <td>{$tipoMovimento}</td>
                            <td class='{$classeNegativo} text-center'>{$quantMovimentada}</td>
                            <td class='{$classeNegativo} text-center'>R$ {$valorMovimento}</td>
                       </tr>".PHP_EOL;
        }

        return $table;

    }

    public function countAll($filter){
        $this->db->where('ordem_producao.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        
        $this->db->join('produto', 'produto.cod_produto = ordem_producao.cod_produto'); 

        if($filter <> ""){
            $this->db->group_start();
            $this->db->or_like('num_ordem_producao' ,$filter);
            $this->db->or_like('ordem_producao.cod_produto' ,$filter);
            $this->db->or_like('nome_produto' ,$filter);
            $this->db->or_like('cod_unidade_medida' ,$filter);
            $this->db->group_end();
            
        }

        return $this->db->count_all_results('ordem_producao');
    }

    

    //Relatórios
    public function totalProducao($dataInicio, $dataFim, $codProdutos){        

        $per_filter = "and reporte_producao.data_reporte >= '" . $dataInicio . "'
                       and reporte_producao.data_reporte <= '" . $dataFim . "'";

        $pro_filter = "";
        if($codProdutos != ""){
            foreach($codProdutos as $key_codProdutos => $cod_produto){
                if($key_codProdutos == 0){
                    $pro_filter = "and (ordem_producao.cod_produto = '" . $cod_produto . "'";
                }else{
                    $pro_filter = $pro_filter . " or ordem_producao.cod_produto = '" . $cod_produto . "'";
                }
            }
            $pro_filter = $pro_filter . ") ";
        }


        $this->db->select("(select sum(reporte_producao.quant_reportada)
                            from reporte_producao
                    inner join ordem_producao on ordem_producao.num_ordem_producao = reporte_producao.num_ordem_producao
                        where reporte_producao.estornado    = 0
                            " . $per_filter . "
                            " . $pro_filter . "
                            and ordem_producao.id_empresa     = " . getDadosUsuarioLogado()['id_empresa'] . ") quant_producao,
                        (select sum(reporte_producao.quant_perdida)
                            from reporte_producao
                    inner join ordem_producao on ordem_producao.num_ordem_producao = reporte_producao.num_ordem_producao
                        where reporte_producao.estornado     = 0
                            " . $per_filter . "
                            " . $pro_filter . "
                            and ordem_producao.id_empresa      = " . getDadosUsuarioLogado()['id_empresa'] . ") quant_perdida,
                        (select sum(reporte_producao.custo_producao)
                            from reporte_producao
                    inner join ordem_producao on ordem_producao.num_ordem_producao = reporte_producao.num_ordem_producao
                        where reporte_producao.estornado     = 0
                            " . $per_filter . "
                            " . $pro_filter . "
                            and ordem_producao.id_empresa      = " . getDadosUsuarioLogado()['id_empresa'] . ") custo_total from dual");

        return $query = $this->db->get()->row();

    }

    public function producaoResumida($dataInicio, $dataFim, $codProdutos){
        $this->db->where('ordem_producao.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('tipo_produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('ordem_producao.cod_produto, produto.nome_produto, tipo_produto.nome_tipo_produto, produto.cod_unidade_medida, 
                           sum(reporte_producao.quant_reportada) quant_reportada, sum(reporte_producao.quant_perdida) quant_perdida, sum(reporte_producao.custo_producao) custo_producao');
        $this->db->from('reporte_producao');
        $this->db->join('ordem_producao', 'ordem_producao.num_ordem_producao = reporte_producao.num_ordem_producao');
        $this->db->join('produto', 'produto.cod_produto = ordem_producao.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->where('reporte_producao.estornado', '0');
        $this->db->group_by('ordem_producao.cod_produto');
        $this->db->order_by('sum(reporte_producao.quant_reportada)', 'desc');

        $this->db->where("reporte_producao.data_reporte >= ", $dataInicio);
        $this->db->where("reporte_producao.data_reporte <= ", $dataFim);

        if($codProdutos != ""){
            $this->db->where_in('produto.cod_produto', $codProdutos);
        }

        return $query = $this->db->get()->result();

    }

    public function producaoDetalhada($dataInicio, $dataFim, $codProdutos){
        $this->db->where('ordem_producao.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('tipo_produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('ordem_producao.num_ordem_producao, reporte_producao.cod_reporte_producao, reporte_producao.data_reporte, ordem_producao.cod_produto, produto.nome_produto, tipo_produto.nome_tipo_produto, produto.cod_unidade_medida, 
                           reporte_producao.quant_reportada, reporte_producao.quant_perdida, reporte_producao.custo_producao');
        $this->db->from('reporte_producao');
        $this->db->join('ordem_producao', 'ordem_producao.num_ordem_producao = reporte_producao.num_ordem_producao');
        $this->db->join('produto', 'produto.cod_produto = ordem_producao.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->where('reporte_producao.estornado', '0');
        $this->db->order_by('reporte_producao.data_reporte', 'desc');

        $this->db->where("reporte_producao.data_reporte >= ", $dataInicio);
        $this->db->where("reporte_producao.data_reporte <= ", $dataFim);

        if($codProdutos != ""){
            $this->db->where_in('produto.cod_produto', $codProdutos);
        }

        return $query = $this->db->get()->result();

    }

    public function totalCustoConsumo($dataInicio, $dataFim, $codProdutosProduzido, $codProdutosConsumido){
        $this->db->where('ordem_producao.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('consumo.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('acabado.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('tipo_produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('sum(movimentos_estoque.valor_movimento) custo_consumo');
        $this->db->from('ordem_producao');        
        $this->db->join('produto acabado', 'acabado.cod_produto = ordem_producao.cod_produto');
        $this->db->join('reporte_producao', 'reporte_producao.num_ordem_producao = ordem_producao.num_ordem_producao');
        $this->db->join('movimentos_estoque', 'movimentos_estoque.id_origem = reporte_producao.cod_reporte_producao');
        $this->db->join('produto consumo', 'consumo.cod_produto = movimentos_estoque.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = consumo.cod_tipo_produto');        
        $this->db->where('movimentos_estoque.especie_movimento', '3');
        $this->db->where('reporte_producao.estornado', '0');

        $this->db->where("reporte_producao.data_reporte >= ", $dataInicio);
        $this->db->where("reporte_producao.data_reporte <= ", $dataFim);

        if($codProdutosConsumido != ""){
            $this->db->where_in('consumo.cod_produto', $codProdutosConsumido);
        }

        if($codProdutosProduzido != ""){
            $this->db->where_in('acabado.cod_produto', $codProdutosProduzido);
        }

        return $query = $this->db->get()->row();
        

    }

    public function consumoResumido($dataInicio, $dataFim, $codProdutosProduzido, $codProdutosConsumido){
        $this->db->where('ordem_producao.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('consumo.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('acabado.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('tipo_produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('ordem_producao.cod_produto produto_producao, acabado.nome_produto nome_producao, acabado.cod_unidade_medida un_producao,
                           sum(reporte_producao.quant_reportada) quant_reportada,
                           movimentos_estoque.cod_produto, consumo.nome_produto, tipo_produto.nome_tipo_produto, consumo.cod_unidade_medida, 
                           sum(movimentos_estoque.quant_movimentada) quant_consumo, sum(movimentos_estoque.valor_movimento) custo_consumo');
        $this->db->from('ordem_producao');        
        $this->db->join('produto acabado', 'acabado.cod_produto = ordem_producao.cod_produto');
        $this->db->join('reporte_producao', 'reporte_producao.num_ordem_producao = ordem_producao.num_ordem_producao');
        $this->db->join('movimentos_estoque', 'movimentos_estoque.id_origem = reporte_producao.cod_reporte_producao');
        $this->db->join('produto consumo', 'consumo.cod_produto = movimentos_estoque.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = consumo.cod_tipo_produto');        
        $this->db->where('movimentos_estoque.especie_movimento', '3');
        $this->db->where('reporte_producao.estornado', '0');
        $this->db->group_by('ordem_producao.cod_produto, movimentos_estoque.cod_produto');
        $this->db->order_by('sum(movimentos_estoque.quant_movimentada)', 'desc');

        $this->db->where("reporte_producao.data_reporte >= ", $dataInicio);
        $this->db->where("reporte_producao.data_reporte <= ", $dataFim);

        if($codProdutosConsumido != ""){
            $this->db->where_in('consumo.cod_produto', $codProdutosConsumido);
        }

        if($codProdutosProduzido != ""){
            $this->db->where_in('acabado.cod_produto', $codProdutosProduzido);
        }

        return $query = $this->db->get()->result();

    }

    public function consumoDetalhado($dataInicio, $dataFim, $codProdutosProduzido, $codProdutosConsumido){
        $this->db->where('ordem_producao.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('consumo.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('acabado.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('tipo_produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('ordem_producao.num_ordem_producao, ordem_producao.cod_produto produto_acabado, acabado.nome_produto nome_acabado,
                           reporte_producao.cod_reporte_producao, reporte_producao.quant_reportada, movimentos_estoque.data_movimento, movimentos_estoque.cod_produto, 
                           consumo.nome_produto, tipo_produto.nome_tipo_produto, consumo.cod_unidade_medida, 
                           movimentos_estoque.quant_movimentada, movimentos_estoque.valor_movimento');
        $this->db->from('movimentos_estoque');
        $this->db->join('produto consumo', 'consumo.cod_produto = movimentos_estoque.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = consumo.cod_tipo_produto');
        $this->db->join('reporte_producao', 'reporte_producao.cod_reporte_producao = movimentos_estoque.id_origem');
        $this->db->join('ordem_producao', 'ordem_producao.num_ordem_producao = reporte_producao.num_ordem_producao');
        $this->db->join('produto acabado', 'acabado.cod_produto = ordem_producao.cod_produto');        
        $this->db->where('movimentos_estoque.especie_movimento', '3');
        $this->db->where('reporte_producao.estornado', '0');
        $this->db->order_by('movimentos_estoque.data_movimento', 'desc');

        $this->db->where("movimentos_estoque.data_movimento >= ", $dataInicio);
        $this->db->where("movimentos_estoque.data_movimento <= ", $dataFim);

        if($codProdutosConsumido != ""){
            $this->db->where_in('consumo.cod_produto', $codProdutosConsumido);
        }

        if($codProdutosProduzido != ""){
            $this->db->where_in('acabado.cod_produto', $codProdutosProduzido);
        }

        return $query = $this->db->get()->result();

    }

    // Para o gráfico
    public function getProducaoDiaria($dataInicio, $dataFim, $codProdutos){

        $pro_filter = "";
        if($codProdutos != ""){
            foreach($codProdutos as $key_codProdutos => $cod_produto){
                if($key_codProdutos == 0){
                    $pro_filter = "and (ordem_producao.cod_produto = '" . $cod_produto . "'";
                }else{
                    $pro_filter = $pro_filter . " or ordem_producao.cod_produto = '" . $cod_produto . "'";
                }
            }
            $pro_filter = $pro_filter . ") ";
        }

        $this->db->select('tim.db_date as data,
                           tim.month_name as nome_mes,
                        IFNULL(reporte.sum_producao, 0) as producao_dia,
                        IFNULL(reporte.sum_perdida, 0) as perda_dia
                        from time_dimension tim');
        $this->db->join("(
                            SELECT rep.data_reporte, sum(rep.quant_reportada) as sum_producao, sum(rep.quant_perdida) as sum_perdida
                            FROM reporte_producao rep
                            join ordem_producao on ordem_producao.num_ordem_producao = rep.num_ordem_producao
                            where ordem_producao.id_empresa = " . getDadosUsuarioLogado()['id_empresa'] . "
                              " . $pro_filter . "
                              and rep.estornado = 0
                            GROUP BY rep.data_reporte 
                        ) as reporte", "reporte on reporte.data_reporte = tim.db_date ", "left");
        $this->db->where('tim.db_date <= CURRENT_DATE()');
        $this->db->order_by('tim.db_date', 'asc');

        $this->db->where("tim.db_date >= ", $dataInicio);
        $this->db->where("tim.db_date <= ", $dataFim);

        return $query = $this->db->get()->result();   
    }

    public function getCustoProdutoConsumo($dataInicio, $dataFim, $codProdutos){
        $this->db->where('ordem_producao.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('tipo_produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('movimentos_estoque.cod_produto, produto.nome_produto, sum(movimentos_estoque.valor_movimento) custo_consumo, 
                           produto.cod_unidade_medida, sum(movimentos_estoque.quant_movimentada) quant_movimentada');
        $this->db->from('movimentos_estoque');
        $this->db->join('reporte_producao', 'reporte_producao.cod_reporte_producao = movimentos_estoque.id_origem');
        $this->db->join('ordem_producao', 'ordem_producao.num_ordem_producao = reporte_producao.num_ordem_producao');
        $this->db->join('produto', 'produto.cod_produto = movimentos_estoque.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->where('movimentos_estoque.especie_movimento', '3');
        $this->db->where('movimentos_estoque.valor_movimento > 0');
        $this->db->where('reporte_producao.estornado', '0');        
        $this->db->group_by('movimentos_estoque.cod_produto');
        $this->db->order_by('sum(movimentos_estoque.valor_movimento)', 'desc');

        $this->db->where("movimentos_estoque.data_movimento >= ", $dataInicio);
        $this->db->where("movimentos_estoque.data_movimento <= ", $dataFim);

        if($codProdutos != ""){
            $this->db->where_in('ordem_producao.cod_produto', $codProdutos);
        }

        return $query = $this->db->get()->result();

    }

    public function getQuantConsumo($dataInicio, $dataFim, $codProdutos){
        $this->db->where('ordem_producao.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);
        $this->db->where('tipo_produto.id_empresa', getDadosUsuarioLogado()['id_empresa']);

        $this->db->select('movimentos_estoque.cod_produto, produto.nome_produto, produto.cod_unidade_medida, sum(movimentos_estoque.quant_movimentada) quant_movimentada');
        $this->db->from('movimentos_estoque');
        $this->db->join('reporte_producao', 'reporte_producao.cod_reporte_producao = movimentos_estoque.id_origem');
        $this->db->join('ordem_producao', 'ordem_producao.num_ordem_producao = reporte_producao.num_ordem_producao');
        $this->db->join('produto', 'produto.cod_produto = movimentos_estoque.cod_produto');
        $this->db->join('tipo_produto', 'tipo_produto.cod_tipo_produto = produto.cod_tipo_produto');
        $this->db->where('movimentos_estoque.especie_movimento', '3');
        $this->db->where('reporte_producao.estornado', '0');        
        $this->db->group_by('movimentos_estoque.cod_produto');
        $this->db->order_by('sum(movimentos_estoque.quant_movimentada)', 'desc');

        $this->db->where("movimentos_estoque.data_movimento >= ", $dataInicio);
        $this->db->where("movimentos_estoque.data_movimento <= ", $dataFim);

        if($codProdutos != ""){
            $this->db->where_in('ordem_producao.cod_produto', $codProdutos);
        }

        return $query = $this->db->get()->result();

    }

    public function getCustoTotalConsumo($dataInicio, $dataFim, $codProdutos){
        $this->db->where('ordem_producao.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('sum(movimentos_estoque.valor_movimento) custo_total');
        $this->db->from('movimentos_estoque');
        $this->db->join('reporte_producao', 'reporte_producao.cod_reporte_producao = movimentos_estoque.id_origem');
        $this->db->join('ordem_producao', 'ordem_producao.num_ordem_producao = reporte_producao.num_ordem_producao');
        $this->db->where('movimentos_estoque.especie_movimento', '3');
        $this->db->where('reporte_producao.estornado', '0');

        $this->db->where("movimentos_estoque.data_movimento >= ", $dataInicio);
        $this->db->where("movimentos_estoque.data_movimento <= ", $dataFim);

        if($codProdutos != ""){
            $this->db->where_in('ordem_producao.cod_produto', $codProdutos);
        }

        return $query = $this->db->get()->row();

    }

    public function getProduçãoPorduto($dataInicio, $dataFim, $codProdutos){
        $this->db->where('ordem_producao.id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        $this->db->where('produto.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('ordem_producao.cod_produto, produto.nome_produto, produto.cod_unidade_medida, sum(reporte_producao.quant_reportada) as quant_reportada, sum(reporte_producao.custo_producao) as custo_producao');
        $this->db->from('reporte_producao');
        $this->db->join('ordem_producao', 'reporte_producao.num_ordem_producao = ordem_producao.num_ordem_producao');
        $this->db->join('produto', 'produto.cod_produto = ordem_producao.cod_produto');
        $this->db->where('reporte_producao.estornado = 0');
        $this->db->group_by('ordem_producao.cod_produto');
        $this->db->order_by('sum(reporte_producao.quant_reportada)', 'desc');

        $this->db->where("reporte_producao.data_reporte >= ", $dataInicio);
        $this->db->where("reporte_producao.data_reporte <= ", $dataFim);

        if($codProdutos != ""){
            $this->db->where_in('ordem_producao.cod_produto', $codProdutos);
        }

        return $query = $this->db->get()->result();
    }

    public function getConsumoPorduto($dataInicio, $dataFim){
        $this->db->where('ordem_producao.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('ordem_producao.cod_produto, sum(reporte_producao.quant_reportada) as quant_reportada');
        $this->db->from('reporte_producao');
        $this->db->join('ordem_producao', 'reporte_producao.num_ordem_producao = ordem_producao.num_ordem_producao');
        $this->db->where('reporte_producao.estornado = 0');
        $this->db->group_by('ordem_producao.cod_produto');
        $this->db->order_by('sum(reporte_producao.quant_reportada)', 'desc');

        return $query = $this->db->get()->result();
    }

    

}