<?php

use App\Especialidad;
use App\Rol;
use App\User;
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
        $admin = User::create([
            'nombre' => 'Jhonny',
            'ap_paterno' => 'Huanca',
            'ap_materno' => 'Tadeo',
            'ci' => '12354678',
            'telefono' => '12354678',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            'estado' => 'a',
        //    'imagen'=>$faker->imageUrl(400, 400, 'cats'),
        ]);

        $medico = User::create([
            'nombre' => 'Medico',
            'ap_paterno' => 'Huanca',
            'ap_materno' => 'Tadeo',
            'ci' => '12354698',
            'telefono' => '12354678',
            'email' => 'medico@scm.com',
            'password' => Hash::make('12345678'),
            'estado' => 'a',
            // 'imagen'=>$faker->imageUrl(400, 400, 'cats'),
        ]);
        $paciente = User::create([
            'nombre' => 'Paciente',
            'ap_paterno' => 'Huanca',
            'ap_materno' => 'Tadeo',
            'ci' => '12354678',
            'telefono' => '12354678',
            'email' => 'paciente@scm.com',
            'password' => Hash::make('12345678'),
            'estado' => 'a',
            // 'imagen'=>$faker->imageUrl(400, 400, 'cats'),
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

        $admin->roles()->sync([$rolAdmin->id]);
        $medico->roles()->sync([$rolMedico->id]);
        $paciente->roles()->sync([$rolPaciente->id]);

        $traumatologia = Especialidad::create([
            'nombre' => 'Traumatologia',
            'descripcion' => 'Descripcion 1',
        ]);

        $psicologia = Especialidad::create([
            'nombre' => 'Psicologia',
            'descripcion' => 'Descripcion 2',
        ]);

        $medico->especialidades()->sync([$traumatologia->id, $psicologia->id]);
    }
}
