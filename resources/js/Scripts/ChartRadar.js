import Chart from "chart.js";

export default {
  methods: {

    createRadar: function (dataset, titulo, elemento) {


      this.$nextTick(function () {

        const config = {
          type: 'radar',
          data: dataset,
          options: {
            scale: {
              gridLines: {
                color: 'white'
              },
              angleLines: {
                color: 'white'
              },
              pointLabels: {
                fontColor: "white",
              },
              ticks: {
                beginAtZero: true
              }




            },

            elements: {
              line: {
                borderWidth: 5
              },
            },
            maintainAspectRatio: true,
            responsive: true,
            plugins: {
              title: {
                display: false,
                text: titulo
              }
            },

            legend: {
              labels: {
                fontColor: "white"
              },
              align: "end",
              position: "bottom"
            },
          },
        };

        var ctx = document.getElementById(elemento).getContext("2d");
        window.myLine = new Chart(ctx, config);
      });


    }

  }
}