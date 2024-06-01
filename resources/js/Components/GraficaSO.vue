<template>
  <div>
    <Bar
      id="my-chart-id"
      :options="chartOptions"
      :data="chartData"
    />
  </div>
</template>

<script>
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

export default {
  name: 'BarChart',
  components: { Bar },
  props: {
    datos: {
      type: Object,
      required: true
    },
    etiqueta: {
      type: String,
      required: true
    },
    colores: {
      type: Array,
      required: false,
      default: () => ['#28a745', '#dc3545', '#007bff', '#343a40', '#ffcc00', '#ff6633', '#33cc33', '#ff0066']
    }
  },
  data() {
    return {
      chartData: {
        labels: Object.keys(this.datos),
        datasets: [{
          label: this.etiqueta,
          data: Object.values(this.datos),
          backgroundColor: this.colores,
          borderColor: this.colores.map(color => this.darkenColor(color, 0.2)),
          borderWidth: 1
        }]
      },
      chartOptions: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    }
  },
  methods: {
    darkenColor(color, amount) {
      let usePound = false;
      if (color[0] === "#") {
        color = color.slice(1);
        usePound = true;
      }

      const num = parseInt(color, 16);
      let r = (num >> 16) + amount * 255;
      let g = ((num >> 8) & 0x00FF) + amount * 255;
      let b = (num & 0x0000FF) + amount * 255;

      r = Math.max(Math.min(255, r), 0);
      g = Math.max(Math.min(255, g), 0);
      b = Math.max(Math.min(255, b), 0);

      return (usePound ? "#" : "") + (g | (b << 8) | (r << 16)).toString(16);
    }
  }
}
</script>
