<?php

class COFINSRegrasTributacao extends CI_Model{    

 var $table = 'COFINS_regras_tributacao';

 var $tableEstado = 'COFINS_link_estado';
 var $tableProduto = 'COFINS_link_produtos';

 var $FKID = 'FKIDRegrasTributacaoCOFINS';

 public function insert($data){
  $resultado = $this->db->insert($this->table, $data);

  if($resultado) return $this->db->insert_id();
  else return false;
}

public function update($id, $data){
   $this->db->where('id', $id);

   $resultado =  $this->db->update($this->table, $data);

   return $resultado?$id:false;
}

public function getObjetoNatureza($id){

   $this->load->model('NaturezaOperacao');

   $this->db->where($this->table.'.FKIDNaturezaOperacao', $id);

   $this->db->select($this->table.'.*');
   $this->db->from($this->table);

   $query = $this->db->get()->result();

   if (is_array($query)) {
    foreach ($query as $key => $item) {
      $item->estados = $this->NaturezaOperacao->getObjetoEstado($item->id,$this->tableEstado,$this->FKID);
      $item->produtos = $this->NaturezaOperacao->getObjetoProduto($item->id,$this->tableProduto,$this->FKID);
   }
}

return $query;

} 


}