<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Assert;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class HorariosTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_acceder_como_admin()
    {
        $this->seed();

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/horarios/1')
                ->assertSee('Horario de trabajo')
                ->screenshot('HorariosTest_test_acceder_como_admin_1')
                ->visit('/horarios/2')
                ->assertSee('Horario de trabajo')
                ->screenshot('HorariosTest_test_acceder_como_admin_2')
                ;
        });
    }

    public function test_acceder_como_medico()
    {
        $this->seed();

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(2))
                ->visit('/horarios/1')
                ->assertSee('Página no autorizada')
                ->screenshot('HorariosTest_test_acceder_como_admin_1')
                ->visit('/horarios/2')
                ->assertSee('Horario de trabajo')
                ->screenshot('HorariosTest_test_acceder_como_admin_2')
                ;
        });
    }

    public function test_almacenar_horario_sin_cambiar()
    {
        $this->seed();

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/horarios/1')
                ->assertSee('Horario de trabajo')
                ->press('Guardar Horario')
                ->assertSee('Horario Actualizado exitosamente')
                ->screenshot('HorariosTest_test_acceder_como_medico_1')
                ;
        });
    }

    public function test_almacenar_horario_habilitando_turnos()
    {
        $this->seed();

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/horarios/1')
                ->assertSee('Horario de trabajo')
                ->assertNotChecked('@tm_activo[0]')
                ->assertNotChecked('@tt_activo[0]')
                ->check('@tm_activo[0]')
                ->check('@tt_activo[0]')
                ->assertChecked('@tm_activo[0]')
                ->assertChecked('@tt_activo[0]')
                ->select('@tm_hora_fin[0]', '08:00')
                ->select('@tt_hora_fin[0]', '15:00')
                ->press('Guardar Horario')
                ->assertSee('Horario Actualizado exitosamente')
                ->assertChecked('@tm_activo[0]')
                ->assertChecked('@tt_activo[0]')
                ->screenshot('HorariosTest_test_almacenar_horario_habilitando_turnos_1')
                ;
        });
    }
}
