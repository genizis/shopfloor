<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active">Indicadores de Compra</a></li>
        </ol>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="<?= base_url('compras/indicadores-compras') ?>" method="get" class="mb-0 needs-validation" novalidate>
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
                    <div class="card-body card-table compra-dia">
                        <h5 class="card-title"><strong>COMPRAS POR DIA</strong></h5>
                        <canvas id="graph-compra-dia" height="55"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card  mb-3">
                            <div class="card-body">
                                <h5 class="card-title"><strong>TOTAL EM COMPRAS</strong></h5>
                                <div class="card-table text-center">
                                    <h1 class="<?php if($total_comprado > 0) echo "text-warning"; ?> display-5 font-weight-bold mb-0">R$
                                        <?= number_format($total_comprado, 2, ',', '.') ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card  mb-1">
                            <div class="card-body">
                                <h5 class="card-title"><strong>TOTAL EM COMPRAS PENDENTES</strong></h5>
                                <div class="card-table text-center">
                                    <h1 class="<?php if($compra_pendente->valor_pendente > 0) echo "text-warning"; ?> display-5 font-weight-bold mb-0">R$
                                        <?= number_format($compra_pendente->valor_pendente, 2, ',', '.') ?></h1>
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
                <div class="card custo-produto ">
                    <div class="card-body">
                        <h5 class="card-title"><strong>COMPRAS POR PRODUTO</strong></h5>
                    </div>
                    <canvas id="pie-chart" class="mb-1"></canvas>
                    <div class="card-body card-table overflow-auto mb-3">
                        <table class="table table-borderless table-sm">
                            <tbody>
                                <?php foreach($compra_produto as $key_compra_produto => $compra_produto) { ?>
                                <tr>
                                    <td class="limit-text-graph"><i class="fas fa-angle-right"
                                            style="color: <?= $cor_compra[$key_compra_produto] ?>"></i>
                                        <?= $compra_produto->cod_produto ?> - <?= $compra_produto->nome_produto ?></td>
                                    <td class="text-danger float-right">R$
                                        <?= number_format($compra_produto->valor_comprado, 2, ',', '.') ?></td>
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
                                    <?= number_format($total_comprado, 2, ',', '.') ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card custo-produto ">
                    <div class="card-body">
                        <h5 class="card-title"><strong>QUANTIDADE COMPRADA POR PRODUTO</strong></h5>
                        <canvas id="bar-chart-horizontal-cons" height="340"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card custo-produto ">
                    <div class="card-body">
                        <h5 class="card-title"><strong>COMPRAS POR FORNECEDOR</strong></h5>
                    </div>
                    <canvas id="bar-chart-horizontal" class="mb-1"></canvas>
                    <div class="card-body card-table overflow-auto mb-3">
                        <table class="table table-borderless table-sm">
                            <tbody>
                                <?php foreach($compra_fornecedor as $key_compra_fornecedor => $compra_fornecedor) { ?>
                                <tr>
                                    <td class="limit-text-graph"><i class="fas fa-angle-right"
                                            style="color: <?= $cor_fornecedor[$key_compra_fornecedor] ?>"></i>
                                        <?= $compra_fornecedor->cod_fornecedor ?> -
                                        <?= $compra_fornecedor->nome_fornecedor ?></td>
                                    <td class="text-danger float-right">R$
                                        <?= number_format($compra_fornecedor->total_compra, 2, ',', '.') ?></td>
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
                                    <?= number_format($total_comprado, 2, ',', '.') ?></strong>
                            </div>
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
new Chart(document.getElementById("graph-compra-dia"), {
    type: 'line',
    data: {
        labels: <?php echo json_encode($dia); ?>,
        datasets : [{
            data: <?php echo json_encode($compra_dia); ?>,
            label : "Compra",
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
                    return "R$ " + tooltipItem.yLabel.toLocaleString("pt-BR", {
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

var formatedString = '<%= "R$ " + value.toString().split(".").join(",") %>';

new Chart(document.getElementById("pie-chart"), {
    type: 'doughnut',
    data: {
        labels: <?php echo json_encode($nome_produto); ?>,
        datasets : [{
            label: "Valor",
            backgroundColor: <?php echo json_encode($cor_compra); ?>,
            data : <?php echo json_encode($dados_compra); ?>,
            pieceLabel : <?php echo json_encode($dados_compra); ?>,
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
    type: 'horizontalBar',
    data: {
        labels: <?php echo json_encode($cod_produto); ?>,
        datasets : [{
            label: "Quant Comprado",
            backgroundColor: "#8E8C84",
            data: <?php echo json_encode($quant_comprada); ?>
        }],
    },
    options: {
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var indice = tooltipItem.index;
                    var unid_medida = <?php echo json_encode($cod_unid_medida); ?>;
                    return tooltipItem.xLabel.toLocaleString("pt-BR", {
                        style: "decimal",
                        minimumFractionDigits: 3,
                        maximumFractionDigits: 3,
                    }) + " " + unid_medida[indice];
                },
                title: function(tooltipItem, data) {
                    var indice = tooltipItem[0].index;
                    var desc_produto = <?php echo json_encode($desc_produto); ?>;
                    return tooltipItem[0].yLabel + " - " + desc_produto[indice];
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
                ticks: {
                    maxTicksLimit: 8,
                    callback: function(value, index, values) {
                        return value.toLocaleString("pt-BR", {
                            style: "decimal",
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        });
                    }
                },


            }],
            yAxes: [{
                gridLines: {
                    display: false,
                },


            }]
        },

    }
});

new Chart(document.getElementById("bar-chart-horizontal"), {
    type: 'pie',
    data: {
        datasets: [{
            data: <?php echo json_encode($dados_fornecedor); ?>,
            backgroundColor : <?php echo json_encode($cor_fornecedor); ?>,
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

$('#inputDataInicio').datepicker({
    uiLibrary: 'bootstrap4'
});
$('#inputDataFim').datepicker({
    uiLibrary: 'bootstrap4'
});
</script>

<?php $this->load->view('gerais/footer'); ?>