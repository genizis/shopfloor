<?php

class NotaFiscal extends CI_Model
{
    var $table = 'notaFiscal';

    public function insert($data)
    {
        $resultado = $this->db->insert($this->table, $data);
        if ($resultado) return $this->db->insert_id();
        else return false;
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);

        $resultado =  $this->db->update($this->table, $data);

        return $resultado ? $id : false;
    }

    public function getCamposDestinatario()
    {
        $camposRT = ['id','nomeContato', 'tipoPessoa', 'cpf', 'cnpj', 'pais', 'contribuinte', 'inscricaoEstadual', 'cep', 'UF', 'municipio', 'bairro', 'endereco', 'numero', 'complemento', 'foneFax', 'email', 'vendedor','consumidorFinal'];
        $campos = '';
        $prefix = 'destinatario_';
        foreach ($camposRT as $key => $campo) {
            $campos .= ', ' . $this->NotaFiscalDestinatario->table . '.' . $campo . ' as ' . $prefix . $campo;
        }
        return $campos;
    }
    public function getCamposTransportador()
    {
        $camposRT = ['id','nome', 'freteConta', 'placaVeiculo', 'UFveiculo', 'RNTC', 'CNPJCPF', 'inscricaoEstadual', 'UF', 'municipio', 'endereco', 'quantidade', 'especie', 'marca', 'numero', 'presoBruto', 'pesoLiquido', 'logistica','enderecoEntregaDiferente'];
        $campos = '';
        $prefix = 'transportador_';
        foreach ($camposRT as $key => $campo) {
            $campos .= ', ' . $this->NotaFiscalTransportadorVolumes->table . '.' . $campo . ' as ' . $prefix . $campo;
        }
        return $campos;
    }

    public function getCamposEndereco()
    {
        $camposRT = ['id','nome', 'cep', 'UF', 'municipio', 'endereco', 'numero', 'bairro', 'complemento', 'pais'];
        $campos = '';
        $prefix = 'enderecoEntrega_';
        foreach ($camposRT as $key => $campo) {
            $campos .= ', ' . $this->NotaFiscalEnderecoEntrega->table . '.' . $campo . ' as ' . $prefix . $campo;
        }
        return $campos;
    }

    public function getCamposPagamento()
    {
        $camposRT = ['id','condicaoPagamento', 'FKIDCategoria'];
        $campos = '';
        $prefix = 'pagamento_';
        foreach ($camposRT as $key => $campo) {
            $campos .= ', ' . $this->NotaFiscalPagamento->table . '.' . $campo . ' as ' . $prefix . $campo;
        }
        return $campos;
    }
    public function getCamposImposto()
    {
        $camposRT = ['id','calculoAutomatico', 'baseICMS', 'valorICMS', 'baseICMSST', 'valorICMSST', 'totalServicos', 'totalProdutos', 'valorFrete', 'valorSeguro', 'outrasDespesas', 'valorIPI', 'valorISSQN', 'totalNota', 'desconto', 'valorFunrural', 'nItens', 'totalAtributos', 'totalFaturado'];
        $campos = '';
        $prefix = 'calculoimposto_';
        foreach ($camposRT as $key => $campo) {
            $campos .= ', ' . $this->NotaFiscalCalculoImposto->table . '.' . $campo . ' as ' . $prefix . $campo;
        }
        return $campos;
    }
    public function getCamposRetencoes()
    {
        $camposRT = ['id','minimoRetencao', 'baseRetencao', 'valorIR', 'valorCSLL', 'valorPISretido', 'valorCOFINSRetido', 'valorISSRetido'];
        $campos = '';
        $prefix = 'retencoes_';
        foreach ($camposRT as $key => $campo) {
            $campos .= ', ' . $this->NotaFiscalRetencoes->table . '.' . $campo . ' as ' . $prefix . $campo;
        }
        return $campos;
    }

    public function getCamposReferenciado()
    {
        $camposRT = ['id','tipo', 'chaveAcesso', 'numeroContador', 'anoMesEmissao', 'numero', 'serie'];
        $campos = '';
        $prefix = 'documento_';
        foreach ($camposRT as $key => $campo) {
            $campos .= ', ' . $this->NotaFiscalDocumentoReferenciado->table . '.' . $campo . ' as ' . $prefix . $campo;
        }
        return $campos;
    }

    public function getCamposAdicional()
    {
        $camposRT = ['id', 'numeroLojaVirtual', 'origemLojaVirtual', 'origemCanalVenda', 'informacoesComplementares'];
        $campos = '';
        $prefix = 'informacoesAdicionais_';
        foreach ($camposRT as $key => $campo) {
            $campos .= ', ' . $this->NotaFiscalInformacaoAdicional->table . '.' . $campo . ' as ' . $prefix . $campo;
        }
        return $campos;
    }
    public function getNotaFiscalXML($id)
    {
        $this->db->select($this->table. '.xml',$this->table.'.id');
        $this->db->where($this->table.'.id',$id);
        $this->db->from($this->table);

        return $this->db->get()->row();
    }
    public function getNotaFiscalIDFaturamento($idFaturamento)
    {
        $this->load->model('NaturezaOperacao');
        $this->load->model('NotaFiscalItem');
        $this->load->model('NotaFiscalDestinatario');
        $this->load->model('NotaFiscalTransportadorVolumes');
        $this->load->model('NotaFiscalEnderecoEntrega');
        $this->load->model('NotaFiscalPagamento');
        $this->load->model('NotaFiscalCalculoImposto');
        $this->load->model('NotaFiscalRetencoes');
        $this->load->model('NotaFiscalDocumentoReferenciado');
        $this->load->model('NotaFiscalInformacaoAdicional');
        $this->load->model('NotaFiscalPessoasAutorizadas');
        $this->load->model('NotaFiscalParcelasPagamento');
        
        $this->db->where($this->table . '.FKIDfaturamentoPedido', $idFaturamento);

        $this->db->join($this->NotaFiscalDestinatario->table, $this->NotaFiscalDestinatario->table . '.FKIDNotaFiscal = ' . $this->table . '.id', 'left');

        $this->db->join($this->NotaFiscalTransportadorVolumes->table, $this->NotaFiscalTransportadorVolumes->table . '.FKIDNotaFiscal = ' . $this->table . '.id', 'left');

        $this->db->join($this->NotaFiscalEnderecoEntrega->table, $this->NotaFiscalEnderecoEntrega->table . '.FKIDNotaFiscal = ' . $this->table . '.id', 'left');
    
        $this->db->join($this->NotaFiscalPagamento->table, $this->NotaFiscalPagamento->table . '.FKIDNotaFiscal = ' . $this->table . '.id', 'left');

        $this->db->join($this->NotaFiscalCalculoImposto->table, $this->NotaFiscalCalculoImposto->table . '.FKIDNotaFiscal = ' . $this->table . '.id', 'left');

        $this->db->join($this->NotaFiscalRetencoes->table, $this->NotaFiscalRetencoes->table . '.FKIDNotaFiscal = ' . $this->table . '.id', 'left');

        $this->db->join($this->NotaFiscalDocumentoReferenciado->table, $this->NotaFiscalDocumentoReferenciado->table . '.FKIDNotaFiscal = ' . $this->table . '.id', 'left');

        $this->db->join($this->NotaFiscalInformacaoAdicional->table, $this->NotaFiscalInformacaoAdicional->table . '.FKIDNotaFiscal = ' . $this->table . '.id', 'left');

        $this->db->join($this->NaturezaOperacao->table, $this->NaturezaOperacao->table . '.id = ' . $this->table . '.FKIDnaturezaOperacao', 'left');
        
        //FKIDnaturezaOperacaoText

        $natureza = $this->NaturezaOperacao->table;
        $naturezaOperacao = $natureza.'.descricao as FKIDnaturezaOperacaoText, 
        '.$natureza.'.InformacoesAdicionais as informacoesAdicionais_informacoesComplementaresFiscoNatureza,
        '.$natureza.'.InformacoesComplementares as informacoesAdicionais_informacoesComplementaresNatureza';

        //Join para pegar o segmento
        $this->db->select($this->table. '.*'.','.$naturezaOperacao. $this->getCamposDestinatario().$this->getCamposTransportador().$this->getCamposEndereco().$this->getCamposPagamento().$this->getCamposImposto().$this->getCamposRetencoes().$this->getCamposReferenciado().$this->getCamposAdicional());

        $this->db->from($this->table);

        $notaFiscal = $this->db->get()->row();

        if ($notaFiscal) {
            $notaFiscal->itensNota = $this->NotaFiscalItem->getNotalFiscal($notaFiscal->id) ;//cod_faturamento_pedido
            $notaFiscal->pessoasAutorizadas = $this->NotaFiscalPessoasAutorizadas->getNotalFiscal($notaFiscal->id);
            $notaFiscal->pagamentoItens = $this->NotaFiscalParcelasPagamento->getPagamento(@$notaFiscal->pagamento_id);
        }

        return $notaFiscal;
    }
}
