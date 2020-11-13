<template>
  <div>
      <div class="container col-md-8 text-center mb-4">
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
      title: "Estado de citas",
      options: ["spline", "line", "bar", "pie"],
      modo: "pie",
      series: [
        {
            name:'Estado',
            colorByPoint:true,
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
      };
    },
  },
  methods: {
    cargar: function () {

        let url = "/reportes/estado/citas";
        const params = {
            fecha_inicio:this.fechas[0],
            fecha_fin:this.fechas[1]
        };
        axios.get(url, {params})
            .then(response =>{
                // console.log(response.data)
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
  },
};
</script>

<style>
</style>
