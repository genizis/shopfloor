<?php

class Email extends CI_Model{

    public function emailBoasVindas($empresa, $nome, $usuario, $validade){   
        
        $this->load->library("PhpMailerLib");
        $mail = $this->phpmailerlib->load();

        $mail->SMTPDebug = 0;  
        $mail->CharSet = "UTF-8";                             
        $mail->isSMTP();                                      
        $mail->Host = 'mail.shopfloor.com.br';  
        $mail->SMTPAuth = true;                               
        $mail->Username = 'contato@shopfloor.com.br';                 
        $mail->Password = 'GeneRene2020';                    
        $mail->SMTPSecure = 'ssl';                            
        $mail->Port = 465;
        $mail->setFrom('contato@shopfloor.com.br', 'Contato do ShopFloor');  

        //$this->setConfigServidor();
        
        $mail->addAddress($usuario);    
        $mail->addReplyTo('contato@shopfloor.com.br', 'Contato');
        $mail->AddBCC("contato@shopfloor.com.br");

        $texto = '<html>
        <head>
            <style>
            .corpo{
                background-color: #f8f8f8!important;
            }
            .conteudo {	
                padding-top: 1rem;
                padding-bottom: 1rem;
            }
            .card {			  
                border: 1px solid rgb(206, 212, 218);
                border-radius: 0.25rem;
                font-family: "Roboto", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
                font-size: 0.875rem;
                font-weight: 400;
                line-height: 1.5;
                color: #3E3F3A;
                text-align: center!important;
                background-color: #fff!important;
                width: 600px;
            }
            
            .card-body {
                min-height: 1px;
                padding: 2rem;
            }
            
            .card-header {
                padding: 1.5rem 3rem;
                margin-bottom: 0;
                color: #fff!important;
                background-color: #29ABE0;
                border-bottom: 1px solid #29ABE0;		  
            }
            
            .display-1 {		  
                font-size: 2.9rem;
                font-weight: 400;
                line-height: 1.2;
            }
            
            .subtitulo {		  
                font-weight: 500;
                line-height: 1.5;
            }
            
            .hr-header {
                border: 1px solid #fff;
            }
            
            .hr-body {
                border: 1px solid rgb(206, 212, 218);
                width: 20%;
            }
            
            .img-logo {
                margin-bottom: 40px;			
            }
            
            .table-usu{
                border: 0px;
                text-align: center!important;
                font-size: 0.9rem;
                font-weight: 400;
                line-height: 1.5;
                width: 100%;
                font-family: "Roboto", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"
            }
            
            .table-label{
                text-align: left!important;
                font-weight: 600;
                color: #3E3F3A !important;
            }
            .table-info{
                text-align: right!important;
                font-weight: 400;
                color: #8E8C84 !important;
            }
            
            .text-dark{
                color: #55544f !important;
            }
            
            .text-muted{
                color: #8E8C84 !important;
            }
            
            .paragrafo{
                width: 80%;
                color: #63625c !important;
                font-size: 15px;
                margin-bottom: 40px;
            }
            
            .suporte{
                width: 80%;
                color: #63625c !important;
                font-size: 15px;
                margin-top: 40px;
                margin-bottom: 40px;
            }
            
            .table-processo{
                font-size: 15px;
                text-align: center!important;
                align: center;
            }
            
            </style>
        </head>
        <body>
            <div class="corpo" style="background-color: #f8f8f8!important;">
                <div class="conteudo" style="padding-top: 1rem;padding-bottom: 1rem;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="center">
                                <div class="card" style="border: 1px solid rgb(206, 212, 218);border-radius: 0.25rem;font-family: &quot;Roboto&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;;font-size: 0.875rem;font-weight: 400;line-height: 1.5;color: #3E3F3A;width: 600px;text-align: center!important;background-color: #fff!important;">
                                    <div class="card-header" style="padding: 1.5rem 3rem;margin-bottom: 0;background-color: #29ABE0;border-bottom: 1px solid #29ABE0;color: #fff!important;">
                                        <img src="cid:logo" class="img-logo" style="margin-bottom: 40px;">
                                        <hr class="hr-header" style="border: 1px solid #fff;">
                                        <h1 class="display-1" style="font-size: 2.9rem;font-weight: 400;line-height: 1.2;">Bem-vindo!</h1>
                                        <h2 class="subtitulo" style="font-weight: 500;line-height: 1.5;">Agora você já pode aproveitar seu tempo grátis e descobrir por que somos a melhor solução para seu negócio.</h2>
                                    </div>
                                    <div class="card-body" style="min-height: 1px;padding: 2rem;">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="center">
                                                    <img src="cid:estoque">
                                                    <h2 class="text-dark" style="color: #55544f !important;">Estoque</h2>
                                                    <p class="paragrafo" style="width: 80%;font-size: 15px;margin-bottom: 40px;color: #63625c !important;">Controle o estoque por meio de baixas automáticas dos itens comprados, vendidos e produzidos. E monitore periodicamente as movimentações pelo inventário.</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <img src="cid:vendas">
                                                    <h2 class="text-dark" style="color: #55544f !important;">Vendas</h2>
                                                    <p class="paragrafo" style="width: 80%;font-size: 15px;margin-bottom: 40px;color: #63625c !important;">Emita, imprima e fature os pedidos de venda. E acompanhe o desempenho comercial da empresa.</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <img src="cid:compras">
                                                    <h2 class="text-dark" style="color: #55544f !important;">Compras</h2>
                                                    <p class="paragrafo" style="width: 80%;font-size: 15px;margin-bottom: 40px;color: #63625c !important;">Crie ordens, emita e receba pedidos de compra para coordenar o estoque de materiais e insumos da produção.</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <img src="cid:financeiro">
                                                    <h2 class="text-dark" style="color: #55544f !important;">Gestão financeira</h2>
                                                    <p class="paragrafo" style="width: 80%;font-size: 15px;margin-bottom: 40px;color: #63625c !important;">Acompanhe pagamentos, recebimentos e administre o fluxo de caixa. Totalmente integrado com os demais módulos.</p>
                                                </td>
                                            </tr>
                                        </table>
                                        <hr class="hr-body" style="border: 1px solid rgb(206, 212, 218);width: 20%;">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="center">
                                                    <p class="suporte" style="width: 80%;font-size: 15px;margin-top: 40px;margin-bottom: 40px;color: #63625c !important;">Caso tenha alguma dúvida, entre em contato com nosso suporte por meio do email <b>suporte@shopfloor.com.br</b> ou whatsapp: (42) 98819-2794.</p>	
                                                </td>
                                            </tr>
                                        </table>	
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="center">
                                                    <h2 class="text-dark" style="color: #55544f !important;">Seus dados</h2>
                                                    <table class="table-usu" style="border: 0px;font-size: 0.9rem;font-weight: 400;line-height: 1.5;width: 100%;font-family: &quot;Roboto&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;;text-align: center!important;">
                                            <tr>
                                                <td class="table-label" style="font-weight: 600;text-align: left!important;color: #3E3F3A !important;">Empresa:</td>
                                                <td class="table-info" style="font-weight: 400;text-align: right!important;color: #8E8C84 !important;">' . $empresa . '</td>
                                            </tr>
                                            <tr>
                                                <td class="table-label" style="font-weight: 600;text-align: left!important;color: #3E3F3A !important;">Nome:</td>
                                                <td class="table-info" style="font-weight: 400;text-align: right!important;color: #8E8C84 !important;">' . $nome . '</td>
                                            </tr>
                                            <tr>
                                                <td class="table-label" style="font-weight: 600;text-align: left!important;color: #3E3F3A !important;">Usuário:</td>
                                                <td class="table-info" style="font-weight: 400;text-align: right!important;color: #8E8C84 !important;">' . $usuario . '</td>
                                            </tr>
                                            <tr>
                                                <td class="table-label" style="font-weight: 600;text-align: left!important;color: #3E3F3A !important;">Data de Expiração:</td>
                                                <td class="table-info" style="font-weight: 400;text-align: right!important;color: #8E8C84 !important;">' . str_replace('-', '/', date("d-m-Y", strtotime($validade))) . '</td>
                                            </tr>
                                        </table>
                                                </td>
                                            </tr>
                                        </table>
                                        
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </body></html>';

        $mail->isHTML(true);                                  
        $mail->Subject = 'Bem-vindo ao ShopFloor, ' . getDadosUsuarioLogado()['nome_usuario'];
        $mail->Body    = $texto;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        $mail->AddEmbeddedImage('img/logo-branco.png', 'logo');

        $mail->AddEmbeddedImage('img/icon/compras.png', 'compras');
        $mail->AddEmbeddedImage('img/icon/estoque.png', 'estoque');
        $mail->AddEmbeddedImage('img/icon/financeiro.png', 'financeiro');
        $mail->AddEmbeddedImage('img/icon/vendas.png', 'vendas');
        //$mail->AddAttachment('img/logo-branco.png');

        $mail->send();

    }

}