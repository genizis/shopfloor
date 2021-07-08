new Chart(document.getElementById("produtos-produzidos"), {
  type: 'horizontalBar',
    data: {
      labels: ["135732 - Caneta Esferográfica Azul", 
               "135732 - Caneta Esferográfica Preta", 
               "135732 - Caneta Esferográfica Vermelha", 
               "135732 - Caneta Esferográfica Laranja", 
               "135732 - Caneta Esferográfica Rosa"],
      datasets: [
        {
          label: "Quantidade no Período",
          backgroundColor: 'rgba(50,93,136,0.2)',
          borderColor: 'rgba(50,93,136,0.4)',
          borderWidth: 2,
          data: [53.6,50.5,45.7,30.4,10.2]
        }
      ]
    },
    options: {
      legend: { display: false },
      scales: {
          yAxes: [{ticks: {mirror: true}}]
      }
      
      
    }
});

new Chart(document.getElementById("produtos-consumidos"), {
  type: 'horizontalBar',
    data: {
      labels: ["135732 - Tinta Azul", 
               "135732 - Tinta Preta", 
               "135732 - Tubo Plástico", 
               "135732 - Tinta Laranja", 
               "135732 - Tinta Rosa"],
      datasets: [
        {
          label: "Quantidade no Período",
          backgroundColor: 'rgba(217,83,79,0.2)',
          borderColor: 'rgba(217,83,79,0.4)',
          borderWidth: 2,
          data: [70.6,43.5,42.7,15.4,10.2]
        }
      ]
    },
    options: {
      legend: { display: false },
      scales: {
          yAxes: [{ticks: {mirror: true}}]
      }
      
      
    }
});

new Chart(document.getElementById("producao-periodo"), {
  type: 'line',
  data: {
        labels: ['10/01', '11/01', '12/01', '13/01', '14/01', '15/01', '16/01', '17/01', '18/01', '19/01'],
        datasets: [
            {
                label: "LT",
                fill: false,
                lineTension: 0,
                borderColor: '#325D88',
                data: [100, 75, 120, 110, 110, 130, 170, 190, 90, 80]
            },
            {
                label: "UN",
                fill: false,
                lineTension: 0,
                borderColor: '#93C54B',
                data: [51, 62, 55, 32, 15, 50, 82, 73, 21, 45]
            }
        ]
    }
});

new Chart(document.getElementById("#produto-vendidos"), {
  type: 'horizontalBar',
    data: {
      labels: ["135732 - Caneta Esferográfica Azul", 
               "135732 - Caneta Esferográfica Preta", 
               "135732 - Caneta Esferográfica Vermelha", 
               "135732 - Caneta Esferográfica Laranja", 
               "135732 - Caneta Esferográfica Rosa"],
      datasets: [
        {
          label: "Quantidade no Período",
          backgroundColor: 'rgba(50,93,136,0.2)',
          borderColor: 'rgba(50,93,136,0.4)',
          borderWidth: 2,
          data: [53.6,50.5,45.7,30.4,10.2]
        }
      ]
    },
    options: {
      legend: { display: false },
      scales: {
          yAxes: [{ticks: {mirror: true}}]      }
      
      
    }
});

new Chart(document.getElementById("quantidade-cliente"), {
  type: 'horizontalBar',
    data: {
      labels: ["135732 - Tinta Azul", 
               "135732 - Tinta Preta", 
               "135732 - Tubo Plástico", 
               "135732 - Tinta Laranja", 
               "135732 - Tinta Rosa"],
      datasets: [
        {
          label: "Quantidade no Período",
          backgroundColor: 'rgba(217,83,79,0.2)',
          borderColor: 'rgba(217,83,79,0.4)',
          borderWidth: 2,
          data: [70.6,43.5,42.7,15.4,10.2]
        }
      ]
    },
    options: {
      legend: { display: false },
      scales: {
          yAxes: [{ticks: {mirror: true}}]
      }
      
      
    }
});
