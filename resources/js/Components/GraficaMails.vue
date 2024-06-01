<template>
    <Pie :data="chartData" :options="chartOptions" />
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js';
import { Pie } from 'vue-chartjs';

ChartJS.register(ArcElement, Tooltip, Legend);

export default defineComponent({
    name: 'App',
    components: {
        Pie
    },
    props: {
        datos: {
            type: Object,
            required: true
        }
    },
    computed: {
        chartData() {
            return {
                labels: Object.keys(this.datos),
                datasets: [
                    {
                        backgroundColor: ['#28a745', '#007bff',  '#343a40','#dc3545',],
                        data: Object.values(this.datos),
                    }
                ]
            };
        },
        chartOptions() {
            return {
                responsive: true,
                maintainAspectRatio: true
            };
        }
    }
});
</script>
