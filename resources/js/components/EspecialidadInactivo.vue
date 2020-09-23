<template>
    <div>
        <div v-if="verModal">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Especialidades inactivos</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true" @click="verModal = false">&times;</span>
                                    </button>
                                </div>
                            <div class="alert alert-info" role="alert" v-if="mensaje != ''">
                                {{ mensaje }}
                            </div>
                            <div class="modal-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Descripcion</th>
                                            <th scope="col">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(especialidad, index) in especialidades" :key="index">
                                            <td>{{ especialidad.id }}</td>
                                            <td>{{ especialidad.nombre }}</td>
                                            <td>{{ especialidad.descripcion }}</td>
                                            <td>
                                                <button class="btn btn-outline-danger" @click="restaurarEspecialidad(especialidad.id, index)">Restaurar</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="verModal = false, getEspecialidades()">Cerrar</button>
                                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
        <button type="submit" class="btn btn-info mr-2" @click="verModal = true, getInactivos()">Ver Inactivos</button>
    </div>
</template>
<script>
export default {
    props:['usuarioId'],
    data() {
        return {
            especialidades:[],
            verModal:false,
            mensaje: ''
        }
    },
    methods: {
        getInactivos(){
            axios.get('/especialidad/inactivos')
                .then(respuesta => {
                    // console.log(respuesta);
                    this.especialidades = respuesta.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        restaurarEspecialidad(id, index){
            // console.log('Diste click '+id);
            axios.get(`/especialidad/restore/${id}`)
                .then(respuesta => {
                    console.log(respuesta);
                    // this.getInactivos();
                    this.mensaje = respuesta.data;
                    this.especialidades.splice(index, 1);
                    // this.getEspecialidades();
                })
                .catch(error => {
                    console.log(error);
                });
        },
        getEspecialidades(){
            location.reload()
        }
    }
}
</script>
<style scoped>
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }
</style>
