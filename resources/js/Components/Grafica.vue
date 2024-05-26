<template>
  <div>
    <radar-chart :chart-data="chartData" :options="chartOptions"></radar-chart>
  </div>
</template>

<script>
import { Radar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, RadarController, RadialLinearScale, PointElement, LineElement, Filler } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, RadarController, RadialLinearScale, PointElement, LineElement, Filler)

export default {
  name: 'RadarChart',
  components: {
    'radar-chart': Radar
  },
  data() {
    return {
      chartData: {
        labels: ['Eating', 'Drinking', 'Sleeping', 'Designing', 'Coding', 'Cycling', 'Running'],
        datasets: [
          {
            label: 'My First Dataset',
            data: [65, 59, 90, 81, 56, 55, 40],
            fill: true,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgb(255, 99, 132)',
            pointBackgroundColor: 'rgb(255, 99, 132)',
            pointBorderColor: '#fff',
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: 'rgb(255, 99, 132)'
          },
          {
            label: 'My Second Dataset',
            data: [28, 48, 40, 19, 96, 27, 100],
            fill: true,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgb(54, 162, 235)',
            pointBackgroundColor: 'rgb(54, 162, 235)',
            pointBorderColor: '#fff',
            pointHoverBackgroundColor: '#fff',
            pointHoverBorderColor: 'rgb(54, 162, 235)'
          }
        ]
      },
      chartOptions: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          r: {
            angleLines: {
              display: true
            },
            suggestedMin: 0,
            suggestedMax: 100
          }
        }
      }
    }
  },
  mounted() {
    this.renderChart(this.chartData, this.chartOptions)
  }
}
</script>

<style scoped>
div {
  position: relative;
  height: 40vh;
  width: 80vw;
}
</style>
