<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active">Indicadores de Vendas</a></li>
        </ol>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="<?= base_url('vendas/indicadores-vendas') ?>" method="get" class="mb-0 needs-validation" novalidate>
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
                <div class="card ">
                    <div class="card-body">
                        <h5 class="card-title"><strong>VENDAS POR DIA</strong></h5>
                        <canvas id="line-chart" height="55"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card  mb-3">
                            <div class="card-body">
                                <h5 class="card-title"><strong>TOTAL EM VENDAS</strong></h5>
                                <div class="card-table text-center">
                                    <h1 class="<?php if($total_venda > 0) echo "text-teal"; ?> display-5 font-weight-bold mb-0">R$
                                        <?= number_format($total_venda, 2, ',', '.') ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card  mb-1">
                            <div class="card-body">
                                <h5 class="card-title"><strong>TOTAL EM DESCONTO</strong></h5>
                                <div class="card-table text-center">
                                    <h1 class="<?php if($total_desconto > 0) echo "text-warning"; ?> display-5 font-weight-bold mb-0">R$
                                        <?= number_format($total_desconto, 2, ',', '.') ?></h1>
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
                <div class="card height-1">
                    <div class="card-body">
                        <h5 class="card-title"><strong>VENDAS POR PRODUTO</strong></h5>
                    </div>
                    <canvas id="graph-venda-produto" class="mb-1"></canvas>
                    <div class="card-body card-table overflow-auto mb-3">
                        <table class="table table-borderless table-sm">
                            <tbody>
                                <?php foreach($venda_produto as $key_venda_produto => $venda_produto) { ?>
                                <tr>
                                    <td><i class="fas fa-angle-right"
                                            style="color: <?= $cor_venda[$key_venda_produto] ?>"></i>
                                        <?= $venda_produto->cod_produto ?> - <?= $venda_produto->nome_produto ?></td>
                                    <td class="text-teal float-right">R$
                                        <?= number_format($venda_produto->valor_vendido, 2, ',', '.') ?></td>
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
                            <div class="col-md-6 text-teal">
                                <strong class="float-right">R$ <?= number_format($total_venda, 2, ',', '.') ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card   mb-3">
                            <div class="card-body">
                                <h5 class="card-title"><strong>QUANTIDADE VENDA POR PRODUTO</strong></h5>
                                <canvas id="bar-chart-horizontal-cons" height="65"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><strong>VALOR DESCONTO POR CLIENTE</strong></h5>
                                <canvas id="bar-chart-horizontal-vend" height="65"></canvas>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-4">
                <div class="card height-1">
                    <div class="card-body">
                        <h5 class="card-title"><strong>VENDAS POR CLIENTE</strong></h5>
                    </div>
                    <canvas id="graph-venda-cliente" class="mb-1"></canvas>
                    <div class="card-body card-table overflow-auto mb-3">
                        <table class="table table-borderless table-sm">
                            <tbody>
                                <?php foreach($venda_cliente as $key_venda_cliente => $venda_cliente) { ?>
                                <tr>
                                    <td class="limit-text-graph"><i class="fas fa-angle-right"
                                            style="color: <?= $cor_cliente[$key_venda_cliente] ?>"></i>
                                        <?= $venda_cliente->cod_cliente ?> - <?php if($venda_cliente->cod_cliente == 0) echo "Consumidor Final"; else echo $venda_cliente->nome_cliente ?></td>
                                    <td class="text-teal float-right">R$
                                        <?= number_format($venda_cliente->total_venda, 2, ',', '.') ?></td>
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
                            <div class="col-md-6 text-teal">
                                <strong class="float-right">R$ <?= number_format($total_venda, 2, ',', '.') ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card ">
                    <div class="card-body">
                        <h5 class="card-title"><strong>VENDAS POR VENDEDOR</strong></h5>
                        <canvas id="graph-venda-vendedor" height="157"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>

    </div>
</section>

<script>
new Chart(document.getElementById("line-chart"), {
    type: 'line',
    data: {
        labels: <?php echo json_encode($dia); ?>,
        datasets: [{
                data: <?php echo json_encode($venda_dia); ?>,
                label: "Venda",
                borderColor: "#20c997",
                backgroundColor: "rgb(32, 201, 151, 0.4)",
                fill: true,
                lineTension: 0.2,
                borderWidth: 3,
                pointHitRadius: 1,
            },
            {
                data: <?php echo json_encode($desconto_dia); ?>,
                label: "Desconto",
                borderColor: "#F47C3C",
                backgroundColor: "rgb(244, 124, 60, 0.4)",
                fill: true,
                lineTension: 0.2,
                borderWidth: 3,
                pointHitRadius: 1,
            },
        ]
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
                    callback: function(value, index, values) {
                        return 'R$ ' + value.toLocaleString("pt-BR", {
                            style: "decimal",
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                    },

                }

            }]
        },
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var indice = tooltipItem.index;
                    return data.datasets[tooltipItem.datasetIndex].label + ": " + "R$ " + tooltipItem.yLabel
                        .toLocaleString("pt-BR", {
                            style: "decimal",
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                },
                title: function(tooltipItem, data) {
                    var indice = tooltipItem[0].index;
                    var dia = <?php echo json_encode($dia_nome); ?>;
                    var mes = <?php echo json_encode($nome_mes); ?>;
                    var ano = <?php echo json_encode($ano); ?>;
                    return dia[indice] + " de " + mes[indice] + " de " + ano[indice];
                }
            }
        }

    }
});

new Chart(document.getElementById("graph-venda-produto"), {
    type: 'doughnut',
    data: {
        labels: <?php echo json_encode($nome_produto); ?>,
        datasets: [{
            label: "Valor",
            backgroundColor: <?php echo json_encode($cor_venda); ?>,
            data: <?php echo json_encode($dados_venda); ?>,
            pieceLabel: <?php echo json_encode($dados_venda); ?>,
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

new Chart(document.getElementById("bar-chart-horizontal-cons"), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($cod_produto); ?>,
        datasets: [{
            label: "Quant Vendido",
            backgroundColor: "#29ABE0",
            data: <?php echo json_encode($quant_venda); ?>
        }],
    },
    options: {
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var indice = tooltipItem.index;
                    var unid_medida = <?php echo json_encode($cod_unid_medida); ?>;
                    return tooltipItem.yLabel.toLocaleString("pt-BR", {
                        style: "decimal",
                        minimumFractionDigits: 3,
                        maximumFractionDigits: 3,
                    }) + " " + unid_medida[indice];
                },
                title: function(tooltipItem, data) {
                    var indice = tooltipItem[0].index;
                    var desc_produto = <?php echo json_encode($desc_produto); ?>;
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
            yAxes: [{
                gridLines: {
                    display: false,
                },
                ticks: {
                    maxTicksLimit: 4,
                    callback: function(value, index, values) {
                        return value.toLocaleString("pt-BR", {
                            style: "decimal",
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        });
                    }
                },


            }],
        },

    }
});

new Chart(document.getElementById("graph-venda-cliente"), {
    type: 'pie',
    data: {
        datasets: [{
            data: <?php echo json_encode($dados_cliente); ?>,
            backgroundColor: <?php echo json_encode($cor_cliente); ?>,
        }],
        labels: [
            "Red",
            "Green",
            "Yellow",
            "Grey",
            "Blue"
        ]
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
        },

    }
});

new Chart(document.getElementById("bar-chart-horizontal-vend"), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($cod_cliente); ?>,
        datasets: [{
            label: "Total Desconto",
            backgroundColor: "#F47C3C",
            data: <?php echo json_encode($valor_desconto); ?>
        }],
    },
    options: {
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var indice = tooltipItem.index;
                    return "R$ " + tooltipItem.yLabel.toLocaleString("pt-BR", {
                        style: "decimal",
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                    });
                },
                title: function(tooltipItem, data) {
                    var indice = tooltipItem[0].index;
                    var desc_produto = <?php echo json_encode($nome_cliente); ?>;
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
            yAxes: [{
                gridLines: {
                    display: false,
                },
                ticks: {
                    maxTicksLimit: 4,
                    callback: function(value, index, values) {
                        return "R$ " + value.toLocaleString("pt-BR", {
                            style: "decimal",
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                    }
                },


            }],
        },

    }
});

new Chart(document.getElementById("graph-venda-vendedor"), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($cod_vendedor); ?> ,
        datasets : [{
                label: "Total de Venda",
                backgroundColor: "#20c997",
                data: <?php echo json_encode($total_venda_vendedor); ?> ,
            },
            {
                label: "Total Comissão",
                backgroundColor: "#29ABE0",
                data: <?php echo json_encode($total_comissao_vendedor); ?> ,
            }
        ]
    },
    options: {
        tooltips: {
            callbacks: {
                label: function(t, d) {
                    var xLabel = d.datasets[t.datasetIndex].label;
                    var yLabel = t.yLabel;
                    // if line chart
                    return xLabel + ': R$ ' + yLabel.toLocaleString("pt-BR", {
                        style: "decimal",
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                },
                title: function(tooltipItem, data) {
                    var indice = tooltipItem[0].index;
                    var nome_vendedor = <?php echo json_encode($nome_vendedor); ?> ;
                    return tooltipItem[0].xLabel + " - " + nome_vendedor[indice];
                }
            }
        },
        legend: {
            display: false
        },
        scales: {
            yAxes: [{
                gridLines: {
                    display: false,
                },
                ticks: {
                    maxTicksLimit: 6,
                    callback: function(value, index, values) {
                        return value.toLocaleString("pt-BR", {
                            style: "decimal",
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        });
                    }
                },
            }],
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