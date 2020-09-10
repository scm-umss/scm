<template>
    <div>
        <div class="form-group row">
            <label for="especialidad" class="col-md-4 col-form-label text-md-right">Especialidad:</label>
            <div class="col-md-6">
                <select ref="especialidad_seleccionada" class="form-control" @change="cargarMedicos">
                    <option value="0">--Seleccionar especialidad--</option>
                    <option v-for="especialidad in especialidades" :key="especialidad.id" :value="especialidad.id">{{ especialidad.nombre }}</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="medico" class="col-md-4 col-form-label text-md-right">Medico:</label>
            <div class="col-md-6">
                <select ref="medico_seleccionado" class="form-control" @change="cargarHoras">
                    <option value="0">--Seleccionar medico--</option>
                    <option v-for="medico in medicos" :key="medico.id" :value="medico.id">{{ medico.nombre }}</option>
                </select>
            </div>
        </div>

        <fecha-component :medicoId=medico_seleccionado></fecha-component>


    </div>
</template>

<script>
export default {
    props:[
       'especialidadId'
    ],
    data() {
        return {
            especialidad_seleccionada: '', //para especialidad_id
            medico_seleccionado: '',    // para medico user_id
            especialidades: [],
            medicos: [],
            fecha_seleccionada: '',
        }
    },
    created: function(){
        this.getEspecialidades()
    },
    methods: {
        getEspecialidades: function (){
            let urlEspecialidades = '/citas/especialidades';
            axios.get(urlEspecialidades).then(response => {
                // console.log(response.data)
                this.especialidades = response.data;
            })
            .catch(error => {
                console.log(error);
            });
        },
        cargarMedicos: function() {
            this.especialidad_seleccionada = this.$refs.especialidad_seleccionada.value;
            if (this.especialidad_seleccionada != '0') {
                let urlMedicos = '/especialidad/'+this.especialidad_seleccionada+'/medicos';
                axios.get(urlMedicos)
                    .then(response => {
                        // console.log(response)
                        this.medicos = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
        cargarHoras: function (){
            this.medico_seleccionado = this.$refs.medico_seleccionado.value;
            console.log('Medico id: '+this.medico_seleccionado+' '+this.fecha_seleccionada);
            // console.log(this.fecha_seleccionada);
        }

    }
}
</script>
