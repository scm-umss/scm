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
                //->assertNotChecked('@tm_activo[0]')
                ->check('@tm_activo[0]')
                ->select('@tm_hora_inicio[0]','07:00')
                ->select('@tm_hora_fin[0]', '11:00')
                //->select('@tm_sucursal[0]', '')
                //->select('@tm_especialidad[0]', '')
                //->assertNotChecked('@tt_activo[0]')
                ->check('@tt_activo[0]')
                ->select('@tt_hora_inicio[0]','15:00')
                ->select('@tt_hora_fin[0]', '18:00')
                //->select('@tt_sucursal[0]', '')
                //->select('@tt_especialidad[0]', '')
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
                ->check('@tm_activo[0]')
                ->select('@tm_hora_inicio[0]','08:00')
                ->select('@tm_hora_fin[0]', '10:00')
                //->select('#tm_sucursal', '')
                //->select('#tm_especialidad', '')
                ->check('@tt_activo[0]')
                ->select('@tt_hora_inicio[0]','14:00')
                ->select('@tt_hora_fin[0]', '17:00')
                //->select('#tt_sucursal', '')
                //->select('#tt_especialidad', '')
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
                ->check('@tm_activo[0]')
                ->select('@tm_hora_inicio[0]','10:00')
                ->select('@tm_hora_fin[0]', '08:00')
                //->select('#tm_sucursal')
                //->select('#tm_especialidad')
                ->check('@tt_activo[0]')
                ->select('@tt_hora_inicio[0]','17:00')
                ->select('@tt_hora_fin[0]', '17:00')
                //->select('#tt_sucursal')
                //->select('#tt_especialidad')
                ->press('Guardar Horario')
                ->assertSee('Horario inconsistente')
                ->screenshot('test_crear_horario_inconsistente_como_admin_4');
        });
        // Verifica que en el DB no se registro el cambio
        $this->assertDatabaseMissing('horarios', ['dia' => '0']);
    }
}
