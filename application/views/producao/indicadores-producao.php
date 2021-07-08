<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active">Indicadores de Produção</a></li>
        </ol>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="<?= base_url('producao/indicadores-producao') ?>" method="get" class="mb-0 needs-validation" novalidate>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <input class="form-control" id="inputDataInicio" type="text"
                                        name="DataInicio"
                                        value="<?= str_replace('-', '/', date("d-m-Y", strtotime($dataInicio))) ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <input class="form-control" id="inputDataFim" type="text"
                                        name="DataFim"
                                        value="<?= str_replace('-', '/', date("d-m-Y", strtotime($dataFim))) ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <select id="inputProduto" name="produto[]" data-style="btn-input-primary" multiple
                                data-actions-box="true" class="selectpicker show-tick form-control"
                                data-live-search="true" data-actions-box="true">
                                <?php $chave_produto = 0; foreach($lista_produto_prod as $key_produto_prod => $produto_prod) { ?>
                                <option value="<?= $produto_prod->cod_produto ?>" <?php if($cod_produto != null){if($produto_prod->cod_produto == $cod_produto[$chave_produto]){ 
                                  if((count($cod_produto) - 1) > $chave_produto) {$chave_produto = $chave_produto + 1; } 
                                  echo "selected"; }}?>>
                                    <?= $produto_prod->cod_produto ?> -
                                    <?= $produto_prod->nome_produto ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <button type="submit" class="btn btn-outline-primary btn-block">Atualizar Indicadores</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body card-table producao-dia">
                        <h5 class="card-title"><strong>PRODUÇÃO POR DIA</strong></h5>
                        <canvas id="graph-producao-dia" height="55"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title"><strong>TOTAL PRODUZIDO</strong></h5>
                                <div class="card-table text-center">
                                    <h1 class="<?php if($total_produzido > 0) echo "text-teal"; ?> display-5 font-weight-bold mb-0">
                                        <?= number_format($total_produzido, 3, ',', '.') ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-1">
                            <div class="card-body">
                                <h5 class="card-title"><strong>TOTAL PERDIDO</strong></h5>
                                <div class="card-table text-center">
                                    <h1 class="<?php if($total_perdido > 0) echo "text-danger"; ?> display-5 font-weight-bold mb-0">
                                        <?= number_format($total_perdido, 3, ',', '.') ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-4">
                <div class="card custo-produto">
                    <div class="card-body">
                        <h5 class="card-title"><strong>CUSTO POR PRODUTO CONSUMIDO</strong></h5>
                    </div>
                    <canvas id="graph-custo" class="mb-1"></canvas>
                    <div class="card-body card-table overflow-auto mb-3">
                        <table class="table table-borderless table-sm">
                            <tbody>
                                <?php foreach($consumo_produto as $key_consumo_produto => $consumo_produto) { ?>
                                <tr>
                                    <td class="limit-text-graph"><i class="fas fa-angle-right"
                                            style="color: <?= $cor_consumo[$key_consumo_produto] ?>"></i>
                                        <?= $consumo_produto->cod_produto ?> - <?= $consumo_produto->nome_produto ?>
                                    </td>
                                    <td class="text-danger float-right">R$
                                        <?= number_format($consumo_produto->custo_consumo, 2, ',', '.') ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Total</strong>
                            </div>
                            <div class="col-md-6 text-danger">
                                <strong class="float-right">R$
                                    <?= number_format($total_custo->custo_total, 2, ',', '.') ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="card consumo-produto">
                            <div class="card-body card-table">
                                <h5 class="card-title"><strong>PRODUÇÃO E CUSTO POR PRODUTO</strong></h5>
                                <canvas id="graph-producao-custo" height="65"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card consumo-produto">
                            <div class="card-body card-table">
                                <h5 class="card-title"><strong>CONSUMO POR PRODUTO</strong></h5>
                                <canvas id="graph-consumo" height="65"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>

    </div>
</section>

<script>
new Chart(document.getElementById("graph-producao-dia"), {
    type: 'line',
    data: {
        labels: <?php echo json_encode($dia); ?> ,
        datasets : [{
            data: <?php echo json_encode($producao_dia); ?> ,
            label : "Produzido",
            borderColor: "#20c997",
            backgroundColor: "rgb(32, 201, 151, 0.4)",
            fill: true,
            lineTension: 0.2,
            borderWidth: 3,
            pointHitRadius: 1,
        }, {
            data: <?php echo json_encode($perda_dia); ?> ,
            label : "Perdido",
            borderColor: "#d9534f",
            backgroundColor: "rgb(217, 83, 79, 0.4)",
            fill: true,
            lineTension: 0.2,
            borderWidth: 3,
            pointHitRadius: 1,
        }, ]
    },
    options: {
        legend: {
            display: false
        },
        title: {
            display: false,
        },
        scales: {
            xAxes: [{
                gridLines: {
                    display: false,

                },

            }],
            yAxes: [{
                ticks: {
                    maxTicksLimit: 4,
                },
                callback: function(value, index, values) {
                    return 'R$ ' + value.toLocaleString("pt-BR", {
                        style: "decimal",
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                },

            }]
        },
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var indice = tooltipItem.index;
                    return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel
                        .toLocaleString("pt-BR", {
                            style: "decimal",
                            minimumFractionDigits: 3,
                            maximumFractionDigits: 3
                        });
                },
                title: function(tooltipItem, data) {
                    var indice = tooltipItem[0].index;
                    var dia = <?php echo json_encode($dia_nome); ?> ;
                    var mes = <?php echo json_encode($nome_mes); ?> ;
                    var ano = <?php echo json_encode($ano); ?> ;
                    return dia[indice] + " de " + mes[indice] + " de " + ano[indice];
                }
            }
        }


    }
});

var formatedString = '<%= "R$ " + value.toString().split(".").join(",") %>';

new Chart(document.getElementById("graph-custo"), {
    type: 'doughnut',
    data: {
        labels: <?php echo json_encode($nome_produto); ?> ,
        datasets : [{
            label: "Valor",
            backgroundColor: <?php echo json_encode($cor_consumo); ?> ,
            data : <?php echo json_encode($custo_produto); ?> ,
            pieceLabel : <?php echo json_encode($custo_produto); ?> ,
        }]
    },
    options: {
        legend: {
            display: false
        },
        title: {
            display: false
        },
        tooltips: {
            enabled: true,
            mode: 'label',
            callbacks: {
                label: function(tooltipItem, data) {
                    var indice = tooltipItem.index;
                    return data.datasets[0].data[indice].toFixed(1).toString().split(".").join(",") + "%";
                }
            }
        }
    }
});



new Chart(document.getElementById("graph-producao-custo"), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($produto_producao); ?> ,
        datasets : [{
            label: "Quant Produzido",
            backgroundColor: "#adb5bd",
            order: 2,
            data: <?php echo json_encode($quant_producao); ?>
        }, {
            label: 'Custo Total',
            borderColor: "#d9534f",
            backgroundColor: "#d9534f",
            data: <?php echo json_encode($custo_producao); ?> ,
            type : 'line',
            order: 1,
            fill: false,
        }],
    },
    options: {
        tooltips: {
            callbacks: {
                label: function(t, d) {
                    var xLabel = d.datasets[t.datasetIndex].label;
                    var yLabel = t.yLabel;
                    var indice = t.index;
                    var unid_medida = <?php echo json_encode($cod_unidade_med); ?> ;
                    // if line chart
                    if (t.datasetIndex === 0) return xLabel + ': ' + yLabel.toLocaleString("pt-BR", {
                        style: "decimal",
                        minimumFractionDigits: 3,
                        maximumFractionDigits: 3
                    }) + " " + unid_medida[indice];
                    // if bar chart
                    else if (t.datasetIndex === 1) return xLabel + ': R$ ' + yLabel.toLocaleString(
                    "pt-BR", {
                        style: "decimal",
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                },
                title: function(tooltipItem, data) {
                    var indice = tooltipItem[0].index;
                    var desc_produto = <?php echo json_encode($nome_produto_prod); ?> ;
                    return tooltipItem[0].xLabel + " - " + desc_produto[indice];
                }
            }
        },
        legend: {
            display: false
        },
        title: {
            display: false,
        },
        scales: {
            xAxes: [{
                gridLines: {
                    display: false,
                },

            }],
            yAxes: [{
                ticks: {
                    maxTicksLimit: 4,
                    callback: function(value, index, values) {
                        return value.toLocaleString("pt-BR", {
                            style: "decimal",
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        });
                    },
                },


            }]
        },

    }
});

new Chart(document.getElementById("graph-consumo"), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($cod_quant_produto); ?> ,
        datasets : [{
            label: "Quant Consumido",
            backgroundColor: "#8e5ea2" ,
            data : <?php echo json_encode($quant_produto); ?>
        }],
    },
    options: {
        tooltips: {
            callbacks: {
                label: function(t, d) {
                    var xLabel = d.datasets[t.datasetIndex].label;
                    var yLabel = t.yLabel;
                    var indice = t.index;
                    var unid_medida = <?php echo json_encode($unid_med_consumo); ?> ;
                    // if line chart
                    return yLabel.toLocaleString("pt-BR", {
                        style: "decimal",
                        minimumFractionDigits: 3,
                        maximumFractionDigits: 3
                    }) + " " + unid_medida[indice];
                },
                title: function(tooltipItem, data) {
                    var indice = tooltipItem[0].index;
                    var desc_produto = <?php echo json_encode($nome_quant_produto); ?> ;
                    return tooltipItem[0].xLabel + " - " + desc_produto[indice];
                }
            }
        },
        legend: {
            display: false
        },
        title: {
            display: false,
        },
        scales: {
            xAxes: [{
                gridLines: {
                    display: false,
                },

            }],
            yAxes: [{
                ticks: {
                    maxTicksLimit: 4,
                    callback: function(value, index, values) {
                        return value.toLocaleString("pt-BR", {
                            style: "decimal",
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        });
                    },
                }

            }]
        },

    }
});

$('#inputDataInicio').datepicker({
    uiLibrary: 'bootstrap4'
});
$('#inputDataFim').datepicker({
    uiLibrary: 'bootstrap4'
});
</script>

<?php $this->load->view('gerais/footer'); ?>