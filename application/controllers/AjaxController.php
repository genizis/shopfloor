<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AjaxController extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        if (usuarioLogado() == false) {

            redirect(base_url("login"), "home", "refresh");
        }
    }

    //Para uso do Ajax no Form


    public function getEstado()
    {
        echo json_encode($this->tabelasauxiliares->getEstado());
    }

    public function getCidades()
    {

        $idEstado = $this->input->post('estado');
        echo $this->tabelasauxiliares->selectCidade($idEstado);
    }

    public function getMovimentosReporteProducao()
    {

        $codReporteProducao = $this->input->post('cod_reporte_producao');
        echo $this->producao->selectMovimentosReporteProducao($codReporteProducao);
    }

    public function getProduto()
    {

        $codProduto = $this->input->post('produto');
        echo $this->produto->selectProduto($codProduto);
    }

    public function getCliente()
    {

        $codCliente = $this->input->post('cliente');
        echo $this->cliente->selectCliente($codCliente);
    }

    public function getVendedor()
    {

        $codVendedor = $this->input->post('vendedor');
        echo $this->vendedor->selectVendedor($codVendedor);
    }

    public function getOrdem()
    {

        $numOrdem = $this->input->post('ordem');
        echo $this->compra->selectOrdem($numOrdem);
    }

    public function getEstruturaComponentePorCodigo()
    {

        $seqComponente = $this->input->post('seq_componente');
        echo $this->engenharia->selectEstruturaComponente($seqComponente);
    }

    public function getComponentesOrdem()
    {

        $seqComponente = $this->input->post('seq_componente_producao');
        echo $this->produto->selectComponenteProd($seqComponente);
    }

    public function getProdutosVenda()
    {

        $seqProdutoVenda = $this->input->post('seq_produto_venda');
        echo $this->produto->selectProdutoVenda($seqProdutoVenda);
    }

    public function getNCM()
    {

        $listaNCM = $this->produto->getNCM();

        echo json_encode($listaNCM);
    }

    public function getNCMFiltro()
    {

        $filtro = $this->input->get('filtro');

        $listaNCM = $this->produto->getNCMFiltro($filtro);

        echo json_encode($listaNCM);
    }

    public function getProdutosFiltro()
    {

        $filtro = $this->input->get('filtro');

        echo json_encode($this->produto->buscaProdutoFiltro($filtro));
    }

    public function getTipoProdutosFiltro()
    {
        $this->load->model('tipoProduto');
        $filtro = $this->input->get('filtro');

        echo json_encode($this->tipoProduto->getTipoProduto($filtro));
    }


    public function inserirCliente()
    {

        $data = [
            'id_empresa' => getDadosUsuarioLogado()['id_empresa'],
            'nome_cliente'  => $this->input->post('nomeCliente'),
            'razao_social'  => $this->input->post('razaoSocial'),
            'tipo_pessoa' => $this->input->post('tipoPessoa'),
            'cnpj_cpf' => $this->input->post('cpfCnpj'),
            'cod_segmento' => $this->input->post('segmento'),
            'tipo_contrib_icms' => $this->input->post('contribuinteICMS'),
            'insc_estadual' => $this->input->post('inscEstadual'),
            'insc_municipal' => $this->input->post('inscMunicipal'),
            'tel_fixo' => $this->input->post('telFixo'),
            'tel_cel' => $this->input->post('telCel'),
            'email' => $this->input->post('eMail'),
            'cep' => $this->input->post('cep'),
            'endereco' => $this->input->post('endereco'),
            'numero' => $this->input->post('numero'),
            'complemento' => $this->input->post('complemento'),
            'bairro' => $this->input->post('bairro'),
            'cod_cidade' => $this->input->post('cidade')
        ];
        $codCliente = $this->cliente->insertCliente($data);

        echo $this->cliente->selectClienteOption($codCliente);
    }
    public function getNaturezaOperacao()
    {
        $this->load->model('NaturezaOperacao');

        $filtro = $this->input->get('filtro');
        $lista = $this->NaturezaOperacao->getObjetoTextSelect($filtro);
        echo json_encode($lista);
    }

    public function excluirVinculoProdutoNaturezaOperacao()
    {
        $this->load->model('NaturezaOperacao');
        $id = $this->input->get('id');
        $regra = $this->input->get('regra');
        $resultado = $this->NaturezaOperacao->deleteProdutos($id, $regra);

        echo json_encode([
            'resultado' => $resultado,
            'msg' => $resultado ? 'Excluido com sucesso' : 'Erro ao excluir'
        ]);
    }
    public function excluirRegraProdutoNaturezaOperacao()
    {
        $this->load->model('NaturezaOperacao');
        $id = $this->input->get('id');
        $regra = $this->input->get('regra');
        $resultado = $this->NaturezaOperacao->deleteRegras($id, $regra);

        echo json_encode([
            'resultado' => $resultado,
            'msg' => $resultado ? 'Excluido com sucesso' : 'Erro ao excluir'
        ]);
    }

    public function excluirNotaFiscalPessoasAutorizadas()
    {
        $this->load->model('NotaFiscalPessoasAutorizadas');
        $id = $this->input->get('id');
        $resultado = $this->NotaFiscalPessoasAutorizadas->delete($id);

        echo json_encode([
            'resultado' => $resultado,
            'msg' => $resultado ? 'Excluido com sucesso' : 'Erro ao excluir'
        ]);
    }

    public function excluirNotaFiscalPagamentoParcela()
    {
        $this->load->model('NotaFiscalParcelasPagamento');
        $id = $this->input->get('id');
        $resultado = $this->NotaFiscalParcelasPagamento->delete($id);

        echo json_encode([
            'resultado' => $resultado,
            'msg' => $resultado ? 'Excluido com sucesso' : 'Erro ao excluir'
        ]);
    }
}
