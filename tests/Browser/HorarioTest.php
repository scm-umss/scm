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
                ->click('@horario-medico-2')
                ->screenshot('horario_test_crear_horario_medico_2')
                ->assertPathIs('/horarios/2')
                ->click('#tm_activo')
                ->select('#tm_hora_inicio','07:00')
                ->select('#tm_hora_fin', '11:00')
                ->select('#tm_sucursal')
                ->select('#tm_especialidad')
                ->click('#tt_activo')
                ->select('#tt_hora_inicio','15:00')
                ->select('#tt_hora_fin', '18:00')
                ->select('#tt_sucursal')
                ->select('#tt_especialidad')
                ->press('Guardar Horario')
                // ->assertPathIs('/usuarios')
                ->screenshot('horario_test_crear_horario_medico_3');
        });
        $this->assertDatabaseHas('horarios', ['dia' => '0', 'tm_activo' => '1']);
    }

    public function test_crear_horario_como_admin()
    {
        $this->seed();

        // Crear medico
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/usuarios')
                ->screenshot('horario_test_crear_horario_como_admin_1')
                ->click('@ver-detalles-2')
                ->screenshot('horario_test_crear_horario_como_admin_2')
                ->assertPathIs('/usuarios/2')
                ->click('@crear-horario-2')
                ->screenshot('horario_test_crear_horario_como_admin_3')
                ->check('#tm_activo')
                ->select('#tm_hora_inicio','08:00')
                ->select('#tm_hora_fin', '10:00')
                ->select('#tm_sucursal')
                ->select('#tm_especialidad')
                ->check('#tt_activo')
                ->select('#tt_hora_inicio','14:00')
                ->select('#tt_hora_fin', '17:00')
                ->select('#tt_sucursal')
                ->select('#tt_especialidad')
                ->press('Guardar Horario')
                // ->assertPathIs('/usuarios')
                ->screenshot('horario_test_crear_horario_como_admin_4');
        });
        $this->assertDatabaseHas('horarios', ['dia' => '0', 'tm_activo' => '1']);
    }
    public function test_crear_horario_inconsistente_como_admin()
    {
        $this->seed();

        // Crear medico
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                ->visit('/usuarios')
                ->screenshot('test_crear_horario_inconsistente_como_admin_1')
                ->click('@ver-detalles-2')
                ->screenshot('test_crear_horario_inconsistente_como_admin_2')
                ->assertPathIs('/usuarios/2')
                ->click('@crear-horario-2')
                ->screenshot('test_crear_horario_inconsistente_como_admin_3')
                ->check('#tm_activo')
                ->select('#tm_hora_inicio','10:00')
                ->select('#tm_hora_fin', '08:00')
                ->select('#tm_sucursal')
                ->select('#tm_especialidad')
                ->check('#tt_activo')
                ->select('#tt_hora_inicio','17:00')
                ->select('#tt_hora_fin', '17:00')
                ->select('#tt_sucursal')
                ->select('#tt_especialidad')
                ->press('Guardar Horario')
                // ->assertPathIs('/usuarios')
                ->screenshot('test_crear_horario_inconsistente_como_admin_4');
        });
        // $this->assertDatabaseHas('horarios', ['dia' => '0', 'tm_activo' => '1']);
    }
}
