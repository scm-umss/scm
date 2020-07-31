<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EspecialidadTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     *
     */
    public function test_registrar_especialidad()
    {
        $this->seed();

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/especialidad')
                ->assertSee('Especialidades')
                ->screenshot('especialidades-index')
                ->click('@nueva-especialidad')
                ->assertPathIs('/especialidad/create')
                ->screenshot('especialidad-create')
                ->type('nombre', 'Especialidad test')
                ->type('descripcion', 'descripcion test')
                ->press('Guardar')
                ->assertPathIs('/especialidad')
                ->screenshot('especialidad-registrado')
                ;
        });

        $this->assertDatabaseHas('especialidads',['nombre'=>'Especialidad test']);
    }
    public function test_actualizar_especialidad()
    {
        $this->seed();

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/especialidad')
                ->assertSee('Especialidades')
                ->click('@editar-especialidad-1')
                ->assertPathIs('/especialidad/1/edit')
                ->screenshot('01 especialidad-edit')
                ->type('descripcion', 'Descripcion actualizada')
                ->press('Actualizar')
                ->assertPathIs('/especialidad')
                ->screenshot('02 especialidad-ractualizado')
                ;
        });

        $this->assertDatabaseHas('especialidads',['descripcion'=>'Descripcion actualizada']);
    }
}
