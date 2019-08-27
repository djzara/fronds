<?php
/**
 * User: zara
 * Date: 2019-04-21
 * Time: 20:29
 */

namespace Tests\Browser\Views\Admin;

use Fronds\Models\User;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Admin\AdminLogin;
use Tests\DuskTestCase;

class AdminLoginPageTest extends DuskTestCase
{

    /**
     * @throws \Throwable
     */
    public function testCanSeeLoginButton(): void
    {
        $this->browse(static function (Browser $browser) {
            $browser->visit(new AdminLogin)
                ->assertVue('btnText', __('controls.button.admin.login'), '@fronds-admin-login-btn')
                ->assertVueIsNot('btnText', __('controls.input.admin.email'), '@fronds-admin-login-btn')
                ->assertSee(__('page.admin.title'));
        });
    }

    /**
     * @throws \Throwable
     */
    public function testCanSeeLoginEmailInput(): void
    {
        $this->browse(static function (Browser $browser) {
            $browser->visit(new AdminLogin)
                ->assertVue('inputLabel', __('controls.input.admin.email'), '@fronds-admin-login-email')
                ->assertVueIsNot('inputLabel', __('controls.button.admin.login'), '@fronds-admin-login-email')
                ->assertSee(__('page.admin.title'));
        });
    }

    /**
     * @throws \Throwable
     */
    public function testCanSeeLoginPassInput(): void
    {
        $this->browse(static function (Browser $browser) {
            $browser->visit(new AdminLogin)
                ->assertVue('inputLabel', __('controls.input.admin.password'), '@fronds-admin-login-pass')
                ->assertVueIsNot('inputLabel', __('controls.button.admin.login'), '@fronds-admin-login-pass')
                ->assertSee(__('page.admin.title'));
        });
    }

    /**
     * @throws \Throwable
     */
    public function testCanSeeLoginForm(): void
    {
        $this->browse(static function (Browser $browser) {
            $browser->visit(new AdminLogin)
                ->assertVue('id', 'fronds-login-form', '@fronds-login-form')
                ->assertSee(__('page.admin.title'));
        });
    }

    /**
     * @throws \Throwable
     */
    public function testUseLoginForm(): void
    {
        $this->browse(static function (Browser $browser) {
            $browser->visit(new AdminLogin())
                ->assertVueIsNot('value', 'duskuser@fronds.com', '@fronds-admin-login-email')
                ->assertVueIsNot('value', 'duskuserpass', '@fronds-admin-login-pass')
                ->type('email', 'duskuser@fronds.com')
                ->type('password', 'duskuserpass')
                ->assertVue('value', 'duskuser@fronds.com', '@fronds-admin-login-email')
                ->assertVue('value', 'duskuserpass', '@fronds-admin-login-pass');
        });
    }

    /**
     * @throws \Throwable
     */
    public function testUseAndSubmitValidLogin(): void
    {
        $user = factory(User::class)->create();
        $this->browse(static function (Browser $browser) use ($user) {
            $browser->visit(new AdminLogin())
                ->type('email', $user->email)
                ->type('password', 'secret')
                ->assertVue('value', $user->email, '@fronds-admin-login-email')
                ->assertVue('value', 'secret', '@fronds-admin-login-pass')
                ->click('@fronds-admin-login-btn-action')
                ->pause(2000)
                ->assertPathIs('/a/manage')
                ->assertMissing('@fronds-action-bar')
                ->logout();
        });
    }

    /**
     * @throws \Throwable
     */
    public function testUserAndSubmitInvalidLoginNoEmail(): void
    {
        $this->browse(static function (Browser $browser) {
            $browser->visit(new AdminLogin())
                ->type('password', 'secret')
                ->assertVue('value', '', '@fronds-admin-login-email')
                ->assertVue('value', 'secret', '@fronds-admin-login-pass')
                ->click('@fronds-admin-login-btn-action')
                ->pause(2000)
                ->assertPathIsNot('/a/manage')
                ->assertPresent('@fronds-action-bar');
        });
    }

    /**
     * @throws \Throwable
     */
    public function testUserAndSubmitInvalidLoginNoPassword(): void
    {
        $user = factory(User::class)->create();
        $this->browse(static function (Browser $browser) use ($user) {
            $browser->visit(new AdminLogin())
                ->type('email', $user->email)
                ->assertVue('value', $user->email, '@fronds-admin-login-email')
                ->assertVue('value', '', '@fronds-admin-login-pass')
                ->click('@fronds-admin-login-btn-action')
                ->pause(2000)
                ->assertPathIsNot('/a/manage')
                ->assertPresent('@fronds-action-bar');
        });
    }

    /**
     * @throws \Throwable
     */
    public function testUserAndSubmitNoCredentials(): void
    {
        $this->browse(static function (Browser $browser) {
            $browser->visit(new AdminLogin())
                ->assertVue('value', '', '@fronds-admin-login-email')
                ->assertVue('value', '', '@fronds-admin-login-pass')
                ->click('@fronds-admin-login-btn-action')
                ->pause(2000)
                ->assertPathIsNot('/a/manage')
                ->assertPresent('@fronds-action-bar');
        });
    }
}
