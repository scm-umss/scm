<template>
  <div>
    <combo-fecha
      :medicoId="medicoId"
      @fecha-select="fechaSelect"
      ref="fechaSeleccionada"
    ></combo-fecha>
    <fieldset class="border p-4" v-if="horas.length">
      <legend class="text-primary">Horas disponibles</legend>
      <div class="container">
        <div class="row row-cols-2">
          <div class="col" v-if="this.tm_sucursal">
            <div
              class="shadow p-2 mb-4 bg-white rounded text-center border border-primary"
            >
              Sucursal Mañana: {{ tm_sucursal.nombre }}
            </div>
          </div>
          <div class="col" v-if="this.tt_sucursal">
            <div
              class="shadow p-2 mb-4 bg-white rounded text-center border border-secondary"
            >
              Sucursal Tarde: {{ tt_sucursal.nombre }}
            </div>
          </div>
        </div>
      </div>
      <hr />
      <div class="container">
        <div class="row row-cols-4">
          <div v-for="(hora, index) in horas" :key="index">
            <div class="col mb-4" v-if="hora < '12:00'">
              <div class="card shadow text-white bg-primary mb-3">
                <div class="card-header">
                  <div class="form-check">
                    <input
                      class="form-check-input"
                      type="radio"
                      name="hora_inicio"
                      :id="'hora_inicio_' + index"
                      :value="hora"
                      @click="horaSelect"
                    />
                    <label
                      class="form-check-label"
                      :for="'hora_inicio_' + index"
                      >{{ hora }}</label
                    >
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
                      :id="'hora_inicio' + index"
                      :value="hora"
                      @click="horaSelect"
                    />
                    <label
                      class="form-check-label"
                      :for="'hora_inicio' + index"
                      >{{ hora }}</label
                    >
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
import ComboFecha from "./ComboFecha.vue";
const noHorasAlert = `<div class="alert alert-danger" role="alert">
                    <strong>Lo sentimos!</strong> No se encontraron horas disponibles para el médico y el día seleccionado.
                </div>`;
export default {
  components: {
    ComboFecha,
  },
  props: ["medicoId", "especialidadId", "pacienteId"],
  data() {
    return {
      fecha_seleccionada: "",
      horas: [],
      tm_sucursal: "",
      tt_sucursal: "",
      hora_seleccionada: "",
      sucursal_seleccionado: "",
    };
  },
  methods: {
    fechaSelect(fecha) {
      console.log("Fecha seleccionada: " + fecha);
      this.fecha_seleccionada = fecha;
      this.horas = [];
      this.cargarHoras();
    },
    cargarHoras() {
      // this.value = [date, new Date(date.getTime() + 30 * 24 * 3600 * 1000)]
      console.log(
        "la fecha sellecionada es: " +
          this.fecha_seleccionada +
          " Medico: " +
          this.medicoId +
          " especialidad: " +
          this.especialidadId
      );
      let urlHorasMedico = "/horasmedico";
      const params = {
        fecha: this.fecha_seleccionada,
        id: this.medicoId,
        especialidad: this.especialidadId,
      };
      axios
        .get(urlHorasMedico, { params })
        .then((response) => {
          // console.log(response.data);
          if (
            (!response.data.tm_horario && !response.data.tt_horario) ||
            (response.data.tm_horario.length === 0 &&
              response.data.tt_horario.length === 0)
          ) {
            this.mostrarAlerta();
            this.tm_sucursal = "";
            this.tt_sucursal = "";
          }
          if (response.data.tm_horario && response.data.tm_sucursal != "") {
            response.data.tm_horario.forEach((hora) => {
              this.horas.push(hora.inicio);
            });
            this.tm_sucursal = response.data.tm_sucursal;
            this.tt_sucursal = "";
          }
          if (response.data.tt_horario && response.data.tt_sucursal != "") {
            response.data.tt_horario.forEach((hora) => {
              this.horas.push(hora.inicio);
            });
            this.tt_sucursal = response.data.tt_sucursal;
            this.tm_sucursal = "";
          }
          if (
            response.data.tm_sucursal != "" &&
            response.data.tt_sucursal != ""
          ) {
            this.tt_sucursal = response.data.tt_sucursal;
            this.tm_sucursal = response.data.tm_sucursal;
          }
          // this.especialidades = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    horaSelect(e) {
        this.hora_seleccionada = e.target.value;
        if (this.hora_seleccionada < '12:00') {
            this.sucursal_seleccionado = this.tm_sucursal.id;
            console.log("sucursal mañana: "+this.sucursal_seleccionado);
        }else{
            this.sucursal_seleccionado = this.tt_sucursal.id;
            console.log("sucursal tarde: "+this.sucursal_seleccionado);
        }
    },
    registrarCita() {
      const params = {
        fecha_programada: this.fecha_seleccionada,
        hora_programada: this.hora_seleccionada,
        paciente: this.pacienteId,
        medico: this.medicoId,
        especialidad: this.especialidadId,
        sucursal:this.sucursal_seleccionado,
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
        this.especialidadId === 0 ||
        this.medicoId === 0
      ) {
        console.log("datos incompletos");
        return false;
      } else {
        return true;
      }
    },
    mostrarAlerta() {
      this.$swal({
        icon: "warning",
        title: "Oops...",
        html: noHorasAlert,
      });
    },
  },
};
</script>

<style>
</style>
