<template>
  <div>
    <input
      type="submit"
      class="btn btn-sm btn-danger"
      value="Cancelar"
      @click="cancelarCita"
      :dusk="dusk"
    />
  </div>
</template>

<script>
export default {
    props:[
        'citaId'
    ],
    data() {
        return {
            dusk: 'cancelar-cita-' + this.citaId
        }
    },
  methods: {
    cancelarCita() {
        // console.log("Cancelarcita");
        this.$swal({
            title: 'Explíquenos el motivo de la cancelación.',
            input: 'textarea',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            // showLoaderOnConfirm: true,
        }).then((result) => {
            console.log(result)
            if(result.isConfirmed){
                if (result.value) {
                const params = {
                    descripcion: result.value
                };
                axios.post(`/citas/${this.citaId}/cancelar`, params)
                    .then(res=>{
                        console.log(res)
                        this.$swal({
                            title: res.data,
                            icon: 'success',
                        })
                        .then(result =>{
                            this.getCitas()
                        });
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }else{
                this.$swal({
                    title: 'Debe completar el campo!.',
                    icon: 'info',
                })
            }
            }
        })
    },
    getCitas(){
        location.reload()
    }
  },
};
</script>

<style>
</style>
