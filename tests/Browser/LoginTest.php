<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_login_usuario()
    {
        $this->seed();

        // $user = factory(User::class)->create([
        //      'email' => 'admin@admin.com',
        // ]);

        //$user = User::find(1);
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'admin@admin.com')
                    ->type('password', '12345678')
                    ->screenshot('LoginTest_test_login_usuario_1')
                    ->press('Acceder')
                    ->assertPathIs('/home')
                    ->screenshot('LoginTest_test_login_usuario_2');
        });
    }
}
