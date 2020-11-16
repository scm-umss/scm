<template>
    <div>
        <button
        type="submit"
        class="btn btn-sm btn-danger"
        @click="darDeBaja"><i class="fas fa-minus-circle"></i> Dar de baja</button>
    </div>
</template>
<script>
export default {
    props:['especialidadId'],
    methods: {
        darDeBaja(){
            // console.log('Diste click '+ this.usuarioId);
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
                    id: this.especialidadId
                };
                axios.post(`/especialidad/${this.especialidadId}`, {params, _method:'delete'})
                    .then(respuesta => {
                        // console.log(respuesta);
                        this.$swal({
                            title: 'Especialidad dado de baja',
                            text: 'Baja exitoso',
                            icon: 'success'
                        });
                        // console.log(this.$el); // para ver el elemento
                        this.$el.parentNode.parentNode.parentNode.removeChild(this.$el.parentNode.parentNode);

                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
            })
        }
    }
}
</script>
