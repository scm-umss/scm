<template>
    <div>
        <div class="form-group row">
            <label for="especialidad" class="col-md-4 col-form-label text-md-right">Especialidad:</label>
            <div class="col-md-6">
                <select @change="$emit('especialidad-select', $event.target.value)" class="form-control">
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
    //    'especialidades'
    ],
    data() {
        return {
            especialidades:[],
        }
    },
    created: function(){
        this.getEspecialidades();
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
    }
}
</script>
