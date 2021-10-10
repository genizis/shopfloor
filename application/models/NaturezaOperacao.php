<?php

class NaturezaOperacao extends CI_Model{    

    var $table = 'natureza_operacao';
    var $tableRT = 'retencoes_regras_tributacao';
    var $tableORT = 'outros_regras_tributacao';

    public function insert($data){
       $resultado = $this->db->insert($this->table, $data);

       if($resultado) return $this->db->insert_id();
       else return  $resultado ;
   }

   public function update($id, $data){

    $this->db->where('id', $id);

    $resultado =  $this->db->update($this->table, $data);

    return $resultado?$id:false;
}

public function insertEstados($ufs, $id, $FKID,$tableEstado)
{
  $this->load->model('Estado');

  $this->db->delete($tableEstado, array($FKID => $id)); //Deletar vinculos Estados cadastrados

  $data = [];
  foreach ($ufs as $key => $uf) {
   $data[] = [$FKID=>$id,'FKIDEstado'=> $this->Estado->buscarPorUF($uf)->id];
}

return $this->db->insert_batch($tableEstado, $data);

}

public function insertProdutos($produtos, $id, $FKID, $tableProduto)
{
   $dataInsert = $dataUpdate = [];
   $tipos = ['ncm'=>'ncm','produto'=>'produto','grupoProduto'=>'grupoProdutos'];

   foreach ($produtos as $key => $linha) {

    $indexProduto = $tipos[$linha['tipo']];
    if (!isset($linha['cad'])) {//Verificar se é um novo objeto
       $dataUpdate[] = ['id'=>$linha['id'],$FKID=>$id,'tipo'=> $linha['tipo'], 'FKIDProduto'=>$linha[$indexProduto]];
   }else{
    $dataInsert[] = [$FKID=>$id,'tipo'=> $linha['tipo'], 'FKIDProduto'=>$linha[$indexProduto]];
}

}

if(count($dataUpdate)>0)//Editar
$this->db->update_batch($tableProduto, $dataUpdate,'id');

if(count($dataInsert)>0)//Cadastrar
$this->db->insert_batch($tableProduto, $dataInsert);

return true;
}

public function verificarVinculoRegraNatureza($tabelaRegra, $id)
{
    $this->db->where($tabelaRegra.'.id', $id);
        $this->db->where($this->table.'.empresaIDFK', getDadosUsuarioLogado()['id_empresa']);//Verificar se é da mesma empresa
        $this->db->join($this->table, $tabelaRegra.'.FKIDNaturezaOperacao = '.$this->table.'.id'); 

        return $this->db->count_all_results($tabelaRegra);
    }

    public function deleteRegras($id, $regra)
    {
        switch($regra){
            case 'ICMS':
            $this->load->model('ICMSRegrasTributacao');

         //Regra de segurança - verificar se a regra esta relacionada com a empresa do usuario, permitindo que ele exclua apenas as deles
            if($this->verificarVinculoRegraNatureza($this->ICMSRegrasTributacao->table, $id)==0) return false;

        return $this->deleteFuncao($id, $this->ICMSRegrasTributacao->table); //Deletar Regras cadastradas
        break;

        case 'IPI':
        $this->load->model('IPIRegrasTributacao');

        //Regra de segurança - verificar se a regra esta relacionada com a empresa do usuario, permitindo que ele exclua apenas as deles
        if($this->verificarVinculoRegraNatureza($this->IPIRegrasTributacao->table, $id)==0) return false;

        return $this->deleteFuncao($id, $this->IPIRegrasTributacao->table); //Deletar Regras cadastradas
        break;

        case 'PIS':
        $this->load->model('PISRegrasTributacao');

        //Regra de segurança - verificar se a regra esta relacionada com a empresa do usuario, permitindo que ele exclua apenas as deles
        if($this->verificarVinculoRegraNatureza($this->PISRegrasTributacao->table, $id)==0) return false;

        return $this->deleteFuncao($id, $this->PISRegrasTributacao->table); //Deletar Regras cadastradas
        break;

        case 'COFINS':
        $this->load->model('COFINSRegrasTributacao');

        //Regra de segurança - verificar se a regra esta relacionada com a empresa do usuario, permitindo que ele exclua apenas as deles
        if($this->verificarVinculoRegraNatureza($this->COFINSRegrasTributacao->table, $id)==0) return false;

        return $this->deleteFuncao($id, $this->COFINSRegrasTributacao->table); //Deletar Regras cadastradas
        break;

        case 'II':
        $this->load->model('IIRegrasTributacao');

        //Regra de segurança - verificar se a regra esta relacionada com a empresa do usuario, permitindo que ele exclua apenas as deles
        if($this->verificarVinculoRegraNatureza($this->IIRegrasTributacao->table, $id)==0) return false;

        return $this->deleteFuncao($id, $this->IIRegrasTributacao->table); //Deletar Regras cadastradas
        break;

        case 'ISSQN':
        $this->load->model('ISSQNRegrasTributacao');

        //Regra de segurança - verificar se a regra esta relacionada com a empresa do usuario, permitindo que ele exclua apenas as deles
        if($this->verificarVinculoRegraNatureza($this->ISSQNRegrasTributacao->table, $id)==0) return false;

        return $this->deleteFuncao($id, $this->ISSQNRegrasTributacao->table); //Deletar Regras cadastradas
        break;
        default:
        return false;
    }

}

public function deleteProdutos($id, $regra)
{
    switch($regra){
        case 'ICMS':
        $this->load->model('ICMSRegrasTributacao');
        return $this->deleteFuncao($id, $this->ICMSRegrasTributacao->tableProduto); //Deletar vinculos Estados cadastrados
        break;

        case 'IPI':
        $this->load->model('IPIRegrasTributacao');
        return $this->deleteFuncao($id, $this->IPIRegrasTributacao->tableProduto); //Deletar vinculos Estados cadastrados
        break;

        case 'PIS':
        $this->load->model('PISRegrasTributacao');
        return $this->deleteFuncao($id, $this->PISRegrasTributacao->tableProduto); //Deletar vinculos Estados cadastrados
        break;

        case 'COFINS':
        $this->load->model('COFINSRegrasTributacao');
        return $this->deleteFuncao($id, $this->COFINSRegrasTributacao->tableProduto); //Deletar vinculos Estados cadastrados
        break;

        case 'II':
        $this->load->model('IIRegrasTributacao');
        return $this->deleteFuncao($id, $this->IIRegrasTributacao->tableProduto); //Deletar vinculos Estados cadastrados
        break;

        case 'ISSQN':
        $this->load->model('ISSQNRegrasTributacao');
        return $this->deleteFuncao($id, $this->ISSQNRegrasTributacao->tableProduto); //Deletar vinculos Estados cadastrados
        break;
        default:
        return false;
    }

}


public function deleteFuncao($id, $table)
{
    return $this->db->delete($table, array('id' => $id));
}

public function insertRetencoesRegrasTributacao($data){
   $resultado = $this->db->insert($this->tableRT, $data);

   if($resultado) return $this->db->insert_id();
   else return  $resultado ;
}

public function updateRetencoesRegrasTributacao($id, $data){
   $this->db->where('FKIDNaturezaOperacao', $id);

   $resultado =  $this->db->update($this->tableRT, $data);

   return $resultado?$id:false;
}

public function insertOutrosRegrasTributacao($data){
   $resultado = $this->db->insert($this->tableORT, $data);

   if($resultado) return $this->db->insert_id();
   else return  $resultado ;
}

public function updateOutrosRegrasTributacao($id, $data){
    $this->db->where('FKIDNaturezaOperacao', $id);
    $resultado = $this->db->update($this->tableORT, $data);

    return $resultado?$id:false;
}



public function getNaturezaOperacao($filter = "", $limit = null, $offset = null){
    $this->db->where($this->table.'.empresaIDFK', getDadosUsuarioLogado()['id_empresa']);

    if($limit){
        $this->db->limit($limit, $offset);
    }

        //Join para pegar o segmento
    $this->db->select($this->table.'.*');
    $this->db->from($this->table);       

    if($filter <> ""){
        $this->db->group_start();
        $this->db->or_like('descricao' ,$filter);
        $this->db->or_like('serie' ,$filter);
        $this->db->group_end();

    }

    $query = $this->db->get()->result();

    return $query ;
}


public function getCamposRetencaoImpostos()
{
   $camposRT = ['RetencaoImpostos','AliquotaCSLL','AliquotaIRRetido'];
   $campos = '';
   foreach ($camposRT as $key => $campo) {
      $campos.=', '.$this->tableRT.'.'.$campo;
  }
  return $campos;
}

public function getCamposOutrosRegrasTributacao()
{
   $camposRT = ['presumidoCalculoPisCofins','somarOutrasDespesas','compraProdutorRural','descontarFunRuralTotal','aliquotaFunrural','tipoAproxTrib','tributos','tipoDesconto'];
   $campos = '';
   foreach ($camposRT as $key => $campo) {
      $campos.=', '.$this->tableORT.'.'.$campo;
  }
  return $campos;
}
public function getObjetoTextSelect($descricao){
    $this->db->where($this->table.'.empresaIDFK', getDadosUsuarioLogado()['id_empresa']);

    $this->db->select($this->table.'.descricao,id,InformacoesComplementares,InformacoesAdicionais');
    $this->db->from($this->table);
    $this->db->or_like($this->table.'.descricao', '%'.$descricao.'%');

    $query = $this->db->get()->result();

    return $query;
} 

public function getObjetoID($id){
    $this->db->where($this->table.'.empresaIDFK', getDadosUsuarioLogado()['id_empresa']);

    $this->db->join($this->tableRT, $this->tableRT.'.FKIDNaturezaOperacao = '.$this->table.'.id','left'); 
    $this->db->join($this->tableORT, $this->tableORT .'.FKIDNaturezaOperacao = '.$this->table.'.id','left');



    $this->db->select($this->table.'.*'.$this->getCamposRetencaoImpostos().$this->getCamposOutrosRegrasTributacao());
    $this->db->from($this->table);
    $this->db->where($this->table.'.id', $id);
    

    $query = $this->db->get()->row();
    if (isset($query->id)) {
        //ICMS
        $this->load->model('ICMSRegrasTributacao');
        $query->ICMS = $this->ICMSRegrasTributacao->getObjetoNatureza($query->id);


        //IPI
        $this->load->model('IPIRegrasTributacao');
        $query->IPI = $this->IPIRegrasTributacao->getObjetoNatureza($query->id);
        

        //PIS
        $this->load->model('PISRegrasTributacao');
        $query->PIS = $this->PISRegrasTributacao->getObjetoNatureza($query->id);

        //COFINS
        $this->load->model('COFINSRegrasTributacao');
        $query->COFINS = $this->COFINSRegrasTributacao->getObjetoNatureza($query->id);

        //II
        $this->load->model('IIRegrasTributacao');
        $query->II = $this->IIRegrasTributacao->getObjetoNatureza($query->id);

        //ISSQN
        $this->load->model('ISSQNRegrasTributacao');
        $query->ISSQN = $this->ISSQNRegrasTributacao->getObjetoNatureza($query->id);
    }


    return $query;
} 

public function deleteNatureza($id) {
    $this->db->where($this->table.'.empresaIDFK', getDadosUsuarioLogado()['id_empresa']); 

    $this->db->where_in('id',$id)->delete($this->table);

    if($this->db->error() <> null){
        return $this->db->error();
    }

    return null;
}

public function countObjetoID($id){
    $this->db->where($this->table.'.empresaIDFK', getDadosUsuarioLogado()['id_empresa']);
    $this->db->where($this->table.'.id', $id);

    return $this->db->count_all_results($this->table);
} 

public function countAll($filter){

    $this->db->where($this->table.'.empresaIDFK', getDadosUsuarioLogado()['id_empresa']); 


    if($filter <> ""){
        $this->db->group_start();
        $this->db->or_like('descricao' ,$filter);
        $this->db->or_like('serie' ,$filter);
        $this->db->group_end();

    }

    return $this->db->count_all_results($this->table);
}

public  function getObjetoProduto($idfk, $tableProduto,$nomeFKID){ //Buscar produtos vinculados as regras
 $this->load->model('Produto');
 $this->load->model('TipoProduto');

 $this->db->where($tableProduto.'.'.$nomeFKID, $idfk);

 $this->db->select($tableProduto.'.*');
 $this->db->from($tableProduto);

 $query = $this->db->get()->result();

 $lista = [];

 foreach ($query as $key => $value){

    switch($value->tipo){
      case 'ncm':
      $objeto = $this->Produto->getNCMID($value->FKIDProduto);

      $value->ncm = $value->FKIDProduto;
      $value->ncmText = isset($objeto->desc_ncm)?$objeto->desc_ncm:'';
      break;
      case 'produto':
      $objeto = $this->Produto->getProdutoID($value->FKIDProduto);

      $value->produto = $value->FKIDProduto;
      $value->produtoText =  isset($objeto->descricao)?$objeto->descricao:'';
      break;
      case 'grupoProduto':
      $objeto = $this->TipoProduto->getTipoProdutoPorCodigo($value->FKIDProduto);
      $value->grupoProdutos = $value->FKIDProduto;
      $value->grupoProdutosText = isset($objeto->nome_tipo_produto)?$objeto->nome_tipo_produto:'';
      break;
  }

  $lista[] = $value;

}


return $lista;

} 

public  function getObjetoEstado($idfk,$tableEstado,$nomeFKID){ //Buscar estados vinculados

   $this->db->where($tableEstado.'.'.$nomeFKID, $idfk);

   $this->db->join('estado', 'estado.id = '.$tableEstado.'.FKIDEstado');

   $this->db->select('estado.uf');
   $this->db->from($tableEstado);

   $query = $this->db->get()->result();

   $lista = [];

   foreach ($query as $key => $value)
    $lista[] = $value->uf;

return $lista;

} 


}