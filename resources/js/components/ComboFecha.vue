<template>
    <div>
        <div class="form-group row">
            <label class="col-md-4 col-form-label text-md-right">Elegir fecha para la cita:</label>
            <div class="col-md-6">
                <date-picker
                    v-model="fecha"
                    format="DD-MM-YYYY"
                    :defaul-value="new Date()"
                    :disabled-date="rangoHabilitado"
                    @change="$emit('fecha-select', fecha)"
                ></date-picker>
            </div>
        </div>
    </div>
</template>

<script>

import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import 'vue2-datepicker/locale/es';

export default {
    components:{
        DatePicker
    },
    props:[
       'medicoId',
       'value'
    ],
    data() {
        return {
            fecha: new Date(),
        }
    },
    created: function(){
        console.log('Fecha: '+this.fecha)
    },
    methods: {
        rangoHabilitado: function(date){
            const hoy = new Date();
            hoy.setHours(0, 0, 0, 0);

            return date < hoy || date > new Date(hoy.getTime() + 30 * 24 * 3600 * 1000);
        },

    },
}
</script>
