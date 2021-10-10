<?php

class NotaFiscalParcelasPagamento extends CI_Model
{
    var $table = 'notaFiscalParcelasPagamento';

    public function insert($data)
    {
        $resultado = $this->db->insert($this->table, $data);
       // var_dump($this->db->error()); //exibir erro
        if ($resultado) return $this->db->insert_id();
        else return false;
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);

        $resultado =  $this->db->update($this->table, $data);

        return $resultado ? $id : false;
    }
    public function delete($id)
    {
        return $this->db->delete($this->table, array('id' => $id));
    }
    public function getPagamento($id)
    {
        $this->db->where($this->table . '.FKIDPagamentoNotaFiscal', $id);

        $this->db->select($this->table . '.*' );
        $this->db->from($this->table);

        $lista = $this->db->get()->result();

        return $lista;
    }

}
