<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {        
        // $user = factory(User::class)->create([
        //     'email' => 'admin@admin.com',
        //     'roles' => 'admin',
        // ]);

        $this->seed();

        $this->browse(function ($first) {
            $first->loginAs(User::find(1))
                  ->screenshot('admin_home')
                  ->visit('/usuarios')
                  ->screenshot('admin_usuarios')
                  ->assertSee('Lista de usuarios');
        });

        $this->browse(function ($first) {
            $first->loginAs(User::find(2))
                  ->screenshot('noadmin_home')
                  ->visit('/usuarios')
                  ->screenshot('noadmin_usuarios')
                  ->assertSee('Laravel');
        });
    }
}
