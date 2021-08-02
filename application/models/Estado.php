<?php

class Estado extends CI_Model{    
    var $table = 'estado';

    public function buscarPorUF($cod){
        return $this->db->get_where($this->table, array('uf' => $cod))->row();
    }    

}