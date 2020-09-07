<template>
    <div>
        <input
        type="submit"
        class="btn btn-sm btn-danger"
        value="Dar de baja"
        @click="darDeBaja">
    </div>
</template>
<script>
export default {
    props:['usuarioId'],
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
                    id: this.usuarioId
                };
                axios.post(`/usuarios/${this.usuarioId}`, {params, _method:'delete'})
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
        }
    }
}
</script>
