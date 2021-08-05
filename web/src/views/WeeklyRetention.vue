<template>
    <div>
        <highcharts :options="chartOptions"></highcharts>
    </div>
</template>


<script>
import axios from 'axios'

export default {
    name: "WeeklyRetention",
    data() {
        return {
            chartOptions: {},
        }
    },
    async mounted() {
        try {

            let response = await axios.get('http://temper.sugarcodex.com/api/weekly-retention');

            this.chartOptions = response.data.data

        } catch (err) {
            console.log('Unable to the fetch');
        }
    },
}
</script>