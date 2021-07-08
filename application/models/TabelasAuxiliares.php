<?php

class TabelasAuxiliares extends CI_Model{

    public function getCidade(){

        $this->db->select('cidade.*, estado.uf');
        $this->db->from('cidade');
        $this->db->join('estado', 'estado.id = cidade.estado');
        $this->db->where('cidade.id !=', 0);
        $this->db->order_by('cidade.nome');

        return $query = $this->db->get()->result();

    } 

    public function getCidadePorEstado($idEstado = null){
                
        return $this->db->where('estado', $idEstado)->order_by('nome')->get('cidade')->result();
        
    } 

    public function selectCidade($idEstado = null){

        $cidades = $this->getCidadePorEstado($idEstado);

        $options = "";

        foreach($cidades as $cidade){
            $options .= "<option value='{$cidade->id}'>$cidade->nome</option>".PHP_EOL;
        }

        return $options;

    }
    
    public function getEstado(){
                
        return $this->db->where('id !=', 0)->get('estado')->result();
        
    } 

    public function getSegmento(){
                
        return $this->db->get('segmento')->result();
        
    } 

    public function getSegmentoPorNome($nomeSegmento){

        $this->db->from('segmento');
        $this->db->where('segmento.nome_segmento', $nomeSegmento);

        return $query = $this->db->get()->row();
    }

    public function getEstadoPorSigla($siglaEstado){

        $this->db->from('estado');
        $this->db->where('estado.uf', $siglaEstado);

        return $query = $this->db->get()->row();
    }

    public function getCidadePorNome($nomeCidade, $uf){

        $this->db->select('cidade.*');
        $this->db->from('cidade');
        $this->db->join('estado', 'estado.id = cidade.estado');
        $this->db->where('cidade.nome', $nomeCidade);
        $this->db->where('estado.uf', $uf);

        return $query = $this->db->get()->row();
    }

}