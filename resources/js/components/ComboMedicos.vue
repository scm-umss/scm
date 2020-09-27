<template>
    <div>
        <div class="form-group row">
            <label for="medico" class="col-md-4 col-form-label text-md-right">Medico:</label>
            <div class="col-md-6">
                <select @change="$emit('medico-select', $event.target.value)" class="form-control">
                    <option value="0">--Seleccionar medico--</option>
                    <option v-for="medico in medicos" :key="medico.id" :value="medico.id" :selected="medico.id == medicoId">{{ medico.nombre }}</option>
                </select>
            </div>
        </div>
        <!-- <p>{{ especialidadId}}</p> -->
    </div>
</template>

<script>
export default {
    props:[
       'medicoId',
       'especialidadId'
    ],
    data() {
        return {

            // medico_seleccionado: '',
            medicos: [],
            // fecha_seleccionada: '',
        }
    },
    methods: {
        cargarMedicos: function(id) {
            // console.log('Leego '+ id);
            // this.especialidad_seleccionada = this.$refs.especialidad_seleccionada.value;
            if (id != '0') {
                let urlMedicos = '/especialidad/'+id+'/medicos';
                axios.get(urlMedicos)
                    .then(response => {
                        // console.log(response)
                        this.medicos = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }else{
                this.medicos=[];
            }
        },
    },
    // created: function(){
    //     this.cargarMedicos(this.especialidadId);
    // }
}
</script>
