<?php

use App\Rol;
use App\Cita;
use App\User;
use App\Sucursal;
use Carbon\Carbon;
use App\Especialidad;
use App\Horario;
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
        //$faker = Faker\Factory::create();
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
        $medicos_ex->each(function ($user) use ($rolMedico, $traumatologia, $psicologia) {
            $user->roles()->sync([$rolMedico->id]);
            if (mt_rand(1,100) > 50) {
                $user->especialidades()->sync([$traumatologia->id]);
            } else {
                $user->especialidades()->sync([$psicologia->id]);
            }
        });

        $pacientes_ex = factory(App\User::class, 60)->create();
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

        $medicos_ex->each(function ($medico_ex) use ($sucursal1, $sucursal2, $traumatologia, $psicologia) {
            for ($i = 0; $i < 7; $i++) {
                $tm_activo = ($i < 6);  // Lun-Vie
                $tt_activo = ($i < 5);
    
                $horario = Horario::create([
                    'dia' => $i,
                    'tm_activo' => $tm_activo,
                    'tm_hora_inicio' => ($tm_activo ? '08:00:00' : '07:00:00'),
                    'tm_hora_fin' => ($tm_activo ? '11:00:00' : '12:00:00'),
                    'tm_sucursal' => $sucursal1->id,
                    'tm_especialidad' => $traumatologia->id,
                    'tm_consultorio' => '101',
                    'tt_activo' => $tt_activo,
                    'tt_hora_inicio' => ($tt_activo ? '15:00:00' : '14:00:00'),
                    'tt_hora_fin' => ($tt_activo ? '17:00:00' : '18:00:00'),
                    'tt_sucursal' => $sucursal2->id,
                    'tt_especialidad' => $psicologia->id,
                    'tt_consultorio' => '201',
                    'user_id' => $medico_ex->id,
                ]);
            }
        });

        $cita = Cita::create([
            'estado' => 'Reservada',
            'numero_ficha' => 1,
            'paciente_id' => $paciente->id,
            'medico_id' => $medico->id,
            'especialidad_id' => $traumatologia->id,
            'sucursal_id' => $sucursal1->id,
            'fecha_programada' => Carbon::now()->addDay(1)->format('Y-m-d'),
            'hora_programada' => '09:00:00',
        ]);

        $citas_ex = factory(App\Cita::class, 30)->create([
            'paciente_id' => $paciente->id,
            'medico_id' => $medico->id,
            'especialidad_id' => $traumatologia->id,
            'sucursal_id' => $sucursal1->id,
        ]);

        $citas_ex->each(function($cita_ex) use ($pacientes_ex, $medicos_ex, $traumatologia, $sucursal1) {
            $cita_ex->paciente_id = $pacientes_ex->random()->id;
            $cita_ex->medico_id = $medicos_ex->random()->id;
            //$cita_ex->especialidad_id = $traumatologia->id;
            //$cita_ex->sucursal_id = $sucursal1->id;
        });
    }
}
