$(document).ready(function () {

    $('.page-item>a').addClass("page-link");

    $('#Inputfornecedor').selectpicker({
      style: 'btn-input-primary'
    });

    $('#inputProdutoProd').selectpicker({
      style: 'btn-input-primary'
    });

    $('#inputPedidoVenda').selectpicker({
      style: 'btn-input-primary'
    });

    $('#inputComponente').selectpicker({
      style: 'btn-input-primary'
    });

    $('#inputProdutoOrdem').selectpicker({
      style: 'btn-input-primary'
    });

    $('#inputSeqEstrutura').selectpicker({
      style: 'btn-input-primary'
    });

    $('#inputCliente').selectpicker({
      style: 'btn-input-primary'
    });

    $('#inputFornecedor').selectpicker({
      style: 'btn-input-primary'
    });

    $('#inputModalidadeMovimento').selectpicker({
      style: 'btn-input-primary'
    });

    $('#inputTipoAcesso').selectpicker({
      style: 'btn-input-primary'
    });

    $('#inputEstado').selectpicker({
      style: 'btn-input-primary'
    });

    $('#inputCidade').selectpicker({
      style: 'btn-input-primary'
    });

    $('#inputSistema').selectpicker({
      style: 'btn-input-primary'
    });

    $('#inputSegmento').selectpicker({
      style: 'btn-input-primary'
    });

    /* Máscaras */
    $('#inputQuantProducao').mask("#.##0,000", {reverse: true});   

    $('#inputQuantConsumo').mask("#.##0,000", {reverse: true});   

    $('#inputQtdePlanejada').mask("#.##0,000", {reverse: true}); 

    $('#inputQtdeReportar').mask("#.##0,000", {reverse: true}); 

    $('#inputQtdePedida').mask("#.##0,000", {reverse: true}); 

    $('#inputNumOrdemCompra').mask("#.##0", {reverse: true});

    $('#inputQuantRecebida').mask("#.##0,000", {reverse: true});

    $('#inputQtdeMovimento').mask("#.##0,000", {reverse: true});

    $('#inputCNPJ').mask('00.000.000/0000-00', {reverse: true});

    $('#inputCPFCNPJ').mask('00.000.000/0000-00', {reverse: true});
    
    

    $('#inputQuantSaida').mask("#.##0,000", {reverse: true});

    $('#dateFim').datepicker({
            uiLibrary: 'bootstrap4'
        });

    $('#dateEmissao').datepicker({
            uiLibrary: 'bootstrap4'
        });

    $('#dateEntrega').datepicker({
            uiLibrary: 'bootstrap4'
        });

    $('#dateEntregaCompra').datepicker({
            uiLibrary: 'bootstrap4'
        });

    $('#dateReporte').datepicker({
            uiLibrary: 'bootstrap4'
        });

    $('#inputDataRecebimento').datepicker({
            uiLibrary: 'bootstrap4'
        });

    $('#inputDataMovimento').datepicker({
            uiLibrary: 'bootstrap4'
        }); 

    $('#inputDataSaida').datepicker({
            uiLibrary: 'bootstrap4'
        }); 

        

        

});





