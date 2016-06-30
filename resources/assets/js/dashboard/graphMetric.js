/**
 * Created by Xavier on 24/6/2016.
 */

let Vue = require('vue');
let Resource = require('vue-resource');
Vue.use(Resource);

Vue.config.debug = true;

let GraphMetric = Vue.extend({
    template:document.getElementById("graphMetricTemplate"),
    data(){
        return {
            baseUrl: "/api/metrics",
            metric:{},
            availableMetrics:[],
            randomId:""
        }
    },
    created(){
        this.randomId = Math.random().toString(36).substring(7);
    },
    ready(){
        let panel = document.getElementById(this.randomId);
        let body = panel.getElementsByClassName("panel-body")[0];
        console.log(body);
        this.$http.get(this.baseUrl).then(({data})=>{
            this.availableMetrics = data.metrics;
            this.metric =  data.metrics[0];

            let canvas = this.createCanvas("myCanvas");
            body.appendChild(canvas);
            this.updateMetric(canvas);
        });



    },
    methods: {
        updateMetric(canvas = null){
            this.$http.get(this.baseUrl, {metric: this.metric.code}).then(({data})=>this.createChart(canvas, "line", data.data, {label:"Number Of Post"}));
        },
        createChartData(fetchedData, settings=null){

            let labels = [];
            let data = [];
            for (var label in fetchedData) {
                labels.push(label);
                data.push(fetchedData[label]);
            }
            var defaultSettings = {
                label: "My First dataset",
                fill: true,
                lineTension: 0.1,
                backgroundColor: "rgba(75,192,192,0.4)",
                borderColor: "rgba(75,192,192,1)",
                borderCapStyle: 'round',
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "rgba(75,192,192,1)",
                pointBackgroundColor: "#fff",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(75,192,192,1)",
                pointHoverBorderColor: "rgba(220,220,220,1)",
                pointHoverBorderWidth: 2,
                pointRadius: 1,
                pointHitRadius: 10,
                data:[]
            };

            if (settings !== null && typeof settings === 'object'){
                for (var key in settings){
                    defaultSettings[key] = settings[key];
                }
            }

            defaultSettings['data'] = data;

            var object = {
                labels: labels,
                datasets: [defaultSettings]
            };
            return object ;
        },
        createCanvas(id){
            let canvas = document.createElement("canvas");
            canvas.id = id;
            canvas.style.position = "relative";
            canvas.width = "100%";
            canvas.style.maxWidth = "800px";
            canvas.height = "100%";
            canvas.style.maxHeight = "800px";
            return canvas
        },
        createChart(canvas, chartType = "line", fetchedData, settingObject, options=null){
            let chartData = this.createChartData(fetchedData, settingObject);
            options = options != null? options :  {
                scales: {
                    xAxes: [{
                        type: 'linear',
                        position: 'bottom'
                    }]
                }
            };
            var data = {
                type: chartType,
                data: chartData
            };
            new Chart(canvas, data, options);
        }
    }
})


export default Vue.component('graph-metric', GraphMetric)