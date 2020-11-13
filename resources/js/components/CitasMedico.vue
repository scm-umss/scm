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
    <highcharts :options="chartOptions"></highcharts>
  </div>
</template>

<script>
import Highcharts from "highcharts";
import exportingInit from "highcharts/modules/exporting";
import DatePicker from 'vue2-datepicker';
import moment from 'moment';

exportingInit(Highcharts);


export default {
  components: {
    DatePicker
  },
  props: ['f_ini','f_fin'],
  data() {
    return {
        fechas:[moment(new Date(this.f_ini)).format('DD-MM-YYYY'), moment(new Date(this.f_fin)).format('DD-MM-YYYY')],
        fecha_inicio: null,
        fecha_fin: null,
      title: "Cantidad de citas por médico",
      options: ["spline", "line", "bar", "pie"],
      modo: "column",
      series: [
        {
            name:'Atendidas',
            data: [],
        },
        {
            name:'Canceladas',
          data: [],
        },
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
            title: {
                text:'Citas Atendidas',
            },
            categories:this.categorias
        }
      };
    },
  },
  methods: {
    cargar: function () {

        let url = "/reportes/citas/medico";
        const params = {
            fecha_inicio:this.fechas[0],
            fecha_fin:this.fechas[1]
        };
        axios.get(url, {params})
            .then(response =>{
                // console.log(response.data.series)
                this.categorias = response.data['categorias']
                this.series[0].data = response.data.series[0].data
                this.series[1].data = response.data.series[1].data
            })
            .catch((error) => {
                console.log(error);
            });
    },
    rangoFechas:function(){
        this.fecha_inicio = this.fechas[0];
        this.fecha_fin = this.fechas[1];
        this.cargar();
        // console.log(this.fechas[0]);
        // console.log(this.fechas[1]);
    }
  },
  created: function() {
      this.cargar();
  },
};
</script>

<style>
</style>
