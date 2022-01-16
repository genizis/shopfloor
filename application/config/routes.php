<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'OmicronController';
$route['404_override'] = 'OmicronController/paginaNula';
$route['translate_uri_dashes'] = FALSE;

//Rotas Visão Geral
$route['visao-geral']['GET'] =  'VisaoGeralController/visaoGeral';
$route['logout']['GET'] =  'VisaoGeralController/logoutUsuario';

$route['login']['GET'] =  'OmicronController/formLogin';
$route['login']['POST'] =  'OmicronController/loginUsuario';

$route['teste']['GET'] =  'TesteController/testeNFE';

$route['comece-agora']['GET'] =  'OmicronController/formCadastroEmpresa';
$route['comece-agora']['POST'] =  'OmicronController/inserirEmpresa';

//Rotas Usuário
$route['usuario/novo-usuario']['GET'] =  'UsuariosController/formUsuario';
$route['usuario/novo-usuario']['POST'] =  'UsuariosController/inserirUsuario';

$route['usuario/editar-usuario/(:any)']['GET'] = 'UsuariosController/editarUsuario/$1';
$route['usuario/editar-usuario/(:any)']['POST'] = 'UsuariosController/salvarUsuario/$1';

$route['usuario']['GET'] = 'UsuariosController/listarUsuario';
$route['usuario'] = 'UsuariosController/listarUsuario';
$route['usuario/(:num)'] = 'UsuariosController/listarUsuario';

//Rotas Usuário e Empresa
$route['dados-empresa']['GET'] =  'EmpresaController/editarEmpresa';
$route['dados-empresa']['POST'] =  'EmpresaController/salvarEmpresa';
$route['solicita-conexao-conta-azul']['GET'] =  'EmpresaController/solicitaConexaoContaAzul';
$route['retira-aviso-conta-azul']['GET'] =  'EmpresaController/retiraNotificacaoContaAzul';
$route['desconecta-conta-azul'] =  'EmpresaController/DesconectaContaAzul';
$route['conta-azul-integration']['GET'] =  'IntegracoesController/callbackContaAzul';
$route['conecta-conta-azul/(:any)/(:any)'] =  'EmpresaController/conectaContaAzul/$1/$2';

$route['meus-dados']['GET'] =  'EmpresaController/editarMeusDados';
$route['meus-dados']['POST'] =  'EmpresaController/salvarMeusDados';

$route['usuarios/novo-usuario']['GET'] =  'UsuariosController/formCadastroUsuario';
$route['usuarios/novo-usuario']['POST'] =  'UsuariosController/inserirUsuario';

//Rotas Natureza de Operação
$route['natureza-operacao']['GET'] =  'EmpresaController/listarNaturezaOperacao';
$route['natureza-operacao'] =  'EmpresaController/listarNaturezaOperacao';
$route['natureza-operacao/(:num)']['GET'] =  'EmpresaController/listarNaturezaOperacao';

$route['natureza-operacao/nova']['GET'] =  'EmpresaController/formNaturezaOperacao';
$route['natureza-operacao/nova']['POST'] =  'EmpresaController/inserirNaturezaOperacao';
$route['natureza-operacao/editar/(:any)']['GET'] = 'EmpresaController/formEditarNaturezaOperacao/$1';
$route['natureza-operacao/excluir-natureza'] = 'EmpresaController/excluirNaturezaOperacao';
$route['natureza-operacao/ajax/(:any)']['GET'] = 'EmpresaController/ajaxeditarNaturezaOperacao/$1';

//Rotas Nota fiscal
$route['nota-fiscal/nova']['GET'] =  'NotaFiscalController/formNotaFiscal';
$route['nota-fiscal/nova']['POST'] =  'NotaFiscalController/inserirNotaFiscal';

$route['nota-fiscal/api/produtos-faturamento']['GET'] =  'NotaFiscalController/getProdutoFaturamento';
$route['nota-fiscal/api/lista-faturamento']['GET'] =  'NotaFiscalController/getNotaFiscalIDFaturamento';



//Rotas Financeiro
$route['conta/nova-conta']['GET'] =  'FinanceiroController/formConta';

$route['conta']['GET'] = 'FinanceiroController/listarConta';
$route['conta'] = 'FinanceiroController/listarConta';
$route['conta/(:num)'] = 'FinanceiroController/listarConta';

$route['conta/nova-conta']['POST'] = 'FinanceiroController/inserirConta';
$route['conta/excluir-conta'] = 'FinanceiroController/excluirConta';
$route['conta/editar-conta/(:any)']['GET'] = 'FinanceiroController/editarConta/$1';
$route['conta/editar-conta/(:any)']['POST'] = 'FinanceiroController/salvarConta/$1';

$route['metodo-pagamento/novo-metodo-pagamento']['GET'] =  'FinanceiroController/formMetodoPagamento';
$route['metodo-pagamento/novo-metodo-pagamento']['POST'] = 'FinanceiroController/inserirMetodoPagamento';

$route['metodo-pagamento']['GET'] = 'FinanceiroController/listarMetodoPagamento';
$route['metodo-pagamento'] = 'FinanceiroController/listarMetodoPagamento';
$route['metodo-pagamento/(:num)'] = 'FinanceiroController/listarMetodoPagamento';
$route['metodo-pagamento/excluir-metodo-pagamento'] = 'FinanceiroController/excluirMetodoPagamento';

$route['metodo-pagamento/editar-metodo-pagamento/(:any)']['GET'] = 'FinanceiroController/editarMetodoPagamento/$1';
$route['metodo-pagamento/editar-metodo-pagamento/(:any)']['POST'] = 'FinanceiroController/salvarMetodoPagamento/$1';

$route['centro-custo/novo-centro-custo']['GET'] =  'FinanceiroController/formCentroCusto';

$route['centro-custo']['GET'] = 'FinanceiroController/listarCentroCusto';
$route['centro-custo'] = 'FinanceiroController/listarCentroCusto';
$route['centro-custo/(:num)'] = 'FinanceiroController/listarCentroCusto';

$route['centro-custo/novo-centro-custo']['POST'] = 'FinanceiroController/inserirCentroCusto';
$route['centro-custo/excluir-centro-custo'] = 'FinanceiroController/excluirCentroCusto';
$route['centro-custo/editar-centro-custo/(:any)']['GET'] = 'FinanceiroController/editarCentroCusto/$1';
$route['centro-custo/editar-centro-custo/(:any)']['POST'] = 'FinanceiroController/salvarCentroCusto/$1';

$route['conta-contabil/nova-conta-contabil']['GET'] =  'FinanceiroController/formContaContabil';
$route['conta-contabil/nova-conta-contabil']['POST'] = 'FinanceiroController/inserirContaContabil';

$route['conta-contabil']['GET'] = 'FinanceiroController/listarContaContabil';
$route['conta-contabil'] = 'FinanceiroController/listarContaContabil';
$route['conta-contabil/(:num)'] = 'FinanceiroController/listarContaContabil';

$route['conta-contabil/excluir-conta-contabil'] = 'FinanceiroController/excluirContaContabil';
$route['conta-contabil/editar-conta-contabil/(:any)']['GET'] = 'FinanceiroController/editarContaContabil/$1';
$route['conta-contabil/editar-conta-contabil/(:any)']['POST'] = 'FinanceiroController/salvarContaContabil/$1';

$route['financeiro/contas-pagar']['GET'] = 'FinanceiroController/redirecionaContasPagar';
$route['financeiro/contas-pagar/(:any)/(:any)']['GET'] = 'FinanceiroController/contasPagar/$1/$2';


$route['financeiro/contas-pagar/inserir-titulo/(:any)/(:any)']['POST'] = 'FinanceiroController/inserirTituloContasPagar/$1/$2';
$route['financeiro/contas-pagar/acao-titulo/(:any)/(:any)'] = 'FinanceiroController/acaoTituloContasPagar/$1/$2';
$route['financeiro/contas-pagar/editar-titulo/(:any)/(:any)/(:any)']['POST'] = 'FinanceiroController/salvarTituloContasPagar/$1/$2/$3';

$route['financeiro/contas-receber']['GET'] = 'FinanceiroController/redirecionaContasReceber';
$route['financeiro/contas-receber/(:any)/(:any)']['GET'] = 'FinanceiroController/contasReceber/$1/$2';


$route['financeiro/contas-receber/inserir-titulo/(:any)/(:any)']['POST'] = 'FinanceiroController/inserirTituloContasReceber/$1/$2';
$route['financeiro/contas-receber/acao-titulo/(:any)/(:any)'] = 'FinanceiroController/acaoTituloContasReceber/$1/$2';
$route['financeiro/contas-receber/editar-titulo/(:any)/(:any)/(:any)']['POST'] = 'FinanceiroController/salvarTituloContasReceber/$1/$2/$3';

$route['financeiro/saldo-conta/movimento-conta/acao-titulo/(:any)'] = 'FinanceiroController/acaoTitulo/$1';
$route['financeiro/saldo-conta/inserir-titulo/(:any)'] = 'FinanceiroController/inserirTitulo/$1';
$route['financeiro/saldo-conta/inserir-transferencia/(:any)'] = 'FinanceiroController/inserirTransferencia/$1';
$route['financeiro/saldo-conta/salvar-titulo/(:any)/(:any)'] = 'FinanceiroController/salvarTitulo/$1/$2';

$route['financeiro/saldo-conta/movimento-conta/(:any)']['GET'] = 'FinanceiroController/movimentoConta/$1';
$route['financeiro/saldo-conta/movimento-conta/(:any)'] = 'FinanceiroController/movimentoConta/$1';
$route['financeiro/saldo-conta/movimento-conta/(:any)/(:num)'] = 'FinanceiroController/movimentoConta/$1';



$route['financeiro/saldo-conta']['GET'] = 'FinanceiroController/redirecionaSaldoConta';
$route['financeiro/saldo-conta/(:any)/(:any)']['GET'] = 'FinanceiroController/listarSaldoConta/$1/$2';
$route['financeiro/saldo-conta/(:any)/(:any)/(:num)'] = 'FinanceiroController/listarSaldoConta';
$route['financeiro/saldo-conta/(:any)/(:any)/(:num)'] = 'FinanceiroController/listarSaldoConta';




//Rotas Unidade de Medida
$route['unidade-medida/nova-unidade-medida']['GET'] =  'UnidadeMedidaController/formCadastroUnidadeMedida';

$route['unidade-medida']['GET'] = 'UnidadeMedidaController/listarUnidadeMedida';
$route['unidade-medida'] = 'UnidadeMedidaController/listarUnidadeMedida';
$route['unidade-medida/(:num)'] = 'UnidadeMedidaController/listarUnidadeMedida';

$route['unidade-medida/nova-unidade-medida']['POST'] = 'UnidadeMedidaController/inserirUnidadeMedida';
$route['unidade-medida/excluir-unidade-medida'] = 'UnidadeMedidaController/excluirUnidadeMedida';
$route['unidade-medida/editar-unidade-medida/(:any)']['GET'] = 'UnidadeMedidaController/editarUnidadeMedida/$1';
$route['unidade-medida/editar-unidade-medida/(:any)']['POST'] = 'UnidadeMedidaController/salvarUnidadeMedida/$1';

//Rotas Tipo de Produto
$route['tipo-produto/novo-tipo-produto']['GET'] =  'TipoProdutoController/formTipoProduto';

$route['tipo-produto']['GET'] = 'TipoProdutoController/listarTipoProduto';
$route['tipo-produto'] = 'TipoProdutoController/listarTipoProduto';
$route['tipo-produto/(:num)'] = 'TipoProdutoController/listarTipoProduto';

$route['tipo-produto/novo-tipo-produto']['POST'] = 'TipoProdutoController/inserirTipoProduto';
$route['tipo-produto/excluir-tipo-produto'] = 'TipoProdutoController/excluirTipoProduto';
$route['tipo-produto/editar-tipo-produto/(:any)']['GET'] = 'TipoProdutoController/editarTipoProduto/$1';
$route['tipo-produto/editar-tipo-produto/(:any)']['POST'] = 'TipoProdutoController/salvarTipoProduto/$1';

//Rotas Produto
$route['produto/novo-produto']['GET'] =  'ProdutoController/formProduto';
$route['produto/importa-produto-conta-azul'] = 'ProdutoController/importaProdutoContaAzul';
$route['produto/exporta-produto-conta-azul'] = 'ProdutoController/exportaProdutoContaAzul';

$route['produto']['GET'] = 'ProdutoController/listarProduto';
$route['produto'] = 'ProdutoController/listarProduto';
$route['produto/(:num)'] = 'ProdutoController/listarProduto';

$route['produto/novo-produto']['POST'] = 'ProdutoController/inserirProduto';
$route['produto/excluir-produto'] = 'ProdutoController/excluirProduto';
$route['produto/editar-produto/(:any)']['GET'] = 'ProdutoController/editarProduto/$1';
$route['produto/editar-produto/(:any)']['POST'] = 'ProdutoController/salvarProduto/$1';

//Rotas Cliente
$route['cliente/novo-cliente']['GET'] =  'ClienteController/formCliente';
$route['cliente/importa-cliente-conta-azul'] = 'ClienteController/importaClienteContaAzul';

$route['cliente']['GET'] = 'ClienteController/listarCliente';
$route['cliente'] = 'ClienteController/listarCliente';
$route['cliente/(:num)'] = 'ClienteController/listarCliente';

$route['cliente/novo-cliente']['POST'] = 'ClienteController/inserirCliente';
$route['cliente/excluir-cliente'] = 'ClienteController/excluirCliente';
$route['cliente/editar-cliente/(:any)']['GET'] = 'ClienteController/editarCliente/$1';
$route['cliente/editar-cliente/(:any)']['POST'] = 'ClienteController/salvarCliente/$1';

$route['cliente/importar-cliente']['GET'] = 'ClienteController/listaImportaCliente';
$route['cliente/importar-cliente']['POST'] = 'ClienteController/importarCliente';

//Rotas Vendedor
$route['vendedor/novo-vendedor']['GET'] =  'VendedorController/formVendedor';
$route['vendedor/novo-vendedor']['POST'] = 'VendedorController/inserirVendedor';

$route['vendedor']['GET'] = 'VendedorController/listarVendedor';
$route['vendedor'] = 'VendedorController/listarVendedor';
$route['vendedor/(:num)'] = 'VendedorController/listarVendedor';

$route['vendedor/excluir-vendedor'] = 'VendedorController/excluirVendedor';

$route['vendedor/editar-vendedor/(:any)']['GET'] = 'VendedorController/editarVendedor/$1';
$route['vendedor/editar-vendedor/(:any)']['POST'] = 'VendedorController/salvarVendedor/$1';

//Rotas Fornecedor
$route['fornecedor/novo-fornecedor']['GET'] =  'FornecedorController/formFornecedor';

$route['fornecedor']['GET'] = 'FornecedorController/listarFornecedor';
$route['fornecedor'] = 'FornecedorController/listarFornecedor';
$route['fornecedor/(:num)'] = 'FornecedorController/listarFornecedor';

$route['fornecedor/novo-fornecedor']['POST'] = 'FornecedorController/inserirFornecedor';
$route['fornecedor/excluir-fornecedor'] = 'FornecedorController/excluirFornecedor';
$route['fornecedor/editar-fornecedor/(:any)']['GET'] = 'FornecedorController/editarFornecedor/$1';
$route['fornecedor/editar-fornecedor/(:any)']['POST'] = 'FornecedorController/salvarFornecedor/$1';

$route['fornecedor/importar-fornecedor']['GET'] = 'FornecedorController/listaImportaFornecedor';
$route['fornecedor/importar-fornecedor']['POST'] = 'FornecedorController/importarFornecedor';

//Rotas Engenharia
$route['estrutura-produto/nova-estrutura-produto']['GET'] =  'EngenhariaController/formEstruturaProduto';
$route['estrutura-produto/nova-estrutura-produto']['POST'] = 'EngenhariaController/inserirEstruturaProduto';

$route['estrutura-produto/inserir-estrutura-componente']['POST'] = 'EngenhariaController/inserirEstruturaComponente';
$route['estrutura-produto/salvar-estrutura-componente/(:any)/(:any)']['POST'] = 'EngenhariaController/salvarEstruturaComponente/$1/$1';

$route['estrutura-produto/editar-estrutura-produto/(:any)']['GET'] = 'EngenhariaController/editarEstruturaProduto/$1';
$route['estrutura-produto/editar-estrutura-produto/(:any)']['POST'] = 'EngenhariaController/salvarEstruturaProduto/$1';

$route['estrutura-produto/excluir-estrutura-componente'] = 'EngenhariaController/excluirEstruturaComponente';
$route['estrutura-produto/excluir-estrutura-produto'] = 'EngenhariaController/excluirEstruturaProduto';

$route['estrutura-produto']['GET'] = 'EngenhariaController/listarEstruturaProduto';
$route['estrutura-produto'] = 'EngenhariaController/listarEstruturaProduto';
$route['estrutura-produto/(:num)'] = 'EngenhariaController/listarEstruturaProduto';

//Rotas Compras
$route['compras/ordem-compra/nova-ordem-compra']['GET'] =  'ComprasController/formOrdemCompra';
$route['compras/ordem-compra/nova-ordem-compra']['POST'] = 'ComprasController/inserirOrdemCompra';

$route['compras/ordem-compra/editar-ordem-compra/(:any)']['GET'] = 'ComprasController/editarOrdemCompra/$1';
$route['compras/ordem-compra/editar-ordem-compra/(:any)']['POST'] = 'ComprasController/salvarOrdemCompra/$1';

$route['compras/ordem-compra/excluir-ordem'] = 'ComprasController/excluirOrdemCompra';

$route['compras/ordem-compra']['GET'] = 'ComprasController/listarOrdem';
$route['compras/ordem-compra'] = 'ComprasController/listarOrdem';
$route['compras/ordem-compra/(:num)'] = 'ComprasController/listarOrdem';

$route['compras/pedido-compra/novo-pedido-compra']['GET'] = 'ComprasController/formPedidoCompra';
$route['compras/pedido-compra/novo-pedido-compra']['POST'] = 'ComprasController/inserirPedidoCompra';
$route['compras/pedido-compra/gerar-pedido-compra']['POST'] = 'ComprasController/gerarPedidoCompra';
$route['compras/pedido-compra/editar-pedido-compra/(:any)']['GET'] = 'ComprasController/editarPedidoCompra/$1';
$route['compras/pedido-compra/editar-pedido-compra/(:any)']['POST'] = 'ComprasController/salvarPedidoCompra/$1';
$route['compras/pedido-compra/adicionar-ordem-compra/(:any)']['POST'] = 'ComprasController/inserirOrdemPedido/$1';
$route['compras/pedido-compra/salvar-ordem-compra/(:any)']['POST'] = 'ComprasController/salvarOrdemPedido/$1';
$route['compras/pedido-compra/nova-ordem-compra/(:any)']['POST'] = 'ComprasController/novaOrdemPedido/$1';
$route['compras/pedido-compra/excluir-ordem-compra/(:any)'] = 'ComprasController/excluirOrdemPedido/$1';
$route['compras/pedido-compra/excluir-pedido'] = 'ComprasController/excluirPedidoCompra';

$route['compras/pedido-compra']['GET'] = 'ComprasController/listarPedido';
$route['compras/pedido-compra'] = 'ComprasController/listarPedido';
$route['compras/pedido-compra/(:num)'] = 'ComprasController/listarPedido';

$route['compras/recebimento-material/estornar-recebimento-material/(:any)']['POST'] = 'ComprasController/estornarRecebimentoMaterial/$1';

$route['compras/recebimento-material/novo-recebimento-material/(:any)']['GET'] = 'ComprasController/edtarRecebimentoMaterial/$1';
$route['compras/recebimento-material/inserir-recebimento/(:any)/(:any)']['POST'] = 'ComprasController/inserirRecebimentoMaterial/$1/$2';

$route['compras/recebimento-material']['GET'] = 'ComprasController/listarRecebimentoMaterial';
$route['compras/recebimento-material'] = 'ComprasController/listarRecebimentoMaterial';
$route['compras/recebimento-material/(:num)'] = 'ComprasController/listarRecebimentoMaterial';

$route['compras/imprimir-pedido/(:num)'] = 'ComprasController/imprimirPedido/$1';

//Rotas Vendas
$route['vendas/pedido-venda/novo-pedido-venda']['GET'] =  'VendasController/formPedidoVenda';

$route['vendas/pedido-venda']['GET'] = 'VendasController/listarPedidoVenda';
$route['vendas/pedido-venda'] = 'VendasController/listarPedidoVenda';
$route['vendas/pedido-venda/(:num)'] = 'VendasController/listarPedidoVenda';
$route['vendas/faturamento-pedido']['GET'] = 'VendasController/listarFaturamentoVenda';
$route['vendas/faturamento-pedido'] = 'VendasController/listarFaturamentoVenda';
$route['vendas/faturamento-pedido/(:num)'] = 'VendasController/listarFaturamentoVenda';
$route['vendas/faturamento-pedido/estornar-faturamento-pedido/(:any)']['POST'] = 'VendasController/estornarFaturamentoPedido/$1';


$route['vendas/pedido-venda/novo-pedido-venda']['POST'] = 'VendasController/inserirPedidoVenda';
$route['vendas/pedido-venda/editar-pedido-venda/(:any)']['GET'] = 'VendasController/editarPedidoVenda/$1';
$route['vendas/pedido-venda/editar-pedido-venda/(:any)']['POST'] = 'VendasController/salvarPedidoVenda/$1';
$route['vendas/pedido-venda/inserir-produto-venda/(:any)']['POST'] = 'VendasController/inserirProdutoVenda/$1';
$route['vendas/pedido-venda/salvar-produto-venda/(:any)/(:any)']['POST'] = 'VendasController/salvarProdutoVenda/$1/$2';
$route['vendas/pedido-venda/excluir-produto-venda'] = 'VendasController/excluirProdutoVenda';
$route['vendas/pedido-venda/excluir-pedido-venda'] = 'VendasController/excluirPedido';
$route['vendas/faturamento-pedido/novo-faturamento-pedido/(:any)']['GET'] = 'VendasController/editFaturamentoPedido/$1';
$route['vendas/faturamento-pedido/inserir-faturamento/(:any)/(:any)']['POST'] = 'VendasController/inserirFaturamento/$1/$2';

$route['vendas/imprimir-pedido/(:num)'] = 'VendasController/imprimirPedido/$1';

$route['vendas/frente-caixa']['GET'] = 'VendasController/redirecionaFrenteCaixa';
$route['vendas/frente-caixa/(:any)']['GET'] = 'VendasController/frenteCaixa/$1';

$route['vendas/abrir-caixa/(:any)']['POST'] = 'VendasController/abrirCaixa/$1';
$route['vendas/fechar-caixa/(:any)']['POST'] = 'VendasController/fecharCaixa/$1';
$route['vendas/reabrir-caixa/(:any)']['POST'] = 'VendasController/reabrirCaixa/$1';
$route['vendas/inserir-movimento/(:any)']['POST'] = 'VendasController/inserirMovimento/$1';

$route['vendas/frente-caixa/estorno-venda/(:any)']['POST'] = 'VendasController/estornoVendaCaixa/$1';
$route['vendas/frente-caixa/excluir-movimento/(:any)']['POST'] = 'VendasController/excluirMovimentoCaixa/$1';

$route['vendas/frente-caixa/(:any)/nova-venda-caixa']['GET'] =  'VendasController/novaVendaCaixa/$1';
$route['vendas/frente-caixa/(:any)/nova-venda-caixa']['POST'] =  'VendasController/inserirVendaCaixa/$1';

$route['vendas/frente-caixa/editar-venda-caixa/(:any)']['GET'] =  'VendasController/editarVendaCaixa/$1';
$route['vendas/frente-caixa/salvar-venda-caixa/(:any)']['POST'] =  'VendasController/salvarVendaCaixa/$1';

$route['vendas/imprimir-venda-frente-caixa/(:num)'] = 'VendasController/imprimirVendaCaixa/$1';
$route['vendas/imprimir-fechamento-caixa/(:any)'] = 'VendasController/imprimirFechamentoCaixa/$1';

//Rotas Vendas Ambiente Vendedor
$route['login-vendedor']['GET'] =  'OmicronController/formLoginVendedor';
$route['login-vendedor']['POST'] =  'OmicronController/loginUsuarioVendedor';
$route['logout-vendedor']['GET'] =  'VendasVendedorController/logoutUsuario';

$route['vendas/imprimir-pedido-vendedor/(:num)'] = 'VendasVendedorController/imprimirPedido/$1';

$route['vendas/pedido-venda-vendedor']['GET'] = 'VendasVendedorController/listarPedidoVenda';
$route['vendas/pedido-venda-vendedor'] = 'VendasVendedorController/listarPedidoVenda';
$route['vendas/pedido-venda-vendedor/(:num)'] = 'VendasVendedorController/listarPedidoVenda';

$route['vendas/pedido-venda-vendedor/novo-pedido-venda-vendedor']['GET'] =  'VendasVendedorController/formPedidoVenda';
$route['vendas/pedido-venda-vendedor/novo-pedido-venda-vendedor']['POST'] = 'VendasVendedorController/inserirPedidoVenda';

$route['vendas/pedido-venda-vendedor/editar-pedido-venda-vendedor/(:any)']['GET'] = 'VendasVendedorController/editarPedidoVenda/$1';
$route['vendas/pedido-venda-vendedor/editar-pedido-venda-vendedor/(:any)']['POST'] = 'VendasVendedorController/salvarPedidoVenda/$1';

$route['vendas/pedido-venda-vendedor/inserir-produto-venda-vendedor/(:any)']['POST'] = 'VendasVendedorController/inserirProdutoVenda/$1';
$route['vendas/pedido-venda-vendedor/salvar-produto-venda-vendedor/(:any)/(:any)']['POST'] = 'VendasVendedorController/salvarProdutoVenda/$1/$2';

$route['vendas/faturamento-pedido/inserir-faturamento-vendedor/(:any)/(:any)']['POST'] = 'VendasVendedorController/inserirFaturamento/$1/$2';

//Rotas Produção
$route['producao/indicadores-producao']['GET'] =  'ProducaoController/visaoProducao';
$route['producao/ordem-producao/nova-ordem-producao']['GET'] =  'ProducaoController/formOrdemProducao';
$route['producao/ordem-producao/nova-ordem-producao']['POST'] = 'ProducaoController/inserirOrdemProducao';
$route['producao/ordem-producao/inserir-produto-consumo/(:any)']['POST'] = 'ProducaoController/inserirComponenteProducao/$1';

$route['producao/ordem-producao/editar-ordem-producao/(:any)']['GET'] = 'ProducaoController/editarOrdemProducao/$1';
$route['producao/ordem-producao/editar-ordem-producao/(:any)']['POST'] = 'ProducaoController/salvarOrdemProducao/$1';
$route['producao/ordem-producao/salvar-produto-consumo/(:any)/(:any)']['POST'] = 'ProducaoController/salvarComponenteProducao/$1/$2';

$route['producao/ordem-producao/excluir-componente-producao/(:any)'] = 'ProducaoController/excluirComponenteProducao/$1';
$route['producao/ordem-producao/excluir-ordem-producao'] = 'ProducaoController/excluirOrdemProducao';

$route['producao/ordem-producao']['GET'] = 'ProducaoController/listarOrdemProducao';
$route['producao/ordem-producao'] = 'ProducaoController/listarOrdemProducao';
$route['producao/ordem-producao/(:num)'] = 'ProducaoController/listarOrdemProducao';

$route['producao/reporte-producao']['GET'] = 'ProducaoController/listarOrdemReporte';
$route['producao/reporte-producao'] = 'ProducaoController/listarOrdemReporte';
$route['producao/reporte-producao/(:num)'] = 'ProducaoController/listarOrdemReporte';

$route['producao/reporte-producao/reportar-producao/(:any)/(:any)/(:any)']['POST'] = 'ProducaoController/repotarProducao/$1/$2/$3';
$route['producao/reporte-producao/estornar-reporte-producao/(:any)']['POST'] = 'ProducaoController/estornarReporteProducao/$1';
$route['producao/reporte-producao/novo-reporte-producao/(:any)']['GET'] = 'ProducaoController/editReporteOrdemPoducao/$1';

$route['producao/imprimir-ordem/(:num)'] = 'ProducaoController/imprimirOrdem/$1';


//Rotas Relatório e Indicadores de Produção
$route['relatorios/producao-produto']['GET'] = 'ProducaoController/producaoProduto';
$route['relatorios/consumo-produto']['GET'] = 'ProducaoController/consumoProduto';

$route['relatorios/venda-produto']['GET'] = 'VendasController/vendaProduto';
$route['relatorios/venda-cliente']['GET'] = 'VendasController/vendaCliente';
$route['relatorios/venda-vendedor']['GET'] = 'VendasController/vendaVendedor';
$route['vendas/indicadores-vendas']['GET'] =  'VendasController/visaoVendas';

$route['relatorios/compra-produto']['GET'] = 'ComprasController/compraProduto';
$route['relatorios/compra-fornecedor']['GET'] = 'ComprasController/compraFornecedor';
$route['compras/indicadores-compras']['GET'] =  'ComprasController/visaoCompras';

$route['relatorios/movimentacao-produto']['GET'] = 'EstoqueController/movimentacoesProduto';
$route['estoque/indicadores-estoque']['GET'] =  'EstoqueController/visaoEstoque';

$route['relatorios/movimentacao-conta']['GET'] = 'FinanceiroController/movimentacaoConta';
$route['financeiro/indicadores-financeiro']['GET'] =  'FinanceiroController/visaoFinanceiro';

$route['relatorios/resultado-conta-contabil']['GET'] = 'FinanceiroController/resultadoContaContabil';


//Rotas Estoque
$route['estoque/posicao-estoque/movimento-produto/(:any)']['GET'] = 'EstoqueController/movimentoProduto/$1';
$route['estoque/posicao-estoque/movimento-produto/(:any)'] = 'EstoqueController/movimentoProduto/$1';
$route['estoque/posicao-estoque/movimento-produto/(:any)/(:num)'] = 'EstoqueController/movimentoProduto/$1';

$route['estoque/posicao-estoque/inserir-movimento/(:any)']['POST'] = 'EstoqueController/inserirMovimentoProduto/$1';

$route['estoque/posicao-estoque']['GET'] = 'EstoqueController/redirecionaPosicaoEstoque';
$route['estoque/posicao-estoque/(:any)/(:any)']['GET'] = 'EstoqueController/listarProdutoEstoque/$1/$2';
$route['estoque/posicao-estoque/(:any)/(:any)/(:num)'] = 'EstoqueController/listarProdutoEstoque';
$route['estoque/posicao-estoque/(:any)/(:any)/(:num)'] = 'EstoqueController/listarProdutoEstoque';

$route['estoque/inventario/novo-inventario']['GET'] =  'EstoqueController/formInventario';
$route['estoque/inventario/novo-inventario']['POST'] =  'EstoqueController/inserirInventario';

$route['estoque/inventario/editar-inventario/(:any)']['GET'] = 'EstoqueController/editarInventario/$1';
$route['estoque/inventario/editar-inventario/(:any)']['POST'] = 'EstoqueController/salvarInventario/$1';
$route['estoque/inventario/adicionar-produto/(:any)']['POST'] = 'EstoqueController/inserirProdutoInventario/$1';
$route['estoque/inventario/editar-produto/(:any)/(:any)']['POST'] = 'EstoqueController/salvarProduto/$1/$2';
$route['estoque/inventario/excluir-produto/(:any)']['POST'] = 'EstoqueController/excluirProduto/$1';
$route['estoque/inventario/executar-inventario/(:any)']['POST'] = 'EstoqueController/executarInventario/$1';

$route['estoque/inventario/excluir-inventario']['POST'] = 'EstoqueController/excluirInventario';

$route['estoque/inventario']['GET'] = 'EstoqueController/listarInventario';
$route['estoque/inventario'] = 'EstoqueController/listarInventario';
$route['estoque/inventario/(:num)'] = 'EstoqueController/listarInventario';

$route['estoque/requisicao-material/nova-requisicao-material']['GET'] =  'EstoqueController/formRequisicaoMaterial';
$route['estoque/requisicao-material/nova-requisicao-material']['POST'] =  'EstoqueController/inserirRequisicaoMaterial';

$route['estoque/requisicao-material/editar-requisicao-material/(:any)']['GET'] = 'EstoqueController/editarRequisicaoMaterial/$1';
$route['estoque/requisicao-material/editar-requisicao-material/(:any)']['POST'] = 'EstoqueController/salvarRequisicaoMaterial/$1';
$route['estoque/requisicao-material/adicionar-produto/(:any)']['POST'] = 'EstoqueController/inserirProdutoRequisicao/$1';
$route['estoque/requisicao-material/editar-produto/(:any)/(:any)']['POST'] = 'EstoqueController/salvarProdutoRequisicao/$1/$2';
$route['estoque/requisicao-material/excluir-produto/(:any)']['POST'] = 'EstoqueController/excluirProdutoRequisicao/$1';
$route['estoque/requisicao-material/atender-requisicao/(:any)']['POST'] = 'EstoqueController/atenderRequisicaoMaterial/$1';
$route['estoque/requisicao-material/estorno-requisicao/(:any)']['POST'] = 'EstoqueController/estornoRequisicaoMaterial/$1';

$route['estoque/requisicao-material']['GET'] = 'EstoqueController/listarRequisicaoMaterial';
$route['estoque/requisicao-material'] = 'EstoqueController/listarRequisicaoMaterial';
$route['estoque/requisicao-material/(:num)'] = 'EstoqueController/listarRequisicaoMaterial';

$route['estoque/necessidade-material']['GET'] = 'EstoqueController/listarCalculoNecessidade';
$route['estoque/necessidade-material'] = 'EstoqueController/listarCalculoNecessidade';
$route['estoque/necessidade-material/(:num)'] = 'EstoqueController/listarCalculoNecessidade';

$route['estoque/necessidade-material/novo-calculo-necessidade']['GET'] =  'EstoqueController/formNovoCalculo';
$route['estoque/necessidade-material/novo-calculo-necessidade']['POST'] = 'EstoqueController/inserirCalculo';

$route['estoque/necessidade-material/editar-calculo-necessidade/(:any)']['GET'] =  'EstoqueController/editarCalculoNecessidade/$1';
$route['estoque/necessidade-material/editar-calculo-necessidade/(:any)']['POST'] = 'EstoqueController/salvarCalculoNecessidade/$1';

$route['estoque/necessidade-material/atualiza-lista-pedidos/(:any)']['POST'] = 'EstoqueController/atualizaListaProduto/$1';

$route['estoque/necessidade-material/excluir-pedido-venda/(:any)'] = 'EstoqueController/excluirPedidoCalculo/$1';

$route['estoque/necessidade-material/calcula-necessidade/(:any)'] = 'EstoqueController/calculaNecessidade/$1';
$route['estoque/necessidade-material/descalcula-necessidade/(:any)'] = 'EstoqueController/descalculaNecessidade/$1';

$route['estoque/necessidade-material/inserir-produto-producao/(:any)'] = 'EstoqueController/inserirProdutoProducao/$1';
$route['estoque/necessidade-material/excluir-produto-producao/(:any)'] = 'EstoqueController/excluirProdutoProducao/$1';
$route['estoque/necessidade-material/salvar-produto-producao/(:any)/(:any)'] = 'EstoqueController/salvarProdutoProducao/$1/$2';

$route['estoque/necessidade-material/inserir-produto-compra/(:any)'] = 'EstoqueController/inserirProdutoCompra/$1';
$route['estoque/necessidade-material/excluir-produto-compra/(:any)'] = 'EstoqueController/excluirProdutoCompra/$1';
$route['estoque/necessidade-material/salvar-produto-compra/(:any)/(:any)'] = 'EstoqueController/salvarProdutoCompra/$1/$2';
$route['estoque/necessidade-material/confirma-ordem/(:any)']['POST'] = 'EstoqueController/confirmaOrdem/$1';
$route['estoque/necessidade-material/desconfirma-ordem/(:any)']['POST'] = 'EstoqueController/desconfirmaOrdem/$1';

$route['estoque/imprimir-necessidade-material/(:num)'] = 'EstoqueController/imprimirNecessidadeMaterial/$1';

$route['estoque/necessidade-material/calcula-necessidade-pedido/(:any)']['POST'] = 'EstoqueController/inserirCalculoPedidoVenda/$1';

//Integração Vendas Externas
$route['vendas/importar-atendimentos-vendas-externas']['GET'] = 'VendasController/importaAtendimentosVendasExternas';

//Rotas Ajax
$route['ajax/busca-cidade']['POST'] = 'AjaxController/getCidades';
$route['ajax/movimento-reporte']['POST'] = 'AjaxController/getMovimentosReporteProducao';
$route['ajax/busca-produto']['POST'] = 'AjaxController/getProduto';
$route['ajax/busca-cliente']['POST'] = 'AjaxController/getCliente';
$route['ajax/busca-vendedor']['POST'] = 'AjaxController/getVendedor';
$route['ajax/busca-ordem-compra']['POST'] = 'AjaxController/getOrdem';
$route['ajax/busca-componente']['POST'] = 'AjaxController/getEstruturaComponentePorCodigo';
$route['ajax/busca-componente-prod']['POST'] = 'AjaxController/getComponentesOrdem';
$route['ajax/busca-produto-venda']['POST'] = 'AjaxController/getProdutosVenda';
$route['ajax/busca-ncm']['POST'] = 'AjaxController/getNCM';
$route['ajax/inserir-cliente']['POST'] = 'AjaxController/inserirCliente';

$route['ajax/busca-ncm-filtro']['GET'] = 'AjaxController/getNCMFiltro';

$route['ajax/busca-produto-filtro']['GET'] = 'AjaxController/getProdutosFiltro';

$route['ajax/busca-tipo-produto-filtro']['GET'] = 'AjaxController/getTipoProdutosFiltro';

$route['ajax/busca-natureza-operacao-filtro']['GET'] = 'AjaxController/getNaturezaOperacao';

$route['ajax/busca-estado']['GET'] = 'AjaxController/getEstado';

$route['ajax/excluir-vinculo-produto-natureza-operacao']['GET'] = 'AjaxController/excluirVinculoProdutoNaturezaOperacao';


$route['ajax/excluir-regra-natureza-operacao']['GET'] = 'AjaxController/excluirRegraProdutoNaturezaOperacao';


$route['ajax/excluir-nota-fiscal-pessoa-autorizada']['GET'] = 'AjaxController/excluirNotaFiscalPessoasAutorizadas';


$route['ajax/excluir-nota-fiscal-parcela']['GET'] = 'AjaxController/excluirNotaFiscalPagamentoParcela';

$route['ajax/nota-fiscal-xml']['GET'] = 'AjaxController/getNotaFiscalXML';


