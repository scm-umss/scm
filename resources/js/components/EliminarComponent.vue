<template>
    <div>
        <input
        type="submit"
        class="btn btn-danger"
        value="Eliminar"
        @click="eliminarPaciente">
    </div>
</template>
<script>
export default {
    props:['pacienteId'],
    methods: {
        eliminarPaciente(){
            // console.log('Diste click '+ this.pacienteId);
            this.$swal({
                title: 'Estás seguro de dar de baja?',
                text: "Una vez de de baja, ya no estará disponible en la lista!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, dar de baja!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
            if (result.value) {
                const params = {
                    id: this.pacienteId
                };
                axios.get(`/usuarios/destroy/${this.pacienteId}`, {params})
                    .then(respuesta => {
                        // console.log(respuesta);
                        this.$swal({
                            title: 'Paciente dado de baja',
                            text: 'Se procedió con la baja',
                            icon: 'success'
                        });
                        console.log(this.$el);
                        this.$el.parentNode.parentNode.parentNode.removeChild(this.$el.parentNode.parentNode);

                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
            })
            // this.$swal({
            //         title: "¿Está seguro de dar de baja al Paciente?",
            //         text: "Una vez dado de baja, ya no estará en la lista de pacientes.",
            //         icon: "warning",
            //         dangerMode: true,
            //         buttons: ["Cancelar", "Dar de baja!"],
            //     })
            //     .then((quiereBorrar) => {
            //     if (quiereBorrar) {
            //         window.location.href = '{{ route("usuarios.destroy", $paciente->id ) }}';
            //     }
            //     });
        }
    }
}
</script>
