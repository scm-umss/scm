<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MedicoShowTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */


    public function test_medico_perfil()
    {
        $this->seed();

        $this->browse(function ($first) {
            $first->loginAs(User::find(2))
                  ->visit('/usuarios/2')
                  ->assertSee('Estás registrado como: Médico')
                  ->screenshot('MedicoShowTest_test_medico_perfil_1')
                  ->visit('/usuarios/3')
                  ->assertSee('Página no autorizada')
                  ->screenshot('MedicoShowTest_test_medico_perfil_2');
        });
    }
}
