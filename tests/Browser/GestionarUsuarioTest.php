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
    public function testExample()
    {
        $this->seed();

        // Crear usuario
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/usuarios')
                ->screenshot('lista_usuarios')
                // ->press('Nuevo Usuario')

                ->click('@crear-usuario')
                ->screenshot('lista_usuarios_1')
                ->type('nombre', 'NombreTest')
                ->type('ap_paterno', 'Ap Test')
                ->type('ci', '12345678')
                ->type('telefono', '12345678')
                ->click('#admin')
                ->select('estado','Activo')
                ->type('email', 'test@test.com')
                ->type('password', '12345678')
                ->type('password_confirmation', '12345678')
                ->press('Registrar Usuario')
                // ->clickLink('Nuevo Usuario')
                // ->click('a[href="/usuarios/create"]')
                ->assertPathIs('/usuarios')
                // ->assertDatabaseHas('users',['email'=>'test@test.com'])
                ->screenshot('usuario_registrado');

        });
        $this->assertDatabaseHas('users',['email'=>'test@test.com']);

        // Editar datos de usuario
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/usuarios')
                ->screenshot('lista_usuarios_edit')
                // ->press('Nuevo Usuario')

                ->click('@editar-usuario-4')
                ->screenshot('editar_usuarios_1')
                ->type('nombre', 'NombreTest')
                ->type('ap_paterno', 'Ap Test')
                ->type('ci', '12345678')
                ->type('telefono', '12345678')
                ->click('#admin')
                ->select('estado','Activo')
                ->type('email', 'test1@test.com')
                // ->type('password', '')
                // ->type('password_confirmation', '')
                ->press('Actualizar')
                // ->clickLink('Nuevo Usuario')
                // ->click('a[href="/usuarios/create"]')
                ->assertPathIs('/usuarios')
                // ->assertDatabaseHas('users',['email'=>'test@test.com'])
                ->screenshot('usuario_actualizado');

        });
        $this->assertDatabaseHas('users',['email'=>'test1@test.com']);
    }
}
