<template>
    <div>
        <div class="filter">
            <div class="mx-5">Period Start:</div>
            <input class="mx-5" type="date" v-model="startDate">
            <div class="mx-5">Period End:</div>
            <input class="mx-5" type="date" v-model="endDate">
            <button @click.prevent="setChartData">Filter</button>
        </div>
        <hr>
        <highcharts :options="chartOptions"></highcharts>
    </div>
</template>


<script>
import axios from 'axios'

export default {
    name: "WeeklyRetention",
    data() {
        return {
            startDate: '2016-07-19',
            endDate: '2016-09-19',
            chartOptions: {},
        }
    },
    methods: {
        async setChartData() {
            try {

                let response = await axios.get(`http://temper.sugarcodex.com/api/weekly-retention?start_date=${this.startDate}&end_date=${this.endDate}`);

                this.chartOptions = response.data.data

            } catch (err) {
                console.log('Unable to the fetch');
            }
        }
    },
    async mounted() {
        await this.setChartData();
    },
}
</script>