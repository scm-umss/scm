<template>
    <div>
        <div class="form-group row">
            <label for="especialidad" class="col-md-4 col-form-label text-md-right">Especialidad:</label>
            <div class="col-md-6">
                <div v-if="especialidadId">
                    <h5><span class="badge badge-info p-2"> {{ nombreEspecialidad}}</span></h5>
                </div>
                <select @change="$emit('especialidad-select', $event.target.value)" class="form-control" v-else>
                    <option value="0">--Seleccionar especialidad--</option>
                    <option v-for="especialidad in especialidades" :key="especialidad.id" :value="especialidad.id" :selected="especialidad.id == especialidadId">{{ especialidad.nombre }}</option>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:[
       'especialidadId',
       'especialidadNombre'
    ],
    data() {
        return {
            especialidades:[],
            nombreEspecialidad: ''
        }
    },
    created: function(){
        this.getEspecialidades();
    },
    methods: {
        getEspecialidades: function (){
            // console.log(this.especialidadId+'ididididi');
            let urlEspecialidades = '/citas/especialidades';
             axios.get(urlEspecialidades)
            .then(response => {
                this.especialidades = response.data;
                this.getNombreEspecialidad(this.especialidadId)
            })
            .catch(error => {
                console.log(error);
            });
        },
        getNombreEspecialidad: function(id) {

            this.nombreEspecialidad = this.especialidades.find(function(especialidad){
                return especialidad.id == id;
            }).nombre;
        },
    }
}
</script>
