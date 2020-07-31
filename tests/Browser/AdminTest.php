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
    public function test_admin_middleware()
    {
        // $user = factory(User::class)->create([
        //     'email' => 'admin@admin.com',
        //     'roles' => 'admin',
        // ]);

        $this->seed();
        // Usuario logeado como admin
        $this->browse(function ($first) {
            $first->loginAs(User::find(1))
                ->visit('/usuarios')
                ->assertSee('Lista de usuarios')
                ->screenshot('AdminTest_admin_middleware_1');
        });

        // Usuario logeado no admin
        $this->browse(function ($first) {
            $first->loginAs(User::find(2))
                ->visit('/usuarios')
                ->assertSee('Laravel')
                ->screenshot('AdminTest_admin_middleware_2');
        });
    }
}
