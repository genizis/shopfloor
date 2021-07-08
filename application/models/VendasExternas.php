<?php

class VendasExternas extends CI_Model{

    public function conectaVendasExternas($user, $password){

        // Etapa 1: Código de Licença
        $codLicenca = $this->getLicenca($user, $password);
        if($codLicenca == false){
            return false;
        }

        // Etapa 2: Código de Integração
        $codIntegracao = $this->getIntegracao($user, $password, $codLicenca);        
        if($codIntegracao == false){

            $codIntegracao = $this->setIntegracao($user, $password, $codLicenca);

        }
        if($codIntegracao ==  false){
            return false;
        }

        // Etapa 3: Gera Token
        return $this->getToken($user, $password, $codLicenca, $codIntegracao);

    }

    public function getLicenca($user, $password){

        // URL API
        $url = "https://api.alkord.com.br/3/licencas";

        //Header
        $authorization = base64_encode($user . ':' . $password);
        $header = array('Authorization: Basic '. $authorization);

        // Realizando conexão
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Resultado da consulta
        $result = curl_exec($ch);
        $response =  curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Finalizando conexão
        curl_close($ch);

        $licenca = json_decode($result, true);
        if(@$licenca['message'] != ""){
            $this->session->set_flashdata('erro', 'Integração Vendas Externas: ' . $licenca['message']);
            return false;
        }

        if($licenca[0]['CODIGO'] == null){
            return false;
        }
        
        return $licenca[0]['CODIGO'];
    }

    public function getIntegracao($user, $password, $codLicenca){

        // URL API
        $url = "https://api.alkord.com.br/3/integracoes?licenca={$codLicenca}";

        //Header
        $authorization = base64_encode($user . ':' . $password);
        $header = array('Authorization: Basic '. $authorization);

        // Realizando conexão
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Resultado da consulta
        $result = curl_exec($ch);
        $response =  curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Finalizando conexão
        curl_close($ch);

        $integracao = json_decode($result, true);
        if(@$integracao['message'] != ""){
            $this->session->set_flashdata('erro', 'Integração Vendas Externas: ' . $integracao['message']);
            return false;
        }

        // Verificando se há um cadastro de integração do ShopFloor
        foreach($integracao['REGISTROS'] as $key_integracao => $integ){

            if($integ['DESCRICAO'] == 'ShopFloor'){
                return $integ['CODIGO'];
            }

        }

        return false;
    }

    public function setIntegracao($user, $password, $codLicenca){        

        // URL API
        $url = "https://api.alkord.com.br/3/integracoes?licenca={$codLicenca}";

        //Header
        $authorization = base64_encode($user . ':' . $password);
        $header = array('Authorization: Basic '. $authorization);

        // Cria dados da integração
        $postIntegracao = array(
            'descricao' => "ShopFloor"
        );

        // Realizando conexão
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postIntegracao));
        

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Resultado da consulta
        $result = curl_exec($ch);
        $response =  curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $integracao = json_decode($result);
        if(@$integracao->message != ""){
            $this->session->set_flashdata('erro', 'Integração Vendas Externas: ' . $integracao->message);
            return false;
        }

        

        if($integracao->codigo == null){
            return false;
        }

        return $integracao->codigo;

    }

    public function getToken($user, $password, $codLicenca, $codIntegracao){

        // URL API
        $url = "https://api.alkord.com.br/3/token?licenca={$codLicenca}&integracao={$codIntegracao}&finalidade=1";

        //Header
        $authorization = base64_encode($user . ':' . $password);
        $header = array('Authorization: Basic '. $authorization);
 
        // Realizando conexão
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        // Resultado da consulta
        $result = curl_exec($ch);
        $response =  curl_getinfo($ch, CURLINFO_HTTP_CODE);
 
        // Finalizando conexão
        curl_close($ch);

        $token = json_decode($result, true);
         
        if(@$token['message'] != ""){
            $this->session->set_flashdata('erro', 'Integração Vendas Externas: ' . $token['message'] . ' Licença: ' . $codLicenca . ' Cód Integração: ' . $codIntegracao);
            return false;
        }

        // Se não encontrar o registro do token        
        if($token['token_acesso'] == null){
            $this->session->set_flashdata('erro', 'Integração Vendas Externas: Não encontrado campo TOKEN_ACESSO');
            return false;
        }

        // Grava token de acesso
        $dados = [
            'token_acesso_vendas_externas' => $token['token_acesso'],
            'token_renovacao_vendas_externas' => $token['token_renovacao'],
            //'validade_token_vendas_externas' => date('Y-m-d H:i:s', strtotime('+' . 3600 . ' seconds'))
            //'validade_token_vendas_externas' => '2099-01-01 23:59:59'
            'validade_token_vendas_externas' => date('Y-m-d H:i:s', strtotime('+' . $token['validade'] . ' seconds'))
        ];

        $this->empresa->updateEmpresa(getDadosUsuarioLogado()['id_empresa'], $dados);

        return $token['token_acesso'];
    }

    public function getRenovacaoToken($tokenRenovacao){

        // URL API
        $url = "https://api.alkord.com.br/3/renovar-token?token={$tokenRenovacao}";
        
 
        // Realizando conexão
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        // Resultado da consulta
        $result = curl_exec($ch);
        $response =  curl_getinfo($ch, CURLINFO_HTTP_CODE);
 
        // Finalizando conexão
        curl_close($ch);

        $token = json_decode($result, true);
         
        if(@$token['message'] != ""){
            $this->session->set_flashdata('erro', 'Integração Vendas Externas: ' . $token['message']);
            return false;
        }
        
        // Se não encontrar o registro do token 
        if($token['token_acesso'] == null){
            $this->session->set_flashdata('erro', 'Integração Vendas Externas: Não encontrado campo TOKEN_ACESSO');
            return false;
        }

        // Grava token renovado
        $dados = [
            'token_acesso_vendas_externas' => $token['token_acesso'],
            'token_renovacao_vendas_externas' => $token['token_renovacao'],
            //'validade_token_vendas_externas' => date('Y-m-d H:i:s', strtotime('+' . 3600 . ' seconds'))
            //'validade_token_vendas_externas' => '2099-01-01 23:59:59'
            'validade_token_vendas_externas' => date('Y-m-d H:i:s', strtotime('+' . $token['validade'] . ' seconds'))
        ];

        $this->empresa->updateEmpresa(getDadosUsuarioLogado()['id_empresa'], $dados);

        return $token['token_acesso'];

    }

    public function getAtendimentos($token, $dataAtendimento){

        // URL API (Atendimentos do dia)
        $url = "https://api.alkord.com/atendimentos?token={$token}&filtros=DATA:si:{$dataAtendimento}%2000:00:00,DATA:ii:{$dataAtendimento}%2023:59:59,PAGAMENTOS[EXCLUIDO:ig:N]";      

        // Realizando conexão
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Resultado da consulta
        $result = curl_exec($ch);
        $response =  curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Finalizando conexão
        curl_close($ch);

        $atendimento = json_decode($result, true);         
        if(@$atendimento['message'] != ""){
            $this->session->set_flashdata('erro', 'Integração Vendas Externas: ' . $atendimento['message']);
            return false;
        }

        $empresa = $this->empresa->getEmpresaPorCodigo(getDadosUsuarioLogado()['id_empresa']);

        // Passa por todos atendimentos importados
        foreach($atendimento['REGISTROS'] as $key_atendimento => $atend){            
            

            // Diferente de Fechado ou Finalizado não considera            
            if($atend['SITUACAO'] != 2 && $atend['SITUACAO'] != 4){
                continue;
            }

            // Validação temporária, só importa vendas efetivadas e não canceladas
            if($atend['TIPO_ATENDIMENTO']['CODIGO'] != 1 && $atend['TIPO_ATENDIMENTO']['CODIGO'] != 5 && $atend['TIPO_ATENDIMENTO']['CODIGO'] != 7){
                continue;
            }

            // Importa somente operações de venda
            if($atend['TIPO_OPERACAO'] != 1 ){
                continue;
            }

            if($atend['TIPO_ATENDIMENTO']['CODIGO'] == 1 || $atend['TIPO_ATENDIMENTO']['CODIGO'] == 5){ // Venda gera pedido e itens

                // Se não for venda, não considera
                

                // Se já houver importado o atendimento antes, não prossegue
                $vendaExterna = $this->venda->getVendaPorCodigoVendasExternas($atend['CODIGO']);
                if($vendaExterna != null){
                    continue;
                }

                // Verifica se o cliente já está cadastrado
                $cliente = null;
                $cliente = $this->cliente->getClientePorCodigoVendasExternas($atend['CLIENTE']['CODIGO']);
                if($cliente == null){

                    // Cliente não encontrado, importa dados para cadastro
                    $this->importaClientePorCodigo($atend['CLIENTE']['CODIGO'], $token);              
                    $cliente = $this->cliente->getClientePorCodigoVendasExternas($atend['CLIENTE']['CODIGO']);                
                }

                // Se mesmo assim não conseguir cadastrar o cliente, para o processo
                if($cliente == null){
                    $this->session->set_flashdata('erro', 'Integração Vendas Externas: Não foi possível cadastrar cliente ' . $atend['CLIENTE']['CODIGO'] . ' - ' . $atend['CLIENTE']['NOME'] . ' no ShopFloor');
                    return false;
                }

                // Verifica se o vendedor já está cadastrado
                $vendedor = null;
                $vendedor = $this->vendedor->getVendedorPorCodigoVendasExternas($atend['VENDEDOR']['CODIGO']);
                if($vendedor == null){

                    // Vendedor não encontrado, atualiza ou cadastra novo vendedor
                    $vendedor = $this->vendedor->getVendedorPorNome($atend['VENDEDOR']['NOME']); 
                    if($vendedor != null){ 
                        //Atualiza cadastro cliente
                        $dadosVendedor = null;
                        $dadosVendedor = [
                            'cod_vendas_externas' => $atend['VENDEDOR']['CODIGO'],
                        ];
                        $this->vendedor->updateVendedor($vendedor->cod_vendedor, $dadosVendedor);   

                    }else{

                        // Cadastra novo vendedor
                        $dadosVendedor = null;
                        $dadosVendedor = [
                            'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                            'nome_vendedor'  => $atend['VENDEDOR']['NOME'],
                            'cod_vendas_externas' => $atend['VENDEDOR']['CODIGO'],
                        ];            
                        $this->vendedor->insertVendedor($dadosVendedor);
                    } 

                    $vendedor = null;    
                    $vendedor = $this->vendedor->getVendedorPorCodigoVendasExternas($atend['VENDEDOR']['CODIGO']);               
                }

                // Se mesmo assim não conseguir cadastrar o vendedor, para o processo
                if($vendedor == null){
                    $this->session->set_flashdata('erro', 'Integração Vendas Externas: Não foi possível cadastrar vendedor ' . $atend['VENDEDOR']['CODIGO'] . ' - ' . $atend['VENDEDOR']['NOME'] . ' no ShopFloor');
                    return false;
                }

                // Verifica se é uma venda confirmada ou orçamento (Venda Confirmada == 3, Orçamento == 1)
                if($atend['TIPO_ATENDIMENTO']['CODIGO'] == 1 || $atend['TIPO_ATENDIMENTO']['CODIGO'] == 5){
                    $situacao = 3;
                }else{
                    $situacao = 1;
                }

                $dadosPedido = [
                    'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                    'cod_vendas_externas' => $atend['CODIGO'],
                    'cod_cliente'  => $cliente->cod_cliente,
                    'cod_vendedor' => $vendedor->cod_vendedor,
                    'perc_comissao' => $vendedor->perc_comissao,
                    'data_emissao' => $atend['DATA'],
                    'data_entrega' => $atend['DATA'],
                    'situacao' => $situacao,
                    'observacoes' => $atend['TEXTOS']['OBSERVACAO'],
                ];
                $numPedidoVenda = $this->venda->insertPedidoVenda($dadosPedido);

                // Se for Venda Confirmada cria registro de faturamento e parcelas no contas a receber
                if($situacao == 3){

                    $dadosFaturamento = null;
                    $dadosFaturamento = [
                        'num_pedido_venda'  => $numPedidoVenda,
                        'data_faturamento' => $atend['DATA'],
                        'valor_bruto' => $atend['TOTAL'],
                        'valor_frete' => $atend['FRETE_VALOR'],
                        'valor_desconto' => $atend['TOTAL_DESCONTO_VALOR'],
                        'observacoes' => $atend['TEXTOS']['OBSERVACAO'],
                    ];
                    $codFaturamentoPedido = $this->venda->insertFaturamento($dadosFaturamento);
                    
                    // Identifica número total de parcelas
                    $numParcelas = 0;
                    if(@$atend['PAGAMENTOS'] != null){
                        
                        foreach($atend['PAGAMENTOS'] as $key_atend => $pagamentos){
                            // Se for Crédito de Devolução, não gera título no contas a receber
                            if($pagamentos['MEIO_PAGAMENTO']['NOME'] == $empresa->cred_devol_vendas_externas){
                                continue;
                            }

                            foreach($pagamentos['PARCELAS'] as $key_pagamentos => $parcelas){
                                $numParcelas = $numParcelas + 1;
                            }
                        }
                    }

                    if(@$atend['PAGAMENTOS'] != null){

                        // Cria os títulos no contas a receber
                        $i = 0;
                        foreach($atend['PAGAMENTOS'] as $key_atend => $pagamentos){

                            // Se for Crédito de Devolução, não gera título no contas a receber
                            if($pagamentos['MEIO_PAGAMENTO']['NOME'] == $empresa->cred_devol_vendas_externas){
                                continue;
                            }

                            // Verifica se o método de pagamento já está cadastrado
                            $metodo_pagamento = null;
                            $metodo_pagamento = $this->financeiro->getMetodoPagamentoPorCodigoVendasExternas($pagamentos['MEIO_PAGAMENTO']['CODIGO']);
                            if($metodo_pagamento == null){

                                // Método de pagamento não encontrado, atualiza ou cadastra novo método
                                $metodo_pagamento = $this->financeiro->getMetodoPagamentoPorNome($pagamentos['MEIO_PAGAMENTO']['NOME']); 

                                if($metodo_pagamento != null){ 

                                    $dadosMetodo = null;
                                    $dadosMetodo = [
                                        'cod_vendas_externas' => $pagamentos['MEIO_PAGAMENTO']['CODIGO'],
                                    ];
                                    $this->financeiro->updateMetodoPagamento($metodo_pagamento->cod_metodo_pagamento, $dadosMetodo);
                                }else{

                                    // Cadastra novo método de pagamento
                                    $dadosMetodo = null;
                                    $dadosMetodo = [
                                        'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                                        'nome_metodo_pagamento'  => $pagamentos['MEIO_PAGAMENTO']['NOME'],
                                        'cod_conta' => $empresa->conta_padrao,
                                        'cod_vendas_externas' => $pagamentos['MEIO_PAGAMENTO']['CODIGO'],
                                    ];            
                                    $this->financeiro->insertMetodoPagamento($dadosMetodo);
                                }

                                $metodo_pagamento = $this->financeiro->getMetodoPagamentoPorCodigoVendasExternas($pagamentos['MEIO_PAGAMENTO']['CODIGO']);
                            }

                            foreach($pagamentos['PARCELAS'] as $key_pagamentos => $parcelas){

                                $i = $i + 1;                        

                                $dadosMovimento = null;
                                $dadosMovimento = [
                                    'cod_conta' => $metodo_pagamento->cod_conta,
                                    'cod_metodo_pagamento' => $metodo_pagamento->cod_metodo_pagamento,
                                    'cod_centro_custo' => $empresa->centro_custo_vendas,
                                    'cod_conta_contabil' => $empresa->conta_contabil_vendas,
                                    'cod_emitente' => $cliente->cod_cliente,
                                    'cod_vendedor' => $vendedor->cod_vendedor,
                                    'tipo_movimento' => 1,
                                    'data_competencia' => $atend['DATA'],
                                    'data_vencimento' => $parcelas['DATA_VENCIMENTO'],
                                    'parcela' => $i . '/' .  $numParcelas,
                                    'desc_movimento' => $cliente->nome_cliente . " - Pedido de Venda: " . $numPedidoVenda . ", " . "Faturamento: " . $codFaturamentoPedido,
                                    'valor_titulo' => $parcelas['VALOR'],
                                    'origem_movimento' => 3,
                                    'id_origem' => $codFaturamentoPedido,
                                    'confirmado' => 0,
                                    'cod_vendas_externas' => $atend['CODIGO']
                                ];
                                $this->financeiro->insertMovimentoConta($dadosMovimento);

                            }
                        }
                    }else{

                        $dadosMovimento = null;
                        $dadosMovimento = [
                            'cod_conta' => $empresa->conta_padrao,
                            'cod_centro_custo' => $empresa->centro_custo_vendas,
                            'cod_conta_contabil' => $empresa->conta_contabil_vendas,
                            'cod_emitente' => $cliente->cod_cliente,
                            'tipo_movimento' => 1,
                            'data_competencia' => $atend['DATA'],
                            'data_vencimento' => $atend['DATA'],
                            'parcela' => '1/1',
                            'desc_movimento' => $cliente->nome_cliente . " - Pedido de Venda: " . $numPedidoVenda . ", " . "Faturamento: " . $codFaturamentoPedido . " (Recebimento Futuro)",
                            'valor_titulo' => $atend['TOTAL'],
                            'origem_movimento' => 3,
                            'id_origem' => $codFaturamentoPedido,
                            'confirmado' => 0,
                            'cod_vendas_externas' => $atend['CODIGO']
                        ];
                        $this->financeiro->insertMovimentoConta($dadosMovimento);

                    }
                }

                // Passa por todos itens do atendimento importado
                foreach($atend['ITENS'] as $key_atend => $produtos){

                    $produto = $this->produto->getProdutoPorCodigoVendasExternas($produtos['PRODUTO']['CODIGO']);
                    // Se não encontrar produto, importa dados para cadastro
                    if($produto == null){

                        $this->importaProdutoPorCodigo($produtos['PRODUTO']['CODIGO'], $token);
                        $produto = $this->produto->getProdutoPorCodigoVendasExternas($produtos['PRODUTO']['CODIGO']);

                    }  

                    $dadosProduto = null;
                    $dadosProduto = [
                        'num_pedido_venda' => $numPedidoVenda,
                        'cod_produto'  => $produto->cod_produto,
                        'quant_pedida' => $produtos['QUANTIDADE'],
                        'valor_unitario' => $produtos['VALOR_UNITARIO'],
                        'quant_atendida' => $produtos['QUANTIDADE'],
                        'status' => 3
                    ];    
                    $this->venda->insertProdutoVenda($dadosProduto);

                    //Se venda confirmada, movimenta estoque dos produtos vendidos
                    if($situacao == 3){

                        // Movimenta estoque
                        $dadosEstoque = null;
                        $dadosEstoque = [
                            'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                            'data_movimento' => $atend['DATA'],
                            'cod_produto' => $produto->cod_produto,
                            'origem_movimento' => 3,
                            'id_origem' => $codFaturamentoPedido,
                            'tipo_movimento' => 2,
                            'especie_movimento' => 5,
                            'quant_movimentada' => $produtos['QUANTIDADE'],
                            'valor_movimento' => $produtos['QUANTIDADE'] * $produtos['VALOR_UNITARIO'],
                        ];
                        $this->estoque->insertMovimentoEstoque($dadosEstoque);
                    }
                } 
            }   
        }            

        $this->session->set_flashdata('sucesso', 'Atendimentos importados com sucesso');
    }

    public function importaClientePorCodigo($codVendasExternas, $token){

        // URL API
        $url = "https://api.alkord.com.br/3/clientes/{$codVendasExternas}?token={$token}";

        // Realizando conexão
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Resultado da consulta
        $result = curl_exec($ch);
        $response =  curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Finalizando conexão
        curl_close($ch);

        $cliente = json_decode($result, true);
         
        if(@$cliente['message'] != ""){
            $this->session->set_flashdata('erro', 'Integração Vendas Externas: ' . $cliente['message']);
            return false;
        }

        foreach($cliente['REGISTROS'] as $key_cliente => $cli){

            $clienteShop = $this->cliente->getClientePorDocumento($cli['DOCUMENTO']);
            // Se não encontrar por CNPJ/CPF, busca por nome
            if($clienteShop == null){
                $clienteShop = $this->cliente->getClientePorRazaoSocial($cli['NOME']);
            }

            if($clienteShop != null){
                //Atualiza cadastro cliente
                $dadosCliente = [
                    'cod_vendas_externas' => $codVendasExternas,
                ];
                $this->cliente->updateCliente($clienteShop->cod_cliente, $dadosCliente);
            }else{

                // Se mesmo assim não encontrar o cliente, cadastra um novo no sistema
                if($cli['TIPO_PESSOA'] == 'J'){
                    $tipoPessoa = 1;

                }elseif($cli['TIPO_PESSOA'] == 'F'){
                    $tipoPessoa = 2;
                }

                //Cria novo cadastro de cliente
                $dadosCliente = [
                    'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                    'nome_cliente'  => ($cli['APELIDO']) ? $cli['APELIDO'] : $cli['NOME'],
                    'razao_social'  => $cli['NOME'],
                    'tipo_pessoa' => $tipoPessoa,
                    'cnpj_cpf' => $cli['DOCUMENTO'],
                    'cod_vendas_externas' => $codVendasExternas,
                ];    
                $codCliente = $this->cliente->insertCliente($dadosCliente);
                
            }
        }
    }

    public function importaProdutoPorCodigo($codVendasExternas, $token){

        // URL API
        $url = "https://api.alkord.com.br/3/produtos/{$codVendasExternas}?token={$token}";

        // Realizando conexão
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Resultado da consulta
        $result = curl_exec($ch);
        $response =  curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Finalizando conexão
        curl_close($ch);

        $produto = json_decode($result, true);         
        if(@$produto['message'] != ""){
            $this->session->set_flashdata('erro', 'Integração Vendas Externas: ' . $produto['message']);
            return false;
        }

        // Por todos os produtos
        foreach($produto['REGISTROS'] as $key_produto => $pro){

            // Os itens já cadastrados no ShopFloor deverão ter no Vendas Externas, Acesso Rápido, o código do ShopFloor para criar o vínculo
            $produtoShop = $this->produto->getProdutoPorCodigo($pro['INFORMACOES_ADICIONAIS']['ACESSO_RAPIDO']);
            if($produtoShop != null){
                //Atualiza cadastro cliente
                $dadosProduto = [
                    'cod_vendas_externas' => $codVendasExternas,
                ];
                $this->produto->updateProduto($produtoShop->cod_produto, $dadosProduto);
            }else{

                // Caso não encontrado o item, cria um novo na base
                $unidadeMedida = $this->unidademedida->getUnidadeMedidaPorCodigo($pro['UNIDADE_MEDIDA_VENDA']['SIGLA']);
                if($unidadeMedida == null){
                    $dataUn = [
                        'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                        'cod_unidade_medida'  => $pro['UNIDADE_MEDIDA_VENDA']['SIGLA'],
                        'nome_unidade_medida' => $pro['UNIDADE_MEDIDA_VENDA']['SIGLA']
                    ];        
                    $this->unidademedida->insertUnidadeMedida($dataUn);
                }

                // Busca o primeiro tipo de produto (campo obrigatório)
                $tipoproduto = $this->tipoproduto->getPrimeiroTipoProduto();

                //Cria novo cadastro de produto
                $dadosProduto = [
                    'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                    'cod_produto'  => $codVendasExternas,
                    'nome_produto' => $pro['NOME'],
                    'desc_produto' => $pro['TEXTOS']['DESCRICAO'],                
                    'cod_tipo_produto' => $tipoproduto->cod_tipo_produto,
                    'cod_unidade_medida' => $pro['UNIDADE_MEDIDA_VENDA']['SIGLA'],
                    'quant_estoq' => 0,
                    'custo_medio' => 0.01,
                    'estoq_min' => 0,
                    'saldo_negativo' => 1,
                    'tempo_abastecimento' => 1,
                    'cod_ncm' => $pro['NCM'],
                    'cod_origem' => 1,
                    'cod_cest' => $pro['CEST'],
                    'peso_liq' => $pro['INFORMACOES_ADICIONAIS']['PESO'],
                    'peso_bruto' => $pro['INFORMACOES_ADICIONAIS']['PESO'],
                    'cod_vendas_externas'  => $codVendasExternas,
                ];  
                $this->produto->insertProduto($dadosProduto);                
            }
        }
    }
    
    public function mask($val, $mask){
        $maskared = '';
        $k = 0;
        for($i = 0; $i <= strlen($mask)-1; $i++){
            if($mask[$i] == '#'){
                if(isset($val[$k]))
                    $maskared .= $val[$k++];
            }else{
                if(isset($mask[$i]))
                $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }

}