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

        $admin->roles()->sync([$rolAdmin->id, $rolMedico->id]);
        $medico->roles()->sync([$rolMedico->id]);
        $paciente->roles()->sync([$rolPaciente->id]);

        factory(App\User::class, 20)->create()->each(function ($user) use ($rolPaciente) {
            $user->roles()->sync([$rolPaciente->id]);
        });

        $traumatologia = Especialidad::create([
            'nombre' => 'Traumatologia',
            'descripcion' => 'Descripcion 1',
        ]);

        $psicologia = Especialidad::create([
            'nombre' => 'Psicologia',
            'descripcion' => 'Descripcion 2',
        ]);

        $admin->especialidades()->sync([$traumatologia->id, $psicologia->id]);
        $medico->especialidades()->sync([$traumatologia->id, $psicologia->id]);

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

        // for ($i=0; $i<=6; $i+1) {
        //     $horario = Horario::create([
        //         'dia' => $i,
        //         'tm_activo' => true,
        //         'tm_hora_inicio' => date('H:i:s', 28800),
        //         'tm_hora_fin' => date('H:i:s', 43200),
        //         'tm_sucursal' => $sucursal1->id,
        //         'tm_especialidad' => $traumatologia->id,
        //         'tm_consultorio' => '101',
        //         'tt_activo' => true,
        //         'tt_hora_inicio' => date('H:i:s', 50400),
        //         'tt_hora_fin' => date('H:i:s', 64800),
        //         'tt_sucursal' => $sucursal2->id,
        //         'tt_especialidad' => $psicologia->id,
        //         'tt_consultorio' => '201',
        //         'user_id' => $medico->id,
        //     ]);
        // }

        $cita = Cita::create([
            'estado' => 'Reservada',
            'numero_ficha' => 1,
            'paciente_id' => $paciente->id,
            'medico_id' => $medico->id,
            'especialidad_id' => $traumatologia->id,
            'sucursal_id' => $sucursal1->id,
            'fecha_programada' => Carbon::now()->format('Y-m-d'),
            'hora_programada' => '09:00:00',
        ]);
    }
}
