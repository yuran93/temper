<template>
  <div>
    <highcharts :options="chartOptions"></highcharts>
  </div>
</template>


<script>
import axios from 'axios'

export default {
  name: "WeeklyRetention",
  async mounted() {
      axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';
      let response = await axios.get('localhost:8000/test');

      console.log(response.data)
  },
  data() {
    return {
      chartOptions: {

        title: {
          text: "WEEKLY RETENTION CURVES - MIXPANEL DATA",
        },

        yAxis: {
          title: {
            text: "Percentage of users",
          },
        },

        xAxis: {
        categories: [43934, 52503, 57177, 69658, 97031, 119931, 137133, 154175],

          accessibility: {
            rangeDescription: "Start date",
          },
        },

        legend: {
          layout: "vertical",
          align: "right",
          verticalAlign: "middle",
        },

        series: [
          {
            name: "Installation",
            data: [175175, 52503, 57177, 69658, 97031, 119931, 137133, 154175],
          },
        ],

        plotOptions: {
    	series: {
      	pointPlacement: 'on'
      }
    },

        responsive: {
          rules: [
            {
              condition: {
                maxWidth: 500,
              },
              chartOptions: {
                legend: {
                  layout: "horizontal",
                  align: "center",
                  verticalAlign: "bottom",
                },
              },
            },
          ],
        },
      },
    };
  },
};
</script>
