<?php

class notaFiscalItensIPI extends CI_Model
{
    var $table = 'notaFiscalItensIPI';

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

}
