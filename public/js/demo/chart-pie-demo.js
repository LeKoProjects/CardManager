// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

var ctx = document.getElementById("myPieChart");

// Extrair labels e dados dos resultados da consulta
var labels = Object.keys(countByTipo);
var data = Object.values(countByTipo);

// Função para gerar cor hexadecimal aleatória
function getRandomColor() {
  var letters = '0123456789ABCDEF';
  var color = '#';
  for (var i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
}

// Função para clarear uma cor hexadecimal
function lightenColor(color, percent) {
  var num = parseInt(color.slice(1), 16),
      amt = Math.round(2.55 * percent),
      R = (num >> 16) + amt,
      B = (num >> 8 & 0x00FF) + amt,
      G = (num & 0x0000FF) + amt;
  return "#" + (0x1000000 + (R < 255 ? R < 1 ? 0 : R : 255) * 0x10000 + (B < 255 ? B < 1 ? 0 : B : 255) * 0x100 + (G < 255 ? G < 1 ? 0 : G : 255)).toString(16).slice(1);
}

// Arrays para armazenar cores e cores de hover
var backgroundColors = [];
var hoverBackgroundColors = [];

// Preencher arrays com cores e tons de hover correspondentes
for (var i = 0; i < labels.length; i++) {
  var backgroundColor = getRandomColor();
  backgroundColors.push(backgroundColor);
  hoverBackgroundColors.push(lightenColor(backgroundColor, 10));
}

// Configurar o gráfico de pizza com cores aleatórias e tons de hover
var ctx = document.getElementById("myPieChart").getContext('2d');
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: labels,
    datasets: [{
      data: data,
      backgroundColor: backgroundColors,
      hoverBackgroundColor: hoverBackgroundColors,
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
      callbacks: {
        label: function(tooltipItem, data) {
          var dataset = data.datasets[tooltipItem.datasetIndex];
          var total = dataset.data[tooltipItem.index];
          var label = dataset.label || '';
          var typeName = data.labels[tooltipItem.index];
          return typeName + ': ' + total;
        }
      }
    },
    legend: {
      display: true,
      position: 'right'
    },
    cutoutPercentage: 80,
  },
});

//ADMIN

// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

var ctx = document.getElementById("myPieChart2");

// Extrair labels e dados dos resultados da consulta
var labels = Object.keys(countByTipo);
var data = Object.values(countByTipo);

// Função para gerar cor hexadecimal aleatória
function getRandomColor() {
  var letters = '0123456789ABCDEF';
  var color = '#';
  for (var i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
}

// Função para clarear uma cor hexadecimal
function lightenColor(color, percent) {
  var num = parseInt(color.slice(1), 16),
      amt = Math.round(2.55 * percent),
      R = (num >> 16) + amt,
      B = (num >> 8 & 0x00FF) + amt,
      G = (num & 0x0000FF) + amt;
  return "#" + (0x1000000 + (R < 255 ? R < 1 ? 0 : R : 255) * 0x10000 + (B < 255 ? B < 1 ? 0 : B : 255) * 0x100 + (G < 255 ? G < 1 ? 0 : G : 255)).toString(16).slice(1);
}

// Arrays para armazenar cores e cores de hover
var backgroundColors = [];
var hoverBackgroundColors = [];

// Preencher arrays com cores e tons de hover correspondentes
for (var i = 0; i < labels.length; i++) {
  var backgroundColor = getRandomColor();
  backgroundColors.push(backgroundColor);
  hoverBackgroundColors.push(lightenColor(backgroundColor, 10));
}

// Configurar o gráfico de pizza com cores aleatórias e tons de hover
var ctx = document.getElementById("myPieChart").getContext('2d');
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: labels,
    datasets: [{
      data: data,
      backgroundColor: backgroundColors,
      hoverBackgroundColor: hoverBackgroundColors,
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
      callbacks: {
        label: function(tooltipItem, data) {
          var dataset = data.datasets[tooltipItem.datasetIndex];
          var total = dataset.data[tooltipItem.index];
          var label = dataset.label || '';
          var typeName = data.labels[tooltipItem.index];
          return typeName + ': ' + total;
        }
      }
    },
    legend: {
      display: true,
      position: 'right'
    },
    cutoutPercentage: 80,
  },
});