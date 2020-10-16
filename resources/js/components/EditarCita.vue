<template>
  <div>
    <!-- <h1>Hola desde edit{{citaId}}</h1> -->
    <fieldset class="border p-4">
      <legend class="text-primary">Editar cita</legend>
      <combo-especialidad
        :especialidadId="especialidad_seleccionada"
        :formulario="evento"
        @especialidad-select="especialidadSelect"
      />
      <combo-medicos
        :especialidadId="especialidad_seleccionada"
        :medicoId="medico_seleccionado"
        :formulario="evento"
        ref="especialidadSeleccionada"
        @medico-select="medicoSelect"
      />
      <combo-fecha
        :medicoId="medico_seleccionado"
        @fecha-select="fechaSelect"
        ref="fechaSeleccionada"
      />
      <div class="container">
        <div class="row row-cols-2">
            <div class="col">
                <div class="alert alert-info" role="alert">
                    <strong>Fecha programada:</strong> {{ fecha_programada.substr(0,10) }}
                </div>
            </div>
            <div class="col">
                <div class="alert alert-info" role="alert">
                    <strong>Hora Programada:</strong> {{ hora_programada.substr(0,5) }}
                </div>
            </div>
        </div>
        <div class="alert alert-warning" role="alert">
            <h5>Para cambiar la cita, seleccione la fecha y hora!.</h5>
        </div>
      </div>
    </fieldset>
    <fieldset class="border p-4" v-if="horas.length">
      <legend class="text-primary">Horas disponibles</legend>
        <div class="container">
        <div class="row row-cols-2">
            <div class="col" v-if="this.tm_sucursal">
                <div class="shadow p-2 mb-4 bg-white rounded text-center border border-primary">Sucursal Mañana: {{ tm_sucursal.nombre }}</div>
            </div>
            <div class="col" v-if="this.tt_sucursal">
                <div class="shadow p-2 mb-4 bg-white rounded text-center border border-secondary">Sucursal Tarde: {{ tt_sucursal.nombre }}</div>
            </div>
        </div>
      </div>
      <hr>
      <div class="container">
        <div class="row row-cols-4">
          <div v-for="(hora, index) in horas" :key="index">
            <div class="col mb-4" v-if="hora<'12:00'">
              <div class="card shadow text-white bg-primary mb-3">
                <div class="card-header">
                  <div class="form-check">
                    <input
                      class="form-check-input"
                      type="radio"
                      name="hora_inicio"
                      :id="'hora_inicio_'+index"
                      :value="hora"
                      :checked="hora+':00' == hora_seleccionada"
                      @click="horaSelect"
                    />
                    <label class="form-check-label" :for="'hora_inicio_'+index">{{ hora }}</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col" v-else>
              <div class="card shadow text-white bg-secondary mb-3">
                <div class="card-header">
                  <div class="form-check">
                    <input
                      class="form-check-input"
                      type="radio"
                      name="hora_inicio"
                      :id="'hora_inicio'+index"
                      :value="hora"
                      :checked="hora+':00' == hora_seleccionada"
                      @click="horaSelect"
                    />
                    <label class="form-check-label" :for="'hora_inicio'+index">{{ hora }}</label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </fieldset>
    <div class="form-group mt-3 d-flex justify-content-center">
      <button
        type="submit"
        class="btn btn-primary p3"
        @click.prevent="editarCita"
        v-if="datosCorrectos()"
      >Guardar Cita</button>
    </div>
  </div>
</template>

<script>
import ComboEspecialidad from "./ComboEspecialidad.vue";
import ComboMedicos from "./ComboMedicos.vue";
import ComboFecha from "./ComboFecha.vue";

const noHorasAlert = `<div class="alert alert-danger" role="alert">
                    <strong>Lo sentimos!</strong> No se encontraron horas disponibles para el médico y el día seleccionado.
                </div>`;

export default {
  components: {
    ComboEspecialidad,
    ComboMedicos,
    ComboFecha,
  },
  props: {
    citaId: "",
  },

  data() {
    return {
      especialidad_seleccionada: "",
    //   especialidad_nombre:"",
      medico_seleccionado: "",
      fecha_seleccionada: null,
      horas: [],
      tm_sucursal: "",
      tt_sucursal: "",
      hora_seleccionada: "",
      paciente_seleccionado:"",
      sucursal_seleccionado:"",
      hora_programada: "",
      fecha_programada: "",
      evento:'editar'
    };
  },
  methods: {
    getCita() {
      console.log("cita id: " + this.citaId);
      const urlCita = `/citas/${this.citaId}/edit`;
      axios
        .get(urlCita)
        .then((response) => {
        //   console.log('Citassss '+response.data);
          this.especialidad_seleccionada = response.data.especialidad_id;
        //   this.especialidad_nombre = response.data.
          this.medico_seleccionado = response.data.medico_id;
          this.paciente_seleccionado = response.data.paciente_id;
          this.sucursal_seleccionado = response.data.sucursal_id;
          this.fecha_seleccionada = response.data.fecha_programada;
          this.hora_seleccionada = response.data.hora_programada;
          this.fecha_programada = response.data.fecha_programada;
          this.hora_programada = response.data.hora_programada;

        //   this.$refs.especialidadNombre.getNombreEspecialidad(this.especialidad_seleccionada);

          this.$refs.especialidadSeleccionada.cargarMedicos(this.especialidad_seleccionada);
          this.fechaSelect(this.fecha_seleccionada);
          // this.especialidades = response.data;
        //   console.log('La fecha edit '+this.fecha_seleccionada)
        })
        .catch((error) => {
          console.log(error);
        });
    },
    especialidadSelect(especialidadId) {
      this.especialidad_seleccionada = especialidadId;

      this.$refs.especialidadSeleccionada.cargarMedicos(especialidadId);
      this.fecha_seleccionada = null
      this.$refs.fechaSeleccionada.setFecha(this.fecha_seleccionada);
      this.medico_seleccionado = '';
      this.horas = [];
    },
    medicoSelect(medicoId) {
    //   console.log("Medico iddddd: " + medicoId);
      this.medico_seleccionado = medicoId;
      this.horas = [];
      this.cargarHoras();
    },
    fechaSelect(fecha) {
    //   console.log("Fecha seleccionada: " + fecha);
      this.fecha_seleccionada = fecha;
      this.horas = [];
      this.cargarHoras();
    },
    horaSelect(e) {
    //   console.log("hora select: " + e.target.value);
        this.hora_seleccionada = e.target.value;
        if (this.hora_seleccionada < '12:00') {
            this.sucursal_seleccionado = this.tm_sucursal.id;
            console.log("sucursal mañana: "+this.sucursal_seleccionado);
        }else{
            this.sucursal_seleccionado = this.tt_sucursal.id;
            console.log("sucursal tarde: "+this.sucursal_seleccionado);
        }
    },
    cargarHoras() {
      console.log(
        "la fecha sellecionada es: " +
          this.fecha_seleccionada +
          " Medico: " +
          this.medico_seleccionado
      );
      let urlHorasMedico = "/horasmedico";
      const params = {
        fecha: this.fecha_seleccionada,
        id: this.medico_seleccionado,
        especialidad: this.especialidad_seleccionada,
      };
      // this.$emit('fechaSeleccionada', this.fecha);
      axios
        .get(urlHorasMedico, { params })
        .then((response) => {
            console.log(response);
          if (
            (!response.data.tm_horario && !response.data.tt_horario) ||
            (response.data.tm_horario.length === 0 &&
              response.data.tt_horario.length === 0)
          ) {
            this.mostrarAlerta();
            this.tm_sucursal = '';
            this.tt_sucursal = '';
          }
          if (response.data.tm_horario && response.data.tm_sucursal !='') {
            response.data.tm_horario.forEach((hora) => {
              this.horas.push(hora.inicio);
            });
            this.tm_sucursal = response.data.tm_sucursal;
            this.tt_sucursal = '';
          }
          if (response.data.tt_horario && response.data.tt_sucursal !='') {
            response.data.tt_horario.forEach((hora) => {
              this.horas.push(hora.inicio);
            });
            this.tt_sucursal = response.data.tt_sucursal;
            this.tm_sucursal = '';
          }
          if (response.data.tm_sucursal !='' && response.data.tt_sucursal !='' ) {
              this.tt_sucursal = response.data.tt_sucursal;
              this.tm_sucursal = response.data.tm_sucursal;
          }
          // this.especialidades = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    mostrarAlerta() {
      this.$swal({
        icon: "warning",
        title: "Oops...",
        html: noHorasAlert,
      });
    },
    editarCita() {
        console.log("hora seleccionada: " + this.hora_seleccionada);
      const params = {
        fecha_programada: this.fecha_seleccionada,
        hora_programada: this.hora_seleccionada,
        paciente: this.paciente_seleccionado,
        medico: this.medico_seleccionado,
        especialidad: this.especialidad_seleccionada,
        sucursal: this.sucursal_seleccionado,
      };
      const urlEdit = `/citas/${this.citaId}`
      if (this.datosCorrectos()) {
        axios
          .post(urlEdit, {params, _method: 'put'})
          .then((response) => {
            console.log(response.data);
            if (!response.data.error) {
              this.$swal({
                icon: "success",
                title: "Registro de cita",
                text: 'Cita registrada exitosamente!.',
              })
                .then((result) => {
                  window.location.href = "/citas";
                })
            } else {
              console.log("Corrige primero");
              this.$swal({
                icon: "error",
                title: "Oops...",
                text: response.data.error,
              }).then(res => {
                  this.horas =[];
                  this.cargarHoras();
              });
            }
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
    datosCorrectos() {
      if (
        !this.fecha_seleccionada ||
        !this.hora_seleccionada ||
        this.especialidad_seleccionada === 0 ||
        this.medico_seleccionado === ''
      ) {
        console.log("datos incompletos");
        return false;
      } else {
        return true;
      }
    },
  },
  created: function () {
    this.getCita();
  },
};
</script>

<style>
</style>
