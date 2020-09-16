<template>
    <div>
        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Elegir fecha para la cita:</label>
            <div class="col-md-6">
                <!-- <date-picker v-model="time1"
                    format="YYYY-MM-DD"
                    type="date"
                    :default-value="new Date()"
                    :disabled-date="rangoHabilitado"
                    ></date-picker> -->
                <date-picker
                    v-model="fecha"
                    placeholder="Seleccionar fecha"
                    valueType="format"
                    format="DD-MM-YYYY"
                    @pick="cargarHoras"
                ></date-picker>


                <!-- <date-picker v-model="time2" type="datetime"></date-picker>
                <date-picker v-model="time3" range></date-picker> -->
            </div>
        </div>
    </div>
</template>

<script>

import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import 'vue2-datepicker/locale/es';

const noHorasAlert = `<div class="alert alert-danger" role="alert">
    <strong>Lo sentimos!</strong> No se encontraron horas disponibles para el médico y el día seleccionado.
</div>`;

export default {
    components:{
        DatePicker
    },
    props:[
       'medicoId'
    ],
    data() {
        return {
            // lang: {
            // formatLocale: {
            //     firstDayOfWeek: 1,
            // },
            // monthBeforeYear: false,
            // },
            // time1: null,
            fecha:'',
            horasTM: [],
            horasTT: []
        }
    },
    created: function(){
        console.log('Fecha')
    },
    methods: {
        cargarHoras: function(date){
            // this.value = [date, new Date(date.getTime() + 30 * 24 * 3600 * 1000)]
            console.log('la fecha sellecionada es: '+this.fecha+ ' Medico: '+this.medicoId)
            let urlHorasMedico = '/horasmedico';
            const params = {fecha: this.fecha, id:this.medicoId};
            // this.$emit('fechaSeleccionada', this.fecha);
            axios.get(urlHorasMedico, {params}).then(response => {
                // console.log(response.data.tm_horario)
                if (!response.data.tm_horario && !response.data.tt_horario || response.data.tm_horario.length === 0 && response.data.tt_horario.length === 0) {
                    this.mostrarAlerta();
                }
                if(response.data.tm_horario){
                    response.data.tm_horario.forEach(hora => {
                        console.log(hora.inicio)
                    });
                }
                if(response.data.tt_horario){
                    response.data.tt_horario.forEach(hora => {
                        console.log(hora.inicio)
                    });
                }
                // this.especialidades = response.data;
            });
        },
        rangoHabilitado: function(date){
            const hoy = new Date();
            hoy.setHours(0, 0, 0, 0);

            return date < hoy || date > new Date(hoy.getTime() + 30 * 24 * 3600 * 1000);
        },
        mostrarAlerta(){
            this.$swal({
                icon: 'warning',
                title: 'Oops...',
                html: noHorasAlert,
            })
        }
    },
}
</script>
