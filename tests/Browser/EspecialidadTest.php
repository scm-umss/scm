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
                ->screenshot('EspecialidadTest_test_registrar_especialidad_1')
                ->click('@nueva-especialidad')
                ->assertPathIs('/especialidad/create')
                ->screenshot('EspecialidadTest_test_registrar_especialidad_2')
                ->type('nombre', 'Especialidad test')
                ->type('descripcion', 'descripcion test')
                ->press('Guardar')
                ->assertPathIs('/especialidad')
                ->screenshot('EspecialidadTest_test_registrar_especialidad_3')
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
                ->screenshot('EspecialidadTest_test_actualizar_especialidad_1')
                ->type('descripcion', 'Descripcion actualizada')
                ->press('Actualizar')
                ->assertPathIs('/especialidad')
                ->screenshot('EspecialidadTest_test_actualizar_especialidad_2')
                ;
        });

        $this->assertDatabaseHas('especialidads',['descripcion'=>'Descripcion actualizada']);
    }
}
