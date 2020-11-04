<template>
  <div>
      <div class="container col-md-8 text-center">
            <date-picker
                v-model="fechas"
                type="date"
                valueType="format"
                format="DD-MM-YYYY"
                range
                placeholder="Seleccionar rango de fechas"
                @change="rangoFechas"
            ></date-picker>
      </div>
    <!-- <highcharts :options="chartOptions" :callback="cargar" ref="chart"></highcharts> -->
    <highcharts :options="chartOptions"></highcharts>
    <button @click="cargar">Cargar</button>
  </div>
</template>

<script>
// import Chart from 'highcharts-vue'
import Highcharts from "highcharts";
import exportingInit from "highcharts/modules/exporting";
// import ComboFecha from "./ComboFecha.vue";
import DatePicker from 'vue2-datepicker';

exportingInit(Highcharts);


export default {
  components: {
    // highcharts: Chart,
    // ComboFecha,
    DatePicker
  },
  data() {
    return {
        // value1: [new Date(2019, 9, 8), new Date(2019, 9, 19)],
        fechas:[],
        fecha_inicio: null,
        fecha_fin: null,
      title: "Estado de citas",
      options: ["spline", "line", "bar", "pie"],
      modo: "pie",
      series: [
        {
            name:'Estado',
          data: [],
        },
      ],
      categorias:[],
    };
  },
  computed: {
    chartOptions:function() {
      return {
        chart: { type: this.modo },
        title: { text: this.title },
        series: this.series,
        yAxis:{
            title: {
                text:'Cantidad de citas',
            }
        },
        xAxis:{
            categories:this.categorias
        }
      };
    },
  },
  methods: {
    cargar: function () {

        let url = "/reportes/estadocitas";
        const params = {
            fecha_inicio:this.fechas[0],
            fecha_fin:this.fechas[1]
        };
        axios.get(url, {params})
            .then(response =>{
                console.log(response.data)
                this.categorias = response.data['categoria']
                this.series[0].data = response.data['cantidad']
            })
            .catch((error) => {
                console.log(error);
            });
    },
    rangoFechas:function(){
        this.fecha_inicio = this.fechas[0];
        this.fecha_fin = this.fechas[1];
        this.cargar();
        console.log(this.fechas[0]);
        console.log(this.fechas[1]);
    }
  },
  created: function() {
      this.cargar();
    //   this.chartOptions()
  },
};
</script>

<style>
</style>
