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


    public function testExample()
    {
        $this->seed();

        $this->browse(function ($first) {
            $first->loginAs(User::find(2))
                //   ->screenshot('noadmin_home')
                  ->visit('/usuarios/2')

                  ->assertSee('Estás registrado como: Médico')
                  ->screenshot('show_medico_2')
                  ->visit('/usuarios/3')
                  ->assertSee('403')
                  ->screenshot('show_mdico_paciente');
        });

        // Medico ve
        // $this->browse(function ($first) {
        //     $first->loginAs(User::find(2))
        //         //   ->screenshot('noadmin_home')
        //           ->visit('/usuarios/3')

        //           ->assertSee('Estás registrado como: Médico')
        //           ->screenshot('show_medico_2');
        // });
    }
}
