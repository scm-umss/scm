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
    public function testExample()
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
                    ->screenshot('login_admin')
                    ->press('Acceder')
                    ->assertPathIs('/home')
                    ->screenshot('login_success');
        });
    }
}
