<?php

use App\Rol;
use App\Cita;
use App\CitaHistorial;
use App\User;
use App\Sucursal;
use Carbon\Carbon;
use App\Especialidad;
use App\Horario;
use Faker\Generator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        // User::truncate();
        // Rol::truncate();

        $sucursal1 = Sucursal::create([
            'nombre' => 'Sucursal 1',
            'descripcion' => '',
            'direccion' => 'Ayacucho esquina Heroinas S/N',
            'telefonos' => '4444444',
        ]);

        $sucursal2 = Sucursal::create([
            'nombre' => 'Sucursal 2',
            'descripcion' => '',
            'direccion' => 'America esquina Beijing S/N',
            'telefonos' => '4441234',
        ]);

        $traumatologia = Especialidad::create([
            'nombre' => 'Traumatologia',
            'descripcion' => 'Descripcion 1',
        ]);

        $psicologia = Especialidad::create([
            'nombre' => 'Psicologia',
            'descripcion' => 'Descripcion 2',
        ]);

        $cardiologia = Especialidad::create([
            'nombre' => 'Cardiologia',
            'descripcion' => 'Descripcion 3',
        ]);

        $odontologia = Especialidad::create([
            'nombre' => 'Odontologia',
            'descripcion' => 'Descripcion 4',
        ]);

        $rolAdmin = Rol::create([
            'nombre' => 'Administrador',
            'slug' => 'admin',
            'descripcion' => 'Este administrador tiene todo los accesos al sistema.',
        ]);
        $rolMedico = Rol::create([
            'nombre' => 'Médico',
            'slug' => 'medico',
            'descripcion' => 'El usuario médico solo tiene acceso a sus citas y perfil.'
        ]);
        $rolPaciente = Rol::create([
            'nombre' => 'Paciente',
            'slug' => 'paciente',
            'descripcion' => 'El usuario paciente solo puede ver sus citas y perfil.'
        ]);

        $admin = User::create([
            'nombre' => 'Administrador',
            'ap_paterno' => 'Paterno',
            'ap_materno' => 'Materno',
            'ci' => '12354678',
            'fecha_nacimiento' => '2000-01-01',
            'telefono' => '12354678',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
        ]);

        $medico = User::create([
            'nombre' => 'Medico',
            'ap_paterno' => 'Paterno',
            'ap_materno' => 'Materno',
            'ci' => '12354698',
            'fecha_nacimiento' => '2002-01-01',
            'telefono' => '12354678',
            'email' => 'medico@scm.com',
            'password' => Hash::make('12345678'),
        ]);

        $paciente = User::create([
            'nombre' => 'Paciente',
            'ap_paterno' => 'Paterno',
            'ap_materno' => 'Materno',
            'ci' => '12354678',
            'fecha_nacimiento' => '1990-01-01',
            'telefono' => '12354678',
            'email' => 'paciente@scm.com',
            'password' => Hash::make('12345678'),
        ]);

        $admin->roles()->sync([$rolAdmin->id, $rolMedico->id]);
        $medico->roles()->sync([$rolMedico->id]);
        $paciente->roles()->sync([$rolPaciente->id]);

        $admin->especialidades()->sync([$traumatologia->id, $psicologia->id]);
        $medico->especialidades()->sync([$traumatologia->id, $psicologia->id]);

        $medicos_ex = factory(App\User::class, 20)->create();
        $medicos_ex->each(function ($user) use ($rolMedico, $traumatologia, $psicologia, $cardiologia, $odontologia) {
            $user->roles()->sync([$rolMedico->id]);
            $p = mt_rand(1,100);
            if ($p < 25) {
                $user->especialidades()->sync([$traumatologia->id]);
            } else if ($p < 50) {
                $user->especialidades()->sync([$cardiologia->id]);
            } else if ($p < 75) {
                $user->especialidades()->sync([$odontologia->id]);
            } else {
                $user->especialidades()->sync([$psicologia->id]);
            }
        });

        $pacientes_ex = factory(App\User::class, 100)->create();
        $pacientes_ex->each(function ($user) use ($rolPaciente) {
            $user->roles()->sync([$rolPaciente->id]);
        });

        // Horario por default
        for ($i = 0; $i < 7; $i++) {
            $tm_activo = ($i < 6);  // Lun-Vie
            $tt_activo = ($i < 5);

            $horario = Horario::create([
                'dia' => $i,
                'tm_activo' => $tm_activo,
                'tm_hora_inicio' => ($tm_activo ? '08:00:00' : '07:00:00'),
                'tm_hora_fin' => ($tm_activo ? '10:30:00' : '12:00:00'),
                'tm_sucursal' => $sucursal1->id,
                'tm_especialidad' => $traumatologia->id,
                'tm_consultorio' => '101',
                'tt_activo' => $tt_activo,
                'tt_hora_inicio' => ($tt_activo ? '15:00:00' : '14:00:00'),
                'tt_hora_fin' => ($tt_activo ? '17:00:00' : '18:00:00'),
                'tt_sucursal' => $sucursal2->id,
                'tt_especialidad' => $psicologia->id,
                'tt_consultorio' => '201',
                'user_id' => $medico->id,
            ]);
        }

        $medicos_ex->each(function ($medico_ex) use ($sucursal1, $sucursal2, $traumatologia, $psicologia, $cardiologia, $odontologia) {
            for ($i = 0; $i < 7; $i++) {
                $tm_activo = ($i < 6);  // Lun-Vie
                $tt_activo = ($i < 5);

                $horario = Horario::create([
                    'dia' => $i,
                    'tm_activo' => $tm_activo,
                    'tm_hora_inicio' => ($tm_activo ? '08:00:00' : '07:00:00'),
                    'tm_hora_fin' => ($tm_activo ? '11:00:00' : '12:00:00'),
                    'tm_sucursal' => $sucursal1->id,
                    'tm_especialidad' => $medico_ex->especialidades()->first()->id,
                    'tm_consultorio' => '101',
                    'tt_activo' => $tt_activo,
                    'tt_hora_inicio' => ($tt_activo ? '15:00:00' : '14:00:00'),
                    'tt_hora_fin' => ($tt_activo ? '17:00:00' : '18:00:00'),
                    'tt_sucursal' => $sucursal2->id,
                    'tt_especialidad' => $medico_ex->especialidades()->first()->id,
                    'tt_consultorio' => '201',
                    'user_id' => $medico_ex->id,
                ]);
            }
        });

        $cita = Cita::create([
            'estado' => 'Reservada',
            'paciente_id' => $paciente->id,
            'medico_id' => $medico->id,
            'especialidad_id' => $traumatologia->id,
            'sucursal_id' => $sucursal1->id,
            'fecha_programada' => Carbon::now()->addDay(1)->format('Y-m-d'),
            'hora_programada' => '09:00:00',
        ]);

        // Crear 6 citas por dia para pacientes y medicos aleatorios
        // todos con la misma sucursal para una semana
        // antes y una semana despues
        $fecha_hoy = Carbon::now();
        $fecha_cita = Carbon::now()->subDays(7);
        $citas_ex = collect();

        for ($i = 0; $i < 14; $i++) {
            $c = factory(App\Cita::class, 6)->create([
                'paciente_id' => $paciente->id,
                'medico_id' => $medico->id,
                'especialidad_id' => $traumatologia->id,
                'sucursal_id' => $sucursal1->id,
                'fecha_programada' => $fecha_cita->format('Y-m-d'),
                'estado' => 'Reservada',
            ]);

            $c->each(function($cita_ex) use ($pacientes_ex, $medicos_ex, $admin, $faker, $fecha_cita, $fecha_hoy) {
                $med = $medicos_ex->random();
                
                $cita_ex->paciente_id = $pacientes_ex->random()->id;
                $cita_ex->medico_id = $med->id;
                $cita_ex->especialidad_id = $med->especialidades()->first()->id;
                //$cita_ex->sucursal_id = $sucursal1->id;
                if ($fecha_cita < $fecha_hoy) {
                    $p = mt_rand(1,100);
                    if ($p < 25) {
                        $cita_ex->estado = 'Cancelada';
                    } else {
                        $cita_ex->estado = 'Atendida';
                    }
                } else {
                    $p = mt_rand(1,100);
                    if ($p < 25) {
                        $cita_ex->estado = 'Cancelada';
                    } else if ($p < 75) {
                        $cita_ex->estado = 'Confirmada';
                    }
                }
                $cita_ex->hora_programada = $faker->unique()->randomElement(['08:00:00','08:30:00','09:00:00','09:30:00','10:00:00','10:30:00']);
                $cita_ex->save();

                $historialCreado = CitaHistorial::create([
                    'cita_id' => $cita_ex->id,
                    'user_id' => $admin->id,
                    'evento' => 'Creado',
                ]);

                if ($cita_ex->estado == 'Cancelada') {
                    $historialCancelado = CitaHistorial::create([
                        'cita_id' => $cita_ex->id,
                        'user_id' => $admin->id,
                        'evento' => 'Cancelado',
                        'descripcion' => $faker->realText($maxNbChars = 100),
                    ]);
                }
            });

            $citas_ex = $citas_ex->concat($c);

            $faker->unique($reset = true);
            $fecha_cita->addDay(1);
        }
    }
}
