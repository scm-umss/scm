<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CitasTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_acceso_citas_como_admin()
    {
        $this->seed();

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/citas/pendientes')
                ->assertSee('Citas Pendientes')
                ->assertSee('Ver')
                ->assertSee('Editar')
                ->assertSee('Confirmar')
                ->assertSourceHas('<input type="submit" value="Cancelar" class="btn btn-sm btn-danger">')
                ->screenshot('CitasTest_acceso_citas_como_admin_1')
                ->visit('/citas/confirmadas')
                ->assertSee('Citas Confirmadas')
                ->assertSee('Ver cita')
                ->assertSourceHas('<input type="submit" value="Cancelar" class="btn btn-sm btn-danger">')
                ->screenshot('CitasTest_acceso_citas_como_admin_2')
                ->visit('/citas/historial')
                ->assertSee('Historial de citas')
                ->assertSee('Ver')
                ->screenshot('CitasTest_acceso_citas_como_admin_3')
                ;
        });
    }

    public function test_acceso_citas_como_medico()
    {
        $this->seed();

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(2))
                ->visit('/citas/pendientes')
                ->assertSee('Citas Pendientes')
                ->assertDontSee('Ver')
                ->assertDontSee('Editar')
                ->assertSee('Confirmar')
                ->assertSourceHas('<input type="submit" value="Cancelar" class="btn btn-sm btn-danger">')
                ->screenshot('CitasTest_acceso_citas_como_medico_1')
                ->visit('/citas/confirmadas')
                ->assertSee('Citas Confirmadas')
                ->assertDontSee('Ver cita')
                ->assertSourceHas('<input type="submit" value="Cancelar" class="btn btn-sm btn-danger">')
                ->screenshot('CitasTest_acceso_citas_como_medico_2')
                ->visit('/citas/historial')
                ->assertSee('Historial de citas')
                ->assertSee('Ver')
                ->screenshot('CitasTest_acceso_citas_como_medico_3')
                ;
        });
    }

    public function test_acceso_citas_como_paciente()
    {
        $this->seed();

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(3))
                ->visit('/citas/pendientes')
                ->assertSee('Citas Pendientes')
                ->assertDontSee('Ver')
                ->assertDontSee('Editar')
                ->assertDontSee('Confirmar')
                ->assertSourceHas('<input type="submit" value="Cancelar" class="btn btn-sm btn-danger">')
                ->screenshot('CitasTest_acceso_citas_como_paciente_1')
                ->visit('/citas/confirmadas')
                ->assertSee('Citas Confirmadas')
                ->assertDontSee('Ver cita')
                ->assertSourceHas('<input type="submit" value="Cancelar" class="btn btn-sm btn-danger">')
                ->screenshot('CitasTest_acceso_citas_como_paciente_2')
                ->visit('/citas/historial')
                ->assertSee('Historial de citas')
                ->assertSee('Ver')
                ->screenshot('CitasTest_acceso_citas_como_paciente_3')
                ;
        });
    }
}
