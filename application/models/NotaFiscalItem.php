<?php

class NotaFiscalItem extends CI_Model
{
    var $table = 'notaFiscalItens';

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

    public function getCamposICMS()
    {

        $camposRT = ['id', 'situacaoTributaria', 'codigoSituacao', 'origem', 'modalidadeBC', 'aplicCred', 'valorAplicCred', 'valorPauta', 'baseICMS', 'valorBaseICMS', 'difICMS', 'presumido', 'ICMS', 'valorICMS', 'posicaoAliquota', 'FCP', 'valorFCP', 'ICMSdesonerado', 'motivoDesonerado', 'codigoBeneficio', 'informacoesComplementares', 'informacoesCompIFICMS'];
        $campos = '';
        $prefix = 'icms_';
        foreach ($camposRT as $key => $campo) {
            $campos .= ', ' . $this->NotaFiscalItensICMS->table . '.' . $campo . ' as ' . $prefix . $campo;
        }
        return $campos;
    }

    public function getCamposICMSST()
    {

        $camposRT = ['id',  'modalidadeBC', 'valorPauta', 'percentualMargem', 'baseICMS', 'valorICMS', 'aliqICMS', 'valorBasePIS', 'aliqPIS', 'valorPIS', 'valorBaseCOFINS', 'aliqCOFINS', 'valorCONFIS'];
        $campos = '';
        $prefix = 'icms_ST';
        foreach ($camposRT as $key => $campo) {
            $campos .= ', ' . $this->NotaFiscalItensICMSST->table . '.' . $campo . ' as ' . $prefix . $campo;
        }
        return $campos;
    }

    public function getCamposIPI()
    {

        $camposRT = ['id',  'situacaoTributaria', 'aliqIPI', 'baseIPI', 'valorBaseIPI', 'valorIPI', 'codEnquad', 'codExcecaoTIPI', 'informacoesComp', 'informacoesCompIF'];
        $campos = '';
        $prefix = 'ipi_';
        foreach ($camposRT as $key => $campo) {
            $campos .= ', ' . $this->notaFiscalItensIPI->table . '.' . $campo . ' as ' . $prefix . $campo;
        }
        return $campos;
    }

    public function getCamposICMSSTR()
    {

        $camposRT = ['id', 'valorICMSsub', 'valorBaseICMS', 'baseICMS', 'aliqICMS', 'valorICMS'];
        $campos = '';
        $prefix = 'icms_STR';
        foreach ($camposRT as $key => $campo) {
            $campos .= ', ' . $this->NotaFiscalItensICMSSTR->table . '.' . $campo . ' as ' . $prefix . $campo;
        }
        return $campos;
    }

    public function getCamposPIS()
    {

        $camposRT = ['id',  'situacaoTributaria', 'basePIS', 'valorBase', 'aliqPIS', 'valorPIS', 'valorFixoPIS', 'informacoesComp', 'informacoesCompIF'];
        $campos = '';
        $prefix = 'pis_';
        foreach ($camposRT as $key => $campo) {
            $campos .= ', ' . $this->notaFiscalItensPIS->table . '.' . $campo . ' as ' . $prefix . $campo;
        }
        return $campos;
    }
    public function getCamposCOFINS()
    {

        $camposRT = ['id', 'situacaoTributaria', 'baseCONFIS', 'valorCONFIS', 'valorBaseCONFIS', 'aliqCONFIS', 'valorFixoCONFIS', 'informacoesComp', 'informacoesCompIF'];
        $campos = '';
        $prefix = 'confis_';
        foreach ($camposRT as $key => $campo) {
            $campos .= ', ' . $this->NotaFiscalItensCONFIS->table . '.' . $campo . ' as ' . $prefix . $campo;
        }
        return $campos;
    }
    public function getCamposRetencoes()
    {
        $camposRT = ['id', 'impostoRetido', 'aliqIR', 'baseIR', 'valorIR', 'aliqCSLL', 'valorCSLL'];
        $campos = '';
        $prefix = 'retencoes_';
        foreach ($camposRT as $key => $campo) {
            $campos .= ', ' . $this->NotaFiscalItensRetencoes->table . '.' . $campo . ' as ' . $prefix . $campo;
        }
        return $campos;
    }
    public function getCamposOutros()
    {
        $camposRT = ['id','presumidoCalculo', 'aliqFunrural', 'tipoItem', 'baseComissao', 'aliquotaComissao', 'valorComissao', 'numeroPedido', 'nrItemPedido', 'aproxTrib', 'valorAproxTrib', 'unidadeTributaria', 'quantidadeTributaria', 'valorUnitario', 'valorOutrasDespesas'];
        $campos = '';
        $prefix = 'outros_';
        foreach ($camposRT as $key => $campo) {
            $campos .= ', ' . $this->NotaFiscalItensOutros->table . '.' . $campo . ' as ' . $prefix . $campo;
        }
        return $campos;
    }

    public function getNotalFiscal($id)
    {
        $this->load->model('NaturezaOperacao');
        $this->load->model('NotaFiscalItensICMS');
        $this->load->model('NotaFiscalItensICMSST');
        $this->load->model('NotaFiscalItensICMSSTR');
        $this->load->model('notaFiscalItensIPI');
        $this->load->model('notaFiscalItensPIS');
        $this->load->model('NotaFiscalItensCONFIS');
        $this->load->model('NotaFiscalItensRetencoes');
        $this->load->model('NotaFiscalItensOutros');
        
        
        $this->db->where($this->table . '.FKIDNotaFiscal', $id);

        //Join para pegar o segmento ICMS
        $this->db->join($this->NotaFiscalItensICMS->table, $this->NotaFiscalItensICMS->table . '.FKIDItensNotaFiscal = ' . $this->table . '.id', 'left');
        $this->db->join($this->NotaFiscalItensICMSST->table, $this->NotaFiscalItensICMSST->table . '.FKIDICMSItensNotaFiscal = ' . $this->NotaFiscalItensICMS->table . '.id', 'left');
        $this->db->join($this->NotaFiscalItensICMSSTR->table, $this->NotaFiscalItensICMSSTR->table . '.FKIDICMSItensNotaFiscal = ' . $this->NotaFiscalItensICMS->table . '.id', 'left');

        $this->db->join($this->notaFiscalItensIPI->table, $this->notaFiscalItensIPI->table . '.FKIDItensNotaFiscal = ' . $this->table . '.id', 'left');

        $this->db->join($this->notaFiscalItensPIS->table, $this->notaFiscalItensPIS->table . '.FKIDItensNotaFiscal = ' . $this->table . '.id', 'left');

        $this->db->join($this->NotaFiscalItensCONFIS->table, $this->NotaFiscalItensCONFIS->table . '.FKIDItensNotaFiscal = ' . $this->table . '.id', 'left');

        $this->db->join($this->NotaFiscalItensRetencoes->table, $this->NotaFiscalItensRetencoes->table . '.FKIDItensNotaFiscal = ' . $this->table . '.id', 'left');

        $this->db->join($this->NotaFiscalItensOutros->table, $this->NotaFiscalItensOutros->table . '.FKIDItensNotaFiscal = ' . $this->table . '.id', 'left');

        $this->db->join($this->NaturezaOperacao->table, $this->NaturezaOperacao->table . '.id = ' . $this->table . '.FKIDNaturezaOperacao', 'left');

        $natureza = $this->NaturezaOperacao->table;
        $naturezaOperacao = $natureza.'.descricao as FKIDNaturezaOperacaoText';


        $this->db->select($this->table . '.*,'.$naturezaOperacao. $this->getCamposICMS() . $this->getCamposICMSST() . $this->getCamposICMSSTR() . $this->getCamposIPI() . $this->getCamposPIS() . $this->getCamposCOFINS().$this->getCamposRetencoes().$this->getCamposOutros());
        $this->db->from($this->table);

    
        
        $lista = $this->db->get()->result();

        return $lista;
    }
}
