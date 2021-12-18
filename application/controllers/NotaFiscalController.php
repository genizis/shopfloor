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
    public function gerarNotaFiscalXML($faturamentoPedidoID)
    {
        require_once "vendor/autoload.php";

        $this->load->model('NotaFiscal');
        $notaFiscal = $this->NotaFiscal->getNotaFiscalIDFaturamento($faturamentoPedidoID);

        try {
            $nfe = new NFePHP\NFe\Make();

            $std = new \stdClass();
            $std->versao = '3.10';
            $nfe->taginfNFe($std);

            $std = new \stdClass();
            $std->cUF = 35;#TODO
            $std->cNF = '80070008';#TODO
            $std->natOp = $notaFiscal->FKIDnaturezaOperacaoText;
            $std->indPag = 0;#TODO
            $std->mod = 55;#TODO
            $std->serie = $notaFiscal->serie;
            $std->nNF = $notaFiscal->numero;
            $std->dhEmi = (new \DateTime($notaFiscal->dataEmissao.' '.$notaFiscal->horaEmissao))->format('Y-m-d\TH:i:sP');
            $std->dhSaiEnt = (new \DateTime($notaFiscal->dataSaida.' '.$notaFiscal->horaSaida))->format('Y-m-d\TH:i:sP');
            $std->tpNF = $notaFiscal->tipoSaida;; //tipoSaida
            $std->idDest = 1;#TODO
            $std->cMunFG = 3518800;#TODO
            $std->tpImp = 1;#TODO
            $std->tpEmis = 1;#TODO
            $std->cDV = 2;#TODO
            $std->tpAmb = 2; // Se deixar o tpAmb como 2 você emitirá a nota em ambiente de homologação(teste) e as notas fiscais aqui não tem valor fiscal
            $std->finNFe = $notaFiscal->finalidade;
            $std->indFinal = 0;#TODO
            $std->indPres = $notaFiscal->indicadorPresenca;
            $std->procEmi = '3.10.31';
            $std->verProc = 1;#TODO
            $nfe->tagide($std);

            $std = new \stdClass(); #TODO //Empresa Emitente
            $std->xNome = 'Empresa teste';
            $std->IE = '6564344535';
            $std->CRT = 3;
            $std->CNPJ = '78767865000156';
            $nfe->tagemit($std);

            $std = new \stdClass();
            $std->xLgr = "Rua Teste";
            $std->nro = '203';
            $std->xBairro = 'Centro';
            $std->cMun = '4317608';
            $std->xMun = 'Porto Alegre';
            $std->UF = 'RS';
            $std->CEP = '955500-000';
            $std->cPais = '1058';
            $std->xPais = 'BRASIL';
            $nfe->tagenderEmit($std);

            $std = new \stdClass(); //Empresa destinatário
            $std->xNome = $notaFiscal->destinatario_nomeContato;
            $std->indIEDest = 1;
            $std->IE = $notaFiscal->destinatario_inscricaoEstadual;
            $std->CNPJ = $notaFiscal->destinatario_cnpj;
            $nfe->tagdest($std);

            $std = new \stdClass();
            $std->xLgr = $notaFiscal->destinatario_endereco;
            $std->nro = $notaFiscal->destinatario_numero;
            $std->xBairro = $notaFiscal->destinatario_bairro;
            $std->cMun = '4317608';#TODO
            $std->xMun = $notaFiscal->destinatario_municipio;
            $std->UF = $notaFiscal->destinatario_UF;
            $std->CEP = $notaFiscal->destinatario_cep;
            $std->cPais = '1058';#TODO
            $std->xPais = $notaFiscal->destinatario_pais;
            $nfe->tagenderDest($std);

            //Itens da nota
            foreach ($notaFiscal->itensNota as $key => $item) {
                $this->itensNotaFiscal($nfe, $item);
            }
            
            $std = new \stdClass();
            $std->vBC = 0.00;#TODO
            $std->vICMS = $notaFiscal->calculoimposto_valorICMS;
            $std->vICMSDeson = 0.00;#TODO
            $std->vBCST = $notaFiscal->calculoimposto_baseICMSST;
            $std->vST = $notaFiscal->calculoimposto_valorICMSST;
            $std->vProd = $notaFiscal->calculoimposto_totalProdutos;
            $std->vFrete = $notaFiscal->calculoimposto_valorFrete;
            $std->vSeg = $notaFiscal->calculoimposto_valorSeguro;
            $std->vDesc = $notaFiscal->calculoimposto_desconto;
            $std->vII = 0.00;#TODO
            $std->vIPI = $notaFiscal->calculoimposto_valorIPI;
            $std->vPIS = 0.00;#TODO
            $std->vCOFINS = 0.00;#TODO
            $std->vOutro = $notaFiscal->calculoimposto_outrasDespesas;
            $std->vNF = $notaFiscal->calculoimposto_totalNota;
            $std->vTotTrib = $notaFiscal->calculoimposto_totalAtributos;
            $nfe->tagICMSTot($std);

            $std = new \stdClass();
            $std->modFrete = $notaFiscal->transportador_freteConta;
            $nfe->tagtransp($std);
            /*
            $std = new \stdClass();
            $std->nFat = '100';
            $std->vOrig = 100;
            $std->vLiq = 100;
            $nfe->tagfat($std);

            $std = new \stdClass();
            $std->nDup = '100';
            $std->dVenc = '2017-08-22';
            $std->vDup = 11.03;
            $nfe->tagdup($std);
            */
            $xml = $nfe->getXML(); // O conteúdo do XML fica armazenado na variável $xml

            $resultXml = $this->NotaFiscal->update($notaFiscal->id, ['xml' => $xml]);
            if (!$resultXml) return false;

            //ASSINAR NOTA
            //$this->assinarCertificado();

            return true;
        } catch (\Exception $e) {
            var_dump($e);
            return;
        }
    }
    public function itensNotaFiscal($nfe, $item)
    {

        $produto = $this->produto->getProdutoPorCodigo($item->codigo);
        //var_dump($item);
        $std = new \stdClass();
        $std->item = $item->id;
        $std->cProd = $item->codigo;
        $std->xProd = $item->descricao;
        $std->NCM = $item->NCM;
        $std->CFOP = $item->CFOP;
        $std->uCom = 'PÇ';#TODO
        $std->qCom = $item->quantidade;
        $std->vUnCom = $item->valorUnitario;
        $std->vProd = '00';#TODO
        $std->uTrib = 'PÇ';#TODO
        $std->qTrib = '00';#TODO
        $std->vUnTrib = '00';#TODO
        $std->indTot = 1;#todo
        $nfe->tagprod($std);

        $std = new \stdClass();
        $std->item = $item->id;
        $std->vTotTrib = 0;#TODO
        $nfe->tagimposto($std);

        $std = new \stdClass();
        $std->item = $item->id;
        $std->orig = $item->icms_origem;
        //$std->CST = $item->icms_situacaoTributaria;#TODO dando erro ao inseri-la
        $std->modBC = $item->icms_modalidadeBC;
        $std->vBC = $item->icms_valorPauta;
        $std->pICMS = $item->icms_presumido;##DUVIDA
        $std->vICMS =  $item->icms_ICMS;##DUVIDA ou valorICMS
        $nfe->tagICMS($std);

        $std = new \stdClass();
        $std->item = $item->id;
        $std->cEnq = $item->ipi_codEnquad;
        $std->CST = $item->ipi_situacaoTributaria;
        $std->vIPI = $item->ipi_valorIPI;
        $std->vBC = 0;#TODO
        $std->pIPI = 0;#TODO
        $nfe->tagIPI($std);

        $std = new \stdClass();
        $std->item = $item->id;
        $std->CST = $item->pis_situacaoTributaria;
        $std->vBC = 0;#TODO
        $std->pPIS = 0;#TODO
        $std->vPIS = $item->pis_valorPIS;
        $nfe->tagPIS($std);

        $std = new \stdClass();
        $std->item = $item->id;
        $std->vCOFINS = $item->confis_valorCONFIS;
        $std->vBC = 0;#TODO
        $std->pCOFINS = 0;#TODO
        $nfe->tagCOFINSST($std);

        $std = new \stdClass();
        $std->item = $item->id;
        $std->qVol = 0;#TODO
        $std->esp = 'caixa';#TODO
        $std->marca = 'OLX';#TODO
        $std->nVol = '000';#TODO
        $std->pesoL = $produto->peso_liq;
        $std->pesoB = $produto->peso_bruto;
        $nfe->tagvol($std);
    }
    public function assinarCertificado()
    {
        $config = [
            "atualizacao" => "2018-02-06 06:01:21",
            "tpAmb" => 2, // Se deixar o tpAmb como 2 você emitirá a nota em ambiente de homologação(teste) e as notas fiscais aqui não tem valor fiscal
            "razaosocial" => "Empresa teste",
            "siglaUF" => "RS",
            "cnpj" => "78767865000156",
            "schemes" => "PL_008i2",
            "versao" => "3.10",
            "tokenIBPT" => "AAAAAAA"
        ];
        $configJson = json_encode($config);
        /*
    $certificadoDigital = file_get_contents('certificado.pfx');

    $tools = new NFePHP\NFe\Tools($configJson, NFePHP\Common\Certificate::readPfx($certificadoDigital, 'senha do certificado'));
    $xmlAssinado = $tools->signNFe($xml);

    $idLote = str_pad(100, 15, '0', STR_PAD_LEFT); // Identificador do lote
    $resp = $tools->sefazEnviaLote([$xmlAssinado], $idLote);

    $st = new NFePHP\NFe\Common\Standardize();
    $std = $st->toStd($resp);
    if ($std->cStat != 103) {
        //erro registrar e voltar
        exit("[$std->cStat] $std->xMotivo");
    }
    $recibo = $std->infRec->nRec; // Vamos usar a variável $recibo para consultar o status da nota
    $protocolo = $tools->seFazConsultaRecibo($recibo);
    $protocol = new NFePHP\NFe\Factories\Protocol();
    $xmlProtocolado = $protocol->add($xmlAssinado, $protocolo);
        */
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
            ['FKIDfaturamentoPedido', 'tipoSaida', 'serie', 'numero', 'loja', 'FKIDunidade', 'FKIDnaturezaOperacao', 'dataEmissao', 'horaEmissao', 'dataSaida', 'horaSaida', 'codigoRegimeTributario', 'finalidade', 'indicadorPresenca', 'exportacaoLocal', 'exportacaoLocalUF', 'intermediadorCNPJ', 'intermediadorID']
        ];

        $data = [
            'empresaIDFK' => getDadosUsuarioLogado()['id_empresa']
        ];
        $faturamentoPedidoID =  $this->input->post('FKIDfaturamentoPedido');

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

        $resultXml  = $this->gerarNotaFiscalXML($faturamentoPedidoID);
        if (!$resultXml) {
            return responseJson($this, [
                'resultado' => $resultXml,
                'msg' => 'Erro ao gerar XML',
                'id' => $idNota
            ]);
        }
        return responseJson($this, [
            'resultado' => true,
            'msg' => 'nota da operação cadastrada com sucesso',
            'id' => $idNota
        ]);
    }

    public function salvarObjetoRegraFiscal($prefix, $camposInt, $campos, $info, $origemRequest, $instanciaModel)
    {
        $campos = array_merge($campos, $camposInt);
        $id = isset($origemRequest[$prefix . 'id']) ? $origemRequest[$prefix . 'id'] : null; //Se existir Editar
        $info = $id == null ? $info : [];
        foreach ($campos as $key => $campo) {
            if (array_search($campo, $camposInt) !== false) {
                $info[$campo] = isset($origemRequest[$prefix . $campo]) && $origemRequest[$prefix . $campo] != "" ? true : null;
            } else {
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
