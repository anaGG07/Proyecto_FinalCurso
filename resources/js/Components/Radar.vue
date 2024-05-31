
<template>
    <div
      class="
        min-w-0
        break-words
        w-full
        pt-10
        shadow-lg
        rounded-b-lg
        bg-green-750
        dark:bg-gray-900
      "
    >
      <div class="p-4">
        <!-- Chart -->
        <div class="relative" style="height: 350px">
          <canvas id="line-chart"></canvas>
        </div>
      </div>
    </div>
  </template>
  <script>
  import LineasChart from "@/Scripts/ChartRadar";
  import moment from "moment";
  import Colores from "@/Scripts/colores.js";
  
  export default {
    props: {
      datos: new Object(),
    },
    mixins: [Colores, LineasChart],
    methods: {
      format_dates(value) {
        let salida = [];
        if (value) {
          value.forEach((registro) => {
            salida.push(moment(String(registro)).format("DD/MM/YYYY"));
          });
        }
  
        return salida;
      },
    },
    mounted: function () {
      let arreglo = [];
      let conjunto = [];
  
      for (const property in this.datos[0]) {
        if (property == "peso" || property == "fecha_revision") {
          arreglo[property] = [];
        }
      }
  
      this.datos.forEach((registro) => {
        for (const property in registro) {
          if (property == "peso" || property == "fecha_revision") {
            arreglo[property].push(registro[property]);
          }
        }
      });
  
      let contador = 0;
      for (const property in arreglo) {
        if (
          property != "user_id" &&
          property != "id" &&
          property != "created_at" &&
          property != "updated_at" &&
          property != "fecha_revision"
        ) {
          let colorNuevo = this.colorHEX(contador);
          contador++;
          conjunto.push({
            label: property,
            backgroundColor: colorNuevo,
            borderColor: colorNuevo,
            data: arreglo[property],
            fill: false,
          });
        }
      }
  
      let dataset = {
        labels: this.format_dates(arreglo["fecha_revision"]),
        datasets: conjunto,
      };
      this.createLineas(dataset, "Control de Peso", "line-chart");
    },
  };
  </script>
  