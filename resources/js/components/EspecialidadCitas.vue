<template>
  <div>
      <div class="container col-md-8 text-center mb-4">
            <date-picker
                v-model="fechas"
                type="date"
                valueType="format"
                format="DD-MM-YYYY"
                range
                default-value=""
                placeholder="Seleccionar rango de fechas"
                @change="rangoFechas"
            ></date-picker>
      </div>
    <!-- <highcharts :options="chartOptions" :callback="cargar" ref="chart"></highcharts> -->
    <highcharts :options="chartOptions"></highcharts>
  </div>
</template>

<script>
// import Chart from 'highcharts-vue'
import Highcharts from "highcharts";
import exportingInit from "highcharts/modules/exporting";
// import ComboFecha from "./ComboFecha.vue";
import DatePicker from 'vue2-datepicker';
import moment from 'moment';

exportingInit(Highcharts);


export default {
  components: {
    // highcharts: Chart,
    // ComboFecha,
    DatePicker
  },
  props: ['f_ini','f_fin'],
  data() {
    return {
        // value1: [new Date(2019, 9, 8), new Date(2019, 9, 19)],
        fechas:[],
        fecha_inicio: null,
        fecha_fin: null,
      title: "Cantidad de citas por especialidad",
      options: ["spline", "line", "bar", "pie"],
      modo: "column",
      series: [
        {
            name:'Especialidad',
            data: [],
        },
        // {
        //     name:'No registrados',
        //   data: [12, 1, 4, 3, 8, 1, 3, 7],
        // },
      ],
      categorias:[],
    };
  },
  computed: {
    chartOptions:function() {
      return {
          lang: {
            downloadCSV:"Descarga CSV",
            downloadSVG:"Descargar en SVG",
            printChart: 'Imprimir',
            downloadPNG: 'Descargar en PNG',
            downloadJPEG: 'Descargar en JPEG',
            downloadPDF: 'Descargar en PDF',
            viewFullscreen:"Ver en pantalla completa"
        },
        chart: { type: this.modo },
        title: { text: this.title },
        series: this.series,
        yAxis:{
            title: {
                text:'Cantidad Citas',
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

        let url = "/reportes/especialidad/citas";
        const params = {
            fecha_inicio:this.fechas[0],
            fecha_fin:this.fechas[1]
        };
        axios.get(url, {params})
            .then(response =>{
                console.log(response.data)
                this.categorias = response.data['categorias']
                this.series[0].data = response.data.series['data']
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
