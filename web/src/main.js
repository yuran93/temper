import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'

import Highcharts from 'highcharts'
import HighchartsVue from 'highcharts-vue'

// stockInit(Highcharts)
// mapInit(Highcharts)
// addWorldMap(Highcharts)

createApp(App)
    .use(HighchartsVue)
    .use(store)
    .use(router)
    .mount('#app')
