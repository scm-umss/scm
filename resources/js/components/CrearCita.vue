<template>
  <div>
    <fieldset class="border p-4">
      <legend class="text-primary">Agendar cita</legend>
      <!-- <listar-especialidades :mensaje="titulo"></listar-especialidades> -->
      <combo-especialidad
        :especialidades="especialidades"
        @especialidad-select="especialidadSelect"
      ></combo-especialidad>
      <!-- <p>{{ especialidad_seleccionada }}</p> -->
      <combo-medicos
        :especialidadId="especialidad_seleccionada"
        @medico-select="medicoSelect"
        ref="especialidadSeleccionada"
      ></combo-medicos>
      <!-- <combo-medicos :especialidadId="especialidad_seleccionada" ref="especialidadSeleccionada"></combo-medicos> -->
      <!-- <combo-fecha :medicoId="medico_seleccionado" v-model="value" @fecha-select="fechaSelect"></combo-fecha> -->
      <combo-fecha :medicoId="medico_seleccionado" @fecha-select="fechaSelect"></combo-fecha>
      <!-- <p>{{ fecha_seleccionada }}</p> -->
    </fieldset>
    <fieldset class="border p-4" v-if="horas.length">
      <legend class="text-primary">Horas disponibles</legend>
        <div class="container">
        <div class="row row-cols-2">
            <div class="col" v-if="this.tm_sucursal !=''">
                <div class="shadow p-2 mb-4 bg-white rounded text-center border border-primary">Sucursal: {{ tm_sucursal }}</div>
            </div>
            <div class="col" v-if="this.tt_sucursal!=''">
                <div class="shadow p-2 mb-4 bg-white rounded text-center border border-secondary">Sucursal: {{ tt_sucursal }}</div>
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
        @click.prevent="registrarCita"
        v-if="datosCorrectos()"
      >Registrar Cita</button>
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
    // titulo: String,
    especialidades: Array,
    // medicos: []
    pacienteId: "",
  },
  data() {
    return {
      especialidad_seleccionada: "",
      medico_seleccionado: "",
      fecha_seleccionada: "",
      horas: [],
      tm_sucursal: '',
      tt_sucursal: '',
      hora_seleccionada: "",
      //   mostrarHoras: false
    };
  },
  methods: {
    especialidadSelect(especialidadId) {
      this.especialidad_seleccionada = especialidadId;
      this.$refs.especialidadSeleccionada.cargarMedicos(especialidadId);
      this.horas = [];
    },
    medicoSelect(medicoId) {
      console.log("Medico id: " + medicoId);
      this.medico_seleccionado = medicoId;
      this.horas = [];
      this.cargarHoras();
    },
    fechaSelect(fecha) {
      console.log("Fecha seleccionada: " + fecha);
      this.fecha_seleccionada = fecha;
      this.horas = [];
      this.cargarHoras();
    },
    horaSelect(e) {
      console.log("hora select: " + e.target.value);
      this.hora_seleccionada = e.target.value;
    },
    cargarHoras() {
      // this.value = [date, new Date(date.getTime() + 30 * 24 * 3600 * 1000)]
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
      };
      // this.$emit('fechaSeleccionada', this.fecha);
      axios
        .get(urlHorasMedico, { params })
        .then((response) => {
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
            this.tm_sucursal = response.data.tm_sucursal.nombre;
            this.tt_sucursal = '';
          }
          if (response.data.tt_horario && response.data.tt_sucursal !='') {
            response.data.tt_horario.forEach((hora) => {
              this.horas.push(hora.inicio);
            });
            this.tt_sucursal = response.data.tt_sucursal.nombre;
            this.tm_sucursal = '';
          }
          if (response.data.tm_sucursal !='' && response.data.tt_sucursal !='' ) {
              this.tt_sucursal = response.data.tt_sucursal.nombre;
              this.tm_sucursal = response.data.tm_sucursal.nombre;
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
    registrarCita() {
      const params = {
        fecha_programada: this.fecha_seleccionada,
        hora_programada: this.hora_seleccionada,
        paciente: this.pacienteId,
        medico: this.medico_seleccionado,
        especialidad: this.especialidad_seleccionada,
      };
      if (this.datosCorrectos()) {
        axios
          .post("/citas", params)
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
        this.medico_seleccionado === 0
      ) {
        console.log("datos incompletos");
        return false;
      } else {
        return true;
      }
    },
  },
  created: function () {
    this.fecha_seleccionada = new Date();
    // console.log("Fecha en crear " + this.fecha_seleccionada);
  },
};
</script>

<style>
</style>
