<template>
    <div>
        <div class="form-group row">
            <label for="medico" class="col-md-4 col-form-label text-md-right">Medico:</label>
            <div class="col-md-6">
                <!-- <div v-if="medicoId">
                    <h5><span class="badge badge-info p-2"> {{ nombreMedico}}</span></h5>
                </div> -->
                <div v-if="formulario == 'editar'">
                    <div v-for="medico in medicos" :key="medico.id" :value="medico.id">
                        <h5><span class="badge badge-info p-2" v-if="medico.id == medicoId"> {{ medico.nombre }} {{ medico.ap_paterno }} {{ medico.ap_materno }}</span></h5>
                    </div>
                </div>
                <select @change="$emit('medico-select', $event.target.value)" class="form-control" v-if="formulario == 'crear'">
                    <option value="">--Seleccionar medico--</option>
                    <option v-for="medico in medicos" :key="medico.id" :value="medico.id" :selected="medico.id == medicoId">{{ medico.nombre }} {{ medico.ap_paterno }} {{ medico.ap_materno }}</option>
                </select>
            </div>
        </div>
        <!-- <p>{{ formulario}}</p> -->
    </div>
</template>

<script>
export default {
    props:[
       'medicoId',
       'especialidadId',
       'formulario',
    //    'edit'
    ],
    data() {
        return {

            // medico_seleccionado: '',
            medicos: [],
            nombreMedico: '',
        }
    },
    methods: {
        cargarMedicos: function(id) {
            if (id != '') {
                console.log('formulario: '+ this.formulario)
                let urlMedicos = '/especialidad/'+id+'/medicosjson'+(this.formulario=='editar'? 'editar':'');
                // console.log(urlMedicos);
                let param = {};
                axios.get(urlMedicos)
                    .then(response => {
                        // console.log(response.data)
                        this.medicos = response.data;
                        // this.getNombreMedico(this.medicoId)
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }else{
                this.medicos=[];
            }
        },
        getNombreMedico: function(id) {
            // console.log('medico id: '+this.medicos);
            const medicos = this.medicos.find(function(medico){
                return medico.id == id;
            });
            this.nombreMedico = medicos.nombre +' ' + medicos.ap_paterno + ' ' + medicos.ap_materno;
        },
    },
}
</script>
