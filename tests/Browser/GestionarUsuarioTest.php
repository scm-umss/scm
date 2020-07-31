<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GestionarUsuarioTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_crear_editar_usuario()
    {
        $this->seed();

        // Crear usuario
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/usuarios')
                ->screenshot('GestionarUsuario_test_crear_editar_usuario_1')
                ->click('@crear-usuario')
                ->screenshot('GestionarUsuario_test_crear_editar_usuario_2')
                ->type('nombre', 'NombreTest')
                ->type('ap_paterno', 'Ap Test')
                ->type('ci', '12345678')
                ->type('telefono', '12345678')
                ->click('#admin')
                ->type('email', 'test@test.com')
                ->type('password', '12345678')
                ->type('password_confirmation', '12345678')
                ->press('Registrar Usuario')
                ->assertPathIs('/usuarios')
                ->screenshot('GestionarUsuario_test_crear_editar_usuario_3');

        });
        $this->assertDatabaseHas('users',['email'=>'test@test.com']);

        // Editar datos de usuario
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/usuarios')
                ->screenshot('GestionarUsuario_test_crear_editar_usuario_4')
                ->click('@editar-usuario-4')
                ->screenshot('GestionarUsuario_test_crear_editar_usuario_5')
                ->type('nombre', 'NombreTest')
                ->type('ap_paterno', 'Ap Test')
                ->type('ci', '12345678')
                ->type('telefono', '12345678')
                ->click('#admin')
                ->type('email', 'test1@test.com')
                ->press('Actualizar')
                ->assertPathIs('/usuarios')
                ->screenshot('GestionarUsuario_test_crear_editar_usuario_6');

        });
        $this->assertDatabaseHas('users',['email'=>'test1@test.com']);
    }

    public function test_dar_de_baja_restaurar_usuario()
    {
        $this->seed();

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/usuarios')
                ->screenshot('GestionarUsuario_test_dar_de_baja_restaurar_usuario_1')
                ->click('@eliminar-usuario-3')
                ->assertPathIs('/usuarios')
                ->screenshot('GestionarUsuario_test_dar_de_baja_restaurar_usuario_2');

        });

        $this->assertSoftDeleted('users', [
            'id' => 3,
            'email' => 'paciente@scm.com'
        ]);

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/usuarios/inactivos')
                ->screenshot('GestionarUsuario_test_dar_de_baja_restaurar_usuario_3')
                ->click('@restaurar-usuario-3')
                ->assertPathIs('/usuarios/inactivos')
                ->screenshot('GestionarUsuario_test_dar_de_baja_restaurar_usuario_4');

        });

        $this->assertDatabaseHas('users',[
            'id' => 3,
            'deleted_at' => null
        ]);
    }
}
