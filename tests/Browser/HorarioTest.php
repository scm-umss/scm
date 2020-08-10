<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class HorarioTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */

    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_crear_horario_medico()
    {
        $this->seed();

        // Crear medico
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(2))
                ->visit('/home')
                ->screenshot('horario_test_crear_horario_medico_1')
                ->click('@crear-usuario-2')
                ->screenshot('horario_test_crear_horario_medico_2')
                ->assertPathIs('/horarios/2')
                // ->type('nombre', 'NombreTest')
                // ->type('ap_paterno', 'Ap Test')
                // ->type('ci', '12345678')
                // ->type('telefono', '12345678')
                // ->click('#admin')
                // ->type('email', 'test@test.com')
                // ->type('password', '12345678')
                // ->type('password_confirmation', '12345678')
                // ->press('Registrar Usuario')
                // ->assertPathIs('/usuarios')
                ->screenshot('horario_test_crear_horario_medico_3');
        });
        // $this->assertDatabaseHas('users', ['email' => 'test@test.com']);

        // Editar datos de usuario
        // $this->browse(function (Browser $browser) {
        //     $browser->loginAs(User::find(1))
        //         ->visit('/usuarios')
        //         ->screenshot('GestionarUsuario_test_crear_editar_usuario_4')
        //         ->click('@editar-usuario-4')
        //         ->screenshot('GestionarUsuario_test_crear_editar_usuario_5')
        //         ->type('nombre', 'NombreTest')
        //         ->type('ap_paterno', 'Ap Test')
        //         ->type('ci', '12345678')
        //         ->type('telefono', '12345678')
        //         ->click('#admin')
        //         ->type('email', 'test1@test.com')
        //         ->press('Actualizar')
        //         ->assertPathIs('/usuarios')
        //         ->screenshot('GestionarUsuario_test_crear_editar_usuario_6');
        // });
        // $this->assertDatabaseHas('users', ['email' => 'test1@test.com']);
    }
}
