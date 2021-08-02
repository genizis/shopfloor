<?php

class ICMSRegrasTributacao  extends CI_Model{    

 var $table = 'ICMS_regras_tributacao';

 var $tableST = 'ICMS_situacao_tributaria';
 var $tableSTra = 'ICMS_substituicao_TRA';
 var $tablePart = 'ICMS_partilha';

 var $tableEstado = 'ICMS_link_estado';
 var $tableProduto = 'ICMS_link_produtos';

 var $FKID = 'FKIDRegrasTributacaoICMS';

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

public function insertSituacaoTributaria($data)
{
 $resultado = $this->db->insert($this->tableST, $data);

 if($resultado) return $this->db->insert_id();
 else return false;
}

public function updateSituacaoTributaria($id, $data)
{
  $this->db->where($this->FKID, $id);

  $resultado =  $this->db->update($this->tableST, $data);

  return $resultado?$id:false;
}

public function insertSubstituicaoTributaria($data)
{
 $resultado = $this->db->insert($this->tableSTra, $data);

 if($resultado) return $this->db->insert_id();
 else return false;
}

public function updateSubstituicaoTributaria($id, $data)
{
  $this->db->where($this->FKID, $id);

  $resultado =  $this->db->update($this->tableSTra, $data);

  return $resultado?$id:false;
}

public function insertPartilha($data)
{
 $resultado = $this->db->insert($this->tablePart, $data);

 if($resultado) return $this->db->insert_id();
 else return false;
}

public function updatePartilha($id, $data)
{
  $this->db->where($this->FKID, $id);

  $resultado =  $this->db->update($this->tablePart, $data);

  return $resultado?$id:false;
}

public function getCamposST()
{
  $camposRT = ['AliquotaICMS','BaseCalculoICMS','Base','MVA','PIS','COFINS','MargemAdicionalICMS','ValorPauta','ModalidadeBC'];
  $campos = '';
  $prefix = 'strib';
  foreach ($camposRT as $key => $campo) {
    $campos.=', '.$this->tableST.'.'.$campo.' as '.$prefix.$campo;
  }
  return $campos;
}

public function getCamposTrab()
{
  $camposRT = ['AliquotaICMS','BaseICMS'];
  $campos = '';
  $prefix = 'st';
  foreach ($camposRT as $key => $campo) {
    $campos.=', '.$this->tableSTra.'.'.$campo.' as '.$prefix.$campo;
  }
  return $campos;
}

public function getCamposPart()
{
  $camposRT = ['TipoTributacao','BaseCalculo','AliquotaInternaUFDestino','AliquotaFCP'];
  $campos = '';
  $prefix = 'pa';
  foreach ($camposRT as $key => $campo) {
    $campos.=', '.$this->tablePart.'.'.$campo.' as '.$prefix.$campo;
  }
  return $campos;
}



public function getObjetoNatureza($id){

 $this->load->model('NaturezaOperacao');

 $this->db->where($this->table.'.FKIDNaturezaOperacao', $id);

 $this->db->join($this->tableST, $this->tableST.'.'.$this->FKID.' = '.$this->table.'.id'); 
 $this->db->join($this->tableSTra, $this->tableSTra .'.'.$this->FKID.' = '.$this->table.'.id');
 $this->db->join($this->tablePart, $this->tablePart .'.'.$this->FKID.' = '.$this->table.'.id');

 $this->db->select($this->table.'.*'.$this->getCamposST().$this->getCamposTrab().$this->getCamposPart());
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