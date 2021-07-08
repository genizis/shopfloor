<?php $this->load->view('gerais/header' , $menu); ?>
<?php $this->load->view('gerais/menu', $menu); ?>

<section>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('visao-geral') ?>">Visão Geral</a></li>
            <li class="breadcrumb-item active">Indicadores de Estoque</a></li>
        </ol>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form action="<?= base_url('estoque/indicadores-estoque') ?>" method="get" class="mb-0 needs-validation" novalidate>
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
                            <button type="submit" class="btn btn-outline-primary btn-block">Atualizar
                                Indicadores</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-9">
                <div class="card ">
                    <div class="card-body card-table estoque-produto">
                        <h5 class="card-title"><strong>ESTOQUE POR PRODUTO</strong></h5>
                        <canvas id="line-chart" height="95"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card  mb-3">
                            <div class="card-body">
                                <h5 class="card-title"><strong>VALOR TOTAL EM ESTOQUE</strong></h5>
                                <div class="card-table text-center">
                                    <h1 class="<?php if($valor_total_estoq > 0) echo "text-danger"; ?> display-5 font-weight-bold mb-0">R$
                                        <?= number_format($valor_total_estoq, 2, ',', '.') ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card  mb-3">
                            <div class="card-body">
                                <h5 class="card-title"><strong>TOTAL EM ENTRADAS</strong></h5>
                                <div class="card-table text-center">
                                    <h1 class="<?php if($valor_entrada > 0) echo "text-info"; ?> display-5 font-weight-bold mb-0">R$
                                        <?= number_format($valor_entrada, 2, ',', '.') ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card  mb-1">
                            <div class="card-body">
                                <h5 class="card-title"><strong>TOTAL EM SAÍDAS</strong></h5>
                                <div class="card-table text-center">
                                    <h1 class="<?php if($valor_saida > 0) echo "text-warning"; ?> display-5 font-weight-bold mb-0">R$
                                        <?= number_format($valor_saida, 2, ',', '.') ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="card movimento-produto ">
                    <div class="card-body">
                        <h5 class="card-title"><strong>MOVIMENTAÇÃO POR PRODUTO</strong></h5>
                        <canvas id="line-chart-2" height="42"></canvas>
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
new Chart(document.getElementById("line-chart"), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($cod_produto_estoq); ?> ,
        datasets : [{
            label: "Quant Estoq",
            backgroundColor: "rgb(142, 140, 132, 0.4)",
            data: <?php echo json_encode($quant_estoq); ?>
        }, {
            label: 'Valor Estoq',
            borderColor: "#d9534f",
            backgroundColor: "#d9534f",
            data: <?php echo json_encode($valor_estoq); ?> ,
            type : 'line',
            order: 2,
            fill: false,
        }],
    },
    options: {
        tooltips: {
            callbacks: {
                label: function(t, d) {
                    var xLabel = d.datasets[t.datasetIndex].label;
                    var yLabel = t.yLabel;
                    var unid_medida = <?php echo json_encode($cod_unid_medida); ?> ;
                    // if line chart
                    if (t.datasetIndex === 0) return xLabel + ': ' + yLabel.toLocaleString("pt-BR", {
                        style: "decimal",
                        minimumFractionDigits: 3,
                        maximumFractionDigits: 3
                    }) + " " + unid_medida[t.index];
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
                    var desc_produto = <?php echo json_encode($nom_produto_estoq); ?> ;
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
            xAxes: [{
                gridLines: {
                    display: false,
                },
            }]
        },
    }
});

new Chart(document.getElementById("line-chart-2"), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($cod_produto_mov); ?> ,
        datasets : [{
                label: "Entrada",
                backgroundColor: "#3cba9f",
                data: <?php echo json_encode($dados_entrada); ?> ,
            },
            {
                label: "Saída",
                backgroundColor: "#F47C3C",
                data: <?php echo json_encode($dados_saida); ?> ,
            }
        ]
    },
    options: {
        tooltips: {
            callbacks: {
                label: function(t, d) {
                    var xLabel = d.datasets[t.datasetIndex].label;
                    var yLabel = t.yLabel;
                    var unid_medida = <?php echo json_encode($cod_unid_med_mov); ?> ;
                    // if line chart
                    return xLabel + ': ' + yLabel.toLocaleString("pt-BR", {
                        style: "decimal",
                        minimumFractionDigits: 3,
                        maximumFractionDigits: 3
                    }) + " " + unid_medida[t.index];
                },
                title: function(tooltipItem, data) {
                    var indice = tooltipItem[0].index;
                    var desc_produto = <?php echo json_encode($nom_produto_mov); ?> ;
                    return tooltipItem[0].xLabel + " - " + desc_produto[indice];
                }
            }
        },
        legend: {
            display: false
        },
        scales: {
            yAxes: [{
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
            xAxes: [{
                gridLines: {
                    display: false,
                },
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