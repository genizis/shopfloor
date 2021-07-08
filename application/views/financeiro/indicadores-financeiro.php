<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active">Indicadores de Financeiro</a></li>
        </ol>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="<?= base_url('financeiro/indicadores-financeiro') ?>" method="get" class="mb-0 needs-validation" novalidate>
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
                        <h5 class="card-title"><strong>FLUXO DE CAIXA</strong></h5>
                        <canvas id="fluxo-caixa-graph" height="55"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card  mb-3">
                            <div class="card-body">
                                <h5 class="card-title"><strong>SALDO CONFIRMADO</strong></h5>
                                <div class="card-table text-center">
                                    <h1
                                        class="display-5 mb-0 <?php if($totais->saldo_total > 0) echo "text-teal";
                                                        if($totais->saldo_total < 0) echo "text-danger"; ?> font-weight-bold">
                                        R$
                                        <?= number_format($totais->saldo_total, 2, ',', '.') ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card  mb-1">
                            <div class="card-body">
                                <h5 class="card-title"><strong>SALDO PROJETADO</strong></h5>
                                <div class="card-table text-center">
                                    <h1
                                        class="display-5 mb-0 <?php if(($totais->saldo_total + $totais->entrada - $totais->saida) > 0) echo "text-teal";
                                                        if(($totais->saldo_total + $totais->entrada - $totais->saida) < 0) echo "text-danger"; ?> font-weight-bold">
                                        R$
                                        <?= number_format($totais->saldo_total + $totais->entrada - $totais->saida, 2, ',', '.') ?>
                                    </h1>
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
                <div class="card custo-produto  mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><strong>RECEITA POR CONTA CONTÁBIL</strong></h5>
                    </div>
                    <canvas id="graph-receita-conta-contabil" class="mb-1"></canvas>
                    <div class="card-body card-table overflow-auto mb-3">
                        <table class="table table-borderless table-sm">
                            <tbody>
                                <?php foreach($receita_conta_contabil as $key_receita_conta_contabil => $receita) { ?>
                                <tr>
                                    <td class="limit-text-graph"><i class="fas fa-angle-right"
                                            style="color: <?= $cor_receita_conta_contabil[$key_receita_conta_contabil] ?>"></i>
                                        <?php if($receita->cod_conta_contabil != null) echo $receita->cod_conta_contabil . " - " . $receita->nome_conta_contabil;
                                      else echo "<strong>SEM CONTA CONTÁBIL</strong>"; ?>
                                    </td>
                                    <td class="text-teal float-right">R$
                                        <?= number_format($receita->valor_total, 2, ',', '.') ?></td>
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
                                <strong class="float-right">R$
                                    <?= number_format($total_receita, 2, ',', '.') ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card produto-venda   mb-3">
                            <div class="card-body">
                                <h5 class="card-title"><strong>TOTAL MOVIMENTADO POR CONTA</strong></h5>
                                <canvas id="line-chart-conta" height="68"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card produto-venda   mb-3">
                            <div class="card-body">
                                <h5 class="card-title"><strong>SALDO DISPONÍVEL POR CONTA</strong></h5>
                                <canvas id="bar-chart-horizontal-cons" height="68"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card custo-produto  mt-2">
                    <div class="card-body">
                        <h5 class="card-title"><strong>DESPESAS POR CONTA CONTÁBIL</strong></h5>
                    </div>
                    <canvas id="graph-despesa-conta-contabil" class="mb-1"></canvas>
                    <div class="card-body card-table overflow-auto mb-3">
                        <table class="table table-borderless table-sm">
                            <tbody>
                                <?php foreach($despesa_conta_contabil as $key_despesa_conta_contabil => $despesa) { ?>
                                <tr>
                                    <td class="limit-text-graph"><i class="fas fa-angle-right"
                                            style="color: <?= $cor_despesa_conta_contabil[$key_despesa_conta_contabil] ?>"></i>
                                        <?php if($despesa->cod_conta_contabil != null) echo $despesa->cod_conta_contabil . " - " . $despesa->nome_conta_contabil;
                                      else echo "<strong>SEM CONTA CONTÁBIL</strong>"; ?>
                                    </td>
                                    <td class="text-danger float-right">R$
                                        <?= number_format($despesa->valor_total, 2, ',', '.') ?></td>
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
                                    <?= number_format($total_despesa, 2, ',', '.') ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card custo-produto mt-2">
                    <div class="card-body">
                        <h5 class="card-title"><strong>RECEITA POR CENTRO DE CUSTO</strong></h5>
                    </div>
                    <canvas id="graph-receita-centro-custo" class="mb-1"></canvas>
                    <div class="card-body card-table overflow-auto mb-3">
                        <table class="table table-borderless table-sm">
                            <tbody>
                                <?php foreach($receita_centro_custo as $key_receita_centro_custo => $receita) { ?>
                                <tr>
                                    <td class="limit-text-graph"><i class="fas fa-angle-right"
                                            style="color: <?= $cor_receita_centro_custo[$key_receita_centro_custo] ?>"></i>
                                        <?php if($receita->cod_centro_custo != null) echo $receita->cod_centro_custo . " - " . $receita->nome_centro_custo;
                                      else echo "<strong>SEM CENTRO DE CUSTO</strong>"; ?>
                                    </td>
                                    <td class="text-teal float-right">R$
                                        <?= number_format($receita->valor_total, 2, ',', '.') ?></td>
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
                                <strong class="float-right">R$
                                    <?= number_format($total_receita, 2, ',', '.') ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card custo-produto  mt-2">
                    <div class="card-body">
                        <h5 class="card-title"><strong>DESPESAS POR CENTRO DE CUSTO</strong></h5>
                    </div>
                    <canvas id="graph-despesa-centro-custo" class="mb-1"></canvas>
                    <div class="card-body card-table overflow-auto mb-3">
                        <table class="table table-borderless table-sm">
                            <tbody>
                                <?php foreach($despesa_centro_custo as $key_despesa_centro_custo => $despesa) { ?>
                                <tr>
                                    <td class="limit-text-graph"><i class="fas fa-angle-right"
                                            style="color: <?= $cor_despesa_centro_custo[$key_despesa_centro_custo] ?>"></i>
                                        <?php if($despesa->cod_centro_custo != null) echo $despesa->cod_centro_custo . " - " . $despesa->nome_centro_custo;
                                      else echo "<strong>SEM CENTRO DE CUSTO</strong>"; ?>
                                    </td>
                                    <td class="text-danger float-right">R$
                                        <?= number_format($despesa->valor_total, 2, ',', '.') ?></td>
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
                                    <?= number_format($total_despesa, 2, ',', '.') ?></strong>
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
new Chart(document.getElementById("fluxo-caixa-graph"), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($dia); ?>,
        datasets: [{
                label: "Entradas",
                backgroundColor: "#3cba9f",
                data: <?php echo json_encode($entradas); ?>,
            },
            {
                label: "Saídas",
                backgroundColor: "#d9534f",
                data: <?php echo json_encode($saidas); ?>,
            }
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

new Chart(document.getElementById("graph-despesa-conta-contabil"), {
    type: 'doughnut',
    data: {
        datasets: [{
            label: "%",
            backgroundColor: <?php echo json_encode($cor_despesa_conta_contabil); ?>,
            data: <?php echo json_encode($dados_despesa_conta_contabil); ?>,
            pieceLabel: <?php echo json_encode($dados_despesa_conta_contabil); ?>,
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

new Chart(document.getElementById("graph-despesa-centro-custo"), {
    type: 'pie',
    data: {
        datasets: [{
            label: "%",
            backgroundColor: <?php echo json_encode($cor_despesa_centro_custo); ?>,
            data: <?php echo json_encode($dados_despesa_centro_custo); ?>,
            pieceLabel: <?php echo json_encode($dados_despesa_centro_custo); ?>,
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

new Chart(document.getElementById("graph-receita-conta-contabil"), {
    type: 'doughnut',
    data: {
        datasets: [{
            label: "%",
            backgroundColor: <?php echo json_encode($cor_receita_conta_contabil); ?>,
            data: <?php echo json_encode($dados_receita_conta_contabil); ?>,
            pieceLabel: <?php echo json_encode($dados_receita_conta_contabil); ?>,
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

new Chart(document.getElementById("graph-receita-centro-custo"), {
    type: 'pie',
    data: {
        datasets: [{
            label: "%",
            backgroundColor: <?php echo json_encode($cor_receita_centro_custo); ?>,
            data: <?php echo json_encode($dados_receita_centro_custo); ?>,
            pieceLabel: <?php echo json_encode($dados_receita_centro_custo); ?>,
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
        labels: <?php echo json_encode($label_conta); ?>,
        datasets: [{
            label: "Saldo",
            backgroundColor: <?php echo json_encode($cor_saldo); ?>,
            data: <?php echo json_encode($dados_saldo); ?>
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

new Chart(document.getElementById("line-chart-conta"), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($label_conta_mov); ?>,
        datasets: [{
                label: "Entradas",
                backgroundColor: "#3cba9f",
                data: <?php echo json_encode($dados_entrada_mov); ?>,
            },
            {
                label: "Saídas",
                backgroundColor: "#d9534f",
                data: <?php echo json_encode($dados_saida_mov); ?>,
            }
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
            }
        }

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