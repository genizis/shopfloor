<?php
defined('BASEPATH') or exit('No direct script access allowed');

class NotaFiscalController extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if (usuarioLogado() == false) {

            redirect(base_url("login"), "home", "refresh");
        }
    }
    public function formNotaFiscal()
    {
        return '';
    }
    public function getNotaFiscalIDFaturamento()
    {
        $this->load->model('NotaFiscal');
        $id = $this->input->get('id');

        echo json_encode($this->NotaFiscal->getNotaFiscalIDFaturamento($id));
    }

    public function getProdutoFaturamento()
    {
        $this->load->model('tipoProduto');
        $id = $this->input->get('id');

        echo json_encode($this->venda->getProdutoFaturadoPorFaturamento($id));
    }

    public function inserirNotaFiscal()
    {
        $this->load->model('NotaFiscal');

    // var_dump($this->input->post('calculoimposto_calculoAutomatico'));
       // return '';

        $camposNotaFiscal = [
            'int' =>
            ['intermediador'],
            'text' =>
            ['FKIDfaturamentoPedido', 'tipoSaida', 'serie', 'numero', 'loja', 'FKIDunidade', 'FKIDnaturezaOperacao', 'dataEmissao', 'horaEmissao', 'dataSaida', 'horaSaida', 'codigoRegimeTributario', 'finalidade', 'indicadorPresenca', 'exportacaoLocal', 'exportacaoLocalUF', 'intermediadorCNPJ','intermediadorID']
        ];

        $data = [
            'empresaIDFK' => getDadosUsuarioLogado()['id_empresa']
        ];

        foreach ($camposNotaFiscal as $key => $lista) { //Popular $data
            $default = $key == 'int' ? 0 : null;
            foreach ($lista as $chav => $campo)
                $data[$campo] = $this->input->post($campo) ? $this->input->post($campo) : $default;
        }
        $idEdicao = $this->input->post('id'); //Se existir Editar

        if ($idEdicao != null) { //Editar
            //Gravar no banco, Edição
            $idNota = $this->NotaFiscal->update($idEdicao, $data);
        } else {
            //Gravar no banco, retornar ID nota da operação
            $idNota = $this->NotaFiscal->insert($data);
        }

        if (!$idNota) //Se não cadastrou a nota
            return responseJson($this, [
                'resultado' => false,
                'msg' => 'Erro ao salvar no banco,',
                'error' => $this->NotaFiscal->db->error()
            ]); //Retornar erros

        //Detalhes

        //Destinatario
        $this->load->model('NotaFiscalDestinatario');

        $this->salvarObjetoRegraFiscal(
            'destinatario_',
            ['consumidorFinal'],
            [
                'nomeContato', 'tipoPessoa', 'cpf', 'cnpj', 'pais', 'contribuinte', 'inscricaoEstadual', 'cep', 'UF', 'municipio', 'bairro', 'endereco', 'numero', 'complemento', 'foneFax', 'email', 'vendedor'
            ],
            ['FKIDNotaFiscal' => $idNota],
            $this->input->post(),
            $this->NotaFiscalDestinatario
        );

        //Cálculo de imposto
        $this->load->model('NotaFiscalCalculoImposto');
        $this->salvarObjetoRegraFiscal(
            'calculoimposto_',
            ['calculoAutomatico'],
            [
                'baseICMS', 'valorICMS', 'baseICMSST', 'valorICMSST', 'totalServicos', 'totalProdutos', 'valorFrete', 'valorSeguro', 'outrasDespesas', 'valorIPI', 'valorISSQN', 'totalNota', 'desconto', 'valorFunrural', 'nItens', 'totalAtributos', 'totalFaturado'
            ],
            ['FKIDNotaFiscal' => $idNota],
            $this->input->post(),
            $this->NotaFiscalCalculoImposto
        );

        //Retenções
        $this->load->model('NotaFiscalRetencoes');

        $this->salvarObjetoRegraFiscal(
            'retencoes_',
            [],
            [
                'minimoRetencao', 'baseRetencao', 'valorIR', 'valorCSLL', 'valorPISretido', 'valorCOFINSRetido', 'valorISSRetido'
            ],
            ['FKIDNotaFiscal' => $idNota],
            $this->input->post(),
            $this->NotaFiscalRetencoes
        );

        //Transportador de volumes
        $this->load->model('NotaFiscalTransportadorVolumes');

        $this->salvarObjetoRegraFiscal(
            'transportador_',
            ['enderecoEntregaDiferente'],
            [
                'nome', 'freteConta', 'placaVeiculo', 'UFveiculo', 'RNTC', 'CNPJCPF', 'inscricaoEstadual', 'UF', 'municipio', 'endereco', 'quantidade', 'especie', 'marca', 'numero', 'presoBruto', 'pesoLiquido', 'logistica'
            ],
            ['FKIDNotaFiscal' => $idNota],
            $this->input->post(),
            $this->NotaFiscalTransportadorVolumes
        );

        //EnderecoEntrega
        $this->load->model('NotaFiscalEnderecoEntrega');

        $this->salvarObjetoRegraFiscal(
            'enderecoEntrega_',
            [],
            [
                'nome', 'cep', 'UF', 'municipio', 'endereco', 'numero', 'bairro', 'complemento', 'pais'
            ],
            ['FKIDNotaFiscal' => $idNota],
            $this->input->post(),
            $this->NotaFiscalEnderecoEntrega
        );

        //Documento referenciado
        $this->load->model('NotaFiscalDocumentoReferenciado');

        $this->salvarObjetoRegraFiscal(
            'documento_',
            [],
            [
                'tipo', 'chaveAcesso', 'numeroContador', 'anoMesEmissao', 'numero', 'serie'
            ],
            ['FKIDNotaFiscal' => $idNota],
            $this->input->post(),
            $this->NotaFiscalDocumentoReferenciado
        );

        //InformacaoAdicional
        $this->load->model('NotaFiscalInformacaoAdicional');

        $this->salvarObjetoRegraFiscal(
            'informacoesAdicionais_',
            [],
            [
                'numeroLojaVirtual', 'origemLojaVirtual', 'origemCanalVenda', 'informacoesComplementares'
            ],
            ['FKIDNotaFiscal' => $idNota],
            $this->input->post(),
            $this->NotaFiscalInformacaoAdicional
        );

        //NotaFiscalPagamento
        $this->load->model('NotaFiscalPagamento');

        $idRegra = $this->salvarObjetoRegraFiscal(
            'pagamento_',
            [],
            [
                'condicaoPagamento', 'FKIDCategoria'
            ],
            ['FKIDNotaFiscal' => $idNota],
            $this->input->post(),
            $this->NotaFiscalPagamento
        );

        //NotaFiscalPagamentosItem 
        if ($idRegra) {
            $this->load->model('NotaFiscalParcelasPagamento');

            $campos = [
                'dias', 'data', 'valor', 'FKIDFormaPagamento', 'observacao'
            ];
            if ($this->input->post('pagamento_itens'))
                foreach ($this->input->post('pagamento_itens') as $key => $item) {

                    $this->salvarObjetoRegraFiscal(
                        '',
                        [],
                        $campos,
                        ['FKIDPagamentoNotaFiscal' => $idRegra],
                        $item,
                        $this->NotaFiscalParcelasPagamento
                    );
                    /*                    
                    foreach ($campos as $key => $campo) {
                        $info[$campo] = $item[$campo] ? $item[$campo] : null;
                    }
                    $idEdicao = isset($item['id']) ? $item['id'] : null; //Se existir Editar
                    if ($idEdicao != null) { //Edição
                        $idRegra = $this->NotaFiscalParcelasPagamento->update($idEdicao, $info);
                    } else
                        $idRegra = $this->NotaFiscalParcelasPagamento->insert($info); //Cadastro    
              */
                }
            //pessoas_autorizadas
            $this->load->model('NotaFiscalPessoasAutorizadas');
            $campos = [
                'FKIDContato', 'CPFCNPJ'
            ];

            if ($this->input->post('pessoas_autorizadas'))
                foreach ($this->input->post('pessoas_autorizadas') as $key => $item) {

                    $this->salvarObjetoRegraFiscal(
                        '',
                        [],
                        $campos,
                        ['FKIDNotaFiscal' => $idNota],
                        $item,
                        $this->NotaFiscalPessoasAutorizadas
                    );
                    /*
                    $info = ['FKIDNotaFiscal' => $idNota];
                    foreach ($campos as $key => $campo) {
                        $info[$campo] = $item[$campo] ? $item[$campo] : null;
                    }
                    $idEdicao = isset($item['id']) ? $item['id'] : null; //Se existir Editar
                    if ($idEdicao != null) { //Edição
                        $idRegra = $this->NotaFiscalPessoasAutorizadas->update($idEdicao, $info);
                    } else
                        $idRegra = $this->NotaFiscalPessoasAutorizadas->insert($info); //Cadastro    
               */
                }
        }

        //Itens da Nota
        $this->load->model('NotaFiscalItem');

        $this->load->model('NotaFiscalItensICMS');
        $this->load->model('notaFiscalItensICMSST');
        $this->load->model('notaFiscalItensICMSSTR');

        $this->load->model('notaFiscalItensIPI');
        $this->load->model('notaFiscalItensCONFIS');
        $this->load->model('notaFiscalItensPIS');
        $this->load->model('notaFiscalItensRetencoes');
        $this->load->model('notaFiscalItensOutros');


        //NotaFiscalItensISSQN
        //NotaFiscalItensEstoque
        $camposInt = ['faturado'];
        $campos = [
            'faturado', 'FKIDNaturezaOperacao', 'descricao', 'codigo', 'tipo', 'quantidade', 'unidade', 'valorUnitario', 'valorTotal', 'valorFrete', 'valorDesconto', 'tipoDesconto', 'CFOP', 'NCM', 'CEST', 'GTINEAN', 'GTINEANTrib', 'informacoesComplementares', 'informacoesCompItem', 'informacoesCompIFItem'
        ];

        if ($this->input->post('itens_nota')) {
            foreach ($this->input->post('itens_nota') as $key => $camposInput) { //Popular $info

                $idNota = $this->salvarObjetoRegraFiscal(
                    '',
                    $camposInt,
                    $campos,
                    ['FKIDNotaFiscal' => $idNota],
                    $camposInput,
                    $this->NotaFiscalItem
                );
                /*
                $info = ['FKIDNotaFiscal' => $idNota];
                foreach ($campos as $key => $campo) {
                    $default = isset($camposInt[$campo]) ? 0 : null;
                    $info[$campo] = $camposInput[$campo] ? $camposInput[$campo] : $default;
                }

                $idNota = isset($camposInput['id']) ? $camposInput['id'] : null; //Se existir Editar
                if ($idNota != null) { //Edição
                    $idNota = $this->NotaFiscalItem->update($idNota, $info);
                } else
                    $idNota = $this->NotaFiscalItem->insert($info); //Cadastro    
*/
                if ($idNota != null) { //Itens nota fiscal
                    //Nota Fiscal Itens ICMS

                    $idICMS = $this->salvarObjetoRegraFiscal(
                        'icms_',
                        [],
                        [
                            'situacaoTributaria', 'codigoSituacao', 'origem', 'modalidadeBC', 'aplicCred', 'valorAplicCred', 'valorPauta', 'baseICMS', 'valorBaseICMS', 'difICMS', 'presumido', 'ICMS', 'valorICMS', 'posicaoAliquota', 'FCP', 'valorFCP', 'ICMSdesonerado', 'motivoDesonerado', 'codigoBeneficio', 'informacoesComplementares', 'informacoesCompIFICMS'
                        ],
                        ['FKIDItensNotaFiscal' => $idNota],
                        $camposInput,
                        $this->NotaFiscalItensICMS
                    );

                    if ($idICMS != null) {
                        //Nota Fiscal Itens ICMS ST
                        $this->salvarObjetoRegraFiscal(
                            'icms_ST',
                            [],
                            [
                                'modalidadeBC', 'valorPauta', 'percentualMargem', 'baseICMS', 'valorICMS', 'aliqICMS', 'valorBasePIS', 'aliqPIS', 'valorPIS', 'valorBaseCOFINS', 'aliqCOFINS', 'valorCONFIS'
                            ],
                            ['FKIDICMSItensNotaFiscal' => $idICMS],
                            $camposInput,
                            $this->notaFiscalItensICMSST
                        );

                        //Nota Fiscal Itens ICMS STR
                        $this->salvarObjetoRegraFiscal(
                            'icms_STR',
                            [],
                            [
                                'valorICMSsub', 'valorBaseICMS', 'baseICMS', 'aliqICMS', 'valorICMS'
                            ],
                            ['FKIDICMSItensNotaFiscal' => $idICMS],
                            $camposInput,
                            $this->notaFiscalItensICMSSTR
                        );
                    } //Fim ICMS

                    //notaFiscalItensIPI
                    $this->salvarObjetoRegraFiscal(
                        'ipi_',
                        [],
                        [
                            'situacaoTributaria', 'aliqIPI', 'baseIPI', 'valorBaseIPI', 'valorIPI', 'codEnquad', 'codExcecaoTIPI', 'informacoesComp', 'informacoesCompIF'
                        ],
                        ['FKIDItensNotaFiscal' => $idNota],
                        $camposInput,
                        $this->notaFiscalItensIPI
                    );

                    //notaFiscalItensCONFIS
                    $this->salvarObjetoRegraFiscal(
                        'confis_',
                        [],
                        [
                            'situacaoTributaria', 'baseCONFIS', 'valorCONFIS', 'valorBaseCONFIS', 'aliqCONFIS', 'valorFixoCONFIS', 'informacoesComp', 'informacoesCompIF'
                        ],
                        ['FKIDItensNotaFiscal' => $idNota],
                        $camposInput,
                        $this->notaFiscalItensCONFIS
                    );

                    //notaFiscalItensPIS
                    $this->salvarObjetoRegraFiscal(
                        'pis_',
                        [],
                        [
                            'situacaoTributaria', 'basePIS', 'valorBase', 'aliqPIS', 'valorPIS', 'valorFixoPIS', 'informacoesComp', 'informacoesCompIF'
                        ],
                        ['FKIDItensNotaFiscal' => $idNota],
                        $camposInput,
                        $this->notaFiscalItensPIS
                    );

                    //notaFiscalItensRetencoes
                    $this->salvarObjetoRegraFiscal(
                        'retencoes_',
                        [],
                        [
                            'impostoRetido', 'aliqIR', 'baseIR', 'valorIR', 'aliqCSLL', 'valorCSLL'
                        ],
                        ['FKIDItensNotaFiscal' => $idNota],
                        $camposInput,
                        $this->notaFiscalItensRetencoes
                    );

                    //notaFiscalItensOutros
                    $this->salvarObjetoRegraFiscal(
                        'outros_',
                        [],
                        [
                            'presumidoCalculo', 'aliqFunrural', 'tipoItem', 'baseComissao', 'aliquotaComissao', 'valorComissao', 'numeroPedido', 'nrItemPedido', 'aproxTrib', 'valorAproxTrib', 'unidadeTributaria', 'quantidadeTributaria', 'valorUnitario', 'valorOutrasDespesas'
                        ],
                        ['FKIDItensNotaFiscal' => $idNota],
                        $camposInput,
                        $this->notaFiscalItensOutros
                    );
                }
            }
        }

        return responseJson($this, [
            'resultado' => true,
            'msg' => 'nota da operação cadastrada com sucesso',
            'id' => $idNota
        ]);
    }

    public function salvarObjetoRegraFiscal($prefix, $camposInt, $campos, $info, $origemRequest, $instanciaModel)
    {
        $campos = array_merge($campos,$camposInt);
        $id = isset($origemRequest[$prefix . 'id']) ? $origemRequest[$prefix . 'id'] : null; //Se existir Editar
        $info = $id==null?$info:[];
        foreach ($campos as $key => $campo) {
            if(array_search($campo,$camposInt) !== false){
                $info[$campo] = isset($origemRequest[$prefix . $campo]) && $origemRequest[$prefix . $campo]!="" ? true : null;
              
            }else{ 
                $info[$campo] = isset($origemRequest[$prefix . $campo]) ? $origemRequest[$prefix . $campo] : null;
            }
           
        }

        if ($id != null) { //Edição
            $id = $instanciaModel->update($id, $info);
        } else
            $id = $instanciaModel->insert($info); //Cadastro    

        if ($id == null) {
            var_dump($instanciaModel->db->error());
            return;
        }

        return $id;
    }

}
