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
    public function acceso_citas_como_admin()
    {
        $this->seed();

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/citas')
                ->assertSee('Citas Pendientes')
                ->screenshot('CitasTest_acceso_citas_como_admin_1')
                ;
        });
    }

    public function acceso_citas_como_medico()
    {
        $this->seed();

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(2))
                ->visit('/citas')
                ->assertSee('vista para medico')
                ->screenshot('CitasTest_acceso_citas_como_medico_1')
                ;
        });
    }

    public function acceso_citas_como_paciente()
    {
        $this->seed();

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(3))
                ->visit('/citas')
                ->assertSee('vista para paciente')
                ->screenshot('CitasTest_acceso_citas_como_paciente_1')
                ;
        });
    }
}
