<?php

class Cliente extends CI_Model{    

    public function insertCliente($cliente){
        $this->db->insert('cliente', $cliente);

        return $this->db->insert_id();
    }

    public function updateCliente($CodCliente, $cliente){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 
        
        $this->db->where('cod_cliente', $CodCliente);
        $this->db->update('cliente', $cliente);

        if($this->db->affected_rows() > 0){
            return $CodCliente;
        }

        return NULL;
    }

    public function deleteCliente($CodCliente) {
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->where_in('cod_cliente',$CodCliente)->delete('cliente');

        if($this->db->error() <> null){
            return $this->db->error();
        }

        return null;
    }

    public function selectClienteOption($codCliente){

        $clientes = $this->getCliente();

        $options = "";
        $select = "";

        foreach($clientes as $cliente){
            if($codCliente == $cliente->cod_cliente)
                $select = "selected";
            else
                $select = "";

            $options .= "<option value='{$cliente->cod_cliente}' $select>$cliente->cod_cliente - $cliente->nome_cliente</option>".PHP_EOL;
        }

        return $options;

    }

    public function getCliente($filter = "", $limit = null, $offset = null){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        if($limit){
            $this->db->limit($limit, $offset);
        }

        //Join para pegar o segmento
        $this->db->select('cliente.*, segmento.nome_segmento');
        $this->db->select('(select count(*)
                              from pedido_venda
                             where pedido_venda.cod_cliente = cliente.cod_cliente) count_pedido');
        $this->db->from('cliente');
        $this->db->join('segmento', 'segmento.cod_segmento = cliente.cod_segmento');        

        if($filter <> ""){
            $this->db->group_start();
            $this->db->or_like('cod_cliente' ,$filter);
            $this->db->or_like('nome_cliente' ,$filter);
            $this->db->or_like('cnpj_cpf' ,$filter);
            $this->db->group_end();
            
        }
        
        return $query = $this->db->get()->result();
        
    }

    public function selectCliente($codCliente){

        $cliente = $this->getClientePorCodigo($codCliente);

        $input = "{$cliente->tipo_pessoa}|{$cliente->cnpj_cpf}";

        return $input;

    } 

    public function getClientePorCodigo($CodCliente){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('cliente.*, cidade.nome as nome_cidade, estado.uf');
        $this->db->join('cidade', 'cidade.id = cliente.cod_cidade', 'left');
        $this->db->join('estado', 'estado.id = cidade.estado', 'left');

        return $this->db->get_where('cliente', array('cod_cliente' => $CodCliente))->row();
    }

    public function getClientePorDocumento($CnpjCpf){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('cliente.*, cidade.nome as nome_cidade');
        $this->db->join('cidade', 'cidade.id = cliente.cod_cidade', 'left');
        $this->db->where('cliente.cnpj_cpf !=', null);
        $this->db->where('cod_vendas_externas', null); 

        return $this->db->get_where('cliente', array('cnpj_cpf' => $CnpjCpf))->row();
    }

    public function getClientePorCodigoVendasExternas($codClienteVendasExternas){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('cliente.*');
        return $this->db->get_where('cliente', array('cod_vendas_externas' => $codClienteVendasExternas))->row();
    }

    public function getClientePorNome($nomeCliente){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('cliente.*, cidade.nome as nome_cidade');
        $this->db->join('cidade', 'cidade.id = cliente.cod_cidade', 'left');
        $this->db->where('cnpj_cpf', null); 
        $this->db->limit(1);

        return $this->db->get_where('cliente', array('nome_cliente' => $nomeCliente))->row();
    }

    public function getClientePorRazaoSocial($razaoSocial){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->select('cliente.*');
        $this->db->where('cnpj_cpf', null); 
        $this->db->where('cod_vendas_externas', null); 
        $this->db->limit(1);

        return $this->db->get_where('cliente', array('razao_social' => $razaoSocial))->row();
    }

    public function getClienteContaAzulPorCodigo($idContaAzul){
        $this->db->where('cliente.id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        $this->db->from('cliente');
        $this->db->where('cliente.id_conta_azul', $idContaAzul);

        return $query = $this->db->get()->row();
    } 

    public function countAll(){
        $this->db->where('id_empresa', getDadosUsuarioLogado()['id_empresa']); 

        return $this->db->count_all_results('cliente');
    }

}