<?php

class ContaAzul extends CI_Model{

    public function conectaContaAzul($code, $state){

        $redirectURI = "https://www.shopfloor.com.br/conta-azul-integration";         

        $client_id = base64_encode('rbOhYqzxUWhe7uXT58ZastCUeEDwPWbs:cjNY5QcFtHP1Hc0uv0wyB3UyUjyOQI7m');

        // set HTTP header
        $header = array('Authorization: Basic '. $client_id);

        // the url of the API you are contacting to 'consume' 
        $url = "https://api.contaazul.com/oauth2/token?grant_type=authorization_code&redirect_uri={$redirectURI}&code={$code}";

        // Open connection
        $ch = curl_init();

        // Set the url, number of GET vars, GET data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Execute request
        $result = curl_exec($ch);

        // Close connection
        curl_close($ch);

        // get the result and parse to JSON
        $token = json_decode($result);

        if($token->access_token != null){ 

            $dados = [
                'token_conta_azul' => $token->access_token,
                'token_refresh_ca' => $token->refresh_token,
                'expira_token_ca' => date('Y-m-d H:i:s', strtotime('+' . $token->expires_in . ' seconds'))
            ];

            $Cod = $this->empresa->updateEmpresa(getDadosUsuarioLogado()['id_empresa'], $dados);

            $empresa = $this->empresa->getEmpresaPorCodigo(getDadosUsuarioLogado()['id_empresa']);
            $usuario = $this->usuario->getUsuarioPorCodigo(getDadosUsuarioLogado()['email']);

            $sessao = array(
                'id_empresa' => $usuario->id_empresa,
                'token_conta_azul' => $empresa->token_conta_azul,
                'token_refresh_ca' => $empresa->token_refresh_ca,
                'expira_token_ca' => $empresa->expira_token_ca,
                'nome_empresa' => $empresa->nome_empresa,
                'nome_usuario' => $usuario->nome_usuario,
                'email' => $usuario->email,
                'tipo_acesso' => $usuario->tipo_acesso
            );

            $this->session->set_userdata('usuario', $sessao);

            return $Cod;
             
        }else { 

            return null;

        }
    }

    public function atualizaToken($tokenRefresh){

        $client_id = base64_encode('rbOhYqzxUWhe7uXT58ZastCUeEDwPWbs:cjNY5QcFtHP1Hc0uv0wyB3UyUjyOQI7m');

        // set HTTP header
        $header = array('Authorization: Basic '. $client_id);

        // the url of the API you are contacting to 'consume' 
        $url = "https://api.contaazul.com/oauth2/token?grant_type=refresh_token&refresh_token={$tokenRefresh}";

        // Open connection
        $ch = curl_init();

        // Set the url, number of GET vars, GET data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Execute request
        $result = curl_exec($ch);
        $response =  curl_getinfo($ch, CURLINFO_HTTP_CODE);


        // Close connection
        curl_close($ch);

        // get the result and parse to JSON
        $token = json_decode($result);

        if($token->access_token != null){ 

            $dados = [
                'token_conta_azul' => $token->access_token,
                'token_refresh_ca' => $token->refresh_token,
                'expira_token_ca' => date('Y-m-d H:i:s', strtotime('+' . $token->expires_in . ' seconds'))
            ];

            $this->empresa->updateEmpresa(getDadosUsuarioLogado()['id_empresa'], $dados);

            $empresa = $this->empresa->getEmpresaPorCodigo(getDadosUsuarioLogado()['id_empresa']);
            $usuario = $this->usuario->getUsuarioPorCodigo(getDadosUsuarioLogado()['email']);

            $sessao = array(
                'id_empresa' => $usuario->id_empresa,
                'token_conta_azul' => $empresa->token_conta_azul,
                'token_refresh_ca' => $empresa->token_refresh_ca,
                'expira_token_ca' => $empresa->expira_token_ca,
                'nome_empresa' => $empresa->nome_empresa,
                'nome_usuario' => $usuario->nome_usuario,
                'email' => $usuario->email,
                'tipo_acesso' => $usuario->tipo_acesso
            );

            $this->session->set_userdata('usuario', $sessao);

            return $token->access_token;
                
        }else{

            return null;

        }
    }

    public function exportaListaProduto($listaProduto){

        foreach($listaProduto as $produto){

            if($produto->id_conta_azul == null){

                $this->novoProduto($produto->cod_produto);

            }else{

                $this->catualizaEstoquePorCodigo($produto->cod_produto);
                $this->editarProduto($codProduto);
                
            }

        }       

    }

    public function exportaProduto($codProduto, $idContaAzul){

        if($idContaAzul == null){
            return $this->novoProduto($codProduto);
        }else{
            return $this->editarProduto($codProduto);
        }

    }

    public function novoProduto($codProduto){
            
        $produto = $this->produto->getProdutoPorCodigo($codProduto);

        if(getDadosUsuarioLogado()['expira_token_ca'] < date('Y-m-d H:i:s')){

           $this->atualizaToken(getDadosUsuarioLogado()['token_refresh_ca']);
            
        }

        // set HTTP header
        $header = array('Content-Type: application/json', 'Authorization: Bearer ' . getDadosUsuarioLogado()['token_conta_azul']);

        // the url of the API you are contacting to 'consume' 
        $url = "https://api.contaazul.com/v1/products";        

        // Open connection
        $ch = curl_init();

        if($produto->quant_estoq > 0){
            $quantEstoq = $produto->quant_estoq;
        }else{
            $quantEstoq = 0;
        }

        // Dados do item
        $postProduct = array(
            'code' => $produto->cod_produto,
            'name' => $produto->nome_produto,
            'value' => 0,
            'cost' => 0,
            'available_stock' => $quantEstoq
        );

        // Set the url, number of GET vars, GET data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postProduct));

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Execute request
        $result = curl_exec($ch);
        $response =  curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Close connection
        curl_close($ch);

        // get the result and parse to JSON
        $produto = json_decode($result, true);

        if($response != '400'){

            $AtualizaProduto = [
                'id_conta_azul' => $produto['id']
            ];
    
            $this->produto->updateProduto($codProduto, $AtualizaProduto);
            return true;

        }else{

            $this->session->set_flashdata('erro', 'Integração Conta Azul: ' . $produto['message']);

        }

    }

    public function editarProduto($codProduto){
            
        $produto = $this->produto->getProdutoPorCodigo($codProduto);

        if(getDadosUsuarioLogado()['expira_token_ca'] < date('Y-m-d H:i:s')){

            $this->atualizaToken(getDadosUsuarioLogado()['token_refresh_ca']);
             
        }

        // set HTTP header
        $header = array('Content-Type: application/json', 'Authorization: Bearer ' . getDadosUsuarioLogado()['token_conta_azul']);

        // the url of the API you are contacting to 'consume' 
        $url = "https://api.contaazul.com/v1/products/{$produto->id_conta_azul}";        

        // Open connection
        $ch = curl_init();

        if($produto->quant_estoq > 0){
            $quantEstoq = $produto->quant_estoq;
        }else{
            $quantEstoq = 0;
        }

        // Dados do item
        $postProduct = array(
            'name' => $produto->nome_produto,
            'available_stock' => $quantEstoq
        );

        // Set the url, number of GET vars, GET data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postProduct));

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Execute request
        $result = curl_exec($ch);
        $response =  curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Close connection
        curl_close($ch);

        if($response == '400'){  
            
            // get the result and parse to JSON
            $produto = json_decode($result, true);

            $this->session->set_flashdata('erro', 'Integração Conta Azul: ' . $produto['message']);

        }elseif($response == '401'){

            // get the result and parse to JSON
            $produto = json_decode($result, true);

            $this->session->set_flashdata('erro', 'Integração Conta Azul: ' . $produto['error_description']);

        }

    }

    public function importaProdutoPorCodigo($codProduto){

        $produtoSF = $this->produto->getProdutoPorCodigo($codProduto);      

        if(getDadosUsuarioLogado()['expira_token_ca'] < date('Y-m-d H:i:s')){

            $this->atualizaToken(getDadosUsuarioLogado()['token_refresh_ca']);
             
        }

        if($produtoSF->id_conta_azul == null){

            $this->novoProduto($produtoSF->cod_produto);

        }else{ 

            // set HTTP header
            $header = array('Authorization: Bearer ' . getDadosUsuarioLogado()['token_conta_azul']);

            // the url of the API you are contacting to 'consume' 
            $url = "https://api.contaazul.com/v1/products/{$produtoSF->id_conta_azul}";        

            // Open connection
            $ch = curl_init();

            // Set the url, number of GET vars, GET data
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            // Execute request
            $result = curl_exec($ch);
            $response =  curl_getinfo($ch, CURLINFO_HTTP_CODE);

            // Close connection
            curl_close($ch);        

            // get the result and parse to JSON
            $produto = json_decode($result, true);

            if($produto != null && $response == '200'){

                if($produto['code'] != null){                     

                    if($produtoSF->quant_estoq != $produto['available_stock']){

                        $estoqueCA = $produto['available_stock'];

                        $dados = [
                            'id_conta_azul' => $produto['id'],
                            'nome_produto' => $produto['name'],
                        ];

                        $this->produto->updateProduto($produto['code'], $dados);

                        //Identifica valor de movimentação
                        if($produtoSF->quant_estoq > $estoqueCA){
                            $quantMovimento = $produtoSF->quant_estoq - $estoqueCA;
                            $tipoMovimento = 2;
                            $especieMovimento = 13;
                        }elseif($produtoSF->quant_estoq < $estoqueCA){
                            $quantMovimento = $estoqueCA - $produtoSF->quant_estoq;
                            $tipoMovimento = 1;
                            $especieMovimento = 12;
                        }else{
                            $quantMovimento = 0;
                        }

                        if($quantMovimento != 0){

                            $dataEstoque = [
                                'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                                'data_movimento' => date("Y-m-d"),
                                'cod_produto' => $produto['code'],
                                'tipo_movimento' => $tipoMovimento,
                                'especie_movimento' => $especieMovimento,
                                'quant_movimentada' => $quantMovimento
                            ];
            
                            $this->estoque->insertMovimentoEstoque($dataEstoque);

                        }
                    }
                }
            }
        }
    }

    public function atualizaEstoquePorCodigo($codProduto){

        $produtoSF = $this->produto->getProdutoPorCodigo($codProduto);       

        if(getDadosUsuarioLogado()['expira_token_ca'] < date('Y-m-d H:i:s')){

            $this->atualizaToken(getDadosUsuarioLogado()['token_refresh_ca']);
             
        }

        if($produtoSF->id_conta_azul == null){

            $this->novoProduto($produtoSF->cod_produto);

        }else{ 

            // set HTTP header
            $header = array('Authorization: Bearer ' . getDadosUsuarioLogado()['token_conta_azul']);

            // the url of the API you are contacting to 'consume' 
            $url = "https://api.contaazul.com/v1/products/{$produtoSF->id_conta_azul}";        

            // Open connection
            $ch = curl_init();

            // Set the url, number of GET vars, GET data
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            // Execute request
            $result = curl_exec($ch);
            $response =  curl_getinfo($ch, CURLINFO_HTTP_CODE);

            // Close connection
            curl_close($ch);        

            // get the result and parse to JSON
            $produto = json_decode($result, true);

            if($produto != null && $response == '200'){

                if($produto['code'] != null){                     

                    if($produtoSF->quant_estoq != $produto['available_stock']){

                        $estoqueCA = $produto['available_stock'];

                        //Identifica valor de movimentação
                        if($produtoSF->quant_estoq > $estoqueCA){
                            $quantMovimento = $produtoSF->quant_estoq - $estoqueCA;
                            $tipoMovimento = 2;
                            $especieMovimento = 13;
                        }elseif($produtoSF->quant_estoq < $estoqueCA){
                            $quantMovimento = $estoqueCA - $produtoSF->quant_estoq;
                            $tipoMovimento = 1;
                            $especieMovimento = 12;
                        }else{
                            $quantMovimento = 0;
                        }

                        if($quantMovimento != 0){

                            $dataEstoque = [
                                'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                                'data_movimento' => date("Y-m-d"),
                                'cod_produto' => $produto['code'],
                                'tipo_movimento' => $tipoMovimento,
                                'especie_movimento' => $especieMovimento,
                                'quant_movimentada' => $quantMovimento
                            ];
            
                            $this->estoque->insertMovimentoEstoque($dataEstoque);

                        }
                    }
                }
            }
        }
    }

    public function importaProduto(){ 
        
        if(getDadosUsuarioLogado()['expira_token_ca'] < date('Y-m-d H:i:s')){

            $this->atualizaToken(getDadosUsuarioLogado()['token_refresh_ca']);
             
        }

        // set HTTP header
        $header = array('Authorization: Bearer ' . getDadosUsuarioLogado()['token_conta_azul']);

        // the url of the API you are contacting to 'consume' 
        $url = "https://api.contaazul.com/v1/products";        

        // Open connection
        $ch = curl_init();

        // Set the url, number of GET vars, GET data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Execute request
        $result = curl_exec($ch);
        $response =  curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Close connection
        curl_close($ch);        

        // get the result and parse to JSON
        $listaProdutos = json_decode($result, true);

        if($listaProdutos != null && $response == '200'){

            foreach($listaProdutos as $produto){

                $produtoCA = $this->produto->getProdutoContaAzulPorCodigo($produto['id']);
                $produtoSF = $this->produto->getProdutoPorCodigo($produto['code']);

                // Só permite importação dos produtos com códigos definidos
                if($produto['code'] != null){ 
                    
                    //Novo Produto
                    if($produtoCA == null && $produtoSF == null){

                        //Quantidade disponível em estoque
                        $estoqueInicial = $produto['available_stock'];

                        $codTipoProduto = $this->tipoproduto->getTipoProdutoPorIdCA($produto['category']['id']);
                        if($codTipoProduto == null){
                            $data = [
                                'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                                'id_conta_azul' => $produto['category']['id'],
                                'nome_tipo_produto'  => $produto['category']['name'],
                                'origem_produto' => 1
                            ];
                
                            $tipoProduto = $this->tipoproduto->insertTipoProduto($data);
                        }else{
                            $tipoProduto = $codTipoProduto->cod_tipo_produto;
                        }

                        $data = [
                            'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                            'id_conta_azul' => $produto['id'],
                            'cod_produto'  => $produto['code'],
                            'nome_produto' => $produto['name'],
                            'desc_produto' => "",
                            'cod_tipo_produto' => $tipoProduto,
                            'cod_unidade_medida' => 'UN',
                            'quant_estoq' => 0,
                            'estoq_min' => 0,
                            'tempo_abastecimento' => 1
                        ];

                        $this->produto->insertProduto($data);

                        //Movimenta estoque inicial
                        if($estoqueInicial > 0){

                            $dataEstoque = [
                                'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                                'data_movimento' => date("Y-m-d"),
                                'cod_produto' => $produto['code'],
                                'tipo_movimento' => 1,
                                'especie_movimento' => 1,
                                'quant_movimentada' => $estoqueInicial
                            ];

                            $this->estoque->insertMovimentoEstoque($dataEstoque);

                        }
                    }else{

                        $estoqueCA = $produto['available_stock'];

                        $dados = [
                            'id_conta_azul' => $produto['id'],
                            'nome_produto' => $produto['name'],
                        ];

                        $this->produto->updateProduto($produto['code'] , $dados);

                        if($produtoSF->quant_estoq > $estoqueCA){
                            $quantMovimento = $produtoSF->quant_estoq - $estoqueCA;
                            $tipoMovimento = 2;
                            $especieMovimento = 13;
                        }elseif($produtoSF->quant_estoq < $estoqueCA){
                            $quantMovimento = $estoqueCA - $produtoSF->quant_estoq;
                            $tipoMovimento = 1;
                            $especieMovimento = 12;
                        }else{
                            $quantMovimento = 0;
                        }

                        if($quantMovimento != 0){

                            $dataEstoque = [
                                'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
                                'data_movimento' => date("Y-m-d"),
                                'cod_produto' => $produto['code'],
                                'tipo_movimento' => $tipoMovimento,
                                'especie_movimento' => $especieMovimento,
                                'quant_movimentada' => $quantMovimento
                            ];
    
                            $this->estoque->insertMovimentoEstoque($dataEstoque);

                        }
                    }                    
                }
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